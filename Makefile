create-project:
	mkdir -p src
	@make up
	docker compose exec app composer create-project --prefer-dist laravel/laravel:^10.0 .

up:
	docker compose up -d --remove-orphans

up-build:
	docker compose up -d --build --remove-orphans

stop:
	docker compose stop

app:
	docker compose exec app bash

web:
	docker compose exec web bash

db:
	docker compose exec db bash

db-connect:
	docker compose exec db psql -U postgres -h localhost -d postgres

log:
	docker compose logs -f

down:
	docker compose down