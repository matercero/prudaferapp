<?php

class SeriesfacturasventasController extends AppController {

    var $name = 'Seriesfacturasventas';

    function index() {
        $this->Seriesfacturasventa->recursive = 0;
        $this->set('seriesfacturasventas', $this->paginate());
    }

    function view($id = null) {
        if (!$id) {
            $this->flashWarnings(__('Invalid series de presupuesto de venta', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->set('seriesfacturasventas', $this->Seriesfacturasventa->read(null, $id));
    }

    function add() {
        if (!empty($this->data)) {
            $this->Seriesfacturasventa->create();
            $serie = $this->Seriesfacturasventa->findBySerie($this->data['Seriesfacturasventa']['serie']);
            if (empty($serie)) {
                if ($this->Seriesfacturasventa->save($this->data)) {
                    $this->Session->setFlash(__('The Seriesfacturasventa has been saved', true));
                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->flashWarnings(__('The Seriesfacturasventa could not be saved. Please, try again.', true));
                }
            } else {
                $this->flashWarnings('No se puede guardar la Serie: Serie Repetida');
            }
        }
    }

    function edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->flashWarnings(__('Invalid Seriesfacturasventa', true));
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            $serie = $this->Seriesfacturasventa->findBySerie($this->data['Seriesfacturasventa']['serie']);
            if (empty($serie)) {
                if ($this->Seriesfacturasventa->save($this->data)) {
                    $this->Session->setFlash(__('The Seriesfacturasventa has been saved', true));
                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->flashWarnings(__('The Seriesfacturasventa could not be saved. Please, try again.', true));
                }
            } else {
                $this->flashWarnings('No se puede guardar la Serie: Serie Repetida');
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Seriesfacturasventa->read(null, $id);
        }
    }

    function delete($id = null) {
        if (!$id) {
            $this->flashWarnings(__('Invalid id for  Seriesfacturasventa', true));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->Seriesfacturasventa->delete($id)) {
            $this->flashWarnings(__('Seriesfacturasventa deleted', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->flashWarnings(__('Seriesfacturasventa was not deleted', true));
        $this->redirect(array('action' => 'index'));
    }

}

?>