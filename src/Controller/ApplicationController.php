<?php

namespace App\Controller;

use App\Entity\Application;
use App\Form\ApplicationType;
use App\Repository\ApplicationRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\This;
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

    #[Route('/applications', name: 'application_list')]
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
    #[Route('/application/{id}/edit', name: 'application_edit')]
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

    #[Route('/application/{id}/delete', name: 'application_delete')]
    public function deleteApplication(?Application $application): NotFoundHttpException|\Symfony\Component\HttpFoundation\RedirectResponse
    {
        // Si l'application n'existe pas, retourne une erreur 404
        if (!$application instanceof Application) {
            return $this->createNotFoundException('Application not found');
        }

        // Suppression de l'application
        $this->em->remove($application);
        $this->em->flush();

        // Message flash pour notifier l'utilisateur
        $this->addFlash('success', 'Candidature supprimée avec succès');

        // Redirection vers la liste des applications
        return $this->redirectToRoute('application_list');
    }

    #[Route('/application/new', name: 'application_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $application = new Application();
        $form = $this->createForm(ApplicationType::class, $application);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($application);
            $em->flush();

            return $this->redirectToRoute('application_list'); // À adapter
        }
        $this->addFlash('success', 'Candidature enregistrée avec succès');

        return $this->render('application/form.html.twig', [
            'form' => $form->createView(),
            'editMode' => false,
        ]);
    }



}