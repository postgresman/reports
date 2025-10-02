# Project Manual

## Getting Started

### Clone the Repository

```bash
git clone https://github.com/postgresman/reports
cd reports
```

### Install Dependencies

Make sure you have [Docker](https://docs.docker.com/get-docker/) installed.

```bash
composer install
```

### Start the Development Environment

Use Laravel Sail to run the required services (MySQL, Redis, Nginx, phpMyAdmin):

```bash
./vendor/bin/sail up
```

### Access Services

- **Application:** http://localhost
- **phpMyAdmin:** http://localhost:8081

### Common Commands

- **Stop Services:**
    ```bash
    ./vendor/bin/sail down
    ```
- **Run Migrations:**
    ```bash
    ./vendor/bin/sail artisan migrate
    ```

## Additional Notes

- Update `.env` as needed for your environment.
- For more Sail commands, see [Laravel Sail documentation](https://laravel.com/docs/sail).
