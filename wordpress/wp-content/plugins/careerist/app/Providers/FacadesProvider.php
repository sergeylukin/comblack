<?php namespace Careerist\Providers;

use Careerist\Facades\Facade;

class FacadesProvider extends Provider {

  public function register() {

    Facade::setFacadeApplication( $this->App );

  }

  public function unregister() {}

}
