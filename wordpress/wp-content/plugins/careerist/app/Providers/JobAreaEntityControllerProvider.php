<?php namespace Careerist\Providers;

use Inc\Base\JobAreaEntityController;
use Careerist\Helpers\Path;
use Alias;

class JobAreaEntityControllerProvider extends Provider {

  public function register() {
    global $wpdb;

    // Register IOC records
    $this->App->singleton('JobAreaEntityController', new JobAreaEntityController($this->App, $wpdb));


    // Register shortcut Alias
    Alias::add('JobAreaEntityController', '\Careerist\Facades\JobAreaEntityController');

  }

  public function unregister() {
    unset($this->App['JobAreaEntityController']);
  }

}
