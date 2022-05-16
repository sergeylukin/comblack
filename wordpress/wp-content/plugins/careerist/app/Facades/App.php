<?php namespace Careerist\Facades;

class App extends Facade {

  /**
   * Just return the app
   *
   * @return string
   */
  protected static function getFacadeAccessor() { return static::getFacadeApplication(); }

}
