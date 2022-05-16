<?php namespace Careerist\Helpers;

use Traversable;
use Careerist\Helpers\InvalidDependencyException;

class InvalidDependencyPassedToPathHelperException extends InvalidDependencyException {}

class Path {
  private $paths = array();

  function __construct($paths = null) {
    if (!$paths || empty($paths)) {
      throw new InvalidDependencyPassedToPathHelperException(
        'paths', 'should contain paths'
      );
    }
    $this->paths = $paths;
  }

  public function __call($path = '', $args)
  {
    return $this->to($path);
  }

  public function to($path)
  {
    return (isset($this->paths[$path]) ? $this->paths[$path] : null);
  }

}

