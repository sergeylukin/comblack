<?php namespace Careerist\Providers;

use Alias;
use Careerist\Helpers\CSV;

class CSVProvider extends Provider {

  public function register() {
    // Register IOC records
    $this->App->singleton('CSV', new CSV);

    // Register shortcut Alias
    Alias::add('CSV', '\Careerist\Facades\CSV');

  }

  public function unregister() {
    unset($this->App['CSV']);
  }

}
