## Loan Client Test

Client interface implement to work with mini-loan-system api https://github.com/raksa/mini-loan-sytem

## Contributors

* raksa <eng.raksa@gmail.com>

## Install Dependencies for Development
* `$ composer install`
* `$ npm install`
* `$ npm run dev`

## Install Dependencies for Production
* `$ composer install --no-dev`
* `$ npm install`
* `$ npm run dev`

## Migrate Database for very first time (after create database time)
attention: this will remove everything in database
* `$ php artisan migrate:fresh --seed`

## Migrate Database for updating and apply change
this can be run every updating code time
* `$ php artisan migrate`

## Configuration

All required environment variables can be found in .env.example

## License

MIT

## TODO
* change remarks to WYSIWYG html
* access control
* test case
