<?php namespace Careerist\Providers;

use Careerist\Core\AliasLoader;

class AliasLoaderProvider extends Provider {

  public function register() {

    $AliasLoader = new AliasLoader;
    $AliasLoader->register();

    $this->App->singleton('Alias', $AliasLoader);
    $AliasLoader->add('Alias', '\Careerist\Facades\Alias');

  }

  public function unregister() {

    $this->App->resolve('Alias')->unregister();

    unset($this->App['Alias']);

  }

}
