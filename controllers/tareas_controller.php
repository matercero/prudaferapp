<?php

class TareasController extends AppController {

    var $name = 'Tareas';
    var $helpers = array('Javascript', 'Time', 'Number');

    function index() {
        $conditions = array();
        
        
        $paginate_results_per_page = 20;
        if (!empty($this->params['url']['resultados_por_pagina']))
            $paginate_results_per_page = intval($this->params['url']['resultados_por_pagina']);
        if (!empty($this->params['named']['resultados_por_pagina']))
            $paginate_results_per_page = intval($this->params['named']['resultados_por_pagina']);

        $this->paginate = array('limit' => $paginate_results_per_page, 'conditions' => $conditions, 'url' => $this->params['pass']);
        $this->Tarea->recursive = 0;

        $this->set('tareas', $this->paginate());       
    }

    function view($id = null) {
        $this->Tarea->recursive = 2;
        if (!$id) {
            $this->flashWarnings(__('Tarea Inválida', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->set('tarea', $this->Tarea->read(null, $id));
    }

    function add($ordene_id = null) {
        if (!empty($this->data)) {
            $stock_message = $this->comprobarExistencias();
            $this->Tarea->create();
            if ($this->Tarea->save($this->data)) {
                $id = $this->Tarea->id;

                if (!empty($_POST["ordene_id"]))
                    $this->Tarea->saveField('ordene_id', $_POST["ordene_id"]);

                $this->Session->setFlash(__('La nueva tarea de taller ha sido creada correctamente' . $stock_message, true));
                $this->redirect($this->referer());
            } else {
                $this->flashWarnings(__('La tarea de taller no ha podido ser creada correctamente. Vuelva a intentarlo' . $stock_message, true));
                $this->redirect($this->referer());
            }
        }
        $ordene = $this->Tarea->Ordene->read(null, $ordene_id);

        $this->set('ordene', $ordene);

        if ($ordene_id != null && $ordene_id >= 0) {
            $this->loadModel('Ordene');
            $ordene = $this->Ordene->read(null, $ordene_id);

            $this->set('ordene', $ordene);
        }
        $numero = $this->Tarea->dime_siguiente_numero($ordene_id);
        $this->set(compact('avisostalleres', 'estadosordenes', 'numero'));
    }

    function edit($id = null) {
        $this->Tarea->recursive = 2;
        if (!$id && empty($this->data)) {
            $this->flashWarnings(__('Tarea inválida', true));
            $this->redirect($this->referer());
        }
        if (!empty($this->data)) {
            if ($this->Tarea->save($this->data)) {
                $this->Session->setFlash(__('La Tarea ha sido guardada', true));
                $this->redirect($this->referer());
            } else {
                $this->flashWarnings(__('La Tarea no ha podido ser guardada. Intentalo de nuevo.', true));
                $this->redirect($this->referer());
            }
        }
        if (empty($this->data)) {
            if (!$this->data = $this->Tarea->read(null, $id)) {
                $this->flashWarnings(__('Tarea inválida', true));
                $this->redirect($this->referer());
            };
        }
    }

    function delete($id = null) {
        if (!$id) {
            $this->flashWarnings(__('Id inválida para la Tarea', true));
            $this->redirect($this->referer());
        }
        if ($this->Tarea->delete($id)) {
            $this->Session->setFlash(__('Tarea borrada', true));
            $this->redirect($this->referer());
        }
        $this->flashWarnings(__('La Tarea no puedo ser borrada' . pr($this->Tarea->invalidFields()), true));
        $this->redirect($this->referer());
    }

    function pdf() {
        Configure::write('debug', 0);
        $this->layout = 'pdf';
        if (empty($this->data['Tarea']['id'])) {
            $this->flashWarnings(__('Tarea Inválida', true));
            $this->redirect($this->referer());
        }
        $this->set('tarea', $this->Tarea->find('first', array('contain' => array('Ordene' => array('Cliente', 'Centrostrabajo', 'Maquina')), 'conditions' => array('Tarea.id' => $this->data['Tarea']['id']))));
        if (!empty($this->data['ArticulosTarea']['ids']))
            $this->set('articulos_tareas', $this->Tarea->ArticulosTarea->find('all', array('contain' => 'Articulo', 'conditions' => array('ArticulosTarea.id' => $this->data['ArticulosTarea']['ids']))));
        $this->render();
    }
    
    function pdfaliente() {
        Configure::write('debug', 0);
        $this->layout = 'pdf';
        if (empty($this->data['Tarea']['id'])) {
            $this->flashWarnings(__('Tarea Inválida', true));
            $this->redirect($this->referer());
        }
        $this->set('tarea', $this->Tarea->find('first', array('contain' => array('Ordene' => array('Cliente', 'Centrostrabajo', 'Maquina')), 'conditions' => array('Tarea.id' => $this->data['Tarea']['id']))));
        if (!empty($this->data['ArticulosTarea']['ids']))
            $this->set('articulos_tareas', $this->Tarea->ArticulosTarea->find('all', array('contain' => 'Articulo', 'conditions' => array('ArticulosTarea.id' => $this->data['ArticulosTarea']['ids']))));
        $this->render();
    }
    function pdf_informe() {
        Configure::write('debug', 0);
        $this->layout = 'pdf'; //this will use the pdf.ctp layout
        if (isset($_SESSION["last_search"])) {
            $this->set('Tarea', $this->Tarea->find('all', $_SESSION["last_search"]));
        } else {
            $this->set('Tarea', $this->Tarea->find('all', array('limit' => 20)));
        }
        unset($_SESSION["last_search"]);
        $this->render();
    }

    /**
     * Comprueba las existencias y devuelve un String con los mensages de aviso.
     * @param array $errors 
     */
    private function comprobarExistencias() {
        /* Comprobacion de Stock */
        $warnings = "";
        foreach ($this->data['ArticulosTarea'] as $articulo_tarea) {
            $articulo = $this->Tarea->ArticulosTarea->Articulo->find('first', array('conditions' => array('Articulo.id' => $articulo_tarea['articulo_id'])));
            $existencias_al_final = intval($articulo['Articulo']['existencias']) - intval($articulo_tarea['cantidad']);
            if ($existencias_al_final < 0) {
                $warnings .= '<br/> No hay existencias suficientes del articulo ' . $articulo['Articulo']['ref'] . ' ---- ' . $articulo['Articulo']['nombre'];
            }
        }
        /* Fin de comprobación de Stock */
        return $warnings;
    }

    function listadopartes() {
        $conditions_partes = array();
        $conditions_partestalleres = array();
        $conditions_partestalleres_mecanico = array();
        $conditions_partes_mecanico = array();
        $es_un_dia = false;
        if (!empty($this->params['url']['numero'])) {
            $conditions_partes [] = array('1' => '1 AND Parte.tarea_id IN (SELECT Tarea.id FROM tareas Tarea WHERE Tarea.ordene_id IN (SELECT Ordene.id FROM ordenes Ordene WHERE Ordene.numero = ' . $this->params['url']['numero'] . '))');
            $conditions_partes_mecanico [] = array('1' => '1 AND Parte.tarea_id IN (SELECT Tarea.id FROM tareas Tarea WHERE Tarea.ordene_id IN (SELECT Ordene.id FROM ordenes Ordene WHERE Ordene.numero = ' . $this->params['url']['numero'] . '))');
            $conditions_partestalleres [] = array('1' => '1 AND Partestallere.tarea_id IN (SELECT Tarea.id FROM tareas Tarea WHERE Tarea.ordene_id IN (SELECT Ordene.id FROM ordenes Ordene WHERE Ordene.numero = ' . $this->params['url']['numero'] . '))');
            $conditions_partestalleres_mecanico [] = array('1' => '1 AND Partestallere.tarea_id IN (SELECT Tarea.id FROM tareas Tarea WHERE Tarea.ordene_id IN (SELECT Ordene.id FROM ordenes Ordene WHERE Ordene.numero = ' . $this->params['url']['numero'] . '))');
        }
        if (!empty($this->params['named']['numero'])) {
            $conditions_partes_mecanico[] = array('1' => '1 AND Parte.tarea_id IN (SELECT Tarea.id FROM tareas Tarea WHERE Tarea.ordene_id IN (SELECT Ordene.id FROM ordenes Ordene WHERE Ordene.numero = ' . $this->params['named']['numero'] . '))');
            $conditions_partes [] = array('1' => '1 AND Parte.tarea_id IN (SELECT Tarea.id FROM tareas Tarea WHERE Tarea.ordene_id IN (SELECT Ordene.id FROM ordenes Ordene WHERE Ordene.numero = ' . $this->params['named']['numero'] . '))');
            $conditions_partestalleres [] = array('1' => '1 AND Partestallere.tarea_id IN (SELECT Tarea.id FROM tareas Tarea WHERE Tarea.ordene_id IN (SELECT Ordene.id FROM ordenes Ordene WHERE Ordene.numero = ' . $this->params['named']['numero'] . '))');
            $conditions_partestalleres_mecanico [] = array('1' => '1 AND Partestallere.tarea_id IN (SELECT Tarea.id FROM tareas Tarea WHERE Tarea.ordene_id IN (SELECT Ordene.id FROM ordenes Ordene WHERE Ordene.numero = ' . $this->params['named']['numero'] . '))');
        }

        if (!empty($this->params['url']['mecanico_id'])) {
            $conditions_partes [] = array('Parte.mecanico_id' => $this->params['url']['mecanico_id']);
            $conditions_partestalleres [] = array('Partestallere.mecanico_id' => $this->params['url']['mecanico_id']);
            $mecanicos = $this->params['url']['mecanico_id'];
        } else {
            $conditions_partes [] = array('1' => '1 AND Parte.mecanico_id IN (SELECT Mecanico.id FROM mecanicos Mecanico WHERE Mecanico.activo = 1)');
            $conditions_partestalleres [] = array('1' => '1 AND Partestallere.mecanico_id IN (SELECT Mecanico.id FROM mecanicos Mecanico WHERE Mecanico.activo = 1)');
        }
        if (!empty($this->params['named']['mecanico_id'])) {
            $conditions_partes [] = array('Parte.mecanico_id' => $this->params['named']['mecanico_id']);
            $conditions_partestalleres [] = array('Partestallere.mecanico_id' => $this->params['named']['mecanico_id']);
            $mecanicos = $this->params['named']['mecanico_id'];
        } else {
            $conditions_partes [] = array('1' => '1 AND Parte.mecanico_id IN (SELECT Mecanico.id FROM mecanicos Mecanico WHERE Mecanico.activo = 1)');
            $conditions_partestalleres [] = array('1' => '1 AND Partestallere.mecanico_id IN (SELECT Mecanico.id FROM mecanicos Mecanico WHERE Mecanico.activo = 1)');
        }


        if (!empty($this->params['url']['fecha_inicio']) && !empty($this->params['url']['fecha_fin'])) {
            $data1 = implode('-', array_reverse($this->params['url']['fecha_inicio']));
            $data2 = implode('-', array_reverse($this->params['url']['fecha_fin']));
            $conditions_partes_mecanico[] = array("Parte.fecha BETWEEN '$data1' AND '$data2'");
            $conditions_partes[] = array("Parte.fecha BETWEEN '$data1' AND '$data2'");
            $conditions_partestalleres[] = array("Partestallere.fecha BETWEEN '$data1' AND '$data2'");
            $conditions_partestalleres_mecanico[] = array("Partestallere.fecha BETWEEN '$data1' AND '$data2'");
            if($data1 == $data2)
                $es_un_dia = true;
        }
        if (!empty($this->params['named']['fecha_inicio[year]']) && !empty($this->params['named']['fecha_fin[year]'])) {
            $data1 = $this->params['named']['fecha_inicio[year]'] . '-' . $this->params['named']['fecha_inicio[month]'] . '-' . $this->params['named']['fecha_inicio[day]'];
            $data2 = $this->params['named']['fecha_fin[year]'] . '-' . $this->params['named']['fecha_fin[month]'] . '-' . $this->params['named']['fecha_fin[day]'];
            $conditions_partes_mecanico[] = array("Parte.fecha BETWEEN '$data1' AND '$data2'");
            $conditions_partes[] = array("Parte.fecha BETWEEN '$data1' AND '$data2'");
            $conditions_partestalleres[] = array("Partestallere.fecha BETWEEN '$data1' AND '$data2'");
            $conditions_partestalleres_mecanico[] = array("Partestallere.fecha BETWEEN '$data1' AND '$data2'");
            if($data1 == $data2)
                $es_un_dia = true;
        }

        if (!empty($this->params['url']['cliente_id'])) {
            $conditions_partes_mecanico [] = array('1' => '1 AND Parte.tarea_id IN (SELECT Tarea.id FROM tareas Tarea WHERE Tarea.ordene_id IN (SELECT Ordene.id FROM ordenes Ordene WHERE Ordene.cliente_id = ' . $this->params['url']['cliente_id'] . '))');
            $conditions_partes [] = array('1' => '1 AND Parte.tarea_id IN (SELECT Tarea.id FROM tareas Tarea WHERE Tarea.ordene_id IN (SELECT Ordene.id FROM ordenes Ordene WHERE Ordene.cliente_id = ' . $this->params['url']['cliente_id'] . '))');
            $conditions_partestalleres [] = array('1' => '1 AND Partestallere.tarea_id IN (SELECT Tarea.id FROM tareas Tarea WHERE Tarea.ordene_id IN (SELECT Ordene.id FROM ordenes Ordene WHERE Ordene.cliente_id = ' . $this->params['url']['cliente_id'] . '))');
            $conditions_partestalleres_mecanico [] = array('1' => '1 AND Partestallere.tarea_id IN (SELECT Tarea.id FROM tareas Tarea WHERE Tarea.ordene_id IN (SELECT Ordene.id FROM ordenes Ordene WHERE Ordene.cliente_id = ' . $this->params['url']['cliente_id'] . '))');
        }
        if (!empty($this->params['named']['cliente_id'])) {
            $conditions_partes_mecanico [] = array('1' => '1 AND Parte.tarea_id IN (SELECT Tarea.id FROM tareas Tarea WHERE Tarea.ordene_id IN (SELECT Ordene.id FROM ordenes Ordene WHERE Ordene.cliente_id = ' . $this->params['named']['cliente_id'] . '))');
            $conditions_partes [] = array('1' => '1 AND Parte.tarea_id IN (SELECT Tarea.id FROM tareas Tarea WHERE Tarea.ordene_id IN (SELECT Ordene.id FROM ordenes Ordene WHERE Ordene.cliente_id = ' . $this->params['named']['cliente_id'] . '))');
            $conditions_partestalleres [] = array('1' => '1 AND Partestallere.tarea_id IN (SELECT Tarea.id FROM tareas Tarea WHERE Tarea.ordene_id IN (SELECT Ordene.id FROM ordenes Ordene WHERE Ordene.cliente_id = ' . $this->params['named']['cliente_id'] . '))');
            $conditions_partestalleres_mecanico [] = array('1' => '1 AND Partestallere.tarea_id IN (SELECT Tarea.id FROM tareas Tarea WHERE Tarea.ordene_id IN (SELECT Ordene.id FROM ordenes Ordene WHERE Ordene.cliente_id = ' . $this->params['named']['cliente_id'] . '))');
        }

        if (!empty($this->params['url']['resultados_por_pagina'])) {
            $paginate_results_per_page = intval($this->params['url']['resultados_por_pagina']);
        }
        if (!empty($this->params['named']['resultados_por_pagina'])) {
            $paginate_results_per_page = intval($this->params['named']['resultados_por_pagina']);
        }

        $partescentros_group = $this->Tarea->Parte->find(
                'all', array(
            'fields' => array(
                'mecanico_id',
                'Mecanico.nombre',
                'SUM(Parte.horasdesplazamientoreales_ida + Parte.horasdesplazamientoreales_vuelta) as `total_horasdesplazamiento_real`',
                'SUM(Parte.horasdesplazamientoimputables_ida + Parte.horasdesplazamientoimputables_vuelta) as `total_horasdesplazamiento_imputables`',
                'SUM(Parte.kilometrajereal_ida + Parte.kilometrajereal_vuelta) as `total_kilometrajereal`',
                'SUM(Parte.kilometrajeimputable_ida + Parte.kilometrajeimputable_vuelta) as `total_kilometrajeimputable`',
                'SUM(Parte.dietasreales) as `total_dietasreales`',
                'SUM(Parte.dietasimputables) as `total_dietasimputables`',
                'SUM(Parte.horasreales) as `total_horascentro_reales`',
                'SUM(Parte.horasimputables) as `total_horascentro_imputables`',
            ),
            'conditions' => $conditions_partes,
            'contain' => 'Mecanico',
            'group' => 'mecanico_id'
                )
        );
        $partestalleres_group = $this->Tarea->Partestallere->find(
                'all', array(
            'fields' => array(
                'mecanico_id',
                'Mecanico.nombre',
                'SUM(Partestallere.horasreales) as `total_horastaller_reales`',
                'SUM(Partestallere.horasimputables) as `total_horastaller_imputables`',
            ),
            'conditions' => $conditions_partestalleres,
            'contain' => 'Mecanico',
            'group' => 'mecanico_id'
                )
        );
        $partestotales_group = array();
        foreach ($partescentros_group as $partescentro_mecanico) {
            if (!empty($partescentro_mecanico['Mecanico']['id'])) {
                $partestotales_group[$partescentro_mecanico['Mecanico']['id']]['nombre'] = $partescentro_mecanico['Mecanico']['nombre'];
                $partestotales_group[$partescentro_mecanico['Mecanico']['id']]['total_horasdesplazamiento_real'] = $partescentro_mecanico[0]['total_horasdesplazamiento_real'];
                $partestotales_group[$partescentro_mecanico['Mecanico']['id']]['total_horasdesplazamiento_imputables'] = $partescentro_mecanico[0]['total_horasdesplazamiento_imputables'];
                $partestotales_group[$partescentro_mecanico['Mecanico']['id']]['total_kilometrajereal'] = $partescentro_mecanico[0]['total_kilometrajereal'];
                $partestotales_group[$partescentro_mecanico['Mecanico']['id']]['total_kilometrajeimputable'] = $partescentro_mecanico[0]['total_kilometrajeimputable'];
                $partestotales_group[$partescentro_mecanico['Mecanico']['id']]['total_dietasreales'] = $partescentro_mecanico[0]['total_dietasreales'];
                $partestotales_group[$partescentro_mecanico['Mecanico']['id']]['total_dietasimputables'] = $partescentro_mecanico[0]['total_dietasimputables'];
                $partestotales_group[$partescentro_mecanico['Mecanico']['id']]['total_horascentro_reales'] = $partescentro_mecanico[0]['total_horascentro_reales'];
                $partestotales_group[$partescentro_mecanico['Mecanico']['id']]['total_horascentro_imputables'] = $partescentro_mecanico[0]['total_horascentro_imputables'];
                $partestotales_group[$partescentro_mecanico['Mecanico']['id']]['total_horasreales'] = $partescentro_mecanico[0]['total_horascentro_reales'];
            }
        }    
        foreach ($partestalleres_group as $partestallere_mecanico) {
            if (!empty($partestallere_mecanico['Mecanico']['id'])) {
                $partestotales_group[$partestallere_mecanico['Mecanico']['id']]['total_horastaller_reales'] = $partestallere_mecanico[0]['total_horastaller_reales'];
                $partestotales_group[$partestallere_mecanico['Mecanico']['id']]['total_horastaller_imputables'] = $partestallere_mecanico[0]['total_horastaller_imputables'];

                if (!isset($partestotales_group[$partestallere_mecanico['Mecanico']['id']]['nombre']))
                    $partestotales_group[$partestallere_mecanico['Mecanico']['id']]['nombre'] = $partestallere_mecanico['Mecanico']['nombre'];

                if (isset($partestotales_group[$partestallere_mecanico['Mecanico']['id']]['total_horasreales']))
                    $partestotales_group[$partestallere_mecanico['Mecanico']['id']]['total_horasreales'] += $partestallere_mecanico[0]['total_horastaller_reales'];
                else
                    $partestotales_group[$partestallere_mecanico['Mecanico']['id']]['total_horasreales'] = $partestallere_mecanico[0]['total_horastaller_reales'];
            }
        }

        if (!isset($mecanicos) || empty($mecanicos)) {
            $mecanicos = $this->Tarea->Parte->Mecanico->find('list', array('conditions' => array('Mecanico.activo' => 1)));
            foreach ($mecanicos as $key => $mecanico) {
                $conditions_partes_mecanico[] = array('Parte.mecanico_id' => $key);
                $fechas_partescentro = $this->Tarea->Parte->find('all', array('contain' => array(), 'fields' => 'Parte.fecha', 'conditions' => $conditions_partes_mecanico, 'group' => 'Parte.fecha'));
                $fechas_partestaller = $this->Tarea->Partestallere->find('all', array('contain' => array(), 'fields' => 'Partestallere.fecha', 'conditions' => $conditions_partestalleres_mecanico, 'group' => 'Partestallere.fecha'));
                $fechas = array();
                foreach ($fechas_partescentro as $fecha) {
                    $fechas[$fecha['Parte']['fecha']] = 0;
                }
                foreach ($fechas_partestaller as $fecha) {
                    $fechas[$fecha['Partestallere']['fecha']] = 0;
                }
                $dias_trabajados = count($fechas);
                $horas_laborales = $dias_trabajados * 8;
                if (!isset($partestotales_group[$key]['total_horasdesplazamiento_real']))
                    $partestotales_group[$key]['total_horasdesplazamiento_real'] = 0;
                if (!isset($partestotales_group[$key]['total_horasreales']))
                    $partestotales_group[$key]['total_horasreales'] = 0;
                $partestotales_group[$key]['total_horas_extra'] = $partestotales_group[$key]['total_horasdesplazamiento_real'] + $partestotales_group[$key]['total_horasreales'] - $horas_laborales;
            }
        } else {
            foreach ($mecanicos as $key => $mecanico) {
                $conditions_partes_mecanico[] = array('Parte.mecanico_id' => $mecanico);
                $fechas_partescentro = $this->Tarea->Parte->find('all', array('contain' => array(), 'fields' => 'Parte.fecha', 'conditions' => $conditions_partes_mecanico, 'group' => 'Parte.fecha'));
                $fechas_partestaller = $this->Tarea->Partestallere->find('all', array('contain' => array(), 'fields' => 'Partestallere.fecha', 'conditions' => $conditions_partestalleres_mecanico, 'group' => 'Partestallere.fecha'));
                $fechas = array();
                foreach ($fechas_partescentro as $fecha) {
                    $fechas[$fecha['Parte']['fecha']] = 0;
                }
                foreach ($fechas_partestaller as $fecha) {
                    $fechas[$fecha['Partestallere']['fecha']] = 0;
                }
                $dias_trabajados = count($fechas);
                $horas_laborales = $dias_trabajados * 8;
                
                if (!isset($partestotales_group[$key]['total_horasdesplazamiento_real']))
                    $partestotales_group[$key]['total_horasdesplazamiento_real'] = 0;
                if (!isset($partestotales_group[$key]['total_horasreales']))
                    $partestotales_group[$key]['total_horasreales'] = 0;
                if(!isset($partestotales_group[$mecanico]))
                    $partestotales_group[$mecanico] = array();
                $partestotales_group[$mecanico]['total_horas_extra'] = @$partestotales_group[$mecanico]['total_horasdesplazamiento_real'] + @$partestotales_group[$mecanico]['total_horasreales'] - @$horas_laborales;
            }
        }
        $this->set('es_un_dia', $es_un_dia);
        $this->set('mecanicos', $this->Tarea->Parte->Mecanico->find('list', array('conditions' => array('Mecanico.activo' => 1))));
        $this->set(compact('partestalleres_group', 'partescentros_group', 'partestotales_group'));
    }

}

?>
