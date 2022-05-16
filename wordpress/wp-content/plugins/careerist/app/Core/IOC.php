<?php namespace Careerist\Core;

use Exception;

class IOCException extends Exception {}

/*
 * Lightweight IOC container
 */
abstract class IOC implements \ArrayAccess {

   /**
    * Contains all the registered instantiations
    *
    * @var array
    */
   protected $registry = array();

   /**
    * Names and instances of objects that should be executed only on first request
    *
    * @var array
    */
   protected $singletons = array();

   /**
    * When application shuts down, it may want to set this property to TRUE in order to
    * prevent new values from being inserted into the IOC
    *
    * @var bool
    */
   protected $ioc_locked = false;

   public function lock() {
     $this->ioc_locked = true;
   }

   public function unlock() {
     $this->ioc_locked = false;
   }

   public function locked() {
    return $this->ioc_locked === true;
   }

   /**
    * Add a new resolver to the registry array.
    * @param  string $name The id
    * @param  object $resolve Closure that creates instance
    * @return void
    */
   public function register($name, $resolve)
   {
     if( $this->ioc_locked )
     {
       throw new IOCException("Sorry, we cannot set '{$name}' after application was shut down or before it started.");
     }
      $this->registry[$name] = $resolve;
   }

   /**
    * Returns all the items that were actually called and registered
    *
    * @return array
    */
   public function getAllRegisteredItems()
   {
     return array_keys($this->registry);
   }

   /**
    * Add a new resolver to the registry array so
    * that it'll be executed only for the first call
    * and will be returned as is on next calls

    * @param  string $name The id of object
    * @param  object $resolve Closure that creates instance
    * @return void
    */
   public function singleton($name, $resolve)
   {
      $this->register($name, $resolve);
      $this->singletons[$name] = null;
   }

   /**
    * Replace currently registered item
    * with the new one
    *
    * Checks whether an item was registered as singleton
    * or as regular reference and re-registers it the same way
    *
    * @param  string $name The id
    * @param  object $resolve Closure that creates instance
    * @return void
    */
   public function swap($name, $resolve)
   {
      if( array_key_exists($name, $this->singletons) )
      {
        $this->singleton($name, $resolve);
      } else {
        $this->register($name, $resolve);
      }
   }

   /**
    * Create the instance
    * @param  string $name The id
    * @return mixed
    */
   public function resolve($name)
   {
      if ( $this->registered($name) )
      {
        $value = $this->registry[$name];

        if( array_key_exists($name, $this->singletons) && $this->singletons[$name] !== null ) {
          return $this->singletons[$name];
        }

        // Either execute callack or just return whatever it is
        if( $value instanceof \Closure )
        {
          $instance = $value($this);
        }
        elseif( $value instanceof \Providers\Provider && is_callable(array($value, 'instantiate')) )
        {
          $instance = $value->instantiate($this);
        }
        else
        {
          $instance = $value;
        }

        if( array_key_exists($name, $this->singletons) ) {
          $this->singletons[$name] = $instance;
        }

        return $instance;
      }

       // If element doesn't exist and ioc was shutdown - do not continue
       // Only allow new instantiations when ioc is not shutdown
       if( $this->ioc_locked )
       {
         throw new IOCException("Sorry, we cannot retrieve '{$name}' after application was shut down or before it started.");
       }

 
      // Just instantiate the Class manually
        if( $name instanceof \Closure ) {
          $class = new \ReflectionClass($name);
          return $class->newInstance();
        } elseif( class_exists('\\Providers\\' . $name . 'Provider') ) {
          $this->registerProvider($name.'Provider');
          if ( $this->registered($name) )
          {
            return $this->resolve($name);
          } else {
            throw new IOCException("Nothing registered with name {$name}. Could not instantiate requested class.");
          }
        } else {
          throw new IOCException("Nothing registered with name {$name}. Could not instantiate requested class.");
        }

   }
 
   /**
    * Determine whether the id is registered
    * @param  string $name The id
    * @return bool Whether to id exists or not
    */
   public function registered($name)
   {
      return array_key_exists($name, $this->registry);
   }


   /******************************
    * Allow accessing instances
    * via $App['instance'] syntax
    * in addition to
    * $App->resolve('instance')
    ******************************/

   /**
    * Determine if a given offset exists.
    *
    * @param  string  $key
    * @return bool
    */
   public function offsetExists($key)
   {
     return isset($this->registry[$key]);
   }

   /**
    * Get the value at a given offset.
    *
    * @param  string  $key
    * @return mixed
    */
   public function offsetGet($key)
   {
     return $this->resolve($key);
   }

   /**
    * Set the value at a given offset.
    *
    * @param  string  $key
    * @param  mixed   $value
    * @return void
    */
   public function offsetSet($key, $value)
   {
     $this->register($key, $value);
   }

   /**
    * Unset the value at a given offset.
    *
    * @param  string  $key
    * @return void
    */
   public function offsetUnset($key)
   {
     $this->unregister($key);
   }

   /**
    * Remove one or multiple registry items
    * For multiple items use "*" wildcard
    *
    * For example:
    *   $App->unregister('path.*'); // remove all items that start with "path."
    *   $App->unregister('*.logs'); // remove all items that end with ".logs"
    *   $App->unregister('foo*bar*baz'); // remove all items that
    *                                       start with "foo"
    *                                       continued with any characters, then "bar"
    *                                       continued with any charactes and finally "baz"
    *   etc.
    *
    * @param  string  $key
    * @return void
    */
   public function unregister($key = null)
   {
     if( empty($key) ) return;

     if( strpos($key, '*') !== false )
     {

        $pattern = '/' . str_replace('*', '.*', $key) . '/';
        foreach( $this->registry as $item_name => $value )
        {
          if( preg_match($pattern, $item_name) )
          {
            $this->remove_registry_item($item_name);
          }
        }

     } else {

       $this->remove_registry_item($key);

     }
   }

   /**
    * Just remove single registry item by it's exact name
    *
    * @param  string  $key
    * @return void
    */
   private function remove_registry_item($key)
   {
     unset($this->registry[$key]);

     // Unset singleton record too
     if( array_key_exists($key, $this->singletons) )
     {
       unset($this->singletons[$key]);
     }
   }

   /******************************
    * Allow accessing instances
    * via $App->instance syntax
    * in addition to
    * $App->resolve('instance')
    * and
    * $App['instance']
    ******************************/
   /**
    * Get the value at a given offset.
    *
    * @param  string  $key
    * @return mixed
    */
   public function __get($key)
   {
     return $this->resolve($key);
   }

   /**
    * Set the value at a given offset.
    *
    * @param  string  $key
    * @param  mixed   $value
    * @return void
    */
   public function __set($key, $value)
   {
     $this->register($key, $value);
   }
}
