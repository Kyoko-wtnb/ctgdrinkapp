# CTG Drink App

This is an web application for Dept. Complex Trait Genetics to track Friday drinks.
The application is build on [Laravel PHP framework](http://laravel.com/docs) (v5.2.45).

## Application structure
A Laravel project directory has the following structure.
Only important directories/files are shown.
```
ctgdrinkapp
|--app
  |--Http
    |--Controllers
	  |-- XXXController.php # back end controller
	|--routes.php
|--bootstrap
|--config
|--database
  |--migrations
    |-- XXX.php # database schema
  |-- database.sql # this is not included in the git but this file is the actual database
|--public
  |--image
  |--css
  |--js # all javasripts are storead here
|--resources
  |--view # all UI (HTML) are defined in this directory
    |--layout
	  |--master.blade.php # layout of the page
	|--includes
	  |--head.blade.php
	  |--header.blade.php
	|--pages
	  |--xxx.blade.php # each page is defined in this php file
|--storage
|--test
```

## Contribution

CTG members are free to contribute to this code.
There is only one rule to keep in mind, please make a pull request to the dev branch rather than direct to the master branch.

Developed by Kyoko Watanabe, 6 June 2018
