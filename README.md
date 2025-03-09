# SAE 4.01 - WEB

Ce dépôt GitHub concerne le projet **SAE 4.01 - Développement Web PHP** réalisé en 2025.

## Membres du projet  
- **Bin Daivin Muhamad Zaiinizee**  
- **Beaujouan Tony**  
- **Lobjois Mathéo**  
- **Mignan Baptiste**  


## Installation

Afin d'installer et de lancer notre projet, il vous faudra installer **Composer**. Nous vous conseillons de suivre [ce tutoriel](https://www.digitalocean.com/community/tutorials/how-to-install-and-use-composer-on-ubuntu-20-04).

Une fois composer installer, il faut installer toutes les dépendances nécessaires au projet en executant les commandes suivantes :

```bash
composer update
composer install
```

Nous avons également remarquer que, lors de la première installation de composer, certaines dépendances nécessaires au projet sont absentes. Si vous rencontrez des problèmes avec les dépendances, executez ces commandes:

```bash
sudo apt install php-xml
sudo apt-get install php-mbstring
```

Une fois toutes les dépendances installés, vous pouvez executer le script de lancement run.sh.
Ce script execute le projet et lance le serveur web sur [`localhost:8080`](localhost:8080)

# Instructions pour lancer l'application

Suivez les étapes ci-dessous pour exécuter l'application localement :  

## 1. Lancer le site web avec `run.sh`
1. Ouvrez un terminal et exécutez la commande suivante :  
   ```bash
   sh ./run.sh
   ```
2. Une fois le serveur démarré, maintenez Ctrl enfoncé et cliquez sur le lien affiché :
http://localhost:8080

## 2. Lancer manuellement le site web

1. Ouvrez un terminal et naviguez jusqu'au dossier `public` du projet.

2. Exécutez la commande suivante pour lancer un serveur local :  
   ```bash
   php -S localhost:8080
   ```

3. Une fois le serveur lancé, maintenez Ctrl enfoncé et cliquez sur le lien affiché :
http://localhost:8080


# Fonctionnalités de l'application

## 1. Visiteur non authentifié
Un utilisateur non connecté peut accéder aux fonctionnalités suivantes :  
- **Module de recherche** permettant de trouver des restaurants selon :  
  - Type de restaurant  
  - Type de cuisine  
  - Multi-critères (prix, localisation, popularité, options végétariennes, etc.)  
- **Module d'inscription**  
- **Module de connexion**  
- **Module de visualisation** des caractéristiques détaillées d’un restaurant  
- **Lecture des critiques** des autres utilisateurs  


## 2. Visiteur enregistré
Un utilisateur authentifié bénéficie de fonctionnalités supplémentaires :  
- **Visualisation des notes** laissées par la communauté en cliquant
- **Accès et gestion de son profil**  
- **Publication et administration** de ses propres critiques  


## 3. Fonctionnalités avancées

### 3.1 Fonctionnalités accessibles à tous les profils
- **Écran d'accueil** affichant les meilleurs restaurants  

### 3.2 Fonctionnalités pour les visiteurs enregistrés
- **Gestion des types de cuisine préférés**  
- **Affichage des restaurants favoris**  


# Tests
Les résultats de la couverture sont générés au format **HTML** et sont situés dans le dossier `coverage`.

## 1. Visualiser le résultat global  
- Ouvrez le fichier `index.html` dans un navigateur.

## 2. Visualiser la couverture de chaque fichier  
- Ouvrez le fichier HTML correspondant au nom du fichier dans le dossier `model`. Par exemple, `Avis.html`, `User.html`, etc.
