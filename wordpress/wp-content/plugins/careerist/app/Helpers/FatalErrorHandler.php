<?php namespace Careerist\Helpers;

use Careerist\Helpers\ErrorHandler;

class FatalErrorHandler {

  /**
   * Callback to be executed by the shutdown function
   * @var callble $callback
   */
  private $callback;
  
  public function __construct() {
    $this->set_callback();
  }

  private function set_callback() {
    $this->callback = function() {
      $error = error_get_last();

      if( is_array($error) )
      {
        $code     = $error['type'];
        $message  = $error['message'];
        $file     = $error['file'];
        $line     = $error['line'];

        ErrorHandler::handle( $code, $message, $file, $line );
      }
    };
  }

  /**
   * Unregister the callback
   */
  public function unregister() {
    $this->callback = null;
  }

  /**
   * Executed by the register_shutdown_function
   */
  public function handle() {
    if( $this->callback)
    {
      $callback = $this->callback;
      $callback();
    }
  }
}
