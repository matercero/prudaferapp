<?php
class Seriespedidoscompra extends AppModel {
	var $name = 'Seriespedidoscompra';
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
			'foreignKey' => 'seriespedidoscompra_id',
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