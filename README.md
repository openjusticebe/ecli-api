
ECLI API a web application used for processing legal text and providing a REST-API. ECLI API is built on top of Lumen.

# Documentations of the API
- [OpenAPI Documentation](https://api-ecli.openjustice.lltl.be/api-docs.html)

# Launch dev environment
- Clone the repo ;
- `cd app`
- `cp .env.example .env`
- edit .env to match your configuration
- `docker-compose up -d`
- `docker-compose exec php php artisan migrate:fresh --seed`

# License
- Licensed with GPLv3.

# Credits
- Project led by **OpenJustice.be** in collaboration with Liège Legal Tech Lab of **[University of Liège](https://legaltech.uliege.be/)** 🎓.
