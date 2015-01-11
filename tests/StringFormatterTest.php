<?php

/**
 * @name String Formatter Test
 * @shortDescription print "Hello {$foo}" vs printf("Hello %s", $foo) vs ..
 * @description 
 */
class StringFormatterTest extends PHPUnit_Framework_TestCase
{
  public function setup() {
    ob_start();
  }
  
  public function tearDown() {
    ob_end_clean();
  }
 
  /** 
   * @name Print Inline
   * @snippet echo "Hello {$you}";
   */
  public function testInline()
  {
    $timer = TimingListener::instance();
    $you = "Jane";
    $attribute =  "Hair";
    $value = "Spikey";
    $timer->startTestTimer();
    for($i = 0; $i < 10e5; $i++) {
      echo "Hello {$you}. My {$attribute} is {$value}";
    }
    $timer->endTestTimer();
  }

  /** 
   * @name Printf()
   * @snippet printf("Hello %s", $you);
   */
  public function testPrintf()
  {
    $timer = TimingListener::instance();
    $you = "Jane";
    $attribute =  "Hair";
    $value = "Spikey";
    $timer->startTestTimer();
    for($i = 0; $i < 10e5; $i++) {
      printf("Hello %s. My %s is %s", $you, $attribute, $value);
    }
    $timer->endTestTimer();
  }
  
  /** 
   * @name Concat print
   * @snippet print 'Hello ' . $you;
   */
  public function testPrintConcat()
  {
    $timer = TimingListener::instance();
    $you = "Jane";
    $attribute =  "Hair";
    $value = "Spikey";
    $timer->startTestTimer();
    for($i = 0; $i < 10e5; $i++) {
      print 'Hello' . $you . 'My ' . $attribute . 'is ' . $value;
    }
    $timer->endTestTimer();
  }
}
?>
