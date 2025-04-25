<?php

namespace App\Entity;

use App\Repository\MotivationLetterRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MotivationLetterRepository::class)]
class MotivationLetter
{
    final const PROMPT_CV_CREATION = <<<EOT
Je vais te donner mon CV ainsi qu’une offre de poste sur laquelle je souhaite postuler. Peux-tu m'aider à identifier ce que je pourrais modifier ou ajouter dans mon CV pour le rendre plus cohérent avec le poste ? J'aimerais que tu m'indiques les éléments à améliorer, les compétences à mettre en avant, et les expériences qui pourraient être un atout. Je pense avoir réalisé plusieurs tâches et projets, mais je pourrais oublier certains détails importants, donc n’hésite pas à me suggérer des améliorations. **Le tout en tenant compte du poste proposé.**

**Aussi, dis-moi tout ce qu’il me faut pour préparer au mieux ma candidature : les éléments à fournir, les documents à joindre, et s’il y a des étapes ou conseils spécifiques pour réussir le processus de recrutement.**

---

### Le CV :
#### **DORBANI Mohamed Abdelmalek**

**Développeur Full-Stack**

Travailleur et persévérant | Sérieux et patient | Autonome et motivé

[m.abdelmalek.dorbani@gmail.com](mailto:m.abdelmalek.dorbani@gmail.com) | [+33758663561](tel:+33758663561) | Île-de-France

Contrat d’apprentissage | Durée : 12 à 24 mois | Master 1 | Rythme : 3 sem. entreprise / 1 sem. formation

Éligible à l’aide de 6000€.

[Portfolio](https://portfolio-malk.vercel.app/) | [Github](https://github.com/Malk2375) | [Gitlab](https://gitlab.com/Malek69)

---

### **Expériences**

#### **Développeur Fullstack – Symfony/VueJS**
**Decidento – Depuis août 2024 | Contrat d'apprentissage | Lyon, France**
- Réalisation de +8 projets en autonomie, supervisés par les Leads, et participation à +5 projets collaboratifs (Stack ci-dessous).
- Participation active à l’intégration de notre plateforme Symfony/VueJS avec divers CRM clients (HubSpot, Salesforce, Zoho, etc.) : automatisation de l’export des fiches sociétés et contacts.
- Conception et animation de formations techniques pour les entreprises clientes sur l’utilisation et l’intégration de nos outils automatisés.
- Échange avec des interlocuteurs anglophones lors de sessions de formation ou de suivi technique.
- Développement d’outils de rédaction automatisés via des API d’IA (OpenAI, Perplexity).
- Contribution à l’amélioration continue des projets existants (refactoring, documentation, performances).
- **Stack :** Symfony (PHP), Vue.js / Jquery, MySQL, Postman, Swagger, Zapier

#### **Développeur Web**
**TRI AUTOMAI – Mai 2024 à juillet 2024 | Stage**
- Création d’un site permettant aux utilisateurs de rechercher, filtrer, commander des pièces détachées en ligne.
- Mise en place d’un système d’administration avec EasyAdmin de Symfony.
- **Stack :** PHP Symfony, NodeJs, ReactJs, MySQL.

#### **Développeur Front-end**
**Spinalcom – Bâtiment intelligent – Juillet 2024 à août 2024**
- Développement d’un tableau de bord pour l’analyse de l’occupation des pièces par étage.
- Connexion et exploitation de l’API Spinalcom.
- **Stack :** VueJs, SCSS, Swagger API.

#### **Développeur Backend - BITCHEST**
**Projet pédagogique – Décembre 2024 à mars 2024**
- Création d’un site permettant d’acheter/vendre des cryptomonnaies virtuelles. Intégration de graphiques d’évolution des cours avec Chart.js.
- Gestion sécurisée des utilisateurs (authentification, autorisations).
- Déploiement du projet sur AlwaysData.
- **Stack :** Bootstrap, NodeJs, PHP Symfony, ChartJs, MySQL.

---

### **Formations**

#### **Master 1 – Développement, Intelligence Artificielle & Big Data**
**IPSSI - GRANDE ÉCOLE D'INFORMATIQUE – Depuis septembre 2025**

#### **L3 – Développement Fullstack & DevOps**
**IPSSI - GRANDE ÉCOLE D'INFORMATIQUE – Octobre 2024 à septembre 2025**

#### **L2 – Développement Web**
**L'école multimédia – Octobre 2023 à juin 2024**

#### **Cycle Préparatoire en Informatique - L1, L2**
**L'école supérieure en science et technologie de l'informatique et du numérique – 2021 à 2023**

---

### **Compétences**

#### **Développement Fullstack et Mobile**
- **PHP, Symfony** – Expert
- **HTML5 / CSS3 / JavaScript / Jquery**
- **Bootstrap / Tailwind**
- **ReactJs, VueJs, NodeJs** – Avancé
- **ExpressJS** – Bon niveau

#### **Bases de données, Cloud et Hébergement**
- **MySQL, MongoDB** – Expert
- **Google Firebase** – Intermédiaire
- **TDD, CI/CD** – Bon niveau
- **OVHcloud, Alwaysdata, Protocole FTP, SSH** – Expert

#### **Environnement (IDE)**
- **Git** – Avancé
- **Docker** – Bon niveau
- **Postman** – Expert
- **PhpStorm**

#### **Gestion de projets**
- **Méthodologie Agile (Scrum)**
- **Trello, Jira**
- **UML**

---

### **Langues**

- **Anglais** – Expert  
  *Compréhension orale et écrite fluide, présentations techniques et échanges clients en contexte professionnel.*

---

### **Centres d'intérêt**

- **Lectures**
- **Sport**

---

### Le Poste proposé :
{{JOB_TITLE}}
{{JOB_DESCRIPTION}}
  
---
EOT;

    final const PROMPT_MOTIVATION_LETTER_TEMPLATE = <<<EOT
Bonjour, Écris une lettre de motivation pour le poste de {{JOB_TITLE}} chez {{COMPANY_NAME}} selon mon profil, démontrant dès le début ma motivation et mon enthousiasme en faisant la candidature, et la correspondance de mon profil à ce poste.

Le résultat doit être un code HTML bien structuré et **compatible avec Dompdf** pour générer un fichier PDF. Utilise des balises HTML simples comme `<html>`, `<body>`, `<h1>`, `<p>`, `<br>`, et `<strong>`. Le style peut être minimal (pas besoin de CSS avancé, ni JavaScript). 

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
    private ?string $promptMotivationLetter = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $promptCv = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $chatgptLink = null;

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
    public function getPromptMotivationLetter(): ?string
    {
        return $this->promptMotivationLetter;
    }

    public function setPromptMotivationLetter(?string $promptMotivationLetter): static
    {
        $this->promptMotivationLetter = $promptMotivationLetter;

        return $this;
    }

    public function setPromptCv(?string $promptCv): self
    {
        $this->promptCv = $promptCv;
        return $this;
    }

    public function getPromptCv(): ?string
    {
        return $this->promptCv;
    }
    public function setChatgptLink(?string $chatgptLink): self
    {
        $this->chatgptLink = $chatgptLink;
        return $this;
    }

    public function getChatgptLink(): ?string
    {
        return $this->chatgptLink;
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
