<?php

use Careerist\Core\Application;

/*
 |--------------------------------------------------------------------------
 | Register The Auto Loaders and Functions
 |--------------------------------------------------------------------------
 |
 | Bootstrap autoloaders and load functions so we do not have to worry
 | about the loading of any our classes "manually" and can use our helper
 | functions anywhere in the system. Feels great to relax.
 |
 */

require __DIR__ . '/autoload.php';



/*
 |--------------------------------------------------------------------------
 | Instantiate new Application
 |--------------------------------------------------------------------------
 |
 | This is the place where the real magic begins - core application class
 | is being initiated. Although there shouldn't be anything special in
 | it's contstructor, it's essential that we establish a base for everything
 | that will be "placed" on top of it during the application runtime
 |
 */

$App = new Application;

// If this file is in `/foo/bar/bootstrap/` then $App['project_name'] will be set to "bar"
$App['project_name'] = basename(dirname(dirname(__FILE__)));
$App['namespace'] = 'Careerist';



/*
 |--------------------------------------------------------------------------
 | Register Service Providers
 |--------------------------------------------------------------------------
 |
 | Service Providers exist to abstract Objects instantiation complexity and
 | to keep it in one place. So, for example if you have a database wrapper
 | instance used in multiple places, and you want to change the way it is
 | being instantiated, you only do it in relevant Service Provider.
 | Another benefit is that if your database wrapper should be replaced
 | (for testing purposes or permanently) the only thing you would do is
 | you would replace it's registering below with the new Service Provider.
 |
 | The convention is that the name of Provider Class consists of Class name
 | plus "Provider" suffix. Also Provider Classes are defined in namespace
 | "\Providers"
 |
 */

$App->registerProviders(array(

  /*
   | This provider registers fatal and other PHP errors handler
   |
   */

  'ErrorHandlerProvider',


  /*
   | This provider will make sure that Facades retrieve corresponding
   | items from IOC when they are called
   |
   */

  'FacadesProvider',


  /*
   | This provider registers an spl autoloader for all the aliases
   | used in our app. An Alias can be registered
   | via $App->registerAlias('Alias', '\Full\Namespace\To\Class');
   |
   */

  'AliasLoaderProvider',


  /*
   | This provider does the magic when you, let's say call Input::get('foo')
   | It checks if Input class does not exist but there is a InputProvider
   | class then it registers the InputProvider and then if InputProvider
   | registered an alias Input then it will be catched by Alias Loader and
   | an instance of Input class will be returned
   |
   */

  'ProviderLoaderProvider',


  /*
   | Here we are registering the paths configured in paths.php to the app. You
   | should not be changing these here. If you need to change these you
   | may do so within the paths.php file
   |
   */

  'PathsProvider',

  'LoggerProvider',

));



/*
 | Register a shortcut for Bench library
 | It provides shorter way of working
 | with metrics
 |
 | So after this line is executed you can
 | do Bench::dump() instead of
 | App::resolve('Bench')->dump()
 | or $App->Bench->dump()
 |
 */
Alias::add('Bench', '\Careerist\Facades\Bench');



/*
 | Record the time/resources consumed while core
 | components like Errors handlers, Paths and Alias
 | providers etc. were initialized
 |
 */

Bench::mark('Load core providers');



$App->registerProviders(array(


  'AdamAPIProvider',
  /*
   | Reads configuration, and registers `Config` alias
   |
   */

  'ConfigProvider',


  /*
   | DB abstraction
   |
   */

  'DatabaseProvider',

  /*
   | CSV exporter
   |
   */

  'CSVProvider',


));

Bench::mark('Load Config/Database providers');



/*
 | Additionally load translate UI related providers
 | only if environment is set to translate locales
 |
 */
$App->registerProviders(array(

  /*
   | Holds activation/deactivation business logic
   |
   */

  'PluginProvider',

));

Bench::mark('Load app specific providers');



return $App;
