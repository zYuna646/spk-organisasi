

## How to set up a project

First, we are going to install Node Module and Vendor files.

```bash
  npm install
```
```bash
  composer install
```

To setup your .env, kindly duplicate your .env.example file and rename the duplicated file to .env.
For this project, I'm using phpMyAdmin Database. On your .env file, locate this block of code below.

```bash
  DB_CONNECTION=mysql
  DB_HOST=127.0.0.1
  DB_PORT=3306
  DB_DATABASE=
  DB_USERNAME=root
  DB_PASSWORD=
```
To finalize this everything, run the following commands on your terminal.

```bash
  npm run dev

  php artisan key:generate

  php artisan migrate

  php artisan server
```

## Tech Stack

![Laravel](https://img.shields.io/badge/laravel-%23FF2D20.svg?style=for-the-badge&logo=laravel&logoColor=white)

![MySQL](https://img.shields.io/badge/mysql-%2300f.svg?style=for-the-badge&logo=mysql&logoColor=white)

![Bootstrap](https://img.shields.io/badge/bootstrap-%238511FA.svg?style=for-the-badge&logo=bootstrap&logoColor=white)
