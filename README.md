
## Installation

nvm 18.17.1
php 8.2.18

`Laravel`
1. Clone the repository
2. Copy the `.env.example` file to `.env`:
3. Set database and emails (mailtrap.io) settings inside `.env`
4. Run `composer install`
5. Run `npm install && npm run build`
6. Run `php artisan key:generate`
7. run `php artisan storage:link`
8. Run `php artisan migrate --seed` 
9. Run `php artisan serve`
10. Moderator permissions -> after registration first user (admin), 
    go to Settings -> Roles -> Edit Moderator role (check View dashboard, View categories 
    & View Products)

`Next`
1. Next starter kit is in client directory
2. cd client -> npm install && npm run dev

