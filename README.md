
## Description
Address book in which you can add, edit and delete Address. 
You can also have an overview of all contacts.
The address book contain the following data:
* Firstname
* Lastname
* Street and number
* Zip
* City
* Country
* Phonenumber
* Birthday
* Email address
* Picture (optional)

## Installation

```
composer install
php bin/console doctrine:schema:update --force
bin/console doctrine:fixtures:load
```

### Tools
* Symfony 3.4
* Doctrine with SQLite
* Twig
* PHP 7.0

## Testing 
```
bin/console doctrine:schema:update --force --env=test
bin/console doctrine:fixtures:load --env=test
vendor/bin/simple-phpunit

```
