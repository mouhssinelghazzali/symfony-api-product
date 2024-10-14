# Projet Symfony

Ce guide décrit les étapes nécessaires pour installer et configurer un projet Symfony.

## Prérequis

Avant de commencer, assurez-vous que votre système dispose des éléments suivants :

- PHP >= 8.1
- Composer
- MySQL ou autre base de données compatible
- Symfony CLI (facultatif mais recommandé)
- Git

## Installation

### 1. Cloner le dépôt

Clonez le projet depuis le dépôt Git :


```bash
git clone https://github.com/mouhssinelghazzali/symfony-api-product.git
cd symfony-api-product
```

2. Installer les dépendances
Assurez-vous d'avoir Composer installé, puis exécutez la commande suivante pour installer les dépendances du projet :


```bash
composer install
```

3. Configurer l'environnement
Dupliquez le fichier .env en .env.local pour configurer vos variables d'environnement spécifiques :


```bash
cp .env .env.local
```

Modifiez le fichier .env.local pour configurer la connexion à votre base de données et autres paramètres :

```bash
DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/nom_de_la_base_de_donnees?serverVersion=8.0"
```

4. Créer la base de données
Créez la base de données en exécutant la commande suivante :

```bash
php bin/console doctrine:database:create
```

5. Exécuter les migrations
Après avoir créé la base de données, appliquez les migrations pour générer les tables :

```bash
php bin/console doctrine:migrations:migrate
```


6. Lancer le serveur Symfony
Vous pouvez lancer le serveur de développement Symfony à l'aide de la commande suivante :

```bash
php -S 127.0.0.1:8000 -t public
```

7. Accéder à l'application
Ouvrez votre navigateur et accédez à l'URL suivante pour visualiser l'application :

```bash
http://127.0.0.1:8000/
```






