# Toundra

Toundra is a platform that allows managing 3d models.

## 1 - Enviroment

### Make sure that you have installed the next tools:
* [Git](https://git-scm.com/downloads)
* [npm](https://www.npmjs.com/get-npm)
* [PHP](https://www.php.net/downloads.php)
* [Composer](https://getcomposer.org/download/)
* [Laravel](https://laravel.com/docs/5.8)
* [MySQL](https://www.mysql.com/downloads/)

>We recomend to you to use Vagrant + Homestead. You can check the official documentation [here](https://laravel.com/docs/5.8/homestead).
## 2 - Database

### Rename the `.env.example` to `.env` file which should include all the environment variables for your project: 

The most important part is the database configuration:

```bash
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=toundra
DB_USERNAME=YOUR_USER_NAME
DB_PASSWORD=YOUR_PASSWORD
```

### Login to MySQL and create a database called `toundra`

```mysql
CREATE DATABASE toundra;
```
>You may also use phpMyAdmin or MySQL Workbech.

### Import the database

```bash
mysql toundra < import.sql
```
>Again, if you don't want to use CLI, you can use phpMyAdmin or MySQL Workbech to do the import.
## 3- Installation

### Clone the repository from Github

```bash
git clone https://github.com/razchen/toundra.git
```
and

```bash
cd toundra
```

### Run Composer dependencies 

```bash
composer install
```

### Run NPM dependencies

```bash
npm install
```

### Run Webpack

```bash
npm run prod
```

### Run the server
If you are not using Vagrant + Homestad, run the server:

```bash
php artisan serve
```

If you are using Vagrant + Homestad, go to your configurated domain.