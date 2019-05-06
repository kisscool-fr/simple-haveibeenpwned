# -*- mode: makefile -*-

COMPOSER = composer
PHPUNIT = ./vendor/bin/phpunit
CSFIXER = ./vendor/bin/php-cs-fixer
PHPSTAN = ./vendor/bin/phpstan

dev:
	$(COMPOSER) install --optimize-autoloader

prod:
	$(COMPOSER) install --no-dev --optimize-autoloader --classmap-authoritative

stan: dev
	$(PHPSTAN) analyse --configuration=phpstan.neon

style: dev
	$(CSFIXER) fix src --dry-run --diff-format=udiff --diff

test: dev
	$(PHPUNIT)
