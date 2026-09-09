# --- Assets front (Vite / Tailwind, pour les pages Breeze) ---
FROM node:20-alpine AS assets
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci
COPY . .
RUN npm run build

# --- Dépendances PHP ---
FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist --no-interaction
COPY . .
RUN composer dump-autoload --optimize --no-dev

# --- Image finale ---
FROM php:8.4-fpm-alpine
RUN apk add --no-cache nginx supervisor bash \
      icu-dev postgresql-dev oniguruma-dev libzip-dev \
 && docker-php-ext-install pdo pdo_pgsql mbstring bcmath intl zip opcache

WORKDIR /var/www/html
COPY . .
COPY --from=vendor /app/vendor ./vendor
COPY --from=assets /app/public/build ./public/build

COPY docker/nginx.conf       /etc/nginx/nginx.conf
COPY docker/supervisord.conf /etc/supervisord.conf
COPY docker/entrypoint.sh    /usr/local/bin/entrypoint.sh

RUN mkdir -p storage/framework/views storage/framework/cache/data \
             storage/framework/sessions storage/logs bootstrap/cache \
 && chmod +x /usr/local/bin/entrypoint.sh \
 && chown -R www-data:www-data storage bootstrap/cache

ENTRYPOINT ["entrypoint.sh"]
CMD ["supervisord", "-c", "/etc/supervisord.conf"]
