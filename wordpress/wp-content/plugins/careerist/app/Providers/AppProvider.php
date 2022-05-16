<?php namespace Careerist\Providers;

use Alias;

class AppProvider extends Provider {

  public function register() {

    // Register shortcut Alias
    Alias::add('App', '\Careerist\Facades\App');

  }

}
