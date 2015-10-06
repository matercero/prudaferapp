<?php

class FormapagosController extends AppController {

    var $name = 'Formapagos';

    function index() {

        $contain = array('Cliente', 'Proveedore');
        $conditions = array();

        if (!empty($this->params['url']['nombre']))
            $conditions [] = array('Formapago.nombre LIKE' => '%' . $this->params['url']['nombre'] . '%');
        if (!empty($this->params['named']['nombre']))
            $conditions [] = array('Formapago.nombre LIKE' => '%' . $this->params['named']['nombre'] . '%');


        if (!empty($this->params['url']['proveedore_id']))
            $conditions [] = array('Formapago.proveedore_id' => $this->params['url']['proveedore_id']);
        if (!empty($this->params['named']['proveedore_id']))
            $conditions [] = array('Formapago.proveedore_id' => $this->params['named']['proveedore_id']);


        if (!empty($this->params['url']['cliente_id']))
            $conditions [] = array('Formapago.cliente_id' => $this->params['url']['cliente_id']);
        if (!empty($this->params['named']['cliente_id']))
            $conditions [] = array('Formapago.cliente_id' => $this->params['named']['cliente_id']);

        $paginate_results_per_page = 20;
        if (!empty($this->params['url']['resultados_por_pagina']))
            $paginate_results_per_page = intval($this->params['url']['resultados_por_pagina']);
        if (!empty($this->params['named']['resultados_por_pagina']))
            $paginate_results_per_page = intval($this->params['named']['resultados_por_pagina']);

        $this->paginate = array('limit' => $paginate_results_per_page, 'contain' => $contain, 'conditions' => $conditions, 'url' => $this->params['pass']);
        $this->Formapago->recursive = 0;
        $this->set('formapagos', $this->paginate());
    }

    function view($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid formapago', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->set('formapago', $this->Formapago->read(null, $id));
    }

    function add() {
        if (!empty($this->data)) {
            $this->Formapago->create();
            if ($this->Formapago->save($this->data)) {
                $this->Session->setFlash(__('The formapago has been saved', true));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The formapago could not be saved. Please, try again.', true));
            }
        }
        $proveedores = $this->Formapago->Proveedore->find('list');
        $clientes = $this->Formapago->Cliente->find('list');
        $this->set(compact('proveedores', 'clientes'));
    }

    function edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid formapago', true));
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            if ($this->Formapago->save($this->data)) {
                $this->Session->setFlash(__('The formapago has been saved', true));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The formapago could not be saved. Please, try again.', true));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Formapago->read(null, $id);
        }
        $proveedores = $this->Formapago->Proveedore->find('list');
        $clientes = $this->Formapago->Cliente->find('list');
        $this->set(compact('proveedores', 'clientes'));
    }

    function delete($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for formapago', true));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->Formapago->delete($id)) {
            $this->Session->setFlash(__('Formapago deleted', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Formapago was not deleted', true));
        $this->redirect(array('action' => 'index'));
    }

}

?>