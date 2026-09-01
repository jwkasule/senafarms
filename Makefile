SHELL := /bin/bash

.DEFAULT_GOAL := help

help:
	@echo "Usage: make <target>"
	@echo ""
	@echo "Targets:"
	@echo "  setup        Install deps, copy .env, generate app key, migrate, seed, build assets"
	@echo "  deps         Install PHP and JS dependencies (composer, npm)"
	@echo "  env          Copy .env.example -> .env (if missing)"
	@echo "  key          Generate APP_KEY (php artisan key:generate)"
	@echo "  migrate      Run database migrations"
	@echo "  seed         Run database seeders"
	@echo "  assets       Build frontend assets (npm run dev)"
	@echo "  production   Build production assets (npm run production)"
	@echo "  serve        Start local dev server (php artisan serve)"
	@echo "  test         Run phpunit"

setup: deps env key migrate seed assets
	@echo "Setup complete. Run 'make serve' to start the dev server."

deps:
	@if ! [ -x "$(shell command -v composer)" ]; then echo "composer not found. Install composer first."; exit 1; fi
	@if ! [ -x "$(shell command -v npm)" ]; then echo "npm not found. Install Node.js/npm first."; exit 1; fi
	@composer install --no-interaction --prefer-dist
	@npm install

env:
	@if [ -f .env ]; then echo ".env already exists"; else cp .env.example .env && echo "Copied .env.example to .env"; fi

key:
	@php artisan key:generate

migrate:
	@php artisan migrate

seed:
	@php artisan db:seed --class=AdminAndSampleSeeder

assets:
	@npm run dev

production:
	@npm run production

serve:
	@php artisan serve --host=127.0.0.1 --port=8000

test:
	@./vendor/bin/phpunit || true
