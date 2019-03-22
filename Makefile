# -*- mode: makefile -*-

PHPUNIT = ./vendor/bin/phpunit
CSFIXER = ./vendor/bin/php-cs-fixer
PHPSTAN = ./vendor/bin/phpstan

stan:
	$(PHPSTAN) analyse --configuration=phpstan.neon

style:
	$(CSFIXER) fix src --dry-run --diff-format=udiff --diff

test:
	$(PHPUNIT)
