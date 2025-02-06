# Tennis Tournament App

A basic Laravel project to manage tennis tournaments, with REST endpoints, validation, and unit tests.

## Prerequisites
- [Docker](https://docs.docker.com/get-docker/) and [Docker Compose](https://docs.docker.com/compose/install/)
- Optionally, `curl` or any other client to test the endpoints

## Getting Started

1. **Clone the repository:**

    ```
    git clone https://github.com/your-username/tennis-tournament.git
    cd tennis-tournament
    ```

2. **Copy or rename `.env.example` to `.env`:**
   - Adjust credentials or ports if needed.

3. **Start the project with Docker:**

    ```
    docker compose build
    docker compose up -d
    ```

   - This creates two containers: `app` (PHP + Laravel) and `db` (MySQL).

4. **Install Composer packages and migrate the database:**

    ```
    docker compose exec app composer install
    docker compose exec app php artisan migrate
    ```

5. **Verify the application is running:**
   - Go to http://localhost:9000 (or the port you configured).
   - You should see the Laravel welcome page.

## Main Endpoints

Default prefix: `http://localhost:9000/api` (adjust the port based on your `.env`).

1. **Create a player (POST `/api/players`):**

    ```
    curl -X POST "http://localhost:9000/api/players" \
         -H "Content-Type: application/json" \
         -d '{
           "name": "Serena",
           "gender": "F",
           "skill": 90,
           "strength": 0,
           "speed": 0,
           "reaction_time": 95
         }'
    ```

2. **List all players (GET `/api/players`):**

    ```
    curl -X GET "http://localhost:9000/api/players"
    ```

3. **Create a tournament (POST `/api/tournaments`):**

    ```
    curl -X POST "http://localhost:9000/api/tournaments" \
         -H "Content-Type: application/json" \
         -d '{
           "type": "F",
           "player_ids": [1, 2, 3, 4]
         }'
    ```

4. **Run a tournament (POST `/api/tournaments/{id}/run`):**

    ```
    curl -X POST "http://localhost:9000/api/tournaments/1/run"
    ```

5. **Get tournament details (GET `/api/tournaments/{id}`):**

    ```
    curl -X GET "http://localhost:9000/api/tournaments/1"
    ```

## Running Tests

Run **Unit** and **Feature** tests:

    docker compose exec app php artisan test

or:

    docker compose exec app ./vendor/bin/phpunit

This executes all tests in the `tests/` directory:

- **Unit Tests**: Validate internal logic (services, specific methods).
- **Feature Tests**: Validate HTTP endpoints and database integration.

## Common Issues and Solutions

- **“Connection refused”** during migration:
  - Wait a few seconds for MySQL to fully start, or check that `.env` credentials match `docker-compose.yaml`.
- **422 (Unprocessable Entity)**:
  - Your request fails validation rules (missing or invalid fields).
- **Port already in use**:
  - Change the exposed port in `docker-compose.yaml` if `9000` is occupied on your system.

## Production Deployment

- Adjust `.env` for your hosting environment.
- Use Docker orchestration (Kubernetes, ECS, etc.) or a cloud Docker service.
- Configure your web server (Nginx/Apache) to serve the application.

## License

This project is under the [MIT License](LICENSE).
