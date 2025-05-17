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
Écris une lettre de motivation pour le poste de {{JOB_TITLE}} chez {{COMPANY_NAME}}.
Commence par exprimer clairement mon enthousiasme et ma motivation à rejoindre leur équipe.
Montre en quoi mon profil correspond au poste proposé, en mettant en avant mes compétences techniques, mon expérience en entreprise (notamment mon alternance chez DECIDENTO), mes projets pédagogiques, et ma volonté d'évoluer dans le développement fullstack et DevOps.

---

**Informations personnelles :**
Nom : Abdelmalek DORBANI
Email : [m.abdelmalek.dorbani@gmail.com](mailto:m.abdelmalek.dorbani@gmail.com)
Téléphone : 07 58 66 35 61
Portfolio : [https://portfolio-malk.vercel.app/](https://portfolio-malk.vercel.app/)

---

**Contexte de formation et recherche :**
Je suis actuellement en Master 1 à l’IPSSI (spécialisation Développement, Intelligence Artificielle & Big Data), en alternance chez DECIDENTO en tant que développeur fullstack.
Je suis à la recherche d’un **contrat d’apprentissage de 12 à 24 mois**, pour la rentrée de septembre/octobre, avec un rythme de **3 semaines en entreprise / 1 semaine en formation**.

---

**Compétences techniques principales :**

* Langages & Frameworks : PHP/Symfony, Node.js, Express.js, Vue.js, React, JavaScript ES6, HTML/CSS, jQuery
* Bases de données : MySQL/MariaDB, MongoDB, Elasticsearch
* DevOps & outils : Git, Docker, CI/CD, Swagger, Postman, TDD (PHPUnit, JS), OVHcloud, Alwaysdata
* Méthodologies : Agile/Scrum, UML2, gestion de projet avec Trello/Jira
* Anglais professionnel : échanges techniques, support et formation client

---

**Expériences professionnelles et projets :**

* **DECIDENTO** (Alternance) : développement de plus de 13 projets fullstack. Réalisations majeures :

  * Backoffice Symfony pour la gestion des données clients et B2B
  * Extranet client Vue.js/Symfony
  * API Symfony + Zapier pour automatisation d’exports vers des CRM (HubSpot, Salesforce…)
  * Intégration d’API IA (OpenAI, Perplexity) pour rédaction/vérification automatisée
  * Intégration d’API publiques (administration française)
  * Support technique, formation client en français et en anglais
  * Optimisations backend : refactoring, commandes Symfony, documentation, performance

* **TRI AUTO** (Stage) : développement d’un site e-commerce de pièces détachées, système d’admin EasyAdmin (Symfony), gestion des filtres/recherches.

* **Spinalcom** (Stage) : tableau de bord d’occupation de bâtiment intelligent, consommation API Spinalcom, développement en Vue.js.

* **BITCHEST** (Projet pédagogique) : site d’achat/vente de cryptomonnaies fictives avec statistiques (Chart.js), système d’authentification sécurisé, déploiement sur AlwaysData.

---

**Fiche de poste à analyser pour adapter la lettre :**
{{JOB_DESCRIPTION}}

---

**Objectif :**
Génère une lettre de motivation adaptée et convaincante, montrant clairement pourquoi mon profil correspond à ce poste. Mets en valeur les expériences clés, notamment DECIDENTO, tout en démontrant ma motivation à évoluer techniquement et professionnellement.

---
EOT;

    final const PROMPT_INTERVIEW_PREPARATION = <<<EOT
---

**Contexte :**

Je prépare un entretien pour une alternance en **développement web** et j'ai déjà la fiche de poste ainsi que des informations sur l'entreprise. Voici ce que tu dois savoir pour m'aider à me préparer efficacement :

---

**1. Fiche de Poste :**

{{JOB_DESCRIPTION}}

**2. Informations sur l’Entreprise :**

{{COMPANY_INFO}}

**3. Mon Profil (CV et Expériences) :**

{{PROFILE}}

---

Maintenant que tu as toutes les informations nécessaires, peux-tu m’aider à me préparer de manière complète pour mon entretien en abordant les points suivants ?

1. **Préparation aux questions techniques :**
    - Quelles questions techniques pourraient être posées en lien avec la fiche de poste et les technologies mentionnées ?
    - Comment répondre aux questions sur les compétences spécifiques demandées ?
    - Quels concepts dois-je absolument maîtriser et quelles erreurs faut-il éviter ?
2. **Préparation aux questions comportementales et soft skills :**
    - Quelles sont les questions comportementales classiques et comment les aborder efficacement ?
    - Comment mettre en avant mes soft skills pendant l’entretien ?
    - Donne-moi des exemples de réponses pour des questions fréquemment posées comme :
        - **\"Parlez-moi d’un projet sur lequel vous avez travaillé\"**
        - **\"Comment gérez-vous les défis dans une équipe ?\"**
3. **Préparation de la présentation personnelle :**
    - Peux-tu me donner des conseils pour structurer une présentation de 2 à 3 minutes ?
    - Comment parler de mon parcours, de mes compétences, et de mes motivations pour cette alternance ?
    - Quelles informations devrais-je absolument inclure et quels éléments vaut-il mieux éviter de mentionner ?
4. **Motivation et attentes vis-à-vis de l’alternance :**
    - Comment répondre à la question **\"Pourquoi cette alternance chez {{EPICONCEPT}} ?\"**
    - Comment aligner mes objectifs professionnels avec ce que l’entreprise propose ?
    - Quelle réponse donner à **\"Quelles sont vos attentes pendant cette alternance ?\"** ?
5. **Questions à poser à l’intervieweur :**
    - Quelles questions pertinentes pourrais-je poser à l’intervieweur pour en savoir plus sur l'entreprise et le poste ?
6. **Tests ou challenges techniques :**
    - Si l’entretien inclut un test technique en direct, quels types de défis pourraient m’être proposés ?
    - Quels conseils pratiques donnerais-tu pour résoudre un problème technique sous pression ?
    - Donne-moi des exemples d'exercices que je peux pratiquer pour m’y préparer.
7. **Gestion du stress et conseils généraux pour l’entretien :**
    - Comment me préparer mentalement pour cet entretien et gérer efficacement le stress ?
    - As-tu des conseils pour rester calme et structuré pendant l’entretien ?
    - Quelles erreurs fréquentes faut-il éviter lors d’un entretien pour une alternance ?

---

**Instructions supplémentaires :**

- Utilise les informations fournies dans la fiche de poste, mon CV et les informations sur l'entreprise pour personnaliser tes réponses.
- Sois précis et adapte tes conseils en fonction des technologies et des compétences spécifiées dans la fiche de poste.
- Je cherche à comprendre les attentes globales de l’entretien et à obtenir des exemples pratiques de réponses à préparer.

---
EOT;

    final const PROFILE = <<<EOT
# DORBANI Mohamed Abdelmalek

**Développeur Full-Stack**

Travailleur et Persévérant | Sérieux et Patient | Autonome et Motivé

[m.abdelmalek.dorbani@gmail.com](mailto:m.abdelmalek.dorbani@gmail.com) | [+33758663561](tel:+33758663561) | Île-de-France

Contrat d’apprentissage | Durée : 12 à 24 mois | Master 1 | Rythme : 3 sem. entreprise / 1 sem. formation

Éligible à l’aide de 6000€.

[Portfolio](https://portfolio-malk.vercel.app/) | [Github](https://github.com/Malk2375) | [Gitlab](https://gitlab.com/Malek69)

---

# Expériences

## **Développeur Fullstack – Symfony/VueJS**

**Decidento – Depuis août 2024 | Contrat d'apprentissage | Lyon, France**

- Réalisation de +8 projets en autonomie supervisé par les Leads et participation à +5 projets collaboratifs (Stack ci-dessous).
- Participation active à l’intégration de notre plateforme Symfony/VueJS avec divers CRM clients (HubSpot, Salesforce, Zoho, etc.) : automatisation de l’export des fiches sociétés et contacts.
- Conception et animation de formations techniques pour les entreprises clientes sur l’utilisation et l’intégration de nos outils automatisés.
- Échange avec des interlocuteurs anglophones lors de sessions de formation ou de suivi technique.
- Développement d’outils de rédaction automatisés via des API d’IA (OpenAI, Perplexity).
- Contribution à l’amélioration continue des projets existants (refactoring, documentation, performances).
- **Stack :** Symfony (PHP), Vue.js / Jquery, MySQL, Postman, Swagger, Zapier

## **Développeur web**

**TRI AUTO – Mai 2024 à juillet 2024 | Stage**

- Création d’un site permettant aux utilisateurs de rechercher, filtrer, commander des pièces détachées en ligne.
- Mise en place d’un système d’administration avec EasyAdmin de Symfony.
- **Stack :** PHP Symfony, NodeJs, ReactJs, MySQL.

## **Développeur Front-end**

**Spinalcom - Bâtiment intelligent – Juillet 2024 à août 2024**

- Développement d’un tableau de bord pour l’analyse de l’occupation des pièces par étage.
- Connexion et exploitation de l’API Spinalcom.
- **Stack :** VueJs, SCSS, Swagger API.

## **Développeur Backend - BITCHEST**

**Projet pédagogique – Décembre 2024 à mars 2024**

- Création d’un site permettant d’acheter/vendre des cryptomonnaies virtuelles. Intégration de graphiques d’évolution des cours avec Chart.js.
- Gestion sécurisée des utilisateurs (authentification, autorisations).
- Déploiement du projet sur AlwaysData.
- **Stack :** Bootstrap, NodeJs, PHP Symfony, ChartJs, MySQL.

---

# Formations

## **Master 1 – Développement, Intelligence Artificielle & Big Data**

**IPSSI - GRANDE ÉCOLE D'INFORMATIQUE – Depuis septembre 2025**

## **L3 – Développement Fullstack & DevOps**

**IPSSI - GRANDE ÉCOLE D'INFORMATIQUE – Octobre 2024 à septembre 2025**

## **L2 – Développement Web**

**L'école multimédia – Octobre 2023 à juin 2024**

## **Cycle Préparatoire en Informatique - L1, L2**

**L'école supérieure en science et technologie de l'informatique et du numérique – 2021 à 2023**

---

# Compétences

## **Dév. fullstack et mobile**

- **PHP, Symfony** – Expert
- **HTML5 / CSS3 / JavaScript / Jquery**
- **Bootstrap / Tailwind**
- **ReactJs, VueJs, NodeJs** – Avancé
- **ExpressJS** – Bon niveau

## **BDD, cloud et hébergement**

- **MySQL, MongoDB** – Expert
- **Google Firebase** – Intermédiaire
- **TDD, CI/CD** – Bon niveau
- **OVHcloud, Alwaysdata, Protocole FTP, SSH** – Expert

## **Environnement (IDE)**

- **Git** – Avancé
- **Docker** – Bon niveau
- **Postman** – Expert
- **PhpStorm**

## **Gestion de projets**

- **Méthodologie Agile (Scrum)**
- **Trello, Jira**
- **UML**

---

# Langues

- **Anglais** – Expert
    
    *Compréhension orale et écrite fluide, présentations techniques et échanges clients en contexte professionnel.*
    

---

# Centres d'intérêt

## **Lectures**

## **Sport**
EOT;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $content = null;
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $promptEntretien = null;

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
    public function getpromptEntretien(): ?string
    {
        return $this->promptEntretien;
    }

    public function setPromptEntretien(?string $promptEntretien): static
    {
        $this->promptEntretien = $promptEntretien;

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
