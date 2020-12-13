🚧 Under construction 🚧

# ECLI Api poc

Replacement API of : https://github.com/openjusticebe/ecli

Developed by OpenJustice.be with ❤️. Licensed with GPLv3.
PoC Api built on top of Lumen.

# Features (Todos)
- [x] Cache with Redis
- [x] Api versioning
- [x] Pagination
- [ ] Documentation OpenAPI
<!-- https://niceprogrammer.com/lumen-api-tutorial-documentation-using-swagger-ui/ -->
- [ ] GraphQL
<!-- https://github.com/digiaonline/lumen-graphql) -->
- [ ] Authentication
- [ ] Throttle without api key

# Credits
- Project led by **OpenJustice.be** in collaboration with Liège Legal Tech Lab of **[University of Liège](https://legaltech.uliege.be/)** 🎓.

# Develop 
- Clone the repo ;
- `cd app`
- `docker-compose up -d`
- `docker-compose exec php php artisan migrate:fresh --seed`