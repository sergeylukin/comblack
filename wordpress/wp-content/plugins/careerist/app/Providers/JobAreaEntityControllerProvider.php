<?php namespace Careerist\Providers;

use Inc\Base\JobAreaEntityController;
use Careerist\Helpers\Path;
use Alias;

class JobAreaEntityControllerProvider extends Provider {

  public function register() {

    // Register IOC records
    $this->App->singleton('JobAreaEntityController', new JobAreaEntityController);


    // Register shortcut Alias
    Alias::add('JobAreaEntityController', '\Careerist\Facades\JobAreaEntityController');

  }

  public function unregister() {
    unset($this->App['JobAreaEntityController']);
  }

}
