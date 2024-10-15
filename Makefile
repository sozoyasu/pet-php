up:
	docker compose up -d

down:
	docker compose down

php:
	docker compose exec php sh

node:
	docker compose exec node sh

tailwind:
	npx tailwindcss -i ./frontend/css/input.css -o ./public/assets/css/app.css --watch
