<?php

class AlmacenesController extends AppController {

    var $name = 'Almacenes';

    function index() {
        $this->Almacene->recursive = 0;
        $this->set('almacenes', $this->paginate());
    }

    function view($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Almacén inválido', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->set('almacene', $this->Almacene->read(null, $id));
    }

    function add() {
        if (!empty($this->data)) {
            $this->Almacene->create();
            if ($this->Almacene->save($this->data)) {
                $this->Session->setFlash(__('El almacén ha sido guardado', true));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('El almacén no ha podido ser guardado. Por favor, inténtelo de nuevo', true));
            }
        }
    }

    function edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Almacén inválido', true));
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            if ($this->Almacene->save($this->data)) {
                $this->Session->setFlash(__('El almacén ha sido guardado', true));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('El almacén no ha podido ser guardado. Por favor, inténtelo de nuevo', true));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Almacene->read(null, $id);
        }
    }

    function delete($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Id de Almacén inválida', true));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->Almacene->delete($id)) {
            $this->Session->setFlash(__('Almacén eliminado', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('El almacén no ha podido ser eliminado', true));
        $this->redirect(array('action' => 'index'));
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
        if (isset($_SESSION["last_search"])) {
            $this->set('almacenes', $this->Almacene->find('all', $_SESSION["last_search"]));
        } else {
            $this->set('almacenes', $this->Almacene->find('all', array('limit' => 200)));
        }
        unset($_SESSION["last_search"]);
        $this->render();
    }

    function beforeFilter() {
        $this->checkPermissions('Almacene', $this->params['action']);
    }

    function json_basico() {
        Configure::write('debug', 0);
        $this->layout = 'json';
        $almacenes = $this->Almacene->find('all', array(
            'fields' => array('id', 'nombre', 'direccion', 'codalm'),
            'contain' => '',
            'conditions' => array(
                'OR' => array('Almacene.nombre LIKE' => '%' . $this->params['url']['q'] . '%', 'Almacene.direccion LIKE' => '%' . $this->params['url']['q'] . '%', 'Almacene.codalm LIKE' => '%' . $this->params['url']['q'] . '%')
            ),
                ));
        $almacenes_array = array();
        foreach ($almacenes as $almacene) {
            $almacenes_array[] = array("id" => $almacene["Almacene"]["id"], "nombre" => $almacene["Almacene"]["nombre"], "direccion" => $almacene["Almacene"]["direccion"], "codalm" => $almacene["Almacene"]["codalm"]);
        }
        $json['almacenes'] = $almacenes_array;
        $this->set('almacenes', $json);
        $this->render('json');
    }
    }

    function get_json($id) {
        Configure::write('debug', 0);
        $this->layout = 'json';
        $almacene = $this->Almacene->find('first', array(
            'contain' => '',
            'conditions' => array(
                'Almacene.id ' => $id
            ),
                ));
        $this->set('almacenes', $almacene['Almacene']);
        $this->render('json');
    }

?>

