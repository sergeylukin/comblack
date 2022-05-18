<?php namespace Careerist\Providers;

use Inc\Base\SyncJobController;
use Alias;

class SyncJobControllerProvider extends Provider {

  public function register() {
    global $wpdb;

    // Register IOC records
    $this->App->singleton('SyncJobController', new SyncJobController($this->App, $wpdb));


    // Register shortcut Alias
    Alias::add('SyncJobController', '\Careerist\Facades\SyncJobController');

  }

  public function unregister() {
    unset($this->App['SyncJobController']);
  }

}
