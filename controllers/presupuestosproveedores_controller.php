<?php

class PresupuestosproveedoresController extends AppController {

    var $name = 'Presupuestosproveedores';
    var $helpers = array('Ajax', 'Js', 'Autocomplete', 'Time');
    var $components = array('FileUpload', 'RequestHandler');

    function beforeFilter() {
        parent::beforeFilter();
        $this->FileUpload->fileModel = 'Presupuestosproveedore';
        if ($this->params['action'] == 'edit' || $this->params['action'] == 'add') {
            $this->FileUpload->fileModel = 'Presupuestosproveedore';
            $this->FileUpload->uploadDir = 'files/presupuestosproveedore';
            $this->FileUpload->fields = array('name' => 'file_name', 'type' => 'file_type', 'size' => 'file_size');
        }
        if ($this->params['action'] == 'index') {
            $this->__list();
        }
        $this->loadModel('Config');
        $this->set('config', $this->Config->read(null, 1));
        $series = $this->Config->Seriespresupuestoscompra->find('list', array('fields' => array('Seriespresupuestoscompra.serie', 'Seriespresupuestoscompra.serie')));
        $this->set('series', $series);
    }

    function index() {
        $contain = array('Ordene' => array('Avisostallere' => array('Cliente', 'Centrostrabajo', 'Maquina')), 'Avisostallere' => array('Cliente', 'Centrostrabajo', 'Maquina'), 'Avisosrepuesto' => array('Cliente', 'Centrostrabajo', 'Maquina'), 'ArticulosPresupuestosproveedore' => 'Articulo', 'Proveedore', 'Almacene', 'Estadospresupuestosproveedore');
        $conditions = array();

        if (!empty($this->params['url']['serie']))
            $conditions [] = array('Presupuestosproveedore.serie' => $this->params['url']['serie']);
        if (!empty($this->params['named']['serie']))
            $conditions [] = array('Presupuestosproveedore.serie' => $this->params['named']['serie']);


        if (!empty($this->params['url']['numero']))
            $conditions [] = array('Presupuestosproveedore.numero' => $this->params['url']['numero']);
        if (!empty($this->params['named']['numero']))
            $conditions [] = array('Presupuestosproveedore.numero' => $this->params['named']['numero']);


       if (!empty($this->params['url']['FechaInicio']) && !empty($this->params['url']['FechaFin'])) {
            $data1 = date("Y-m-d", strtotime( $this->params['url']['FechaInicio']));
            $data2 = date("Y-m-d", strtotime( $this->params['url']['FechaFin']));
        //    echo '$data1=' . $data1 . ' $data2=' . $data2  ;
            $conditions[] = array("Presupuestosproveedore.fecha BETWEEN '$data1' AND '$data2'");       
        }

        if (!empty($this->params['url']['FechaInicio']) && !empty($this->params['url']['FechaFin'])) {
            $data1 = date("Y-m-d", strtotime($this->params['url']['FechaInicio']));
            $data2 = date("Y-m-d", strtotime($this->params['url']['FechaFin']));
            $conditions[] = array("Presupuestosproveedore.fecha BETWEEN '$data1' AND '$data2'");
        }

        if (!empty($this->params['named']['FechaInicio']) && !empty($this->params['named']['FechaFin'])) {
            $data1 = date("Y-m-d", strtotime($this->params['named']['FechaInicio']));
            $data2 = date("Y-m-d", strtotime($this->params['named']['FechaFin']));
            $conditions[] = array("Presupuestosproveedore.fecha BETWEEN '$data1' AND '$data2'");
        }


        if (!empty($this->params['url']['proveedore_id']))
            $conditions [] = array('1' => '1 AND Presupuestosproveedore.proveedore_id = ' . $this->params['url']['proveedore_id']);
        if (!empty($this->params['named']['proveedore_id']))
            $conditions [] = array('1' => '1 AND Presupuestosproveedore.proveedore_id = ' . $this->params['named']['proveedore_id']);

        if (!empty($this->params['url']['articulo_id']))
            $conditions [] = array('1' => '1 AND Presupuestosproveedore.id IN (SELECT ArticulosPresupuestosproveedore.presupuestosproveedore_id FROM articulos_presupuestosproveedores ArticulosPresupuestosproveedore WHERE ArticulosPresupuestosproveedore.articulo_id = ' . $this->params['url']['articulo_id'] . ')');
        if (!empty($this->params['named']['articulo_id']))
            $conditions [] = array('1' => '1 AND Presupuestosproveedore.id IN (SELECT ArticulosPresupuestosproveedore.presupuestosproveedore_id FROM articulos_presupuestosproveedores ArticulosPresupuestosproveedore WHERE ArticulosPresupuestosproveedore.articulo_id = ' . $this->params['named']['articulo_id'] . ')');

        if (!empty($this->params['url']['numero_avisostallere']))
            $conditions [] = array('1' => '1 AND Presupuestosproveedore.avisostallere_id IN (SELECT Avisostallere.id FROM avisostalleres Avisostallere WHERE Avisostallere.numero = "' . $this->params['url']['numero_avisostallere'] . '")');
        if (!empty($this->params['named']['numero_avisostallere']))
            $conditions [] = array('1' => '1 AND Presupuestosproveedore.avisostallere_id IN (SELECT Avisostallere.id FROM avisostalleres Avisostallere WHERE Avisostallere.numero = "' . $this->params['named']['numero_avisostallere'] . '")');

        if (!empty($this->params['url']['numero_avisosrepuesto']))
            $conditions [] = array('1' => '1 AND Presupuestosproveedore.avisosrepuesto_id IN (SELECT Avisosrepuesto.id FROM avisosrepuestos Avisosrepuesto WHERE Avisosrepuesto.numero = "' . $this->params['url']['numero_avisosrepuesto'] . '")');
        if (!empty($this->params['named']['numero_avisosrepuesto']))
            $conditions [] = array('1' => '1 AND Presupuestosproveedore.avisosrepuesto_id IN (SELECT Avisosrepuesto.id FROM avisosrepuestos Avisosrepuesto WHERE Avisosrepuesto.numero = "' . $this->params['named']['numero_avisosrepuesto'] . '")');

        if (!empty($this->params['url']['numero_ordene']))
            $conditions [] = array('1' => '1 AND Presupuestosproveedore.ordene_id IN (SELECT Ordene.id FROM ordenes Ordene WHERE Ordene.numero = "' . $this->params['url']['numero_ordene'] . '")');
        if (!empty($this->params['named']['numero_ordene']))
            $conditions [] = array('1' => '1 AND Presupuestosproveedore.ordene_id IN (SELECT Ordene.id FROM ordenes Ordene WHERE Ordene.numero = "' . $this->params['named']['numero_ordene'] . '")');

        $paginate_results_per_page = 20;
        if (!empty($this->params['url']['resultados_por_pagina']))
            $paginate_results_per_page = intval($this->params['url']['resultados_por_pagina']);
        if (!empty($this->params['named']['resultados_por_pagina']))
            $paginate_results_per_page = intval($this->params['named']['resultados_por_pagina']);

        $this->paginate = array('limit' => $paginate_results_per_page, 'contain' => $contain, 'conditions' => $conditions, 'url' => $this->params['pass']);
        $presupuestosproveedores = $this->paginate();
        $this->set('presupuestosproveedores', $presupuestosproveedores);

        if (!empty($this->params['url']['pdf'])) {
            $this->layout = 'pdf';
            $this->render('/presupuestosproveedores/pdfFilter');
        }
    }

    function view($id = null) {
        if (!$id) {
            $this->flashWarnings(__('Invalid presupuestosproveedore', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->set('presupuestosproveedore', $this->Presupuestosproveedore->find(
                        'first', array('contain' =>
                    array(
                        'Tiposiva',
                        'Proveedore' => 'Tiposiva',
                        'Estadospresupuestosproveedore',
                        'Pedidosproveedore' => 'Proveedore',
                        'Presupuestoscliente' => 'Cliente',
                        'Pedidoscliente' => array('Presupuestoscliente' => 'Cliente'),
                        'Ordene' => array('Avisostallere' => array('Cliente', 'Centrostrabajo', 'Maquina')),
                        'Avisostallere' => array('Cliente', 'Centrostrabajo', 'Maquina', 'Estadosavisostallere'),
                        'Avisosrepuesto' => array('Cliente', 'Centrostrabajo', 'Maquina', 'Estadosaviso'),
                        'ArticulosPresupuestosproveedore' => 'Articulo', 'Proveedore', 'Almacene'),
                    'conditions' => array('Presupuestosproveedore.id' => $id))));
        $this->set('articulos_presupuestosproveedore', $this->Presupuestosproveedore->ArticulosPresupuestosproveedore->find('all', array('contain' => array('Articulo', 'Tarea'),
                    'conditions' => array('ArticulosPresupuestosproveedore.presupuestosproveedore_id' => $id))));
    }

    function add($avisorepuestos_id = null, $avisostallere_id = null, $ordene_id = null) {
        if (!empty($this->data) && !isset($this->data['articulos_validados'])) {
            $this->Presupuestosproveedore->create();
            if (!empty($this->data['Presupuestosproveedore']['proveedore_id'])) {
                $proveedore = $this->Presupuestosproveedore->Proveedore->find('first', array('contain' => array(), 'conditions' => array('Proveedore.id' => $this->data['Presupuestosproveedore']['proveedore_id'])));
                $this->data['Presupuestosproveedore']['tiposiva_id'] = $proveedore['Proveedore']['tiposiva_id'];
            }
            if ($this->Presupuestosproveedore->save($this->data)) {
                $id = $this->Presupuestosproveedore->id;
                /* Guarda fichero */
                if ($this->FileUpload->finalFile != null) {
                    $this->Presupuestosproveedore->saveField('presupuestoescaneado', $this->FileUpload->finalFile);
                    // Se cambia el estado a Recibido:
                    $this->Presupuestosproveedore->saveField('estadospresupuestosproveedore_id', 2);
                }
                /* FIn Guardar Fichero */
                if (!empty($this->data['Presupuestosproveedore']['avisosrepuesto_id'])) {
                    /* Convertimos los articulos del aviso de repuesto a articulos para pedir a proveedor */
                    $articulos_avisosrepuesto = $this->Presupuestosproveedore->Avisosrepuesto->ArticulosAvisosrepuesto->findAllByAvisosrepuestoId($this->data['Presupuestosproveedore']['avisosrepuesto_id']);
                    $data = array();
                    foreach ($articulos_avisosrepuesto as $articulo_avisosrepuesto) {
                        $articulo_proveedore = array();
                        $articulo_proveedore['ArticulosPresupuestosproveedore']['articulo_id'] = $articulo_avisosrepuesto['ArticulosAvisosrepuesto']['articulo_id'];
                        $articulo_proveedore['ArticulosPresupuestosproveedore']['presupuestosproveedore_id'] = $id;
                        $articulo_proveedore['ArticulosPresupuestosproveedore']['cantidad'] = $articulo_avisosrepuesto['ArticulosAvisosrepuesto']['cantidad'];
                        $data[] = $articulo_proveedore;
                    }
                    $this->Presupuestosproveedore->ArticulosPresupuestosproveedore->saveAll($data);
                    /* Fin conversion */
                } elseif (!empty($this->data['Presupuestosproveedore']['ordene_id'])) {
                    $this->Presupuestosproveedore->Ordene->updateAll(array('Ordene.estadosordene_id' => 1), array('Ordene.id' => $this->data['Presupuestosproveedore']['ordene_id']));
                } elseif (!empty($this->data['Albaranesproveedore']['albaranesproveedore_id'])) {
                    /* Convertimos los Articulos que vienen de albaran marcados para devolucion */
                    $articulos_albaranesproveedore = $this->Presupuestosproveedore->Pedidosproveedore->Albaranesproveedore->ArticulosAlbaranesproveedore->findAllByAlbaranesproveedoreId($this->data['Albaranesproveedore']['albaranesproveedore_id']);
                    $articulos_presupuestosproveedore = array();
                    foreach ($articulos_albaranesproveedore as $articulo_albaranesproveedore) {
                        if ($articulo_albaranesproveedore['ArticulosAlbaranesproveedore']['marcado'] != 0) {
                            $articulo_proveedore = array();
                            $articulo_pedido = $this->Presupuestosproveedore->Pedidosproveedore->ArticulosPresupuestosproveedorePedidosproveedore->findById($articulo_albaranesproveedore['ArticulosAlbaranesproveedore']['articulos_presupuestosproveedore_pedidosproveedore_id']);
                            $articulo_presupuesto = $this->Presupuestosproveedore->ArticulosPresupuestosproveedore->findById($articulo_pedido['ArticulosPresupuestosproveedorePedidosproveedore']['articulos_presupuestosproveedore_id']);
                            $articulo_proveedore['ArticulosPresupuestosproveedore']['articulo_id'] = $articulo_presupuesto['ArticulosPresupuestosproveedore']['articulo_id'];
                            $articulo_proveedore['ArticulosPresupuestosproveedore']['presupuestosproveedore_id'] = $id;
                            $articulo_proveedore['ArticulosPresupuestosproveedore']['cantidad'] = 0 - $articulo_presupuesto['ArticulosPresupuestosproveedore']['cantidad'];
                            $articulos_presupuestosproveedore[] = $articulo_proveedore;
                        }
                    }
                    $this->Presupuestosproveedore->ArticulosPresupuestosproveedore->saveAll($articulos_presupuestosproveedore);
                    /* Fin conversion */
                } elseif (!empty($this->data['paraalmacen'])) {
                    if (!empty($this->data['articulos'])) {
                        /* Convertimos los articulos del aviso de repuesto a articulos para pedir a proveedor */
                        $articulos = $this->Presupuestosproveedore->ArticulosPresupuestosproveedore->Articulo->find('all', array('conditions' => array('Articulo.id' => $this->data['articulos'])));
                        $data = array();
                        foreach ($articulos as $articulo) {
                            $articulo_proveedore = array();
                            $articulo_proveedore['ArticulosPresupuestosproveedore']['articulo_id'] = $articulo['Articulo']['id'];
                            $articulo_proveedore['ArticulosPresupuestosproveedore']['presupuestosproveedore_id'] = $id;
                            $articulo_proveedore['ArticulosPresupuestosproveedore']['cantidad'] = $articulo['Articulo']['stock_maximo'] - $articulo['Articulo']['existencias'];
                            $data[] = $articulo_proveedore;
                        }
                        $this->Presupuestosproveedore->ArticulosPresupuestosproveedore->saveAll($data);
                        /* Fin conversion */
                    }
                }
                $this->Session->setFlash(__('El presupuesto de proveedor ha sido guardado correctamente', true));
                $this->redirect(array('action' => 'view', $this->Presupuestosproveedore->id));
            } else {
                $this->flashWarnings(__('El presupuesto de proveedor no ha podido ser guardado. Por favor, intentalo de nuevo.'), true);
                $this->redirect($this->referer());
            }
        }
        $this->set('tiposivas', $this->Presupuestosproveedore->Tiposiva->find('list'));
        $estadospresupuestosproveedores = $this->Presupuestosproveedore->Estadospresupuestosproveedore->find('list');
        $proveedores = $this->Presupuestosproveedore->Proveedore->find('list');
        $almacenes = $this->Presupuestosproveedore->Almacene->find('list');
        $numero = $this->Presupuestosproveedore->dime_siguiente_numero();
        $this->set(compact('proveedores', 'almacenes', 'ordene_id', 'numero', 'estadospresupuestosproveedores'));
        if ($avisorepuestos_id == null && $avisostallere_id == null && $ordene_id == null) {
            if (empty($this->data['articulos_validados'])) {
                $this->render('add_directo');
            } else {
                $articulos = $this->Presupuestosproveedore->ArticulosPresupuestosproveedore->Articulo->find('all', array('conditions' => array('Articulo.id' => $this->data['articulos_validados'])));
                $this->set(compact('articulos'));
                $this->render('add_almacen');
            }
        } elseif ($avisorepuestos_id == 'devolucion' && !empty($avisostallere_id)) {
            $albaranesproveedore_id = $avisostallere_id; //Albaran del que vienen las devoluciones
            $this->set('albaranesproveedore_id', $albaranesproveedore_id);
            $this->render('add_devolucion');
        } else {
            if ($avisorepuestos_id != null && $avisorepuestos_id >= 0) {
                $avisorepuesto = $this->Presupuestosproveedore->Avisosrepuesto->read(null, $avisorepuestos_id);
                $this->set('avisorepuesto', $avisorepuesto);
            } elseif ($avisostallere_id != null && $avisostallere_id >= 0) {
                $avisotaller = $this->Presupuestosproveedore->Avisostallere->read(null, $avisostallere_id);
                $this->set('avisotaller', $avisotaller);
            } elseif ($ordene_id != null && $ordene_id >= 0) {
                $ordene = $this->Presupuestosproveedore->Ordene->find('first', array('contain' => array('Avisostallere' => array('Cliente', 'Centrostrabajo', 'Maquina')), 'conditions' => array('Ordene.id' => $ordene_id)));
                $this->set('ordene', $ordene);
            }
        }
    }

    function edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->flashWarnings(__('Invalid presupuestosproveedore', true));
            $this->redirect($this->referer());
        }
        if (!empty($this->data)) {
            if ($this->Presupuestosproveedore->saveAll($this->data)) {
                $id = $this->Presupuestosproveedore->id;
                $upload = $this->Presupuestosproveedore->findById($id);
                if (!empty($this->data['Presupuestosproveedore']['remove_file'])) {
                    $this->FileUpload->RemoveFile($upload['Presupuestosproveedore']['presupuestoescaneado']);
                    $this->Presupuestosproveedore->saveField('presupuestoescaneado', null);
                    // Se cambia el estado a Pendiente:
                    $this->Presupuestosproveedore->saveField('estadospresupuestosproveedore_id', 1);
                }
                if ($this->FileUpload->finalFile != null) {
                    $this->FileUpload->RemoveFile($upload['Presupuestosproveedore']['presupuestoescaneado']);
                    $this->Presupuestosproveedore->saveField('presupuestoescaneado', $this->FileUpload->finalFile);
                    // Se cambia el estado a Recibido:
                    $this->Presupuestosproveedore->saveField('estadospresupuestosproveedore_id', 2);
                }
                $this->Session->setFlash(__('El presupuesto de proveedor ha sido guardado correctamente', true));
                $this->redirect($this->referer());
            } else {
                $this->flashWarnings(__('El presupuesto de proveedor no ha podido ser guardado. Por favor, intentalo de nuevo.', true));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Presupuestosproveedore->find('first', array('contain' =>
                array(
                    'Estadospresupuestosproveedore',
                    'Pedidosproveedore',
                    'Presupuestoscliente',
                    'Pedidoscliente',
                    'Ordene',
                    'Avisostallere',
                    'Avisosrepuesto',
                    'ArticulosPresupuestosproveedore' => 'Articulo', 'Proveedore', 'Almacene'), 'conditions' => array('Presupuestosproveedore.id' => $id)));
        }
        $this->set('tiposivas', $this->Presupuestosproveedore->Tiposiva->find('list'));
        $this->Presupuestosproveedore->ArticulosPresupuestosproveedore->recursive = 2;
        $this->set('articulos_presupuestosproveedore', $this->Presupuestosproveedore->ArticulosPresupuestosproveedore->findAllByPresupuestosproveedoreId($id));
        $proveedores = $this->Presupuestosproveedore->Proveedore->find('list');
        $almacenes = $this->Presupuestosproveedore->Almacene->find('list');
        $estadospresupuestosproveedores = $this->Presupuestosproveedore->Estadospresupuestosproveedore->find('list');
        $this->set(compact('proveedores', 'almacenes', 'estadospresupuestosproveedores'));
        if (empty($this->data['Presupuestosproveedore']['avisostallere_id']) && empty($this->data['Presupuestosproveedore']['avisosrepuesto_id']) && empty($this->data['Presupuestosproveedore']['ordene_id'])) {
            $this->render('edit_directo');
        }
    }

    function delete($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Id invalida del presupuesto de Proveedor', true));
            $this->redirect(array('action' => 'index'));
        }
        $upload = $this->Presupuestosproveedore->findById($id);
        $this->FileUpload->RemoveFile($upload['Presupuestosproveedore']['presupuestoescaneado']);
        if ($this->Presupuestosproveedore->delete($id)) {
            $this->Session->setFlash(__('Presupuessto de Proveedor borrado correctamente', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->flashWarnings(__('No se pudo borrar el presupuesto de Proveedor', true));
        $this->redirect($this->referer());
    }

    function pdf($id) {
        Configure::write('debug', 0);
        $this->layout = 'pdf';
        $this->set('presupuestosproveedore', $this->Presupuestosproveedore->find(
                        'first', array('contain' =>
                    array(
                        'Tiposiva',
                        'Proveedore' => array('Tiposiva', 'Formapago'),
                        'Estadospresupuestosproveedore',
                        'Pedidosproveedore' => 'Proveedore',
                        'Presupuestoscliente' => 'Cliente',
                        'Pedidoscliente' => array('Presupuestoscliente' => 'Cliente'),
                        'Ordene' => array('Avisostallere' => array('Cliente', 'Centrostrabajo', 'Maquina')),
                        'Avisostallere' => array('Cliente', 'Centrostrabajo', 'Maquina', 'Estadosavisostallere'),
                        'Avisosrepuesto' => array('Cliente', 'Centrostrabajo', 'Maquina', 'Estadosaviso'),
                        'ArticulosPresupuestosproveedore' => 'Articulo', 'Proveedore', 'Almacene'),
                    'conditions' => array('Presupuestosproveedore.id' => $id))));
        $this->render();
    }

    private function __list() {
        $proveedores = $this->Presupuestosproveedore->Proveedore->find('list');
        $almacenes = $this->Presupuestosproveedore->Almacene->find('list');
        $this->set(compact('proveedores', 'almacenes'));
    }

    /**
     * funcion importar articulos desde fichero CSV con refencia, cantidad e idTarea
     */
    function import() {
        Configure::write('debug', 0);
        $id = $this->Presupuestosproveedore->id;

        if (isset($_POST['idPresProvee'])) {
            $id = $_POST['idPresProvee'];
        }
        if (isset($_POST['idAlmacene'])) {
            $idAlmacen = $_POST['idAlmacene'];
        }
        //   echo ">>" . $id . ' >> ' . $idAlmacen;

        $this->set('presupuestosproveedore', $this->Presupuestosproveedore->find(
                        'first', array('contain' =>
                    array(
                        'Tiposiva',
                        'Proveedore' => array('Tiposiva', 'Formapago'),
                        'Estadospresupuestosproveedore',
                        'Pedidosproveedore' => 'Proveedore',
                        'Presupuestoscliente' => 'Cliente',
                        'Pedidoscliente' => array('Presupuestoscliente' => 'Cliente'),
                        'Ordene' => array('Avisostallere' => array('Cliente', 'Centrostrabajo', 'Maquina')),
                        'Avisostallere' => array('Cliente', 'Centrostrabajo', 'Maquina', 'Estadosavisostallere'),
                        'Avisosrepuesto' => array('Cliente', 'Centrostrabajo', 'Maquina', 'Estadosaviso'),
                        'ArticulosPresupuestosproveedore' => 'Articulo', 'Proveedore', 'Almacene'),
                    'conditions' => array('Presupuestosproveedore.id' => $id))));


//Upload File
        if (isset($_POST['submit'])) {
            if (is_uploaded_file($_FILES['filename']['tmp_name'])) {
                //echo "<h1>" . "El fichero " . $_FILES['filename']['name'] . " uploaded successfully." . "</h1>";
                $resultadoUpload = "Fichero <b>" . $_FILES['filename']['name'] . "</b> subido con éxito. <br />";
                /* echo "<h2>Displaying contents:</h2>";
                  readfile($_FILES['filename']['tmp_name']); */
            }
            //Import uploaded file to Database en modo Lectura
            $cntRegistros = 0;
            $cntInsert = 0;
            $cntNoProcede = 0;
            $resultadoIncidencias = "<ol>";
            $insertOrUpdate = "";
            $flag = true; // para saltar la cabecera
            $handle = fopen($_FILES['filename']['tmp_name'], "r");
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                if ($flag) {
                    $flag = false;
                    continue;
                }
                $cntRegistros ++;

                // buscados el idArticulo por la referencia
                $consulta = sprintf("SELECT id, count(*) as total FROM articulos 
                                      WHERE UPPER(ref) LIKE UPPER('%s') 
                                      AND almacene_id = '%s'", '%' . mysql_real_escape_string($data[0]) . '%', $idAlmacen);

// Ejecutar la consulta
                $resultadoSQL = mysql_query($consulta);
                if (!$resultadoSQL) {
                    $mensaje = sprintf('Consulta no válida: %s . Consulta completa: %s ', mysql_error(), $consulta);
                    die($mensaje);
                }

                // $resultado .= $consulta . '<br />';
                // echo $consulta . ' id= ' . $dataSQL['id'] . ' total= ' . $dataSQL['total'] . '<br />';
                $dataSQL = mysql_fetch_assoc($resultadoSQL);
                // echo "Registros con ref " . $data[0] . " coincide = " . $dataSQL['total'] . '<br />';
                // Depende del resultado obtenido                
                $articulo_id = $dataSQL['id'];
                switch ($dataSQL['total']) {
                    case 0:
                        $resultadoIncidencias .= sprintf("<li> Referencia = %s , "
                                . "<span style='color:red;font-weight:bold'> NO  existe </span> como articulo en el almacen </li>", $data[0]);
                        $cntNoProcede ++;
                        break;
                    case 1:
                        //$resultado .= "<li>Referencia = " . $data[0] . ', ha encontrado 0 articulo.  Consulta para comprobar = ' . $consulta . '</li><br />';
                        $idtarea = ($data[2] == 0 ? 'NULL' : $data[2]);
                        $precio = ($data[3] == 0 ? 0 : $data[3]);
                        $dto = ($data[4] == 0 ? 0 : $data[4]);
                        $insertOrUpdate = "INSERT INTO articulos_presupuestosproveedores (presupuestosproveedore_id, articulo_id, "
                                . " cantidad, tarea_id, precio_proveedor, descuento) values ('$id', '$articulo_id', "
                                . " $data[1], $idtarea, $precio, $dto ) ";
                        $cntInsert ++;
                        break;
                    default :
                        $resultadoIncidencias .= sprintf("<li> Incidencia con referencia = %s, "
                                . "<span style='color:red;font-weight:bold'>, Coincide más de un artículo </span> con esta referencia "
                                . ". Comprobar = %s </li>", $data[0], $consulta);
                        $cntNoProcede ++;
                } // switch 
                // echo $insertOrUpdate. "<br />";    
                if (strlen($insertOrUpdate) > 0) {
                    $resultado2SQL = mysql_query($insertOrUpdate);
                    if (!$resultado2SQL) {
                        $mensaje = sprintf('Consulta no válida: %s . Consulta completa: %s ', mysql_error(), $insertOrUpdate);
                        die($mensaje);
                    }
                }
                $insertOrUpdate = "";
            } // While
            fclose($handle);

            $resultadoResumen = " Total de registros analizados : " . $cntRegistros . '<br />'
                    . "     Articulos creados en el presupuesto : " . $cntInsert . '<br />'
                    . "     Registros NO procesados por incidencias : " . $cntNoProcede;

            $this->set('resultadoUpload', isset($resultadoUpload) ? $resultadoUpload : " " );
            $this->set('resultadoResumen', isset($resultadoResumen) ? $resultadoResumen : " " );
            $this->set('resultado', (isset($resultadoIncidencias) ? $resultadoIncidencias : "No hay. " ) . "</ol>");
            $this->Session->setFlash(__('Importación finalizada con éxito .', true));
        } else {
            $this->set('resultadoUpload', "No hay fichero a subir");
        }
    }

}

?>
