<?php namespace Careerist\Providers;

abstract class Provider {
 /**
  * The application instance.
  *
  * @var \Core\Application
  */
  protected $App;

  /**
   * Create a new service provider instance.
   *
   * @param  \Core\Application  $app
   * @return void
   */
  public function __construct($App)
  {
    $this->App = $App;
  }

  /**
   * Register the service provider.
   *
   * @return void
   */
  abstract public function register();

  /**
   * Unregister the service provider.
   * By default takes the class name strips
   * the "Provider" part and removes this item
   * from IOC
   *
   * For example, for InputProvider class
   * $App['Input'] will be unset
   *
   * @return void
   */
  public function unregister() {
    $classname = get_class($this);
    if (preg_match('@\\\\([\w]+)$@', $classname, $matches)) {
      $classname = $matches[1];
    }

    $item = strstr($classname, 'Provider', true);
    $item = str_replace($this->App['namespace'] . '\\', '', $item);

    unset($this->App[$item]);
  }
}
