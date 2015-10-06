<?php

class FacturasproveedoresController extends AppController {

    var $name = 'Facturasproveedores';
    var $components = array('FileUpload');
    var $helpers = array('Javascript', 'Form', 'Html', 'Autocomplete', 'Time', 'Js');

    function beforeFilter() {
        parent::beforeFilter();
        $this->loadModel('Config');
        if ($this->params['action'] == 'edit' || $this->params['action'] == 'add') {
            $this->FileUpload->fileModel = 'Facturasproveedore';
            $this->FileUpload->uploadDir = 'files/facturasproveedore';
            $this->FileUpload->fields = array('name' => 'file_name', 'type' => 'file_type', 'size' => 'file_size');
        }

        if ($this->params['action'] == 'index') {
            $this->__list();
            $this->set('series_albaranes', $this->Config->SeriesAlbaranesventa->find('list', array('fields' => array('SeriesAlbaranesventa.serie', 'SeriesAlbaranesventa.serie'))));
        }
        $this->set('config', $this->Config->read(null, 1));
        $this->set('series', $this->Config->Seriesfacturascompra->find('list', array('fields' => array('Seriesfacturascompra.serie', 'Seriesfacturascompra.serie'))));
    }

    function index() {
        $conditions = array();

        if (!empty($this->params['url']['serie']))
            $conditions [] = array('Facturasproveedore.serie' => $this->params['url']['serie']);
        if (!empty($this->params['named']['serie']))
            $conditions [] = array('Facturasproveedore.serie' => $this->params['named']['serie']);


        if (!empty($this->params['url']['numero']))
            $conditions [] = array('Facturasproveedore.numero' => $this->params['url']['numero']);
        if (!empty($this->params['named']['numero']))
            $conditions [] = array('Facturasproveedore.numero' => $this->params['named']['numero']);


        if (!empty($this->params['url']['fecha_inicio']) && !empty($this->params['url']['fecha_fin'])) {
            $data1 = implode('-', array_reverse($this->params['url']['fecha_inicio']));
            $data2 = implode('-', array_reverse($this->params['url']['fecha_fin']));
            $conditions[] = array("Facturasproveedore.fechafactura BETWEEN '$data1' AND '$data2'");
        }
        if (!empty($this->params['named']['fecha_inicio[year]']) && !empty($this->params['named']['fecha_fin[year]'])) {
            $data1 = $this->params['named']['fecha_inicio[year]'] . '-' . $this->params['named']['fecha_inicio[month]'] . '-' . $this->params['named']['fecha_inicio[day]'];
            $data2 = $this->params['named']['fecha_fin[year]'] . '-' . $this->params['named']['fecha_fin[month]'] . '-' . $this->params['named']['fecha_fin[day]'];
            $conditions[] = array("Facturasproveedore.fechafactura BETWEEN '$data1' AND '$data2'");
        }

        if (!empty($this->params['url']['proveedore_id']))
            $conditions [] = array('1' => '1 AND Facturasproveedore.proveedore_id = "' . $this->params['url']['proveedore_id'] . '"');
        if (!empty($this->params['named']['cliente_id']))
            $conditions [] = array('1' => '1 AND Facturasproveedore.proveedore_id = "' . $this->params['named']['proveedore_id'] . '"');



        /* Albaranes buscador */

        if (!empty($this->params['url']['serie_albaran'])) {
            $conditions [] = array('1' => '1 AND Facturasproveedore.id IN (SELECT Albaranesproveedore.facturasproveedore_id FROM albaranesproveedores Albaranesproveedore WHERE Albaranesproveedore.serie =  "' . $this->params['url']['serie_albaran'] . '")');
        }
        if (!empty($this->params['named']['serie_albaran'])) {
            $conditions [] = array('1' => '1 AND Facturasproveedore.id IN (SELECT Albaranesproveedore.facturasproveedore_id FROM albaranesproveedores Albaranesproveedore WHERE Albaranesproveedore.serie =  "' . $this->params['named']['serie_albaran'] . '")');
        }

        if (!empty($this->params['url']['numero_albaran'])) {
            $conditions [] = array('1' => '1 AND Facturasproveedore.id IN (SELECT Albaranesproveedore.facturasproveedore_id FROM albaranesproveedores Albaranesproveedore WHERE Albaranesproveedore.numero =  "' . $this->params['url']['numero_albaran'] . '")');
        }
        if (!empty($this->params['named']['numero_albaran'])) {
            $conditions [] = array('1' => '1 AND Facturasproveedore.id IN (SELECT Albaranesproveedore.facturasproveedore_id FROM albaranesproveedores Albaranesproveedore WHERE Albaranesproveedore.numero =  "' . $this->params['named']['numero_albaran'] . '")');
        }

        /*         * Fin albaranes buscador */

        $paginate_results_per_page = 20;
        if (!empty($this->params['url']['resultados_por_pagina']))
            $paginate_results_per_page = intval($this->params['url']['resultados_por_pagina']);
        if (!empty($this->params['named']['resultados_por_pagina']))
            $paginate_results_per_page = intval($this->params['named']['resultados_por_pagina']);

        $this->paginate = array('limit' => $paginate_results_per_page, 'conditions' => $conditions, 'url' => $this->params['pass']);

        $this->Facturasproveedore->recursive = 1;
        $this->set('facturasproveedores', $this->paginate());
        if (!empty($this->params['url']['pdf'])) {
            $this->layout = 'pdf';
            $this->render('/facturasproveedores/pdfFilter');
        }
    }

    function view($id = null) {
        if (!$id) {
            $this->flashWarnings(__('Factura de Proveedor No Existe', true));
            $this->redirect($this->redirect());
        }
        $facturasproveedore = $this->Facturasproveedore->find('first', array(
            'conditions' => array('Facturasproveedore.id' => $id),
            'contain' => array(
                'Proveedore' => 'Formapago',
                'Estadosfacturasproveedore',
                'Tiposiva',
                'Albaranesproveedore' => 'Centrosdecoste',
            ),
                ));
        $this->set('facturasproveedore', $facturasproveedore);
    }

    function add($albaranesproveedore_id = null) {
        $this->Facturasproveedore->recursive = 2;
        if (!empty($this->data)) {
            $albaranesproveedore_id = $this->data['Facturasproveedore']['albaranesproveedore_id'];
            $this->Facturasproveedore->create();
            if ($this->Facturasproveedore->save($this->data)) {
                $id = $this->Facturasproveedore->id;
                $this->Facturasproveedore->saveField('facturaescaneada', $this->FileUpload->finalFile);
                // START validacion de articulosalabranes a articulosfactura
                $data = array();
                // Fin de la validacion de ArticulosAlbaranesProveedore a ArticulosFacturasproveedore
                $this->Session->setFlash(__('La Factura de Proveedor ha sido guardada correctamente', true));
                $this->redirect(array('action' => 'view', $this->Facturasproveedore->id));
            } else {
                $this->flashWarnings(__('La Factura de Proveedor no ha podido ser guardada. Prueba de nuevo.', true));
            }
        }
        $albaranesproveedore = $this->Facturasproveedore->Albaranesproveedore->find('first', array('contain' => array('ArticulosAlbaranesproveedore' => 'Articulo'), 'conditions' => array('Albaranesproveedore.id' => $albaranesproveedore_id)));
        $tiposivas = $this->Facturasproveedore->Tiposiva->find('list');
        $estadosfacturasproveedores = $this->Facturasproveedore->Estadosfacturasproveedore->find('list');
        $this->set(compact('tiposivas', 'albaranesproveedore_id', 'albaranesproveedore', 'estadosfacturasproveedores'));
    }

    function edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->flashWarnings(__('Factura de Proveedor Inválida', true));
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            if ($this->Facturasproveedore->save($this->data)) {
                $id = $this->Facturasproveedore->id;
                $upload = $this->Facturasproveedore->findById($id);
                if (!empty($this->data['Facturasproveedore']['remove_file'])) {
                    $this->FileUpload->RemoveFile($upload['Facturasproveedore']['facturaescaneada']);
                    $this->Facturasproveedore->saveField('facturaescaneada', null);
                }
                if ($this->FileUpload->finalFile != null) {
                    $this->FileUpload->RemoveFile($upload['Facturasproveedore']['facturaescaneada']);
                    $this->Facturasproveedore->saveField('facturaescaneada', $this->FileUpload->finalFile);
                }
                $this->Session->setFlash(__('La Factura de Proveedor ha sido guardada correctamente', true));
                $this->redirect(array('action' => 'view', $id));
            } else {
                $this->flashWarnings(__('La Factura de Proveedor No ha podido ser guardada.', true));
            }
        }
        $this->data = $this->Facturasproveedore->find('first', array('contain' => array('Proveedore', 'Tiposiva', 'Estadosfacturasproveedore'), 'conditions' => array('Facturasproveedore.id' => $id)));
        $estadosfacturasproveedores = $this->Facturasproveedore->Estadosfacturasproveedore->find('list');
        $tiposivas = $this->Facturasproveedore->Tiposiva->find('list');
        $this->set(compact('tiposivas', 'estadosfacturasproveedores'));
    }

    function delete($id = null) {
        if (!$id) {
            $this->flashWarnings(__('Id invalida de Factura de Proveedor', true));
            $this->redirect($this->referer());
        }
        $id = $this->Facturasproveedore->id;
        $upload = $this->Facturasproveedore->findById($id);
        if ($this->Facturasproveedore->delete($id)) {
            $this->FileUpload->RemoveFile($upload['Facturasproveedore']['facturaescaneada']);
            $this->Session->setFlash(__('Facturasproveedore deleted', true));
            $this->redirect(array('controller' => 'facturasproveedores', 'action' => 'index'));
        }
        $this->flashWarnings(__('No se ha podido borrar la Factura de Proveedor. Posiblemente contenga Albaranes de Proveedor', true));
        $this->redirect($this->referer());
    }

    function pdf($id = null) {
        if ($id != null) {
            /* Cargar modelos */
            $this->Facturasproveedore->recursive = 0;
            $this->loadModel('Albaranesproveedore');
            $this->Albaranesproveedore->recursive = 0;
            $this->loadModel('ArticulosAvisosrepuesto');
            $this->ArticulosAvisosrepuesto->recursive = 0;
            $this->loadModel('Articulo');
            $this->Articulo->recursive = 0;
            $this->loadModel('Avisosrepuesto');
            $this->Avisosrepuesto->recursive = 0;
            $this->loadModel('Avisostallere');
            $this->Avisostallere->recursive = 0;
            $this->loadModel('Ordene');
            $this->Ordene->recursive = 0;
            $this->loadModel('Tarea');
            $this->Tarea->recursive = -1;
            $this->loadModel('Parte');
            $this->Parte->recursive = -1;
            $this->loadModel('Partestallere');
            $this->Partestallere->recursive = -1;
            $this->loadModel('ArticulosParte');
            $this->ArticulosParte->recursive = 0;
            $this->loadModel('ArticulosPartestallere');
            $this->ArticulosPartestallere->recursive = -1;
            $this->loadModel('Articulo');
            $this->Articulo->recursive = -1;
            /* Fin cargar modelos */
            $factura = $this->Facturasproveedore->findById($id);
            $albaranes = $this->Albaranesproveedore->findAllByFacturasproveedoreId($id);
            foreach ($albaranes as $key_alabaran => $albaran) {
                $albaran_proveedor = $this->Albaranesproveedore->findById($albaran['Albaranesproveedore']['id']);
                $albaranes[$key_alabaran]['DetalleAlbaran'] = $albaran_proveedor['Albaranesproveedore'];
                /* ¿Albaran de Aviso de taller o de Repuestos? */
                if (!empty($albaran_proveedor['Albaranesproveedore']['avisosrepuesto_id'])) {
                    /*
                     * Albaran de Aviso de Repuesto 
                     */
                    //Repuestos
                    $repuestos = $this->ArticulosAvisosrepuesto->findAllByAvisosrepuestoId($albaran_proveedor['Albaranesproveedore']['avisosrepuesto_id']);
                    foreach ($repuestos as $key_repuestos => $repuesto) {
                        $articulo = $this->Articulo->findById($repuesto['ArticulosAvisosrepuesto']['articulo_id']);
                        $repuestos[$key_repuestos]['DetalleArticulo'] = $articulo['Articulo'];
                    }
                    $albaranes[$key_alabaran]['AvisoRepuesto']['Repuestos'] = $repuestos;
                    //Aviso de Repuestos
                    $aviso_repuesto = $this->Avisosrepuesto->findById($albaran_proveedor['Albaranesproveedore']['avisosrepuesto_id']);
                } elseif (!empty($albaran_proveedor['Albaranesproveedore']['avisostallere_id'])) {
                    /*
                     *  Alabran de Avisos de Taller 
                     */

                    //Primero cojemos el aviso
                    $aviso_de_taller = $this->Avisostallere->findById($albaran_proveedor['Albaranesproveedore']['avisostallere_id']);
                    //despues cojemos la orden del aviso
                    $orden_aviso_taller = $this->Ordene->findByAvisostallereId($aviso_de_taller['Avisostallere']['id']);
                    // y ahora cojemos las tareas de la orden
                    $tareas = $this->Tarea->findAllByOrdeneId($orden_aviso_taller['Ordene']['id']);
                    $albaranes[$key_alabaran]['AvisoTaller'] = $tareas;
                    //Ahora por cada tarea cojemos y les ponemos los partes y partes de talleres
                    foreach ($albaranes[$key_alabaran]['AvisoTaller'] as $key_tarea => $tarea) {
                        $partes_tallere = $this->Partestallere->findAllByTareaId($tarea['Tarea']['id']);
                        $partes_centros = $this->Parte->findAllByTareaId($tarea['Tarea']['id']);
                        $albaranes[$key_alabaran]['AvisoTaller'][$key_tarea]['PartesTallere'] = $partes_tallere;
                        $albaranes[$key_alabaran]['AvisoTaller'][$key_tarea]['PartesCentros'] = $partes_centros;
                        //Ahora sacamos los articulos asociados a cada tipo de parte:
                        // 1º Articulos de Parte de Taller
                        foreach ($albaranes[$key_alabaran]['AvisoTaller'][$key_tarea]['PartesTallere'] as $key_parte_taller => $parte_taller) {
                            $articulos = $this->ArticulosPartestallere->findAllByPartestallereId($parte_taller['Partestallere']['id']);
                            $albaranes[$key_alabaran]['AvisoTaller'][$key_tarea]['PartesTallere'][$key_parte_taller]['Articulos'] = $articulos;
                            foreach ($albaranes[$key_alabaran]['AvisoTaller'][$key_tarea]['PartesTallere'][$key_parte_taller]['Articulos'] as $articulo_parte_taller_key => $articulo_parte_taller) {
                                $detalle_articulo = $this->Articulo->findById($articulo_parte_taller['ArticulosPartestallere']['articulo_id']);
                                $albaranes[$key_alabaran]['AvisoTaller'][$key_tarea]['PartesTallere'][$key_parte_taller]['Articulos'][$articulo_parte_taller_key]['Articulo'] = array_shift($detalle_articulo);
                            }
                        }
                        // 2º Articulos de Parte de Centrotrabajo
                    }
                }
            }
            $factura["Albaranes"] = $albaranes;
        } else {
            die("Factura no encontrada");
        }
        /* pr($factura);
          die(); */
        $this->layout = 'pdf';
        $this->set('factura', $factura);
        $this->render();
    }

    function downloadFile($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Id inválida para factura de proveedores', true));
            $this->redirect(array('action' => 'index'));
        } else {
            $id = $this->Facturasproveedore->id;
            $upload = $this->Facturasproveedore->findById($id);
            $name = $upload['Facturasproveedore']['facturaescaneada'];
            $ruta = '../webroot/files/' . $name;

            header("Content-disposition: attachment; filename=$name");
            header("Content-type: application/octet-stream");
            readfile($ruta);
        }
    }

    private function __list() {
        $tiposivas = $this->Facturasproveedore->Tiposiva->find('list');
        $this->set(compact('tiposivas'));
    }

    function select() {
        $facturasproveedores = $this->Facturasproveedore->find('list', array('conditions' => array('Facturasproveedore.proveedore_id' => $this->data['Devolucionesproveedore']['proveedore_id'])));
        $this->set(compact('facturasproveedores'));
    }

    function facturar() {
        if (!empty($this->data)) {
            $facturasproveedore_ids = array();
            foreach ($this->data['facturable'] as $posible_factura) {
                $this->Facturasproveedore->create();
                $facturasproveedore = array();
                $proveedore_id = null;
                $fecha = $posible_factura['fechafactura'][2] . '-' .$posible_factura['fechafactura'][1]. '-' . $posible_factura['fechafactura'][0];
                $baseimponible = 0;
                $this->loadModel('Config');
                $config = $this->Config->read(null, 1);

                $facturasproveedore['Facturasproveedore']['fechafactura'] = $fecha;
                $facturasproveedore['Facturasproveedore']['serie'] = $config['Seriesfacturascompra']['serie'];
                $facturasproveedore['Facturasproveedore']['baseimponible'] = $baseimponible;
                $facturasproveedore['Facturasproveedore']['numero_factura_aportado'] = $posible_factura['numero_factura_aportado'];
                $albaranesproveedore = $this->Facturasproveedore->Albaranesproveedore->find('first', array('contain' => array(), 'conditions' => array('Albaranesproveedore.id' => $posible_factura['albaranes'])));
                $facturasproveedore['Facturasproveedore']['tiposiva_id'] = $albaranesproveedore['Albaranesproveedore']['tiposiva_id'];
                if ($this->Facturasproveedore->save($facturasproveedore)) {
                    foreach ($posible_factura['albaranes'] as $albarane_id) {
                        $albaranesproveedore = $this->Facturasproveedore->Albaranesproveedore->find('first', array('contain' => array(), 'conditions' => array('Albaranesproveedore.id' => $albarane_id)));
                        $this->Facturasproveedore->Albaranesproveedore->id = $albaranesproveedore['Albaranesproveedore']['id'];
                        $this->Facturasproveedore->Albaranesproveedore->saveField('facturasproveedore_id', $this->Facturasproveedore->id);
                        $this->Facturasproveedore->Albaranesproveedore->saveField('estadosalbaranesproveedore_id', 2);
                        $proveedore_id = $albaranesproveedore['Albaranesproveedore']['proveedore_id'];
                        $baseimponible += $albaranesproveedore['Albaranesproveedore']['baseimponible'];
                    }
                    $this->Facturasproveedore->saveField('proveedore_id', $proveedore_id);
                    $this->Facturasproveedore->saveField('baseimponible', number_format($baseimponible, 5, '.', ''));
                    $facturasproveedore_ids[] = $this->Facturasproveedore->id;
                } else {
                    $this->flashWarnings(__('La Facturacion no puede ser realizada', true));
                    $this->redirect($this->referer());
                }
            }
            $facturasproveedores = $this->Facturasproveedore->find('all', array('contain' => array('Proveedore', 'Tiposiva'), 'conditions' => array('Facturasproveedore.id' => $facturasproveedore_ids)));
            $this->Session->setFlash(__('La Facturacion ha sido guardada correctamente', true));
            $this->set(compact('facturasproveedores'));
        } else {
            $this->flashWarnings(__('La Facturacion no puede ser realizada', true));
            $this->redirect($this->referer());
        }
    }

    function quitar_albaran($albaranesproveedore_id) {
        $albaranesproveedore = $this->Facturasproveedore->Albaranesproveedore->find('first', array('contain' => array(), 'conditions' => array('Albaranesproveedore.id' => $albaranesproveedore_id)));
        $facturasproveedore = $this->Facturasproveedore->find('first', array('contain' => array(), 'conditions' => array('Facturasproveedore.id' => $albaranesproveedore['Albaranesproveedore']['facturasproveedore_id'])));
        $this->Facturasproveedore->id = $facturasproveedore['Facturasproveedore']['id'];
        $this->Facturasproveedore->saveField('baseimponible', number_format($facturasproveedore['Facturasproveedore']['baseimponible'] - $albaranesproveedore['Albaranesproveedore']['baseimponible'], 5, '.', ''));
        $this->Facturasproveedore->Albaranesproveedore->id = $albaranesproveedore['Albaranesproveedore']['id'];
        $this->Facturasproveedore->Albaranesproveedore->saveField('facturasproveedore_id', null);
        $this->Facturasproveedore->Albaranesproveedore->saveField('estadosalbaranesproveedore_id', 1);
        $this->Session->setFlash(__('Albarán de proveedore Nº ' . $albaranesproveedore['Albaranesproveedore']['numero'] . ' quitado de la Factura de Proveedor correctamente', true));
        $this->redirect($this->referer());
    }

}

?>