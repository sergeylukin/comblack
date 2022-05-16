<?php namespace Careerist\Providers;

use Careerist\Core\ProviderLoader;

class ProviderLoaderProvider extends Provider {

  public function register() {

    $ProviderLoader = new ProviderLoader( $this->App );
    $ProviderLoader->register();

    $this->App->singleton('ProviderLoader', $ProviderLoader);

  }

  public function unregister() {

    $this->App->resolve('ProviderLoader')->unregister();

    unset($this->App['ProviderLoader']);

  }

}
