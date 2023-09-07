phpstan:
	vendor/bin/phpstan analyse lib tests

phpfixer:
	vendor/bin/php-cs-fixer fix -v

test:
	vendor/bin/phpunit tests/
