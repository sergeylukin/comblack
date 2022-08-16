<?php namespace Careerist\Providers;

use Alias;
use Careerist\Helpers\SyncEvent;

class SyncEventProvider extends Provider {

  public function register() {

    $SyncEvent = new SyncEvent($this->App['Database']);
    // Register IOC record
    $this->App->singleton('SyncEvent', $SyncEvent);

    // Register shortcut Alias
    Alias::add('SyncEvent', '\Careerist\Facades\SyncEvent');

  }

}
