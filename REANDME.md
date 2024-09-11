# Le site Immo²

Il s'agit de la plateforme web d'une agence immobilière. Elle permet à tous de recherchez son bien idéale et ce que vous ayez déjà quelques critère en tête ou non. Ce site permet également de proposer son biens à la vente en y postant une offre ou plusieurs.

Ce projet a été réalisé à l'aide du framework Symfony dans sa version 6.4 en mode webapp, j'utilise Tailwind pour la gestion du CSS.


## Prérequis

Avant de commencer, assurez-vous d'avoir les éléments suivants installés sur votre machine :

- PHP >= 8.0
- Composer
- Symfony CLI (facultatif, mais recommandé)
- Serveur web (Apache, Nginx, ou le serveur Symfony)
- Une base de données (par ex. MySQL, PostgreSQL)

## Installation

### Cloner le repertoire:
``` bash
git clone https://github.com/votre-utilisateur/votre-projet.git
```

### Installer Composer:
``` bash
composer install
```

### Configurer les variables d'environnement:
Dupliquer le fichier .env en .env.local et renseigner les informations de connexion à votre base de données, comme suit :
``` bash
DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name"
```

### Exécuter les migrations pour créer la base de données:
``` bash
php bin/console doctrine:migrations:migrate
```

### Charger les données de test:
``` bash
php bin/console doctrine:migrations:migrate
```

## Fonctionnalités
Voici les fonctionnalités présente sur le site, elles sont triées par status des utilisateurs. 


### Utilisateurs anonymes

- Consulter les biens immobiliers disponibles.
- Appliquer des critères de recherche pour filtrer les biens.
- Créer un compte utilisateur.
- Se connecter avec un compte existant.

### Utilisateurs connectés

- Accéder aux mêmes fonctionnalités que les utilisateurs anonymes.
- Accéder à une page /profile pour :
- Créer de nouveaux biens immobiliers.
- Gérer (modifier/supprimer) les biens mis en ligne.
- Modifier les informations de son compte (page d'édition du compte).

### Administrateurs

- Accéder au tableau de bord administratif via l'URL /admin.
- Visualiser et gérer tous les biens enregistrés dans la base de données.
- Ajouter de nouvelles villes dans la base de données via l'interface d'administration.
## Securité

Le site est ainsi fait pour qu'un utilisateur anonyme puisse seulement consulté les pages "vitrines". Il doit donc se connecter si il possède des identifiants (/login) ou s'inscrire si il n'en possède pas (/register) si il désire intéragir avec le site, son accès ets donc limité. 

Un utilisateur connecté bénéficie du role USER, cela lui donne accès a tout chemin comportant /profile. Il accède a son dashboard personnel où il peut intéragir avec ses annonces de bien Immobilier, en ajouter. Il peut également éditer son profile.

Un utilisateur ne peut éditer et voir en detail uniquement ses propres annonces grâce à une sécurité dans le controller dans les action edit et delete:

```php
if ($bienImmo->getOwner() !== $this->getUser()) {
    throw $this->createAccessDeniedException('Vous ne pouvez modifier que vos propres biens.');
}
```
Un administrateur peut lui acceder à un dashboard général du site, où il peut agir sur toutes les annonces. C'est également lui qui renseigne les villes pour le reste du site.

Voici la configuration du security.yaml :

```yaml
access_control:
        - { path: ^/admin, roles: ROLE_ADMIN }
        - { path: ^/register, roles: PUBLIC_ACCESS }
        - { path: ^/profile, roles: ROLE_USER }
```

Pour avoir accès aux différents logs de connexion il faut se rendre dans src/DataFixtures/AppFixtures.php.
## Formulaire de contact

N'importe qu'elle utilisateur peut créer une demande de contact en rensaignant son Nom, son email et un message. Toutes les informations sont stockées en bdd.
## Autre

L'upload de fichier pour ajouter une image à une annonce n'est pas fonctionnel, sans mentir j'ai suivis ton cours de A à Z mais pour une raison qui m'echappe car cela ne fonctionne pas, l'image se met bien dans met bien dans le /public/upload mais aucune chaîne de caractère n'est stocké.

J'avais pour idée de permettre aux utilisateurs de pouvoir upload une image de couverture et plusieurs images pour une gallerie en stockant les images dans un tableau. J'arrivais bien à obtenir mes images dans le dossier upload mais rien en bdd. Si tu fixes le problème je suis curieux de savoir ce qui allait pas ;)