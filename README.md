# Getting Started

## Installation

Clone the repository

    https://github.com/iqra-khan0635/laravel-vue-task-crud.git

Go to the repository folder

    cd laravel-vue-task-crud

Install all the dependencies using composer

    composer install
    npm install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

Start the local development server

    npm run dev
    php artisan serve

You can now access the server at http://localhost:{port}

for Run the database test

    php artisan test
