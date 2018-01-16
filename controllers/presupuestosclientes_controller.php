<?php

class PresupuestosclientesController extends AppController {

    var $name = 'Presupuestosclientes';
    var $components = array('FileUpload');
    var $helpers = array('Form', 'Ajax', 'Js', 'Autocomplete', 'Time');

    function beforeFilter() {
        parent::beforeFilter();
        if ($this->params['action'] == 'edit' || $this->params['action'] == 'add') {
            $this->FileUpload->fileModel = 'Presupuestoscliente';
            $this->FileUpload->uploadDir = 'files/presupuestoscliente';
            $this->FileUpload->fields = array('name' => 'file_name', 'type' => 'file_type', 'size' => 'file_size');
        }
        $this->loadModel('Config');
        $this->set('config', $this->Config->read(null, 1));

        $series = $this->Config->Seriespresupuestosventa->find('list', array('fields' => array('Seriespresupuestosventa.serie', 'Seriespresupuestosventa.serie')));
        $this->set('series', $series);
    }

    function index() {
        $conditions = array();

        if (!empty($this->params['url']['serie']))
            $conditions [] = array('Presupuestoscliente.serie' => $this->params['url']['serie']);
        if (!empty($this->params['named']['serie']))
            $conditions [] = array('Presupuestoscliente.serie' => $this->params['named']['serie']);


        if (!empty($this->params['url']['numero']))
            $conditions [] = array('Presupuestoscliente.numero' => $this->params['url']['numero']);
        if (!empty($this->params['named']['numero']))
            $conditions [] = array('Presupuestoscliente.numero' => $this->params['named']['numero']);

        if (!empty($this->params['url']['FechaInicio2']) && !empty($this->params['url']['FechaFin'])) {
            $data1 = date("Y-m-d", strtotime( $this->params['url']['FechaInicio']));
            $data2 = date("Y-m-d", strtotime( $this->params['url']['FechaFin']));
            echo '$data1=' . $data1 . ' $data2=' . $data2  ;
            $conditions[] = array("Presupuestoscliente.fecha BETWEEN '$data1' AND '$data2'");       
        }
        
//        if (!empty($this->params['url']['fecha_inicio']) && !empty($this->params['url']['fecha_fin'])) {
//            $data1 = implode('-', array_reverse($this->params['url']['fecha_inicio']));
//            $data2 = implode('-', array_reverse($this->params['url']['fecha_fin']));        
//            $conditions[] = array("Presupuestoscliente.fecha BETWEEN '$data1' AND '$data2'");        
//            
//        }


//        if (!empty($this->params['named']['fecha_inicio[year]']) && !empty($this->params['named']['fecha_fin[year]'])) {
//            $data1 = $this->params['named']['fecha_inicio[year]'] . '-' . $this->params['named']['fecha_inicio[month]'] . '-' . $this->params['named']['fecha_inicio[day]'];
//            $data2 = $this->params['named']['fecha_fin[year]'] . '-' . $this->params['named']['fecha_fin[month]'] . '-' . $this->params['named']['fecha_fin[day]'];
//            $conditions[] = array("Presupuestoscliente.fecha BETWEEN '$data1' AND '$data2'");
//        }


        if (!empty($this->params['url']['articulo_id']))
            $conditions [] = array('1' => '1 AND Presupuestoscliente.id IN (SELECT Tareaspresupuestocliente.presupuestoscliente_id FROM tareaspresupuestoclientes Tareaspresupuestocliente WHERE Tareaspresupuestocliente.id IN (SELECT Materiale.tareaspresupuestocliente_id FROM materiales Materiale WHERE Materiale.articulo_id = ' . $this->params['url']['articulo_id'] . '))');
        if (!empty($this->params['named']['articulo_id']))
            $conditions [] = array('1' => '1 AND Presupuestoscliente.id IN (SELECT Tareaspresupuestocliente.presupuestoscliente_id FROM tareaspresupuestoclientes Tareaspresupuestocliente WHERE Tareaspresupuestocliente.id IN (SELECT Materiale.tareaspresupuestocliente_id FROM materiales Materiale WHERE Materiale.articulo_id = ' . $this->params['named']['articulo_id'] . '))');


        if (!empty($this->params['url']['cliente_id']))
            $conditions [] = array('1' => '1 AND Presupuestoscliente.cliente_id = ' . $this->params['url']['cliente_id']);
        if (!empty($this->params['named']['cliente_id']))
            $conditions [] = array('1' => '1 AND Presupuestoscliente.cliente_id = ' . $this->params['named']['cliente_id']);

        if (!empty($this->params['url']['comerciale_id']))
            $conditions [] = array('1' => '1 AND Presupuestoscliente.comerciale_id = ' . $this->params['url']['comerciale_id']);
        if (!empty($this->params['named']['cliente_id']))
            $conditions [] = array('1' => '1 AND Presupuestoscliente.comerciale_id = ' . $this->params['named']['comerciale_id']);

        if (!empty($this->params['url']['maquina_id']))
            $conditions [] = array('1' => '1 AND Presupuestoscliente.maquina_id = ' . $this->params['url']['maquina_id']);
        if (!empty($this->params['named']['maquina_id']))
            $conditions [] = array('1' => '1 AND Presupuestoscliente.maquina_id = ' . $this->params['named']['maquina_id']);

        if (!empty($this->params['url']['numero_ordene']))
            $conditions [] = array('1' => '1 AND Presupuestoscliente.ordene_id IN (SELECT Ordene.id FROM ordenes Ordene WHERE Ordene.numero = "' . $this->params['url']['numero_ordene'] . '")');
        if (!empty($this->params['named']['numero_ordene']))
            $conditions [] = array('1' => '1 AND Presupuestoscliente.ordene_id  IN (SELECT Ordene.id FROM ordenes Ordene WHERE Ordene.numero = "' . $this->params['named']['numero_ordene'] . '")');


        if (!empty($this->params['url']['numero_avisostallere']))
            $conditions [] = array('1' => '1 AND Presupuestoscliente.avisostallere_id IN (SELECT Avisostallere.id FROM avisostalleres Avisostallere WHERE Avisostallere.numero =  "' . $this->params['url']['numero_avisostallere'] . '")');
        if (!empty($this->params['named']['numero_avisostallere']))
            $conditions [] = array('1' => '1 AND Presupuestoscliente.avisostallere_id  IN (SELECT Avisostallere.id FROM avisostalleres Avisostallere WHERE Avisostallere.numero = "' . $this->params['named']['numero_avisostallere'] . '")');

        if (!empty($this->params['url']['numero_avisosrepuesto']))
            $conditions [] = array('1' => '1 AND Presupuestoscliente.avisosrepuesto_id IN (SELECT Avisosrepuesto.id FROM avisosrepuestos Avisosrepuesto WHERE Avisosrepuesto.numero =  "' . $this->params['url']['numero_avisosrepuesto'] . '")');
        if (!empty($this->params['named']['numero_avisosrepuesto']))
            $conditions [] = array('1' => '1 AND Presupuestoscliente.avisosrepuesto_id  IN (SELECT Avisosrepuesto.id FROM avisosrepuestos Avisosrepuesto WHERE Avisosrepuesto.numero = "' . $this->params['named']['numero_avisosrepuesto'] . '")');


        $paginate_results_per_page = 20;
        if (!empty($this->params['url']['resultados_por_pagina']))
            $paginate_results_per_page = intval($this->params['url']['resultados_por_pagina']);
        if (!empty($this->params['named']['resultados_por_pagina']))
            $paginate_results_per_page = intval($this->params['named']['resultados_por_pagina']);

        $this->paginate = array('limit' => $paginate_results_per_page, 'conditions' => $conditions, 'url' => $this->params['pass']);
        $this->Presupuestoscliente->recursive = 0;
        $this->set('presupuestosclientes', $this->paginate());
    }

    function view($id = null) {
        if (!$id) {
            $this->flashWarnings(__('Presupuestos Cliente Inválido', true));
            $this->redirect(array('action' => 'index'));
        }
        $presupuestoscliente = $this->Presupuestoscliente->find(
                'first', array(
            'contain' => array(
                'Estadospresupuestoscliente',
                'Maquina',
                'Centrostrabajo',
                'Mensajesinformativo',
                'Almacene',
                'Cliente',
                'Comerciale',
                'Pedidoscliente',
                'Tiposiva',
                'Avisosrepuesto' => array('Cliente', 'Centrostrabajo', 'Maquina'),
                'Presupuestosproveedore' => array('Proveedore', 'Avisostallere' => 'Cliente', 'Avisosrepuesto' => 'Cliente'),
                'Avisostallere' => array('Cliente', 'Centrostrabajo', 'Maquina'),
                'Ordene' => array('Avisostallere' => array('Cliente', 'Centrostrabajo', 'Maquina')),
                'Tareaspresupuestocliente' => array(
                    'TareaspresupuestoclientesOtrosservicio',
                    'Materiale' => array('Articulo'),
                    'Manodeobra'
                )
            ),
            'conditions' => array('Presupuestoscliente.id' => $id)));
        $totalmanoobrayservicios = 0;
        $totalrepuestos = 0;
        foreach ($presupuestoscliente['Tareaspresupuestocliente'] as $tarea) {
            $totalmanoobrayservicios += $tarea['mano_de_obra'] + $tarea['servicios'];
            $totalrepuestos += $tarea['materiales'];
        }
        $this->set('presupuestoscliente', $presupuestoscliente);
        $this->set('totalrepuestos', $totalrepuestos);
        $this->set('totalmanoobrayservicios', $totalmanoobrayservicios);
    }

    function pdf($id) {
        Configure::write('debug', 0);
        $this->layout = 'pdf';
        if (!$id) {
            $this->flashWarnings(__('Presupuestos Cliente Inválido', true));
            $this->redirect(array('action' => 'index'));
        }
        $presupuestoscliente = $this->Presupuestoscliente->find(
                'first', array(
            'contain' => array(
                'Estadospresupuestoscliente',
                'Maquina',
                'Centrostrabajo',
                'Mensajesinformativo',
                'Almacene',
                'Cliente',
                'Comerciale',
                'Pedidoscliente',
                'Tiposiva',
                'Avisosrepuesto' => array('Cliente', 'Centrostrabajo', 'Maquina'),
                'Presupuestosproveedore' => array('Proveedore', 'Avisostallere' => 'Cliente', 'Avisosrepuesto' => 'Cliente'),
                'Avisostallere' => array('Cliente', 'Centrostrabajo', 'Maquina'),
                'Ordene' => array('Avisostallere' => array('Cliente', 'Centrostrabajo', 'Maquina')),
                'Tareaspresupuestocliente' => array(
                    'TareaspresupuestoclientesOtrosservicio',
                    'Materiale' => array('Articulo'),
                    'Manodeobra'
                )
            ),
            'conditions' => array('Presupuestoscliente.id' => $id)));
        $totalmanoobrayservicios = 0;
        $totalrepuestos = 0;
        foreach ($presupuestoscliente['Tareaspresupuestocliente'] as $tarea) {
            $totalmanoobrayservicios += $tarea['mano_de_obra'] + $tarea['servicios'];
            $totalrepuestos += $tarea['materiales'];
        }
        $this->set('presupuestoscliente', $presupuestoscliente);
        $this->set('totalrepuestos', $totalrepuestos);
        $this->set('totalmanoobrayservicios', $totalmanoobrayservicios);
        $this->render();
    }

    function pdf_facturapro($id) {
        Configure::write('debug', 0);
        $this->layout = 'pdf';
        if (!$id) {
            $this->flashWarnings(__('Presupuestos Cliente Inválido', true));
            $this->redirect(array('action' => 'index'));
        }
        $presupuestoscliente = $this->Presupuestoscliente->find(
                'first', array(
            'contain' => array(
                'Estadospresupuestoscliente',
                'Maquina',
                'Centrostrabajo',
                'Mensajesinformativo',
                'Almacene',
                'Cliente',
                'Comerciale',
                'Pedidoscliente',
                'Tiposiva',
                'Avisosrepuesto' => array('Cliente', 'Centrostrabajo', 'Maquina'),
                'Presupuestosproveedore' => array('Proveedore', 'Avisostallere' => 'Cliente', 'Avisosrepuesto' => 'Cliente'),
                'Avisostallere' => array('Cliente', 'Centrostrabajo', 'Maquina'),
                'Ordene' => array('Avisostallere' => array('Cliente', 'Centrostrabajo', 'Maquina')),
                'Tareaspresupuestocliente' => array(
                    'TareaspresupuestoclientesOtrosservicio',
                    'Materiale' => array('Articulo'),
                    'Manodeobra'
                )
            ),
            'conditions' => array('Presupuestoscliente.id' => $id)));
        $totalmanoobrayservicios = 0;
        $totalrepuestos = 0;
        foreach ($presupuestoscliente['Tareaspresupuestocliente'] as $tarea) {
            $totalmanoobrayservicios += $tarea['mano_de_obra'] + $tarea['servicios'];
            $totalrepuestos += $tarea['materiales'];
        }
        $this->set('presupuestoscliente', $presupuestoscliente);
        $this->set('totalrepuestos', $totalrepuestos);
        $this->set('totalmanoobrayservicios', $totalmanoobrayservicios);
        $this->render();
    }

    function add($vienede = null, $iddedondeviene = null, $cliente_id = null) {
        $this->loadModel('Config');
        $config = $this->Config->read(null, 1);
        if (!empty($this->data)) {
            $this->Presupuestoscliente->create();
            if (!empty($this->data['Articulosparamantenimiento'])) {
                //Si viene el presupuesto desde una maquina para encargar los repuestos necesarios para el mantenimiento
                $presupuestoscliente = array();
                $presupuestoscliente['Presupuestoscliente']['cliente_id'] = $this->data['Presupuestoscliente']['cliente_id'];
                $presupuestoscliente['Presupuestoscliente']['centrostrabajo_id'] = $this->data['Presupuestoscliente']['centrostrabajo_id'];
                $presupuestoscliente['Presupuestoscliente']['maquina_id'] = $this->data['Presupuestoscliente']['maquina_id'];
                $presupuestoscliente['Presupuestoscliente']['tiposiva_id'] = $config['Config']['tiposiva_id'];
                $presupuestoscliente['Presupuestoscliente']['precio_mat'] = 0;
                $presupuestoscliente['Presupuestoscliente']['estadospresupuestoscliente_id'] = 1;
                $presupuestoscliente['Presupuestoscliente']['precio_obra'] = 0;
                $presupuestoscliente['Presupuestoscliente']['precio'] = 0;
                $presupuestoscliente['Presupuestoscliente']['impuestos'] = 0;
                $presupuestoscliente['Presupuestoscliente']['fecha'] = date('Y-m-d');
            } else {
                $presupuestoscliente = $this->data;
            }

            if ($this->Presupuestoscliente->save($presupuestoscliente)) {
                $id = $this->Presupuestoscliente->id;
                /* Guarda fichero */
                if ($this->FileUpload->finalFile != null) {
                    $this->Presupuestoscliente->saveField('presupuestoescaneado', $this->FileUpload->finalFile);
                    // Se cambia el estado a Recibido:
                }
                /* FIn Guardar Fichero */

                $this->Session->setFlash(__('El Presupuesto a Cliente ha sido guardado', true));
                /* Comenzamos con el paso de las relaciones */
                if (!empty($this->data['Presupuestoscliente']['avisosrepuesto_id'])) {
                    /* Actualizamos el estado del avisorepuesto a #8: Enviado Presupuesto a Cliente */
                    $this->Presupuestoscliente->Avisosrepuesto->id = $this->data['Presupuestoscliente']['avisosrepuesto_id'];
                    $this->Presupuestoscliente->Avisosrepuesto->saveField('estadosaviso_id', 8);
                    /* Fin actualizar Estado */
                    $articulos_avisosrepuesto = $this->Presupuestoscliente->Avisosrepuesto->ArticulosAvisosrepuesto->find('all', array('contain' => 'Articulo', 'conditions' => array('ArticulosAvisosrepuesto.avisosrepuesto_id' => $this->data['Presupuestoscliente']['avisosrepuesto_id'])));
                    $tarea = array();
                    $tarea['Tareaspresupuestocliente']['asunto'] = 'Presupuesto Material';
                    $tarea['Tareaspresupuestocliente']['presupuestoscliente_id'] = $this->Presupuestoscliente->id;
                    $this->Presupuestoscliente->Tareaspresupuestocliente->create();
                    $this->Presupuestoscliente->Tareaspresupuestocliente->save($tarea);
                    $materiale = array();
                    $i = 0;
                    foreach ($articulos_avisosrepuesto as $articulo_avisosrepuesto) {
                        $materiale['Materiale'][$i]['articulo_id'] = $articulo_avisosrepuesto['ArticulosAvisosrepuesto']['articulo_id'];
                        $materiale['Materiale'][$i]['cantidad'] = $articulo_avisosrepuesto['ArticulosAvisosrepuesto']['cantidad'];
                        $materiale['Materiale'][$i]['precio_unidad'] = $articulo_avisosrepuesto['Articulo']['precio_sin_iva'];
                        $materiale['Materiale'][$i]['importe'] = number_format($materiale['Materiale'][$i]['precio_unidad'] * $materiale['Materiale'][$i]['cantidad'], 5, '.', '');
                        $materiale['Materiale'][$i]['descuento'] = 0;
                        $materiale['Materiale'][$i]['tareaspresupuestocliente_id'] = $this->Presupuestoscliente->Tareaspresupuestocliente->id;
                        $i++;
                    }
                    $this->Presupuestoscliente->Tareaspresupuestocliente->Materiale->saveAll($materiale['Materiale']);
                } elseif (!empty($this->data['Presupuestoscliente']['avisostallere_id'])) {
                    $avisostallere = $this->Presupuestoscliente->Avisostallere->find('first', array('contain' => '', 'conditions' => array('Avisostallere.id' => $this->data['Presupuestoscliente']['avisostallere_id'])));
                    $tarea = array();
                    $tarea['Tareaspresupuestocliente']['asunto'] = $avisostallere['Avisostallere']['descripcion'];
                    $tarea['Tareaspresupuestocliente']['presupuestoscliente_id'] = $this->Presupuestoscliente->id;
                    $this->Presupuestoscliente->Tareaspresupuestocliente->create();
                    $this->Presupuestoscliente->Tareaspresupuestocliente->save($tarea);
                } elseif (!empty($this->data['Presupuestoscliente']['ordene_id'])) {
                    $ordene = $this->Presupuestoscliente->Ordene->find('first', array('contain' => array('Avisostallere', 'Tarea' => array('ArticulosTarea' => 'Articulo')), 'conditions' => array('Ordene.id' => $this->data['Presupuestoscliente']['ordene_id'])));
                    foreach ($ordene['Tarea'] as $tarea_ordene) {
                        $tarea = array();
                        $tarea['Tareaspresupuestocliente']['asunto'] = $tarea_ordene['descripcion'];
                        $tarea['Tareaspresupuestocliente']['tipo'] = $tarea_ordene['tipo'];
                        $tarea['Tareaspresupuestocliente']['presupuestoscliente_id'] = $this->Presupuestoscliente->id;
                        $this->Presupuestoscliente->Tareaspresupuestocliente->create();
                        $this->Presupuestoscliente->Tareaspresupuestocliente->save($tarea);
                        $materiale = array();
                        $i = 0;
                        if (!empty($tarea_ordene['ArticulosTarea'])) {
                            foreach ($tarea_ordene['ArticulosTarea'] as $articulo_tarea) {
                                $materiale['Materiale'][$i]['articulo_id'] = $articulo_tarea['articulo_id'];
                                $materiale['Materiale'][$i]['cantidad'] = $articulo_tarea['cantidad'];
                                $materiale['Materiale'][$i]['precio_unidad'] = $articulo_tarea['Articulo']['precio_sin_iva'];
                                $materiale['Materiale'][$i]['importe'] = number_format($materiale['Materiale'][$i]['precio_unidad'] * $materiale['Materiale'][$i]['cantidad'], 5, '.', '');
                                $materiale['Materiale'][$i]['descuento'] = 0;
                                $materiale['Materiale'][$i]['tareaspresupuestocliente_id'] = $this->Presupuestoscliente->Tareaspresupuestocliente->id;
                                $i++;
                            }
                            $this->Presupuestoscliente->Tareaspresupuestocliente->Materiale->saveAll($materiale['Materiale']);
                        }
                    }
                } elseif (!empty($this->data['Presupuestoscliente']['presupuestosproveedore_id'])) {
                    /* Actualizamos el estado del avisorepuesto a #8: Enviado Presupuesto a Cliente */
                    $presupuestosproveedore = $this->Presupuestoscliente->Presupuestosproveedore->find(
                            'first', array('contain' =>
                        array(
                            'Presupuestoscliente',
                        ),
                        'conditions' => array('Presupuestosproveedore.id' => $this->data['Presupuestoscliente']['presupuestosproveedore_id'])
                    ));
                    if (!empty($presupuestosproveedore['Presupuestosproveedore']['avisosrepuesto_id'])) {
                        $this->Presupuestoscliente->Avisosrepuesto->id = $presupuestosproveedore['Presupuestosproveedore']['avisosrepuesto_id'];
                        $this->Presupuestoscliente->Avisosrepuesto->saveField('estadosaviso_id', 8);
                    }
                    if (!empty($presupuestosproveedore['Presupuestoscliente']['avisosrepuesto_id'])) {
                        $this->Presupuestoscliente->Avisosrepuesto->id = $presupuestosproveedore['Presupuestoscliente']['avisosrepuesto_id'];
                        $this->Presupuestoscliente->Avisosrepuesto->saveField('estadosaviso_id', 8);
                    }
                    /* Fin actualizar Estado */
                    $articulos_presupuestoproveedore = $this->Presupuestoscliente->Presupuestosproveedore->ArticulosPresupuestosproveedore->find('all', array('contain' => 'Articulo', 'conditions' => array('ArticulosPresupuestosproveedore.presupuestosproveedore_id' => $this->data['Presupuestoscliente']['presupuestosproveedore_id'])));
                    $tarea = array();
                    $tarea['Tareaspresupuestocliente']['asunto'] = 'Presupuesto Material';
                    $tarea['Tareaspresupuestocliente']['presupuestoscliente_id'] = $this->Presupuestoscliente->id;
                    $this->Presupuestoscliente->Tareaspresupuestocliente->create();
                    $this->Presupuestoscliente->Tareaspresupuestocliente->save($tarea);
                    $materiale = array();
                    $i = 0;
                    foreach ($articulos_presupuestoproveedore as $articulo_presupuestoproveedore) {
                        $materiale['Materiale'][$i]['articulo_id'] = $articulo_presupuestoproveedore['ArticulosPresupuestosproveedore']['articulo_id'];
                        $materiale['Materiale'][$i]['cantidad'] = $articulo_presupuestoproveedore['ArticulosPresupuestosproveedore']['cantidad'];
                        $materiale['Materiale'][$i]['precio_unidad'] = $articulo_presupuestoproveedore['Articulo']['precio_sin_iva'];
                        $materiale['Materiale'][$i]['importe'] = number_format($materiale['Materiale'][$i]['precio_unidad'] * $materiale['Materiale'][$i]['cantidad'], 5, '.', '');
                        $materiale['Materiale'][$i]['descuento'] = 0;
                        $materiale['Materiale'][$i]['tareaspresupuestocliente_id'] = $this->Presupuestoscliente->Tareaspresupuestocliente->id;
                        $i++;
                    }
                    $this->Presupuestoscliente->Tareaspresupuestocliente->Materiale->saveAll($materiale['Materiale']);
                } elseif (!empty($this->data['Articulosparamantenimiento'])) {
                    $tarea = array();
                    $tarea['Tareaspresupuestocliente']['asunto'] = 'Presupuesto Material';
                    $tarea['Tareaspresupuestocliente']['presupuestoscliente_id'] = $this->Presupuestoscliente->id;
                    $this->Presupuestoscliente->Tareaspresupuestocliente->create();
                    $this->Presupuestoscliente->Tareaspresupuestocliente->save($tarea);
                    $materiale = array();
                    $i = 0;
                    foreach ($this->data['Articulosparamantenimiento'] as $articulosparamantenimiento) {
                        $articulosparamantenimiento = $this->Presupuestoscliente->Cliente->Maquina->Articulosparamantenimiento->find('first', array('contain' => array('Articulo'),
                            'conditions' => array('Articulosparamantenimiento.id' => $articulosparamantenimiento['id'])));
                        $materiale['Materiale'][$i]['articulo_id'] = $articulosparamantenimiento['Articulosparamantenimiento']['articulo_id'];
                        $materiale['Materiale'][$i]['cantidad'] = $articulosparamantenimiento['Articulosparamantenimiento']['cantidad'];
                        $materiale['Materiale'][$i]['precio_unidad'] = $articulosparamantenimiento['Articulo']['precio_sin_iva'];
                        $materiale['Materiale'][$i]['importe'] = number_format($materiale['Materiale'][$i]['precio_unidad'] * $materiale['Materiale'][$i]['cantidad'], 5, '.', '');
                        $materiale['Materiale'][$i]['descuento'] = 0;
                        $materiale['Materiale'][$i]['tareaspresupuestocliente_id'] = $this->Presupuestoscliente->Tareaspresupuestocliente->id;
                        $i++;
                    }
                    $this->Presupuestoscliente->Tareaspresupuestocliente->Materiale->saveAll($materiale['Materiale']);
                }
                /* Finalizamos con el paso de las relaciones */
                $this->redirect(array('action' => 'view', $this->Presupuestoscliente->id));
            } else {
                $this->Session->setFlash(__('El Presupuestoscliente no ha podido ser guardado. Por favor, inténtelo de nuevo', true));
            }
        }
        $estadospresupuestosclientes = $this->Presupuestoscliente->Estadospresupuestoscliente->find('list');
        $series = $this->Config->Seriespresupuestosventa->find('list', array('fields' => array('Seriespresupuestosventa.serie', 'Seriespresupuestosventa.serie')));
        $comerciales = $this->Presupuestoscliente->Comerciale->find('list');
        $tiposivas = $this->Presupuestoscliente->Tiposiva->find('list');
        $almacenes = $this->Presupuestoscliente->Almacene->find('list');
        $clientes = $this->Presupuestoscliente->Cliente->find('list');
        $centrostrabajos = $this->Presupuestoscliente->Centrostrabajo->find('list');
        $maquinas = $this->Presupuestoscliente->Maquina->find('list');
        $mensajesinformativos = $this->Presupuestoscliente->Mensajesinformativo->find('list');
        $numero = $this->Presupuestoscliente->dime_siguiente_numero();
        $this->set(compact('estadospresupuestosclientes', 'clientes', 'centrostrabajos', 'maquinas', 'series', 'comerciales', 'tiposivas', 'almacenes', 'numero', 'mensajesinformativos'));
        switch ($vienede) {
            case 'avisosrepuesto':
                $avisosrepuesto = $this->Presupuestoscliente->Avisosrepuesto->find('first', array('contain' => array('Almacene', 'Cliente', 'Centrostrabajo', 'Maquina'), 'conditions' => array('Avisosrepuesto.id' => $iddedondeviene)));
                $this->set(compact('avisosrepuesto'));
                $this->render('add_from_avisosrepuesto');
                break;
            case 'avisostallere':
                $avisostallere = $this->Presupuestoscliente->Avisostallere->find('first', array('contain' => array('Cliente', 'Centrostrabajo', 'Maquina'), 'conditions' => array('Avisostallere.id' => $iddedondeviene)));
                $this->set(compact('avisostallere'));
                $this->render('add_from_avisostallere');
                break;
            case 'ordene':
                $ordene = $this->Presupuestoscliente->Ordene->find('first', array('contain' => array('Almacene', 'Avisostallere' => array('Cliente', 'Centrostrabajo', 'Maquina')), 'conditions' => array('Ordene.id' => $iddedondeviene)));
                $this->set(compact('ordene'));
                $this->render('add_from_ordene');
                break;
            case 'presupuestosproveedore':
                $presupuestosproveedore = $this->Presupuestoscliente->Presupuestosproveedore->find('first', array('contain' => array('Almacene', 'Avisostallere' => array('Centrostrabajo', 'Maquina'), 'Avisosrepuesto' => array('Centrostrabajo', 'Maquina'), 'Ordene' => array('Avisostallere' => array('Centrostrabajo', 'Maquina'))), 'conditions' => array('Presupuestosproveedore.id' => $iddedondeviene)));
                $cliente = $this->Presupuestoscliente->Cliente->find('first', array('contain' => '', 'conditions' => array('Cliente.id' => $cliente_id)));
                $this->set(compact('presupuestosproveedore', 'cliente'));
                $this->render('add_from_presupuestosproveedore');
                break;
            default:
                $clientes = $this->Presupuestoscliente->Cliente->find('list');
                break;
        }
    }

    function edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid presupuestoscliente', true));
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            if ($this->Presupuestoscliente->save($this->data)) {

                $id = $this->Presupuestoscliente->id;
                $upload = $this->Presupuestoscliente->findById($id);
                if (!empty($this->data['Presupuestoscliente']['remove_file'])) {
                    $this->FileUpload->RemoveFile($upload['Presupuestoscliente']['presupuestoescaneado']);
                    $this->Presupuestoscliente->saveField('presupuestoescaneado', null);
                }
                if ($this->FileUpload->finalFile != null) {
                    $this->FileUpload->RemoveFile($upload['Presupuestoscliente']['presupuestoescaneado']);
                    $this->Presupuestoscliente->saveField('presupuestoescaneado', $this->FileUpload->finalFile);
                }

                $this->Session->setFlash(__('The presupuestoscliente has been saved', true));
                $this->redirect(array('action' => 'view', $id));
            } else {
                $this->Session->setFlash(__('The presupuestoscliente could not be saved. Please, try again.', true));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Presupuestoscliente->read(null, $id);
        }
        $series = $this->Config->Seriespresupuestosventa->find('list', array('fields' => array('Seriespresupuestosventa.serie', 'Seriespresupuestosventa.serie')));
        $estadospresupuestosclientes = $this->Presupuestoscliente->Estadospresupuestoscliente->find('list');
        $tiposivas = $this->Presupuestoscliente->Tiposiva->find('list');
        $comerciales = $this->Presupuestoscliente->Comerciale->find('list');
        $almacenes = $this->Presupuestoscliente->Almacene->find('list');
        $avisosrepuestos = $this->Presupuestoscliente->Avisosrepuesto->find('list');
        $ordenes = $this->Presupuestoscliente->Ordene->find('list');
        $avisostalleres = $this->Presupuestoscliente->Avisostallere->find('list');
        $mensajesinformativos = $this->Presupuestoscliente->Mensajesinformativo->find('list');

        $clientes = $this->Presupuestoscliente->Cliente->find('list');
        $centrostrabajos = $this->Presupuestoscliente->Centrostrabajo->find('list', array('conditions' => array('Centrostrabajo.cliente_id' => $this->data['Presupuestoscliente']['cliente_id'])));
        $maquinas = $this->Presupuestoscliente->Maquina->find('list', array('conditions' => array('Maquina.centrostrabajo_id' => $this->data['Presupuestoscliente']['centrostrabajo_id'])));

        $this->set(compact('clientes', 'centrostrabajos', 'maquinas', 'series', 'estadospresupuestosclientes', 'mensajesinformativos', 'almacenes', 'comerciales', 'avisosrepuestos', 'ordenes', 'avisostalleres', 'tiposivas'));
    }

    function delete($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for presupuestoscliente', true));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->Presupuestoscliente->delete($id)) {
            $this->Session->setFlash(__('Presupuestoscliente deleted', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Presupuestoscliente was not deleted', true));
        $this->redirect(array('action' => 'index'));
    }

    function reogranizardatos() {
        $presupuestosclientes = $this->Presupuestoscliente->find('list');
        die(pr($presupuestosclientes));
        foreach ($presupuestosclientes as $id => $fecha) {
            $presupuestoscliente_modelo = $this->Presupuestoscliente->find('first', array(
                'contain' => array(
                    'Avisosrepuesto' => array('Cliente', 'Centrostrabajo', 'Maquina'),
                    'Avisostallere' => array('Cliente', 'Centrostrabajo', 'Maquina'),
                    'Ordene' => array('Avisostallere' => array('Cliente', 'Centrostrabajo', 'Maquina')),
                ),
                'conditions' => array('Presupuestoscliente.id' => $id)));
            $this->Presupuestoscliente->id = $presupuestoscliente_modelo['Presupuestoscliente']['id'];
            if (!empty($presupuestoscliente_modelo['Avisosrepuesto'])) {
                $presupuestoscliente_modelo['Presupuestoscliente']['cliente_id'] = $presupuestoscliente_modelo['Avisosrepuesto']['cliente_id'];
            }
            if (!empty($presupuestoscliente_modelo['Ordene'])) {
                $presupuestoscliente_modelo['Presupuestoscliente']['cliente_id'] = $presupuestoscliente_modelo['Ordene']['Avisostallere']['cliente_id'];
            }
            if (!empty($presupuestoscliente_modelo['Avisostallere'])) {
                $presupuestoscliente_modelo['Presupuestoscliente']['cliente_id'] = $presupuestoscliente_modelo['Avisostallere']['cliente_id'];
            }
            $this->Presupuestoscliente->save($presupuestoscliente_modelo['Presupuestoscliente']);
        }
    }

    function siguiente_numero_ajax($serie) {
        Configure::write('debug', 0);
        $this->layout = 'ajax';
        $numero = $this->Presupuestoscliente->dime_siguiente_numero_ajax($serie);
        $this->set(compact('numero'));
        $this->render();
    }

}

?>
