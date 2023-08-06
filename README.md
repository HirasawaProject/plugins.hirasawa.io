# Hirasawa Plugin Repository
The code powering plugins.hirasawa.io

# Setup
Setting up this project is very similar any other Laravel project
* `git clone https://github.com/HirasawaProject/plugins.hirasawa.io.git`
* `cp .env.example .env`
* Setup database credentials in `.env`
* `php artisan key:generate`
* `php artisan migrate`
* `php artisan db:seed` - For standard values
* `php artisan db:seed --class=DevelopmentSeeder` - For development data

When you run the development seeder you also generate an admin account with the email `admin@hirasawa.io` and password `admin`