build-frontend:
	cd frontend && vue build

serve-frontend:
	cd frontend && npm start

serve-backend:
	php artisan serve
