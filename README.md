# Laravel Online Shop

Built in Laravel 5.5.42 and using OpenPay, I created this in summer vacation when I was just starting to get better at understanding and using Laravel. This still needs a lot of improvement. There is hard coded parts and missing PHP Doc annotations. I will keep improving it, though.

### Prerequisites
- PHP 5.6+
- PHP Composer
- NPM 
- OpenPay Sandbox/Production Mode

### Installing

You just have to clone the repo, run composer and npm, create a new .ENV file duplicating .ENV.EXAMPLE file, run Laravel migrations and you're good to go. 

Install composer dependencies
```
composer install
composer update
```

Install npm dependencies
```
cd public
npm install
```


Then, duplicate .env.example file and rename it as .env 
Open it and configure it.
```
cp .env.example .env
```

Generate application key
```
php artisan key:generate
```

Finlly, run 
```
php artisan migrate
```

## Built With

* [Laravel 5.4.30](https://laravel.com/docs/5.4) - The web framework used

## Authors

* **Carlos Eli Lopez** - *Initial work* - [Serveix](https://github.com/Serveix)
