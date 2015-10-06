<?php

class PartestalleresController extends AppController {

    var $name = 'Partestalleres';
    var $helpers = array('Form', 'Ajax', 'Js', 'Time');
    var $components = array('RequestHandler', 'FileUpload', 'Session');

    function beforeFilter() {
        parent::beforeFilter();
        if ($this->params['action'] == 'edit' || $this->params['action'] == 'add') {
            $this->FileUpload->fileModel = 'Partestallere';
            $this->FileUpload->uploadDir = 'files/partestallere';
            $this->FileUpload->fields = array('name' => 'file_name', 'type' => 'file_type', 'size' => 'file_size');
        }
    }

    function index() {
        $this->layout = 'ajax';
        $this->Parte->recursive = 0;
        $conditions_partestalleres = array();
        if (!empty($this->params['url']['numero'])) {
            $conditions_partestalleres [] = array('1' => '1 AND Partestallere.tarea_id IN (SELECT Tarea.id FROM tareas Tarea WHERE Tarea.ordene_id IN (SELECT Ordene.id FROM ordenes Ordene WHERE Ordene.numero = ' . $this->params['url']['numero'] . '))');
        }
        if (!empty($this->params['named']['numero'])) {
            $conditions_partestalleres [] = array('1' => '1 AND Partestallere.tarea_id IN (SELECT Tarea.id FROM tareas Tarea WHERE Tarea.ordene_id IN (SELECT Ordene.id FROM ordenes Ordene WHERE Ordene.numero = ' . $this->params['named']['numero'] . '))');
        }

        if (!empty($this->params['url']['mecanico_id'])) {
            $conditions_partestalleres [] = array('Partestallere.mecanico_id' => $this->params['url']['mecanico_id']);
        } else {
            $conditions_partestalleres [] = array('1' => '1 AND Partestallere.mecanico_id IN (SELECT Mecanico.id FROM mecanicos Mecanico WHERE Mecanico.activo = 1)');
        }
        if (!empty($this->params['named']['mecanico_id'])) {
            $conditions_partestalleres [] = array('Partestallere.mecanico_id' => $this->params['named']['mecanico_id']);
        } else {
            $conditions_partestalleres [] = array('1' => '1 AND Partestallere.mecanico_id IN (SELECT Mecanico.id FROM mecanicos Mecanico WHERE Mecanico.activo = 1)');
        }


        if (!empty($this->params['url']['fecha_inicio']) && !empty($this->params['url']['fecha_fin'])) {
            $data1 = implode('-', array_reverse($this->params['url']['fecha_inicio']));
            $data2 = implode('-', array_reverse($this->params['url']['fecha_fin']));
            $conditions_partestalleres[] = array("Partestallere.fecha BETWEEN '$data1' AND '$data2'");
        }
        if (!empty($this->params['named']['fecha_inicio[year]']) && !empty($this->params['named']['fecha_fin[year]'])) {
            $data1 = $this->params['named']['fecha_inicio[year]'] . '-' . $this->params['named']['fecha_inicio[month]'] . '-' . $this->params['named']['fecha_inicio[day]'];
            $data2 = $this->params['named']['fecha_fin[year]'] . '-' . $this->params['named']['fecha_fin[month]'] . '-' . $this->params['named']['fecha_fin[day]'];
            $conditions_partestalleres[] = array("Partestallere.fecha BETWEEN '$data1' AND '$data2'");
        }


        if (!empty($this->params['url']['cliente_id'])) {
            $conditions_partestalleres [] = array('1' => '1 AND Partestallere.tarea_id IN (SELECT Tarea.id FROM tareas Tarea WHERE Tarea.ordene_id IN (SELECT Ordene.id FROM ordenes Ordene WHERE Ordene.cliente_id = ' . $this->params['url']['cliente_id'] . '))');
        }
        if (!empty($this->params['named']['cliente_id'])) {
            $conditions_partestalleres [] = array('1' => '1 AND Partestallere.tarea_id IN (SELECT Tarea.id FROM tareas Tarea WHERE Tarea.ordene_id IN (SELECT Ordene.id FROM ordenes Ordene WHERE Ordene.cliente_id = ' . $this->params['named']['cliente_id'] . '))');
        }

        $paginate_results_per_page = 20;
        if (!empty($this->params['url']['resultados_por_pagina'])) {
            $paginate_results_per_page = intval($this->params['url']['resultados_por_pagina']);
        }
        if (!empty($this->params['named']['resultados_por_pagina'])) {
            $paginate_results_per_page = intval($this->params['named']['resultados_por_pagina']);
        }

        $this->paginate = array('limit' => $paginate_results_per_page, 'contain' => array('Mecanico', 'Tarea' => 'Ordene'), 'conditions' => $conditions_partestalleres, 'url' => $this->params['pass'], 'order' => 'fecha DESC');
        $this->set('partestalleres', $this->paginate());
    }

    function view($id = null) {
        if (!$id) {
            $this->flashWarnings(__('Parte de Taller NO Válido', true));
            $this->redirect(array('action' => 'index'));
        }

        $this->Partestallere->recursive = 2;
        $partestallere = $this->Partestallere->read(null, $id);
        $this->set('partestallere', $partestallere);

        $tarea_id = $partestallere['Tarea']['id'];
        $this->set('tarea', $this->Partestallere->Tarea->read(null, $tarea_id));
    }

    function add($tarea_id = null) {
        if (!empty($this->data)) {
            if (!empty($this->data['Partestallere']['fecha']))
                $this->data['Partestallere']['fecha'] = date("Y-m-d H:i:s", strtotime($this->data['Partestallere']['fecha']));
            $this->Partestallere->create();
            if ($this->Partestallere->save($this->data)) {
                $id = $this->Partestallere->id;
                /* Guarda fichero */
                if ($this->FileUpload->finalFile != null) {
                    $this->Partestallere->saveField('parteescaneado', $this->FileUpload->finalFile);
                }
                /* FIn Guardar Fichero */
                $this->Session->write('Visualizar.tarea_id', @$this->data['Partestallere']['tarea_id']);
                $this->Session->setFlash(__('El nuevo Parte de Taller ha sido creado correctamente', true));
                $this->redirect($this->referer());
            } else {
                die(pr($this->Partestallere->invalidFields()));
                $this->Session->write('Visualizar.tarea_id', @$this->data['Partestallere']['tarea_id']);
                $this->flashWarnings(__('El Parte de Taller NO ha podido ser creado', true));
                $this->redirect($this->referer());
            }
        }
        $tarea = $this->Partestallere->Tarea->find('first', array('contain' => array('Ordene' => array('Centrostrabajo')), 'conditions' => array('Tarea.id' => $tarea_id)));
        $mecanicos = $this->Partestallere->Mecanico->find('list', array('conditions' => array('Mecanico.activo' => 1)));
        $this->Session->write('Visualizar.tarea_id', $tarea_id);
        $this->set(compact('mecanicos', 'tarea_id', 'tarea'));
    }

    function edit($id = null) {

        if (!$id && empty($this->data)) {
            $this->flashWarnings(__('Parte de Taller Inválido', true));
            $this->redirect($this->referer());
        }
        if (!empty($this->data)) {
            if (!empty($this->data['Partestallere']['fecha']))
                $this->data['Partestallere']['fecha'] = date("Y-m-d H:i:s", strtotime($this->data['Partestallere']['fecha']));
            if ($this->Partestallere->save($this->data)) {
                $id = $this->Partestallere->id;
                $upload = $this->Partestallere->findById($id);
                if (!empty($this->data['Partestallere']['remove_file'])) {
                    $this->FileUpload->RemoveFile($upload['Partestallere']['parteescaneado']);
                    $this->Partestallere->saveField('parteescaneado', null);
                }
                if ($this->FileUpload->finalFile != null) {
                    $this->FileUpload->RemoveFile($upload['Partestallere']['parteescaneado']);
                    $this->Partestallere->saveField('parteescaneado', $this->FileUpload->finalFile);
                }
                $this->Session->write('Visualizar.tarea_id', $this->data['Partestallere']['tarea_id']);
                $this->Session->setFlash(__('El parte de taller ha sido guardado correctamente', true));
                $this->redirect($this->referer());
            } else {
                $this->Session->write('Visualizar.tarea_id', @$this->data['Partestallere']['tarea_id']);
                $this->Session->setFlash(__('El parte de taller No podido ser guardado', true));
                $this->redirect($this->referer());
            }
        } else {
            $this->data = $this->Partestallere->read(null, $id);
        }

        $mecanicos = $this->Partestallere->Mecanico->find('list');
        $this->set(compact('mecanicos'));
    }

    function delete($id = null) {
        if (!$id) {
            $this->flashWarnings(__('Id Inválida para el Parte de Taller', true));
            $this->redirect($this->referer());
        }
        $id = $this->Partestallere->id;
        $upload = $this->Partestallere->findById($id);
        $this->FileUpload->RemoveFile($upload['Partestallere']['parteescaneado']);
        if ($this->Partestallere->delete($id)) {
            $this->Session->setFlash(__('Parte de Taller  Borrado Correctamente', true));
            $this->redirect($this->referer());
        }

        $this->flashWarnings(__('El Paarte de Taller NO pudo ser Borrado', true));
        $this->redirect($this->referer());
    }

}

?>