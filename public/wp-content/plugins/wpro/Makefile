help:
	# make deps    	      - Install dependencies.
	# make builddocs      - Convert WordPress the readme.txt into GitHub README.md markdown.
	# make installtestenv - Install unit testing environment.
	# make test           - Run unit tests.
	# make clean          - Remove build and test junk from filesystem.
	#
	# Requirements for everything to work:
	# * composer - Check out https://getcomposer.org/
	# * make
	# * php - As command line program

all: deps builddocs

deps:
	composer install

builddocs: deps
	vendor/bin/wp2md convert < readme.txt > README.md

installtestenv: deps
	mysql -e "DROP DATABASE IF EXISTS wprotest;" --user=root --password=""
	bin/install-wp-tests.sh wprotest root ""

test:
	vendor/bin/phpunit

clean:
	rm -Rf vendor composer.lock

.PHONY: help all deps builddocs installtestdev clean
