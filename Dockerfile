FROM php:8.3-apache

RUN docker-php-ext-install pdo_mysql

# As credenciais chegam por variáveis de ambiente (env_file no docker-compose);
# o .env não é copiado para a imagem (ver .dockerignore).
COPY . /var/www/html/
