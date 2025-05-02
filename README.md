# Base App

Base app for Laravel Framework.
Last updated at 10 Aug 2021

# Setup

1. [initiate](https://github.com/saravanan-nichi-in/backend-bootstrap#initiate)
2. [Coding Style](https://github.com/saravanan-nichi-in/backend-bootstrap#coding-style)
3. [Coding Scan](https://github.com/saravanan-nichi-in/backend-bootstrap#coding-style)
4. [Testing](https://github.com/saravanan-nichi-in/backend-bootstrap#testing)

# Features

1. [Repository Pattern](https://github.com/saravanan-nichi-in/backend-bootstrap#repository-pattern)
2. [Queue](https://github.com/saravanan-nichi-in/backend-bootstrap#queue)
3. [Mail](https://github.com/saravanan-nichi-in/backend-bootstrap#mail)
4. [Facades](https://github.com/saravanan-nichi-in/backend-bootstrap#facades)
5. [Export](https://github.com/saravanan-nichi-in/backend-bootstrap#export)
6. [Telescope](https://github.com/saravanan-nichi-in/backend-bootstrap#telescope)

# References

1. [Coding Rule](https://github.com/saravanan-nichi-in/backend-bootstrap#coding-rule)
2. [Observer](https://laravel.com/docs/8.x/eloquent#observers)
3. [Resource](https://laravel.com/docs/8.x/eloquent-resources)
4. [Logging](https://laravel.com/docs/8.x/logging)
5. [Localization](https://laravel.com/docs/8.x/localization)

## Initiate

Please follow the below steps

1. Install third party packages from composer.json

```sh
composer update
```

2. Create .env

```sh
cp .env.example .env
```

3. Create database (base) and change the DB details in .env file

```
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=base
DB_USERNAME=your_db_username
DB_PASSWORD=your_db_password
```

4. Generate application key

```
php artisan key:generate
```

5. Migrate and seed database using

```sh
php artisan migrate --seed
```

6. Generate API Documentation

```sh
php artisan l5-swagger:generate
```

7. Access Swagger

```sh
url = {APP_URL}/api/documentation
```

8. Run artisan command to get Client ID and Client Secret

```sh
php artisan passport:install
```

Copy Password grant Client ID and Client Secret and store in secure place.

9. Click Authorize button and feed given below inputs

```sh
// Admin Credentials
username = admin@gmail.com
password = Base@321

// Business Credentials
username = user@gmail.com
password = Base@321

Client ID = We copied from the previous step
Client Secret = We copied from the previous step
```

10. Create database (base_testing) and change the DB details in .env.testing file

```sh
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=base_testing
DB_USERNAME=your_db_username
DB_PASSWORD=your_db_password
```

11. Use command php artisan module:make table model --migration --section=Section

```sh
table = posts ( Plural )
model = Post ( Singular )
Section = Admin or Business ( Singular )
```

12. Run PHPUnit Testing

```sh
vendor/bin/phpunit
```

13. Coding Standard as per PHP Code Sniffer, run this code in root folder

```sh
vendor/bin/phpcs --standard=PSR12 app
```

14. Coding scan completed as per PHP Stan, run this code in root folder

```sh
vendor/bin/phpstan analyse app
```
