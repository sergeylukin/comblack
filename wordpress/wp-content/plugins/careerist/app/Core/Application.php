<?php namespace Careerist\Core;

use Careerist\Core\Bench\Bench;

class Application extends IOC {

  /**
   * Whether app was started
   *
   * @var boolean
   */
  private $started = false;

  /**
   * Service Providers instances
   *
   * @var array
   */
  public $providers = array();

  /**
   * Create a new application instance
   *
   * @return void
   */
  public function __construct()
  {
    // Auto-start the application
    $this->start();
  }


  /**
   * Register specific provider
   *
   * @return void
   */
  public function registerProvider($provider = '')
  {
    // Do not register Providers twice
    if( array_key_exists($provider, $this->providers) ) {
      return;
    }
    $class = '\\' . $this->namespace . '\\Providers\\' . $provider;
    $instance = new $class($this);
    $instance->register($this);

    // Remember that this provider is registered
    $this->providers[$provider] = $instance;
  }

  /**
   * Register array of providers
   *
   * @return void
   */
  public function registerProviders($providers = array())
  {
    if( !is_array($providers) ) $providers = array();

    foreach( $providers as $provider ) {
      $this->registerProvider( $provider );
    }
  }

  /**
   * Unregister specific provider
   *
   * @return void
   */
  public function unregisterProvider($provider = '')
  {
    if( !array_key_exists($provider, $this->providers) )
    {
      return;
    }

    $this->providers[$provider]->unregister($this);
    unset($this->providers[$provider]);
  }

  /**
   * Unregister all currently registered providers
   *
   * @return void
   */
  public function unregisterProviders()
  {
    foreach( $this->providers as $provider => $instance )
    {
      $this->unregisterProvider($provider);
    }
  }

  /**
   * Do some initialization stuff
   *
   * @return void
   */
  public function start()
  {
    if ($this->started) {
      return;
    }

    // Register and start Bench library instance
    $this->singleton('Bench', new Bench);

    // Set flag to make sure this method will not be executed for current 
    // instance
    $this->started = true;

    // Make sure the when app starts - IOC is fully accessible for read/write
    $this->unlock();

    // Set a bench mark after we initialized IOC container
    $this->Bench->mark('Initialize IOC container');
  }


  /**
   * Just facade syntax for the Bench library
   * Because mark() method is mostsly used one
   * we created this nicer way to call it.
   * Instead of `$App->Bench->mark()` it can be
   * as `$App->benchmark()`
   *
   * @return int (duration time in milliseconds)
   */
  public function benchmark($name = '')
  {
    return $this->Bench->mark($name);
  }

  /**
   * Shutdown the application and call events
   *
   * @return void
   */
  public function shutdown($callback = null)
  {
      // Stop measuring the performance metrics
      // and remove Bench instance from registry
      $this->Bench->stop();
      if (is_callable($callback)) {
        $callback($this);
      }
      $this->unregister('Bench');

      // Go over each provider and execute unregister() method
      // Each provider is suppored to unregister whatever
      // it registered before
      $this->unregisterProviders();

      // Close IOC for write and only allow reading existing entries
      // (this will only be possible if some provider didn't clean it's stuff,
      // which should not happen frequent; the only such provider I can think
      // of right now is provider that registers Response HTTP headers which
      // are likely required to be available even after application finished
      // working in Functional tests for example)
      $this->lock();
  }

}
