<?php

namespace App\Controller;

use AllowDynamicProperties;
use App\Entity\Application;
use App\Entity\MotivationLetter;
use App\Form\MotivationLetterType;
use App\Service\PdfService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

#[AllowDynamicProperties] class MotivationLetterController extends AbstractController
{
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    #[Route('/motivation-letter/edit/{id}', name: 'motivation_letter_edit')]
    public function editMotivationLetter(?Application $application, Request $request): Response
    {
        // Vérifie si l'application existe et a une lettre de motivation
        if (!$application || !$application->getMotivationLetter()->count()) {
            $this->addFlash('error', 'Aucune lettre de motivation trouvée pour cette candidature.');
            return $this->redirectToRoute('application_list'); // ou une autre route appropriée
        }

        // Récupère la première lettre de motivation
        $motivationLetter = $application->getMotivationLetter()->first();

        // Crée le formulaire basé sur l'entité MotivationLetter
        $form = $this->createForm(MotivationLetterType::class, $motivationLetter);
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // L'entité est déjà persistée, il suffit de faire un flush
            $this->em->flush();

            // Message flash de succès
            $this->addFlash('success', 'Lettre de motivation enregistrée avec succès.');

            // Redirige vers une autre route
            return $this->redirectToRoute('application_list'); // ou une autre route appropriée
        }

        // Rendu du formulaire si ce n'est pas encore soumis ou validé
        return $this->render('motivationLetter/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/motivation-letter/reload-prompt/{id}', name: 'motivation_letter_reload_prompt')]
    public function reloadPrompt(?Application $application): RedirectResponse
    {
        if (!$application instanceof Application) {
            throw new NotFoundHttpException('Candidature not found');
        }
        $promptMotivationLetter = str_replace(
            ['{{JOB_TITLE}}', '{{COMPANY_NAME}}', '{{JOB_DESCRIPTION}}'],
            [$application->getJobTitle(), $application->getCompanyName(), $application->getJobDescription()],
            MotivationLetter::PROMPT_MOTIVATION_LETTER_TEMPLATE
        );

        // Set the prompt (lettre de motivation) dans l'entité MotivationLetter
        $motivationLetter = $application->getMotivationLetter()->first();
        $motivationLetter->setPromptMotivationLetter($promptMotivationLetter);
        $motivationLetter->setApplication($application);

        $this->em->persist($motivationLetter);
        $this->em->persist($application);
        $this->em->flush();
        $this->addFlash('success', 'Prompt de lettre de motivation rechargé avec succès');

        // Rediriger après l'enregistrement
        return $this->redirectToRoute('application_list');
    }

    #[Route('/motivation-letter/cv/reload-prompt/{id}', name: 'cv_reload_prompt')]
    public function reloadPromptCV(?Application $application): RedirectResponse
    {
        if (!$application instanceof Application) {
            throw new NotFoundHttpException('Candidature not found');
        }
        $promptCv = str_replace(
            ['{{JOB_TITLE}}', '{{JOB_DESCRIPTION}}'],
            [$application->getJobTitle(), $application->getJobDescription()],
            MotivationLetter::PROMPT_CV_CREATION
        );

        // Set the prompt (lettre de motivation) dans l'entité MotivationLetter
        $motivationLetter = $application->getMotivationLetter()->first();
        $motivationLetter->setPromptCv($promptCv);
        $motivationLetter->setApplication($application);

        $this->em->persist($motivationLetter);
        $this->em->persist($application);
        $this->em->flush();
        $this->addFlash('success', 'Prompt de CV rechargé avec succès');

        // Rediriger après l'enregistrement
        return $this->redirectToRoute('application_list');
    }
    #[Route('/motivation-letter/entretien/reload-prompt/{id}', name: 'entretien_reload_prompt')]
    public function reloadPromptEntretien(?Application $application): RedirectResponse
    {
        if (!$application instanceof Application) {
            throw new NotFoundHttpException('Candidature not found');
        }
        $jobDescription = $application->getJobDescription() !== null ? $application->getJobDescription() : '';
        $companyInfo = $application->getCompanyInfo() !== null ? $application->getCompanyInfo() : '';
        $profile = MotivationLetter::PROFILE !== null ? MotivationLetter::PROFILE : '';
        $companyName = $application->getCompanyName() !== null ? $application->getCompanyName() : '';

        $promptEntretien = str_replace(
            ['{{JOB_DESCRIPTION}}', '{{COMPANY_INFO}}', '{{PROFILE}}', '{{COMPANY_NAME}}'],
            [$jobDescription, $companyInfo, $profile, $companyName],
            MotivationLetter::PROMPT_INTERVIEW_PREPARATION
        );

        // Set the prompt (lettre de motivation) dans l'entité MotivationLetter
        $motivationLetter = $application->getMotivationLetter()->first();
        $motivationLetter->setPromptEntretien($promptEntretien);
        $motivationLetter->setApplication($application);

        $this->em->persist($motivationLetter);
        $this->em->persist($application);
        $this->em->flush();
        $this->addFlash('success', 'Prompt d\'entretien rechargé avec succès');

        // Rediriger après l'enregistrement
        return $this->redirectToRoute('application_list');
    }

    #[Route('/motivation-letter/delete/{id}', name: 'motivation_letter_delete')]
    public function deleteMotivationLetter(?Application $application, EntityManagerInterface $em): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        // Si l'application n'existe pas, retourne une erreur 404
        if (!$application) {
            throw new NotFoundHttpException('Application not found');
        }

        // Suppression des lettres de motivation liées à l'application
        foreach ($application->getMotivationLetter() as $motivationLetter) {
            // Utilisation de la méthode removeMotivationLetter pour chaque lettre de motivation
            $motivationLetter->setContent(null);
            $this->em->persist($motivationLetter);
        }
        $em->flush();

        // Message flash pour notifier l'utilisateur
        $this->addFlash('success', 'Lettre de motivation supprimée avec succès');

        // Redirection vers la liste des applications
        return $this->redirectToRoute('application_list');
    }

    #[Route(path: '/motivation-letter/pdf/download/{id}', name: 'motivation_letter_pdf_download')]
    public function downloadPdf(PdfService $pdfService, ?Application $application): Response
    {
        if (!$application instanceof Application) {
            throw new NotFoundHttpException('Candidature not found');
        } else {
            $content = $this->renderView('pdf/letterDeMotivationPdf.html.twig',[
                'contenu' => $application->getMotivationLetter()->first()->getContent()
            ]);
            return $pdfService->getStreamResponse($content, 'Lettre de motivation - Alternant DEV - Dorbani - M1.pdf');
        }
    }
}