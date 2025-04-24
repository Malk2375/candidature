<?php

namespace App\Entity;

use App\Repository\MotivationLetterRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MotivationLetterRepository::class)]
class MotivationLetter
{
    final const PROMPT_MOTIVATION_LETTER_TEMPLATE = <<<EOT
Bonjour, Écris une lettre de motivation pour le poste de {{JOB_TITLE}} chez {{COMPANY_NAME}} selon mon profil, démontrant dès le début ma motivation et mon enthousiasme en faisant la candidature, et la correspondance de mon profil à ce poste.

## Voici mon profil :

——

Je suis Abdelmalek DORBANI et je cherche un contrat d'apprentissage pour mon MASTER 1 en développement fullstack et DevOps.
Parcours académique: " J'ai fait trois ans d'études en Algérie à l'École Supérieure en Science et Technologie de l'Informatique et du Numérique, et j'ai poursuivi ma formation avec un BAC+2 à Paris à l'École Multimédia, me spécialisant en développement web, et j’entame en septembre mon bac+3 à IPSSI en développement fullstack et devops. Je suis fort en PHP Symfony, React, et MySQL. "

Mon expérience inclut un stage en tant que développeur web chez TRI AUTO, où j'ai contribué au développement d'un site permettant aux utilisateurs de rechercher, filtrer et commander des pièces détachées en ligne, ainsi que la mise en place d'un système d'administration avec EasyAdmin de Symfony.

J'ai également fais une interface d'analyse d'occupation des pièces par étage pour chaque bâtiment en utilisant VueJs, Swagger API et Scss Spinalcom.

Dans le cadre de ma formation, j'ai développé : Bitchest, un site permettant d'acheter et de vendre des cryptomonnaies virtuelles. J'ai développé un webdocumentaire en React, Firebase, et FramerMotion, qui parle des combats des judokas français dans les JO.

——

## Voici la fiche de poste :

——

{{JOB_DESCRIPTION}}

——

En mettant en avant mes compétences et expériences mentionnées, et en expliquant pourquoi je serais un atout pour leur équipe. Voici le lien vers mon portfolio : https://portfolio-malk.vercel.app/, où l'on trouve toutes les informations, les projets et les liens vers mes réseaux.
EOT;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $content = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $prompt = null;

    #[ORM\ManyToOne(cascade:['persist', 'remove'])]
    private ?Application $application = null;
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): static
    {
        $this->content = $content;

        return $this;
    }
    public function getPrompt(): ?string
    {
        return $this->prompt;
    }

    public function setPrompt(?string $prompt): static
    {
        $this->prompt = $prompt;

        return $this;
    }

    public function getApplication(): ?Application
    {
        return $this->application;
    }

    public function setApplication(?Application $application): static
    {
        $this->application = $application;
        return $this;
    }
}
