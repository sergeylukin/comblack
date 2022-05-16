<?php namespace Careerist\Helpers\Container;

use ArrayAccess;
use Iterator;

class Container implements ArrayAccess, Iterator {

  private $pointer = 0;

  protected $container = array();


  /*
   * Set to true if you want items to be nestable by dot, e.g:
   *
   * $this->get('group.subgroup.item')
   *
   * would traverse container as:
   *
   * array('group'  => array('subgroup' => array('item')));
   *
   */
  protected $split_by_dot = true;

  protected $trim_on_set = false;

  public function fillContainer($array)
  {
    $this->container = $array;
  }

  public function get($key) {
    $array = $this->container;

    $result = null;
    
    if (empty($key)) {

      $result = $array;

    } else {

      if( $this->split_by_dot === true )
      {
        $hierarchy = explode('.', $key);
      } else {
        $hierarchy = array($key);
      }

      if( count($hierarchy) == 1 ) {

        if( isset($array[$key]) ) {
          $result = $array[$key];
        }

      } else {

        $i = 0;
        $depth = count($hierarchy);
        $array_tmp = $array;
        foreach( $hierarchy as $alias ) {
          $i++;
          if( !isset($array_tmp[$alias]) ) {
            break;
          }

          if( $i == $depth ) {
            $result = $array_tmp[$alias];
            break;
          }

          if( is_array($array_tmp) ) {
            $array_tmp = $array_tmp[$alias];
          }
        }

      }

    }

    if( is_array($result) ) {

      $container = new Container();

      $container->fillContainer($result);

      return $container;

    }

    return $result;
  }

  public function set($key, $value = null)
  {
    $array = $this->container;

    if( $this->trim_on_set )
    {
      $key = trim($key);
      $value = trim($value);
    }

    if( $this->split_by_dot === true )
    {
      $hierarchy = explode('.', $key);
    } else {
      $hierarchy = array($key);
    }

    if( count($hierarchy) == 1 ) {
      $array[$key] = $value;
      // Update container
      $this->container = $array;
    } else {
      $i = 0;
      $depth = count($hierarchy);
      $array_tmp = array();
      $lastRef = & $array_tmp;
      foreach( $hierarchy as $alias ) {
        $i++;
        if( $i == $depth ) {
          $lastRef[$alias] = $value;
        } else {
          $lastRef[$alias] = array();
          $lastRef = & $lastRef[$alias];
        }
      }

      if (!is_array($this->container)) {
        $this->container = array();
      }
      $this->container = array_merge_recursive($this->container, $array_tmp);
    }
  }

  public function delete($key = '')
  {
    unset($this->container[$key]);
  }

  public function exists($key)
  {
    return $this->get($key) !== null;
  }

  /******************************
   * Allow accessing container
   * via in Array-fashion
   * for example:
   * $i = new Blocks(array(
   *   'blockA' => 'foo'
   * ));
   * echo $i['blockA']; // foo
   ******************************/

  /**
   * Determine if a given offset exists.
   *
   * @param  string  $key
   * @return bool
   */
  public function offsetExists($key)
  {
    return $this->exists($key);
  }

  /**
   * Get the value at a given offset.
   *
   * @param  string  $key
   * @return mixed
   */
  public function offsetGet($key)
  {
    return $this->get($key);
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
    $this->set($key, $value);
  }

  /**
   * Unset the value at a given offset.
   *
   * @param  string  $key
   * @return void
   */
  public function offsetUnset($key)
  {
    $this->delete($key);
  }

  /******************************
   * Allow iterating
   * through object
   * for example:
   *
   * $i = new Blocks(array(
   *   'blockA' => 'foo'
   * ));
   *
   * foreach ($i as $key => $value) {
   *   echo $key; // 'blockA'
   *   echo $value; // 'foo'
   * }
   ******************************/
  public function key() {
    return key($this->container);
  }

  public function current() {
    return current($this->container);
  }

  public function next() {
    next($this->container);
  }

  public function rewind() {
    reset($this->container);
  }

  public function valid() {
    return current($this->container);
  }
}

