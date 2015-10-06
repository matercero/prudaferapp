<?php

class SeriespedidoscomprasController extends AppController {

    var $name = 'Seriespedidoscompras';

    function index() {
        $this->Seriespedidoscompra->recursive = 0;
        $this->set('seriespedidoscompras', $this->paginate());
    }

    function view($id = null) {
        if (!$id) {
            $this->flashWarnings(__('Invalid series de pedido de venta', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->set('seriespedidoscompra', $this->Seriespedidoscompra->read(null, $id));
    }

    function add() {
        if (!empty($this->data)) {
            $this->Seriespedidoscompra->create();
            $serie = $this->Seriespedidoscompra->findBySerie($this->data['Seriespedidoscompra']['serie']);
            if (empty($serie)) {
                if ($this->Seriespedidoscompra->save($this->data)) {
                    $this->Session->setFlash(__('The Seriespedidoscompra has been saved', true));
                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->flashWarnings(__('The Seriespedidoscompra could not be saved. Please, try again.', true));
                }
            } else {
                $this->flashWarnings('No se puede guardar la Serie: Serie Repetida');
            }
        }
    }

    function edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->flashWarnings(__('Invalid Seriespedidoscompra', true));
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            $serie = $this->Seriespedidoscompra->findBySerie($this->data['Seriespedidoscompra']['serie']);
            if (empty($serie)) {
                if ($this->Seriespedidoscompra->save($this->data)) {
                    $this->Session->setFlash(__('The Seriespedidoscompra has been saved', true));
                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->flashWarnings(__('The Seriespedidoscompra could not be saved. Please, try again.', true));
                }
            } else {
                $this->flashWarnings('No se puede guardar la Serie: Serie Repetida');
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Seriespedidoscompra->read(null, $id);
        }
    }

    function delete($id = null) {
        if (!$id) {
            $this->flashWarnings(__('Invalid id for  Seriespedidoscompra', true));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->Seriespedidoscompra->delete($id)) {
            $this->flashWarnings(__('Seriespedidoscompra deleted', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->flashWarnings(__('Seriespedidoscompra was not deleted', true));
        $this->redirect(array('action' => 'index'));
    }

}

?>
