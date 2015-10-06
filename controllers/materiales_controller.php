<?php

class MaterialesController extends AppController {

    var $name = 'Materiales';
    var $helpers = array('Autocomplete','Ajax','Javascript'); 
    var $components = array('Session','RequestHandler' );
    
    function index() {
        $this->Materiale->recursive = 0;
        $this->set('materiales', $this->paginate());
    }

    function view($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid materiale', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->set('materiale', $this->Materiale->read(null, $id));
    }

    /**
     * Debe venir de una tarea siempre
     * @param type $tareaspresupuestocliente_id
     */
    function add($tareaspresupuestocliente_id) {
        $this->layout = 'ajax';
        if (!empty($this->data)) {
            $this->Materiale->create();
            if ($this->Materiale->save($this->data)) {
                $this->Session->setFlash(__('El material ha sido añadido', true));
                $this->redirect($this->referer());
            } else {
                $this->flashWarnings(__('El material no se pudo añadir. Prueba de nuevo.', true));
            }
        }
        $tareaspresupuestocliente = $this->Materiale->Tareaspresupuestocliente->find('first',array('contain' => 'Presupuestoscliente','conditions' => array('Tareaspresupuestocliente.id' => $tareaspresupuestocliente_id)));
        $this->set(compact('tareaspresupuestocliente_id','tareaspresupuestocliente'));
    }
    function add_ajax($tareaspresupuestocliente_id) {
        $this->layout = 'ajax';
        if (!empty($this->data)) {
            $this->Materiale->create();
            if ($this->Materiale->save($this->data)) {
                $this->Session->setFlash(__('El material ha sido añadido', true));
            } else {
                $this->flashWarnings(__('El material no se pudo añadir. Prueba de nuevo.', true));
            }
        }
        $tareaspresupuestocliente = $this->Materiale->Tareaspresupuestocliente->find('first',array('contain' => 'Presupuestoscliente','conditions' => array('Tareaspresupuestocliente.id' => $tareaspresupuestocliente_id)));
        $this->set(compact('tareaspresupuestocliente_id','tareaspresupuestocliente'));
        $this->render('add');
    }

    function edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid materiale', true));
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            if ($this->Materiale->save($this->data)) {
                $this->Session->setFlash(__('The materiale has been saved', true));
                $this->redirect($this->referer());
            } else {
                $this->Session->setFlash(__('The materiale could not be saved. Please, try again.', true));
                $this->redirect($this->referer());
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Materiale->read(null, $id);
        }
        $this->layout = 'ajax';
        $tareaspresupuestocliente = $this->Materiale->Tareaspresupuestocliente->find('first',array('contain' => 'Presupuestoscliente','conditions' => array('Tareaspresupuestocliente.id' => $this->data['Materiale']['tareaspresupuestocliente_id'])));
        $this->set(compact('tareaspresupuestocliente'));
    }

    /**
     * Ajax
     * @param int $id 
     */
    function ajax_edit($id = null) {
        $this->Materiale->id = $this->data['Materiale']['id'];
        $this->Materiale->saveField('cantidad_pedir', $this->data['Materiale']['cantidad_pedir']);
        $this->layout = 'ajax';
        $this->set('materiale_id', $this->Materiale->id);
    }

    /**
     * Ajax
     * @param int $id 
     */
    function update_tarea() {
        $this->Materiale->id = $this->data['materiale_id'];
        $this->Materiale->saveField('tareaspresupuestocliente_id', $this->data['tareaspresupuestocliente_id']);
        $this->Session->setFlash(__('Material Actualizado Correctamente', true));
        $this->layout = 'ajax';
    }

    function delete($id = null) {
        if (!$id) {
            $this->flashWarnings(__('Id no válido para el material', true));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->Materiale->delete($id)) {
            $this->Session->setFlash(__('Material  para la Tarea eliminado', true));
            $this->redirect($this->referer());
        }
        $this->flashWarnings(__('No se pudo eliminar el Material para la Tarea', true));
        $this->redirect(array('action' => 'index'));
    }

    
    function ver_ultima_venta($id) {
        $this->loadModel('MaterialesTareasalbaranescliente');
        $materiale = $this->Materiale->find('first', array(
            'contain' => array('Tareaspresupuestocliente' => 'Presupuestoscliente'),
            'conditions' => array('Materiale.id' => $id)
                ));
        $cliente_id = $materiale['Tareaspresupuestocliente']['Presupuestoscliente']['cliente_id'];
        $presupuestoscliente_id = $materiale['Tareaspresupuestocliente']['Presupuestoscliente']['id'];
        $articulo_id = $materiale['Materiale']['articulo_id'];

        $ultimo_precio_venta = 0;
        $sql = "SELECT * FROM materiales_tareasalbaranesclientes as MaterialesTareasalbaranescliente WHERE MaterialesTareasalbaranescliente.articulo_id = '" . $articulo_id . "' AND  MaterialesTareasalbaranescliente.tareasalbaranescliente_id IN (SELECT Tareasalbaranescliente.id FROM tareasalbaranesclientes as Tareasalbaranescliente WHERE Tareasalbaranescliente.albaranescliente_id IN (SELECT Albaranescliente.id FROM albaranesclientes as Albaranescliente WHERE Albaranescliente.cliente_id = '" . $cliente_id . "')) ORDER BY  MaterialesTareasalbaranescliente.id DESC;";
        $materiales_ultimo_vendidos = $this->MaterialesTareasalbaranescliente->query($sql);
        $materiale = array_shift($materiales_ultimo_vendidos);
        
        $materiale = $this->MaterialesTareasalbaranescliente->find('first', array(
            'contain' => array('Tareasalbaranescliente' => 'Albaranescliente'),
            'conditions' => array('MaterialesTareasalbaranescliente.id' => $materiale['MaterialesTareasalbaranescliente']['id'])
                ));
        $this->set(compact('materiale'));
    }
}

?>