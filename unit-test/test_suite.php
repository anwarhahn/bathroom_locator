<?php
require_once('simpletest/autorun.php');

class AllFileTests extends TestSuite {
	function __construct() {
		parent::__construct();
		$this->addFile('sample_test.php');
	}
}
?>