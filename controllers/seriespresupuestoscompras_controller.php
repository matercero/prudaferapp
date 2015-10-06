<?php

class SeriespresupuestoscomprasController extends AppController {

    var $name = 'Seriespresupuestoscompras';

    function index() {
        $this->Seriespresupuestoscompra->recursive = 0;
        $this->set('seriespresupuestoscompras', $this->paginate());
    }

    function view($id = null) {
        if (!$id) {
            $this->flashWarnings(__('Invalid series de pedido de venta', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->set('seriespresupuestoscompra', $this->Seriespresupuestoscompra->read(null, $id));
    }

    function add() {
        if (!empty($this->data)) {
            $this->Seriespresupuestoscompra->create();
            $serie = $this->Seriespresupuestoscompra->findBySerie($this->data['Seriespresupuestoscompra']['serie']);
            if (empty($serie)) {
                if ($this->Seriespresupuestoscompra->save($this->data)) {
                    $this->Session->setFlash(__('The Seriespresupuestoscompra has been saved', true));
                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->flashWarnings(__('The Seriespresupuestoscompra could not be saved. Please, try again.', true));
                }
            } else {
                $this->flashWarnings('No se puede guardar la Serie: Serie Repetida');
            }
        }
    }

    function edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->flashWarnings(__('Invalid Seriespresupuestoscompra', true));
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            $serie = $this->Seriespresupuestoscompra->findBySerie($this->data['Seriespresupuestoscompra']['serie']);
            if (empty($serie)) {
                if ($this->Seriespresupuestoscompra->save($this->data)) {
                    $this->Session->setFlash(__('The Seriespresupuestoscompra has been saved', true));
                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->flashWarnings(__('The Seriespresupuestoscompra could not be saved. Please, try again.', true));
                }
            } else {
                $this->flashWarnings('No se puede guardar la Serie: Serie Repetida');
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Seriespresupuestoscompra->read(null, $id);
        }
    }

    function delete($id = null) {
        if (!$id) {
            $this->flashWarnings(__('Invalid id for  Seriespresupuestoscompra', true));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->Seriespresupuestoscompra->delete($id)) {
            $this->flashWarnings(__('Seriespresupuestoscompra deleted', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->flashWarnings(__('Seriespresupuestoscompra was not deleted', true));
        $this->redirect(array('action' => 'index'));
    }

}

?>