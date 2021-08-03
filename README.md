# PrimeXConnectTest

----------

## Installation

### Back-end

Clone the repository

    git clone git@github.com:AnkiPurohit/PrimeXConnectTest.git

Switch to the repo folder

    cd primx-test

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes (DB CONNECTION configs) in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate
    
Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

### Front-end

Install all the dependencies using Node Package Manager

    npm install

Build Front-end by running one og the below

    npm run build 
    npm run prod
    
### e2e Cypress API Tests

Provide login user credentials to support login command. Best practice is to runtime register a user and set the credentials into Cypress enviroment variables. However, for the test purpose, I have put it under `cypress/common.js` file.

    export const LOGIN_DATA = {
        'username': 'test@test.com',
        'password': '123456'
    };


Open cypress by running the command below. 

    ./node_modules/.bin/cypress open
    

### API Documentation

I have added swagger documentation for the APIs. I have used https://github.com/DarkaOnLine/L5-Swagger to document the API endpoints. The json documentation can be found under `/storage/api-docs/` . You can utilise online swagger editor to import the file and view the documentation. It can be configured on site via changing `config/l5-swagger.php` file. 


#### Note that, Regarding Tests and documentation, I have not covered all the endpoints due to time constraints. By writing some important ones, I have tried to showcase the best practice and my knowledge
