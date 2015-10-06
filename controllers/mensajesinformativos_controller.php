<?php
class MensajesinformativosController extends AppController {

	var $name = 'Mensajesinformativos';

	function index() {
		$this->Mensajesinformativo->recursive = 0;
		$this->set('mensajesinformativos', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid mensajesinformativo', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('mensajesinformativo', $this->Mensajesinformativo->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Mensajesinformativo->create();
			if ($this->Mensajesinformativo->save($this->data)) {
				$this->Session->setFlash(__('The mensajesinformativo has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The mensajesinformativo could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid mensajesinformativo', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Mensajesinformativo->save($this->data)) {
				$this->Session->setFlash(__('The mensajesinformativo has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The mensajesinformativo could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Mensajesinformativo->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for mensajesinformativo', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Mensajesinformativo->delete($id)) {
			$this->Session->setFlash(__('Mensajesinformativo deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Mensajesinformativo was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>