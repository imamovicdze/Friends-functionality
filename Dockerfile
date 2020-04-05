FROM php:7

RUN apt-get update -y && apt-get install -y openssl zip unzip git
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


WORKDIR /app
COPY . /app
RUN composer install

CMD php artisan key:generate
CMD php artisan migrate
CMD php artisan db:seed --class=UserSeeder


CMD php artisan serve --host=0.0.0.0 --port=8181


EXPOSE 8181