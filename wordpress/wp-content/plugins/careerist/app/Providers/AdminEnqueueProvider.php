<?php namespace Careerist\Providers;

use Inc\Base\Enqueue;
use Careerist\Helpers\Path;
use Alias;

class AdminEnqueueProvider extends Provider {

  public function register() {

    $root = dirname(__DIR__, 2);

		$instance = new Enqueue;
    $instance->register();

    // Register IOC records
    $this->App->singleton('AdminEnqueue', $instance);


    // Register shortcut Alias
    Alias::add('AdminEnqueue', '\Careerist\Facades\AdminEnqueue');

  }

  public function unregister() {
    unset($this->App['AdminEnqueue']);
  }

}
