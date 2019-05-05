# SebouInfoConso

https://sebouinfoconso.herokuapp.com

Application Laravel permettant de suivre la consommation en calories des repas des utilisateurs.

*Réalisée dans le cadre du module PHP avancé | LP DAWIN 2019*

## Setup

- Cloner le repo
- Créer une base de données vide
- Dupliquer le .env.example et le nommer `.env`
  - Paramètrer les variables de connexion à la DB
  - Paramètrer `APP_KEY` avec une valeur générée par la commande `php artisan key:generate`
- Installer les dépendances PHP avec `composer install`
- Installer les dépendances JS avec `npm install`
- Build les assets avec `npm run dev`
- Lancer les migrations avec `php artisan migrate`
- Régler l'accès au dossier `public` (MAMP, Laravel Valet, etc.)
- *Have fun*