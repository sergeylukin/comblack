<?php namespace Careerist\Core\Filesystem;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RegexIterator;
use RecursiveRegexIterator;

class FileNotFoundException extends \Exception {}

class Filesystem {

  /**
   * Determine if a file exists.
   *
   * @param  string  $path
   * @return bool
   */
  public function exists($path)
  {
    return file_exists($path);
  }

  /**
   * Get the contents of a file.
   *
   * @param  string  $path
   * @return string
   *
   * @throws FileNotFoundException
   */
  public function get($path)
  {
    if ($this->isFile($path)) return file_get_contents($path);

    throw new FileNotFoundException("File does not exist at path {$path}");
  }

  /**
   * Get the contents of a file as array where keys are line numbers
   *
   * @param  string  $path
   * @return string
   *
   * @throws FileNotFoundException
   */
  public function getWithLines($path)
  {
    if ($this->isFile($path)) return file($path, FILE_IGNORE_NEW_LINES);

    throw new FileNotFoundException("File does not exist at path {$path}");
  }

  /**
   * Get the contents of a remote file.
   *
   * @param  string  $path
   * @return string
   */
  public function getRemote($path)
  {
    return file_get_contents($path);
  }

  /**
   * Get the returned value of a file.
   *
   * @param  string  $path
   * @return mixed
   *
   * @throws FileNotFoundException
   */
  public function getRequire($path)
  {
    if ($this->isFile($path)) return require $path;

    throw new FileNotFoundException("File does not exist at path {$path}");
  }

  /**
   * Require the given file once.
   *
   * @param  string  $file
   * @return mixed
   */
  public function requireOnce($file)
  {
    require_once $file;
  }

  /**
   * Write the contents of a file.
   *
   * @param  string  $path
   * @param  string  $contents
   * @return int
   */
  public function put($path, $contents)
  {
    $directory = dirname($path);
    if (!$this->exists($directory)) {
      $this->makeDirectory($directory, 0755, true);
    }

    return file_put_contents($path, $contents);
  }

  /**
   * Touch a file
   *
   * @param  string  $filepath
   * @param  string  $mode
   */
  public function touch($filepath, $mode = 'a')
  {
      fclose(fopen($filepath, $mode));
  }

  /**
   * Create a file
   *
   * @param  string  $filepath
   * @param  string  $mode
   */
  public function createFile($filepath, $mode = 0644) {
    $this->touch($filepath);
    chmod($filepath, $mode);
  }


  /**
   * Prepend to a file.
   *
   * @param  string  $path
   * @param  string  $data
   * @return int
   */
  public function prepend($path, $data)
  {
    if ($this->exists($path))
    {
      return $this->put($path, $data.$this->get($path));
    }
    else
    {
      return $this->put($path, $data);
    }
  }

  /**
   * Append to a file.
   *
   * @param  string  $path
   * @param  string  $data
   * @return int
   */
  public function append($path, $data)
  {
    if ($this->exists($path))
    {
      return $this->put($path, $this->get($path).$data);
    }
    else
    {
      return $this->put($path, $data);
    }
  }

  /**
   * Delete the file at a given path.
   *
   * @param  string|array  $paths
   * @return bool
   */
  public function delete($paths)
  {
    $paths = is_array($paths) ? $paths : func_get_args();

    foreach ($paths as $path) {
      if ($this->isDirectory($path) && !is_link($path)) {
        $this->deleteTree($path);
      } else {
        @unlink($path);
      }
    }
  }

  public function deleteTree($dir)
  {
    $files = array_diff(scandir($dir), array('.','..')); 
    foreach ($files as $file) { 
      (is_dir("$dir/$file") && !is_link($dir)) ? $thos->deleteTree("$dir/$file") : unlink("$dir/$file"); 
    } 
    return rmdir($dir); 
  }

  /**
   * Move a file to a new location.
   *
   * @param  string  $path
   * @param  string  $target
   * @return bool
   */
  public function move($path, $target)
  {
    return rename($path, $target);
  }

  /**
   * Copy a file to a new location.
   *
   * @param  string  $path
   * @param  string  $target
   * @return bool
   */
  public function copy($path, $target)
  {
    // check if target path's base directory exists
    // and create it if it doesn't
    $directory = dirname($target);
    if (!$this->exists($directory)) {
      $this->makeDirectory($directory, 0755, true);
    }

    return copy($path, $target);
  }

  /**
   * Extract the file extension from a file path.
   *
   * @param  string  $path
   * @return string
   */
  public function extension($path)
  {
    return pathinfo($path, PATHINFO_EXTENSION);
  }

  /**
   * Get the file type of a given file.
   *
   * @param  string  $path
   * @return string
   */
  public function type($path)
  {
    return filetype($path);
  }

  /**
   * Get the file size of a given file.
   *
   * @param  string  $path
   * @return int
   */
  public function size($path)
  {
    return filesize($path);
  }

  /**
   * Get the file's last modification time.
   *
   * @param  string  $path
   * @return int
   */
  public function lastModified($path)
  {
    return filemtime($path);
  }

  /**
   * Determine if the given path is a directory.
   *
   * @param  string  $directory
   * @return bool
   */
  public function isDirectory($directory)
  {
    return is_dir($directory);
  }

  /**
   * Determine if the given path is writable.
   *
   * @param  string  $path
   * @return bool
   */
  public function isWritable($path)
  {
    return is_writable($path);
  }

  /**
   * Determine if the given path is a file.
   *
   * @param  string  $file
   * @return bool
   */
  public function isFile($file)
  {
    return is_file($file);
  }

  /**
   * Find path names matching a given pattern.
   *
   * @param  string  $pattern
   * @param  int     $flags
   * @return array
   */
  public function glob($pattern, $flags = 0)
  {
    return glob($pattern, $flags);
  }

  /**
   * Get an array of all files in a directory.
   *
   * @param  string  $directory
   * @return array
   */
  public function files($directory, $pattern = null)
  {
    if ($pattern) {
      $glob = glob("{$directory}/{$pattern}");
    } else {
      $glob = glob($directory.'/*');
    }

    if ($glob === false) return array();

    // To get the appropriate files, we'll simply glob the directory and filter
    // out any "files" that are not truly files so we do not end up with any
    // directories in our list, but only true files within the directory.
    return array_filter($glob, function($file)
    {
      return file_exists($file) && is_file($file);
    });
  }

  public function allFiles($directory, $regex = null)
  {
    $Directory = new RecursiveDirectoryIterator($directory);
    $Iterator = new RecursiveIteratorIterator($Directory);

    if ($regex !== null) {
      $files = new RegexIterator($Iterator, $regex, RecursiveRegexIterator::GET_MATCH);
    } else {
      $files = new RegexIterator($Iterator, '/^.+\.[^\.]+$/i', RecursiveRegexIterator::GET_MATCH);
    }

    return array_map(function($value) {
      return $value[0];
    }, iterator_to_array($files));

  }

  public function allDirectories($root, $regex = null)
  {
    $iter = new RecursiveIteratorIterator(
      new RecursiveDirectoryIterator($root, RecursiveDirectoryIterator::SKIP_DOTS),
      RecursiveIteratorIterator::SELF_FIRST,
      RecursiveIteratorIterator::CATCH_GET_CHILD // Ignore "Permission denied"
    );

    $paths = array($root);
    foreach ($iter as $path => $dir) {
      if ($dir->isDir()) {
        $paths[] = $path;
      }
    }

    return $paths;

  }

  /**
   * Create a directory.
   *
   * @param  string  $path
   * @param  int     $mode
   * @param  bool    $recursive
   * @param  bool    $force
   * @return bool
   */
  public function makeDirectory($path, $mode = 0777, $recursive = false, $force = false)
  {
    if ($force)
    {
      return @mkdir($path, $mode, $recursive);
    }
    else
    {
      return mkdir($path, $mode, $recursive);
    }
  }

  /**
   * Empty the specified directory of all files and folders.
   *
   * @param  string  $directory
   * @return bool
   */
  public function cleanDirectory($directory)
  {
    // Cut trailing slash
    if (substr($directory, -1) === '/') {
      $directory = substr($directory, 0, -1);
    }

    $files = array_diff(scandir($directory), array('.','..')); 
    foreach ($files as $file) { 
      if ($this->isDirectory("$directory/$file") && !is_link($directory)) {
        $this->deleteTree("$directory/$file");
      } else {
        $this->delete("$directory/$file");
      }
    } 
  }

  public function totalFilesIn($directory)
  {
    return count($this->files($directory));
  }

}
