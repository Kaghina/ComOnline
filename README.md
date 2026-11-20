# ComOnline — *Votre commune en un clic !*

Application web PHP/MySQL de gestion de services municipaux pour la région Auvergne-Rhône-Alpes.
Projet réalisé dans le cadre de l'UE **BDW — Base de données et programmation web** (L2, UCB Lyon 1).
Le sujet est dans [projetbd.pdf](projetbd.pdf).

## Fonctionnalités

| Page | Description |
|------|-------------|
| **Accueil** | Présentation du site et accès rapide aux fonctionnalités |
| **Statistiques** | Nombre de départements, communes et citoyens ; enfants et leur école ; enfants et leur cantine au 01/01/2024 ; paires d'enfants homonymes dans des écoles différentes ; top-3 des départements, des services les plus demandés, des services les plus proposés et des communes réalisant le plus d'unions |
| **Ajouter Service** | Ajout d'un nouveau service proposé par une commune (avec transaction) |
| **Rechercher** | Recherche d'un service (par libellé) ou d'un citoyen (par nom ou prénom) |
| **Historique** | Liste des actions de la session, exportable dans un fichier `.log` |
| **Périodes d'essai** | Génération aléatoire de périodes d'essai (communes, durée, services), filtrable par département et durée maximale |

## Prérequis

- **PHP 8.0 ou plus**, avec l'extension `mysqli` activée
- **MySQL 8** ou **MariaDB 10+**

Sous Windows, **WampServer** fournit les deux (PHP dans `C:\wamp64\bin\php\`, MariaDB sur le port **3307**, MySQL sur le port **3306**).

## Installation

### 1. Créer la base de données

Avec phpMyAdmin (http://localhost/phpmyadmin) : créer une base `comonline` (interclassement `utf8mb4_general_ci`), puis onglet **Importer** → choisir `commune.sql`.

Ou en ligne de commande (PowerShell, MariaDB de WAMP) :

```powershell
cd D:\L2\ComOnline
& "C:\wamp64\bin\mariadb\mariadb11.4.9\bin\mariadb.exe" -u root -h 127.0.0.1 -P 3307 -e "CREATE DATABASE IF NOT EXISTS comonline CHARACTER SET utf8mb4;"
cmd /c '"C:\wamp64\bin\mariadb\mariadb11.4.9\bin\mariadb.exe" -u root -h 127.0.0.1 -P 3307 --default-character-set=utf8mb4 comonline < commune.sql'
```

Le script `commune.sql` supprime puis recrée toutes les tables : on peut le relancer pour remettre la base à zéro.

### 2. Configurer la connexion

Tous les paramètres de connexion sont dans **un seul fichier** : [inc/config-bd.php](inc/config-bd.php).

```php
$servername = "127.0.0.1";
$port       = 3307;        // 3307 = MariaDB (WAMP), 3306 = MySQL
$username   = "root";
$password   = "";
$database   = "comonline";
```

Pour le serveur de la fac, décommenter le bloc prévu à cet effet dans ce même fichier et y mettre votre mot de passe.

## Lancement

### Option A — Serveur intégré de PHP (le plus simple)

Depuis le dossier du projet :

```powershell
cd D:\L2\ComOnline
C:\wamp64\bin\php\php8.3.28\php.exe -S 127.0.0.1:8000
```

Puis ouvrir **http://127.0.0.1:8000** dans le navigateur.

> Utiliser `127.0.0.1` plutôt que `localhost` : sous Windows, `-S localhost:8000` n'écoute qu'en IPv6 et le navigateur peut afficher « failed to load page ». `Ctrl + C` pour arrêter.

> WampServer doit être démarré (icône verte) pour que la base de données soit accessible.

### Option B — Via Apache (WampServer)

Copier le dossier `ComOnline` dans `C:\wamp64\www\`, puis ouvrir **http://localhost/ComOnline/**.

## Structure du projet

Le projet suit une architecture **MVC** avec un contrôleur frontal :

```
ComOnline/
├── index.php            Contrôleur frontal : choisit la page via ?page=...
├── commune.sql          Création des tables + jeu de données
├── inc/
│   ├── config-bd.php    Paramètres de connexion à la base
│   ├── includes.php     Nom du site, slogan, gestion de l'historique
│   └── routes.php       Table de routage page → contrôleur / vue / CSS
├── modele/
│   └── modele.php       Fonctions d'accès aux données (requêtes SQL)
├── controleurs/         Un contrôleur par page (traitement des formulaires)
├── vues/                Une vue par page (affichage HTML)
├── static/              En-tête, menu et pied de page communs
├── css/                 style.css (commun) + une feuille par page
├── img/                 Images et logo
└── historiques/         Fichiers d'historique générés (créé automatiquement)
```

**Ajouter une page** : créer `controleurs/controleurX.php`, `vues/vueX.php`, `css/X.css`, puis déclarer la route dans `inc/routes.php` et le lien dans `static/menu.php`.

## Modèle de données

Tables principales : `REGION`, `DEPARTEMENT`, `COMMUNE`, `CITOYEN`, `SERVICE`, `SERVICE_COMMUNE`,
`ECOLE`, `CANTINE`, `ENFANT`, `JUSTIFICATIF`, `BUREAU_DE_VOTE`, `LIEU`,
et les demandes : `DEMANDE_SCOLAIRE`, `DEMANDE_RESTAURATION`, `DEMANDE_ELECTIONS`,
`DEMANDE_UNION_CIVILE`, `DEMANDE_ETAT_CIVIL`, `DEMANDE_SIGNALEMENT`.

Le jeu de données contient 12 départements, 22 communes réelles de la région, 20 citoyens, 14 enfants, 10 écoles, 10 cantines et des demandes pour chaque service.

## Limites connues

- Le critère **« nombre de kilomètres »** des périodes d'essai n'est pas encore pris en compte.
- La commune d'une union civile est déduite de la commune du premier citoyen (la table `DEMANDE_UNION_CIVILE` n'a pas de colonne commune).

## Licence

Contenu sous licence [Creative Commons BY-NC-SA](https://creativecommons.org/licenses/).

## Auteur

Auteurs
  Kahina Ait Kaci Arab

