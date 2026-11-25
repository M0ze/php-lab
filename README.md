# contact-crud — contact form + PDO SQLite CRUD (PHP P1)

A clean contact form that saves to SQLite via PDO prepared statements. Teaches
superglobals, prepared statements, and graceful 404/500 pages.

## How to run

    cd contact-crud
    composer install
    php -S localhost:8000 -t public

## Structure

    public/
      index.php     — front controller
    src/
      Contact.php   — model: PDO, prepared statements

## Run with a file DB

    echo "SQLITE_DATABASE=/home/mugaggamosess/Projects/php/data/contacts.db" > .env
    mkdir -p data
    php -S localhost:8000 -t public

## Roadmap

| # | Project | What it teaches |
|---|---------|-----------------|
| 1 | contact-crud | superglobals, PDO prepared statements |
| 2 | mvc-blog | sessions, password_hash, tiny router |
| 3 | jwt-api | JSON responses, headers, stateless auth |

## Toolchain (this machine)

    php 8.5.12
    composer 2.10.3
