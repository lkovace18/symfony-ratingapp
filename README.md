[![Build Status](https://img.shields.io/travis/lkovace18/symfony-ratingapp/master.svg?style=flat-square)](https://travis-ci.org/lkovace18/symfony-ratingapp/)
[![StyleCI](https://styleci.io/repos/91046493/shield)](https://styleci.io/repos/91046493)

Rate Application
========================

* Rate web page with js code snippet. 
* Api endpoints for voting and getting data for current web page.


## Documentation

### Installation

- clone project
- configure database and mailer in `app/config/parameters.yml`
- run commands from application root directory
```bash
    composer install
    php bin/console doctrine:database:create
    php bin/console doctrine:schema:create
```

- for start dummy data run command from application root directory
```bash
    php bin/console doctrine:fixtures:load
```
 

### Running Tests

- run commands from application root directory
```bash
    php bin/console doctrine:database:create --env=test
    php bin//console doctrine:schema:create --env=test
    phpunit
```


### Edditing JS
- run command from application root directory
```bash
    npm install or yarn
```

- for development run command 
```bash
    npm run watch or yarn run watch 
```

- for production run command 
```bash
    npm run production or yarn run production 
```


### Api
if application is installed you can visit http://<your-site>/api/doc for more information

basic information

#### POST /rating/

Request
```json
    {
      data: {
        uri: "some_uri",
      }
    }
```

Success response - status code 200
```json
    {
      status: "success",
      data: {
          uri: "some_uri",
          score: 4.12  
      }
    }
```

Faliure response - status code 400
```json
    {
      status: "faliure",
      errors: {
            /* list of errors */
      }
    }
```

#### POST /rating/vote

Request
```json
    {
      data: {
        visitor_id: "some_visitor_id",
        uri: "some_uri",
        rating: 3
      }
    }
```

Success response - status code 200
```json
    {
      status: "success",
      data: {
          uri: "some_uri",
          rating: 3,
          score: 4.12  
      }
    }
```

Faliure response - status code 400
```json
    {
      status: "faliure",
      errors: {
            /* list of errors */
      }
    }
```

Whats next
--------------

Roadmap:

  * optimize tests

  * add console command to purge unraded sites (cron)

  * add api option for getting domain rating based on domain page ratings;

  * add api option for getting visitor site ratings;

  * refactor widget js ( visitors can change mind )


## License

Symfony rating-app is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
