# Contest management system

## Installation

[Laravel Official Documentation](https://laravel.com/docs/8.x)


Clone the repository

    git clone https://gitlab.com/lovsokheang/contest_management_system.git

Switch to the repo folder

    cd contest_management_system

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Install all the dependencies using composer

    composer install
    
Install node modules: [NodeJS Official Documentation](https://nodejs.org/en/), [Yarn](https://yarnpkg.com/)

    npm i
    or
    yarn

Generate a new application key

    php artisan key:generate

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate --seed

Start the local development server

    php artisan serve

Server default host http://localhost:8000

**Command list**

    git clone https://gitlab.com/lovsokheang/contest_management_system.git
    cd contest_management_system
    cp .env.example .env
    composer install
    yarn
    php artisan key:generate
    
**Make sure you set the correct database connection information before running the migrations** [Environment variables](#environment-variables)

    php artisan migrate --seed
    php artisan serve

**Default user**

    email: admin@admin.com
    password: not4you

