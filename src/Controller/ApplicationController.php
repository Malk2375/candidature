<?php

namespace App\Controller;

use AllowDynamicProperties;
use App\Entity\Application;
use App\Entity\MotivationLetter;
use App\Form\ApplicationType;
use App\Repository\ApplicationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


#[AllowDynamicProperties] class ApplicationController extends AbstractController
{
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/application/list', name: 'application_list')]
    public function index(ApplicationRepository $applicationRepository): Response
    {
        $applications = $applicationRepository->findBy([], ['applicationDate' => 'DESC']);

        return $this->render('application/list.html.twig', [
            'applications' => $applications,
        ]);
    }


    /**
     * @throws \Exception
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
}