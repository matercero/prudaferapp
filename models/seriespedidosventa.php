<?php
class Seriespedidosventa extends AppModel {
	var $name = 'Seriespedidosventa';
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
			'foreignKey' => 'seriespedidosventa_id',
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