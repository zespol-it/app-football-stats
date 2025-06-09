# Laravel Project with Jetstream, Livewire, and Tailwind CSS

This project is built with Laravel and includes the following technologies:
- Laravel 12
- Jetstream with Livewire
- Tailwind CSS
- Spatie Laravel Permission
- Alpine.js
- Vite

## Prerequisites

- PHP 8.2 or higher
- Composer
- Node.js and NPM
- SQLite (or MySQL/PostgreSQL)

## Installation

1. Clone the repository:
```bash
git clone <repository-url>
cd <project-directory>
```

2. Install app:
```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
php artisan storage:link
php artisan serve
```

```bash
npm i && npm run dev
```


3. Configure database:
   - For SQLite (default):
     ```bash
     touch database/database.sqlite
     ```
   - For MySQL/PostgreSQL:
     - Update `.env` file with your database credentials

The application will be available at `http://localhost:8000`


## Admin Access

### Default Admin Credentials
- Email: admin@example.com
- Password: password

To create an admin user, run:
```bash
php artisan db:seed
```

This will create an admin user with the following permissions:
- Manage users
- Manage roles
- Manage permissions

## Development

- Run tests:
```bash
php artisan test
```

- Watch for changes:
```bash
npm run dev
```

## Production Deployment

1. Build assets for production:
```bash
npm run build
```

2. Optimize Laravel:
```bash
php artisan optimize
```

## Security

Remember to change the default admin password after first login!

## License

zespol-IT.pl

## Documentation

### Screenshots

W katalogu `docs/` znajdują się zrzuty ekranu przedstawiające główne funkcjonalności aplikacji:

1. [Dashboard](docs/01-dashboard.png) - Panel główny z ostatnimi meczami
2. [Ligi](docs/02-leagues.png) - Lista lig i ich szczegóły
3. [Drużyny](docs/03-teams.png) - Lista drużyn i ich szczegóły
4. [Zawodnicy](docs/04-players.png) - Lista zawodników i ich statystyki
5. [Mecze](docs/05-matches.png) - Lista meczów i ich szczegóły
6. [Statystyki](docs/06-statistics.png) - Statystyki ligowe, strzelców i asystentów
7. [Ustawienia](docs/07-settings.png) - Panel ustawień aplikacji
