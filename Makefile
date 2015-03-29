SHELL:=/bin/bash
ifndef LOGDIR
LOGDIR:=./logs
endif

all:
	@make -s setup
	@make -s build
	@make -s test
	@make -s docs
	@make -s install

setup:

build:
	composer install -o -vv -n --ansi 2>&1
test:
	php -S localhost:8000 -t Tests/Functional/TestServer 2>1 & phpunit -c phpunit.xml --coverage-html $(LOGDIR)/coverage
	ps -eaf | awk '/ph[p] -S/{ print $$2 }' | xargs kill
docs:

install:

