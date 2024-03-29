<?php namespace Careerist\Providers;

use Alias;
use Requests_Session as Http;
use Careerist\Helpers\AdamAPI;

class AdamAPIProvider extends Provider {

  public function register() {

    // Register IOC record
    $AdamAPI = new AdamAPI(new Http);
    if (defined('WP_DEBUG') && WP_DEBUG === true) {
      $AdamAPI->useMocks();
    }
    $this->App->register('AdamAPI', $AdamAPI);

    // Register shortcut Alias
    Alias::add('AdamAPI', '\Careerist\Facades\AdamAPI');

  }

}
