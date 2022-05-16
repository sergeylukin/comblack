<?php namespace Careerist\Core;

class ProviderLoader {

  /**
   * Indicates if a loader has been registered.
   *
   * @var bool
   */
  protected $registered = false;

  private $App;

  /**
   * Create a new class alias loader instance.
   *
   * @param  array  $aliases
   * @return void
   */
  public function __construct($App)
  {
    $this->App = $App;
  }

  /**
   * Load a class provider if it exists but not yet registered
   *
   * @param  string  $alias
   * @return void
   */
  public function load($alias)
  {

    // We're only in charge of registering a provider for
    // class that has a provider but was not yet registered
    // so if there is already a registered record for
    // for this item - ignore and let another registered
    // spl_autoloader load it
    if( $this->App->registered($alias) ) return false;

    if( strpos(strtolower($alias), 'provider') === false )
    {
      if( class_exists("\\{$this->App->namespace}" . '\\Providers\\' . $alias . 'Provider') )
      {
        $this->App->registerProvider($alias.'Provider');
      }
    }
  }

  /**
   * Prepend the load method to the auto-loader stack.
   *
   * @return void
   */
  public function register()
  {
    if ( ! $this->registered)
    {
      spl_autoload_register(array($this, 'load'), true, true);

      $this->registered = true;
    }
  }

  public function unregister()
  {
    if ( $this->registered)
    {
      spl_autoload_unregister(array($this, 'load'));

      $this->registered = false;
    }
  }

}
