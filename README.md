# 🎬 Téléciné

**Téléciné** est une application web collaborative qui permet aux cinéphiles d’organiser et de rejoindre des **séances de films**.  
Chaque séance est centrée autour d’un film choisi, d’une date et d’un nombre limité de participants.  
Après la séance, les utilisateurs peuvent **laisser une critique** et découvrir les avis des autres membres.

L’application interagit avec l’**API TMDB** pour afficher automatiquement les informations du film sélectionné (titre, affiche, synopsis, acteurs, etc.).  
Téléciné est conçue pour rassembler les gens autour du cinéma — qu’il s’agisse d’une soirée film entre amis ou d’un grand club de ciné.

---

## 🌟 Fonctionnalités principales

### 🎞️ Gestion des séances
- Création de **séances** avec titre du film, date, heure et description.  
- Limitation du nombre de participants par séance.  
- Possibilité de rejoindre ou quitter une séance librement.  

### 🧠 Intégration de données cinéma
- Recherche de films via **l’API TMDB** avec autocomplétion.  
- Récupération automatique du titre, de l’affiche, de l’année de sortie et du genre.  
- Stockage local des métadonnées essentielles pour chaque séance.  

### 💬 Interaction utilisateur
- Possibilité de **laisser des avis et notes** après chaque séance.  
- Consultation des critiques des autres participants.  
- Interface claire et fluide favorisant la discussion autour des films.  

### ⚙️ Administration
- Tableau de bord d’administration pour gérer les films, utilisateurs et séances.  
- Gestion des rôles et sécurité via le système de **Symfony Security**.  

### 🎨 Design et ergonomie
- Interface moderne et réactive grâce à **Tailwind CSS**.  
- Adaptation automatique aux mobiles, tablettes et ordinateurs.  
- Charte graphique légère et épurée centrée sur le contenu.

---

## 🧩 Stack technique

| Couche | Technologie | Rôle |
|--------|--------------|------|
| **Back-end** | [Symfony 6+](https://symfony.com/) | Framework principal (routes, contrôleurs, sécurité). |
| **Base de données / ORM** | [Doctrine ORM](https://www.doctrine-project.org/) | Gestion des entités et de la persistance. |
| **Front-end** | [Tailwind CSS](https://tailwindcss.com/) | Framework CSS utilitaire et responsive. |
| **API externe** | [TMDB API](https://developer.themoviedb.org/) | Source de données des films. |
| **Moteur de template** | Twig | Génération dynamique des vues. |
| **Versionning** | Git + GitHub | Suivi du développement. |
| **Gestionnaires de paquets** | Composer + npm | Dépendances PHP et front-end. |

---

## 🧰 Prérequis

Avant d’installer Téléciné, vérifiez que votre système dispose des outils suivants :

### ✅ Outils nécessaires
- PHP **8.2+**
- Composer **2.x**
- Node.js **18+** et **npm**
- Git
- Une base de données compatible SQL (MySQL ou PostgreSQL)
- Symfony CLI *(facultatif mais recommandé)*

### 🔧 Variables d’environnement
Les variables sont définies dans le fichier `.env.local`.  
Elles servent notamment à configurer la connexion à la base de données et la clé API TMDB.

---

## 🪟 Installation sous Windows

### 1. Cloner le dépôt
Ouvrez **Git Bash** ou **PowerShell** :
```bash
git clone https://github.com/tonpseudo/telecine.git
cd telecine
```

### 2. Installer les dépendances PHP
```bash
composer install
```

### 3. Installer les dépendances front-end
```bash
npm install
```

### 3. Installer les dépendances front-end
Pour lancer la compilation de Tailwind CSS :
```bash
npm run dev
```

### 4. Compiler les assets
Pour lancer la compilation de Tailwind CSS :
```bash
npm run dev
```

### 5. Configurer l’environnement

Copiez le fichier .env :

```bash
cp .env .env.local
```

Puis éditez .env.local avec vos paramètres :

```bash
DATABASE_URL="mysql://root:@127.0.0.1:3306/telecine"
TMDB_API_KEY="ta_cle_tmdb"
APP_ENV=dev
APP_DEBUG=true
```

###6. Créer la base de données
```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

###7. Lancer le serveur Symfony

Si vous avez installé Symfony CLI :

```bash
symfony serve
```

Sinon :

```bash
php -S localhost:8000 -t public
```

###8. Accédez à l’application

Ouvrez votre navigateur :

```bash
http://localhost:8000
```

🍎 Installation sous macOS

L’installation est similaire à celle de Windows, mais adaptée à l’environnement Unix.

###1. Cloner le dépôt
```bash
git clone https://github.com/tonpseudo/telecine.git
cd telecine
```

###2. Installer les dépendances
```bash
composer install
npm install
```

###3. Créer le fichier d’environnement
```bash
cp .env .env.local
```

Exemple de configuration :

```bash
DATABASE_URL="mysql://root:motdepasse@127.0.0.1:3306/telecine"
TMDB_API_KEY="votre_cle_tmdb"
APP_ENV=dev
APP_DEBUG=true
```

###4. Créer la base de données
```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

Pour PostgreSQL :

```bash
DATABASE_URL="postgresql://postgres:motdepasse@127.0.0.1:5432/telecine"
```

###5. Compiler les assets
```bash
npm run dev
```

###6. Lancer le serveur

Avec Symfony CLI :
```bash
symfony serve
```

Ou directement :
```bash
php -S localhost:8000 -t public
```

Puis ouvrez :
```bash
http://localhost:8000
```

