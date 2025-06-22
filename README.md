# Laravel Ledenadministratie App

Dit is een Laravel 12 applicatie voor het beheren van families, leden, lidmaatschappen, kortingen en contributieplannen. Gebouwd als eindopdracht voor de PHP & SQL-cursus.

## Vereisten

Zorg ervoor dat je onderstaande software hebt geïnstalleerd:

- PHP >= 8.2
- Composer
- MySQL of een andere ondersteunde database
- Node.js & npm (voor frontend assets)
- Laravel CLI (optioneel maar handig)

## Installatie

Volg deze stappen om de applicatie lokaal te draaien:

### Clone de repository en dan:

- composer install
- npm install
- .env file aanpassen met eigen mysql wachtwoord.
- Genereer de applicatiesleutel: php artisan key:generate
- Voer database migraties uit: php artisan migrate
- The tabellen van data voorzien: php artisan db:seed

### Compileer de frontend assets
npm run dev

### Start de lokale server
php artisan serve

## Inloggen
### Als admin
- name: admin
- password: password
### Als famili lid (user)
- name: Mr Test
- password: password
