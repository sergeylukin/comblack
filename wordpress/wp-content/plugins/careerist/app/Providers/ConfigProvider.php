<?php namespace Careerist\Providers;

use Alias;
use Careerist\Helpers\Config\Config;
use Careerist\Core\Filesystem\Filesystem;

class ConfigProvider extends Provider {

  public function register() {

    // Register IOC record
    $this->App->singleton('config', function($App) {
      // Instantiate config object
      $config = new Config( new Filesystem );

      // Fetch default configuration and environment-specific
      $path = $App['path'].'/config';
      $config->fetch( $path );

      return $config;
    });

    // Register shortcut Alias
    Alias::add('Config', '\Careerist\Facades\Config');

  }

  public function unregister() {
    unset($this->App['config']);
  }

}
