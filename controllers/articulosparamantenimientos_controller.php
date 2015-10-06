<?php

class ArticulosparamantenimientosController extends AppController {

    var $name = 'Articulosparamantenimientos';
    var $helpers = array('Form', 'Ajax', 'Js', 'Autocomplete');
    var $components = array('RequestHandler', 'Session');

    function index() {
        $this->Articulosparamantenimiento->recursive = 0;
        $this->set('articulosparamantenimientos', $this->paginate());
    }

    function view($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid articulosparamantenimiento', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->set('articulosparamantenimiento', $this->Articulosparamantenimiento->read(null, $id));
    }

    function add($maquina_id = null) {
        if (!empty($this->data)) {
            $this->Articulosparamantenimiento->create();
            if ($this->Articulosparamantenimiento->save($this->data)) {
                $this->Session->setFlash(__('El Artículo para mantenimiento ha sido guardado', true));
                $this->redirect($this->referer());
            } else {
                $this->Session->setFlash(__('El Artículo para mantenimiento no ha sido guardado. Por favor, prueba de nuevo.', true));
                $this->redirect($this->referer());
            }
        }
        $this->set(compact('maquina_id'));
    }

    function add_ajax($maquina_id = null) {
        if (!empty($this->data)) {
            $this->Articulosparamantenimiento->create();
            if ($this->Articulosparamantenimiento->save($this->data)) {
                $this->Session->setFlash(__('El Artículo para mantenimiento ha sido guardado', true));
            } else {
                $this->Session->setFlash(__('El Artículo para mantenimiento no ha sido guardado. Por favor, prueba de nuevo.', true));
            }
        }
        $this->set(compact('maquina_id'));
        $this->render('add');
    }

    function edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid articulosparamantenimiento', true));
            $this->redirect($this->referer());
        }
        if (!empty($this->data)) {
            if ($this->Articulosparamantenimiento->save($this->data)) {
                $this->Session->setFlash(__('El Artículo para mantenimiento ha sido guardado', true));
                $this->redirect($this->referer());
            } else {
                $this->Session->setFlash(__('El Artículo para mantenimiento no ha sido guardado. Por favor, prueba de nuevo.', true));
                $this->redirect($this->referer());
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Articulosparamantenimiento->read(null, $id);
        }
    }

    function delete($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for articulosparamantenimiento', true));
            $this->redirect($this->referer());
        }
        if ($this->Articulosparamantenimiento->delete($id)) {
            $this->Session->setFlash(__('Articulosparamantenimiento deleted', true));
            $this->redirect($this->referer());
        }
        $this->Session->setFlash(__('Articulosparamantenimiento was not deleted', true));
        $this->redirect($this->referer());
    }

}

?>