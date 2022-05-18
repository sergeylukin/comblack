<?php namespace Careerist\Providers;

use Inc\Base\JobEntityController;
use Careerist\Helpers\Path;
use Alias;

class JobEntityControllerProvider extends Provider {

  public function register() {
    global $wpdb;

    // Register IOC records
    $this->App->singleton('JobEntityController', new JobEntityController($this->App, $wpdb));


    // Register shortcut Alias
    Alias::add('JobEntityController', '\Careerist\Facades\JobEntityController');

  }

  public function unregister() {
    unset($this->App['JobEntityController']);
  }

}
