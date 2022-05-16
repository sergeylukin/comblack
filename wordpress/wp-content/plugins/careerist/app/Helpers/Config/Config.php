<?php namespace Careerist\Helpers\Config;

use Careerist\Helpers\Container\Container;
use Careerist\Core\Filesystem\Filesystem;

class Config extends Container {

  /**
   * The filesystem instance.
   *
   * @var Core\Filesystem\Filesystem
   */
  protected $files;

  /**
   * Create a new configuration repository.
   *
   * @param  \Core\Filesystem\Filesystem $files
   * @return void
   */
  public function __construct(Filesystem $files) {
    $this->files = $files;
  }

  function fetch($basePath = null)
  {
    $config = array();

    if( $this->files->isDirectory($basePath) )
    {

      $files = $this->files->files($basePath);
      foreach( $files as $file )
      {
        $config = array_merge_recursive($config, $this->fetchFile($file));
      }

    }

    $this->fillContainer(array_replace_recursive($this->container, $config));
  }

  private function fetchFile($file)
  {
    $items = array();

    if( $this->files->exists($file) )
    {
      $items = $this->files->getRequire($file);
    }

    return (array) $items;
  }

}
