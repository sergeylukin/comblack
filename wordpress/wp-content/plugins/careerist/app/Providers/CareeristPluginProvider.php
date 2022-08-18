<?php namespace Careerist\Providers;

use Alias;
use Careerist\Helpers\CareeristPlugin;
use AdminDashboard;
use AdminEnqueue;
use AdminSettingsLinks;
use JobEntityController;
use JobAreaEntityController;
use JobCategoryEntityController;

class CareeristPluginProvider extends Provider {

  public function register() {

    $CareeristPlugin = new CareeristPlugin($this->App['Database'], $this->App['Logger']);
    // Register IOC record
    $this->App->singleton('CareeristPlugin', $CareeristPlugin);

    AdminDashboard::register();
    AdminEnqueue::register();
    AdminSettingsLinks::register();

		JobEntityController::register();
		JobAreaEntityController::register();
		JobCategoryEntityController::register();

    // Register shortcut Alias
    Alias::add('CareeristPlugin', '\Careerist\Facades\CareeristPlugin');

  }

  public function unregister() {
    unset($this->App['CareeristPlugin']);
  }

}
