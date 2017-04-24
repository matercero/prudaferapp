<?php

class ArticulosController extends AppController {

    var $name = 'Articulos';
    var $components = array('FileUpload', 'Session');
    var $helpers = array('Html', 'Ajax', 'Javascript');

    function __construct($id = false, $table = null, $ds = null) {
        if (empty($this->alias))
            $this->alias = 'Articulo';
        parent::__construct($id, $table, $ds);
        $this->virtualFields['autocomplete'] = sprintf("CONCAT(" . $this->alias . ".ref, ' --- '," . $this->alias . ".nombre)");
    }

    function beforeFilter() {
        parent::beforeFilter();
        if ($this->params['action'] == 'edit' || $this->params['action'] == 'add') {
            $this->FileUpload->fileModel = 'Articulo';
            $this->FileUpload->uploadDir = 'files/articulo';
            $this->FileUpload->fields = array('name' => 'file_name', 'type' => 'file_type', 'size' => 'file_size');
        }
    }

    function index() {

        $contain = array('Familia', 'Almacene');
        $conditions = array();

        if (!empty($this->params['url']['ref']))
            $conditions [] = array('Articulo.ref LIKE' => '%' . $this->params['url']['ref'] . '%');
        if (!empty($this->params['named']['ref']))
            $conditions [] = array('Articulo.ref LIKE' => '%' . $this->params['named']['ref'] . '%');

        if (!empty($this->params['url']['nombre']))
            $conditions [] = array('Articulo.nombre LIKE' => '%' . $this->params['url']['nombre'] . '%');
        if (!empty($this->params['named']['nombre']))
            $conditions [] = array('Articulo.nombre LIKE' => '%' . $this->params['named']['nombre'] . '%');

        if (!empty($this->params['url']['codigobarras']))
            $conditions [] = array('Articulo.codigobarras LIKE' => '%' . $this->params['url']['codigobarras'] . '%');
        if (!empty($this->params['named']['codigobarras']))
            $conditions [] = array('Articulo.codigobarras LIKE' => '%' . $this->params['named']['codigobarras'] . '%');

        if (!empty($this->params['url']['proveedore_id']))
            $conditions [] = array('Articulo.proveedore_id' => $this->params['url']['proveedore_id']);
        if (!empty($this->params['named']['proveedore_id']))
            $conditions [] = array('Articulo.proveedore_id' => $this->params['named']['proveedore_id']);

        if (!empty($this->params['url']['almacene_id']))
            $conditions [] = array('Articulo.almacene_id' => $this->params['url']['almacene_id']);
        if (!empty($this->params['named']['almacene_id']))
            $conditions [] = array('Articulo.almacene_id' => $this->params['named']['almacene_id']);

        if (!empty($this->params['url']['familia_id']))
            $conditions [] = array('Articulo.familia_id' => $this->params['url']['familia_id']);
        if (!empty($this->params['named']['familia_id']))
            $conditions [] = array('Articulo.familia_id' => $this->params['named']['familia_id']);

        if (!empty($this->params['url']['localizacion_de']) && !empty($this->params['url']['localizacion_hasta']))
            $conditions [] = array('Articulo.localizacion BETWEEN ? AND ?' => array($this->params['url']['localizacion_de'], $this->params['url']['localizacion_hasta']));
        if (!empty($this->params['named']['localizacion_hasta']) && !empty($this->params['named']['localizacion_hasta']))
            $conditions [] = array('Articulo.localizacion BETWEEN ? AND ?' => array($this->params['named']['localizacion_de'], $this->params['named']['localizacion_hasta']));

        if (!empty($this->params['url']['descripcionLarga']))
            $conditions [] = array('Articulo.descripcionLarga LIKE' => '%' . $this->params['url']['descripcionLarga'] . '%');
        if (!empty($this->params['named']['descripcionLarga']))
            $conditions [] = array('Articulo.descripcionLarga LIKE' => '%' . $this->params['named']['descripcionLarga'] . '%');


        $paginate_results_per_page = 20;
        if (!empty($this->params['url']['resultados_por_pagina']))
            $paginate_results_per_page = intval($this->params['url']['resultados_por_pagina']);
        if (!empty($this->params['named']['resultados_por_pagina']))
            $paginate_results_per_page = intval($this->params['named']['resultados_por_pagina']);

        $this->paginate = array('limit' => $paginate_results_per_page, 'contain' => $contain, 'conditions' => $conditions, 'url' => $this->params['pass']);

        $articulos = $this->paginate('Articulo');
        $this->set('familias', $this->Articulo->Familia->find('list'));
        $this->set('almacenes', $this->Articulo->Almacene->find('list'));
        $this->set('articulos', $this->paginate());
    }

    function view($id = null) {
        if (!$id) {
            $this->flashWarnings(__('Artículo no válido', true));
            $this->redirect($this->referer());
        }
        $articulo = $this->Articulo->find('first', array('contain' => array('Almacene', 'Familia', 'Proveedore', 'Referido' => array('Articulo_referido' => array('Proveedore', 'Almacene'))), 'conditions' => array('Articulo.id' => $id)));
        $articulos_misma_ref = $this->Articulo->find('all', array('contain' => array('Almacene'), 'conditions' => array('Articulo.ref' => $articulo["Articulo"]["ref"])));
        $this->set(compact('articulo', 'articulos_misma_ref'));
    }

    function add() {
        if (!empty($this->data)) {
            $this->Articulo->create();
            $cantidad = $this->Articulo->find('count', array('conditions' => array('Articulo.ref' => $this->data['Articulo']['ref'], 'Articulo.almacene_id' => $this->data['Articulo']['almacene_id'])));
            if ($cantidad > 0) {
                $this->flashWarnings(__('No se ha guardado el Artículo: Ya existe un Artículo con la misma referencia en este almacén.', true));
            } else {
                if ($this->Articulo->save($this->data)) {
                    /* Guarda fichero */
                    if ($this->FileUpload->finalFile != null) {
                        $this->Articulo->saveField('articuloescaneado', $this->FileUpload->finalFile);
                    }
                    /* FIn Guardar Fichero */
                    $this->Session->setFlash(__('El artículo se ha guardado con éxito', true));
                    $this->redirect($this->referer());
                } else {
                    $this->flashWarnings(__('El artículo NO se ha guardado. Por favor, inténtelo de nuevo.', true));
                    $this->redirect($this->referer());
                }
            }
        }
        $familias = $this->Articulo->Familia->find('list');
        $this->set(compact('familias'));
        $almacenes = $this->Articulo->Almacene->find('list');
        $this->set(compact('almacenes'));
        $proveedores = $this->Articulo->Proveedore->find('list');
        $this->set(compact('proveedores'));
    }

    function edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->flashWarnings(__('Invalid articulo', true));
            $this->redirect($this->referer());
        }
        if (!empty($this->data)) {
            if ($this->Articulo->save($this->data)) {
                $id = $this->Articulo->id;
                $upload = $this->Articulo->findById($id);
                if (!empty($this->data['Articulo']['remove_file'])) {
                    $this->FileUpload->RemoveFile($upload['Articulo']['articuloescaneado']);
                    $this->Articulo->saveField('articuloescaneado', null);
                }
                if ($this->FileUpload->finalFile != null) {
                    $this->FileUpload->RemoveFile($upload['Articulo']['articuloescaneado']);
                    $this->Articulo->saveField('articuloescaneado', $this->FileUpload->finalFile);
                }
                $this->Session->setFlash(__('El articulo ha sido guardado con éxito', true));
                $this->redirect($this->referer());
            } else {
                $this->flashWarnings(__('El articulo NO se ha guardado. Por favor, inténtelo de nuevo.', true));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Articulo->read(null, $id);
        }
        $familias = $this->Articulo->Familia->find('list');
        $this->set(compact('familias'));
        $almacenes = $this->Articulo->Almacene->find('list');
        $this->set(compact('almacenes'));
        $proveedores = $this->Articulo->Proveedore->find('list');
        $this->set(compact('proveedores'));
    }

    function delete($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('ID no válida', true));
            $this->redirect($this->referer());
        }
        $id = $this->Articulo->id;
        $upload = $this->Articulo->findById($id);
        $this->FileUpload->RemoveFile($upload['Articulo']['articuloescaneado']);
        if ($this->Articulo->delete($id)) {
            $this->Session->setFlash(__('Artículo borrado', true));
            $this->redirect($this->referer());
        }
        $this->flashWarnings(__('El artículo NO ha podido ser eliminado.'
                        . 'Posiblemente porque este relacionado.', true));
        $this->redirect($this->referer());
    }

    function search() {
        $this->autoRender = false;
        $search = $this->data[$this->modelClass]['Buscar'];
        $search = explode(' ', $search);
        $cond = "";
        $i = 0;
        foreach ($this->{$this->modelClass}->_schema as $field => $value) {
//debug($field);
            if ($i > 0) {
                $cond = $cond . " OR ";
            }
            $n = 0;
            foreach ($search as $word) {
                if ($n > 0) {
                    $cond = $cond . " AND ";
                }
                $cond = $cond . " " . $this->modelClass . "." . $field . " LIKE '%" . $word . "%' ";
                $n++;
            }
            $i++;
        }
        $conditions = array('limit' => 500, 'conditions' => $cond);
        $this->paginate = $conditions;
        $_SESSION["last_search"] = $conditions;
        array_shift($_SESSION["last_search"]);
        $this->set(strtolower($this->name), $this->paginate());
        $this->render('index');
    }

    function pdf() {
        Configure::write('debug', 0);
        $this->layout = 'pdf'; //this will use the pdf.ctp layout
        if (isset($_SESSION["last_search"])) {
            $this->set('articulos', $this->Articulo->find('all', $_SESSION["last_search"]));
        } else {
            $this->set('articulos', $this->Articulo->find('all', array('limit' => 200)));
        }
        unset($_SESSION["last_search"]);
        $this->render();
    }

    function auto_complete() {
        if (!empty($this->params['pass'][0])) {
            $articulos = $this->Articulo->find('all', array(
                'conditions' => array(
                    'Articulo.almacene_id' => $this->params['pass'][0],
                    'OR' => array(
                        'Articulo.nombre LIKE' => $this->params['url']['term'] . '%',
                        'Articulo.codigobarras LIKE' => $this->params['url']['term'] . '%',
                        'Articulo.ref LIKE' => $this->params['url']['term'] . '%'
                    ),
                ),
                'fields' => array('nombre', 'ref', 'id', 'precio_sin_iva', 'existencias'),
                'recursive' => -1,
            ));
        } else {
            $articulos = $this->Articulo->find('all', array(
                'conditions' => array(
                    'OR' => array(
                        'Articulo.nombre LIKE' => $this->params['url']['term'] . '%',
                        'Articulo.codigobarras LIKE' => $this->params['url']['term'] . '%',
                        'Articulo.ref LIKE' => $this->params['url']['term'] . '%'
                    ),
                ),
                'fields' => array('nombre', 'ref', 'id', 'precio_sin_iva', 'existencias'),
                'recursive' => -1,
            ));
        }
        $articulos_array = array();
        foreach ($articulos as $articulo) {
            $articulos_array[] = array("id" => $articulo["Articulo"]["id"], "value" => $articulo["Articulo"]["nombre"], "ref" => $articulo["Articulo"]["ref"], "precio_sin_iva" => $articulo["Articulo"]["precio_sin_iva"], "existencias" => $articulo["Articulo"]["existencias"]);
        }

        $this->set('articulos', $articulos_array);
        $this->layout = 'ajax';
    }

    function regularizar($id) {
        $this->layout = 'ajax';
        $nueva_existencias = $this->params['form']['nueva_existencia'];
        $this->Articulo->id = $id;
        if (!$this->Articulo->saveField('existencias', $nueva_existencias)) {
            die('No se puedo cambiar las existencias');
        }
        $this->set(compact('nueva_existencias'));
    }

    function json_infinite() {
        Configure::write('debug', 0);
        $this->layout = 'ajax';
        $articulos = $this->Articulo->find('all', array(
            'fields' => array('id', 'ref', 'nombre'),
            'contain' => '',
            'limit' => $this->params['url']['page_limit'],
            'page' => $this->params['url']['page'],
            'conditions' => array(
                'OR' => array('Articulo.nombre LIKE' => '%' . $this->params['url']['q'] . '%', 'Articulo.ref LIKE' => '%' . $this->params['url']['q'] . '%')
            ),
        ));
        $total = $this->Articulo->find('count', array(
            'conditions' => array(
                'OR' => array('Articulo.nombre LIKE' => '%' . $this->params['url']['q'] . '%', 'Articulo.ref LIKE' => '%' . $this->params['url']['q'] . '%')
            ),
        ));
        $articulos_array = array();
        foreach ($articulos as $articulo) {
            $articulos_array[] = array("id" => $articulo["Articulo"]["id"], "nombre" => $articulo["Articulo"]["nombre"], "ref" => $articulo["Articulo"]["ref"]);
        }
        $json['articulos'] = $articulos_array;
        $json['total'] = $total;
        $this->set('articulos', $json);
        $this->render('json');
    }

    function json_basico() {
        Configure::write('debug', 0);
        $this->layout = 'json';
        $articulos = $this->Articulo->find('all', array(
            'fields' => array('id', 'ref', 'nombre', 'Almacene.nombre'),
            'contain' => 'Almacene',
            'conditions' => array(
                'OR' => array('Articulo.nombre LIKE' => '%' . $this->params['url']['q'] . '%', 'Articulo.ref LIKE' => '%' . $this->params['url']['q'] . '%')
            ),
        ));
        $articulos_array = array();
        foreach ($articulos as $articulo) {
            $articulos_array[] = array("id" => $articulo["Articulo"]["id"], "nombre" => $articulo["Articulo"]["nombre"] . ' --- ' . $articulo["Almacene"]["nombre"], "ref" => $articulo["Articulo"]["ref"], 'almacene' => $articulo["Almacene"]["nombre"]);
        }
        $json['articulos'] = $articulos_array;
        $this->set('articulos', $json);
        $this->render('json');
    }

    function get_json($id) {
        Configure::write('debug', 0);
        $this->layout = 'ajax';
        $articulo = $this->Articulo->find('first', array(
            'fields' => array('id', 'ref', 'nombre'),
            'contain' => '',
            'conditions' => array(
                'Articulo.id ' => $id
            ),
        ));
        $this->set('articulos', $articulo['Articulo']);
        $this->render('json');
    }

    /**
     * Accion de importar un fichero .csv y carga en la tabla articulos
     */
    function import() {
        Configure::write('debug', 0);
//Upload File
        if (isset($_POST['submit'])) {
            if (is_uploaded_file($_FILES['filename']['tmp_name'])) {
                //echo "<h1>" . "El fichero " . $_FILES['filename']['name'] . " uploaded successfully." . "</h1>";
                $resultadoUpload = "El fichero " . $_FILES['filename']['name'] . " subido con éxito. <br />";
                /*  echo "<h2>Displaying contents:</h2>";
                  readfile($_FILES['filename']['tmp_name']); */
                $id_almacen = $_POST['almacen'];
            } else {
                $this->set('resultado', "<span style='color:blue;font-weight:bold'>No ha seleccionado fichero .CSV</span>."
                        . "<br /><br />Pulse 'Volver' y seleccione un fichero. ");
                return false;
            }

//Import uploaded file to Database en modo Lectura
            $resultado = "<ol>";
            $cntRegistros = 0;
            $cntInsert = 0;
            $cntUpdate = 0;
            $cntNoProcede = 0;
            $flag = true;
            $handle = fopen($_FILES['filename']['tmp_name'], "r");
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                if ($flag) {
                    $flag = false;
                    continue;
                }
                $cntRegistros ++;

                $consulta = sprintf("SELECT id, count(*) as total FROM articulos 
                                      WHERE UPPER(ref) LIKE UPPER('%s') 
                                      AND almacene_id = '%s'", '%' . mysql_real_escape_string($data[0]) . '%', $id_almacen);

// Ejecutar la consulta
                $resultadoSQL = mysql_query($consulta);
                if (!$resultadoSQL) {
                    $mensaje = sprintf('Consulta no válida: %s . Consulta completa: %s ', mysql_error(), $consulta);
                    die($mensaje);
                }

                // $resultado .= $consulta . '<br />';
                $dataSQL = mysql_fetch_assoc($resultadoSQL);
                //echo "Registros con ref " . $data[0] . " coincide = " . $dataSQL['total'] . '<br />';
                // Depende del resultado obtenido 
                switch ($dataSQL['total']) {
                    // Caso de referencia NO existente
                    case 0:
                        $insertOrUpdate = "INSERT INTO articulos("
                                . "REF, NOMBRE, ULTIMOPRECIOCOMPRA,PRECIO_SIN_IVA,"
                                . "FAMILIA_ID,PROVEEDORE_ID,PESO,"
                                . "LARGO,ANCHO,ALTO,ES_IMPORTADO) "
                                . "values(TRIM('$data[0]'),TRIM('$data[1]'),TRIM('$data[2]'),"
                                . "TRIM('$data[3]'),TRIM('$data[4]'),"
                                . "TRIM('$data[5]'),TRIM('$data[6]'),"
                                . "TRIM('$data[7]'),TRIM('$data[8]'),"
                                . "TRIM('$data[9]'), 1 )";
                        $resultado .= sprintf("<li>Referencia = %s,  "
                                . "<span style='color:green;font-weight:bold'>INSERTADA</span>", $data[0]);
                        $cntInsert ++;
                        break;
                    // Caso de Referencia existente. Se actualiza
                    case 1:
                        $insertOrUpdate = "UPDATE articulos  "
                                . " SET "
                                . "PRECIO_SIN_IVA = TRIM('" . $data[3] . "'),"
                                . "PESO = '" . $data[7] . "',"
                                . "LARGO = '" . $data[8] . "',"
                                . "ANCHO = '" . $data[9] . "',"
                                . "ALTO = '" . $data[10] . "'"
                                . "WHERE id = '" . $dataSQL['id'] . "'";
                        $resultado .= sprintf("<li>Referencia = %s,  "
                                . "<span style='color:blue;font-weight:bold'>ACTUALIZADA</span>", $data[0]);
                        $cntUpdate ++;
                        break;
                    default :
                        $resultado .= sprintf("<li>Referencia = %s,  "
                                . "<span style='color:red;font-weight:bold'>INCIDENCIA</span>. Comprobar: %s", $data[0], $consulta);
                        $cntNoProcede ++;
                }
                if (strlen($insertOrUpdate) > 0) {
                    $resultado2SQL = mysql_query($insertOrUpdate);
                    if (!$resultado2SQL) {
                        $mensaje = sprintf('Consulta no válida: %s . Consulta completa: %s ', mysql_error(), $consulta);
                        die($mensaje);
                    }
                }
                $insertOrUpdate = "";
            } // While
            fclose($handle);


            if (!$flag) {
                $resultadoResumen = "<br /><b>Resumen de la importación:</b><br />."
                        . "Total de registros analizados : " . $cntRegistros . '<br />'
                        . "     Artículos creados en el presupuesto : " . $cntInsert . '<br />'
                        . "     Artículos creados en el presupuesto : " . $cntUpdate . '<br />'
                        . "     Registros NO procesados por incidencias : " . $cntNoProcede;

                $this->set('resultado', (isset($resultado) ? $resultado : "No hay. " ) . "</ol>");
                $this->Session->setFlash(__('Importación finalizada con éxito .', true));
            }
            $this->set('resultadoResumen', isset($resultadoResumen) ? $resultadoResumen : " " );
            $this->set('resultadoUpload', isset($resultadoUpload) ? $resultadoUpload : " " );
        } else {
            $this->set('resultadoResumen', "");
            $this->set('resultadoUpload', isset($resultadoUpload) ? $resultadoUpload : "No hay fichero a subir " );
        }
    }
}

?>
