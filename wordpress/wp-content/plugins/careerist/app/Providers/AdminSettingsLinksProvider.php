<?php namespace Careerist\Providers;

use Inc\Base\SettingsLinks;
use Careerist\Helpers\Path;
use Alias;

class AdminSettingsLinksProvider extends Provider {

  public function register() {
    global $wpdb;

    // Register IOC recordsd
    $this->App->singleton('AdminSettingsLinks', new SettingsLinks($this->App, $wpdb));

    // Register shortcut Alias
    Alias::add('AdminSettingsLinks', '\Careerist\Facades\AdminSettingsLinks');

  }

  public function unregister() {
    unset($this->App['AdminSettingsLinks']);
  }

}
