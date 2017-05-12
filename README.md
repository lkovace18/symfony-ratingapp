[![Build Status](https://img.shields.io/travis/lkovace18/symfony-ratingapp/master.svg?style=flat-square)](https://travis-ci.org/lkovace18/symfony-ratingapp/)
[![StyleCI](https://styleci.io/repos/91046493/shield)](https://styleci.io/repos/91046493)

Rating Application
========================

* Rate web page with js code snippet. 
* Api endpoints for voting and getting data for current web page.


## Documentation

### Installation

- Clone project
- Configure database and mailer in  `app/config/parameters.yml`
- Run commands from application root directory
```bash
    composer install
    php bin/console doctrine:database:create
    php bin/console doctrine:schema:create
```

- You can add dummy data, run command from application root directory
```bash
    php bin/console doctrine:fixtures:load
```
 

### Running Tests

- Run commands from application root directory
```bash
    php bin/console doctrine:database:create --env=test
    php bin//console doctrine:schema:create --env=test
    phpunit
```


### Editing JS
- Run command from application root directory
```bash
    npm install or yarn
```

- For development run command
```bash
    npm run watch or yarn run watch 
```

- For production run command
```bash
    npm run production or yarn run production 
```


### API
If application is installed you can visit `http://{your-site}/api/doc` for more information

Basic information

#### POST /rating/

Request
```json
    {
      'data': {
        'uri': "some_uri",
      }
    }
```

Success response - status code 200
```json
    {
      'status': "success",
      'data': {
          'uri': "some_uri",
          'score': 4.12  
      }
    }
```

Failure response - status code 400
```json
    {
      'status': "failure",
        'errors': {
          'validation': {
              'field-name': 'validation-error-message',
          }
      }
    }
```

#### POST /rating/vote

Request
```json
    {
      'data': {
        'visitor_id': "some_visitor_id",
        'uri': "some_uri",
        'rating': 3
      }
    }
```

Success response - status code 200
```json
    {
      'status': 'success',
      'data': {
          'uri': 'some_uri',
          'rating': 3,
          'score': 4.12  
      }
    }
```

Failure response - status code 400
```json
    {
      'status': 'failure',
      'errors': {
        'validation': {
            'field-name': 'validation-error-message',
        }
      }
    }
```

What's next
--------------

Roadmap:

  * Optimize tests
   
  *  Add Dusk for functional tests ( https://gist.github.com/kbond/bf86368e46090fb2ffaec0e5cbe91ea8 )

  * Add console command to purge unrated sites (cron)

  * add API option for getting domain rating based on domain page ratings

  * add API option for getting visitor site ratings

  * Refactor widget js ( visitors can change mind )


## License

Symfony rating-app is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
