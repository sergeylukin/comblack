<?php namespace Careerist\Providers;

use Alias;
use Filesystem;
use Careerist\Helpers\Path;
use App;

class PathsProvider extends Provider {

  public function register() {

    $root = dirname(__DIR__, 2);

    $paths = array(

      /*
      |--------------------------------------------------------------------------
      | Application Path
      |--------------------------------------------------------------------------
      |
      | Here we just defined the path to the application directory.
      |
      */

      'app' => $root.'/app',

      'config' => $root.'/app/config',

      /*
      |--------------------------------------------------------------------------
      | Root Path
      |--------------------------------------------------------------------------
      |
      | The root is the lowest possible directory where this project resides.
      | It is usually the same directory where VCS (like `.git` directory) files reside.
      |
      */

      'root' => $root,

      /*
      |--------------------------------------------------------------------------
      | Logs Path
      |--------------------------------------------------------------------------
      |
      | The logs path is used to store log files that contain System logs,
      | Warnings and Errors.
      |
      */

      'logs' => $root.'/logs',

    );

    // Register IOC records
    $this->App->singleton('path', realpath($paths['app']));

    // Here we will register the install paths into the container as strings that can be
    // accessed from any point in the system. Each path key is prefixed with path
    // so that they have the consistent naming convention inside the container.
    foreach ( $paths as $key => $value)
    {
      $paths[$key] = $value = normalize_path($value);
      // We use normalize_path() and not realpath()
      // because some paths may not exist when paths
      // are assigned (think of build manifest files for
      // example)
      $this->App->singleton("path.{$key}", $value);
    }

    $this->App->singleton('Path', function($App) use ($paths) {
      return new Path($paths);
    });

    // Register shortcut Alias
    Alias::add('Path', '\Careerist\Facades\Path');

  }

  public function unregister() {
    unset($this->App['Path']);
    unset($this->App['path']);
    unset($this->App["path.*"]);
  }

}
