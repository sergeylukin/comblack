<?php namespace Careerist\Providers;

use Alias;
use Careerist\Helpers\Plugin;
use AdminDashboard;
use AdminEnqueue;
use AdminSettingsLinks;
use JobEntityController;
use JobAreaEntityController;
use JobCategoryEntityController;

class PluginProvider extends Provider {

  public function register() {

    $Plugin = new Plugin($this->App['Database'], $this->App['Logger']);
    // Register IOC record
    $this->App->singleton('Plugin', $Plugin);

    AdminDashboard::register();
    AdminEnqueue::register();
    AdminSettingsLinks::register();

		JobEntityController::register();
		JobAreaEntityController::register();
		JobCategoryEntityController::register();

    // Register shortcut Alias
    Alias::add('Plugin', '\Careerist\Facades\Plugin');

  }

  public function unregister() {
    unset($this->App['Plugin']);
  }

}
