//installing the laravel installer
composer global require laravel/installer

create new laravel project
laravel new projectName

when you clone my project, run these commands:
git clone https://github.com/gnongkynrih/sample-website.git
or

git clone https://github.com/gnongkynrih/fullstack-2026

cp .env.example .env //rename the .env.example file to .env
php artisan key:generate //generate the project key

composer install
npm install
npm run dev

//to use the storage for uploads
php artisan storage:link

//create your database
create database database_name

configure the database in the .env file
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=database_name
DB_USERNAME=root
DB_PASSWORD=your_password

test your database connection with
php artisan migrate

//if during testing you want to reset the database
php artisan migrate:fresh //will drop and recreate all the tables

//if you want to rollback the last migration
php artisan migrate:rollback

//we can test with dummy data by using factories
//generate dummy data for Post model
//but your model must use HasFactory
php artisan make:factory PostFactory

//to make use of the factory we create a seeder
php artisan make:seeder PostsTableSeeder

//to execute the seeder
php artisan db:seed --class=PostsTableSeeder

//if you want to seed the database with test data
php artisan db:seed

//for testing email functionality
we use mailpit or mailhog

//install it first
https://github.com/mailhog/MailHog

//then in your .env file
MAIL_MAILER=smtp
MAIL_HOST=127.0.0.1
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

//to run the smtp server
mailhog or mailpit
the smtp server will run on port 1025
in your browser go to http://127.0.0.1:8025

//setup the roles and permissions
https://spatie.be/docs/laravel-permission/v7/basic-usage/basic-usage

//first install the package
composer require spatie/laravel-permission

//then publish the migration
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"

//then run the migration
php artisan migrate

//then seed the database
php artisan db:seed --class=RolePermissionSeeder

//for the ui components
use mary-ui
https://mary-ui.com/docs/installation

//install mary-ui
composer require robsontenorio/mary
php artisan mary:install

//to export to pdf
composer require barryvdh/laravel-dompdf

//to export to excel
composer require maatwebsite/excel

//to generate charts, i use chart.js
//https://www.chartjs.org/docs/latest/getting-started/installation.html

to store image in storage folder, use the following command:
php artisan storage:link

install quill ide
npm install quill@2.0.3
npm run build

in your resources/app.js
import Quill from "quill";
window.Quill = Quill;

npm install animate.css --save
import 'animate.css'; in resources/app.css
