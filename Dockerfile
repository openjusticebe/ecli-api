FROM nginx:1.17.9

COPY ./nginx/default.prod.conf /etc/nginx/conf.d/default.conf
COPY ./src /var/www
COPY ./src/.env.prod /var/www/.env

EXPOSE 80/tcp
EXPOSE 443/tcp
