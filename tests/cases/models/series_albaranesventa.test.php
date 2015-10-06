<?php
/* SeriesAlbaranesventa Test cases generated on: 2012-08-30 14:08:44 : 1346331044*/
App::import('Model', 'SeriesAlbaranesventa');

class SeriesAlbaranesventaTestCase extends CakeTestCase {
	var $fixtures = array('app.series_albaranesventa', 'app.config');

	function startTest() {
		$this->SeriesAlbaranesventa =& ClassRegistry::init('SeriesAlbaranesventa');
	}

	function endTest() {
		unset($this->SeriesAlbaranesventa);
		ClassRegistry::flush();
	}

}
?>