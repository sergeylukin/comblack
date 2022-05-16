<?php namespace Careerist\Providers;

use Inc\Base\SettingsLinks;
use Careerist\Helpers\Path;
use Alias;

class AdminSettingsLinksProvider extends Provider {

  public function register() {

    $root = dirname(__DIR__, 2);

		$instance = new SettingsLinks;
    $instance->register();

    // Register IOC records
    $this->App->singleton('AdminSettingsLinks', $instance);


    // Register shortcut Alias
    Alias::add('AdminSettingsLinks', '\Careerist\Facades\AdminSettingsLinks');

  }

  public function unregister() {
    unset($this->App['AdminSettingsLinks']);
  }

}
