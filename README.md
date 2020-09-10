Please read README file

1. on command line 

composer install

2. then .env.example rename to .env

3. In the .env file rename

DB name -> task_laravel

user -> root

password -> root

4. then on command line

php artisan make migrate

php artisan db:seed
