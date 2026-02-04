# Base de données EventHub

## Fichiers disponibles

- `plateforme-events.sql` : Structure complète + données de test

## Installation

### Via phpMyAdmin
1. Créer une base de données `plateforme-events`
2. Importer `plateforme-events.sql`

### Via terminal
```bash
mysql -u root -p
CREATE DATABASE `plateforme-events` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `plateforme-events`;
SOURCE plateforme-events.sql;
EXIT;
```

## Identifiants de test

### Compte Administrateur
- **Email** : `admin@eventhub.com`
- **Mot de passe** : `password`

### Compte Utilisateur
- **Email** : `user@test.com`
- **Mot de passe** : `test123`
