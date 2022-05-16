<?php namespace Careerist\Helpers;

use Logger;
use Careerist\Helpers\ExceptionHandler;
use ErrorException;

class ErrorHandler {
  public static function handle( $code, $message, $file, $line, $context = array() ) {
    $level = self::getCodename($code);

    $description = sprintf(
      '%s raised in file %s at line %d with message "%s"',
      $level ? sprintf('Error of type %s', $level)
             : sprintf('Unknown error level with code %s', $code),
      $file,
      $line,
      $message
    );

    ExceptionHandler::handle( new ErrorException($message, $code, 1, $file, $line), $description );
  }

  public static function getCodename($code) {
    $codename = '';

    switch ($code) {
      case E_ERROR:
        $codename = 'E_ERROR';
        break;
      case E_PARSE:
        $codename = 'E_PARSE';
        break;
      case E_CORE_ERROR:
        $codename = 'E_CORE_ERROR';
        break;
      case E_COMPILE_ERROR:
        $codename = 'E_COMPILE_ERROR';
        break;
      case E_USER_ERROR:
        $codename = 'E_USER_ERROR';
        break;
      case E_RECOVERABLE_ERROR:
        $codename = 'E_RECOVERABLE_ERROR';
        break;
      case E_WARNING:
        $codename = 'E_WARNING';
        break;
      case E_CORE_WARNING:
        $codename = 'E_CORE_WARNING';
        break;
      case E_COMPILE_WARNING:
        $codename = 'E_COMPILE_WARNING';
        break;
      case E_USER_WARNING:
        $codename = 'E_USER_WARNING';
        break;
      case E_STRICT:
        $codename = 'E_STRICT';
        break;
      case E_DEPRECATED:
        $codename = 'E_DEPRECATED';
        break;
      case E_USER_DEPRECATED:
        $codename = 'E_USER_DEPRECATED';
        break;
      case E_NOTICE:
        $codename = 'E_NOTICE';
        break;
      case E_USER_NOTICE:
        $codename = 'E_USER_NOTICE';
        break;
    }
    return $codename;
  }
}
