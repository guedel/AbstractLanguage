.PHONY: help bump clean check test shell style fix-style package

PHPVER = 8.3
PHPQA = podman run --init -it --rm -v "`pwd`:/project" -v "`pwd`/var/tmp-phpqa:/tmp" -v "$(REGISTRY_PATH)/composer:/registry" -w /project docker.io/jakzal/phpqa:php$(PHPVER)-alpine
PHPCOV = podman run --init -it --hostname php-dev --rm -e XDEBUG_MODE=coverage -v "`pwd`:/app" -w /app docker.io/webdevops/php-dev:$(PHPVER)-alpine
PHPSTAN_LEVEL = 3

help:
	@echo "targets: bump, clean, fix-style, shell, style, phpmd, phpstan, analyse, test, check, package"

clean:
	@echo "Nettoyage"
	rm -rf var/*

fix-style:
	@echo "Correction du style"
	$(PHPQA) phpcbf

shellqa:
	$(PHPQA) sh

shell:
	$(PHPCOV) bash

style:
	@echo "Vérification du style"
	@mkdir -p var/tmp-phpqa
	$(PHPQA) phpcs

phpmd:
	$(PHPQA) phpmd analyze --ruleset=cleancode --ignore-errors-on-exit --reportfile-html var/phpmd src

phpstan:
	$(PHPQA) phpstan analyze src/ -l $(PHPSTAN_LEVEL)

analyze: phpstan

test:
	@echo "Tests"
	$(PHPCOV) composer exec -- phpunit --coverage-html var/phpunit
	# XDEBUG_MODE=coverage composer exec -- phpunit --coverage-html var/phpunit

check: style analyze test

package: check
	$(PHPQA) composer archive -f zip --dir /registry
