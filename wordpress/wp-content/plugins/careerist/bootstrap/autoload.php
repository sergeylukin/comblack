<?php

/*
 |--------------------------------------------------------------------------
 | Register The Composer Auto Loader
 |--------------------------------------------------------------------------
 |
 | Composer provides a convenient, automatically generated class loader
 | for our application. We just need to utilize it! We'll require it
 | into the script here so that we do not have to worry about the
 | loading of any our classes "manually". Feels great to relax.
 |
 */

require __DIR__ . '/../vendor/autoload.php';

/*
 |--------------------------------------------------------------------------
 | Load helper functions
 |--------------------------------------------------------------------------
 |
 | There is always some functionality you wanted PHP would have built in
 | Here we load files that contain some useful utility functions to
 | manipulate arrays, strings and even provide nicer API for some basic
 | internals of our Application
 |
 */

if( file_exists( __DIR__ . '/../app/functions.php') ) {
  require __DIR__ . '/../app/functions.php';
}
