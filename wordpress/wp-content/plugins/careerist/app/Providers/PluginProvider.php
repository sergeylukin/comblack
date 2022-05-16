<?php namespace Careerist\Providers;

use Alias;
use Careerist\Helpers\Plugin;

class PluginProvider extends Provider {

  public function register() {

    $Plugin = new Plugin($this->App['Database'], $this->App['Logger']);
    // Register IOC record
    $this->App->singleton('Plugin', $Plugin);

    // Register shortcut Alias
    Alias::add('Plugin', '\Careerist\Facades\Plugin');

  }

  public function unregister() {
    unset($this->App['Plugin']);
  }

}
