.PHONY: clean check style fix-style package

PHPQA = podman run --init -it --rm -v "`pwd`:/project" -v "`pwd`/var/tmp-phpqa:/tmp" -w /project docker.io/jakzal/phpqa:php7.4-alpine

clean:
	@echo "Nettoyage"

fix-style:
	@echo "Correction du style
	$(PHPQA) phpcbf

style:
	@echo "Vérification du style"
	@mkdir -p var/tmp-phpqa
	$(PHPQA) phpcs

check:
	@echo "Tests"
	vendor/bin/phpunit

package: check
	composer archive -f zip --dir $(REGISTRY_PATH)/composer/
