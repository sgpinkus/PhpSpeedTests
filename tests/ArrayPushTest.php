<?php

/**
 * @name Array Push Test
 * @shortDescription array_push() vs $a[] =.
 */
class ArrayPushTest extends PHPUnit_Framework_TestCase
{
 
  /** 
   * @name Push with array_push()
   * @snippet array_push($a, $i);
   */
  public function testArrayPushFunction()
  {
    $timer = TimingListener::instance();
    $timer->startTestTimer();
    $a = array();
    for($i = 0; $i < 10e5; $i++) {
      array_push($a, $i);
    }
    $timer->endTestTimer();
    
  }
  
  /**
   * @name Push with $a[] = 
   * @snippet $a[] = $i;
   */
  public function testArrayPush()
  {
    $timer = TimingListener::instance();
    $timer->startTestTimer();
    for($i = 0; $i < 10e5; $i++) {
      $a[] = $i;
    }
    $timer->endTestTimer();
  }
}
?>
