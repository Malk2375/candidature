<?php

namespace App\Controller;

use AllowDynamicProperties;
use App\Entity\Application;
use App\Entity\MotivationLetter;
use App\Form\ApplicationType;
use App\Repository\ApplicationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class ApplicationController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    #[Route('/', name: 'application_list')]
    public function index(ApplicationRepository $applicationRepository): Response
    {
        $applications = $applicationRepository->findBy([], ['applicationDate' => 'DESC']);
        $nbApplicationsOfTheDay = 0;
        $today = new \DateTimeImmutable('today');

        foreach ($applications as $application) {
            if ($application->getApplicationDate()->format('Y-m-d') === $today->format('Y-m-d')) {
                $nbApplicationsOfTheDay++;
            }
        }

        return $this->render('application/list.html.twig', [
            'applications' => $applications,
            'nbApplicationsOfTheDay' => $nbApplicationsOfTheDay
        ]);
    }
    #[Route('/api/application/list', name: 'api_application_list', methods: ['GET'])]
    public function apiIndex(ApplicationRepository $applicationRepository): JsonResponse
    {
        $applications = $applicationRepository->findBy([], ['applicationDate' => 'DESC']);
        $data = [];
        foreach ($applications as $application) {
            $data[] = [
                'id' => $application->getId(),
                'jobTitle' => $application->getJobTitle(),
                'companyName' => $application->getCompanyName(),
                'jobLink' => $application->getJobLink(),
                'applicationDate' => $application->getApplicationDate()->format('d-m-Y'),
                'jobDescription' => $application->getJobDescription(),
                'motivationLetters' => array_map(function ($motivationLetter) {
                    return [
                        'id' => $motivationLetter->getId(),
                        'content' => $motivationLetter->getContent(),
                        'promptMotivationLetter' => $motivationLetter->getPromptMotivationLetter(),
                        'promptCv' => $motivationLetter->getPromptCv(),
                        'chatgptLink' => $motivationLetter->getChatgptLink(),
                    ];
                }, $application->getMotivationLetter()->toArray()),
            ];
        }
        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @throws Exception
     */
    #[Route('/application/edit/{id}', name: 'application_edit')]
    public function editApplication(Request $request, Application $application, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(ApplicationType::class, $application);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('application_list');
        }
        $this->addFlash('success', 'Candidature modifiée avec succès');

        return $this->render('application/form.html.twig', [
            'form' => $form->createView(),
            'editMode' => true,
        ]);
    }
    #[Route('/api/application/edit/{id}', name: 'api_application_edit')]
    public function apiEditApplication(Request $request, Application $application, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (json_last_error() !== JSON_ERROR_NONE || !is_array($data)) {
            return $this->json(['error' => 'Invalid JSON'], Response::HTTP_BAD_REQUEST);
        }

        if (isset($data['jobTitle'])) {
            $application->setJobTitle($data['jobTitle']);
        }
        if (isset($data['companyName'])) {
            $application->setCompanyName($data['companyName']);
        }
        if (isset($data['jobLink'])) {
            $application->setJobLink($data['jobLink']);
        }
        if (isset($data['applicationDate'])) {
            try {
                $application->setApplicationDate(new \DateTimeImmutable($data['applicationDate']));
            } catch (Exception $e) {
                return $this->json(['error' => 'Invalid date format'], Response::HTTP_BAD_REQUEST);
            }
        }
        if (isset($data['jobDescription'])) {
            $application->setJobDescription($data['jobDescription']);
        }

        $em->flush();

        return $this->json([
            'message' => 'Candidature mise à jour avec succès',
            'applicationId' => $application->getId(),
        ], Response::HTTP_OK);
    }

    #[Route('/api/application/new', name: 'api_application_new', methods: ['POST'])]
    public function apiNewApplication(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Vérification de la validité des données JSON
        if (json_last_error() !== JSON_ERROR_NONE || !is_array($data)) {
            return $this->json(['error' => 'Invalid JSON'], Response::HTTP_BAD_REQUEST);
        }

        $application = new Application();
        $motivationLetter = new MotivationLetter();

        // Assigner la date actuelle si la date de candidature est null
        if ($application->getApplicationDate() === null) {
            $application->setApplicationDate(new \DateTimeImmutable());
        }

        // Génération des prompts (lettre de motivation et CV)
        $promptMotivationLetter = str_replace(
            ['{{JOB_TITLE}}', '{{COMPANY_NAME}}', '{{JOB_DESCRIPTION}}'],
            [$application->getJobTitle(), $application->getCompanyName(), $application->getJobDescription()],
            MotivationLetter::PROMPT_MOTIVATION_LETTER_TEMPLATE
        );
        $promptCv = str_replace(
            ['{{JOB_TITLE}}', '{{JOB_DESCRIPTION}}'],
            [$application->getJobTitle(), $application->getJobDescription()],
            MotivationLetter::PROMPT_CV_CREATION
        );
        $motivationLetter->setPromptCv($promptCv);
        $motivationLetter->setPromptMotivationLetter($promptMotivationLetter);

        $motivationLetter->setApplication($application);

        // Ajouter la lettre de motivation à l'application
        $application->addMotivationLetter($motivationLetter);

        // Persister la lettre de motivation et l'application
        $em->persist($motivationLetter);
        $em->persist($application);
        $em->flush();

        // Retourner une réponse JSON avec succès
        return $this->json([
            'message' => 'Candidature créée avec succès',
            'applicationId' => $application->getId(),
        ], Response::HTTP_CREATED);
    }
    #[Route('/application/new', name: 'application_new')]
    public function newApplication(Request $request, EntityManagerInterface $em): Response
    {
        $application = new Application();
        $form = $this->createForm(ApplicationType::class, $application);
        $promptMotivationLetter = MotivationLetter::PROMPT_MOTIVATION_LETTER_TEMPLATE;
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Création de la lettre de motivation
            $motivationLetter = new MotivationLetter();
            if ($application->getApplicationDate() === null) {
                $application->setApplicationDate(new \DateTimeImmutable()); // Date actuelle
            }
            // Remplacer les placeholders dans le template de la lettre de motivation
            $promptMotivationLetter = str_replace(
                ['{{JOB_TITLE}}', '{{COMPANY_NAME}}', '{{JOB_DESCRIPTION}}'],
                [$application->getJobTitle(), $application->getCompanyName(), $application->getJobDescription()],
                $promptMotivationLetter
            );
            $promptCv = str_replace(
                ['{{JOB_TITLE}}', '{{JOB_DESCRIPTION}}'],
                [$application->getJobTitle(), $application->getJobDescription()],
                MotivationLetter::PROMPT_CV_CREATION
            );

            $motivationLetter->setPromptCv($promptCv);
            // Set the prompt (lettre de motivation) dans l'entité MotivationLetter
            $motivationLetter->setPromptMotivationLetter($promptMotivationLetter);

            $motivationLetter->setApplication($application);

            // Ajouter la lettre de motivation à l'application
            $application->addMotivationLetter($motivationLetter);

            // Persister la lettre de motivation
            $em->persist($motivationLetter);

            // Persister l'application
            $em->persist($application);

            // Sauvegarder dans la base de données
            $em->flush();

            // Ajouter un message flash de succès
            $this->addFlash('success', 'Candidature enregistrée avec succès');

            // Rediriger après l'enregistrement
            return $this->redirectToRoute('application_list');
        }

        // Rendu du formulaire en cas d'échec de soumission
        return $this->render('application/form.html.twig', [
            'form' => $form->createView(),
            'editMode' => false,
        ]);
    }

    #[Route('/application/delete/{id}', name: 'application_delete')]
    public function deleteApplication(?Application $application, EntityManagerInterface $em): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        // Si l'application n'existe pas, retourne une erreur 404
        if (!$application) {
            throw new NotFoundHttpException('Application not found');
        }

        // Suppression des lettres de motivation liées à l'application
        foreach ($application->getMotivationLetter() as $motivationLetter) {
            // Utilisation de la méthode removeMotivationLetter pour chaque lettre de motivation
            $application->removeMotivationLetter($motivationLetter);
            $em->remove($motivationLetter); // Supprimer la lettre de motivation
        }

        // Suppression de l'application
        $em->remove($application);

        // Persister les changements
        $em->flush();

        // Message flash pour notifier l'utilisateur
        $this->addFlash('success', 'Candidature supprimée avec succès');

        // Redirection vers la liste des applications
        return $this->redirectToRoute('application_list');
    }
    #[Route('/api/application/delete/{id}', name: 'api_application_delete', methods: ['DELETE'])]
    public function apiDeleteApplication(?Application $application, EntityManagerInterface $em): JsonResponse
    {
        // Si l'application n'existe pas, retourne une erreur 404
        if (!$application) {
            return $this->json(['error' => 'Candidature non trouvée'], Response::HTTP_NOT_FOUND);
        }

        // Suppression des lettres de motivation liées à l'application
        foreach ($application->getMotivationLetter() as $motivationLetter) {
            // Utilisation de la méthode removeMotivationLetter pour chaque lettre de motivation
            $application->removeMotivationLetter($motivationLetter);
            $em->remove($motivationLetter); // Supprimer la lettre de motivation
        }

        // Suppression de l'application
        $em->remove($application);

        // Persister les changements
        $em->flush();

        // Retourner un code HTTP 204 No Content pour une suppression réussie sans contenu
        return $this->json([], Response::HTTP_NO_CONTENT);
    }
}