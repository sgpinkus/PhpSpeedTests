<?php

/**
 * @name Read Hash Loop Test
 * @shortDescription foreach() vs. for() vs. while(list() = each()) 
 * @description What is the best way to loop a hash array with stringy keys?
 */
class ReadHashLoopTest extends PHPUnit_Framework_TestCase
{
  public function setUp() {
    $val = 'AAAAAAAAAA';
    $this->aHash = array();
    while(sizeof($this->aHash) < 10000) {    
      $this->aHash[uniqid("", true)] = $val;
    }
  }
  
  public function tearDown() {
    unset($this->aHash);
  }
  
  /**
   * @name Foreach value
   * @snippet foreach($aHash as $val);
   */
  public function testForEachValue() {
    $timer = TimingListener::instance();
    $timer->startTestTimer();
    foreach($this->aHash as $val);
    $timer->endTestTimer();
  }
  
  /**
   * @name While list() each() value
   * @snippet while(list(,$val) = each($aHash));
   */
  public function testWhileListValue() {
    $timer = TimingListener::instance();
    $timer->startTestTimer();
    while(list(,$val) = each($this->aHash));
    $timer->endTestTimer();
  }
  
  /**
   * @name Foreach key value
   * @snippet foreach($aHash as $key => $val);
   */
  public function testForEachKeyValue() {
    $timer = TimingListener::instance();
    $timer->startTestTimer();
    foreach($this->aHash as $key => $val);
    $timer->endTestTimer();
  }
  
  /**
   * @name While list() each() key value
   * @snippet while(list($key,$val) = each($aHash));
   */
  public function testWhileListKeyValue() {
    $timer = TimingListener::instance();
    $timer->startTestTimer();
    while(list($key,$val) = each($this->aHash));
    $timer->endTestTimer();
  }
  
  /**
   * @name For count() array_keys()
   * @snippet for($i=0; $i<$size; $i++) $tmp = $aHash[$keys[$i]];
   */
  public function testForCountArrayKeys() {
    $timer = TimingListener::instance();
    $timer->startTestTimer();
    $keys = array_keys($this->aHash);
    $size = sizeof($keys);
    for($i=0; $i<$size; $i++) $tmp = $this->aHash[$keys[$i]];
    $timer->endTestTimer();
  }

  /**
   * @name Just array_keys()
   * @snippet $keys = array_keys($aHash);
   */
  public function testArrayKeys() {
    $timer = TimingListener::instance();
    $timer->startTestTimer();
    $keys = array_keys($this->aHash);
    $timer->endTestTimer();
  }

  /**
   * @name Just array_valuess()
   * @snippet $keys = array_values($aHash);
   */
  public function testArrayValues() {
    $timer = TimingListener::instance();
    $timer->startTestTimer();
    $keys = array_values($this->aHash);
    $timer->endTestTimer();
  }
}
