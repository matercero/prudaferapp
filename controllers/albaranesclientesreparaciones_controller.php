<?php

class AlbaranesclientesreparacionesController extends AppController {

    var $name = 'Albaranesclientesreparaciones';
    var $components = array('RequestHandler', 'Session', 'FileUpload');
    var $helpers = array('Form', 'Autocomplete', 'Ajax', 'Js', 'Number', 'Time');

    function beforeFilter() {
        parent::beforeFilter();
        if ($this->params['action'] == 'edit' || $this->params['action'] == 'add' || $this->params['action'] == 'devolucion') {
            $this->FileUpload->fileModel = 'Albaranesclientesreparacione';
            $this->FileUpload->uploadDir = 'files/albaranesclientesreparacione';
            $this->FileUpload->fields = array('name' => 'file_name', 'type' => 'file_type', 'size' => 'file_size');
        }
        $this->loadModel('Config');
        $this->set('config', $this->Config->read(null, 1));
    }

    function index() {
        $contain = array(
            'Estadosalbaranesclientesreparacione',
            'Cliente',
            'Centrostrabajo',
            'Maquina',
            'Ordene' => 'Avisostallere',
            'Tiposiva',
            'Comerciale',
            'FacturasCliente',
            'Centrosdecoste',
            'TareasAlbaranesclientesreparacione' => array(
                'TareasAlbaranesclientesreparacionesParte' => 'Mecanico',
                'TareasAlbaranesclientesreparacionesPartestallere' => 'Mecanico'),
        );
        $conditions = array();

        if (!empty($this->params['url']['serie']))
            $conditions [] = array('Albaranesclientesreparacione.serie' => $this->params['url']['serie']);
        if (!empty($this->params['named']['serie']))
            $conditions [] = array('Albaranesclientesreparacione.serie' => $this->params['named']['serie']);


        if (!empty($this->params['url']['numero']))
            $conditions [] = array('Albaranesclientesreparacione.numero' => $this->params['url']['numero']);
        if (!empty($this->params['named']['numero']))
            $conditions [] = array('Albaranesclientesreparacione.numero' => $this->params['named']['numero']);



        if (!empty($this->params['url']['FechaInicio']) && !empty($this->params['url']['FechaFin'])) {
            $data1 = date("Y-m-d", strtotime($this->params['url']['FechaInicio']));
            $data2 = date("Y-m-d", strtotime($this->params['url']['FechaFin']));
            //  echo '$data1=' . $data1 . ' $data2=' . $data2  ;
            $conditions[] = array("Albaranesclientesreparacione.fecha BETWEEN '$data1' AND '$data2'");
        }


        if (!empty($this->params['url']['articulo_id']))
            $conditions [] = array('1' => '1 AND Albaranesclientesreparacione.id IN (SELECT TareasAlbaranesclientesreparacione.albaranesclientesreparacione_id FROM tareas_albaranesclientesreparaciones TareasAlbaranesclientesreparacione WHERE TareasAlbaranesclientesreparacione.id IN (SELECT ArticulosTareasAlbaranesclientesreparacione.tareas_albaranesclientesreparacione_id FROM articulos_tareas_albaranesclientesreparaciones ArticulosTareasAlbaranesclientesreparacione WHERE ArticulosTareasAlbaranesclientesreparacione.articulo_id = ' . $this->params['url']['articulo_id'] . '))');
        if (!empty($this->params['named']['articulo_id']))
            $conditions [] = array('1' => '1 AND Albaranesclientesreparacione.id IN (SELECT TareasAlbaranesclientesreparacione.albaranesclientesreparacione_id FROM tareas_albaranesclientesreparaciones TareasAlbaranesclientesreparacione WHERE TareasAlbaranesclientesreparacione.id IN (SELECT ArticulosTareasAlbaranesclientesreparacione.tareas_albaranesclientesreparacione_id FROM articulos_tareas_albaranesclientesreparaciones ArticulosTareasAlbaranesclientesreparacione WHERE ArticulosTareasAlbaranesclientesreparacione.articulo_id = ' . $this->params['named']['articulo_id'] . '))');


        if (!empty($this->params['url']['cliente_id']))
            $conditions [] = array('1' => '1 AND Albaranesclientesreparacione.cliente_id = ' . $this->params['url']['cliente_id']);
        if (!empty($this->params['named']['cliente_id']))
            $conditions [] = array('1' => '1 AND Albaranesclientesreparacione.cliente_id = ' . $this->params['named']['cliente_id']);

        if (!empty($this->params['url']['comerciale_id']))
            $conditions [] = array('1' => '1 AND Albaranesclientesreparacione.comerciale_id = ' . $this->params['url']['comerciale_id']);
        if (!empty($this->params['named']['cliente_id']))
            $conditions [] = array('1' => '1 AND Albaranesclientesreparacione.comerciale_id = ' . $this->params['named']['comerciale_id']);

        if (!empty($this->params['url']['numero_ordene']))
            $conditions [] = array('1' => '1 AND Albaranesclientesreparacione.ordene_id IN (SELECT Ordene.id FROM ordenes Ordene WHERE Ordene.numero = "' . $this->params['url']['numero_ordene'] . '")');
        if (!empty($this->params['named']['numero_ordene']))
            $conditions [] = array('1' => '1 AND Albaranesclientesreparacione.ordene_id  IN (SELECT Ordene.id FROM ordenes Ordene WHERE Ordene.numero = "' . $this->params['named']['numero_ordene'] . '")');

        if (!empty($this->params['url']['estadosalbaranesclientesreparacione_id']))
            $conditions [] = array('1' => '1 AND Albaranesclientesreparacione.estadosalbaranesclientesreparacione_id = ' . $this->params['url']['estadosalbaranesclientesreparacione_id']);
        if (!empty($this->params['named']['estadosalbaranesclientesreparacione_id']))
            $conditions [] = array('1' => '1 AND Albaranesclientesreparacione.estadosalbaranesclientesreparacione_id = ' . $this->params['named']['estadosalbaranesclientesreparacione_id']);

        if (!empty($this->params['url']['numero_avisostallere']))
            $conditions [] = array('1' => '1 AND Albaranesclientesreparacione.ordene_id IN (SELECT Ordene.id FROM ordenes Ordene WHERE Ordene.avisostallere_id IN  (SELECT Avisostallere.id FROM avisostalleres Avisostallere WHERE Avisostallere.numero =  "' . $this->params['url']['numero_avisostallere'] . '"))');
        if (!empty($this->params['named']['numero_avisostallere']))
            $conditions [] = array('1' => '1 AND Albaranesclientesreparacione.ordene_id  IN (SELECT Ordene.id FROM ordenes Ordene WHERE Ordene.avisostallere_id IN (SELECT Avisostallere.id FROM avisostalleres Avisostallere WHERE Avisostallere.numero = "' . $this->params['named']['numero_avisostallere'] . '"))');


        $paginate_results_per_page = 20;
        if (!empty($this->params['url']['resultados_por_pagina']))
            $paginate_results_per_page = intval($this->params['url']['resultados_por_pagina']);
        if (!empty($this->params['named']['resultados_por_pagina']))
            $paginate_results_per_page = intval($this->params['named']['resultados_por_pagina']);

        $this->paginate = array('limit' => $paginate_results_per_page, 'contain' => $contain, 'conditions' => $conditions, 'url' => $this->params['pass']);


        $series = $this->Config->SeriesAlbaranesventa->find('list', array('fields' => array('SeriesAlbaranesventa.serie', 'SeriesAlbaranesventa.serie')));
        $this->set('series', $series);

        $this->set('comerciales', $this->Albaranesclientesreparacione->Comerciale->find('list'));
        $this->set('estadosalbaranesclientesreparaciones', $this->Albaranesclientesreparacione->Estadosalbaranesclientesreparacione->find('list'));
        $this->set('albaranesclientesreparaciones', $this->paginate());
    }

    function view($id = null) {
        if (!$id) {
            $this->flashWarnings(__('Albarán de Reparación Inválido', true));
            $this->redirect($this->referer());
        }
        $this->set('albaranesclientesreparacione', $this->Albaranesclientesreparacione->find(
                        'first', array(
                    'contain' => array(
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
                    ),
                    'conditions' => array('Albaranesclientesreparacione.id' => $id))));
    }

    function pdf($id) {
        Configure::write('debug', 0);
        $this->layout = 'pdf';
        if (!$id) {
            $this->flashWarnings(__('Albarán de Reparación Inválido', true));
            $this->redirect($this->referer());
        }
        $this->set('albaranesclientesreparacione', $this->Albaranesclientesreparacione->find(
                        'first', array(
                    'contain' => array(
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
                    ),
                    'conditions' => array('Albaranesclientesreparacione.id' => $id))));
        $this->render();
    }

    function pdf_datos_presupuesto($id) {
        Configure::write('debug', 0);
        $this->layout = 'pdf';
        if (!$id) {
            $this->flashWarnings(__('Presupuesto de Cliente Inválido', true));
            $this->redirect($this->referer());
        }

        $albaranesclientesreparacione = $this->Albaranesclientesreparacione->find(
                'first', array(
            'contain' => array(
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
            ),
            'conditions' => array('Albaranesclientesreparacione.id' => $id)));

        $presupuestoscliente = $this->Albaranesclientesreparacione->Ordene->Presupuestoscliente->find(
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
            'conditions' => array('Presupuestoscliente.id' => $albaranesclientesreparacione['Albaranesclientesreparacione']['es_presupuestado'])));
        $totalmanoobrayservicios = 0;
        $totalrepuestos = 0;
        foreach ($presupuestoscliente['Tareaspresupuestocliente'] as $tarea) {
            $totalmanoobrayservicios += $tarea['mano_de_obra'] + $tarea['servicios'];
            $totalrepuestos += $tarea['materiales'];
        }
        $this->set('albaranesclientesreparacione', $albaranesclientesreparacione);
        $this->set('presupuestoscliente', $presupuestoscliente);
        $this->set('totalrepuestos', $totalrepuestos);
        $this->set('totalmanoobrayservicios', $totalmanoobrayservicios);
        $this->render();
    }

    function add($ordene_id = null, $presupuestocliente_id = null) {
        if (!empty($this->data)) {
            $this->Albaranesclientesreparacione->create();
            if ($this->Albaranesclientesreparacione->save($this->data)) {
                /* Guardar fichero */
                if ($this->FileUpload->finalFile != null) {
                    $this->Albaranesclientesreparacione->saveField('albaranescaneado', $this->FileUpload->finalFile);
                    $this->Albaranesclientesreparacione->saveField('estadosalbaranesclientesreparacione_id', 2);
                }
                /* Fin de Guardar Fichero */
                /* Pasamos las Tareas Validadas de la Orden  */
                if (!empty($this->data['Tarea'])) {
                    foreach ($this->data['Tarea'] as $tarea_validada) {
                        $this->Albaranesclientesreparacione->TareasAlbaranesclientesreparacione->create();
                        $this->Albaranesclientesreparacione->TareasAlbaranesclientesreparacione->crear_desde_tarea_de_orden($tarea_validada['id'], $this->Albaranesclientesreparacione->id);
                    }
                }
                /* Fin de Pasar las Tareas Validadas de la Orden  */
                /* Pasamos las Tareas Validadas del Presupuesto  */
                if (!empty($this->data['TareaPresupuesto'])) {
                    foreach ($this->data['TareaPresupuesto'] as $tarea_validada) {
                        $this->Albaranesclientesreparacione->TareasAlbaranesclientesreparacione->create();
                        $this->Albaranesclientesreparacione->TareasAlbaranesclientesreparacione->crear_desde_tarea_de_presupuesto($tarea_validada['id'], $this->Albaranesclientesreparacione->id);
                    }
                }
                /* Fin de Pasar las Tareas Validadas del Presupuesto  */
                /* Cambiamos de estado la Orden */
                $this->Albaranesclientesreparacione->Ordene->id = $this->data['Albaranesclientesreparacione']['ordene_id'];
                $this->Albaranesclientesreparacione->Ordene->saveField('estadosordene_id', 6); // 6	Cerrada con albarán
                /* Fin de cambiar de estado la Orden */
                $this->Session->setFlash(__('El Albarán de Reparación ha sido guardado correctamente', true));
                $this->redirect(array('action' => 'view', $this->Albaranesclientesreparacione->id));
            } else {
                $this->flashWarnings(__('El Albarán de Reparación no ha podiso se guardado. Por favor, intenéntalo de nuevo.', true));
            }
        }
        $numero = $this->Albaranesclientesreparacione->dime_siguiente_numero();
        $tiposivas = $this->Albaranesclientesreparacione->Tiposiva->find('list');
        $series = $this->Config->SeriesAlbaranesventa->find('list', array('fields' => array('SeriesAlbaranesventa.serie', 'SeriesAlbaranesventa.serie')));
        $almacenes = $this->Albaranesclientesreparacione->Almacene->find('list');
        $comerciales = $this->Albaranesclientesreparacione->Comerciale->find('list');
        $centrosdecostes = $this->Albaranesclientesreparacione->Centrosdecoste->find('list');
        $estadosalbaranesclientesreparaciones = $this->Albaranesclientesreparacione->Estadosalbaranesclientesreparacione->find('list');
        $this->set(compact('series', 'tiposivas', 'almacenes', 'comerciales', 'centrosdecostes', 'numero', 'estadosalbaranesclientesreparaciones'));
        if (!empty($ordene_id) && empty($presupuestocliente_id)) {
            $ordene = $this->Albaranesclientesreparacione->Ordene->find('first', array('contain' => array('Avisostallere', 'Almacene', 'Tarea' => array('ArticulosTarea' => 'Articulo', 'Parte' => array('Mecanico'), 'Partestallere' => array('Mecanico')), 'Cliente', 'Centrostrabajo', 'Maquina'), 'conditions' => array('Ordene.id' => $ordene_id)));
            $baseimponible = $this->Albaranesclientesreparacione->Ordene->get_baseimponible($ordene_id);
            $totalrepuestos = $this->Albaranesclientesreparacione->Ordene->get_totalrepuestos($ordene_id);
            $totalmanoobra_servicios = $this->Albaranesclientesreparacione->Ordene->get_totalmanoobra_servicios($ordene_id);
            $this->set('totalmanoobra_servicios', $totalmanoobra_servicios);
            $this->set('baseimponible', $baseimponible);
            $this->set('totalrepuestos', $totalrepuestos);
            $this->set('ordene', $ordene);
            $this->render('add_from_ordene');
        } elseif (!empty($ordene_id) && !empty($presupuestocliente_id)) {
            $ordene = $this->Albaranesclientesreparacione->Ordene->find('first', array('contain' => array('Avisostallere' => 'Centrostrabajo', 'Almacene', 'Tarea' => array('ArticulosTarea' => 'Articulo', 'Parte' => array('Mecanico'), 'Partestallere' => array('Mecanico')), 'Cliente', 'Centrostrabajo', 'Maquina'), 'conditions' => array('Ordene.id' => $ordene_id)));
            $presupuestoscliente = $this->Albaranesclientesreparacione->Ordene->Presupuestoscliente->find('first', array('conditions' => array('Presupuestoscliente.id' => $presupuestocliente_id), 'contain' => array('Tareaspresupuestocliente' => array('Materiale' => 'Articulo'))));
            $totalmanoobrayservicios = 0;
            $totalrepuestos = 0;
            foreach ($presupuestoscliente['Tareaspresupuestocliente'] as $tarea) {
                $totalmanoobrayservicios += $tarea['mano_de_obra'] + $tarea['servicios'];
                $totalrepuestos += $tarea['materiales'];
            }
            $this->set('totalrepuestos', $totalrepuestos);
            $this->set('totalmanoobrayservicios', $totalmanoobrayservicios);
            $this->set('ordene', $ordene);
            $this->set('presupuestoscliente', $presupuestoscliente);
            $this->render('add_from_presupuestocliente');
        } else {
            $this->render('add');
        }
    }

    function edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->flashWarnings(__('Invalid albaranesclientesreparacione', true));
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            if ($this->Albaranesclientesreparacione->save($this->data)) {
                $upload = $this->Albaranesclientesreparacione->findById($id);
                if (!empty($this->data['Albaranesclientesreparacione']['remove_file'])) {
                    $this->FileUpload->RemoveFile($upload['Albaranesclientesreparacione']['albaranescaneado']);
                    $this->Albaranesclientesreparacione->saveField('albaranescaneado', null);
                }
                if ($this->FileUpload->finalFile != null) {
                    $this->FileUpload->RemoveFile($upload['Albaranesclientesreparacione']['albaranescaneado']);
                    $this->Albaranesclientesreparacione->saveField('albaranescaneado', $this->FileUpload->finalFile);
                    $this->Albaranesclientesreparacione->saveField('estadosalbaranesclientesreparacione_id', 2);
                }
                $this->Session->setFlash(__('El Albarán de Reparación ha sido guardado', true));
                $this->redirect(array('action' => 'view', $this->Albaranesclientesreparacione->id));
            } else {
                $this->flashWarnings(__('El Albarán de Reparación no ha podido ser guardado.', true));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Albaranesclientesreparacione->find('first', array('contain' => array('Estadosalbaranesclientesreparacione', 'Ordene', 'Centrosdecoste', 'Comerciale', 'Almacene', 'Maquina', 'Cliente' => 'Formapago', 'Centrostrabajo', 'Tiposiva'), 'conditions' => array('Albaranesclientesreparacione.id' => $id)));
        }
        $series = $this->Config->SeriesAlbaranesventa->find('list', array('fields' => array('SeriesAlbaranesventa.serie', 'SeriesAlbaranesventa.serie')));
        $estadosalbaranesclientesreparaciones = $this->Albaranesclientesreparacione->Estadosalbaranesclientesreparacione->find('list');
        $tiposivas = $this->Albaranesclientesreparacione->Tiposiva->find('list');
        $almacenes = $this->Albaranesclientesreparacione->Almacene->find('list');
        $comerciales = $this->Albaranesclientesreparacione->Comerciale->find('list');
        $centrosdecostes = $this->Albaranesclientesreparacione->Centrosdecoste->find('list');
        $clientes = $this->Albaranesclientesreparacione->Cliente->find('list');
        $centrostrabajos = $this->Albaranesclientesreparacione->Centrostrabajo->find('list', array('conditions' => array('Centrostrabajo.cliente_id' => $this->data['Albaranesclientesreparacione']['cliente_id'])));
        $maquinas = $this->Albaranesclientesreparacione->Maquina->find('list', array('conditions' => array('Maquina.centrostrabajo_id' => $this->data['Albaranesclientesreparacione']['centrostrabajo_id'])));

        $this->set(compact('series', 'tiposivas', 'almacenes', 'comerciales', 'centrosdecostes', 'estadosalbaranesclientesreparaciones', 'clientes', 'centrostrabajos', 'maquinas'));
    }

    function delete($id = null) {
        if (!$id) {
            $this->flashWarnings(__('Id incorrecta del Albarán de Reparación', true));
            $this->redirect(array('action' => 'index'));
        }
        $id = $this->Albaranesclientesreparacione->id;
        $upload = $this->Albaranesclientesreparacione->findById($id);
        if (!empty($upload['Albaranesclientesreparacione']['albaranescaneado']))
            $this->FileUpload->RemoveFile($upload['Albaranesclientesreparacione']['albaranescaneado']);
        if ($this->Albaranesclientesreparacione->delete($id)) {
            $this->Session->setFlash(__('Albarán de Reparación borrado', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->flashWarnings(__('El Albarán de Reparación no puedo ser borrado', true));
        $this->redirect(array('action' => 'index'));
    }

    function siguiente_numero_ajax($serie) {
        Configure::write('debug', 0);
        $this->layout = 'ajax';
        $numero = $this->Albaranesclientesreparacione->dime_siguiente_numero_ajax($serie);
        $this->set(compact('numero'));
        $this->render();
    }

}

?>