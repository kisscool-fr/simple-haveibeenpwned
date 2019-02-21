# -*- mode: makefile -*-

PHPUNIT = ./vendor/bin/phpunit
CSFIXER = ./vendor/bin/php-cs-fixer
PHPSTAN = ./vendor/bin/phpstan

stan:
	$(PHPSTAN) analyse --level=max src

style:
	$(CSFIXER) fix src --diff-format=udiff --dry-run --diff

test:
	$(PHPUNIT)
