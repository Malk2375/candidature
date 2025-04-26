<?php

namespace App\Service;

use Nucleos\DompdfBundle\Exception\PdfException;
use Nucleos\DompdfBundle\Factory\DompdfFactoryInterface;
use Nucleos\DompdfBundle\Wrapper\DompdfWrapperInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class PdfService
{
    public function __construct
    (
        private readonly DompdfFactoryInterface $factory,
        private readonly DompdfWrapperInterface $wrapper,
        private readonly Environment $twig,  // Injection du service Twig
    )
    {
    }

    /**
     * @throws PdfException
     */
    public function getPdf(string $html): string
    {
        return $this->wrapper->getPdf($html);
    }

    public function generate(string $html)
    {
        $dompdf = $this->factory->create();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf->output();
    }

    public function getStreamResponse(string $html, string $fileName): StreamedResponse
    {
        return $this->wrapper->getStreamResponse($html, $fileName);
    }

    // Méthode pour envoyer le PDF

    /**
     * @param FrontendUser $user
     * @param SendInBlue $sendInBlue
     * @param $openAiResponse
     * @param $productQualities
     * @return JsonResponse
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * On a besoin la de :
     * Le nom du user et le nom de sa société,
     * La date de génération du pdf donc l'envoie du mail, les avantages renseignés, le prospect ciblé (fullName, job, role, localisation, sa société cible)
     * Le signal (nom de l'article, et du texte)
     * L'email généré et le script d'appel
     */
//    public function sendPdf($html): JsonResponse
//    {
//        $content = $this->generate($html);
//        $date = new \DateTime();
//
//        // Ajouter la pièce jointe PDF encodée en base64
//        $attachment = [
//            'content' => base64_encode($content), // Le contenu du PDF encodé en base64
//            'name' => 'Aide à la prospection Decidento - Société '.$companySocialName . $date->format('dym') .'.pdf', // Nom du fichier de la pièce jointe
//            'contentType' => 'application/pdf', // Type MIME
//        ];
//
//        // Ajouter la pièce jointe au tableau de données
//        $data['attachment'] = [$attachment];
//
//        try {
//            // Envoyer l'email avec la pièce jointe
//            $sendInBlue->sendSmtpEmail($data);
//            return new JsonResponse(['status' => 'success', 'message' => 'Un  PDF envoyé dans votre boite mail avec succès']);
//        } catch (\Exception $e) {
//            return new JsonResponse(['status' => 'error', 'message' => 'Erreur lors de l\'envoi de l\'email : ' . $e->getMessage()]);
//        }
//    }
}
