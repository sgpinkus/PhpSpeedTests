<?php

/**
 * @name Counting Loop Test
 * @shortDescription for() vs while()
 */
class CountingLoopTest extends PHPUnit_Framework_TestCase
{
 
  /** 
   * @name For Loop
   * @snippet for($i = 0; $i < 10e5; $i++);
   */
  public function testFor()
  {
    $timer = TimingListener::instance();
    $timer->startTestTimer();
    for($i = 0; $i < 10e5; $i++);
    $timer->endTestTimer();
    
  }
  
  /**
   * @name While Loop
   * @snippet $i = 0; while($i < 10e5) $i++;
   */
  public function testWhile()
  {
    $timer = TimingListener::instance();
    $timer->startTestTimer();
    $i = 0; while($i < 10e5) $i++;
    $timer->endTestTimer();
  }
}
?>
