# Touche Pas Au Klaxon

## Description

Application de covoiturage interne développée en PHP selon l'architecture **MVC** (Modèle - Vue - Contrôleur).

Les utilisateurs peuvent proposer des trajets entre agences, consulter les trajets disponibles et contacter les conducteurs. Un espace d'administration permet de gérer les utilisateurs, les agences et les trajets.

## Prérequis

- [XAMPP](https://www.apachefriends.org/) (Apache + PHP 8.2 + MySQL)
- [Composer](https://getcomposer.org/)

## Installation

1. Cloner le projet dans le dossier `htdocs` de XAMPP :
   ```
   git clone <url-du-repo> C:/xampp/htdocs/touche-pas-au-klaxon
   ```

2. Installer les dépendances Composer :
   ```
   cd C:/xampp/htdocs/touche-pas-au-klaxon
   composer install
   ```

3. Créer la base de données et les tables :
   ```
   mysql -u root < database/create.sql
   ```

4. Insérer les données initiales :
   ```
   mysql -u root < database/seed.sql
   ```

5. Démarrer Apache et MySQL depuis le panneau XAMPP.

6. Accéder à l'application : [http://localhost/touche-pas-au-klaxon/public/](http://localhost/touche-pas-au-klaxon/public/)

## Utilisation

- **Visiteur** : consultation des trajets disponibles (sans les coordonnées du conducteur)
- **Utilisateur connecté** : création, modification et suppression de ses propres trajets + accès aux coordonnées des conducteurs
- **Administrateur** : gestion complète des utilisateurs, agences et trajets

## Comptes de test

| Rôle          | Email                  | Mot de passe |
|---------------|------------------------|--------------|
| Administrateur | admin@klaxon.fr       | password     |
| Utilisateur   | alexandre.martin@email.fr | password  |

## Technologies utilisées

- **PHP 8.2** — langage back-end
- **Architecture MVC** — séparation Modèle / Vue / Contrôleur
- **PDO** — accès à la base de données avec requêtes préparées
- **MySQL** — base de données relationnelle
- **izniburak/router** — routeur HTTP léger
- **Bootstrap 5** — framework CSS
- **Bootstrap Icons** — icônes
- **Apache / XAMPP** — serveur web local
