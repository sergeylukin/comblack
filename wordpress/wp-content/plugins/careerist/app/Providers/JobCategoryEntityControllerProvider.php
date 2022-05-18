<?php namespace Careerist\Providers;

use Inc\Base\JobCategoryEntityController;
use Careerist\Helpers\Path;
use Alias;

class JobCategoryEntityControllerProvider extends Provider {

  public function register() {
    global $wpdb;

    // Register IOC records
    $this->App->singleton('JobCategoryEntityController', new JobCategoryEntityController($this->App, $wpdb));


    // Register shortcut Alias
    Alias::add('JobCategoryEntityController', '\Careerist\Facades\JobCategoryEntityController');

  }

  public function unregister() {
    unset($this->App['JobCategoryEntityController']);
  }

}
