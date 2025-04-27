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
**TRI AUTO – Mai 2024 à juillet 2024 | Stage**
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
- **MySQL/MariaDB, MongoDB** – Expert
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
Bonjour,  
Écris une lettre de motivation pour le poste de **{{JOB_TITLE}}** chez **{{COMPANY_NAME}}**, démontrant dès le début mon enthousiasme et ma motivation à rejoindre leur équipe. Montre comment mon profil correspond parfaitement au poste proposé, en m’appuyant sur mes compétences techniques, mes expériences concrètes, ainsi que ma volonté de progresser dans ce domaine.

---

## Mon profil :

Je suis **Mohamed Abdelmalek DORBANI**, actuellement en Master 1 à l’**IPSSI** en développement, intelligence artificielle et big data. Je suis à la recherche d’un **contrat d’apprentissage de 12 à 24 mois** dans le domaine du **développement Fullstack / DevOps**, avec un rythme de **3 semaines en entreprise / 1 semaine en formation**. Je suis éligible à l’aide à l’embauche de 6000 €.

### 🛠️ **Compétences techniques**
- **Langages & frameworks :** PHP / Symfony, React, Vue.js, Node.js, ExpressJS, MySQL, MongoDB, Firebase
- **CI/CD, Docker, Git, Postman, Swagger, TDD, API REST**
- **Hébergement & déploiement :** AlwaysData, OVHcloud, FTP/SSH
- **Méthodologies :** Agile/Scrum, UML, Trello, Jira
- **Anglais professionnel :** présentations techniques et échanges clients

### 💼 **Expériences significatives**
- **Decidento (apprentissage actuel)** : développement d’outils internes et automatisation de process entre Symfony/VueJS et divers CRM (HubSpot, Salesforce, etc.) ; intégration d’API IA (OpenAI, Perplexity) ; animation de formations clients.
- **TRI AUTO** : développement d’un site e-commerce pour pièces détachées, back-office via EasyAdmin (Symfony).
- **Spinalcom** : dashboard d’analyse d’occupation des bâtiments (VueJs, Swagger API).
- **BITCHEST** : site d’achat/vente de cryptomonnaies fictives, déployé sur AlwaysData.
- **Autres projets** : Webdocumentaire interactif en React/Firebase/FramerMotion.

🎯 Mes projets et travaux sont visibles sur mon portfolio : [https://portfolio-malk.vercel.app/](https://portfolio-malk.vercel.app/)

---

## Voici la fiche de poste :

{{JOB_DESCRIPTION}}

---

Génère une lettre de motivation adaptée à ce profil, en démontrant en quoi je suis un excellent candidat pour ce poste et en valorisant mes expériences et mes compétences mentionnées ci-dessus.
---
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
