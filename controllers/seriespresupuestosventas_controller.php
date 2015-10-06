<?php

class SeriespresupuestosventasController extends AppController {

    var $name = 'Seriespresupuestosventas';

    function index() {
        $this->Seriespresupuestosventa->recursive = 0;
        $this->set('seriespresupuestosventas', $this->paginate());
    }

    function view($id = null) {
        if (!$id) {
            $this->flashWarnings(__('Invalid series de presupuesto de venta', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->set('seriespresupuestosventa', $this->Seriespresupuestosventa->read(null, $id));
    }

    function add() {
        if (!empty($this->data)) {
            $this->Seriespresupuestosventa->create();
            $serie = $this->Seriespresupuestosventa->findBySerie($this->data['Seriespresupuestosventa']['serie']);
            if (empty($serie)) {
                if ($this->Seriespresupuestosventa->save($this->data)) {
                    $this->Session->setFlash(__('The Seriespresupuestosventa has been saved', true));
                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->flashWarnings(__('The Seriespresupuestosventa could not be saved. Please, try again.', true));
                }
            } else {
                $this->flashWarnings('No se puede guardar la Serie: Serie Repetida');
            }
        }
    }

    function edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->flashWarnings(__('Invalid Seriespresupuestosventa', true));
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            $serie = $this->Seriespresupuestosventa->findBySerie($this->data['Seriespresupuestosventa']['serie']);
            if (empty($serie)) {
                if ($this->Seriespresupuestosventa->save($this->data)) {
                    $this->Session->setFlash(__('The Seriespresupuestosventa has been saved', true));
                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->flashWarnings(__('The Seriespresupuestosventa could not be saved. Please, try again.', true));
                }
            } else {
                $this->flashWarnings('No se puede guardar la Serie: Serie Repetida');
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Seriespresupuestosventa->read(null, $id);
        }
    }

    function delete($id = null) {
        if (!$id) {
            $this->flashWarnings(__('Invalid id for  Seriespresupuestosventa', true));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->Seriespresupuestosventa->delete($id)) {
            $this->flashWarnings(__('Seriespresupuestosventa deleted', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->flashWarnings(__('Seriespresupuestosventa was not deleted', true));
        $this->redirect(array('action' => 'index'));
    }

}

?>