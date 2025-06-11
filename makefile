# Variables
COMPOSE = docker-compose
PHP     = $(COMPOSE) exec app php
ARTISAN = $(PHP) artisan
NPM     = $(COMPOSE) exec node npm

# Build and start containers
up:
	$(COMPOSE) up -d --build

# Stop containers
down:
	$(COMPOSE) down

# Restart containers
restart:
	$(COMPOSE) down && $(COMPOSE) up -d

# App shell (PHP container)
bash:
	$(COMPOSE) exec app bash

# Run Composer install
composer-install:
	$(COMPOSE) exec app composer install

# Run Laravel migrations
migrate:
	$(ARTISAN) migrate

# Run Laravel seeders
seed:
	$(ARTISAN) db:seed

# Rollback migrations
rollback:
	$(ARTISAN) migrate:rollback

# Clear caches
clear:
	$(ARTISAN) config:clear && \
	$(ARTISAN) cache:clear && \
	$(ARTISAN) route:clear && \
	$(ARTISAN) view:clear

# Laravel key generate
key:
	$(ARTISAN) key:generate

# Permissions fix (on host)
permissions:
	sudo chown -R $$(id -u):$$(id -g) storage bootstrap/cache && chmod -R 775 storage bootstrap/cache

# Show logs
logs:
	$(COMPOSE) logs -f

# PostgreSQL shell
psql:
	$(COMPOSE) exec db psql -U laravel -d laravel

# Run PHP tests
test:
	$(ARTISAN) test

# Generate JWT Token
jwt:
	$(ARTISAN) jwt:secret