
ECLI API a web application used for processing legal text and providing a REST-API. ECLI API is built on top of Lumen.

# Documentations of the API
- [OpenAPI Documentation](https://api-ecli.openjustice.lltl.be/api-docs.html)

# Launch dev environment
- Clone the repo ;
- `cd app`
- `cp .env.example .env`
- edit .env to match your configuration
- `docker-compose up -d`
- `docker-compose exec php php artisan migrate`
- Import `db` from a dump
- Run composer install (attach to console and run `composer install`)
- Enable log directory writing  ( `chmod 777 /var/www/storage/logs`)
- Populate DB with something

# Tests
Tests are written within `./app/tests/` directory. 

- `docker-compose exec php ./vendor/bin/phpunit`

# License
- Licensed with GPLv3.

# Credits
- Project led by **OpenJustice.be** in collaboration with Liège Legal Tech Lab of **[University of Liège](https://legaltech.uliege.be/)** 🎓.
