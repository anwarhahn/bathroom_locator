<?php
class Sample {
	function __construct() {
		#print "In Sample constructor\n";
	}

	function method1($arg) {
		#echo "In Method1\n";
		return $arg;
	}

	function method2() {
		#echo "In Method2\n";
		return "Hello World!";
	}

	function fail() {
		return $this->method2() . "!";
	}
}
?>