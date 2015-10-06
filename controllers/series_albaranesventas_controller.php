<?php

class SeriesAlbaranesventasController extends AppController {

    var $name = 'SeriesAlbaranesventas';

    function index() {
        $this->SeriesAlbaranesventa->recursive = 0;
        $this->set('seriesAlbaranesventas', $this->paginate());
    }

    function view($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid series albaranesventa', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->set('seriesAlbaranesventa', $this->SeriesAlbaranesventa->read(null, $id));
    }

    function add() {
        if (!empty($this->data)) {
            $this->SeriesAlbaranesventa->create();
            $serie = $this->SeriesAlbaranesventa->findBySerie($this->data['SeriesAlbaranesventa']['serie']);
            if (empty($serie)) {
                if ($this->SeriesAlbaranesventa->save($this->data)) {
                    $this->Session->setFlash(__('The series albaranesventa has been saved', true));
                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->flashWarnings(__('The series albaranesventa could not be saved. Please, try again.', true));
                }
            } else {
                $this->flashWarnings('No se puede guardar la Serie: Serie Repetida');
            }
        }
    }

    function edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid series albaranesventa', true));
            $this->redirect(array('action' => 'index'));
        }
        $serie = $this->SeriesAlbaranesventa->findBySerie($this->data['SeriesAlbaranesventa']['serie']);
        if (empty($serie)) {
            if (!empty($this->data)) {
                if ($this->SeriesAlbaranesventa->save($this->data)) {
                    $this->Session->setFlash(__('The series albaranesventa has been saved', true));
                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->Session->setFlash(__('The series albaranesventa could not be saved. Please, try again.', true));
                }
            }
        } else {
            $this->flashWarnings('No se puede guardar la Serie: Serie Repetida');
        }
        if (empty($this->data)) {
            $this->data = $this->SeriesAlbaranesventa->read(null, $id);
        }
    }

    function delete($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for series albaranesventa', true));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->SeriesAlbaranesventa->delete($id)) {
            $this->Session->setFlash(__('Series albaranesventa deleted', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Series albaranesventa was not deleted', true));
        $this->redirect(array('action' => 'index'));
    }

}

?>