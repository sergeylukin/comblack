<?php namespace Careerist\Providers;

use Alias;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\SlackHandler;
use Monolog\Handler\FirePHPHandler;
use Config;

class LoggerProvider extends Provider {

  public function register() {

    // Register IOC record
    $this->App->singleton('Logger', function($App) {

      try {
        $path = $App['path.logs'];
      } catch(\Exception $e) {
        $path = '/tmp/';
      }
      $log = new Logger('main');
      $log->pushHandler(new StreamHandler($path.'/main.log', Logger::WARNING));

      // Add extra stuff like IP, HOST, REFERER, etc.
      $log->pushProcessor(new \Monolog\Processor\WebProcessor);

      return $log;

    });

    // Register shortcut Alias
    Alias::add('Logger', '\Careerist\Facades\Logger');

  }

}
