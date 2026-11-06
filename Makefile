.PHONY: clean check style fix-style package

PHPQA = podman run --init -it --rm -v "`pwd`:/project" -v "`pwd`/var/tmp-phpqa:/tmp" -v "$(REGISTRY_PATH)/composer:/registry" -w /project docker.io/jakzal/phpqa:php7.4-alpine

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
	$(PHPQA) composer exec phpunit

package: check
	$(PHPQA) composer archive -f zip --dir /registry
