About this system :
Spare Parts Pricing System Using Laravel
The Spare Parts Pricing System is a Laravel-based application designed to manage the pricing of spare parts efficiently. It provides a structured approach to storing, calculating, and retrieving spare part prices using a dynamic pricing model.

Key Features:
Product Management – Add, edit, and manage spare parts with essential details like name, description
Dynamic Pricing – Automatically calculate the final price based on a base price and a markup percentage.
 Price History Tracking – Maintain historical price changes for better financial insights.
  – Store pricing data in different currencies to support global operations.
 API Integration – Expose endpoints to integrate with ERP systems or front-end applications.
 User-Friendly Interface – Display spare part details and prices seamlessly using Laravel Blade or external frontend frameworks.

this project is now only used for company that only work for najm for pricing spare parts . 









About Laravel
Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

Mrboji Project Setup
Prerequisites
Before setting up the Laravel project, ensure that your system meets the following requirements:

PHP (>= 8.0)
Composer (latest version)
MySQL or PostgreSQL database
Git (optional but recommended)
Installation Steps
1. Clone the Repository

cd mrboji
2. Install Dependencies
composer install
3. Set Up Environment File
cp .env.example .env
Modify the .env file with your database and other configurations.

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mrboji
DB_USERNAME=root
DB_PASSWORD=
4. Generate Application Key
php artisan key:generate
5. Run Database Migrations and Seeders (if any)
php artisan migrate --seed
It will create database and create default user for you Note: PleaseDon't forgot to change password

Admin: 
  email:    admin@admin.com
  password: password
 
Writer: 
  email:    writer@admin.com
  password: password
  
Pricing: 
  email:    pricing@admin.com
  password: password  
6. Set File Permissions (Linux/macOS only) if needed
chmod -R 775 storage bootstrap/cache
7. Start the Development Server
php artisan serve
8. Access the Application
Open your browser and navigate to:

http://127.0.0.1:8000
Additional Commands
Clear cache: php artisan cache:clear
View application logs: tail -f storage/logs/laravel.log
Run tests: php artisan test






System Requirements
The following are required to function properly.

PHP Version：PHP 8.2.12
Laravel Version：5.7.0
Apache/2.4.58
Composer version 2.7.5
mysqlnd 8.2.12
Features
Laravel 
Authentication MVC MODELS 
Installation
copy .env.example .env if you got any problem 
used admin LTE panel 
php artisan key:generate
php artisan storage:link

php artisan migrate:fresh –seed

server info :
Database server
Server: 127.0.0.1 via TCP/IP
Server type: MariaDB
Server connection: SSL is not being used Documentation
Server version: 10.4.32-MariaDB - mariadb.org binary distribution
Protocol version: 10
User: root@localhost
Server charset: UTF-8 Unicode (utf8mb4)
     
Web server
Apache/2.4.58 (Win64) OpenSSL/3.1.3 PHP/8.2.12
Database client version: libmysql - mysqlnd 8.2.12
Usage
Production
Composer Install
  composer install -Composer version 2.7.5

  * * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1

Development
Run artisan serve
  php artisan serve
  useful cli commands for projects
Set redis in local by windows (WSL2)
    REDIS_CLIENT=predis
    REDIS_HOST=localhost
    REDIS_PASSWORD=null no password requriments 
    REDIS_PORT=6379
If not install redis, please change .env
    CACHE_DRIVER="file"
    SESSION_DRIVER="file"
Clear and cache
optimize will clear and cache config, route, file

  php artisan optimize:clear
Directory Permissions
  chmod -R 777 storage bootstrap/cache
Storage Link
  php artisan storage:link
Migrate with seeder
  php artisan migrate:fresh --seed
Scribe
Scribe and Ide Helper Generator
  composer ide-helper-gen
Only Scribe Generator
  php artisan scribe:generate
how to open api document
run development php artisan serve
use browser open http://127.0.0.1:8000/docs
Feature Flags
Feature flags status
  php artisan feature:status
Turn on Feature Flags
  php artisan feature:feature {feature} --activate
  php artisan feature:feature {feature} --a
Turn off Feature Flags
  php artisan feature:feature {feature} --deactivate
  php artisan feature:feature {feature} --d
Sail
MySQL .env setting
    DB_HOST=mysql
    DB_PORT=3306
    DB_DATABASE="caring_deer"
    DB_USERNAME=sail
    DB_PASSWORD=password
Sail up
  ./vendor/bin/sail up
  ./vendor/bin/sail up -d
Sail down
  ./vendor/bin/sail down
Sidecar
Configure AWS Keys (Optional)
  php artisan sidecar:install
Deploy to AWS Lambda and activate(Note: This will deploy to AWS Lambda)
  php artisan sidecar:deploy --activate
Schedule event
Run Schedule (Need to add Crontab)
  php artisan schedule:run
Schedule List
  php artisan schedule:list
Queue
Run Queue
    php artisan queue:work --queue social,push
Rework Queue
    php artisan queue:restart





    Steps for Installation:
The first step is to extract the file.
Secondly cd to project folder
Thirdly ‘ composer install ‘
After ‘cp .env.example .env’
Sixthly ‘ php artisan key:generate ‘
then ” php artisan migrate “
After ” php artisan db:seed “
finally ” php artisan serve “

