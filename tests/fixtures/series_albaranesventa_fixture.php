<?php
/* SeriesAlbaranesventa Fixture generated on: 2012-08-30 14:08:44 : 1346331044 */
class SeriesAlbaranesventaFixture extends CakeTestFixture {
	var $name = 'SeriesAlbaranesventa';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'serie' => array('type' => 'string', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'serie' => 'Lorem ipsum dolor sit amet'
		),
	);
}
?>