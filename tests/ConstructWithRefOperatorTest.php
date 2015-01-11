<?php

/**
 * @name Using the =&-ref-operator
 * @shortDescription $obj = new SomeClass() vs. $obj =& new SomeClass() 
 * @description Could this really have an effect? Objects are already reference types.
 */
class ConstructWithRefOperatorTest extends PHPUnit_Framework_TestCase
{
  /**
   * @name No Ref
   * @snippet $obj = new SomeClass();
   */
  public function testNoRef() {
    $timer = TimingListener::instance();
    $timer->startTestTimer();
    $i = 0;
    while($i < 1000) {
      $obj = new SomeClass();
      ++$i;
    }
    $timer->endTestTimer();
  }
  
  /**
   * @name With Ref
   * @snippet $obj =& new SomeClass();
   */
  public function testWithRef() {
    $timer = TimingListener::instance();
    $timer->startTestTimer();
    $i = 0;
    while($i < 1000) {
      $obj =& new SomeClass();
      ++$i;
    }
    $timer->endTestTimer();
  }
}

class SomeClass {
  private $data = [0,1,2,3,4,5,6,7,8,9];  
  function foo() {}
}
