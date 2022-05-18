<?php namespace Careerist\Providers;

use Inc\Pages\Dashboard;
use Careerist\Helpers\Path;
use Alias;

class AdminDashboardProvider extends Provider {

  public function register() {
    global $wpdb;

    // Register IOC records
    $this->App->singleton('AdminDashboard', new Dashboard($this->App, $wpdb));


    // Register shortcut Alias
    Alias::add('AdminDashboard', '\Careerist\Facades\AdminDashboard');

  }

  public function unregister() {
    unset($this->App['AdminDashboard']);
  }

}
