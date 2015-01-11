<?php

/**
 * @name References Vs Pass By Value
 * @shortDescription $data &= getData() vs. $data = getData() 
 * @description Could this really have an effect? Objects are already reference types.
 */
class UsingReferencesTest extends PHPUnit_Framework_TestCase
{
  public function setup() {
    $this->obj = new SomeOtherClass();
  }
  
  public function tearDown() {
    unset($this->obj);
  }
  
  /**
   * @name No Ref
   * @snippet $data = $obj->get();
   */
  public function testNoRef() {
    $timer = TimingListener::instance();
    $timer->startTestTimer();
    $i = 0;
    while($i < 1000) {
      $data = $this->obj->get();
      ++$i;
    }    
    $timer->endTestTimer();
  }
  
  /**
   * @name With Ref
   * @snippet $data =& $obj->getRef();
   */
  public function testWithRef() {
    $timer = TimingListener::instance();
    $timer->startTestTimer();
    $i = 0;
    while($i < 1000) {
      $data =& $this->obj->getRef();
      ++$i;
    }    
    $timer->endTestTimer();
  }
  
  /**
   * @name No Ref Modify
   * @snippet $data = $obj->get(); $data[] = 100;
   */
  public function testNoRefModify() {
    $timer = TimingListener::instance();
    $timer->startTestTimer();
    $i = 0;
    while($i < 1000) {
      $data = $this->obj->get();
      $data[] = 100;
      ++$i;
    }    
    $timer->endTestTimer();
  }
  
  /**
   * @name With Ref Modify
   * @snippet $data =& $obj->getRef(); $data[] = 100;
   */
  public function testWithRefModify() {
    $timer = TimingListener::instance();
    $timer->startTestTimer();
    $i = 0;
    while($i < 1000) {
      $data =& $this->obj->getRef();
      $data[] = 100;
      ++$i;
    }
    $timer->endTestTimer();
  }
}

class SomeOtherClass {
  private $data = array(0,1,2,3,4,5,6,7,8,9);  
  function get() {return $this->data;}
  function &getRef() {return $this->data;}
}
