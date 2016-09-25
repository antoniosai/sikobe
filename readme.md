# SIKOBE powered by Laravel PHP Framework

[![Build Status](https://travis-ci.org/laravel/framework.svg)](https://travis-ci.org/laravel/framework)
[![Total Downloads](https://poser.pugx.org/laravel/framework/d/total.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/framework/v/stable.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Unstable Version](https://poser.pugx.org/laravel/framework/v/unstable.svg)](https://packagist.org/packages/laravel/framework)
[![License](https://poser.pugx.org/laravel/framework/license.svg)](https://packagist.org/packages/laravel/framework)

### Installation

- PHP version please refer to Laravel 5.3 installation doc.
- Install Node.js (so you can use the "npm" command)

Steps required :

1) Do clone this repository.

2) Download the Composer : https://getcomposer.org/download/1.2.1/composer.phar , and place inside this app directory.

3) Copy the ".env.example" to ".env", then define the :
   - APP_URL : example http://sikobe.local.dev
   - APP_DOMAIN : example sikobe.local.dev
   - API_DOMAIN : example http://api.sikobe.local.dev
   - and all database iinformation

4) Run "php composer.phar install" inside this app directory.

5) Run "npm install" inside this app directory.

6) Create a new database, then import the "/SQL/2016-09-26-init_tables.sql".

### HTML Theme
Download here : https://dl.dropboxusercontent.com/u/1550865/metronic-theme.tar.gz

Use the HTML files inside "admin_1_material_design" folder for referrences.


### Test the REST API
Use Postman Google Chrome extension. Import the "SIKOBE.postman_collection.json".


### Updating database schema
Create a new file inside the "/SQL/" folder provided, each time you update database schema, to make sure all contributors here having the same schema as you are. Use following format "/SQL/yyyy-mm-dd-<table_name>-<your_username>.sql"


### Customizing the CSS

#### I. Backend
Only add your custom CSS to "/resources/asssets/sass/layouts/layout/custom.scss".

#### II. Frontend
Only add your custom CSS to "/resources/asssets/sass/layouts/layout/front-custom.scss".

#### III. Compile
After you modify the scss, run "gulp" in this app directory.
```sh
$ cd sikobe
$ gulp
```


## License

This application is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
