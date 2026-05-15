# Project Instructions

This project is a Dockerized Laravel application designed for rapid development.

## Architecture

- **PHP:** 8.4 FPM
- **Web Server:** Nginx (Alpine)
- **Database:** PostgreSQL 16
- **Cache/Queue:** Redis 7
- **Mail Testing:** Mailhog
- **Database Management:** Cloudbeaver

## Conventions

- **Coding Standards:** Follow PSR-12 and Laravel's coding standards.
- **Type Safety:** Use strict typing (`declare(strict_types=1);`) in all new PHP files. Prefer explicit type hints for properties, parameters, and return types.
- **Dependency Management:** Use `composer` within the `app` container.

## Workflows

### Environment Setup

The environment is managed via Docker. On first run, the `docker-entrypoint.sh` script automatically:
1. Installs Laravel (if not present).
2. Copies `.env.docker` to `.env`.
3. Installs Composer dependencies.
4. Generates the application key.
5. Runs database migrations.

### Common Commands

Always run these commands through Docker to ensure consistency:

- **Start environment:** `docker compose up -d`
- **Stop environment:** `docker compose down`
- **Access App Container:** `docker compose exec app bash`
- **Run Artisan:** `docker compose exec app php artisan <command>`
- **Run Tests:** `docker compose exec app php artisan test`
- **View Logs:** `docker compose logs -f app`

## Database

- **Host:** `postgres`
- **Port:** `5432`
- **Database:** `laravel_db`
- **User:** `user`
- **Password:** `user123`

Access the database management UI at `http://localhost:8978` (Cloudbeaver).

## Mailhog

Access the Mailhog UI at the dynamically assigned port (check `docker compose ps`).
