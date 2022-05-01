# laravel-posts
test

1. Configure your .env file
2. 
```consoles
composer install
npm i
npm run dev
alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'
sail up -d
mkdir storage/app/public/posts
sail artisan storage:link
php artisan db:seed --class=PostSeeder
```