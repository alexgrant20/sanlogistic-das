## ABOUT SANLOGISTIC

-- For first use (DEV)

- duplicate .env.example and rename it to .env
- Run composer install
- Adjust APP_DEBUG = TRUE and APP_ENV = local
- Adjust DB in ENV (USE MYSQL / Similar)
- Run php artisan migrate:fresh
- Run php db:seed
- Run php db:seed --class="SecondarySeeder"
- php artisan optimize:clear
- php artisan generate:key

-- For first use (LIVE)

- duplicate .env.example and rename it to .env
- Run composer install --optimize-autoloader --no-dev
- Adjust APP_DEBUG = FALSE and APP_ENV = production
- Adjust DB in ENV (USE MYSQL / Similar)
- Run php artisan migrate
- Run php db:seed (Generate basic data like city, district, etc)
- php artisan optimize
- php artisan generate:key

-- Periodic Use (LIVE/DEV)

- git pull
- run composer install --optimize-autoloader --no-dev
- php artisan optimize
- php artisan cache:forget spatie.permission.cache
