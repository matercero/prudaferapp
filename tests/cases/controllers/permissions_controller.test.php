<?php
/* Permissions Test cases generated on: 2011-09-09 11:09:38 : 1315559378*/
App::import('Controller', 'Permissions');

class TestPermissionsController extends PermissionsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class PermissionsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.permission', 'app.group', 'app.groups_permission', 'app.user', 'app.mecanico', 'app.groups_user');

	function startTest() {
		$this->Permissions =& new TestPermissionsController();
		$this->Permissions->constructClasses();
	}

	function endTest() {
		unset($this->Permissions);
		ClassRegistry::flush();
	}

	function testIndex() {

	}

	function testView() {

	}

	function testAdd() {

	}

	function testEdit() {

	}

	function testDelete() {

	}

}
?>