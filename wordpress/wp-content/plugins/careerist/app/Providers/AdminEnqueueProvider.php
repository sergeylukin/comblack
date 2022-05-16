<?php namespace Careerist\Providers;

use Inc\Base\Enqueue;
use Careerist\Helpers\Path;
use Alias;

class AdminEnqueueProvider extends Provider {

  public function register() {

    $root = dirname(__DIR__, 2);

    // Register IOC records
    $this->App->singleton('AdminEnqueue', new Enqueue);


    // Register shortcut Alias
    Alias::add('AdminEnqueue', '\Careerist\Facades\AdminEnqueue');

  }

  public function unregister() {
    unset($this->App['AdminEnqueue']);
  }

}
