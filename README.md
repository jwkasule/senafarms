# SenaFarms

A Laravel 5.5 based farm-management and POS web application for small poultry/egg businesses — tracks inventory (eggs, chickens, pullets), production, sales, customers/reservations, veterinary updates and generates PDF reports.

## Features

- Web-based admin panel and end‑user ordering/reservations
- POS flow (add/confirm/cancel orders)
- Inventory management (eggs, chickens, pullets) with reorder/price updates
- Production and population reports (PDF export)
- Sales history and reporting (PDF)
- Customer account management (register, edit, disable, password reset)
- Notifications and approvals workflow
- Simple API routes (see routes/api.php) for integrations
- Uses Pusher / Laravel Echo for realtime notifications

## Stack

- Language: PHP (>=7.0)
- Framework: Laravel 5.5
- Frontend: Vue 2, Bootstrap (bootstrap-sass), Laravel Mix (webpack)
- Notable libraries:
  - barryvdh/laravel-dompdf (PDF generation)
  - gloudemans/shoppingcart (cart/pos)
  - pusher/pusher-php-server + laravel-echo / pusher-js (realtime)
  - uxweb/sweet-alert (notifications)

## Project layout (top-level)

```
app/                Application classes (controllers/models; many controllers for Orders, Inventory, Production, Population, Sales, POS, Customers, Vet, Approvals, etc.)
bootstrap/          Laravel bootstrap files
config/             Configuration files
database/           Migrations / seeds / factories
public/             Public webroot (index.php, assets, css, js, images)
resources/          Views, lang, frontend assets
routes/             HTTP route definitions (web.php, api.php, console.php, channels.php)
storage/            Logs, compiled views and file storage
tests/              PHPUnit tests
artisan             Laravel CLI
composer.json       PHP dependencies and autoloading (PSR-4: "DLG\\" => "app/")
package.json        Node / frontend build scripts (laravel-mix)
webpack.mix.js      Mix (webpack) build config
Procfile            (present — used for Heroku / platform deployment)
```

How it fits together
- HTTP requests are routed via routes/web.php to controllers in app/ (e.g., HomeController, AdminController, InventoryController, OrdersController, POSController, ProductionController, PopulationController, SalesController, VetController).
- Views are in resources/views and static/public assets are built with Laravel Mix (npm / webpack) into public/.
- Data persistence uses Laravel's database layer (migrations/seeds in database/). PDF reports use barryvdh/laravel-dompdf.

## Quick start — run locally

Prerequisites
- PHP >= 7.0 with common extensions (mbstring, openssl, pdo, tokenizer, xml, ctype, json)
- Composer
- Node.js + npm
- MySQL (or other DB supported by Laravel) or adjust DB connection

1. Clone and install dependencies
```bash
git clone https://github.com/jwkasule/senafarms.git
cd senafarms
composer install
npm install
```

2. Environment
```bash
cp .env.example .env
# edit .env: APP_URL, DB_CONNECTION, DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD
php artisan key:generate
```

3. Database
```bash
php artisan migrate
# optionally:
php artisan db:seed
```

4. Build frontend assets (development)
```bash
npm run dev
# or for continuous rebuilds:
npm run watch
```

5. Serve the app
```bash
php artisan serve
# then open http://127.0.0.1:8000
```

Notes for production / Heroku
- A Procfile exists in the repo — you can deploy to Heroku or other PHP hosts. Ensure environment variables (DB, APP_KEY, PUSHER_* etc.) are set on the host.
- Build assets for production with:
```bash
npm run production
```

## Environment variables (common / important)

- APP_ENV, APP_DEBUG, APP_URL
- APP_KEY (generated via artisan)
- DB_CONNECTION, DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD
- MAIL_* (for password reset emails)
- BROADCAST_DRIVER=pusher, PUSHER_APP_ID, PUSHER_APP_KEY, PUSHER_APP_SECRET
- Any other provider credentials used in config/

## Tests

Run PHPUnit:
```bash
./vendor/bin/phpunit
```

(phpunit.xml exists in the repo.)

## Extending / Working on the code

- Controllers and primary app logic live in app/ (many resource-style controllers for inventory, production, sales, customers).
- Routes are in routes/web.php and routes/api.php — add routes there and corresponding controller methods.
- Views are in resources/views. Frontend assets (Sass/JS) are in resources/assets and compiled using Laravel Mix.
- Composer autoload maps namespace DLG\ to app/ (see composer.json).

## Troubleshooting

- If pages show a 500 error, check storage/logs/laravel.log for stack traces and ensure storage/ and bootstrap/cache are writable.
- Missing APP_KEY? Run php artisan key:generate.
- If frontend assets aren’t loading, rebuild with npm run dev / npm run production.
- For real-time notifications ensure PUSHER_* env vars are configured and your broadcast driver is set to pusher.

## Contributing

1. Fork the repo
2. Create a feature branch
3. Write tests for new functionality where possible
4. Submit a pull request describing the change

## License

MIT — see composer.json (license: MIT).

---

If you want, I can:
- Add a small INSTALL.md with environment examples,
- Generate a simple seed file to create an admin user and sample inventory,
- Or produce a short diagram of the main controllers and their responsibilities. Which would you like next?
