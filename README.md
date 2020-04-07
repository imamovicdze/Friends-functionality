# Hygge Software for PHP Developer Position 

This is solution for task that I received for PHP Developer Position.

#### To run this application you will need:
- MAMP or XAMPP or WAMP
- MYSQL Server (one that come with WAMP ) 
- Composer [https://getcomposer.org/](https://getcomposer.org/)
- Chorme or Firefox browser

#### RESTful APIs
- Documentation - [https://imamovicdze.github.io/friendsapp-docs/](https://imamovicdze.github.io/friendsapp-docs/)
- Additional Postman API Example - [Friends-functionality.postman_collection.json](https://github.com/imamovicdze/Friends-functionality/blob/master/Friends-functionality.postman_collection.json)

## Versions
* PHP 7.4
* Laravel 7

### Mannualy start

You need to download or clone this repo using link below:

`https://github.com/imamovicdze/Friends-functionality.git`

Then

`composer install`

After installing dependencies go to mysql server and create database with name:

`friends`

When you create database, you should change your parameters in: `.env` file.

Now run command:
 
`php artisan key:generate` and 
 
`php artisan migrate` to create tables.

Run `php artisan db:seed --class=UserSeeder` to populate table 

Now you run command: 

`php artisan serve` and go to 

`http://127.0.0.1:8000/`

### Docker start

Change `.env.example` to `.env`, next

Use  `cd laradock` folder and run following command:

`docker-compose up -d nginx mysql phpmyadmin workspace` to start docker.

Now go to: **`http://localhost`**
