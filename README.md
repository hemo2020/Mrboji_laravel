## About Laravel
done by ibrahim bashmmakh 0507986759

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

# Mrboji Project Setup

## Prerequisites
Before setting up the Laravel project, ensure that your system meets the following requirements:

- PHP (>= 8.0)
- Composer (latest version)
- MySQL or PostgreSQL database
- Git (optional but recommended)

## Installation Steps

### 1. Clone the Repository
```sh

cd mrboji
```

### 2. Install Dependencies
```sh
composer install
```

### 3. Set Up Environment File
```sh
cp .env.example .env
```
Modify the `.env` file with your database and other configurations.
```sh
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mrboji
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Generate Application Key
```sh
php artisan key:generate
```

### 5. Run Database Migrations and Seeders (if any)
```sh
php artisan migrate --seed
```
It will create database and create default user for you
Note: PleaseDon't forgot to change password
```sh
Admin: 
  email:    admin@admin.com
  password: password
 
Writer: 
  email:    writer@admin.com
  password: password
  
Pricing: 
  email:    pricing@admin.com
  password: password  
```

### 6. Set File Permissions (Linux/macOS only) if needed
```sh
chmod -R 775 storage bootstrap/cache
```

### 7. Start the Development Server
```sh
php artisan serve
```

### 8. Access the Application
Open your browser and navigate to:
```
http://127.0.0.1:8000
```

## Additional Commands
- Clear cache: `php artisan cache:clear`
- View application logs: `tail -f storage/logs/laravel.log`
- Run tests: `php artisan test`
