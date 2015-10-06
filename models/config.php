<?php

class Config extends AppModel {

    var $name = 'Config';
    var $displayField = 'id';
    
    var $belongsTo = array(
        'SeriesAlbaranesventa' => array(
            'className' => 'SeriesAlbaranesventa',
            'foreignKey' => 'series_albaranesventa_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Seriespresupuestosventa' => array(
            'className' => 'Seriespresupuestosventa',
            'foreignKey' => 'seriespresupuestosventa_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Seriesfacturasventa' => array(
            'className' => 'Seriesfacturasventa',
            'foreignKey' => 'seriesfacturasventa_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Seriespedidosventa' => array(
            'className' => 'Seriespedidosventa',
            'foreignKey' => 'seriespedidosventa_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Seriespresupuestoscompra' => array(
            'className' => 'Seriespresupuestoscompra',
            'foreignKey' => 'seriespresupuestoscompra_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Seriespedidoscompra' => array(
            'className' => 'Seriespedidoscompra',
            'foreignKey' => 'seriespedidoscompra_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Seriesalbaranescompra' => array(
            'className' => 'Seriesalbaranescompra',
            'foreignKey' => 'seriesalbaranescompra_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Seriesfacturascompra' => array(
            'className' => 'Seriesfacturascompra',
            'foreignKey' => 'seriesfacturascompra_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Tiposiva' => array(
            'className' => 'Tiposiva',
            'foreignKey' => 'tiposiva_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
    );

}

?>