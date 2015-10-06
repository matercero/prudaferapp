<?php
class Seriespresupuestoscompra extends AppModel {
	var $name = 'Seriespresupuestoscompra';
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
			'foreignKey' => 'seriespresupuestoscompra_id',
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