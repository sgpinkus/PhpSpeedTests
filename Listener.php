<?php
require_once './vendor/autoload.php';

/**
 * Listener for PHPUnit tests and suites. Generates HTML view of results, via Twig.
 * PHPUnit already provides time taken for each test. This listener asdd two more methods to start/stop a test timer for better accuracy.
 */
class TimingListener extends PHPUnit_Framework_BaseTestListener
{
  private $startTime = null;
  private $endTime = null;
  private static $instance = null;
  
  public function __construct()
  {
    $this->view = new View();
    self::$instance = $this;
  }
  
  /**
   * Render. There is no "all done" event. Argh.
   */
  public function __destruct() {
    $this->view->render();
  }

  
  /**
   * Notify view listener with a description of the current suite.
   * A "suite" may correspond to a class, or a subdir or other things that aren't PHPUnit_Framework_TestCase.
   * TestSuite has no getAnnotations(). Want to use this mech to do suites though.
   */
  public function startTestSuite(PHPUnit_Framework_TestSuite $suite)
  {
    $meta = [];
    $name = $suite->getName();
    // Only for classes.
    try {
      $reflection = new ReflectionClass($name);
      $meta = self::parseDocBlock($reflection);
      $this->view->startEvent("suite", $name, $meta);
    }
    catch(ReflectionException $e) {
      $this->view->startEvent("noclasssuite", $name, $meta);
    }
  }

  public function endTestSuite(PHPUnit_Framework_TestSuite $suite)
  {
    $name = $suite->getName();
    try {
      $reflection = new ReflectionClass($name);
      $this->view->stopEvent("suite", $name, []);
    }
    catch(ReflectionException $e) {
      $this->view->startEvent("noclasssuite", $name, []);
    }
  }
  
  /**
   * Notify vew listener of test -  belonging to current suite.
   * @see endTest()
   */
  public function startTest(PHPUnit_Framework_Test $test)
  {
    $this->startTime = null;
    $this->endTime = null;
    $meta = $test->getAnnotations();
    $this->view->startEvent("test", $test->getName(), $meta);
  }

  public function endTest(PHPUnit_Framework_Test $test, $time)
  {
    $endTime = isset($this->endTime) ? $this->endTime : microtime(true);
    $time = isset($this->startTime) ? $endTime - $this->startTime : $time;
    $meta = $test->getAnnotations();
    $meta['time'] = $time;
    $this->view->stopEvent("test", $test->getName(), $meta);
  }
  
  /**
   * Optionally used to force setting of test timing. Recommended to use this.
   */
  public function startTestTimer()
  {
    $this->startTime = microtime(true);
  }
  
  /**
   * Optionally used to force setting of test start time. Recommended to use this.
   */  
  public function endTestTimer()
  {
    $this->stopTime = microtime(true);
  }
  
  public static function instance()
  {
    return self::$instance;
  }
  
  private static function parseDocBlock(ReflectionClass $reflection)
  {
    $docBlock = [];
    $m = [];
    $docComment = $reflection->getDocComment();
    if($docComment) {
      preg_match_all("/^\s+\*\s+@(\w+)\s*(.*)\n/m", $docComment, $m);
      $docBlock = array_combine($m[1], $m[2]);
    }
    return $docBlock;
  }
}


/**
 * Collects test stats, then renders them via a Twig template.
 */
class View
{
  private $stack = [];
  private $suites = [];
  private $twig;

  public function __construct($tmpl = './tmpl/') 
  {
    $loader = new Twig_Loader_Filesystem($tmpl);
    $this->twig = new Twig_Environment(
      $loader,
      ['debug' => true]
    );
    $this->twig->addExtension(new Twig_Extension_Debug());
  }

  public function startEvent($eventType, $eventName, $meta) {
    if(is_callable([$this,"start_{$eventType}"])) {
      $this->stack[] = $eventType . $eventName;
      call_user_func_array([$this, "start_{$eventType}"], [$eventName, $meta]);
    }
  }
  
  public function stopEvent($eventType, $eventName, $meta) {
    if(is_callable([$this,"stop_{$eventType}"])) {
      if($this->stack[sizeof($this->stack)-1] != $eventType . $eventName) {
        throw new Exception("Stop event doesn't match started event.");
      }
      call_user_func_array([$this, "stop_{$eventType}"], [$eventName, $meta]);
      array_pop($this->stack);
    }
  } 

  public function start_suite($name, $meta) {
    debug("Start suite $name\n");
    $name = isset($meta['name']) ? $meta['name'] : $name;
    $newSuite = [
      'name' => $name,
      'meta' => $meta,
      'tests' => [],
      'stats' => ['min' => INF, 'max' => -INF, 'cnt' => 0]
    ];
    $this->suites[] = $newSuite;
  }
  
  public function stop_suite($name, $meta) {
    debug("Stop suite $name\n");
  }
  
  public function start_test($name, $meta) {
    debug("\tStart test $name\n");
  }
  
  public function stop_test($name, $meta) {
    debug("\tStop test $name\n");
    $name = isset($meta['method']['name'][0]) ? $meta['method']['name'][0] : $name;
    $newTest = [
      'name' => $name,
      'meta' => $meta
    ];
    $currentSuite =& $this->getCurrentSuite();
    $currentSuite['tests'][] = $newTest;
  }
  
  public function render() {
    print $this->twig->render("suites.html", ['suites' => $this->suites]);
  }

  private function &getCurrentSuite() {
    return $this->suites[count($this->suites)-1];
  }
}

function debug($msg) {
  fprintf(STDERR, $msg . "\n");
}
