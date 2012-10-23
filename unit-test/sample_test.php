<?php
require_once('simpletest/autorun.php');
require_once('sample_php.php');

class TestOfSample extends UnitTestCase {

	private $sample = NULL;


	function setUp() {
		$this->sample =& new Sample();
    }

    function tearDown() {
    	$this->sample = NULL;
    }

	function testMethod1() {
		$res = $this->sample->method1("goodbye");
		$this->assertEqual($res, "goodbye");
	}

	function testMethod2() {
		$res = $this->sample->method2();
		$this->assertEqual($res, "Hello World!");	
	}

	function testFail() {
		$res = $this->sample->fail();
		#$this->assertEqual($res, "Hello World!");	
	}
}
?>