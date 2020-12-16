🚧 Under construction 🚧

# ECLI Api poc
Replacement of original API : https://github.com/openjusticebe/ecli

Developed by OpenJustice.be with ❤️. Licensed with GPLv3.
PoC Api built on top of Lumen.

# Features
- [x] Cache with Redis
- [x] Api versioning
- [x] Pagination
- [x] Documentation OpenAPI

# TODOS
- [ ] GraphQL (standing by)
- [ ] Authentication for post (standing by)
- [ ] Throttle without api key (standing by)

# Documentations of the API
- [OpenAPI Documentation](https://api-ecli.openjustice.lltl.be/api-docs.html)

# Credits
- Project led by **OpenJustice.be** in collaboration with Liège Legal Tech Lab of **[University of Liège](https://legaltech.uliege.be/)** 🎓.

# Develop 
- Clone the repo ;
- `cd app`
- `docker-compose up -d`
- `docker-compose exec php php artisan migrate:fresh --seed`