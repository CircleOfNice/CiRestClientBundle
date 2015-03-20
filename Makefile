SHELL:=/bin/bash
if [ -z ${LOGDIR+x} ]; then LOGDIR=. ; else LOGDIR=$(LOGDIR); fi

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
	php -S localhost:8000 -t Tests/Functional/TestServer 2>1 & phpunit -c phpunit.xml --coverage-html $(LOGDIR)/coverage
	ps -eaf | awk '/ph[p] -S/{ print $$2 }' | xargs kill
docs:

install:

