phpspec:
	./bin/phpspec run
phpunit:
	./bin/phpunit -c phpunit.xml
phpstan:
	./bin/phpstan analyse src --level max
phpcs:
	./bin/phpcs src
phpcbf:
	./bin/phpcbf src
phpcpd:
	./bin/phpcpd src
phploc:
	./bin/phploc src
