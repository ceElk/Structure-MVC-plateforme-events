# 🎉 EventHub - Plateforme de gestion d'ateliers et d'événements

![PHP](https://img.shields.io/badge/PHP-8.x-777BB4?style=flat&logo=php)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=flat&logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=flat&logo=bootstrap&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green.svg)

## 📖 Présentation du projet

**EventHub** est une plateforme web dynamique développée en **PHP orienté objet** permettant la gestion complète d'ateliers et d'événements. Le projet a été réalisé **sans framework** afin de garantir une compréhension approfondie du fonctionnement interne d'une application web moderne.

### Contexte pédagogique

Projet réalisé dans le cadre d'une formation de développeur web, avec pour objectif de démontrer la maîtrise :
- De l'architecture MVC
- De la programmation orientée objet en PHP
- De la gestion d'une base de données relationnelle
- De la sécurisation d'une application web
- Du versionnement Git professionnel

---

## ✨ Fonctionnalités principales

### 👥 Pour les visiteurs
- ✅ Consultation de la liste des événements et ateliers
- ✅ Filtrage par catégories (Art, Sport, Musique, Technologie, Cuisine, etc.)
- ✅ Recherche globale (par titre, ville, description)
- ✅ Filtres avancés (prix, date, ville)
- ✅ Consultation des détails d'un événement/atelier
- ✅ Page "À propos"
- ✅ Page "Contact" avec envoi d'emails

### 🔐 Pour les utilisateurs connectés
- ✅ Inscription et connexion sécurisées
- ✅ Réservation de places pour les événements
- ✅ Gestion de ses réservations personnelles
- ✅ Annulation de réservations
- ✅ Consultation de l'historique des réservations
- ✅ Modification de son profil
- ✅ Changement de mot de passe

### 👨‍💼 Pour les administrateurs
- ✅ Gestion complète des événements (CRUD)
- ✅ Gestion complète des ateliers (CRUD)
- ✅ Gestion des catégories
- ✅ Gestion des utilisateurs (visualisation, modification, suppression)
- ✅ Consultation de toutes les réservations avec filtres
- ✅ Dashboard avec statistiques en temps réel
- ✅ Upload et gestion d'images

---

## 🛠️ Technologies utilisées

- **Backend** : PHP 8.x (Programmation Orientée Objet)
- **Architecture** : MVC (Model-View-Controller) fait main
- **Base de données** : MySQL 8.0 / MariaDB
- **Frontend** : HTML5, CSS3, Bootstrap 5.3
- **JavaScript** : Vanilla JS (validation côté client)
- **Accès BDD** : PDO avec requêtes préparées
- **Emails** : PHPMailer (envoi via SMTP)
- **Sécurité** : 
  - Hashage des mots de passe (bcrypt)
  - Protection XSS (htmlspecialchars)
  - Protection CSRF (vérification des méthodes HTTP)
  - Validation des données côté serveur
- **Versionnement** : Git / GitHub

---

## 📋 Prérequis techniques

Avant d'installer le projet, assurez-vous d'avoir :

- **PHP** >= 8.0
- **MySQL** >= 8.0 ou **MariaDB** >= 10.5
- **Composer** (pour installer PHPMailer)
- **Apache** ou **Nginx** (avec mod_rewrite activé)
- **Git** >= 2.0

### Environnements recommandés

- **MAMP** (Mac)
- **XAMPP** (Windows/Mac/Linux)
- **WAMP** (Windows)
- **Laragon** (Windows)

---

## 🚀 Installation

### 1. Cloner le dépôt
```bash
git clone https://github.com/ceElk/Structure-MVC-plateforme-events.git
cd Structure-MVC-plateforme-events
```

### 2. Installer les dépendances
```bash
composer install
```

### 3. Créer la base de données

**Option A : Via phpMyAdmin**
1. Ouvrez phpMyAdmin
2. Créez une nouvelle base de données nommée `plateforme-events`
3. Importez le fichier `database/plateforme-events.sql`

**Option B : Via le terminal**
```bash
mysql -u root -p
CREATE DATABASE `plateforme-events` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `plateforme-events`;
SOURCE database/plateforme-events.sql;
EXIT;
```

### 4. Configurer la connexion à la base de données

Modifiez le fichier `App/Core/DbConnect.php` avec vos identifiants :
```php
private const DB_HOST = 'localhost';
private const DB_NAME = 'plateforme-events';
private const DB_USER = 'root';
private const DB_PASS = ''; // Votre mot de passe MySQL
```

### 5. Configurer l'envoi d'emails (optionnel)

Pour activer l'envoi d'emails via le formulaire de contact :
```bash
cp App/Config/email.example.php App/Config/email.php
```

Modifiez `App/Config/email.php` avec vos identifiants SMTP Gmail :
```php
'smtp_username' => 'votre.email@gmail.com',
'smtp_password' => 'votre_mot_de_passe_app',
```

**Pour Gmail, créez un mot de passe d'application :** https://myaccount.google.com/apppasswords

### 6. Lancer le serveur

**Avec MAMP/XAMPP/WAMP :**
- Placez le projet dans le dossier `htdocs`
- Démarrez Apache et MySQL
- Accédez à `http://localhost:8888/plateforme-events/App/public/`

**Avec le serveur PHP intégré :**
```bash
cd App/public
php -S localhost:8000
```

---

## 🔑 Identifiants de test

### Compte administrateur
- **Email** : `admin@eventhub.com`
- **Mot de passe** : `password`

### Compte utilisateur
- **Email** : `user@test.com`
- **Mot de passe** : `test123`

> ⚠️ **Important** : Changez ces identifiants en production !

---

## 📁 Structure du projet
```
plateforme-events/
├── App/
│   ├── Controllers/          # Contrôleurs de l'application
│   │   ├── Controller.php    # Contrôleur parent
│   │   ├── HomeController.php
│   │   ├── AuthController.php
│   │   ├── EventController.php
│   │   ├── AtelierController.php
│   │   ├── ReservationController.php
│   │   ├── UserController.php
│   │   ├── AdminController.php
│   │   ├── SearchController.php
│   │   └── PageController.php
│   ├── Models/               # Modèles (interaction BDD)
│   │   ├── User.php
│   │   ├── Role.php
│   │   ├── Event.php
│   │   ├── Category.php
│   │   └── Reservation.php
│   ├── Entities/             # Entités (objets métier)
│   │   ├── UserEntity.php
│   │   ├── RoleEntity.php
│   │   ├── EventEntity.php
│   │   ├── CategoryEntity.php
│   │   └── ReservationEntity.php
│   ├── Views/                # Vues (templates HTML)
│   │   ├── base.php          # Layout principal
│   │   ├── home/
│   │   ├── auth/
│   │   ├── event/
│   │   ├── atelier/
│   │   ├── reservation/
│   │   ├── user/
│   │   ├── admin/
│   │   ├── search/
│   │   └── page/
│   ├── Config/               # Configuration
│   │   └── email.example.php
│   ├── Core/                 # Classes du noyau
│   │   ├── Router.php        # Routeur
│   │   └── DbConnect.php     # Connexion PDO
│   ├── Autoloader.php        # Chargement automatique des classes
│   └── public/               # Point d'entrée public
│       ├── index.php         # Fichier principal
│       ├── assets/
│       │   ├── css/
│       │   ├── js/
│       │   └── images/
│       └── uploads/          # Images uploadées
├── database/
│   ├── plateforme-events.sql # Structure complète de la BDD
│   └── README.md
├── vendor/                   # Dépendances Composer
├── composer.json
├── .gitignore
└── README.md
```

---

## 🗄️ Architecture de la base de données

### Tables principales

#### `users`
Gestion des utilisateurs
- id, username, email, password (hashé bcrypt)
- first_name, last_name, phone
- role_id, is_active, email_verified
- last_login, created_at, updated_at

#### `roles`
Gestion des rôles
- id, name (admin, user)
- description, created_at

#### `events`
Gestion des événements et ateliers
- id, title, slug, type (atelier/evenement)
- description, short_description
- date_start, time_start, date_end
- location, location_city, location_postal_code
- capacity, available_spots, price
- image, category_id, status
- created_at, updated_at

#### `categories`
Gestion des catégories
- id, name, slug, description
- icon, color, is_active
- created_at, updated_at

#### `reservations`
Gestion des réservations
- id, user_id, event_id
- reservation_number (unique)
- status (pending, confirmed, cancelled, attended)
- number_of_seats, amount_paid
- payment_status, payment_method
- reserved_at, cancelled_at, cancellation_reason
- user_notes, admin_notes
- created_at, updated_at

---

## 🔒 Sécurité

Le projet intègre plusieurs couches de sécurité :

### Protection des données
- ✅ **Requêtes préparées PDO** : Protection contre les injections SQL
- ✅ **Hashage bcrypt** : Mots de passe sécurisés
- ✅ **htmlspecialchars()** : Protection XSS sur toutes les sorties
- ✅ **Validation côté serveur** : Vérification de toutes les entrées utilisateur
- ✅ **Configuration sensible** : Identifiants SMTP dans fichier ignoré par Git

### Contrôle d'accès
- ✅ **Gestion des sessions** : Authentification sécurisée
- ✅ **Protection des routes** : Vérification des rôles (admin/user)
- ✅ **Méthodes HTTP** : POST pour les actions sensibles
- ✅ **Vérifications métier** : Empêche les actions interdites

### Upload de fichiers
- ✅ **Validation d'extensions** : jpg, jpeg, png, webp uniquement
- ✅ **Taille limitée** : 5 Mo maximum
- ✅ **Noms de fichiers uniques** : Prévient les collisions
- ✅ **Dossiers protégés** : Permissions correctes

---

## 🎯 Fonctionnalités avancées

### Système de recherche
- Recherche globale par mots-clés (titre, description, ville)
- Filtrage par catégorie dynamique
- Filtrage par ville
- Filtrage par prix (min/max)
- Filtrage par date
- Compteur de résultats

### Gestion des réservations
- Numéro de réservation unique (format: RES-YYYY-XXXXX)
- Vérification des places disponibles en temps réel
- Mise à jour automatique des stocks
- Empêche les doublons de réservation
- Système d'annulation avec remise en stock automatique
- Historique complet des réservations

### Interface responsive
- Design adaptatif (mobile, tablette, desktop)
- Navigation intuitive avec dropdown dynamiques
- Messages flash pour les retours utilisateur
- Formulaires avec validation
- Thème noir/or professionnel

---

## 📝 Versionnement Git

Le projet utilise Git avec une branche unique `main`. 

### Historique des commits
```
4a25f75 update project systeme de reservation ok
343f955 site fonctionnel sauf user role pas encore fait
f50b945 Update project
39d792a Fix navbar links + base url + theme
dcdfed2 feat: Plateforme événements MVC complète avec upload d'images et thème doré/noir
01c7a49 Initial commit
```

### Principales étapes du développement

1. **Initialisation** : Mise en place du dépôt GitHub et structure initiale
2. **Architecture MVC** : Création de l'architecture complète (Controllers, Models, Views, Core)
3. **Design système** : Implémentation du thème doré/noir et navbar responsive
4. **Upload d'images** : Système d'upload sécurisé pour les événements
5. **Authentification** : Système de connexion/inscription avec rôles (admin/user)
6. **Système de réservation** : Gestion complète des réservations avec vérification des places
7. **Pages statiques** : À propos, Contact avec envoi d'emails
8. **Sécurisation** : Protection des identifiants, validation des données

### Convention de nommage des commits

Le projet suit une convention de commits clairs et descriptifs :
- `feat:` pour les nouvelles fonctionnalités
- `fix:` pour les corrections de bugs
- `update:` pour les mises à jour générales
- `docs:` pour la documentation
- `security:` pour les améliorations de sécurité

---

## 👨‍💻 Auteur

**Cécilia** - Développeuse Web Junior  
[GitHub](https://github.com/ceElk) | [LinkedIn](https://linkedin.com/in/cecilia-elkrieff)

---

## 📄 Licence

Ce projet est sous licence MIT.

---

## 🙏 Remerciements

- Bootstrap pour le framework CSS
- Font Awesome pour les icônes
- PHPMailer pour l'envoi d'emails
- La communauté PHP pour la documentation

---

## 📞 Support

Pour toute question ou problème :
- Ouvrir une [issue](https://github.com/ceElk/Structure-MVC-plateforme-events/issues)
- Contacter par email : cecilia.elkrieff@gmail.com

---

**⭐ Si ce projet vous a été utile, n'hésitez pas à lui donner une étoile sur GitHub !**
