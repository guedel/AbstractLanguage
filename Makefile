.PHONY: clean check package

clean:
	@echo "Nettoyage"

check:
	@echo "Vérification"
	vendor/bin/phpunit

package: check
	composer archive -f zip --dir $(REGISTRY_PATH)/composer/
