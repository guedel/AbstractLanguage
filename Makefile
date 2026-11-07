.PHONY: bump clean check test shell style fix-style package

PHPVER = php8.3
PHPQA = podman run --init -it --rm -v "`pwd`:/project" -v "`pwd`/var/tmp-phpqa:/tmp" -v "$(REGISTRY_PATH)/composer:/registry" -w /project docker.io/jakzal/phpqa:$(PHPVER)-alpine

bump:
	@echo "Bump version"
	# TODO
	jq '.version' < composer.json

clean:
	@echo "Nettoyage"

fix-style:
	@echo "Correction du style
	$(PHPQA) phpcbf

shell:
	$(PHPQA) sh

style:
	@echo "Vérification du style"
	@mkdir -p var/tmp-phpqa
	$(PHPQA) phpcs

analyze:
	$(PHPQA) phpstan analyze src/ -l 1
	# $(PHPQA) deptrac
	$(PHPQA) phpmd analyze --ignore-errors-on-exit --report-file var/phpmd src

test:
	@echo "Tests"
	$(PHPQA) composer exec phpunit

check: style analyze test

package: check
	$(PHPQA) composer archive -f zip --dir /registry
