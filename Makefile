SHELL:=/bin/bash

all:
	@make -s setup
	@make -s build
	@make -s test
	@make -s docs
	@make -s install

setup:

build:
	composer install --no-dev -o -vv -n --ansi
test:
	php -S localhost:8000 -t Tests/Functional/TestServer & phpunit -c phpunit.xml --coverage-html logs/coverage
	ps -eaf -o pid,cmd | awk '/ph[p] -S/{ print $$1 }' | xargs kill
docs:

install:

