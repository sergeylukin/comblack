<?php namespace Careerist\Core;

class AliasLoader {

  /**
   * The array of class aliases.
   *
   * @var array
   */
  protected $aliases;

  /**
   * Indicates if a loader has been registered.
   *
   * @var bool
   */
  protected $registered = false;

  /**
   * Create a new class alias loader instance.
   *
   * @param  array  $aliases
   * @return void
   */
  public function __construct(array $aliases = array())
  {
    $this->aliases = $aliases;
  }

  /**
   * Load a class alias if it is registered.
   *
   * @param  string  $alias
   * @return void
   */
  public function load($alias)
  {
    if( !$this->registered ) return false;

    if (isset($this->aliases[$alias]))
    {
      return class_alias($this->aliases[$alias], $alias);
    }
  }

  /**
   * Add alias to a reference
   * For example add('View', '\Facades\View')
   * will result in calling \Facades\View Class every time View class is called
   *
   * @param  string  $alias
   * @param  string  $class
   * @return void
   */
  public function add($alias, $class)
  {
    $this->aliases[$alias] = $class;
  }

  /**
   * Register the loader on the auto-loader stack.
   *
   * @return void
   */
  public function register()
  {
    if ( ! $this->registered)
    {
      $this->prependToLoaderStack();

      $this->registered = true;
    }
  }

  public function unregister()
  {
    if ( $this->registered)
    {
      spl_autoload_unregister(array($this, 'load'));

      $this->aliases = array();

      $this->registered = false;
    }
  }

  /**
   * Prepend the load method to the auto-loader stack.
   *
   * @return void
   */
  protected function prependToLoaderStack()
  {
    spl_autoload_register(array($this, 'load'), true, true);
  }

  /**
   * Get the registered aliases.
   *
   * @return array
   */
  public function getAliases()
  {
    return $this->aliases;
  }

  /**
   * Set the registered aliases.
   *
   * @param  array  $aliases
   * @return void
   */
  public function setAliases(array $aliases)
  {
    $this->aliases = $aliases;
  }

  /**
   * Indicates if the loader has been registered.
   *
   * @return bool
   */
  public function isRegistered()
  {
    return $this->registered;
  }

  /**
   * Set the "registered" state of the loader.
   *
   * @param  bool  $value
   * @return void
   */
  public function setRegistered($value)
  {
    $this->registered = $value;
  }

}
