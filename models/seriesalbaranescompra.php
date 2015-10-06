<?php
class Seriesalbaranescompra extends AppModel {
	var $name = 'Seriesalbaranescompra';
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
			'foreignKey' => 'seriesalbaranescompra_id',
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