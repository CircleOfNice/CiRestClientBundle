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
	phpunit -c phpunit.xml --coverage-html logs/coverage
docs:

install:

