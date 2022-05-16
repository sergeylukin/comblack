<?php namespace Careerist\Providers;

use Inc\Pages\Dashboard;
use Careerist\Helpers\Path;
use Alias;

class AdminDashboardProvider extends Provider {

  public function register() {

    $root = dirname(__DIR__, 2);

		$instance = new Dashboard;
    $instance->register();

    // Register IOC records
    $this->App->singleton('AdminDashboard', $instance);


    // Register shortcut Alias
    Alias::add('AdminDashboard', '\Careerist\Facades\AdminDashboard');

  }

  public function unregister() {
    unset($this->App['AdminDashboard']);
  }

}
