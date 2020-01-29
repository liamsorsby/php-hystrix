phpspec:
	./bin/phpspec run
phpunit:
	./bin/phpunit -c phpunit.xml
phpstan:
	./bin/phpstan analyse src --level 4
phpcs:
	./bin/phpcs src
phpcbf:
	./bin/phpcbf src
phpcpd:
	./bin/phpcpd src
phploc:
	./bin/phploc src
test:
	make phpspec && make phpunit && make phpstan && make phpcs && make phpcbf && make phpcpd