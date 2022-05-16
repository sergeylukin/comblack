<?php namespace Careerist\Providers;

use Careerist\Helpers\Database;
use Alias;

class DatabaseProvider extends Provider {

  public function register() {

    global $wpdb;
    $Database = new Database($wpdb);

    $this->App->singleton('Database', $Database);
    // Register shortcut Alias
    Alias::add('Database', '\Careerist\Facades\Database');

  }

  public function unregister() {

    unset($this->App['Database']);

  }

}
