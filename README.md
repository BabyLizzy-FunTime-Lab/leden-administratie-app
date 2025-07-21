# Laravel Ledenadministratie App

Dit is een Laravel 12 applicatie voor het beheren van families, leden, lidmaatschappen, kortingen en</br>
contributieplannen. Gebouwd als eindopdracht voor de PHP & SQL-cursus.

## Vereisten

Zorg ervoor dat je onderstaande software hebt geïnstalleerd:

- PHP >= 8.2
- Composer version 2.8.9
- MySQL
- Node.js version 18
- npm version 10 
- Laravel (artisan CLI) version 12

## Installatie

Volg deze stappen om de applicatie lokaal te draaien:

### Clone de repository en dan:

- `composer install`
- `npm install`
- .env file aanpassen met eigen mysql wachtwoord.
- Genereer de applicatiesleutel: `php artisan key:generate`
- Voer database migraties uit: `php artisan migrate`
- The tabellen van data voorzien: `php artisan db:seed`

### Compileer de frontend assets
`npm run dev`

### Start de lokale server
`php artisan serve`

## Inloggen
Dit zijn de standaard testaccounts.
Alle andere accounts zijn willekeurig</br>
gegenereerd door de [UserFactory](database/factories/UserFactory.php) en 
[FamilyFactory](database/factories/FamilyFactory.php).
### Als admin
- naam: admin
- wachtwoord: password
### Als familie lid (user)
- name: Mr Test
- password: password

## db reset
Use this command to reset the database with a new set of data and tables:</br>
`php artisan migrate:fresh --seed`
