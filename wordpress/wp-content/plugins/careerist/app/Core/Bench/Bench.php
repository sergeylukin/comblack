<?php namespace Careerist\Core\Bench;

class Bench {

  /**
   * Mark arrays.
   *
   * @var array
   */
  protected $marks = array();

  /**
   * Microtime of when $this->start() was called.
   *
   * @var float
   */
  protected $start = null;

  /**
   * Bytes of memory allocated to PHP when $this->start() was called.
   *
   * @var int
   */
  protected $startMemory = null;

  /**
   * Microtime of when $this->stop() was called.
   *
   * @var float
   */
  protected $stop = null;

  /**
   * Bytes of memory allocated to PHP when $this->stop() was called.
   *
   * @var int
   */
  protected $stopMemory = null;

  /**
   * Do not allow instantiating this class
   */
  public function __construct() {
    $this->start();
  }

  /**
   * Start timer.
   *
   * @return void;
   */
  public function start() {
    if($this->start === null) {
      $this->start = microtime(true);
      $this->startMemory = memory_get_usage(true);
    }
  }

  /**
   * Stop timer.
   *
   * @return float; -> $this->duration()
   */
  public function stop() {
    if($this->stop === null) {
      $last_mark = $this->getLastMark();
      $this->mark('stop');
      $this->stop = microtime(true);
      $this->stopMemory = memory_get_usage(true);
    }
    return $this->durationFormatted();
  }

  /**
   * Reset timer.
   *
   * @return void;
   */
  public function reset() {
    $this->marks = array();
    $this->start = null;
    $this->startMemory = null;
    $this->stop = null;
    $this->stopMemory = null;
  }

  public function getLastMark()
  {
    if ($total = count($this->marks)) {
      return $this->marks[$total - 1]['display'];
    }

    return null;
  }

  /**
   * Mark a point in time.
   *
   * @param string; The id of the mark. (e.g., 'connection_start', 'connected_success', 'connection_fail');
   * @return mixed; Float, the time in seconds since last mark, or if no marks $this->start) - false, on error.
   */
  public function mark($id) {
    if($this->start === null) {
      $this->start();
    }

    if ($total = count($this->marks)) {
      $last_mark = $this->marks[$total-1];
    } else {
      $last_mark = array(
        'id' => 'start',
        'microtime' => $this->start,
        'total_memory' => $this->startMemory,
      );
    }

    $mark = array();
    $mark['id'] = $id;
    $mark['microtime'] = microtime(true);
    $mark['microtime_since_beginning'] = $mark['microtime'] - $this->start;
    $mark['microtime_since_beginning_formatted'] = $this->convertDurationToReadableFormat($mark['microtime_since_beginning']);
    $mark['duration'] = $mark['microtime'] - $last_mark['microtime'];
    $mark['duration_formatted'] = $this->convertDurationToReadableFormat($mark['duration']);
    $mark['total_memory'] = memory_get_usage(true);
    $mark['memory_since_beginning'] = $mark['total_memory'] - $this->startMemory;
    $mark['memory_since_beginning_formatted'] = $this->convertMemoryToReadableFormat($mark['memory_since_beginning']);
    $mark['memory'] = $mark['total_memory'] - $last_mark['total_memory'];
    $mark['memory_formatted'] = $this->convertMemoryToReadableFormat($mark['memory']);
    $location = 
    $mark['display'] = array(
      'location' => "Between '{$last_mark['id']}' and '{$mark['id']}'",
      'duration' => $mark['duration_formatted'],
      'memory'   => $mark['memory_formatted'],
    );
    $this->marks[] = $mark;
    return $mark['duration'];
  }

  /**
   * Get the time elapsed (in human readable format) since benchmarking started
   * 
   * durationFormatted()
   *   if[stop() has been called] -- Time between start() and stop()
   *   else -- Time between start() and the durationFormatted() call.
   * 
   * durationFormatted("from_mark_id", "to_mark_id") - Time between marks
   *
   * @param mixed;
   * @param mixed;
   * @return string;
   */
  public function durationFormatted($from_mark_id = null, $to_mark_id = null) {
    return $this->convertDurationToReadableFormat($this->duration($from_mark_id, $to_mark_id));
  }

  /**
   * Get the time elapsed (in seconds.milliseconds format) since benchmarking started
   * 
   * duration()
   *   if[stop() has been called] -- Time between start() and stop()
   *   else -- Time between start() and the duration() call.
   * 
   * duration("from_mark_id", "to_mark_id") - Time between marks
   *
   * @param mixed;
   * @param mixed;
   * @return milliseconds;
   */
  public function duration($from_mark_id = null, $to_mark_id = null) {
    $microtime = microtime(true);
    $time = 0;

    if($this->start === null) {
      $this->start();
    }

    if(!$from_mark_id && !$to_mark_id) {
      $end = ($this->stop !== null) ? $this->stop : $microtime;
      $time = $end - $this->start;
    } else {
      if (($mark_from = $this->getMarkById($from_mark_id)) && ($mark_to = $this->getMarkById($to_mark_id))) {
        $time = abs($mark_to['microtime'] - $mark_from['microtime']);
      }
    }

    return $time;
  }

  /**
   * Get statistics on what has happened since calling start();
   *
   * @return mixed; array of statistics, false on error.
   */
  public function dump($limit = null)
  {

    if($this->start === null) {
      $this->start();
    }

    $stats = array();

    // Elapsed Time (in seconds) -- Check comments of $this->duration() for more info.
    $endTime = ($this->stop) ? $this->stop : microtime(true);
    $duration = $endTime - $this->start;
    $stats['runtime'] = $this->convertDurationToReadableFormat($duration);
    $stats['runtime_marks'] = $this->getMarksSortedByDuration($limit);

    $endMemory = ($this->stopMemory) ? $this->stopMemory : memory_get_usage(true);
    $totalMemory = $endMemory - $this->startMemory;
    $stats['memory'] = $this->convertMemoryToReadableFormat($totalMemory);
    $stats['memory_marks'] = $this->getMarksSortedByMemory($limit);

    return $stats;

  }

  public function dump2js($limit = null) {
    return json_encode($this->dump($limit));
  }

  public function dump2file($file = '', $limit = null) {
    if (file_exists($file) && is_writable($file)) {
      return file_put_contents($file, print_r($this->dump($limit), true), FILE_APPEND);
    }
    return false;
  }




  /**
   * Get the marks array.
   *
   * $limit can be either:
   *   - 0 (returns all marks)
   *   - null (returns default number of marks)
   *   - n (where n is a number of marks to return)
   *
   * @return array;
   */
  private function getMarks($limit = null, $sort_by = 'duration', $sort = SORT_DESC)
  {

    if ($sort === SORT_DESC || $sort === SORT_ASC) {
      $marks = $this->array_sort($this->marks, $sort_by, $sort);
    } else {
      $marks = $this->marks;
    }

    if ($limit === null) {
      $limit = 3;
    }

    if ($limit !== 0) {
      $marks = array_slice($marks, 0, $limit);
    }

    return array_map(function($mark) {
      return $mark['display'];
    }, $marks);

  }

  private function getMarksSortedByDuration($limit = null)
  {
    return $this->getMarks($limit, 'duration', SORT_DESC);
  }

  private function getMarksSortedByMemory($limit = null)
  {
    return $this->getMarks($limit, 'memory', SORT_DESC);
  }

  private function array_sort($array, $on, $order=SORT_ASC){
    usort($array, function($a, $b) use ($on, $order) {
      $one = $a[$on];
      $two = $b[$on];
      if ($one < $two) {
        if ($order === SORT_ASC) {
          $ret = -1;
        } else {
          $ret = 1;
        }
      } elseif ($one > $two) {
        if ($order === SORT_ASC) {
          $ret = 1;
        } else {
          $ret = -1;
        }
      } else {
        $ret = 0;
      }

      return $ret;
    });

    return $array;
  }

  /**
   * Get a mark by its id.
   *
   * @param string; The id of the existing mark.
   * @return mixed; array on success, false on failure.
   */
  private function getMarkById($id) {
    foreach($this->marks as $mark) {
      if($mark['id'] == $id) {
        return $mark;
      }
    }
    return false;
  }

  private function convertDurationToReadableFormat($duration)
  {
    $duration =  sprintf('%.3f', $duration);

    // split the microtime in seconds and microseconds
    list($seconds, $milliseconds) = explode('.', $duration);

    $hours = date('H', $seconds);
    $minutes = date('i', $seconds);
    $seconds = intval(date('s', $seconds)) . ".{$milliseconds}";

    $str = '';
    if ($hours > 0) {
      $str .= (!empty($str) ? ' ' : '') . "{$hours} hours";
    }
    if ($minutes > 0) {
      $str .= (!empty($str) ? ' ' : '') . "{$minutes} minutes";
    }
    $str .= (!empty($str) ? ' ' : '') . "{$seconds} seconds";

    return $str;
  }

  private function convertMemoryToReadableFormat($size)
  {
    if (!$size) {
      return '0 b';
    }
    $unit=array('b','kb','mb','gb','tb','pb');
    return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
  }

}
