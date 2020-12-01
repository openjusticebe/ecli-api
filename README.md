# ECLI Api poc

PoC Api built on top of Lumen.

# Features (Todos)
- [ ] Cache
- [ ] Api versioning
- [ ] Authentication
- [ ] Pagination
- [ ] Count

# Credits
- project led by OpenJustice.be and Liège Legal Tech Lab of University of Liège

# Develop
## Without docker
- Download the repo ;
- `php artisan migrate:fresh --seed`
- `php -S localhost:8000 -t public`


# Build
```docker build -t "ecli-api" ./  && docker run --rm -it -p 8000:8000```