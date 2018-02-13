<?php

class AlbaranesproveedoresController extends AppController {

    var $name = 'Albaranesproveedores';
    var $components = array('FileUpload', 'Session');
    var $helpers = array('Form', 'MultipleRecords', 'Ajax', 'Js', 'Autocomplete', 'Time');

    function beforeFilter() {
        parent::beforeFilter();
        if ($this->params['action'] == 'edit' || $this->params['action'] == 'add') {
            $this->FileUpload->fileModel = 'Albaranesproveedore';
            $this->FileUpload->uploadDir = 'files/albaranesproveedore';
            $this->FileUpload->fields = array('name' => 'file_name', 'type' => 'file_type', 'size' => 'file_size');
        }
        $this->loadModel('Config');
        $this->set('config', $this->Config->read(null, 1));
        $series = $this->Config->Seriesalbaranescompra->find('list', array('fields' => array('Seriesalbaranescompra.serie', 'Seriesalbaranescompra.serie')));
        $this->set('series', $series);
    }

    function index() {
        $contain = array('Almacene', 'Proveedore' => 'Tiposiva', 'Estadosalbaranesproveedore', 'Pedidosproveedore' => array('Presupuestosproveedore' => array('Proveedore', 'Almacene')));
        $conditions = array();

        if (!empty($this->params['url']['serie']))
            $conditions [] = array('Albaranesproveedore.serie' => $this->params['url']['serie']);
        if (!empty($this->params['named']['serie']))
            $conditions [] = array('Albaranesproveedore.serie' => $this->params['named']['serie']);


        if (!empty($this->params['url']['numero']))
            $conditions [] = array('Albaranesproveedore.numero' => $this->params['url']['numero']);
        if (!empty($this->params['named']['numero']))
            $conditions [] = array('Albaranesproveedore.numero' => $this->params['named']['numero']);

        
        if (!empty($this->params['url']['FechaInicio']) && !empty($this->params['url']['FechaFin'])) {
            $data1 = date("Y-m-d", strtotime($this->params['url']['FechaInicio']));
            $data2 = date("Y-m-d", strtotime($this->params['url']['FechaFin']));
            $conditions[] = array("Albaranesproveedore.fecha BETWEEN '$data1' AND '$data2'");
        }

        if (!empty($this->params['named']['FechaInicio']) && !empty($this->params['named']['FechaFin'])) {
            $data1 = date("Y-m-d", strtotime($this->params['named']['FechaInicio']));
            $data2 = date("Y-m-d", strtotime($this->params['named']['FechaFin']));
            $conditions[] = array("Albaranesproveedore.fecha BETWEEN '$data1' AND '$data2'");
        }

        if (!empty($this->params['url']['proveedore_id']))
            $conditions [] = array('1' => '1 AND Albaranesproveedore.proveedore_id = ' . $this->params['url']['proveedore_id']);
        if (!empty($this->params['named']['proveedore_id']))
            $conditions [] = array('1' => '1 AND Albaranesproveedore.proveedore_id = ' . $this->params['named']['proveedore_id']);

        if (!empty($this->params['url']['almacene_id']))
            $conditions [] = array('1' => '1 AND Albaranesproveedore.almacene_id = ' . $this->params['url']['almacene_id']);
        if (!empty($this->params['named']['almacene_id']))
            $conditions [] = array('1' => '1 AND Albaranesproveedore.almacene_id = ' . $this->params['named']['almacene_id']);

        if (!empty($this->params['url']['articulo_id']))
            $conditions [] = array('1' => '1 AND Albaranesproveedore.id IN (SELECT ArticulosAlbaranesproveedore.albaranesproveedore_id FROM articulos_albaranesproveedores ArticulosAlbaranesproveedore WHERE ArticulosAlbaranesproveedore.articulo_id = ' . $this->params['url']['articulo_id'] . ')');
        if (!empty($this->params['named']['articulo_id']))
            $conditions [] = array('1' => '1 AND Albaranesproveedore.id IN (SELECT ArticulosAlbaranesproveedore.albaranesproveedore_id FROM articulos_albaranesproveedores ArticulosAlbaranesproveedore WHERE ArticulosAlbaranesproveedore.articulo_id = ' . $this->params['named']['articulo_id'] . ')');

        if (!empty($this->params['url']['numero_avisostallere']))
            $conditions [] = array('1' => '1 AND Albaranesproveedore.pedidosproveedore_id IN (SELECT Pedidosproveedore.id FROM pedidosproveedores Pedidosproveedore WHERE Pedidosproveedore.presupuestosproveedore_id IN (SELECT Presupuestosproveedore.id FROM presupuestosproveedores Presupuestosproveedore WHERE Presupuestosproveedore.avisostallere_id IN (SELECT Avisostallere.id FROM avisostalleres Avisostallere WHERE Avisostallere.numero = "' . $this->params['url']['numero_avisostallere'] . '")))');
        if (!empty($this->params['named']['numero_avisostallere']))
            $conditions [] = array('1' => '1 AND Albaranesproveedore.pedidosproveedore_id IN (SELECT Pedidosproveedore.id FROM pedidosproveedores Pedidosproveedore WHERE Pedidosproveedore.presupuestosproveedore_id IN (SELECT Presupuestosproveedore.id FROM presupuestosproveedores Presupuestosproveedore WHERE Presupuestosproveedore.avisostallere_id IN (SELECT Avisostallere.id FROM avisostalleres Avisostallere WHERE Avisostallere.numero = "' . $this->params['named']['numero_avisostallere'] . '")))');

        if (!empty($this->params['url']['numero_avisosrepuesto']))
            $conditions [] = array('1' => '1 AND Albaranesproveedore.pedidosproveedore_id IN (SELECT Pedidosproveedore.id FROM pedidosproveedores Pedidosproveedore WHERE Pedidosproveedore.presupuestosproveedore_id IN (SELECT Presupuestosproveedore.id FROM presupuestosproveedores Presupuestosproveedore WHERE Presupuestosproveedore.avisosrepuesto_id IN (SELECT Avisosrepuesto.id FROM avisosrepuestos Avisosrepuesto WHERE Avisosrepuesto.numero = "' . $this->params['url']['numero_avisosrepuesto'] . '")))');
        if (!empty($this->params['named']['numero_avisosrepuesto']))
            $conditions [] = array('1' => '1 AND Albaranesproveedore.pedidosproveedore_id IN (SELECT Pedidosproveedore.id FROM pedidosproveedores Pedidosproveedore WHERE Pedidosproveedore.presupuestosproveedore_id IN (SELECT Presupuestosproveedore.id FROM presupuestosproveedores Presupuestosproveedore WHERE Presupuestosproveedore.avisosrepuesto_id IN (SELECT Avisosrepuesto.id FROM avisosrepuestos Avisosrepuesto WHERE Avisosrepuesto.numero = "' . $this->params['named']['numero_avisosrepuesto'] . '")))');

        if (!empty($this->params['url']['numero_ordene']))
            $conditions [] = array('1' => '1 AND Albaranesproveedore.pedidosproveedore_id IN (SELECT Pedidosproveedore.id FROM pedidosproveedores Pedidosproveedore WHERE Pedidosproveedore.presupuestosproveedore_id IN (SELECT Presupuestosproveedore.id FROM presupuestosproveedores Presupuestosproveedore WHERE Presupuestosproveedore.ordene_id IN (SELECT Ordene.id FROM ordenes Ordene WHERE Ordene.numero = "' . $this->params['url']['numero_ordene'] . '")))');
        if (!empty($this->params['named']['numero_ordene']))
            $conditions [] = array('1' => '1 AND Albaranesproveedore.pedidosproveedore_id IN (SELECT Pedidosproveedore.id FROM pedidosproveedores Pedidosproveedore WHERE Pedidosproveedore.presupuestosproveedore_id IN (SELECT Presupuestosproveedore.id FROM presupuestosproveedores Presupuestosproveedore WHERE Presupuestosproveedore.ordene_id IN (SELECT Ordene.id FROM ordenes Ordene WHERE Ordene.numero = "' . $this->params['named']['numero_ordene'] . '")))');

        if (!empty($this->params['url']['estadosalbaranesproveedore_id']))
            $conditions [] = array('1' => '1 AND Albaranesproveedore.estadosalbaranesproveedore_id = ' . $this->params['url']['estadosalbaranesproveedore_id']);
        if (!empty($this->params['named']['estadosalbaranesproveedore_id']))
            $conditions [] = array('1' => '1 AND Albaranesproveedore.estadosalbaranesproveedore_id = ' . $this->params['named']['estadosalbaranesproveedore_id']);

        if (!empty($this->params['url']['centrosdecoste_id']))
            $conditions [] = array('1' => '1 AND Albaranesproveedore.centrosdecoste_id = ' . $this->params['url']['centrosdecoste_id']);
        if (!empty($this->params['named']['centrosdecoste_id']))
            $conditions [] = array('1' => '1 AND Albaranesproveedore.centrosdecoste_id = ' . $this->params['named']['centrosdecoste_id']);

        $paginate_results_per_page = 20;
        if (!empty($this->params['url']['resultados_por_pagina']))
            $paginate_results_per_page = intval($this->params['url']['resultados_por_pagina']);
        if (!empty($this->params['named']['resultados_por_pagina']))
            $paginate_results_per_page = intval($this->params['named']['resultados_por_pagina']);

        $this->paginate = array('limit' => $paginate_results_per_page, 'contain' => $contain, 'conditions' => $conditions, 'url' => $this->params['pass']);
        $albaranesproveedores = $this->paginate();
        $this->set('albaranesproveedores', $albaranesproveedores);
        $this->set('estadosalbaranesprove', $this->Albaranesproveedore->Estadosalbaranesproveedore->find('list'));
        $this->set('centrocoste', $this->Albaranesproveedore->Centrosdecoste->find('list'));
     
        if (!empty($this->params['url']['pdf'])) {
            $this->layout = 'pdf';
            $this->render('/albaranesproveedores/pdfFilter');
        }
    }

    function view($id = null) {
        if (!$id) {
            $this->flashWarnings(__('Albarán Inválido', true));
            $this->redirect($this->referer());
        }
        $albaranesproveedore = $this->Albaranesproveedore->find('first', array('conditions' => array('Albaranesproveedore.id' => $id),
            'contain' => array(
                'Tiposiva',
                'Almacene',
                'Proveedore' => array('Tiposiva', 'Formapago'),
                'Estadosalbaranesproveedore',
                'Centrosdecoste',
                'Pedidosproveedore' => array(
                    'Proveedore',
                    'Presupuestosproveedore' => array(
                        'Proveedore' => array('Tiposiva', 'Formapago'),
                        'Almacene',
                        'Avisostallere' => array('Cliente', 'Centrostrabajo', 'Maquina', 'Estadosavisostallere'),
                        'Avisosrepuesto' => array('Cliente', 'Centrostrabajo', 'Maquina', 'Estadosaviso'),
                        'Ordene' => array('Avisostallere' => array('Cliente', 'Centrostrabajo', 'Maquina')))))));
        if (empty($albaranesproveedore)) {
            $this->flashWarnings(__('Albarán Inválido', true));
            $this->redirect(array('action' => 'index'));
        }
        $articulos_albaranesproveedore = $this->Albaranesproveedore->ArticulosAlbaranesproveedore->findAllByAlbaranesproveedoreId($id);
        if (!empty($albaranesproveedore['Pedidosproveedore']['Presupuestosproveedore']['id'])) {
            $presupuestosproveedore = $this->Albaranesproveedore->Pedidosproveedore->Presupuestosproveedore->findById($albaranesproveedore['Pedidosproveedore']['Presupuestosproveedore']['id']);
            $this->set('presupuestosproveedore', $presupuestosproveedore);
        }
        $this->set('albaranesproveedore', $albaranesproveedore);
        $this->set('articulos_albaranesproveedore', $articulos_albaranesproveedore);
    }

    function add($pedidosproveedore_id = null) {
        $this->Albaranesproveedore->recursive = 2;
        if (!empty($this->data)) {
            $this->Albaranesproveedore->create();
            if ($this->Albaranesproveedore->save($this->data)) {
                $pedidosproveedore_id = $this->data['Albaranesproveedore']['pedidosproveedore_id'];
                $id = $this->Albaranesproveedore->id;
                /* Cuando se crea el alabran desde un pedido debemos cambiar el estado del epdido a recibido completo */
                $this->Albaranesproveedore->Pedidosproveedore->id = $pedidosproveedore_id;
                $this->Albaranesproveedore->Pedidosproveedore->saveField('estadospedidosproveedore_id', 3);
                /* Guarda fichero */
                if ($this->FileUpload->finalFile != null) {
                    $this->Albaranesproveedore->saveField('albaranescaneado', $this->FileUpload->finalFile);
                }
                /* FIn Guardar Fichero */
                $data = array();
                foreach ($this->data['ArticulosPedidosproveedore'] as $articulo_pedidosproveedore) {
                    if ($articulo_pedidosproveedore['id'] != 0) {
                        $cantidad_servida = $articulo_pedidosproveedore['cantidad_servida'];
                        $articulo_albaranesproveedore = array();
                        $this->Albaranesproveedore->Pedidosproveedore->ArticulosPedidosproveedore->recursive = -1;
                        $articulo_pedidosproveedore = $this->Albaranesproveedore->Pedidosproveedore->ArticulosPedidosproveedore->find('first', array('conditions' => array('ArticulosPedidosproveedore.id' => $articulo_pedidosproveedore['id'])));
                        $articulo_albaranesproveedore['ArticulosAlbaranesproveedore']['albaranesproveedore_id'] = $id;
                        $articulo_albaranesproveedore['ArticulosAlbaranesproveedore']['tarea_id'] = $articulo_pedidosproveedore['ArticulosPedidosproveedore']['tarea_id'];
                        $articulo_albaranesproveedore['ArticulosAlbaranesproveedore']['articulo_id'] = $articulo_pedidosproveedore['ArticulosPedidosproveedore']['articulo_id'];
                        $this->Albaranesproveedore->Pedidosproveedore->ArticulosPedidosproveedore->id = $articulo_pedidosproveedore['ArticulosPedidosproveedore']['id'];
                        $this->Albaranesproveedore->Pedidosproveedore->ArticulosPedidosproveedore->saveField('pendiente_servir', $articulo_pedidosproveedore['ArticulosPedidosproveedore']['cantidad'] - $cantidad_servida);
                        $articulo_albaranesproveedore['ArticulosAlbaranesproveedore']['cantidad'] = $cantidad_servida;
                        $articulo_albaranesproveedore['ArticulosAlbaranesproveedore']['precio_proveedor'] = $articulo_pedidosproveedore['ArticulosPedidosproveedore']['precio_proveedor'];
                        $articulo_albaranesproveedore['ArticulosAlbaranesproveedore']['descuento'] = $articulo_pedidosproveedore['ArticulosPedidosproveedore']['descuento'];
                        $articulo_albaranesproveedore['ArticulosAlbaranesproveedore']['neto'] = $articulo_pedidosproveedore['ArticulosPedidosproveedore']['neto'];
                        $articulo_albaranesproveedore['ArticulosAlbaranesproveedore']['total'] = $cantidad_servida * $articulo_pedidosproveedore['ArticulosPedidosproveedore']['neto'];
                        $data[] = $articulo_albaranesproveedore;
                    }
                }
                $this->Albaranesproveedore->ArticulosAlbaranesproveedore->saveAll($data);
                // Fin de la validación de articulos a ArticulosAlbaranesProveedore 

                $this->Session->setFlash(__('El Albarán a proveedor ha sido guardado', true));
                $this->redirect(array('action' => 'view', $this->Albaranesproveedore->id));
            } else {
                $this->flashWarnings(__('El albaran de Proveedor nor ha podido ser guardado. Por favor intentalo de nuevo.', true));
            }
        }
        if (!empty($pedidosproveedore_id)) {
            $pedidosproveedore = $this->Albaranesproveedore->Pedidosproveedore->find('first', array('contain' => array('ArticulosPedidosproveedore' => array('Articulo', 'Tarea'), 'Presupuestosproveedore'), 'conditions' => array('Pedidosproveedore.id' => $pedidosproveedore_id)));
        }
        $this->set('tiposivas', $this->Albaranesproveedore->Tiposiva->find('list'));
        $this->set('proveedores', $this->Albaranesproveedore->Proveedore->find('list'));
        $this->set('almacenes', $this->Albaranesproveedore->Almacene->find('list'));
        $numero = $this->Albaranesproveedore->dime_siguiente_numero();
        $estadosalbaranesproveedores = $this->Albaranesproveedore->Estadosalbaranesproveedore->find('list');
        $centrosdecostes = $this->Albaranesproveedore->Centrosdecoste->find('list');
        $this->set(compact('pedidosproveedore_id', 'pedidosproveedore', 'numero', 'estadosalbaranesproveedores', 'centrosdecostes'));
    }

    function edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->flashWarnings(__('Albarán a Proveedor No válido', true));
            $this->redirect($this->referer());
        }
        if (!empty($this->data)) {
            if ($this->Albaranesproveedore->saveAll($this->data)) {
                $id = $this->Albaranesproveedore->id;
                $upload = $this->Albaranesproveedore->findById($id);
                if (!empty($this->data['Albaranesproveedore']['remove_file'])) {
                    $this->FileUpload->RemoveFile($upload['Albaranesproveedore']['albaranescaneado']);
                    $this->Albaranesproveedore->saveField('albaranescaneado', null);
                }
                if ($this->FileUpload->finalFile != null) {
                    $this->FileUpload->RemoveFile($upload['Albaranesproveedore']['albaranescaneado']);
                    $this->Albaranesproveedore->saveField('albaranescaneado', $this->FileUpload->finalFile);
                }
                $this->Session->setFlash(__('El Albarán a Proveedor ha sido guardado', true));
                $this->redirect(array('action' => 'view', $id));
            } else {
                $this->flashWarnings(__('El Albarán de Proveedor no ha podido ser guardado. Por favor, inténtalo de nuvo.', true));
            }
        }
        if (empty($this->data)) {
            $albaranesproveedore = $this->Albaranesproveedore->find('first', array('conditions' => array('Albaranesproveedore.id' => $id),
                'contain' => array('Pedidosproveedore' =>
                    array('Presupuestosproveedore' =>
                        array('Proveedore',
                            'Almacene',
                            'Avisostallere' => array('Cliente', 'Centrostrabajo', 'Maquina', 'Estadosavisostallere'),
                            'Avisosrepuesto' => array('Cliente', 'Centrostrabajo', 'Maquina', 'Estadosaviso'),
                            'Ordene' => array('Avisostallere' => array('Cliente', 'Centrostrabajo', 'Maquina')))))));
            $this->set('albaranesproveedore', $albaranesproveedore);
            $this->data = $this->Albaranesproveedore->read(null, $id);
        }

        $this->set('tiposivas', $this->Albaranesproveedore->Tiposiva->find('list'));
        $this->set('proveedores', $this->Albaranesproveedore->Proveedore->find('list'));
        $this->set('almacenes', $this->Albaranesproveedore->Almacene->find('list'));
        $estadosalbaranesproveedores = $this->Albaranesproveedore->Estadosalbaranesproveedore->find('list');
        $pedidosproveedores = $this->Albaranesproveedore->Pedidosproveedore->find('list');
        $centrosdecostes = $this->Albaranesproveedore->Centrosdecoste->find('list');
        $this->set(compact('pedidosproveedores', 'estadosalbaranesproveedores', 'centrosdecostes'));
    }

    function delete($id = null) {
        if (!$id) {
            $this->flashWarnings(__('Id inválida para el Albarán de Proveedor', true));
            $this->redirect(array('action' => 'index'));
        }
        $id = $this->Albaranesproveedore->id;
        $upload = $this->Albaranesproveedore->findById($id);
        if (!empty($upload['Albaranesproveedore']['albaranescaneado']))
            $this->FileUpload->RemoveFile($upload['Albaranesproveedore']['albaranescaneado']);
        if ($this->Albaranesproveedore->delete($id)) {
            $this->Session->setFlash(__('Albarán de Proveedor borrado', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->flashWarnings(__('El Albarán de Proveedor no ha podido ser borrado.', true));
        $this->redirect(array('action' => 'index'));
    }

    function select() {
        $this->Albaranesproveedore->recursive = 2;
        $albaranesproveedores = $this->Albaranesproveedore->find('all', array('conditions' => array('Albaranesproveedore.facturasproveedore_id' => $this->data['Devolucionesproveedore']['facturasproveedore_id'])));
        $this->set(compact('albaranesproveedores'));
    }

    function facturacion() {
        if (!empty($this->data)) {
            $fecha_inicio = date('Y-m-d', strtotime($this->data['Filtro']['fecha_inicio']['year'] . '-' . $this->data['Filtro']['fecha_inicio']['month'] . '-' . $this->data['Filtro']['fecha_inicio']['day']));
            $fecha_fin = date('Y-m-d', strtotime($this->data['Filtro']['fecha_fin']['year'] . '-' . $this->data['Filtro']['fecha_fin']['month'] . '-' . $this->data['Filtro']['fecha_fin']['day']));
            if (!empty($this->data['Filtro']['todos'])) {
                /* Obtenemos los alabranes de todos los proveedores comprendidos en el rango de fecha
                 * y que se PUEDAN FACTURAR 
                 */
                $albaranesproveedores = $this->Albaranesproveedore->find('all', array('conditions' => array('Albaranesproveedore.confirmado' => 1, 'Albaranesproveedore.estadosalbaranesproveedore_id' => 1, 'Albaranesproveedore.fecha BETWEEN ? AND ?' => array($fecha_inicio, $fecha_fin), 'Albaranesproveedore.facturasproveedore_id' => NULL), 'contain' => array('Proveedore', 'Centrosdecoste', 'Tiposiva'), 'order' => 'Albaranesproveedore.proveedore_id'));
                $proveedore_list = array();
                foreach ($albaranesproveedores as $albaranesproveedore) {
                    $proveedore_list[$albaranesproveedore['Proveedore']['nombre']][] = $albaranesproveedore;
                }
            } elseif (!empty($this->data['Filtro']['Proveedore'])) {
                /* Obtenemos los alabranes de los proveedore comprendidos en el rango de fecha
                 * y que se PUEDAN FACTURAR 
                 */
                $albaranesproveedores = $this->Albaranesproveedore->find('all', array('conditions' => array('Albaranesproveedore.confirmado' => 1, 'Albaranesproveedore.estadosalbaranesproveedore_id' => 1, 'Albaranesproveedore.fecha BETWEEN ? AND ?' => array($fecha_inicio, $fecha_fin), 'Albaranesproveedore.proveedore_id' => $this->data['Filtro']['Proveedore']), 'contain' => array('Proveedore', 'Centrosdecoste', 'Tiposiva'), 'order' => 'Albaranesproveedore.proveedore_id'));
                $proveedore_list = array();
                foreach ($albaranesproveedores as $albaranesproveedore) {
                    $proveedore_list[$albaranesproveedore['Proveedore']['nombre']][] = $albaranesproveedore;
                }
            }
            $this->set(compact('proveedore_list'));
            $this->render('facturacion_list');
        }
    }

}

?>
