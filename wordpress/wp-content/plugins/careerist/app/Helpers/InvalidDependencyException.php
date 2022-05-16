<?php namespace Careerist\Helpers;

class InvalidDependencyException extends \Exception {
  public function __construct($dependency_name = '', $is = 'is incorrect') {
    $class = 'UnknownClass';
    $method = 'UnknownMethod';
    $arguments = '';

    $trace = explode("\n", $this->getTraceAsString());
    $trace = $trace[0];

    if (preg_match('/#\d\s(?<file>.*)\((?<line>\d+)\):\s(?<class>.*)->(?<method>[^(]*)\((?<arguments>.*)\)/', $trace, $matches)) {
      $class = $matches['class'];
      $method = $matches['method'];
      $arguments = $matches['arguments'];
    }

    $message = "Dependency '{$dependency_name}' passed to {$class}::{$method}() {$is}, called in {$this->file} on line {$this->line}. Here is complete list of arguments passed to {$class}::{$method}(): {$arguments}";
    parent::__construct($message, 0);
  }
}
