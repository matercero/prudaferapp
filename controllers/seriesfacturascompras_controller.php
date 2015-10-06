<?php

class SeriesfacturascomprasController extends AppController {

    var $name = 'Seriesfacturascompras';

    function index() {
        $this->Seriesfacturascompra->recursive = 0;
        $this->set('seriesfacturascompras', $this->paginate());
    }

    function view($id = null) {
        if (!$id) {
            $this->flashWarnings(__('Invalid series de Factura de Compra', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->set('seriesfacturascompra', $this->Seriesfacturascompra->read(null, $id));
    }

    function add() {
        if (!empty($this->data)) {
            $this->Seriesfacturascompra->create();
            $serie = $this->Seriesfacturascompra->findBySerie($this->data['Seriesfacturascompra']['serie']);
            if (empty($serie)) {
                if ($this->Seriesfacturascompra->save($this->data)) {
                    $this->Session->setFlash(__('The Seriesfacturascompra has been saved', true));
                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->flashWarnings(__('The Seriesfacturascompra could not be saved. Please, try again.', true));
                }
            } else {
                $this->flashWarnings('No se puede guardar la Serie: Serie Repetida');
            }
        }
    }

    function edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->flashWarnings(__('Invalid Seriesfacturascompra', true));
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            $serie = $this->Seriesfacturascompra->findBySerie($this->data['Seriesfacturascompra']['serie']);
            if (empty($serie)) {
                if ($this->Seriesfacturascompra->save($this->data)) {
                    $this->Session->setFlash(__('The Seriesfacturascompra has been saved', true));
                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->flashWarnings(__('The Seriesfacturascompra could not be saved. Please, try again.', true));
                }
            } else {
                $this->flashWarnings('No se puede guardar la Serie: Serie Repetida');
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Seriesfacturascompra->read(null, $id);
        }
    }

    function delete($id = null) {
        if (!$id) {
            $this->flashWarnings(__('Invalid id for  Seriesfacturascompra', true));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->Seriesfacturascompra->delete($id)) {
            $this->flashWarnings(__('Seriesfacturascompra deleted', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->flashWarnings(__('Seriesfacturascompra was not deleted', true));
        $this->redirect(array('action' => 'index'));
    }

}

?>