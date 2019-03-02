phpspec:
	./bin/phpspec run
phpunit:
	./bin/phpunit -c phpunit.xml
phpstan:
	./bin/phpstan analyse src --level max
