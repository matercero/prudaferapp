<?php
class Seriesfacturascompra extends AppModel {
	var $name = 'Seriesfacturascompra';
	var $displayField = 'serie';
	var $validate = array(
		'serie' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		),
	);

	var $hasMany = array(
		'Config' => array(
			'className' => 'Config',
			'foreignKey' => 'seriesfacturascompra_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

}
?>