<?php namespace Careerist\Providers;

use Careerist\Helpers\ErrorHandler;
use Careerist\Helpers\FatalErrorHandler;
use Logger;

class ErrorHandlerProvider extends Provider {

  private $fatal_error_handler;

  public function register() {

    // Handle all the PHP Errors like E_ERROR, E_NOTICE, E_NOTICE etc.
    set_error_handler(array('Careerist\Helpers\ErrorHandler', 'handle'));

    // Handle Fatal Errors
    $this->fatal_error_handler = new FatalErrorHandler;
    register_shutdown_function(array($this->fatal_error_handler, 'handle'));

    ini_set( "display_errors", "off" );
    error_reporting( E_ALL );

  }

  public function unregister() {
    restore_error_handler();
    $this->fatal_error_handler->unregister();
  }

}

