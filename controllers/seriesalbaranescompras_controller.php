<?php

class SeriesalbaranescomprasController extends AppController {

    var $name = 'Seriesalbaranescompras';

    function index() {
        $this->Seriesalbaranescompra->recursive = 0;
        $this->set('seriesalbaranescompras', $this->paginate());
    }

    function view($id = null) {
        if (!$id) {
            $this->flashWarnings(__('Invalid series de Albarán de venta', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->set('seriesalbaranescompra', $this->Seriesalbaranescompra->read(null, $id));
    }

    function add() {
        if (!empty($this->data)) {
            $this->Seriesalbaranescompra->create();
            $serie = $this->Seriesalbaranescompra->findBySerie($this->data['Seriesalbaranescompra']['serie']);
            if (empty($serie)) {
                if ($this->Seriesalbaranescompra->save($this->data)) {
                    $this->Session->setFlash(__('The Seriesalbaranescompra has been saved', true));
                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->flashWarnings(__('The Seriesalbaranescompra could not be saved. Please, try again.', true));
                }
            } else {
                $this->flashWarnings('No se puede guardar la Serie: Serie Repetida');
            }
        }
    }

    function edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->flashWarnings(__('Invalid Seriesalbaranescompra', true));
            $this->redirect(array('action' => 'index'));
        }

        if (!empty($this->data)) {
            $serie = $this->Seriesalbaranescompra->findBySerie($this->data['Seriesalbaranescompra']['serie']);
            if (empty($serie)) {
                if ($this->Seriesalbaranescompra->save($this->data)) {
                    $this->Session->setFlash(__('The Seriesalbaranescompra has been saved', true));
                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->flashWarnings(__('The Seriesalbaranescompra could not be saved. Please, try again.', true));
                }
            } else {
                $this->flashWarnings('No se puede guardar la Serie: Serie Repetida');
            }
        }

        if (empty($this->data)) {
            $this->data = $this->Seriesalbaranescompra->read(null, $id);
        }
    }

    function delete($id = null) {
        if (!$id) {
            $this->flashWarnings(__('Invalid id for  Seriesalbaranescompra', true));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->Seriesalbaranescompra->delete($id)) {
            $this->flashWarnings(__('Seriesalbaranescompra deleted', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->flashWarnings(__('Seriesalbaranescompra was not deleted', true));
        $this->redirect(array('action' => 'index'));
    }

}

?>