<?php namespace Careerist\Facades;

abstract class Facade {

  /**
   * The application instance being facaded.
   *
   * @var \Core\Application
   */
  protected static $app;

  /**
   * Get the registered name of the component.
   *
   * @return string
   */
  protected static function getFacadeAccessor()
  {
    throw new \RuntimeException("Facade does not implement getFacadeAccessor method.");
  }

  /**
   * Resolve the facade root instance from the container.
   *
   * @param  string  $name
   * @return mixed
   */
  protected static function resolveFacadeInstance($name)
  {
    if (is_object($name)) return $name;

    return static::$app->resolve($name);
  }

  /**
   * Get the application instance behind the facade.
   *
   * @return \Illuminate\Foundation\Application
   */
  public static function getFacadeApplication()
  {
    return static::$app;
  }

  /**
   * Set the application instance.
   *
   * @param  \Core\Application  $app
   * @return void
   */
  public static function setFacadeApplication($app)
  {
    static::$app = $app;
  }

  /**
   * Handle dynamic, static calls to the object.
   *
   * @param  string  $method
   * @param  array   $args
   * @return mixed
   */
  public static function __callStatic($method, $args)
  {
    $instance = static::resolveFacadeInstance(static::getFacadeAccessor());

    switch (count($args))
    {
      case 0:
        return $instance->$method();

      case 1:
        return $instance->$method($args[0]);

      case 2:
        return $instance->$method($args[0], $args[1]);

      case 3:
        return $instance->$method($args[0], $args[1], $args[2]);

      case 4:
        return $instance->$method($args[0], $args[1], $args[2], $args[3]);

      default:
        return call_user_func_array(array($instance, $method), $args);
    }
  }

}
