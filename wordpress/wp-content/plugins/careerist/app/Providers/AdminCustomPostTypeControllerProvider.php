<?php namespace Careerist\Providers;

use Inc\Base\CustomPostTypeController;
use Careerist\Helpers\Path;
use Alias;

class AdminCustomPostTypeControllerProvider extends Provider {

  public function register() {

    $root = dirname(__DIR__, 2);

		$instance = new CustomPostTypeController;
    $instance->register();

    // Register IOC records
    $this->App->singleton('AdminCustomPostTypeController', $instance);


    // Register shortcut Alias
    Alias::add('AdminCustomPostTypeController', '\Careerist\Facades\AdminCustomPostTypeController');

  }

  public function unregister() {
    unset($this->App['AdminCustomPostTypeController']);
  }

}
