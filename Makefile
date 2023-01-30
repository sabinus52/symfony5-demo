## Commandes du projet Symfony en cours
## ------------------------------------
##
## Options disponibles :
##

include .env
ifneq (,$(wildcard ./.env.local))
    include .env.local
endif

ifndef APP_NAME
$(error APP_NAME is not set)
endif
APP_NAME := $(subst $\",,$(APP_NAME))

#ifndef GITHUB_REMOTE
#$(error GITHUB_REMOTE is not set)
#endif

PATH_FILE_CONF=/workspace/configuration/devops

.PHONY: help
help: Makefile
	@sed -n 's/^##//p' $<


# Démarrage du service Docker et Symfony
##   start              : Lancement du serveur BDD + SYMFONY
.PHONY: start
start:
	@echo "===== Démarrage de l'application ${APP_NAME} ====="
	@echo ""
	@./bin/console debug:dotenv
	@echo "----- Démarrage du serveur applicatif -----"
	@symfony serve


# Vérifie l'installation et des bons paramètres
##   check              : Vérficiation du paramétrage
.PHONY: check
check:
	@symfony check:security
	@./bin/console debug:container --env-vars
	@./bin/console debug:dotenv
	@./bin/console doctrine:database:create


# Initialise le projet
##   initialize         : Initialise le projet
.PHONY: initialize
initialize:
	echo "=== Initialisation du projet $(APP_NAME) ====="
	@echo "--- Configuration GIT ---------------------------------------------"
	@if [ $(git rev-parse --verify develop 2>/dev/null) ]; then \
		git remote add origin $(GITHUB_REMOTE); \
		git branch -M master; \
		git push -u origin master; \
		git stash; \
		git flow init; \
		git stash pop; \
		git push -u origin develop; \
		git config core.fileMode false; \
	fi
	@echo "--- Fichier de qualité de code ------------------------------------"
	cp ${PROJECTS_HOME}$(PATH_FILE_CONF)/ruleset.xml .
	cp ${PROJECTS_HOME}$(PATH_FILE_CONF)/phpstan.neon .
	cp ${PROJECTS_HOME}$(PATH_FILE_CONF)/.php-cs-fixer.dist.php .
	sed -i "s/%APP_NAME%/$(APP_NAME)/g" .php-cs-fixer.dist.php
	@echo "--- Fichier .gitignore --------------------------------------------"
	@if ! cat .gitignore | grep "###> My configuration ###" > /dev/null; then \
		echo "###> My configuration ###" >> .gitignore; \
		echo "/.env" >> .gitignore; \
		echo "/*.code-workspace" >> .gitignore; \
		echo "/*.conf" >> .gitignore; \
		echo "###< My configuration ###" >> .gitignore; \
	fi
	@echo "--- Documentation -------------------------------------------------"
	touch README.md CHANGELOG.md DEVELOP-README.md


# Tests unitaires avec PHPINIT
##   test               : Tests unitaires avec PHPINIT
.PHONY: test
test:
	phpunit --debug


# Analyse de la qualité du code
##   phpmd              : Analyse de la qualité du code
.PHONY: phpmd
phpmd:
	@phpmd src ansi ruleset.xml
	@phpmd tests ansi ruleset.xml


# Analyse statique du code PHP
##   phpstan            : Analyse statique du code PHP
.PHONY: phpstan
phpstan:
	@phpstan analyse src --level=7 --configuration=phpstan.neon


# Analyse si le code suit le standard de Symfony
##   codestyle          : Analyse si le code suit le standard de Symfony
.PHONY: codestyle
codestyle:
	@php-cs-fixer fix --dry-run --verbose --diff


# Corrige les erreurs de standard de dev de Symfony
##   codestyle-fix      : Corrige les erreurs de standard de dev de Symfony
.PHONY: codestyle-fix
codestyle-fix:
	@php-cs-fixer fix

##
##