<?php

class PartesController extends AppController {

    var $name = 'Partes';
    var $components = array('RequestHandler', 'FileUpload', 'Session');
    var $helpers = array('Time');

    function beforeFilter() {
        parent::beforeFilter();
        if ($this->params['action'] == 'edit' || $this->params['action'] == 'add') {
            $this->FileUpload->fileModel = 'Parte';
            $this->FileUpload->uploadDir = 'files/parte';
            $this->FileUpload->fields = array('name' => 'file_name', 'type' => 'file_type', 'size' => 'file_size');
        }
    }

    function index() {
        $this->layout = 'ajax';
        $this->Parte->recursive = 0;
        $conditions_partes = array();

        if (!empty($this->params['url']['numero'])) {
            $conditions_partes [] = array('1' => '1 AND Parte.tarea_id IN (SELECT Tarea.id FROM tareas Tarea WHERE Tarea.ordene_id IN (SELECT Ordene.id FROM ordenes Ordene WHERE Ordene.numero = ' . $this->params['url']['numero'] . '))');
        }
        if (!empty($this->params['named']['numero'])) {
            $conditions_partes [] = array('1' => '1 AND Parte.tarea_id IN (SELECT Tarea.id FROM tareas Tarea WHERE Tarea.ordene_id IN (SELECT Ordene.id FROM ordenes Ordene WHERE Ordene.numero = ' . $this->params['named']['numero'] . '))');
        }

        if (!empty($this->params['url']['mecanico_id'])) {
            $conditions_partes [] = array('Parte.mecanico_id' => $this->params['url']['mecanico_id']);
        } else {
            $conditions_partes [] = array('1' => '1 AND Parte.mecanico_id IN (SELECT Mecanico.id FROM mecanicos Mecanico WHERE Mecanico.activo = 1)');
        }
        if (!empty($this->params['named']['mecanico_id'])) {
            $conditions_partes [] = array('Parte.mecanico_id' => $this->params['named']['mecanico_id']);
        } else {
            $conditions_partes [] = array('1' => '1 AND Parte.mecanico_id IN (SELECT Mecanico.id FROM mecanicos Mecanico WHERE Mecanico.activo = 1)');
        }


        if (!empty($this->params['url']['fecha_inicio']) && !empty($this->params['url']['fecha_fin'])) {
            $data1 = implode('-', array_reverse($this->params['url']['fecha_inicio']));
            $data2 = implode('-', array_reverse($this->params['url']['fecha_fin']));
            $conditions_partes[] = array("Parte.fecha BETWEEN '$data1' AND '$data2'");
        }
        if (!empty($this->params['named']['fecha_inicio[year]']) && !empty($this->params['named']['fecha_fin[year]'])) {
            $data1 = $this->params['named']['fecha_inicio[year]'] . '-' . $this->params['named']['fecha_inicio[month]'] . '-' . $this->params['named']['fecha_inicio[day]'];
            $data2 = $this->params['named']['fecha_fin[year]'] . '-' . $this->params['named']['fecha_fin[month]'] . '-' . $this->params['named']['fecha_fin[day]'];
            $conditions_partes[] = array("Parte.fecha BETWEEN '$data1' AND '$data2'");
        }


        if (!empty($this->params['url']['cliente_id'])) {
            $conditions_partes [] = array('1' => '1 AND Parte.tarea_id IN (SELECT Tarea.id FROM tareas Tarea WHERE Tarea.ordene_id IN (SELECT Ordene.id FROM ordenes Ordene WHERE Ordene.cliente_id = ' . $this->params['url']['cliente_id'] . '))');
        }
        if (!empty($this->params['named']['cliente_id'])) {
            $conditions_partes [] = array('1' => '1 AND Parte.tarea_id IN (SELECT Tarea.id FROM tareas Tarea WHERE Tarea.ordene_id IN (SELECT Ordene.id FROM ordenes Ordene WHERE Ordene.cliente_id = ' . $this->params['named']['cliente_id'] . '))');
        }

        $paginate_results_per_page = 20;
        if (!empty($this->params['url']['resultados_por_pagina'])) {
            $paginate_results_per_page = intval($this->params['url']['resultados_por_pagina']);
        }
        if (!empty($this->params['named']['resultados_por_pagina'])) {
            $paginate_results_per_page = intval($this->params['named']['resultados_por_pagina']);
        }

        $this->paginate = array('limit' => $paginate_results_per_page, 'contain' => array('Mecanico', 'Tarea' => 'Ordene'), 'conditions' => $conditions_partes, 'url' => $this->params['pass'], 'order' => 'fecha DESC');
        $this->set('partes', $this->paginate());
    }

    function view($id = null) {
        $this->Parte->recursive = 2;
        if (!$id) {
            $this->flashWarnings(__('Parte de Centro de Trabajo Inválido', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->set('parte', $this->Parte->read(null, $id));
    }

    function add($tarea_id = null) {
        if (!empty($this->data)) {
            if (!empty($this->data['Parte']['fecha']))
                $this->data['Parte']['fecha'] = date("Y-m-d H:i:s", strtotime($this->data['Parte']['fecha']));
            $this->Parte->create();
            if ($this->Parte->save($this->data)) {
                /* Guarda fichero */
                if ($this->FileUpload->finalFile != null) {
                    $this->Parte->saveField('parteescaneado', $this->FileUpload->finalFile);
                }
                /* Fin de Guardar Fichero */
                $this->Session->setFlash(__('El nuevo Parte en Centro de Trabajo ha sido añadido correctamente' . true));
                $this->Session->write('Visualizar.tarea_id', $tarea_id);
                $this->redirect($this->referer());
            } else {
                $this->Session->write('Visualizar.tarea_id', $tarea_id);
                $this->flashWarnings(__('El Parte en Centro de Trabajo No ha podido ser añadido. Vuelva a intentarlo' . true));
                $this->redirect($this->referer());
            }
        }
        $tarea = $this->Parte->Tarea->find('first', array('contain' => array('Ordene' => array('Centrostrabajo')), 'conditions' => array('Tarea.id' => $tarea_id)));
        $mecanicos = $this->Parte->Mecanico->find('list',array('conditions' => array('Mecanico.activo' => 1)));
        $this->set(compact('mecanicos', 'tarea_id', 'tarea'));
    }

    function edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->flashWarnings(__('Parte de Centro de Trabajo Inválido', true));
            $this->redirect($this->referer());
        }
        if (!empty($this->data)) {
            if (!empty($this->data['Parte']['fecha']))
                $this->data['Parte']['fecha'] = date("Y-m-d H:i:s", strtotime($this->data['Parte']['fecha']));
            if ($this->Parte->save($this->data)) {
                $id = $this->Parte->id;
                $upload = $this->Parte->findById($id);
                if (!empty($this->data['Parte']['remove_file'])) {
                    $this->FileUpload->RemoveFile($upload['Parte']['parteescaneado']);
                    $this->Parte->saveField('parteescaneado', null);
                }
                if ($this->FileUpload->finalFile != null) {
                    $this->FileUpload->RemoveFile($upload['Parte']['parteescaneado']);
                    $this->Parte->saveField('parteescaneado', $this->FileUpload->finalFile);
                }
                $this->Session->setFlash(__('El nuevo Parte de Centro de Trabajo ha sido creado correctamente', true));
                $this->Session->write('Visualizar.tarea_id', @$this->data['Parte']['tarea_id']);
                $this->redirect($this->referer());
            } else {
                $this->flashWarnings(__('El Parte de Centro de Trabajo No ha podido ser creado. Vuelva a intentarlo', true));
                $this->Session->write('Visualizar.tarea_id', @$this->data['Parte']['tarea_id']);
                $this->redirect($this->referer());
            }
        } else {
            $this->data = $this->Parte->read(null, $id);
        }
        $tarea = $this->Parte->Tarea->find('first', array('contain' => array('Ordene' => array('Centrostrabajo')), 'conditions' => array('Tarea.id' => $this->data['Parte']['tarea_id'])));
        $mecanicos = $this->Parte->Mecanico->find('list');
        $this->set(compact('mecanicos'));
    }

    function delete($id = null) {
        if (!$id) {
            $this->flashWarnings(__('Id No válida para el Parte de Centro de Trabajo', true));
            $this->redirect($this->referer());
        }
        if ($this->Parte->delete($id)) {
            $this->Session->setFlash(__('El Parte de Centro de Trabajo ha sido borrado', true));
            $this->redirect($this->referer());
        }
        $this->flashWarnings(__('El Parte de Centro de Trabajo No pudo ser borrado', true));
        $this->redirect($this->referer());
    }

    function pdf($id = null) {
        if ($id != null) {
            $this->Parte->recursive = 2;
            $this->layout = 'pdf';
            $parte = $this->Parte->read(null, $id);
            $this->set('parte', $parte);
            $this->render();
        }
    }

}

?>
