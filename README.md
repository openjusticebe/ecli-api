# ECLI Api poc

PoC Api built on top of Lumen.

# Features (Todos)
- [x] Cache
- [x] Api versioning
- [x] Pagination
- [x] Count
- [ ] Validation de schema
- [ ] Documentation openapi https://niceprogrammer.com/lumen-api-tutorial-documentation-using-swagger-ui/
- [ ] GraphQL (https://github.com/digiaonline/lumen-graphql)
- [ ] Authentication
- [ ] Throttle without api

# Credits
- Project led by OpenJustice.be and Liège Legal Tech Lab of University of Liège

# Develop
## Without docker
- Download the repo ;
- `php artisan migrate:fresh --seed`
- `php -S localhost:8000 -t public`


# Build
```docker-compose up```