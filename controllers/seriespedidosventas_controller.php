<?php

class SeriespedidosventasController extends AppController {

    var $name = 'Seriespedidosventas';

    function index() {
        $this->Seriespedidosventa->recursive = 0;
        $this->set('seriespedidosventas', $this->paginate());
    }

    function view($id = null) {
        if (!$id) {
            $this->flashWarnings(__('Invalid series de pedido de venta', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->set('seriespedidosventa', $this->Seriespedidosventa->read(null, $id));
    }

    function add() {
        if (!empty($this->data)) {
            $this->Seriespedidosventa->create();
            $serie = $this->Seriespedidosventa->findBySerie($this->data['Seriespedidosventa']['serie']);
            if (empty($serie)) {
                if ($this->Seriespedidosventa->save($this->data)) {
                    $this->Session->setFlash(__('The Seriespedidosventa has been saved', true));
                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->flashWarnings(__('The Seriespedidosventa could not be saved. Please, try again.', true));
                }
            } else {
                $this->flashWarnings('No se puede guardar la Serie: Serie Repetida');
            }
        }
    }

    function edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->flashWarnings(__('Invalid Seriespedidosventa', true));
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            $serie = $this->Seriespedidosventa->findBySerie($this->data['Seriespedidosventa']['serie']);
            if (empty($serie)) {
                if ($this->Seriespedidosventa->save($this->data)) {
                    $this->Session->setFlash(__('The Seriespedidosventa has been saved', true));
                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->flashWarnings(__('The Seriespedidosventa could not be saved. Please, try again.', true));
                }
            } else {
                $this->flashWarnings('No se puede guardar la Serie: Serie Repetida');
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Seriespedidosventa->read(null, $id);
        }
    }

    function delete($id = null) {
        if (!$id) {
            $this->flashWarnings(__('Invalid id for  Seriespedidosventa', true));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->Seriespedidosventa->delete($id)) {
            $this->flashWarnings(__('Seriespedidosventa deleted', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->flashWarnings(__('Seriespedidosventa was not deleted', true));
        $this->redirect(array('action' => 'index'));
    }

}

?>
