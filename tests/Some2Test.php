<?php

/**
 * @whoop Foo
 */
class SomeTest2 extends PHPUnit_Framework_TestCase
{

  public function testNothing() {
  }
  
  public function testNothingRepeatProvider() {
    return array_fill(0,3,[]);
  }

  /**
   * @dataProvider testNothingRepeatProvider
   */
  public function testNothingRepeat() {
  }


  /**
   * This test is blah blah.
   */
  public function testNothingAgainAndAgain() {
  }

  public function testNothingAgainAndAgainAndAgain() {
  }
  
  public function testArrayPushFunction()
  {
    $s = microtime(true);
    $a = [];
    #$timer = TimingListener::instance();
    #$timer->startTest($this, true);        
    for($i = 0; $i < 10e5; $i++) {
      array_push($a, $i);
    }
    $e = microtime(true);
    #$timer->endTest($this, null);
    print "\n\t" . $e - $s ."\n";
    
  }
  
  public function testArrayPush()
  {
    $a = [];
    for($i = 0; $i < 10e5; $i++) {
      $a[] = $i;
    }
  }
}
?>
