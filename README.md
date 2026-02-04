# Plateforme Events - Structure MVC

# 🎉 EventHub - Plateforme de gestion d'ateliers et d'événements

![PHP](https://img.shields.io/badge/PHP-8.x-777BB4?style=flat&logo=php)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=flat&logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=flat&logo=bootstrap&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green.svg)

## 📖 Présentation du projet

*Plateforme-events** est une plateforme web dynamique développée en **PHP orienté objet** permettant la gestion complète d'ateliers et d'événements. Le projet a été réalisé **sans framework** afin de garantir une compréhension approfondie du fonctionnement interne d'une application web moderne.

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
- ✅ Page "Contact"

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
- ✅ Consultation de toutes les réservations
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
git clone https://github.com/VOTRE_USERNAME/plateforme-events.git
cd plateforme-events
```

### 2. Créer la base de données

**Option A : Via phpMyAdmin**
1. Ouvrez phpMyAdmin
2. Créez une nouvelle base de données nommée `eventhub`
3. Importez le fichier `database/eventhub.sql`

**Option B : Via le terminal**
```bash
mysql -u root -p
CREATE DATABASE eventhub CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE eventhub;
SOURCE database/eventhub.sql;
EXIT;
```

### 3. Configurer la connexion à la base de données

Modifiez le fichier `App/Core/DbConnect.php` avec vos identifiants :
```php
private const DB_HOST = 'localhost';
private const DB_NAME = 'eventhub';
private const DB_USER = 'root';
private const DB_PASS = ''; // Votre mot de passe MySQL
```

### 4. Lancer le serveur

**Avec MAMP/XAMPP/WAMP :**
- Placez le projet dans le dossier `htdocs`
- Démarrez Apache et MySQL
- Accédez à `http://localhost:8888/plateforme-events/`

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
│   │   └── SearchController.php
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
│   ├── eventhub.sql          # Structure de la BDD
│   └── test_data.sql         # Données de test
└── README.md
```

---

## 🗄️ Architecture de la base de données

### Tables principales

#### `users`
Gestion des utilisateurs (admins et utilisateurs)
- id, username, email, password (hashé)
- first_name, last_name, phone
- role_id, is_active, email_verified
- last_login, created_at, updated_at

#### `roles`
Gestion des rôles
- id, name (admin, user, visitor)
- description, created_at

#### `events`
Gestion des événements et ateliers
- id, title, slug, type (atelier/evenement)
- description, short_description
- date_start, date_end, duration
- location, location_city, location_postal_code
- is_online, online_link
- capacity, available_spots, min_participants
- price, currency, image
- category_id, organizer_id, status
- is_featured, views_count
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
- reserved_at, confirmed_at, cancelled_at
- cancellation_reason, user_notes, admin_notes
- created_at, updated_at

---

## 🔒 Sécurité

Le projet intègre plusieurs couches de sécurité :

### Protection des données
- ✅ **Requêtes préparées PDO** : Protection contre les injections SQL
- ✅ **Hashage bcrypt** : Mots de passe sécurisés
- ✅ **htmlspecialchars()** : Protection XSS sur toutes les sorties
- ✅ **Validation côté serveur** : Vérification de toutes les entrées utilisateur

### Contrôle d'accès
- ✅ **Gestion des sessions** : Authentification sécurisée
- ✅ **Protection des routes** : Vérification des rôles
- ✅ **Méthodes HTTP** : POST pour les actions sensibles
- ✅ **Vérifications métier** : Empêche les actions interdites

### Upload de fichiers
- ✅ **Validation d'extensions** : jpg, jpeg, png, webp uniquement
- ✅ **Taille limitée** : 5 Mo maximum
- ✅ **Noms de fichiers uniques** : Prévient les collisions
- ✅ **Dossiers protégés** : Permissions correctes

---

## 📸 Captures d'écran

### Page d'accueil
![Page d'accueil](docs/screenshots/home.png)

### Liste des événements
![Liste des événements](docs/screenshots/events.png)

### Détail d'un événement
![Détail](docs/screenshots/event-detail.png)

### Dashboard admin
![Dashboard](docs/screenshots/admin-dashboard.png)

---

## 🎯 Fonctionnalités avancées

### Système de recherche
- Recherche globale par mots-clés
- Filtrage par catégorie
- Filtrage par ville
- Filtrage par prix (min/max)
- Filtrage par date

### Gestion des réservations
- Numéro de réservation unique
- Vérification des places disponibles
- Mise à jour automatique des stocks
- Empêche les doublons de réservation
- Système d'annulation avec remise en stock

### Interface responsive
- Design adaptatif (mobile, tablette, desktop)
- Navigation intuitive
- Messages flash pour les retours utilisateur
- Formulaires avec validation en temps réel

---

## 🐛 Débogage

### Activer l'affichage des erreurs

En cas de problème, activez l'affichage des erreurs dans `App/public/index.php` :
```php
error_reporting(E_ALL);
ini_set('display_errors', 1);
```

### Vérifier les logs Apache/PHP

**MAMP** :
tail -f /Applications/MAMP/logs/php_error.log
```

**XAMPP** :
tail -f C:/xampp/apache/logs/error.log
```

---

## 🚧 Améliorations futures

- [ ] Système de paiement en ligne (Stripe/PayPal)
- [ ] Envoi d'emails de confirmation
- [ ] Export PDF des réservations
- [ ] Système de notation et commentaires
- [ ] Notifications push
- [ ] API REST pour applications mobiles
- [ ] Multi-langues (i18n)
- [ ] Calendrier interactif
- [ ] Statistiques avancées (graphiques)

---

## 📝 Versionnement Git

Le projet utilise Git avec une branche unique `main`. Chaque fonctionnalité majeure fait l'objet d'un commit explicite :

# Exemples de messages de commit

- 4a25f75 update project systeme de reservation ok
- 343f955 site fonctionnel sauf user role pas encore fait
- f50b945 Update project
- 39d792a Fix navbar links + base url + theme
- dcdfed2 feat: Plateforme événements MVC complète avec upload d'images et thème doré/noir
- 01c7a49 Initial commit**

---
### Principales étapes du développement

1. **Initialisation** : Mise en place du dépôt GitHub et structure initiale
2. **Architecture MVC** : Création de l'architecture complète (Controllers, Models, Views, Core)
3. **Design système** : Implémentation du thème doré/noir et navbar responsive
4. **Upload d'images** : Système d'upload sécurisé pour les événements
5. **Authentification** : Système de connexion/inscription avec rôles (admin/user)
6. **Système de réservation** : Gestion complète des réservations avec vérification des places

### Convention de nommage des commits

Le projet suit une convention de commits clairs et descriptifs :
- `feat:` pour les nouvelles fonctionnalités
- `fix:` pour les corrections de bugs
- `update:` pour les mises à jour générales
- `docs:` pour la documentation

## 👨‍💻 Auteur

**Cécilia** - Développeuse Web Junior  
[GitHub](https://github.com/ceElk) | [LinkedIn](https://linkedin.com/in/ceElk)

---

## 📄 Licence

Ce projet est sous licence MIT. Voir le fichier `LICENSE` pour plus de détails.

---

## 🙏 Remerciements

- Bootstrap pour le framework CSS
- La communauté PHP pour la documentation


---

## 📞 Support

Pour toute question ou problème :
- Ouvrir une [issue](https://github.com/ceElk/plateforme-events/issues)
- Contacter par email : cecilia.elkrieff@gmail.com

---

**⭐ Si ce projet vous a été utile, n'hésitez pas à lui donner une étoile sur GitHub !**
