<?php

class FacturasClientesController extends AppController {

    var $name = 'FacturasClientes';
    var $components = array('FileUpload', 'Email');
    var $helpers = array('Autocomplete', 'Time', 'Form');

    function beforeFilter() {
        parent::beforeFilter();
        if ($this->params['action'] == 'edit' || $this->params['action'] == 'add') {
            $this->FileUpload->fileModel = 'FacturasCliente';
            $this->FileUpload->uploadDir = 'files/facturascliente';
            $this->FileUpload->fields = array('name' => 'file_name', 'type' => 'file_type', 'size' => 'file_size');
        }
        $this->loadModel('Config');
        $this->set('config', $this->Config->read(null, 1));
        $this->set('series', $this->Config->Seriesfacturasventa->find('list', array('fields' => array('Seriesfacturasventa.serie', 'Seriesfacturasventa.serie'))));
    }

    function index() {

        $contain = array('Estadosfacturascliente', 'Cliente');
        $conditions = array();

        if (!empty($this->params['url']['serie']))
            $conditions [] = array('FacturasCliente.serie' => $this->params['url']['serie']);
        if (!empty($this->params['named']['serie']))
            $conditions [] = array('FacturasCliente.serie' => $this->params['named']['serie']);


        if (!empty($this->params['url']['numero']))
            $conditions [] = array('FacturasCliente.numero' => $this->params['url']['numero']);
        if (!empty($this->params['named']['numero']))
            $conditions [] = array('FacturasCliente.numero' => $this->params['named']['numero']);


        if (!empty($this->params['url']['fecha_inicio']) && !empty($this->params['url']['fecha_fin'])) {
            $data1 = implode('-', array_reverse($this->params['url']['fecha_inicio']));
            $data2 = implode('-', array_reverse($this->params['url']['fecha_fin']));
            $conditions[] = array("FacturasCliente.fecha BETWEEN '$data1' AND '$data2'");
        }
        if (!empty($this->params['named']['fecha_inicio[year]']) && !empty($this->params['named']['fecha_fin[year]'])) {
            $data1 = $this->params['named']['fecha_inicio[year]'] . '-' . $this->params['named']['fecha_inicio[month]'] . '-' . $this->params['named']['fecha_inicio[day]'];
            $data2 = $this->params['named']['fecha_fin[year]'] . '-' . $this->params['named']['fecha_fin[month]'] . '-' . $this->params['named']['fecha_fin[day]'];
            $conditions[] = array("FacturasCliente.fecha BETWEEN '$data1' AND '$data2'");
        }

        if (!empty($this->params['url']['cliente_id']))
            $conditions [] = array('1' => '1 AND FacturasCliente.cliente_id = "' . $this->params['url']['cliente_id'] . '"');
        if (!empty($this->params['named']['cliente_id']))
            $conditions [] = array('1' => '1 AND FacturasCliente.cliente_id = "' . $this->params['named']['cliente_id'] . '"');

        if (!empty($this->params['url']['modoEnvFac']))
            $conditions [] = array('1' => '1 AND Cliente.modoenviofactura = "' . $this->params['url']['modoEnvFac'] . '"');
        if (!empty($this->params['named']['modoEnvFac']))
            $conditions [] = array('1' => '1 AND Cliente.modoenviofactura = "' . $this->params['named']['modoEnvFac'] . '"');

        if (!empty($this->params['url']['numero_ordene'])) {
            $conditions [] = array('OR' => array(
                    array('1' => '1 AND FacturasCliente.id IN (SELECT Albaranescliente.facturas_cliente_id FROM albaranesclientes Albaranescliente WHERE Albaranescliente.ordene_id IN (SELECT Ordene.id FROM ordenes Ordene WHERE Ordene.numero = "' . $this->params['url']['numero_ordene'] . '"))'),
                    array('1' => '1 AND FacturasCliente.id IN (SELECT Albaranesclientesreparacione.facturas_cliente_id FROM albaranesclientesreparaciones Albaranesclientesreparacione WHERE Albaranesclientesreparacione.ordene_id IN (SELECT Ordene.id FROM ordenes Ordene WHERE Ordene.numero = "' . $this->params['url']['numero_ordene'] . '"))'),
            ));
        }
        if (!empty($this->params['named']['numero_ordene'])) {
            $conditions [] = array('OR' => array(
                    array('1' => '1 AND FacturasCliente.id IN (SELECT Albaranescliente.facturas_cliente_id FROM albaranesclientes Albaranescliente WHERE Albaranescliente.ordene_id IN (SELECT Ordene.id FROM ordenes Ordene WHERE Ordene.numero = "' . $this->params['named']['numero_ordene'] . '"))'),
                    array('1' => '1 AND FacturasCliente.id IN (SELECT Albaranesclientesreparacione.facturas_cliente_id FROM albaranesclientesreparaciones Albaranesclientesreparacione WHERE Albaranesclientesreparacione.ordene_id IN (SELECT Ordene.id FROM ordenes Ordene WHERE Ordene.numero = "' . $this->params['named']['numero_ordene'] . '"))'),
            ));
        }

        if (!empty($this->params['url']['numero_avisostallere'])) {
            $conditions [] = array('OR' => array(
                    array('1' => '1 AND FacturasCliente.id IN (SELECT Albaranescliente.facturas_cliente_id FROM albaranesclientes Albaranescliente WHERE Albaranescliente.avisostallere_id IN (SELECT Avisostallere.id FROM avisostalleres Avisostallere WHERE Avisostallere.numero = "' . $this->params['url']['numero_avisostallere'] . '"))'),
                    array('1' => '1 AND FacturasCliente.id IN (SELECT Albaranesclientesreparacione.facturas_cliente_id FROM albaranesclientesreparaciones Albaranesclientesreparacione WHERE Albaranesclientesreparacione.avisostallere_id IN (SELECT Avisostallere.id FROM avisostalleres Avisostallere WHERE Avisostallere.numero = "' . $this->params['url']['numero_avisostallere'] . '"))'),
            ));
        }
        if (!empty($this->params['named']['numero_avisostallere'])) {
            $conditions [] = array('OR' => array(
                    array('1' => '1 AND FacturasCliente.id IN (SELECT Albaranescliente.facturas_cliente_id FROM albaranesclientes Albaranescliente WHERE Albaranescliente.avisostallere_id IN (SELECT Avisostallere.id FROM avisostalleres Avisostallere WHERE Avisostallere.numero = "' . $this->params['named']['numero_avisostallere'] . '"))'),
                    array('1' => '1 AND FacturasCliente.id IN (SELECT Albaranesclientesreparacione.facturas_cliente_id FROM albaranesclientesreparaciones Albaranesclientesreparacione WHERE Albaranesclientesreparacione.avisostallere_id IN (SELECT Avisostallere.id FROM avisostalleres Avisostallere WHERE Avisostallere.numero = "' . $this->params['named']['numero_avisostallere'] . '"))'),
            ));
        }


        if (!empty($this->params['url']['numero_avisosrepuesto'])) {
            $conditions [] = array('OR' => array(
                    array('1' => '1 AND FacturasCliente.id IN (SELECT Albaranescliente.facturas_cliente_id FROM albaranesclientes Albaranescliente WHERE Albaranescliente.avisostallere_id IN (SELECT Avisostallere.id FROM avisostalleres Avisostallere WHERE Avisostallere.numero = "' . $this->params['url']['numero_avisostallere'] . '"))'),
                    array('1' => '1 AND FacturasCliente.id IN (SELECT Albaranesclientesreparacione.facturas_cliente_id FROM albaranesclientesreparaciones Albaranesclientesreparacione WHERE Albaranesclientesreparacione.avisostallere_id IN (SELECT Avisostallere.id FROM avisostalleres Avisostallere WHERE Avisostallere.numero = "' . $this->params['url']['numero_avisostallere'] . '"))'),
            ));
        }
        if (!empty($this->params['named']['numero_avisosrepuesto'])) {
            $conditions [] = array('OR' => array(
                    array('1' => '1 AND FacturasCliente.id IN (SELECT Albaranescliente.facturas_cliente_id FROM albaranesclientes Albaranescliente WHERE Albaranescliente.avisosrepuesto_id IN (SELECT Avisosrepuesto.id FROM avisosrepuestos Avisosrepuesto WHERE Avisosrepuesto.numero = "' . $this->params['named']['numero_avisosrepuesto'] . '"))'),
                    array('1' => '1 AND FacturasCliente.id IN (SELECT Albaranesclientesreparacione.facturas_cliente_id FROM albaranesclientesreparaciones Albaranesclientesreparacione WHERE Albaranesclientesreparacione.avisosrepuesto_id IN (SELECT Avisosrepuesto.id FROM avisosrepuestos Avisosrepuesto WHERE Avisosrepuesto.numero = "' . $this->params['named']['numero_avisosrepuesto'] . '"))'),
            ));
        }

        /* Albaranes buscador */

        if (!empty($this->params['url']['serie_albaran'])) {
            $conditions [] = array('OR' => array(
                    array('1' => '1 AND FacturasCliente.id IN (SELECT Albaranescliente.facturas_cliente_id FROM albaranesclientes Albaranescliente WHERE Albaranescliente.serie =  "' . $this->params['url']['serie_albaran'] . '")'),
                    array('1' => '1 AND FacturasCliente.id IN (SELECT Albaranesclientesreparacione.facturas_cliente_id FROM albaranesclientesreparaciones Albaranesclientesreparacione WHERE Albaranesclientesreparacione.serie = "' . $this->params['url']['serie_albaran'] . '")'),
            ));
        }
        if (!empty($this->params['named']['serie_albaran'])) {
            $conditions [] = array('OR' => array(
                    array('1' => '1 AND FacturasCliente.id IN (SELECT Albaranescliente.facturas_cliente_id FROM albaranesclientes Albaranescliente WHERE Albaranescliente.serie =  "' . $this->params['named']['serie_albaran'] . '")'),
                    array('1' => '1 AND FacturasCliente.id IN (SELECT Albaranesclientesreparacione.facturas_cliente_id FROM albaranesclientesreparaciones Albaranesclientesreparacione WHERE Albaranesclientesreparacione.serie = "' . $this->params['named']['serie_albaran'] . '")'),
            ));
        }

        if (!empty($this->params['url']['numero_albaran'])) {
            $conditions [] = array('OR' => array(
                    array('1' => '1 AND FacturasCliente.id IN (SELECT Albaranescliente.facturas_cliente_id FROM albaranesclientes Albaranescliente WHERE Albaranescliente.numero =  "' . $this->params['url']['numero_albaran'] . '")'),
                    array('1' => '1 AND FacturasCliente.id IN (SELECT Albaranesclientesreparacione.facturas_cliente_id FROM albaranesclientesreparaciones Albaranesclientesreparacione WHERE Albaranesclientesreparacione.numero = "' . $this->params['url']['numero_albaran'] . '")'),
            ));
        }
        if (!empty($this->params['named']['numero_albaran'])) {
            $conditions [] = array('OR' => array(
                    array('1' => '1 AND FacturasCliente.id IN (SELECT Albaranescliente.facturas_cliente_id FROM albaranesclientes Albaranescliente WHERE Albaranescliente.numero =  "' . $this->params['named']['numero_albaran'] . '")'),
                    array('1' => '1 AND FacturasCliente.id IN (SELECT Albaranesclientesreparacione.facturas_cliente_id FROM albaranesclientesreparaciones Albaranesclientesreparacione WHERE Albaranesclientesreparacione.numero = "' . $this->params['named']['numero_albaran'] . '")'),
            ));
        }

        /*         * Fin albaranes buscador */

        $paginate_results_per_page = 20;
        if (!empty($this->params['url']['resultados_por_pagina']))
            $paginate_results_per_page = intval($this->params['url']['resultados_por_pagina']);
        if (!empty($this->params['named']['resultados_por_pagina']))
            $paginate_results_per_page = intval($this->params['named']['resultados_por_pagina']);

        $this->paginate = array('limit' => $paginate_results_per_page, 'contain' => $contain, 'conditions' => $conditions, 'url' => $this->params['pass']);



        $this->loadModel('Config');
        $this->set('series_albaranes', $this->Config->SeriesAlbaranesventa->find('list', array('fields' => array('SeriesAlbaranesventa.serie', 'SeriesAlbaranesventa.serie'))));
        $this->set('facturasClientes', $this->paginate());
        if (!empty($this->params['url']['pdf'])) {
            $this->layout = 'pdf';
            $this->render('/facturas_clientes/pdfFilter');
        }
    }

    function view($id = null) {
        if (!$id) {
            $this->flashWarnings(__('Invalid facturas cliente', true));
            $this->redirect($this->referer());
        }
        $this->set('facturasCliente', $this->FacturasCliente->find(
                        'first', array(
                    'contain' => array(
                        'Estadosfacturascliente',
                        'Cliente' => array('Formapago', 'Cuentasbancaria'),
                        'Albaranescliente' => array('Tiposiva', 'Cliente', 'Centrosdecoste'),
                        'Albaranesclientesreparacione' => array('Tiposiva', 'Cliente', 'Centrosdecoste')
                    ),
                    'conditions' => array('FacturasCliente.id' => $id)
                        )
                )
        );
    }

    function pdf($id) {
        Configure::write('debug', 0);
        $this->layout = 'pdf';
        if (!$id) {
            $this->flashWarnings(__('Factura Inválida', true));
            $this->redirect($this->referer());
        }
        $this->set('facturasCliente', $this->FacturasCliente->find(
                        'first', array(
                    'contain' => array(
                        'Estadosfacturascliente',
                        'Cliente' => array('Formapago', 'Cuentasbancaria'),
                        'Albaranescliente' => array(
                            'FacturasCliente' => 'Cliente',
                            'Estadosalbaranescliente',
                            'Maquina',
                            'Tiposiva',
                            'Comerciale',
                            'Centrosdecoste',
                            'Almacene',
                            'Cliente' => 'Formapago',
                            'Centrostrabajo',
                            'Pedidoscliente' => array(
                                'Presupuestoscliente' => 'Cliente'),
                            'Avisosrepuesto' => array('Cliente', 'Centrostrabajo', 'Maquina'),
                            'Tareasalbaranescliente' => array('MaterialesTareasalbaranescliente' => 'Articulo', 'ManodeobrasTareasalbaranescliente', 'TareasalbaranesclientesOtrosservicio'), 'Avisosrepuesto' => array('Cliente', 'Centrostrabajo', 'Maquina')),
                        'Albaranesclientesreparacione' => array(
                            'Estadosalbaranesclientesreparacione',
                            'TareasAlbaranesclientesreparacione' => array(
                                'TareasAlbaranesclientesreparacionesParte' => 'Mecanico',
                                'TareasAlbaranesclientesreparacionesPartestallere' => 'Mecanico',
                                'ArticulosTareasAlbaranesclientesreparacione' => 'Articulo'),
                            'Ordene' => array(
                                'Centrostrabajo',
                                'Cliente',
                                'Avisostallere' => array('Centrostrabajo', 'Cliente')),
                            'Centrosdecoste',
                            'Comerciale',
                            'Almacene',
                            'Maquina',
                            'FacturasCliente' => 'Cliente',
                            'Cliente' => 'Formapago',
                            'Centrostrabajo',
                            'Tiposiva'
                        )
                    ),
                    'conditions' => array('FacturasCliente.id' => $id)
                        )
                )
        );
        $this->render();
    }

    function add() {
        $this->FacturasCliente->recursive = 2;
        if (!empty($this->data)) {
            $this->FacturasCliente->create();
            if ($this->FacturasCliente->save($this->data)) {
                $id = $this->FacturasCliente->id;
                if ($this->FileUpload->finalFile != null) {
                    $this->FacturasCliente->saveField('facturaescaneada', $this->FileUpload->finalFile);
                }
                $this->Session->setFlash(__('The facturas cliente has been saved', true));
                $this->redirect(array('action' => 'view', $this->FacturasCliente->id));
            } else {
                $this->flashWarnings(__('The facturas cliente could not be saved. Please, try again.', true));
            }
        }
        $series = $this->Config->Seriesfacturasventa->find('list', array('fields' => array('Seriesfacturasventa.serie', 'Seriesfacturasventa.serie')));
        $albaranesclientes = $this->FacturasCliente->Albaranescliente->find('list');
        $this->set(compact('albaranesclientes'));
    }

    function edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->flashWarnings(__('Invalid facturas cliente', true));
            $this->redirect($this->referer());
        }
        if (!empty($this->data)) {
            if ($this->FacturasCliente->save($this->data)) {
                $id = $this->FacturasCliente->id;
                $upload = $this->FacturasCliente->findById($id);
                if (!empty($this->data['FacturasCliente']['remove_file'])) {
                    $this->FileUpload->RemoveFile($upload['FacturasCliente']['facturaescaneada']);
                    $this->FacturasCliente->saveField('facturaescaneada', null);
                }
                if ($this->FileUpload->finalFile != null) {
                    $this->FileUpload->RemoveFile($upload['FacturasCliente']['facturaescaneada']);
                    $this->FacturasCliente->saveField('facturaescaneada', $this->FileUpload->finalFile);
                }
                $this->Session->setFlash(__('The facturas cliente has been saved', true));
                $this->redirect($this->referer());
            } else {
                $this->flashWarnings(__('The facturas cliente could not be saved. Please, try again.', true));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->FacturasCliente->read(null, $id);
        }
        $series = $this->Config->Seriesfacturasventa->find('list', array('fields' => array('Seriesfacturasventa.serie', 'Seriesfacturasventa.serie')));
        $this->set('series', $series);
        $this->set('estadosfacturasclientes', $this->FacturasCliente->Estadosfacturascliente->find('list'));
        $this->set('clientes', $this->FacturasCliente->Cliente->find('list'));
    }

    function delete($id = null) {
        if (!$id) {
            $this->flashWarnings(__('Invalid id for facturas cliente', true));
            $this->redirect($this->referer());
        }
        $id = $this->FacturasCliente->id;
        $upload = $this->FacturasCliente->findById($id);
        $this->FileUpload->RemoveFile($upload['FacturasCliente']['facturaescaneada']);
        if ($this->FacturasCliente->delete($id)) {
            $this->Session->setFlash(__('Facturas cliente deleted', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->flashWarnings(__('No se pudo borrar la factura cliente', true));
        $this->redirect($this->referer());
    }

    function facturacion() {
        if (!empty($this->data)) {
            $fecha_inicio = date('Y-m-d', strtotime($this->data['Filtro']['fecha_inicio']['year'] . '-' . $this->data['Filtro']['fecha_inicio']['month'] . '-' . $this->data['Filtro']['fecha_inicio']['day']));
            $fecha_fin = date('Y-m-d', strtotime($this->data['Filtro']['fecha_fin']['year'] . '-' . $this->data['Filtro']['fecha_fin']['month'] . '-' . $this->data['Filtro']['fecha_fin']['day']));
            $cliente_facturable_list = array();
            if (!empty($this->data['Filtro']['todos'])) {
                $conditions = array();
                $conditions [] = array('1' => '1 AND ((SELECT COUNT(Albaranescliente.id) FROM albaranesclientes Albaranescliente WHERE Albaranescliente.cliente_id = Cliente.id AND Albaranescliente.facturable = 1 AND Albaranescliente.estadosalbaranescliente_id = 2 AND Albaranescliente.serie IN ("' . implode('","', $this->data['Filtro']['seriesAlbaranesventa']) . '") AND Albaranescliente.fecha BETWEEN "' . $fecha_inicio . '" AND "' . $fecha_fin . '") > 0 OR (SELECT COUNT(Albaranesclientesreparacione.id) FROM albaranesclientesreparaciones Albaranesclientesreparacione WHERE Albaranesclientesreparacione.facturable = 1 AND Albaranesclientesreparacione.serie IN ("' . implode('", "', $this->data['Filtro']['seriesAlbaranesventa']) . '") AND Albaranesclientesreparacione.estadosalbaranesclientesreparacione_id = 2 AND Albaranesclientesreparacione.fecha BETWEEN "' . $fecha_inicio . '" AND "' . $fecha_fin . '") ) > 0');
                $clientes = $this->FacturasCliente->Cliente->find('all', array('contain' => '', 'conditions' => $conditions));
                foreach ($clientes as $key => $cliente) {
                    $this->FacturasCliente->Cliente->id = $cliente['Cliente']['id'];
                    $cliente_facturable = $this->FacturasCliente->Cliente->get_cliente_facturable($fecha_inicio, $fecha_fin, $this->data['Filtro']['seriesAlbaranesventa']);
                    $cliente_facturable_list[] = $cliente_facturable;
                }
            } else {
                $conditions = array();
                $conditions [] = array('Cliente.id' => $this->data['Filtro']['Cliente']);
                $conditions [] = array('1' => '1 AND ( (SELECT COUNT(Albaranescliente.id) FROM albaranesclientes Albaranescliente WHERE Albaranescliente.cliente_id = Cliente.id AND Albaranescliente.serie IN ("' . implode('","', $this->data['Filtro']['seriesAlbaranesventa']) . '")  AND Albaranescliente.facturable = 1 AND Albaranescliente.estadosalbaranescliente_id = 2 AND Albaranescliente.fecha BETWEEN "' . $fecha_inicio . '" AND "' . $fecha_fin . '") > 0 OR (SELECT COUNT(Albaranesclientesreparacione.id) FROM albaranesclientesreparaciones Albaranesclientesreparacione WHERE Albaranesclientesreparacione.cliente_id = Cliente.id AND Albaranesclientesreparacione.serie IN ("' . implode('","', $this->data['Filtro']['seriesAlbaranesventa']) . '")  AND Albaranesclientesreparacione.facturable = 1 AND Albaranesclientesreparacione.estadosalbaranesclientesreparacione_id = 2 AND Albaranesclientesreparacione.fecha BETWEEN "' . $fecha_inicio . '" AND "' . $fecha_fin . '") ) > 0');
                $clientes = $this->FacturasCliente->Cliente->find('all', array('contain' => '', 'conditions' => $conditions));
                foreach ($clientes as $key => $cliente) {
                    $this->FacturasCliente->Cliente->id = $cliente['Cliente']['id'];
                    $cliente_facturable = $this->FacturasCliente->Cliente->get_cliente_facturable($fecha_inicio, $fecha_fin);
                    $cliente_facturable_list[] = $cliente_facturable;
                }
            }
            $siguiente_numero = $this->FacturasCliente->dime_siguiente_numero();
            $this->loadModel('Seriesfacturasventa');
            $this->set('seriesfacturasventas', $this->Seriesfacturasventa->find('list', array('fields' => array('Seriesfacturasventa.serie', 'Seriesfacturasventa.serie'))));
            $this->set('serie_selecionada', $this->data['Filtro']['serie_factura']);
            $this->set('fecha_selecionada', $this->data['Filtro']['fecha_factura']);
            $this->set(compact('cliente_facturable_list', 'siguiente_numero'));
            $this->render('facturacion_list');
        }
        $this->loadModel('SeriesAlbaranesventa');
        $this->set('seriesAlbaranesventas', $this->SeriesAlbaranesventa->find('list', array('fields' => array('SeriesAlbaranesventa.serie', 'SeriesAlbaranesventa.serie'))));
        $this->loadModel('Seriesfacturasventa');
        $this->set('seriesfacturasventas', $this->Seriesfacturasventa->find('list', array('fields' => array('Seriesfacturasventa.serie', 'Seriesfacturasventa.serie'))));
    }

    function facturar() {
        if (!empty($this->data)) {
            $facturascliente_ids = array();
            $siguiente_numero = null;
            foreach ($this->data['facturable'] as $facturable) {
                if ($siguiente_numero === null)
                    $siguiente_numero = $this->FacturasCliente->dime_siguiente_numero($facturable['serie']);
                else
                    $siguiente_numero++;
                $this->FacturasCliente->create();
                $facturas_cliente = array();
                $cliente_id = $facturable['cliente_id'];
                $fecha = $facturable['fecha']['year'] . '-' . $facturable['fecha']['month'] . '-' . $facturable['fecha']['day'];
                $baseimponible = 0;
                $impuestos = 0;

                $facturas_cliente['FacturasCliente']['serie'] = $facturable['serie'];
                $facturas_cliente['FacturasCliente']['numero'] = $siguiente_numero;
                $facturas_cliente['FacturasCliente']['fecha'] = $fecha;
                $facturas_cliente['FacturasCliente']['baseimponible'] = 0;
                $facturas_cliente['FacturasCliente']['cliente_id'] = $cliente_id;
                $facturas_cliente['FacturasCliente']['impuestos'] = 0;
                $facturas_cliente['FacturasCliente']['total'] = 0;
                if (!empty($facturable['albaranescliente']) || !empty($facturable['albaranesclientesreparacione'])) {
                    $this->FacturasCliente->save($facturas_cliente);
                    if (!empty($facturable['albaranescliente']))
                        foreach ($facturable['albaranescliente'] as $albarane_id) {
                            $albranescliente = $this->FacturasCliente->Albaranescliente->find('first', array('contain' => array(), 'conditions' => array('Albaranescliente.id' => $albarane_id)));
                            $this->FacturasCliente->Albaranescliente->id = $albranescliente['Albaranescliente']['id'];
                            $this->FacturasCliente->Albaranescliente->saveField('facturas_cliente_id', $this->FacturasCliente->id);
                            $this->FacturasCliente->Albaranescliente->saveField('estadosalbaranescliente_id', 3);
                            $baseimponible += $albranescliente['Albaranescliente']['precio'];
                            $impuestos += $albranescliente['Albaranescliente']['impuestos'];
                        }
                    if (!empty($facturable['albaranesclientesreparacione']))
                        foreach ($facturable['albaranesclientesreparacione'] as $albaranereparacione_id) {
                            $albranescliente = $this->FacturasCliente->Albaranesclientesreparacione->find('first', array('contain' => array('Tiposiva'), 'conditions' => array('Albaranesclientesreparacione.id' => $albaranereparacione_id)));
                            $this->FacturasCliente->Albaranesclientesreparacione->id = $albranescliente['Albaranesclientesreparacione']['id'];
                            $this->FacturasCliente->Albaranesclientesreparacione->saveField('facturas_cliente_id', $this->FacturasCliente->id);
                            $this->FacturasCliente->Albaranesclientesreparacione->saveField('estadosalbaranesclientesreparacione_id', 3);
                            $baseimponible += $albranescliente['Albaranesclientesreparacione']['baseimponible'];
                            $impuestos += $albranescliente['Albaranesclientesreparacione']['baseimponible'] * $albranescliente['Tiposiva']['porcentaje_aplicable'] / 100;
                        }
                    $this->FacturasCliente->saveField('baseimponible', redondear_dos_decimal($baseimponible));
                    $this->FacturasCliente->saveField('impuestos', redondear_dos_decimal($impuestos));
                    $this->FacturasCliente->saveField('total', redondear_dos_decimal($baseimponible + $impuestos));
                    $facturascliente_ids[] = $this->FacturasCliente->id;
                }
            }
            $facturasClientes = $this->FacturasCliente->find('all', array('contain' => array('Cliente', 'Estadosfacturascliente'), 'conditions' => array('FacturasCliente.id' => $facturascliente_ids)));
            $this->set(compact('facturasClientes'));
        } else {
            $this->flashWarnings(__('La Facturacion no puede ser realizada', true));
            $this->redirect($this->referer());
        }
    }

    function quitar_albaran_repuestos($albaranescliente_id) {
        $albaranescliente = $this->FacturasCliente->Albaranescliente->find('first', array('contain' => array(), 'conditions' => array('Albaranescliente.id' => $albaranescliente_id)));
        $this->FacturasCliente->Albaranescliente->id = $albaranescliente['Albaranescliente']['id'];
        $this->FacturasCliente->Albaranescliente->saveField('facturas_cliente_id', null);
        $this->FacturasCliente->id = $albaranescliente['Albaranescliente']['facturas_cliente_id'];
        $this->FacturasCliente->recalcular_totales();
        $this->redirect($this->referer());
    }

    function quitar_albaran_reparacion($albaranesclientesreparacione_id) {
        $albaranescliente = $this->FacturasCliente->Albaranesclientesreparacione->find('first', array('contain' => array(), 'conditions' => array('Albaranesclientesreparacione.id' => $albaranesclientesreparacione_id)));
        $this->FacturasCliente->Albaranesclientesreparacione->id = $albaranescliente['Albaranesclientesreparacione']['id'];
        $this->FacturasCliente->Albaranesclientesreparacione->saveField('facturas_cliente_id', null);
        $this->FacturasCliente->id = $albaranescliente['Albaranesclientesreparacione']['facturas_cliente_id'];
        $this->FacturasCliente->recalcular_totales();
        $this->redirect($this->referer());
    }

    function imprimirfacturacion() {
        Configure::write('debug', 0);
        if (empty($this->data)) {
            $this->flashWarnings(__('No has realizado la facturación', true));
            $this->redirect($this->referer());
        }
        if (!empty($this->data)) {
            //Configure::write('debug', 0);
            $this->layout = 'pdf';
            foreach ($this->data['FacturasCliente']['ids'] as $factura_id) {

                $facturasClientes[] = $this->FacturasCliente->find(
                        'first', array(
                    'contain' => array(
                        'Estadosfacturascliente',
                        'Cliente' => array('Formapago', 'Cuentasbancaria'),
                        'Albaranescliente' => array(
                            'FacturasCliente' => 'Cliente',
                            'Estadosalbaranescliente',
                            'Maquina',
                            'Tiposiva',
                            'Comerciale',
                            'Centrosdecoste',
                            'Almacene',
                            'Cliente' => 'Formapago',
                            'Centrostrabajo',
                            'Pedidoscliente' => array(
                                'Presupuestoscliente' => 'Cliente'),
                            'Avisosrepuesto' => array('Cliente', 'Centrostrabajo', 'Maquina'),
                            'Tareasalbaranescliente' => array('MaterialesTareasalbaranescliente' => 'Articulo', 'ManodeobrasTareasalbaranescliente', 'TareasalbaranesclientesOtrosservicio'), 'Avisosrepuesto' => array('Cliente', 'Centrostrabajo', 'Maquina')),
                        'Albaranesclientesreparacione' => array(
                            'Estadosalbaranesclientesreparacione',
                            'TareasAlbaranesclientesreparacione' => array(
                                'TareasAlbaranesclientesreparacionesParte' => 'Mecanico',
                                'TareasAlbaranesclientesreparacionesPartestallere' => 'Mecanico',
                                'ArticulosTareasAlbaranesclientesreparacione' => 'Articulo'),
                            'Ordene' => array(
                                'Centrostrabajo',
                                'Cliente',
                                'Avisostallere' => array('Centrostrabajo', 'Cliente')),
                            'Centrosdecoste',
                            'Comerciale',
                            'Almacene',
                            'Maquina',
                            'FacturasCliente' => 'Cliente',
                            'Cliente' => 'Formapago',
                            'Centrostrabajo',
                            'Tiposiva'
                        )
                    ),
                    'conditions' => array('FacturasCliente.id' => $factura_id)
                        )
                );
            }
            $this->set('facturasClientes', $facturasClientes);
            $this->loadModel('Config');
            $this->set('config', $this->Config->read(null, 1));
            $this->render();
        }
    }

    function imprimirtotal($factura_id) {
        Configure::write('debug', 0);
        $this->layout = 'pdf';

        $facturasCliente = $this->FacturasCliente->find(
                'first', array(
            'contain' => array(
                'Estadosfacturascliente',
                'Cliente' => array('Formapago', 'Cuentasbancaria'),
                'Albaranescliente' => array(
                    'FacturasCliente' => 'Cliente',
                    'Estadosalbaranescliente',
                    'Maquina',
                    'Tiposiva',
                    'Comerciale',
                    'Centrosdecoste',
                    'Almacene',
                    'Cliente' => 'Formapago',
                    'Centrostrabajo',
                    'Pedidoscliente' => array(
                        'Presupuestoscliente' => 'Cliente'),
                    'Avisosrepuesto' => array('Cliente', 'Centrostrabajo', 'Maquina'),
                    'Tareasalbaranescliente' => array('MaterialesTareasalbaranescliente' => 'Articulo', 'ManodeobrasTareasalbaranescliente', 'TareasalbaranesclientesOtrosservicio'), 'Avisosrepuesto' => array('Cliente', 'Centrostrabajo', 'Maquina')),
                'Albaranesclientesreparacione' => array(
                    'Estadosalbaranesclientesreparacione',
                    'TareasAlbaranesclientesreparacione' => array(
                        'TareasAlbaranesclientesreparacionesParte' => 'Mecanico',
                        'TareasAlbaranesclientesreparacionesPartestallere' => 'Mecanico',
                        'ArticulosTareasAlbaranesclientesreparacione' => 'Articulo'),
                    'Ordene' => array(
                        'Centrostrabajo',
                        'Cliente',
                        'Avisostallere' => array('Centrostrabajo', 'Cliente')),
                    'Centrosdecoste',
                    'Comerciale',
                    'Almacene',
                    'Maquina',
                    'FacturasCliente' => 'Cliente',
                    'Cliente' => 'Formapago',
                    'Centrostrabajo',
                    'Tiposiva'
                )
            ),
            'conditions' => array('FacturasCliente.id' => $factura_id)
                )
        );
        $this->loadModel('Config');
        $this->set('config', $this->Config->read(null, 1));
        $this->set('facturasCliente', $facturasCliente);
    }

    function imprimircarta($factura_id) {
        Configure::write('debug', 0);
        $this->layout = 'pdf';

        $facturasCliente = $this->FacturasCliente->find(
                'first', array(
            'contain' => array(
                'Estadosfacturascliente',
                'Cliente' => array('Formapago', 'Cuentasbancaria'),
                'Albaranescliente' => array(
                    'FacturasCliente' => 'Cliente',
                    'Estadosalbaranescliente',
                    'Maquina',
                    'Tiposiva',
                    'Comerciale',
                    'Centrosdecoste',
                    'Almacene',
                    'Cliente' => 'Formapago',
                    'Centrostrabajo',
                    'Pedidoscliente' => array(
                        'Presupuestoscliente' => 'Cliente'),
                    'Avisosrepuesto' => array('Cliente', 'Centrostrabajo', 'Maquina'),
                    'Tareasalbaranescliente' => array('MaterialesTareasalbaranescliente' => 'Articulo', 'ManodeobrasTareasalbaranescliente', 'TareasalbaranesclientesOtrosservicio'), 'Avisosrepuesto' => array('Cliente', 'Centrostrabajo', 'Maquina')),
                'Albaranesclientesreparacione' => array(
                    'Estadosalbaranesclientesreparacione',
                    'TareasAlbaranesclientesreparacione' => array(
                        'TareasAlbaranesclientesreparacionesParte' => 'Mecanico',
                        'TareasAlbaranesclientesreparacionesPartestallere' => 'Mecanico',
                        'ArticulosTareasAlbaranesclientesreparacione' => 'Articulo'),
                    'Ordene' => array(
                        'Centrostrabajo',
                        'Cliente',
                        'Avisostallere' => array('Centrostrabajo', 'Cliente')),
                    'Centrosdecoste',
                    'Comerciale',
                    'Almacene',
                    'Maquina',
                    'FacturasCliente' => 'Cliente',
                    'Cliente' => 'Formapago',
                    'Centrostrabajo',
                    'Tiposiva'
                )
            ),
            'conditions' => array('FacturasCliente.id' => $factura_id)
                )
        );
        $this->loadModel('Config');
        $this->set('config', $this->Config->read(null, 1));
        $this->set('facturasCliente', $facturasCliente);
    }

    function enviarfacturasemail() {

        Configure::write('debug', 0);
        if (empty($this->data)) {
            $this->flashWarnings(__('No has realizado la facturación', true));
            $this->redirect($this->referer());
        }
        
        // Configuración del servidor de correo 
        $this->Email->smtpOptions = array(
            'port' => '25',
            'timeout' => '30',
            'host' => 'mail.talleresdafer.com',
            'username' => 'prueba@talleresdafer.com',
            'password' => 'Prueba.dafer*+');

        // Configurar método de entrega
        $this->Email->delivery = 'smtp';
        $this->Email->from = 'prueba@talleresdafer.com';
        // admin@talleresdafer.com Antonio
        // $this->Email->to = array('matercero@gmail.com', 'repuesto2@talleresdafer.com');
        //  $this->Email->to = 'matercero@gmail.com';
        // $this->Email->replyTo = '';
        $this->Email->subject = 'Prueba envio factura';
        $this->Email->template = 'default'; // NOTAR QUE NO HAY '.ctp'
        $this->Email->sendAs = 'both';
        $mensajeBody = 'Prueba del cuerpo del mensaje.';


        $resumenResultado = '';        
        $path = '../webroot/files/facturaEmails/' ;
        
        foreach ($this->data['FacturasCliente']['ids'] as $factura_id) {
            // echo $factura_id . " | ";

            $nombre_fichero = 'factura_' . $factura_id . '.pdf';
            // Path de la factura a adjuntar
            $pathFactura = $path . $nombre_fichero;

            // echo $pathFactura . " | <br/>";
            if (file_exists($pathFactura)) {
                $resumenResultado .= "<h1 style='color:green'><br/>La factura $nombre_fichero EXISTE.</h1>";

                // Recuperamos los datos de facturaCliente
                $facturasCliente = $this->FacturasCliente->find(
                        'first', array(
                    'contain' => array(
                        'Estadosfacturascliente',
                        'Cliente' => array('Formapago', 'Cuentasbancaria'),
                        'Albaranescliente' => array(
                            'FacturasCliente' => 'Cliente',
                            'Estadosalbaranescliente',
                            'Maquina',
                            'Tiposiva',
                            'Comerciale',
                            'Centrosdecoste',
                            'Almacene',
                            'Cliente' => 'Formapago',
                            'Centrostrabajo',
                            'Pedidoscliente' => array(
                                'Presupuestoscliente' => 'Cliente'),
                            'Avisosrepuesto' => array('Cliente', 'Centrostrabajo', 'Maquina'),
                            'Tareasalbaranescliente' => array('MaterialesTareasalbaranescliente' => 'Articulo', 'ManodeobrasTareasalbaranescliente', 'TareasalbaranesclientesOtrosservicio'), 'Avisosrepuesto' => array('Cliente', 'Centrostrabajo', 'Maquina')),
                        'Albaranesclientesreparacione' => array(
                            'Estadosalbaranesclientesreparacione',
                            'TareasAlbaranesclientesreparacione' => array(
                                'TareasAlbaranesclientesreparacionesParte' => 'Mecanico',
                                'TareasAlbaranesclientesreparacionesPartestallere' => 'Mecanico',
                                'ArticulosTareasAlbaranesclientesreparacione' => 'Articulo'),
                            'Ordene' => array(
                                'Centrostrabajo',
                                'Cliente',
                                'Avisostallere' => array('Centrostrabajo', 'Cliente')),
                            'Centrosdecoste',
                            'Comerciale',
                            'Almacene',
                            'Maquina',
                            'FacturasCliente' => 'Cliente',
                            'Cliente' => 'Formapago',
                            'Centrostrabajo',
                            'Tiposiva'
                        )
                    ),
                    'conditions' => array('FacturasCliente.id' => $factura_id)
                        )
                );

//               echo '<pre>';
//                var_dump($facturasCliente['Cliente']['email']);
//                echo '</pre>';
//                
                // PARA (a quien se envia).Dirección a la que se dirige el mensaje (string)          
                //  $this->Email->to = $facturasCliente['Cliente']['email'];
                // $resumenResultado .= "Enviado a = " . $facturasCliente['Cliente']['email'];
                
                /* Mas configuracion 
                 * 
                 * cc -> arreglo de direcciones a enviar copias del mensaje (CC)
                 * bcc -> arreglo de direcciones a enviar las copias ocultas del mensaje (CCO)
                 * replyTo -> dirección de respuesta(string)
                 * from -> dirección remitente (string)
                 * subject -> asunto del mensaje (string)
                 */

                $this->Email->to = 'matercero@gmail.com';
                $resumenResultado .= "Enviado a = matercero@gmail.com ";

                // Adjunto
                $this->Email->attachments = array(
                    'Factura.pdf' => $pathFactura);

                $this->Email->send($mensajeBody);
                $this->set('smtperrors', $this->Email->smtpError);

                $resumenResultado .= " CON ÉXITO. ";
                
                //TODO actualizar el estado de la factura cliente 
                
            } else {
                $resumenResultado .= "<h1 style='color:red'>No existe factura para enviar. La factura $nombre_fichero NO existe.</h1>";
            }
        } // Foreach
     
        $this->set('resumenResultado', $resumenResultado);
    }
    
      function facturaPdfDisco($factura_id) {
        Configure::write('debug', 1);
        $this->layout = 'factura_Pdf_Disco';

       // echo 'pdf_1 con id ' . $factura_id . '<br/>';

        $facturasCliente = $this->FacturasCliente->find(
                'first', array(
            'contain' => array(
                'Estadosfacturascliente',
                'Cliente' => array('Formapago', 'Cuentasbancaria'),
                'Albaranescliente' => array(
                    'FacturasCliente' => 'Cliente',
                    'Estadosalbaranescliente',
                    'Maquina',
                    'Tiposiva',
                    'Comerciale',
                    'Centrosdecoste',
                    'Almacene',
                    'Cliente' => 'Formapago',
                    'Centrostrabajo',
                    'Pedidoscliente' => array(
                        'Presupuestoscliente' => 'Cliente'),
                    'Avisosrepuesto' => array('Cliente', 'Centrostrabajo', 'Maquina'),
                    'Tareasalbaranescliente' => array('MaterialesTareasalbaranescliente' => 'Articulo', 'ManodeobrasTareasalbaranescliente', 'TareasalbaranesclientesOtrosservicio'), 'Avisosrepuesto' => array('Cliente', 'Centrostrabajo', 'Maquina')),
                'Albaranesclientesreparacione' => array(
                    'Estadosalbaranesclientesreparacione',
                    'TareasAlbaranesclientesreparacione' => array(
                        'TareasAlbaranesclientesreparacionesParte' => 'Mecanico',
                        'TareasAlbaranesclientesreparacionesPartestallere' => 'Mecanico',
                        'ArticulosTareasAlbaranesclientesreparacione' => 'Articulo'),
                    'Ordene' => array(
                        'Centrostrabajo',
                        'Cliente',
                        'Avisostallere' => array('Centrostrabajo', 'Cliente')),
                    'Centrosdecoste',
                    'Comerciale',
                    'Almacene',
                    'Maquina',
                    'FacturasCliente' => 'Cliente',
                    'Cliente' => 'Formapago',
                    'Centrostrabajo',
                    'Tiposiva'
                )
            ),
            'conditions' => array('FacturasCliente.id' => $factura_id)
                )
        );
        $this->loadModel('Config');
        $this->set('config', $this->Config->read(null, 1));
        $this->set('facturasCliente', $facturasCliente);
    }

}

?>
