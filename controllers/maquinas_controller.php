<?php

class MaquinasController extends AppController {

    var $name = 'Maquinas';
    var $components = array('FileUpload');

    function index() {
        $contain = array('Centrostrabajo' => 'Cliente', 'Cliente');
        $conditions = array();

        if (!empty($this->params['url']['codigo_nombre_serie'])) {
            $conditions [] = array("OR" => array(
                    'Maquina.codigo LIKE' => '%' . $this->params['url']['codigo_nombre_serie'] . '%',
                    'Maquina.nombre LIKE' => '%' . $this->params['url']['codigo_nombre_serie'] . '%',
                    'Maquina.serie_maquina LIKE' => '%' . $this->params['url']['codigo_nombre_serie'] . '%'
                    ));
        }
        if (!empty($this->params['named']['codigo_nombre_serie'])) {
            $conditions [] = array("OR" => array(
                    'Maquina.codigo LIKE' => '%' . $this->params['named']['codigo_nombre_serie'] . '%',
                    'Maquina.nombre LIKE' => '%' . $this->params['named']['codigo_nombre_serie'] . '%',
                    'Maquina.serie_maquina LIKE' => '%' . $this->params['named']['codigo_nombre_serie'] . '%'
                    ));
        }

        if (!empty($this->params['url']['cliente_id']))
            $conditions [] = array('Maquina.cliente_id ' => $this->params['url']['cliente_id']);
        if (!empty($this->params['named']['cliente_id']))
            $conditions [] = array('Maquina.cliente_id ' => $this->params['named']['cliente_id']);

        if (!empty($this->params['url']['cliente_id']))
            $conditions [] = array('1' => '1 AND Maquina.centrostrabajo_id IN (SELECT Centrostrabajo.id FROM centrostrabajos Centrostrabajo WHERE Centrostrabajo.cliente_id = "' . $this->params['url']['cliente_id'] . '")');
        if (!empty($this->params['named']['cliente_id']))
            $conditions [] = array('1' => '1 AND Maquina.centrostrabajo_id IN (SELECT Centrostrabajo.id FROM centrostrabajos Centrostrabajo WHERE Centrostrabajo.cliente_id = "' . $this->params['named']['cliente_id'] . '")');

        $paginate_results_per_page = 20;
        if (!empty($this->params['url']['resultados_por_pagina']))
            $paginate_results_per_page = intval($this->params['url']['resultados_por_pagina']);
        if (!empty($this->params['named']['resultados_por_pagina']))
            $paginate_results_per_page = intval($this->params['named']['resultados_por_pagina']);

        $this->paginate = array('limit' => $paginate_results_per_page, 'contain' => $contain, 'conditions' => $conditions, 'url' => $this->params['pass']);

        $this->set('maquinas', $this->paginate());
    }

    function view($id = null) {
        if (!$id) {
            $this->flashWarnings(__('Invalid maquina', true));
            $this->redirect($this->referer());
        }
        $this->set('maquina', $this->Maquina->find('first', array('contain' => array('Articulosparamantenimiento' => 'Articulo', 'Otrosrepuesto' => 'Articulo', 'Centrostrabajo' => 'Cliente', 'Cliente'), 'conditions' => array('Maquina.id' => $id))));
    }

    function add() {
        if (!empty($this->data)) {
            $this->Maquina->create();
            if ($this->Maquina->save($this->data)) {
                $this->Session->setFlash(__('La Máquina ha sido guardada', true));
                $this->redirect(array('action' => 'view', $this->Maquina->id));
            } else {
                $this->flashWarnings(__('La Máquina no ha podido ser guardada. Inténtalo de nuevo.', true));
            }
        }
        $centrostrabajos = $this->Maquina->Centrostrabajo->find('list');
        $clientes = $this->Maquina->Cliente->find('list');
        $this->set(compact('centrostrabajos', 'clientes'));
    }

    function add_popup($cliente_id = null, $centrostrabajo_id = null) {
        if (!empty($this->data)) {
            $this->Maquina->create();
            if ($this->Maquina->save($this->data)) {
                /* Guarda fichero */
                if ($this->FileUpload->finalFile != null) {
                    $this->Maquina->saveField('maquinaescaneada', $this->FileUpload->finalFile);
                }
                /* Fin de Guarda Fichero */
                $this->Session->setFlash(__('La Máquina ha sido guardada', true));
                $this->redirect($this->referer());
            } else {
                $this->flashWarnings(__('La Máquina no ha podido ser guardada. Inténtalo de nuevo.', true));
                $this->redirect($this->referer());
            }
        }
        $centrostrabajos = $this->Maquina->Centrostrabajo->find('list');
        $clientes = $this->Maquina->Cliente->find('list');
        if (!empty($cliente_id)) {
            $this->data = array('Maquina' => array('cliente_id' => $cliente_id));
            $centrostrabajos = $this->Maquina->Centrostrabajo->find('list', array('conditions' => array('Centrostrabajo.cliente_id' => $cliente_id)));
            if (!empty($centrostrabajo_id))
                $this->data['Maquina']['centrostrabajo_id'] = $centrostrabajo_id;
        }
        $this->set(compact('centrostrabajos', 'clientes'));
    }

    function edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Máquina no Válida', true));
            $this->redirect(array('action' => 'index'));
        }

        if (!empty($this->data)) {
            if ($this->Maquina->save($this->data)) {
                /* Edicion de  fichero */
                $id = $this->Maquina->id;
                $upload = $this->Maquina->findById($id);
                if (!empty($this->data['Maquina']['remove_file'])) {
                    $this->FileUpload->RemoveFile($upload['Maquina']['maquinaescaneada']);
                    $this->Maquina->saveField('maquinaescaneada', null);
                }
                if ($this->FileUpload->finalFile != null) {
                    $this->FileUpload->RemoveFile($upload['Maquina']['maquinaescaneada']);
                    $this->Maquina->saveField('maquinaescaneada', $this->FileUpload->finalFile);
                }
                /* Fin de Edicion Fichero */
                $this->Session->setFlash(__('La Máquina ha sido guardada', true));
                $this->redirect(array('action' => 'view', $id));
            } else {
                $this->flashWarnings(__('La Máquina no ha podido ser guardada. Inténtalo de nuevo.', true));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Maquina->read(null, $id);
        }
        
        $clientes = $this->Maquina->Cliente->find('list');
        $maquina = $this->Maquina->find('first', array('contain' => array('Centrostrabajo' => 'Cliente'), 'conditions' => array('Maquina.id' => $id)));
        $centrostrabajos = $this->Maquina->Centrostrabajo->find('list', array('conditions' => array('Centrostrabajo.cliente_id' => $maquina['Centrostrabajo']['cliente_id'])));
        $this->set(compact('clientes', 'maquina', 'centrostrabajos'));

        /* Control de que la maquina no se pueda editar si esta pdte de facturar */
        $db = ConnectionManager::getInstance();
        $conn = $db->getDataSource('default');
        $query = ' SELECT maquinas.id '
                . 'FROM estadosalbaranesclientesreparaciones '
                . 'LEFT JOIN albaranesclientesreparaciones '
                . 'ON albaranesclientesreparaciones.estadosalbaranesclientesreparacione_id = estadosalbaranesclientesreparaciones.id '
                . 'LEFT JOIN maquinas '
                . 'ON albaranesclientesreparaciones.maquina_id = maquinas.id '
                . 'WHERE estadosalbaranesclientesreparaciones.id <> 3 '
                . 'AND maquinas.id = "' . $this->Maquina->id . '"';
        $res = $conn->query($query);
      //  echo ">>>" . $query;
        $hayFacturaPdte = FALSE;
        if (!empty($res) && sizeof($res) > 0) {
            $hayFacturaPdte = TRUE;
            $this->Session->setFlash(__('Máquina pendiente de facturar. NO puede cambiar de centro.', true));
        }
        $this->set('hayFacturaPdte', $hayFacturaPdte);        
        /*         * ***************************** */
    }

    function delete($id = null) {
        if (!$id) {
            $this->flashWarnings(__('Id de Máquina no válido', true));
            $this->redirect(array('action' => 'index'));
        }
        $upload = $this->Maquina->findById($id);
        if ($this->Maquina->delete($id)) {
            $this->FileUpload->RemoveFile($upload['Maquina']['maquinaescaneada']);
            $this->Session->setFlash(__('Máquina borrada', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->flashWarnings(__('No se ha podido borrar la máquina', true));
        $this->redirect($this->referer());
    }

    function search() {
        $this->autoRender = false;
        $search = $this->data[$this->modelClass]['Buscar'];
        $search = explode(' ', $search);
        $cond = "";
        $i = 0;
        foreach ($this->{$this->modelClass}->_schema as $field => $value) {
            //debug($field);
            if ($i > 0) {
                $cond = $cond . " OR ";
            }
            $n = 0;
            foreach ($search as $word) {
                if ($n > 0) {
                    $cond = $cond . " AND ";
                }
                $cond = $cond . " " . $this->modelClass . "." . $field . " LIKE '%" . $word . "%' ";
                $n++;
            }
            $i++;
        }
        $conditions = array('limit' => 500, 'conditions' => $cond);
        $this->paginate = $conditions;
        $_SESSION["last_search"] = $conditions;
        array_shift($_SESSION["last_search"]);
        $this->set(strtolower($this->name), $this->paginate());
        $this->render('index');
    }

    function pdf() {
        Configure::write('debug', 0);
        $this->layout = 'pdf'; //this will use the pdf.ctp layout
        // Operaciones que deseamos realizar y variables que pasaremos a la vista.
        $this->set('maquinas', $this->paginate());
        $this->render();
    }

    function selectAvisostalleres() {
        $maquinas = $this->Maquina->find('list', array('conditions' => array('Maquina.centrostrabajo_id' => $this->data['Avisostallere']['centrostrabajo_id'])));
        $this->set(compact('maquinas'));
    }

    function selectAvisosrepuestos() {
        $maquinas = $this->Maquina->find('list', array('conditions' => array('Maquina.centrostrabajo_id' => $this->data['Avisosrepuesto']['centrostrabajo_id'])));
        $this->set(compact('maquinas'));
    }

    function selectAlbaranesclientesreparaciones() {
        $maquinas = $this->Maquina->find('list', array('conditions' => array('Maquina.centrostrabajo_id' => $this->data['Albaranesclientesreparacione']['centrostrabajo_id'])));
        $this->set(compact('maquinas'));
    }

    function selectAlbaranesclientes() {
        $maquinas = $this->Maquina->find('list', array('conditions' => array('Maquina.centrostrabajo_id' => $this->data['Albaranescliente']['centrostrabajo_id'])));
        $this->set(compact('maquinas'));
    }

    function selectPresupuestosclientes() {
        $maquinas = $this->Maquina->find('list', array('conditions' => array('Maquina.centrostrabajo_id' => $this->data['Presupuestoscliente']['centrostrabajo_id'])));
        $this->set(compact('maquinas'));
    }
    function selectOrdenes() {
        $maquinas = $this->Maquina->find('list', array('conditions' => array('Maquina.centrostrabajo_id' => $this->data['Ordene']['centrostrabajo_id'])));
        $this->set(compact('maquinas'));
    }

    function json_basico() {
        Configure::write('debug', 0);
        $this->layout = 'json';
        $maquinas = $this->Maquina->find('all', array(
            'fields' => array('id', 'codigo', 'nombre', 'serie_maquina'),
            'contain' => '',
            'conditions' => array(
                'OR' => array('Maquina.codigo LIKE' => '%' . $this->params['url']['q'] . '%', 'Maquina.nombre LIKE' => '%' . $this->params['url']['q'] . '%', 'Maquina.serie_maquina LIKE' => '%' . $this->params['url']['q'] . '%')
            ),
                ));
        $maquinas_array = array();
        foreach ($maquinas as $maquina) {
            $maquinas_array[] = array("id" => $maquina["Maquina"]["id"], "nombre" => $maquina["Maquina"]["nombre"], "codigo" => $maquina["Maquina"]["codigo"], "serie_maquina" => $maquina["Maquina"]["serie_maquina"]);
        }
        $json['maquinas'] = $maquinas_array;
        $this->set('maquinas', $json);
        $this->render('json');
    }

    function get_json($id) {
        Configure::write('debug', 0);
        $this->layout = 'json';
        $maquina = $this->Maquina->find('first', array(
            'fields' => array('id', 'codigo', 'nombre', 'serie_maquina'),
            'contain' => '',
            'conditions' => array(
                'Maquina.id ' => $id
            ),
                ));
        $this->set('maquinas', $maquina['Maquina']);
        $this->render('json');
    }

    function beforeFilter() {
        parent::beforeFilter();
        $this->checkPermissions('Maquina', $this->params['action']);
        if ($this->params['action'] == 'edit' || $this->params['action'] == 'add' || $this->params['action'] == 'add_popup') {
            $this->FileUpload->fileModel = 'Maquina';
            $this->FileUpload->uploadDir = 'files/maquina';
            $this->FileUpload->fields = array('name' => 'file_name', 'type' => 'file_type', 'size' => 'file_size');
        }
    }

}

?>
