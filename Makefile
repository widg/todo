.DEFAULT_GOAL := help
include .env

.PHONY: build
build: ## сборка образов и приложения
	@echo "================================================================================"
	@printf "\033[36mУстановка зависимостей\033[0m\n"
	@go mod download
	@printf "\033[36mСборка образов\033[0m\n"
	@DOCKER_BUILDKIT=1 docker-compose build \
		--pull \
		--build-arg=USER_ID=${DOCKER_UID} \
        --build-arg=GROUP_ID=${DOCKER_GID}
	@echo "================================================================================"
	@printf "\033[36mЗапуск контейнеров\033[0m\n"
	@docker-compose up -d

.PHONY: up
up: ## (пере)сборка образов и запуск приложения
	@printf '\033[36mЗапуск контейнеров\033[0m\n'
	@docker-compose up -d

.PHONY: restart
restart: ## перезапуск приложения
	@docker-compose down
	@docker-compose up -d

.PHONY: vue-setup
vue-setup: ## создать проект vue
	@printf '\033[36mИнструкция:\033[0m\n'
	@printf '\033[36mhttps://dev.to/tqbit/a-step-by-step-guide-to-vue-development-with-docker-part-one-5ap4\033[0m\n'
	@printf '\033[36mЗапуск docker run -v ./:/vue-setup -it vue_helper\033[0m\n'
	@printf '\033[36mСоздаём приложение user@b24a617a1dfa:/vue-setup$ vue create vue_app\033[0m\n'
	## todo: в консоли отрабатывает а в make нет
	@docker build \
		--build-arg USER_ID=$(id -u) \
		--build-arg GROUP_ID=$(id -g) \
		-t vue_helper - < ./frontend/Setup.Dockerfile

.PHONY: vue-helper
vue-helper: ## создать проект vue
	@docker run -v ./:/vue-setup -it vue_helper

.PHONY: lavavel-setup
lavavel-setup: ## 
	# @docker build -t laravel_helper - < ./Setup.Dockerfile
	@docker run -v ./:/laravel-setup -it laravel_helper


