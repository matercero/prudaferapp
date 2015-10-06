<?php

class MigrarController extends AppController {

    var $name = 'Migrar';
    var $helpers = array('Autocomplete', 'Ajax', 'Javascript');
    var $components = array('Session', 'RequestHandler');
    var $uses = null;

    function familias() {
        $path = '../csvs/FAMILIA.csv';
        $primera_fila = true;
        if (($handle = fopen($path, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                /* Por cada fila insertar en base de datos */
                /*
                 *  0 => CODFAM
                 *  1 => DESFAM
                 */
                //Si no es la primera fila
                if (!$primera_fila) {
                    $this->loadModel('Familia');
                    $this->Familia->create();
                    $familia = array();
                    $familia['Familia']['codigo'] = $data[0];
                    $familia['Familia']['nombre'] = $data[1];
                    $familia['Familia']['descripcion'] = "";
                    $this->Familia->save($familia);
                } else {
                    $primera_fila = false;
                }
            }
            fclose($handle);
        }
        echo('Migracion de Familias Completada');
    }

    function proveedores() {
        $path = '../csvs/PROVEED.csv';
        $primera_fila = true;
        if (($handle = fopen($path, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                /* Por cada fila insertar en base de datos */
                /*
                  [0] => CODPRO
                  [1] => NOMPRO
                  [2] => APEPRO
                  [3] => CTACON
                  [4] => DOMPRO
                  [5] => POBPRO
                  [6] => PROPRO
                  [7] => DPOPRO
                  [8] => ACOPRO
                  [9] => TELEF1
                  [10] => TELEF2
                  [11] => TELEF3
                  [12] => FAXPRO
                  [13] => CONPRO
                  [14] => DTOCAB
                  [15] => DTODET
                  [16] => DIAPA1
                  [17] => DIAPA2
                  [18] => CIFPRO
                  [19] => CODTIP
                  [20] => CODPAG
                  [21] => CODMON
                 */
                //Si no es la primera fila
                if (!$primera_fila) {
                    $this->loadModel('Proveedore');
                    $this->Proveedore->create();
                    $familia = array();
                    $familia['Proveedore']['cif'] = $data[18];
                    $familia['Proveedore']['nombre'] = $data[1] . ' ' . $data[2];
                    $familia['Proveedore']['nombrefiscal'] = $data[1] . ' ' . $data[2];
                    $familia['Proveedore']['direccion'] = $data[4];
                    $familia['Proveedore']['direccionfiscal'] = $data[4];
                    $familia['Proveedore']['direccionalmacen'] = "";
                    $familia['Proveedore']['telefono'] = $data[9];
                    $familia['Proveedore']['fax'] = $data[12];
                    $familia['Proveedore']['web'] = "";
                    $familia['Proveedore']['proveedoresde'] = "";
                    $familia['Proveedore']['email'] = "";
                    $familia['Proveedore']['comercial'] = "";
                    $familia['Proveedore']['personascontacto'] = $data[13];
                    $familia['Proveedore']['observaciones'] = "";
                    $familia['Proveedore']['poblacion'] = $data[5];
                    $familia['Proveedore']['provincia'] = $data[6];
                    $familia['Proveedore']['cp'] = $data[7];
                    $familia['Proveedore']['pais'] = "";
                    $familia['Proveedore']['tipotransporte'] = "";
                    $familia['Proveedore']['formapedido'] = "";
                    $familia['Proveedore']['ecommerce'] = "";
                    $familia['Proveedore']['usuario'] = "";
                    $familia['Proveedore']['contrasenia'] = "";
                    $familia['Proveedore']['tiposiva_id'] = 7;
                    $familia['Proveedore']['cuentascontable_id'] = null;
                    $familia['Proveedore']['apartadocorreos'] = $data[8];
                    $familia['Proveedore']['codpro'] = $data[0];
                    $this->Proveedore->save($familia);
                } else {
                    $primera_fila = false;
                }
            }
            fclose($handle);
        }
        echo('Migracion de Proveedores Completada');
    }

    function almacenes() {
        $path = '../csvs/ALMACEN.csv';
        $primera_fila = true;
        if (($handle = fopen($path, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                /* Por cada fila insertar en base de datos */
                /*
                  [0] => CODALM
                  [1] => DESALM
                 */
                //Si no es la primera fila
                if (!$primera_fila) {
                    $this->loadModel('Almacene');
                    $this->Almacene->create();
                    $familia = array();
                    $familia['Almacene']['nombre'] = $data[1];
                    $familia['Almacene']['direccion'] = "";
                    $familia['Almacene']['telefono'] = "";
                    $familia['Almacene']['codalm'] = $data[0];
                    $this->Almacene->save($familia);
                } else {
                    $primera_fila = false;
                }
            }
            fclose($handle);
        }
        echo('Migracion de Almacenes Completada');
    }

    function articulos() {
        $path = '../csvs/ARTICAL.csv';
        $primera_fila = true;
        if (($handle = fopen($path, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";") ) !== FALSE) {
                /* Por cada fila insertar en base de datos */
                /*
                 * [0] => CODALM
                  [1] => CODPDT
                  [2] => LOCALIZ
                  [3] => SISVAL
                  [4] => PVP1
                  [5] => PRESTA
                  [6] => PREULT
                  [7] => PREMED
                  [8] => CANEXI
                  [9] => CODPRV
                  [10] => STOCKMIN
                  [11] => STOCKMAX
                 */
                //Si no es la primera fila
                if (!$primera_fila) {
                    $this->loadModel('Articulo');
                    $this->Articulo->create();
                    $articulo = array();
                    $articulo['Articulo']['ref'] = $data[1];
                    $articulo['Articulo']['nombre'] = "";
                    $articulo['Articulo']['codigobarras'] = "";
                    $articulo['Articulo']['valoracion'] = 0;
                    $articulo['Articulo']['precio_sin_iva'] = str_replace(',', '.', $data[4]);
                    $articulo['Articulo']['ultimopreciocompra'] = str_replace(',', '.', $data[6]);
                    $articulo['Articulo']['familia_id'] = null;
                    $articulo['Articulo']['localizacion'] = $data[2];
                    $articulo['Articulo']['existencias'] = $data[8];
                    $almacene = $this->Articulo->Almacene->find('first', array('contain' => array(), 'conditions' => array('Almacene.codalm' => $data[0])));
                    $articulo['Articulo']['almacene_id'] = $almacene['Almacene']['id'];
                    $proveedore = $this->Articulo->Proveedore->find('first', array('contain' => array(), 'conditions' => array('Proveedore.codpro' => (int) $data[9])));
                    $articulo['Articulo']['proveedore_id'] = $proveedore['Proveedore']['id'];
                    $articulo['Articulo']['stock_minimo'] = $data[10];
                    $articulo['Articulo']['stock_maximo'] = $data[11];
                    $articulo['Articulo']['observaciones'] = "";
                    $articulo['Articulo']['articuloescaneado'] = "";
                    $this->Articulo->save($articulo);
                } else {
                    $primera_fila = false;
                }
            }
        }
        fclose($handle);

        $path = '../csvs/ARTICBA.csv';
        $primera_fila = true;
        if (($handle = fopen($path, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                if (!$primera_fila) {
                    $this->loadModel('Articulo');
                    $articulos = $this->Articulo->find('all', array('contain' => array(), 'conditions' => array('Articulo.ref' => $data[0])));
                    foreach ($articulos as $articulo) {
                        $familia = $this->Articulo->Familia->find('first', array('fields' => array('id'), 'contain' => array(), 'conditions' => array('Familia.codigo' => (int) $data[3])));
                        $articulo['Articulo']['familia_id'] = $familia['Familia']['id'];
                        $articulo['Articulo']['nombre'] = $data[1];
                        $articulo['Articulo']['codigobarras'] = $data[2];
                        pr($articulo);
                        $this->Articulo->save($articulo);
                    }
                } else {
                    $primera_fila = false;
                }
            }
            fclose($handle);
        }
        echo('Migracion de Articulos Completada');
    }

    function cuentascontables() {
        $path = '../csvs/CUENTAS08.csv';
        $primera_fila = true;
        if (($handle = fopen($path, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                if (!$primera_fila) {
                    $this->loadModel('Cuentascontable');
                    $this->Cuentascontable->create();
                    $cuentascontable = array();
                    $cuentascontable['Cuentascontable']['codigo'] = $data[0];
                    $cuentascontable['Cuentascontable']['nombre'] = $data[1];
                    $cuentascontable['Cuentascontable']['nombre_cuenta_abierta'] = $data[2];
                    $cuentascontable['Cuentascontable']['nombre_cuenta_externa'] = $data[3];
                    $this->Cuentascontable->save($cuentascontable);
                } else {
                    $primera_fila = false;
                }
            }
            fclose($handle);
        }
        echo('Migracion de Cuentas Contables Completada');
    }

    function clientes() {

        /*
         *     [0] => CODCLI
          [1] => NOMCLI
          [2] => CIFCLI
          [3] => APECLI
          [4] => CTACON
          [5] => DOMCLI
          [6] => POBCLI
          [7] => PROCLI
          [8] => DPOCLI
          [9] => ACOCLI
          [10] => TELEF1
          [11] => TELEF2
          [12] => TELEF3
          [13] => FAXCLI
          [14] => CONCLI
          [15] => TIPFAC
          [16] => TARIPR
          [17] => DTOCAB
          [18] => TIPIMP
          [19] => DTOOBR
          [20] => RECARG
          [21] => DTOMAT
          [22] => FORPAG
          [23] => DIAPA1
          [24] => DIAPA2
          [25] => CODBAN
          [26] => CODSUC
          [27] => DIGCON
          [28] => CODCUE
          [29] => TAROBR
          [30] => DESHOR
          [31] => PREHOR
          [32] => NUMKM
          [33] => PREKM
          [34] => CLAFAC
          [35] => DIETENT
          [36] => MONEDA
          [37] => CONTROLRIE
          [38] => RIECON
          [39] => IMPREF
          [40] => IMPHOR
          [41] => DTOREP
          [42] => TARIREP

         */
        $path = '../csvs/CLIENTE.csv';
        $primera_fila = true;
        if (($handle = fopen($path, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                if (!$primera_fila) {
                    $this->loadModel('Cliente');
                    $this->Cliente->create();
                    $cliente = array();
                    $cliente['Cliente']['codcli'] = $data[0];
                    $cliente['Cliente']['cif'] = $data[2];
                    $cliente['Cliente']['nombrefiscal'] = $data[1] . " " . $data[3];
                    $cliente['Cliente']['nombre'] = $data[1] . " " . $data[3];
                    $cliente['Cliente']['personascontacto'] = $data[14];
                    $cliente['Cliente']['telefono'] = $data[10];
                    $cliente['Cliente']['fax'] = $data[13];
                    $cliente['Cliente']['web'] = "";
                    $cliente['Cliente']['email'] = "";
                    $cliente['Cliente']['direccion_postal'] = $data[5];
                    $cliente['Cliente']['direccion_fiscal'] = $data[5];
                    $cliente['Cliente']['modoenviofactura'] = "direccionpostal";
                    $cliente['Cliente']['riesgos'] = str_replace(',', '.', $data[38]);
                    $cliente['Cliente']['modo_facturacion'] = "";
                    $cuentascontable = $this->Cliente->Cuentascontable->find('first', array('contain' => array(), 'conditions' => array('Cuentascontable.codigo' => $data[4])));
                    $cliente['Cliente']['cuentascontable_id'] = $cuentascontable['Cuentascontable']['id'];
                    if ($data[39] == 'FALSO')
                        $cliente['Cliente']['imprimir_con_ref'] = 0;
                    if ($data[39] == 'VERDADERO')
                        $cliente['Cliente']['imprimir_con_ref'] = 1;
                    $cliente['Cliente']['comerciale_id'] = null;
                    $cliente['Cliente']['codigopostal'] = $data[8];
                    $cliente['Cliente']['codigopostalfiscal'] = $data[8];
                    $cliente['Cliente']['apartadocorreospostal'] = $data[9];
                    $cliente['Cliente']['apartadocorreosfiscal'] = $data[9];
                    $cliente['Cliente']['poblacionpostal'] = $data[6];
                    $cliente['Cliente']['poblacionfiscal'] = $data[6];
                    $cliente['Cliente']['provinciapostal'] = $data[7];
                    $cliente['Cliente']['provinciafiscal'] = $data[7];
                    if ($this->Cliente->save($cliente)) {
                        $this->Cliente->Centrostrabajo->create();
                        $centrostrabajo = array();
                        $centrostrabajo['Centrostrabajo']['centrotrabajo'] = $data[5];
                        $centrostrabajo['Centrostrabajo']['direccion'] = $data[5];
                        $centrostrabajo['Centrostrabajo']['poblacion'] = $data[6];
                        $centrostrabajo['Centrostrabajo']['provincia'] = $data[7];
                        $centrostrabajo['Centrostrabajo']['cp'] = $data[8];
                        $centrostrabajo['Centrostrabajo']['telefono'] = $data[10];
                        $centrostrabajo['Centrostrabajo']['cliente_id'] = $this->Cliente->id;
                        $centrostrabajo['Centrostrabajo']['observaciones'] = "";
                        $centrostrabajo['Centrostrabajo']['responsable'] = $data[14];
                        $centrostrabajo['Centrostrabajo']['modofacturacion'] = "";
                        $centrostrabajo['Centrostrabajo']['distancia'] = str_replace(',', '.', $data[32]);
                        $centrostrabajo['Centrostrabajo']['tiempodesplazamiento'] = str_replace(',', '.', $data[30]);
                        $centrostrabajo['Centrostrabajo']['preciohoradesplazamiento'] = str_replace(',', '.', $data[31]);
                        $centrostrabajo['Centrostrabajo']['preciokm'] = str_replace(',', '.', $data[33]);
                        $centrostrabajo['Centrostrabajo']['preciohoraencentro'] = 0;
                        $centrostrabajo['Centrostrabajo']['preciohoraentraller'] = 0;
                        $centrostrabajo['Centrostrabajo']['preciofijodesplazamiento'] = 0;
                        $centrostrabajo['Centrostrabajo']['dietas'] = str_replace(',', '.', $data[35]);
                        $centrostrabajo['Centrostrabajo']['descuentomaterial'] = str_replace(',', '.', $data[31]);
                        $centrostrabajo['Centrostrabajo']['descuentomanoobra'] = 0;
                        $centrostrabajo['Centrostrabajo']['fax'] = $data[13];
                        $centrostrabajo['Centrostrabajo']['email'] = "";
                        $this->Cliente->Centrostrabajo->save($centrostrabajo);
                    }
                } else {
                    $primera_fila = false;
                }
            }
            fclose($handle);
        }
        $path = '../csvs/TERCERO.csv';
        $primera_fila = true;
        if (($handle = fopen($path, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                if (!$primera_fila) {
                    $this->loadModel('Cliente');
                    $cliente_bd = $this->Cliente->find('first', array('contain' => array(), 'conditions' => array('Cliente.codcli' => $data[2])));
                    if (empty($cliente_bd) && $data[0] == 'C') {
                        $this->Cliente->create();
                        $cliente = array();
                        $cliente['Cliente']['codcli'] = $data[2];
                        $cliente['Cliente']['cif'] = $data[4];
                        $cliente['Cliente']['nombrefiscal'] = $data[3];
                        $cliente['Cliente']['nombre'] = $data[3];
                        $cliente['Cliente']['personascontacto'] = $data[31];
                        $cliente['Cliente']['telefono'] = $data[20];
                        $cliente['Cliente']['fax'] = $data[23];
                        $cliente['Cliente']['web'] = "";
                        $cliente['Cliente']['email'] = "";
                        $cliente['Cliente']['direccion_postal'] = $data[6];
                        $cliente['Cliente']['direccion_fiscal'] = $data[6];
                        $cliente['Cliente']['modoenviofactura'] = "direccionpostal";
                        $cliente['Cliente']['riesgos'] = 0;
                        $cliente['Cliente']['modo_facturacion'] = "albaran";
                        $cuentascontable = $this->Cliente->Cuentascontable->find('first', array('contain' => array(), 'conditions' => array('Cuentascontable.codigo' => $data[1])));
                        $cliente['Cliente']['cuentascontable_id'] = $cuentascontable['Cuentascontable']['id'];
                        $cliente['Cliente']['imprimir_con_ref'] = 1;
                        $cliente['Cliente']['comerciale_id'] = null;
                        $cliente['Cliente']['codigopostal'] = $data[9];
                        $cliente['Cliente']['codigopostalfiscal'] = $data[9];
                        $cliente['Cliente']['apartadocorreospostal'] = $data[19];
                        $cliente['Cliente']['apartadocorreosfiscal'] = $data[19];
                        $cliente['Cliente']['poblacionpostal'] = $data[10];
                        $cliente['Cliente']['poblacionfiscal'] = $data[10];
                        $cliente['Cliente']['provinciapostal'] = $data[11];
                        $cliente['Cliente']['provinciafiscal'] = $data[11];
                        if ($this->Cliente->save($cliente)) {
                            $this->Cliente->Centrostrabajo->create();
                            $centrostrabajo = array();
                            $centrostrabajo['Centrostrabajo']['centrotrabajo'] = $data[6];
                            $centrostrabajo['Centrostrabajo']['direccion'] = $data[6];
                            $centrostrabajo['Centrostrabajo']['poblacion'] = $data[10];
                            $centrostrabajo['Centrostrabajo']['provincia'] = $data[11];
                            $centrostrabajo['Centrostrabajo']['cp'] = $data[9];
                            $centrostrabajo['Centrostrabajo']['telefono'] = $data[20];
                            $centrostrabajo['Centrostrabajo']['cliente_id'] = $this->Cliente->id;
                            $centrostrabajo['Centrostrabajo']['observaciones'] = "";
                            $centrostrabajo['Centrostrabajo']['responsable'] = $data[31];
                            $centrostrabajo['Centrostrabajo']['modofacturacion'] = "";
                            $centrostrabajo['Centrostrabajo']['distancia'] = 0;
                            $centrostrabajo['Centrostrabajo']['tiempodesplazamiento'] = 0;
                            $centrostrabajo['Centrostrabajo']['preciohoradesplazamiento'] = 0;
                            $centrostrabajo['Centrostrabajo']['preciokm'] = 0;
                            $centrostrabajo['Centrostrabajo']['preciohoraencentro'] = 0;
                            $centrostrabajo['Centrostrabajo']['preciohoraentraller'] = 0;
                            $centrostrabajo['Centrostrabajo']['preciofijodesplazamiento'] = 0;
                            $centrostrabajo['Centrostrabajo']['dietas'] = 0;
                            $centrostrabajo['Centrostrabajo']['descuentomaterial'] = 0;
                            $centrostrabajo['Centrostrabajo']['descuentomanoobra'] = 0;
                            $centrostrabajo['Centrostrabajo']['fax'] = $data[23];
                            $centrostrabajo['Centrostrabajo']['email'] = "";
                            $this->Cliente->Centrostrabajo->save($centrostrabajo);
                        }
                    }
                } else {
                    $primera_fila = false;
                }
            }
            fclose($handle);
        }
        echo('Migracion de Cuentas Clientes Completada');
    }

    function formapagos() {
        /**/
        echo "Ejecutar estas dos consusltas desde phpMyAdmin: <br/>";
        $this->loadModel('Config');
        $this->Config->query("INSERT INTO formapagos (nombre, tipodepago, numero_vencimientos, cliente_id) SELECT 'Contado', 'contado', 1, id FROM clientes");
        $this->Config->query("INSERT INTO formapagos (nombre, tipodepago, numero_vencimientos,dias_entre_vencimiento, proveedore_id) SELECT 'transferencia', 'transferencia', 1,30, id FROM proveedores");
        echo('Migracion de Forma de Pagos');
    }

    function cuentasbancarias() {
        $path = '../csvs/CLIENTE.csv';
        $primera_fila = true;
        if (($handle = fopen($path, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                if (!$primera_fila) {
                    $this->loadModel('Cuentasbancaria');
                    $this->Cuentasbancaria->create();
                    $cuentasbancaria = array();
                    $cuentasbancaria['Cuentasbancaria']['nombre'] = 'Cuenta Bancaria de ' . $data[1];
                    $cuentasbancaria['Cuentasbancaria']['numero_entidad'] = $data[25];
                    $cuentasbancaria['Cuentasbancaria']['numero_sucursal'] = $data[26];
                    $cuentasbancaria['Cuentasbancaria']['numero_dc'] = $data[27];
                    $cuentasbancaria['Cuentasbancaria']['numero_cuenta'] = $data[28];
                    $cuentasbancaria['Cuentasbancaria']['numero_bicswift'] = '';
                    $cuentasbancaria['Cuentasbancaria']['numero_iban'] = '';
                    $this->Cuentasbancaria->Cliente->find('first', array('contain' => array(), 'conditions' => array('Cliente.cif' => $data[2])));
                    $cuentasbancaria['Cuentasbancaria']['cliente_id'] = $data[0];
                    $this->Cuentasbancaria->save($cuentasbancaria);
                } else {
                    $primera_fila = false;
                }
            }
            fclose($handle);
        }
        echo('Migracion de Cuentas Bancarias Finalizada');
    }

    function maquinas() {
        /* Debemos tener la columna temporar codcli en la tabla clientes */
        $path = '../csvs/MAQUINA.csv';
        $primera_fila = true;
        if (($handle = fopen($path, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                /*
                 * Array
                  (
                  [0] => CODMAQ
                  [1] => CODCLI
                  [2] => DESMAQ
                  [3] => SERMAQ
                  [4] => SERMOT
                  [5] => SERTRA
                  [6] => VARIOS
                  )
                 */
                if (!$primera_fila) {
                    $this->loadModel('Maquina');
                    $this->Maquina->create();
                    $maquina = array();
                    $maquina['Maquina']['codigo'] = $data[0];
                    $maquina['Maquina']['nombre'] = $data[2];
                    $maquina['Maquina']['serie_maquina'] = $data[3];
                    $maquina['Maquina']['modelo_motor'] = '';
                    $maquina['Maquina']['serie_motor'] = $data[4];
                    $maquina['Maquina']['modelo_transmision'] = '';
                    $maquina['Maquina']['serie_transmision'] = $data[5];
                    $maquina['Maquina']['horas'] = 0;
                    $maquina['Maquina']['observaciones'] = '';
                    $maquina['Maquina']['anio_fabricacion'] = '';
                    $maquina['Maquina']['maquinaescaneada'] = '';
                    $cliente = $this->Maquina->Cliente->find('first', array('contain' => array('Centrostrabajo'), 'conditions' => array('Cliente.codcli' => $data[1])));
                    $maquina['Maquina']['cliente_id'] = $cliente['Cliente']['id'];
                    // Cuando estamos migrando cada cliente solo tiene un unico centro de trabajo
                    $maquina['Maquina']['centrostrabajo_id'] = $cliente['Centrostrabajo'][0]['id'];
                    $this->Maquina->save($maquina);
                } else {
                    $primera_fila = false;
                }
            }
            fclose($handle);
        }
        echo('Migracion de Máquinas Finalizada');
    }

    function mecanicos() {
        /* Debemos tener la columna temporar codcli en la tabla clientes */
        $path = '../csvs/OPERARI.csv';
        $primera_fila = true;
        if (($handle = fopen($path, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                if (!$primera_fila) {
                    $this->loadModel('Mecanico');
                    $this->Mecanico->create();
                    $mecanico = array();
                    $mecanico['Mecanico']['codigo'] = $data[0];
                    $mecanico['Mecanico']['dni'] = '';
                    $mecanico['Mecanico']['nombre'] = $data[1];
                    $mecanico['Mecanico']['fechaalta'] = NULL;
                    $mecanico['Mecanico']['observaciones'] = '';
                    $this->Mecanico->save($mecanico);
                } else {
                    $primera_fila = false;
                }
            }
            fclose($handle);
        }
        echo('Migracion de Mecanicos Finalizada');
    }

    function comerciales_proveedores() {
        /* Debemos tener la columna temporal codpro en la tabla proveedores */
        $path = '../csvs/PROVEED.csv';
        $primera_fila = true;
        if (($handle = fopen($path, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                if (!$primera_fila) {
                    $this->loadModel('ComercialesProveedore');
                    $this->ComercialesProveedore->create();
                    $ComercialesProveedore = array();
                    $ComercialesProveedore['ComercialesProveedore']['nombre'] = $data[13];
                    $ComercialesProveedore['ComercialesProveedore']['apellidos'] = $data[13];
                    $ComercialesProveedore['ComercialesProveedore']['email'] = '';
                    $ComercialesProveedore['ComercialesProveedore']['telefono'] = $data[9];
                    $ComercialesProveedore['ComercialesProveedore']['observaciones'] = '';
                    $proveedore = $this->ComercialesProveedore->Proveedore->find('first', array('contain' => array(), 'conditions' => array('Proveedore.codpro' => $data[0])));
                    $ComercialesProveedore['ComercialesProveedore']['proveedore_id'] = $proveedore['Proveedore']['id'];
                    $this->ComercialesProveedore->save($ComercialesProveedore);
                } else {
                    $primera_fila = false;
                }
            }
            fclose($handle);
        }
        echo('Migracion de Comerciales Proveedores Finalizada');
    }

    /*
     * ORDENES 
     */

    function ordenes() {
        /*
          SET foreign_key_checks = 0;
          TRUNCATE TABLE `ordenes`;
         */
        $path = '../csvs/ORDCAB.csv';
        $primera_fila = true;
        if (($handle = fopen($path, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                if (!$primera_fila) {
                    $this->loadModel('Ordene');
                    $this->Ordene->create();
                    $ordene = array();
                    $ordene['Ordene']['numero'] = $data[0];
                    $ordene['Ordene']['fecha'] = str_fecha_mysql($data[4]);
                    $ordene['Ordene']['urgente'] = 0;
                    $ordene['Ordene']['descripcion'] = '';
                    $ordene['Ordene']['observaciones'] = '';
                    $ordene['Ordene']['avisostallere_id'] = NULL;
                    $ordene['Ordene']['estadosordene_id'] = 6;
                    $ordene['Ordene']['fecha_prevista_reparacion'] = NULL;
                    $ordene['Ordene']['almacene_id'] = 1;
                    $ordene['Ordene']['comerciale_id'] = NULL;
                    $cliente = $this->Ordene->Cliente->find('first', array('contain' => array('Centrostrabajo'), 'conditions' => array('Cliente.codcli' => $data[1])));
                    $ordene['Ordene']['cliente_id'] = $cliente['Cliente']['id'];
                    // Cuando estamos migrando cada cliente solo tiene un unico centro de trabajo
                    $ordene['Ordene']['centrostrabajo_id'] = $cliente['Centrostrabajo'][0]['id'];
                    //He puesto que la maquina pueda ser NULO por problemas de migracion
                    $maquina = $this->Ordene->Maquina->find('first', array('contain' => array(), 'conditions' => array('Maquina.codigo' => $data[2])));
                    //$maquina = $this->Ordene->Maquina->find('first', array('contain' => array(), 'conditions' => array('Maquina.codigo' => $data[2], 'Maquina.cliente_id' => $cliente['Cliente']['id'])));
                    $ordene['Ordene']['maquina_id'] = $maquina['Maquina']['id'];
                    $this->Ordene->save($ordene);
                } else {
                    $primera_fila = false;
                }
            }
            fclose($handle);
        }
        echo('Migracion de Ordenes ( base )  Finalizada');
    }

    function tareas() {
        /*
          SET foreign_key_checks = 0;
          TRUNCATE TABLE `tareas`;
         */
        // No he pasado el HREAL y HFACT
        $path = '../csvs/ORDDET.csv';
        $primera_fila = true;
        if (($handle = fopen($path, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                if (!$primera_fila) {
                    $this->loadModel('Tarea');
                    $this->Tarea->create();
                    $tarea = array();
                    $tarea['Tarea']['tipo'] = 'centro';
                    $ordene = $this->Tarea->Ordene->find('first', array('contain' => array(), 'conditions' => array('Ordene.numero' => $data[2], 'Ordene.fecha' => str_fecha_mysql($data[1]))));
                    $tarea['Tarea']['ordene_id'] = $ordene['Ordene']['id'];
                    $tarea['Tarea']['numero'] = $data[0];
                    $tarea['Tarea']['descripcion'] = $data[3];
                    $this->Tarea->save($tarea);
                } else {
                    $primera_fila = false;
                }
            }
            fclose($handle);
        }
        echo('Migracion de Tareas  Finalizada');
    }

    function articulos_tareas() {
        /*
          SET foreign_key_checks = 0;
          TRUNCATE TABLE `articulos_tareas`;
         * 
         * 
          Array
          (
          [0] => ORDANYO
          [1] => NUMORD
          [2] => NUMTAR
          [3] => CODPDT
          [4] => FECIMP
          [5] => HORA
          [6] => CANTIDAD
          [7] => DOCSER
          [8] => DOCNUM
          [9] => LINEA
          )
          Hay que Desactivar el BeforeSave del modelo de  ArticulosTarea
         * Hay Articulos que no se pasan por que tienen asignada una tarea que no esta en ORDEt o no tienen ARTIculo 
         */
        $path = '../csvs/MATERIA.csv';
        $primera_fila = true;
        if (($handle = fopen($path, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                if (!$primera_fila) {
                    $this->loadModel('ArticulosTarea');
                    $this->ArticulosTarea->create();
                    $articulo_tarea = array();
                    $articulo = $this->ArticulosTarea->Articulo->find('first', array('contain' => array(), 'conditions' => array('Articulo.ref' => $data[3])));
                    $articulo_tarea['ArticulosTarea']['articulo_id'] = $articulo['Articulo']['id'];
                    $articulo_tarea['ArticulosTarea']['precio_unidad'] = $articulo['Articulo']['precio_sin_iva'];
                    //primero el precio del Articulo y luego cuando pasemos las ordenes se actualizará con el precio del albarán
                    $tarea = $this->ArticulosTarea->Tarea->find('first', array(
                        'contain' => array(),
                        'conditions' => array('Tarea.numero' => $data[2], '1' => '1 AND Tarea.ordene_id = (SELECT Ordene.id FROM ordenes Ordene WHERE DATE_FORMAT(Ordene.fecha,"%Y")="' . $data[0] . '" AND Ordene.numero = "' . $data[1] . '")')
                            )
                    );
                    $articulo_tarea['ArticulosTarea']['tarea_id'] = $tarea['Tarea']['id'];
                    $articulo_tarea['ArticulosTarea']['cantidadreal'] = intval($data[6]);
                    $articulo_tarea['ArticulosTarea']['cantidad'] = intval($data[6]);
                    $articulo_tarea['ArticulosTarea']['cantidad_presupuestada'] = 0;
                    $articulo_tarea['ArticulosTarea']['descuento'] = 0;
                    $articulo_tarea['ArticulosTarea']['presupuestado'] = 0;
                    if (!empty($articulo_tarea['ArticulosTarea']['tarea_id']) && !empty($articulo_tarea['ArticulosTarea']['articulo_id']))
                        $this->ArticulosTarea->save($articulo_tarea);
                } else {
                    $primera_fila = false;
                }
            }
            fclose($handle);
        }
        echo('Migracion de Articulos de Tareas  Finalizada');
    }

    function partes() {
        /*
          SET foreign_key_checks = 0;
          TRUNCATE TABLE `partes`;
         * 
         * 
         */
        $path = '../csvs/TIEMPOS.csv';
        $primera_fila = true;
        if (($handle = fopen($path, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                if (!$primera_fila) {
                    if (intval($data[8]) >= 800 && intval($data[8]) < 900) {
                        $this->loadModel('Parte');
                        $this->Parte->create();
                        $parte = array();
                        $parte['Parte']['numero'] = 0;
                        $tarea = $this->Parte->Tarea->find('first', array(
                            'contain' => array(),
                            'conditions' => array('Tarea.numero' => $data[2], '1' => '1 AND Tarea.ordene_id = (SELECT Ordene.id FROM ordenes Ordene WHERE DATE_FORMAT(Ordene.fecha,"%Y")="' . $data[0] . '" AND Ordene.numero = "' . $data[1] . '")')
                                )
                        );
                        $parte['Parte']['tarea_id'] = $tarea['Tarea']['id'];
                        $mecanico = $this->Parte->Mecanico->find('first', array('contain' => array(), 'conditions' => array('Mecanico.codigo' => $data[3])));
                        $parte['Parte']['mecanico_id'] = $mecanico['Mecanico']['id'];
                        $parte['Parte']['fecha'] = str_fecha_mysql($data[4]);
                        $parte['Parte']['horainicio'] = str_time_mysql($data[5]);
                        $parte['Parte']['horafinal'] = str_time_mysql($data[6]);
                        $parte['Parte']['horasimputables'] = redondear_dos_decimal(str_replace(',', '.', $data[7]) / 60);
                        $parte['Parte']['dietasimputables'] = str_replace(',', '.', $data[14]);
                        $parte['Parte']['otrosservicios_imputable'] = str_replace(',', '.', $data[11]);
                        // La operacion se obtiene mediante  NUMTAR $data[2] , NUMORD $data[1] , ORDANYO $data[0] ,CODOPER $data[8] , LINEA $data[9] en la tabla ORDOBRA
                        $ordobra = $this->Parte->query("SELECT DESOPE FROM ordobra WHERE NUMTAR = '" . $data[2] . "' AND NUMORD ='" . $data[1] . "' AND FECORD ='" . $data[0] . "' AND CODOPER = '" . $data[8] . "' AND LINEA = '" . $data[9] . "';");
                        if (!empty($ordobra[0]['ordobra']['DESOPE']))
                            $parte['Parte']['operacion'] = $ordobra[0]['ordobra']['DESOPE'];
                        else
                            $parte['Parte']['operacion'] = 'Operación en Centro de Trabajo';

                        $parte['Parte']['observaciones'] = $data[10];
                        $parte['Parte']['varios_descripcion'] = 'Portes';
                        $parte['Parte']['total_kmdesplazamiento_imputable'] = doubleval(str_replace(',', '.', $data[12]));
                        $parte['Parte']['total_horasdesplazamiento_imputable'] = doubleval(str_replace(',', '.', $data[13]));
                        $parte['Parte']['preciohoraencentro'] = 32; // Por defecto
                        if (!empty($parte['Parte']['tarea_id']))
                            $this->Parte->save($parte);
                    }
                } else {
                    $primera_fila = false;
                }
            }
            fclose($handle);
        }
        echo 'Migracion de Partes de Centros de trabajo Finalizada';
    }

    function partestalleres() {
        /*
          SET foreign_key_checks = 0;
          TRUNCATE TABLE `partestalleres`;
         * 
         * 
         */
        $path = '../csvs/TIEMPOS.csv';
        $primera_fila = true;
        if (($handle = fopen($path, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                if (!$primera_fila) {
                    if (intval($data[8]) >= 100 && intval($data[8]) < 200) {
                        $this->loadModel('Partestallere');
                        $this->Partestallere->create();
                        $partestallere = array();
                        $partestallere['Partestallere']['numero'] = 0;
                        $tarea = $this->Partestallere->Tarea->find('first', array(
                            'contain' => array(),
                            'conditions' => array('Tarea.numero' => $data[2], '1' => '1 AND Tarea.ordene_id = (SELECT Ordene.id FROM ordenes Ordene WHERE DATE_FORMAT(Ordene.fecha,"%Y")="' . $data[0] . '" AND Ordene.numero = "' . $data[1] . '")')
                                )
                        );
                        $partestallere['Partestallere']['tarea_id'] = $tarea['Tarea']['id'];
                        $mecanico = $this->Partestallere->Mecanico->find('first', array('contain' => array(), 'conditions' => array('Mecanico.codigo' => $data[3])));
                        $partestallere['Partestallere']['mecanico_id'] = $mecanico['Mecanico']['id'];
                        $partestallere['Partestallere']['fecha'] = str_fecha_mysql($data[4]);
                        $partestallere['Partestallere']['horainicio'] = str_time_mysql($data[5]);
                        $partestallere['Partestallere']['horafinal'] = str_time_mysql($data[6]);
                        $partestallere['Partestallere']['horasimputables'] = redondear_dos_decimal(str_replace(',', '.', $data[7]) / 60);
                        $partestallere['Partestallere']['otrosservicios_imputable'] = str_replace(',', '.', $data[11]);
                        // La operacion se obtiene mediante  NUMTAR $data[2] , NUMORD $data[1] , ORDANYO $data[0] ,CODOPER $data[8] , LINEA $data[9] en la tabla ORDOBRA
                        $ordobra = $this->Partestallere->query("SELECT DESOPE FROM ordobra WHERE NUMTAR = '" . $data[2] . "' AND NUMORD ='" . $data[1] . "' AND FECORD ='" . $data[0] . "' AND CODOPER = '" . $data[8] . "' AND LINEA = '" . $data[9] . "';");
                        if (!empty($ordobra[0]['ordobra']['DESOPE']))
                            $partestallere['Partestallere']['operacion'] = $ordobra[0]['ordobra']['DESOPE'];
                        else
                            $partestallere['Partestallere']['operacion'] = 'Operación en Taller';
                        $partestallere['Partestallere']['observaciones'] = $data[10];
                        $partestallere['Partestallere']['varios_descripcion'] = 'Portes';
                        $partestallere['Partestallere']['preciohoraentraller'] = 30;

                        if (!empty($partestallere['Partestallere']['tarea_id']))
                            $this->Partestallere->save($partestallere);
                    }
                } else {
                    $primera_fila = false;
                }
            }
            fclose($handle);
        }
        echo 'Migracion de Partes de Taller Finalizada';
    }

    /*
     * ALBARANES DE LAS ORDENES
     */

    function albaranesclientesreparaciones() {
        /*
          SET foreign_key_checks = 0;
          TRUNCATE TABLE `albaranesclientesreparaciones`;
         */
        $cantidad_albaranes_bad = 0;
        $cantidad_albaranestot_bad = 0;
        $path = '../csvs/ALFACAB-REPARACION.csv';
        $primera_fila = true;
        if (($handle = fopen($path, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                if (!$primera_fila) {
                    $this->loadModel('Albaranesclientesreparacione');
                    $this->Albaranesclientesreparacione->create();
                    $albaranesclientesreparacione = array();
                    $albaranesclientesreparacione['Albaranesclientesreparacione']['serie'] = $data[1];
                    $albaranesclientesreparacione['Albaranesclientesreparacione']['numero'] = intval($data[2]);
                    $albaranesclientesreparacione['Albaranesclientesreparacione']['fecha'] = str_fecha_mysql($data[0]);
                    $albaranesclientesreparacione['Albaranesclientesreparacione']['observaciones'] = $data[17];
                    $albaranesclientesreparacione['Albaranesclientesreparacione']['albaranescaneado'] = '';
                    $albaranesclientesreparacione['Albaranesclientesreparacione']['facturable'] = 1;
                    $fecha_del_albaran = new DateTime(str_fecha_mysql($data[0]));
                    $fecha_de_cambio_de_iva = new DateTime("2011-07-1");
                    if ($fecha_del_albaran < $fecha_de_cambio_de_iva)
                        $albaranesclientesreparacione['Albaranesclientesreparacione']['tiposiva_id'] = 11;
                    else
                        $albaranesclientesreparacione['Albaranesclientesreparacione']['tiposiva_id'] = 1;
                    $ordene = $this->Albaranesclientesreparacione->Ordene->find('first', array('contain' => array(), 'conditions' => array('Ordene.fecha' => str_fecha_mysql($data[9]), 'Ordene.numero' => $data[10])));
                    $albaranesclientesreparacione['Albaranesclientesreparacione']['ordene_id'] = $ordene['Ordene']['id'];
                    $albaranesclientesreparacione['Albaranesclientesreparacione']['cliente_id'] = $ordene['Ordene']['cliente_id'];
                    $albaranesclientesreparacione['Albaranesclientesreparacione']['centrostrabajo_id'] = $ordene['Ordene']['centrostrabajo_id'];
                    $albaranesclientesreparacione['Albaranesclientesreparacione']['maquina_id'] = $ordene['Ordene']['maquina_id'];
                    $almacene = $this->Albaranesclientesreparacione->Almacene->find('first', array('contain' => array(), 'conditions' => array('Almacene.codalm' => $data[3])));
                    $albaranesclientesreparacione['Albaranesclientesreparacione']['almacene_id'] = $almacene['Almacene']['id'];
                    $albaranesclientesreparacione['Albaranesclientesreparacione']['facturas_cliente_id'] = null; // Al añadir las facturas hay que actualizar
                    $albaranesclientesreparacione['Albaranesclientesreparacione']['es_devolucion'] = 0;
                    $albaranesclientesreparacione['Albaranesclientesreparacione']['numero_aceptacion_aportado'] = '';
                    $albaranesclientesreparacione['Albaranesclientesreparacione']['comerciale_id'] = null;
                    $albaranesclientesreparacione['Albaranesclientesreparacione']['centrosdecoste_id'] = null;
                    $albaranesclientesreparacione['Albaranesclientesreparacione']['estadosalbaranesclientesreparacione_id'] = 3;

                    if (!$this->Albaranesclientesreparacione->save($albaranesclientesreparacione)) {
                        //pr($this->Albaranesclientesreparacione->invalidFields());
                        //pr($data);
                        $cantidad_albaranes_bad++;
                    }
                } else {
                    $primera_fila = false;
                }
            }
            fclose($handle);
        }
        // ahora tenemos que ponerle la base imponible que se encuentra  en otro archivo: ALFATOT
        $path = '../csvs/ALFATOT.csv';
        $primera_fila = true;
        if (($handle = fopen($path, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                if (!$primera_fila && $data[0] == 'A') {
                    $this->loadModel('Albaranesclientesreparacione');
                    $albaranesclientesreparacione = $this->Albaranesclientesreparacione->find('first', array('fields' => array('id'), 'contain' => array(), 'conditions' => array('Albaranesclientesreparacione.serie' => $data[2], 'Albaranesclientesreparacione.numero' => intval($data[3]), 'Albaranesclientesreparacione.fecha' => str_fecha_mysql($data[1]))));
                    if (!empty($albaranesclientesreparacione['Albaranesclientesreparacione']['id'])) {
                        $this->Albaranesclientesreparacione->id = $albaranesclientesreparacione['Albaranesclientesreparacione']['id'];
                        $this->Albaranesclientesreparacione->saveField('baseimponible', str_replace(',', '.', $data[7]));
                    } else {
                        //pr($data);
                        $cantidad_albaranestot_bad++;
                    }
                } else {
                    $primera_fila = false;
                }
            }
            fclose($handle);
        }
        // Fin
        echo('Migracion de Albranes de Reparacion ( Ordenes )  Finalizada');
        echo '<br/>Cantidad de ALFACAB Reparacion No añadida: ' . $cantidad_albaranes_bad;
        echo '<br/>Cantidad de AFATOT No añadida: ' . $cantidad_albaranestot_bad;
    }

    function tareas_albaranesclientesreparaciones() {
        /*
          SET foreign_key_checks = 0;
          TRUNCATE TABLE `tareas_albaranesclientesreparaciones`;
         */
        $cantidad_tareas_bad = 0;
        $path = '../csvs/ALFADET-REPARACION.csv';
        $primera_fila = true;
        if (($handle = fopen($path, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                if (!$primera_fila) {
                    $this->loadModel('TareasAlbaranesclientesreparacione');
                    $this->TareasAlbaranesclientesreparacione->create();
                    $tarea = array();
                    $tarea['TareasAlbaranesclientesreparacione']['numero'] = $data[0];
                    $tarea['TareasAlbaranesclientesreparacione']['tipo'] = 'centro';
                    $serie_albaran = $data[2];
                    $conditions = array('Albaranesclientesreparacione.serie' => $serie_albaran, 'Albaranesclientesreparacione.numero' => intval($data[3]));
                    $albaranesclientesreparacione = $this->TareasAlbaranesclientesreparacione->Albaranesclientesreparacione->find('first', array('contain' => array(), 'conditions' => $conditions));
                    $tarea['TareasAlbaranesclientesreparacione']['albaranesclientesreparacione_id'] = $albaranesclientesreparacione['Albaranesclientesreparacione']['id'];
                    $tarea['TareasAlbaranesclientesreparacione']['descripcion'] = $data[4];
                    $tarea_orden = $this->TareasAlbaranesclientesreparacione->Tarea->find('first', array('contain' => array(), 'conditions' => array('Tarea.numero' => $data[0], 'Tarea.ordene_id' => $albaranesclientesreparacione['Albaranesclientesreparacione']['ordene_id'])));
                    if (empty($tarea_orden['Tarea']['id']))
                        $tarea['TareasAlbaranesclientesreparacione']['tarea_id'] = null;
                    else
                        $tarea['TareasAlbaranesclientesreparacione']['tarea_id'] = $tarea_orden['Tarea']['id'];
                    //Se tiene que desactivar afterSave
                    if (!$this->TareasAlbaranesclientesreparacione->save($tarea)) {
                        $cantidad_tareas_bad++;
                        //pr($this->TareasAlbaranesclientesreparacione->invalidFields()));
                        //pr($data));
                    }
                } else {
                    $primera_fila = false;
                }
            }
            fclose($handle);
        }
        echo('Migracion de Tareas de Albaranesclientesreparaciones  Finalizada');
        echo('<br/>Total tareas albaranes reparaciones no anadidas: ' . $cantidad_tareas_bad);
    }

    function articulos_tareas_albaranesclientesreparaciones() {
        /*
          SET foreign_key_checks = 0;
          TRUNCATE TABLE `articulos_tareas_albaranesclientesreparaciones`;
         */
        $articulos_bad = 0;
        $path = '../csvs/ALFAMAT-REPARACION1.csv';
        $primera_fila = true;
        if (($handle = fopen($path, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                if (!$primera_fila) {
                    $this->loadModel('ArticulosTareasAlbaranesclientesreparacione');
                    $this->ArticulosTareasAlbaranesclientesreparacione->create();
                    $articulos_tareas_albaranesclientesreparacione = array();
                    $articulo = $this->ArticulosTareasAlbaranesclientesreparacione->Articulo->find('first', array('contain' => array(), 'conditions' => array('Articulo.ref' => $data[2], 'Articulo.almacene_id' => intval($data[1]))));
                    $articulos_tareas_albaranesclientesreparacione['ArticulosTareasAlbaranesclientesreparacione']['articulo_id'] = $articulo['Articulo']['id'];
                    $serie_albaran = $data[5];
                    $albaranesclientesreparacione = $this->ArticulosTareasAlbaranesclientesreparacione->TareasAlbaranesclientesreparacione->Albaranesclientesreparacione->find('first', array('contain' => array(), 'fields' => array('id'), 'conditions' => array('Albaranesclientesreparacione.serie' => $serie_albaran, 'Albaranesclientesreparacione.numero' => intval($data[6]))));
                    $tarea = $this->ArticulosTareasAlbaranesclientesreparacione->TareasAlbaranesclientesreparacione->find('first', array('contain' => array(), 'fields' => array('id'), 'conditions' => array('TareasAlbaranesclientesreparacione.numero' => $data[0], 'TareasAlbaranesclientesreparacione.albaranesclientesreparacione_id' => $albaranesclientesreparacione['Albaranesclientesreparacione']['id'])));
                    $articulos_tareas_albaranesclientesreparacione['ArticulosTareasAlbaranesclientesreparacione']['tareas_albaranesclientesreparacione_id'] = $tarea['TareasAlbaranesclientesreparacione']['id'];
                    $articulos_tareas_albaranesclientesreparacione['ArticulosTareasAlbaranesclientesreparacione']['cantidadreal'] = intval(str_replace(',', '.', $data[8]));
                    $articulos_tareas_albaranesclientesreparacione['ArticulosTareasAlbaranesclientesreparacione']['cantidad'] = intval(str_replace(',', '.', $data[7]));
                    $articulos_tareas_albaranesclientesreparacione['ArticulosTareasAlbaranesclientesreparacione']['cantidad_presupuestada'] = 0;
                    $articulos_tareas_albaranesclientesreparacione['ArticulosTareasAlbaranesclientesreparacione']['descuento'] = str_replace(',', '.', $data[9]);
                    $articulos_tareas_albaranesclientesreparacione['ArticulosTareasAlbaranesclientesreparacione']['articulos_tarea_id'] = null;
                    $articulos_tareas_albaranesclientesreparacione['ArticulosTareasAlbaranesclientesreparacione']['presupuestado'] = 0;
                    $articulos_tareas_albaranesclientesreparacione['ArticulosTareasAlbaranesclientesreparacione']['precio_unidad'] = str_replace(',', '.', $data[13]);

                    if (!$this->ArticulosTareasAlbaranesclientesreparacione->save($articulos_tareas_albaranesclientesreparacione)) {
                        //pr($this->ArticulosTareasAlbaranesclientesreparacione->invalidFields());
                        //pr($data);
                        $articulos_bad++;
                    }
                } else {
                    $primera_fila = false;
                }
            }
            fclose($handle);
        }
        $path = '../csvs/ALFAMAT-REPARACION2.csv';
        $primera_fila = true;
        if (($handle = fopen($path, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                if (!$primera_fila) {
                    $this->loadModel('ArticulosTareasAlbaranesclientesreparacione');
                    $this->ArticulosTareasAlbaranesclientesreparacione->create();
                    $articulos_tareas_albaranesclientesreparacione = array();
                    $articulo = $this->ArticulosTareasAlbaranesclientesreparacione->Articulo->find('first', array('contain' => array(), 'conditions' => array('Articulo.ref' => $data[2], 'Articulo.almacene_id' => intval($data[1]))));
                    $articulos_tareas_albaranesclientesreparacione['ArticulosTareasAlbaranesclientesreparacione']['articulo_id'] = $articulo['Articulo']['id'];
                    $serie_albaran = $data[5];
                    $albaranesclientesreparacione = $this->ArticulosTareasAlbaranesclientesreparacione->TareasAlbaranesclientesreparacione->Albaranesclientesreparacione->find('first', array('contain' => array(), 'fields' => array('id'), 'conditions' => array('Albaranesclientesreparacione.serie' => $serie_albaran, 'Albaranesclientesreparacione.numero' => intval($data[6]))));
                    $tarea = $this->ArticulosTareasAlbaranesclientesreparacione->TareasAlbaranesclientesreparacione->find('first', array('contain' => array(), 'fields' => array('id'), 'conditions' => array('TareasAlbaranesclientesreparacione.numero' => $data[0], 'TareasAlbaranesclientesreparacione.albaranesclientesreparacione_id' => $albaranesclientesreparacione['Albaranesclientesreparacione']['id'])));
                    $articulos_tareas_albaranesclientesreparacione['ArticulosTareasAlbaranesclientesreparacione']['tareas_albaranesclientesreparacione_id'] = $tarea['TareasAlbaranesclientesreparacione']['id'];
                    $articulos_tareas_albaranesclientesreparacione['ArticulosTareasAlbaranesclientesreparacione']['cantidadreal'] = intval(str_replace(',', '.', $data[8]));
                    $articulos_tareas_albaranesclientesreparacione['ArticulosTareasAlbaranesclientesreparacione']['cantidad'] = intval(str_replace(',', '.', $data[7]));
                    $articulos_tareas_albaranesclientesreparacione['ArticulosTareasAlbaranesclientesreparacione']['cantidad_presupuestada'] = 0;
                    $articulos_tareas_albaranesclientesreparacione['ArticulosTareasAlbaranesclientesreparacione']['descuento'] = str_replace(',', '.', $data[9]);
                    $articulos_tareas_albaranesclientesreparacione['ArticulosTareasAlbaranesclientesreparacione']['articulos_tarea_id'] = null;
                    $articulos_tareas_albaranesclientesreparacione['ArticulosTareasAlbaranesclientesreparacione']['presupuestado'] = 0;
                    $articulos_tareas_albaranesclientesreparacione['ArticulosTareasAlbaranesclientesreparacione']['precio_unidad'] = str_replace(',', '.', $data[13]);

                    if (!$this->ArticulosTareasAlbaranesclientesreparacione->save($articulos_tareas_albaranesclientesreparacione)) {
                        //pr($this->ArticulosTareasAlbaranesclientesreparacione->invalidFields());
                        //pr($data);
                        $articulos_bad++;
                    }
                } else {
                    $primera_fila = false;
                }
            }
            fclose($handle);
        }
        echo 'Migracion de Articulos de Tareas de Albaranesclientesreparacione Finalizada <br/>';
        echo 'Total Articulos de Tareas de Albaranesclientesreparacione NO anadidos: ' . $articulos_bad . ' <br/>';
    }

    function tareas_albaranesclientesreparaciones_partes() {
        /*
          SET foreign_key_checks = 0;
          TRUNCATE TABLE `tareas_albaranesclientesreparaciones_partes`;
         */

        $path = '../csvs/ALFAOBRA.csv';
        $partes_bad = 0;
        $primera_fila = true;
        if (($handle = fopen($path, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                if (!$primera_fila) {
                    if (intval($data[0]) >= 800 && intval($data[0]) < 900) {
                        $this->loadModel('TareasAlbaranesclientesreparacionesParte');
                        $this->TareasAlbaranesclientesreparacionesParte->create();
                        $parte = array();
                        $parte['TareasAlbaranesclientesreparacionesParte']['numero'] = 0;
                        $serie_albaran = $data[3];
                        $albaranesclientesreparacione = $this->TareasAlbaranesclientesreparacionesParte->TareasAlbaranesclientesreparacione->Albaranesclientesreparacione->find('first', array('contain' => array(), 'fields' => array('id'), 'conditions' => array('Albaranesclientesreparacione.serie' => $serie_albaran, 'Albaranesclientesreparacione.numero' => intval($data[4]))));
                        if (empty($albaranesclientesreparacione['Albaranesclientesreparacione']['id'])) {
                            // pr($this->TareasAlbaranesclientesreparacionesParte->TareasAlbaranesclientesreparacione->Albaranesclientesreparacione->getLastQuery());
                        }
                        $tarea = $this->TareasAlbaranesclientesreparacionesParte->TareasAlbaranesclientesreparacione->find('first', array('contain' => array(), 'fields' => array('id'), 'conditions' => array('TareasAlbaranesclientesreparacione.numero' => $data[1], 'TareasAlbaranesclientesreparacione.albaranesclientesreparacione_id' => $albaranesclientesreparacione['Albaranesclientesreparacione']['id'])));
                        $parte['TareasAlbaranesclientesreparacionesParte']['tareas_albaranesclientesreparacione_id'] = $tarea['TareasAlbaranesclientesreparacione']['id'];
                        $parte['TareasAlbaranesclientesreparacionesParte']['mecanico_id'] = null;
                        $parte['TareasAlbaranesclientesreparacionesParte']['horasreales'] = doubleval(str_replace(',', '.', $data[7]));
                        $parte['TareasAlbaranesclientesreparacionesParte']['horasimputables'] = doubleval(str_replace(',', '.', $data[6]));
                        $parte['TareasAlbaranesclientesreparacionesParte']['descuento_manodeobra'] = doubleval(str_replace(',', '.', $data[8]));
                        if (empty($data[5]))
                            $parte['TareasAlbaranesclientesreparacionesParte']['operacion'] = 'Operación en Centro de Trabajo';
                        else
                            $parte['TareasAlbaranesclientesreparacionesParte']['operacion'] = $data[5];
                        $parte['TareasAlbaranesclientesreparacionesParte']['preciohoraencentro'] = doubleval(str_replace(',', '.', $data[12]));
                        if (!$this->TareasAlbaranesclientesreparacionesParte->save($parte)) {
                            //pr($data);
                            //pr($this->TareasAlbaranesclientesreparacionesParte->invalidFields());
                            $partes_bad++;
                        }
                    }
                } else {
                    $primera_fila = false;
                }
            }
            fclose($handle);
        }
        echo 'Migracion de Partes en Centro de Trabajo de Tareas de Albaranesclientesreparacione Finalizada';
        echo '<br/>Total de Partes de Centro de Trabajo del Albaran no añadidos: ' . $partes_bad;
    }

    function tareas_albaranesclientesreparaciones_partestalleres() {
        /*
          SET foreign_key_checks = 0;
          TRUNCATE TABLE `tareas_albaranesclientesreparaciones_partestalleres`;
         */

        $path = '../csvs/ALFAOBRA.csv';
        $primera_fila = true;
        $partes_bad = 0;
        if (($handle = fopen($path, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                if (!$primera_fila) {
                    if (intval($data[0]) >= 100 && intval($data[0]) < 200) {
                        $this->loadModel('TareasAlbaranesclientesreparacionesPartestallere');
                        $this->TareasAlbaranesclientesreparacionesPartestallere->create();
                        $parte = array();
                        $parte['TareasAlbaranesclientesreparacionesPartestallere']['numero'] = 0;
                        $serie_albaran = $data[3];
                        $albaranesclientesreparacione = $this->TareasAlbaranesclientesreparacionesPartestallere->TareasAlbaranesclientesreparacione->Albaranesclientesreparacione->find('first', array('contain' => array(), 'fields' => array('id'), 'conditions' => array('Albaranesclientesreparacione.serie' => $serie_albaran, 'Albaranesclientesreparacione.numero' => intval($data[4]))));
                        $tarea = $this->TareasAlbaranesclientesreparacionesPartestallere->TareasAlbaranesclientesreparacione->find('first', array('contain' => array(), 'fields' => array('id'), 'conditions' => array('TareasAlbaranesclientesreparacione.numero' => $data[1], 'TareasAlbaranesclientesreparacione.albaranesclientesreparacione_id' => $albaranesclientesreparacione['Albaranesclientesreparacione']['id'])));
                        if (empty($tarea['TareasAlbaranesclientesreparacione']['id'])) {
                            //pr($this->TareasAlbaranesclientesreparacionesPartestallere->getLastQuery());
                        }
                        $parte['TareasAlbaranesclientesreparacionesPartestallere']['tareas_albaranesclientesreparacione_id'] = $tarea['TareasAlbaranesclientesreparacione']['id'];
                        $parte['TareasAlbaranesclientesreparacionesPartestallere']['mecanico_id'] = null;
                        $parte['TareasAlbaranesclientesreparacionesPartestallere']['horasreales'] = doubleval(str_replace(',', '.', $data[7]));
                        $parte['TareasAlbaranesclientesreparacionesPartestallere']['horasimputables'] = doubleval(str_replace(',', '.', $data[6]));
                        $parte['TareasAlbaranesclientesreparacionesPartestallere']['descuento_manodeobra'] = doubleval(str_replace(',', '.', $data[8]));
                        if (empty($data[5]))
                            $parte['TareasAlbaranesclientesreparacionesPartestallere']['operacion'] = 'Operación en Centro de Trabajo';
                        else
                            $parte['TareasAlbaranesclientesreparacionesPartestallere']['operacion'] = $data[5];
                        $parte['TareasAlbaranesclientesreparacionesPartestallere']['preciohoraentraller'] = doubleval(str_replace(',', '.', $data[12]));

                        if (!$this->TareasAlbaranesclientesreparacionesPartestallere->save($parte)) {
                            // pr($this->TareasAlbaranesclientesreparacionesPartestallere->getLastQuery());
                            //pr($tarea);
                            //pr($data);
                            //pr($this->TareasAlbaranesclientesreparacionesPartestallere->invalidFields());
                            $partes_bad++;
                        }
                    }
                } else {
                    $primera_fila = false;
                }
            }
            fclose($handle);
        }
        echo 'Migracion de Partes en Taller de Tareas de Albaranesclientesreparacione Finalizada';
        echo '<br/>Total de Partes en Taller  de Tareas de Albaranesclientesreparacione no añadidos: ' . $partes_bad;
    }

    /*
     * 
     * PRESUPUESTOS A CLIENTES
     * 
     */

    function presupuestosclientes() {
        /*
          SET foreign_key_checks = 0;
          TRUNCATE TABLE `presupuestosclientes`;
          TRUNCATE TABLE `manodeobras`;
          TRUNCATE TABLE `materiales`;
          TRUNCATE TABLE `tareaspresupuestoclientes`;
          TRUNCATE TABLE `tareaspresupuestoclientes_otrosservicios`;
         */

        $path = '../csvs/PRECAB.csv';
        $primera_fila = true;
        $presupuestosclientes_bad = 0;
        if (($handle = fopen($path, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                if (!$primera_fila) {
                    $this->loadModel('Presupuestoscliente');
                    $this->Presupuestoscliente->create();
                    $presupuestoscliente = array();
                    $presupuestoscliente['Presupuestoscliente']['serie'] = $data[1];
                    $presupuestoscliente['Presupuestoscliente']['numero'] = intval($data[2]);
                    $presupuestoscliente['Presupuestoscliente']['fecha'] = str_fecha_mysql($data[0]);
                    $presupuestoscliente['Presupuestoscliente']['observaciones'] = $data[13];
                    $fecha_del_albaran = new DateTime(str_fecha_mysql($data[0]));
                    $fecha_de_cambio_de_iva = new DateTime("2011-07-1");
                    if ($fecha_del_albaran < $fecha_de_cambio_de_iva)
                        $presupuestoscliente['Presupuestoscliente']['tiposiva_id'] = 11;
                    else
                        $presupuestoscliente['Presupuestoscliente']['tiposiva_id'] = 1;
                    $ordene = $this->Presupuestoscliente->Ordene->find('first', array('contain' => array(), 'conditions' => array('Ordene.fecha' => str_fecha_mysql($data[9]), 'Ordene.numero' => $data[10])));
                    $presupuestoscliente['Presupuestoscliente']['ordene_id'] = $ordene['Ordene']['id'];
                    $cliente = $this->Presupuestoscliente->Cliente->find('first', array('contain' => array('Centrostrabajo'), 'conditions' => array('Cliente.codcli' => $data[3])));
                    $presupuestoscliente['Presupuestoscliente']['cliente_id'] = $cliente['Cliente']['id'];
                    $presupuestoscliente['Presupuestoscliente']['centrostrabajo_id'] = $cliente['Centrostrabajo'][0]['id'];
                    $maquina = $this->Presupuestoscliente->Maquina->find('first', array('contain' => array(), 'conditions' => array('Maquina.codigo' => $data[11])));
                    $presupuestoscliente['Presupuestoscliente']['maquina_id'] = $maquina['Maquina']['id'];
                    $presupuestoscliente['Presupuestoscliente']['comerciale_id'] = null;
                    $presupuestoscliente['Presupuestoscliente']['almacene_id'] = null;
                    $presupuestoscliente['Presupuestoscliente']['fecha_enviado'] = str_fecha_mysql($data[12]);
                    $presupuestoscliente['Presupuestoscliente']['avisar'] = 0;
                    $presupuestoscliente['Presupuestoscliente']['precio'] = str_replace(',', '.', $data[6]);
                    $presupuestoscliente['Presupuestoscliente']['impuestos'] = str_replace(',', '.', $data[7]);
                    $presupuestoscliente['Presupuestoscliente']['confirmado'] = 1;
                    $presupuestoscliente['Presupuestoscliente']['mensajesinformativo_id'] = 1;
                    $presupuestoscliente['Presupuestoscliente']['estadospresupuestoscliente_id'] = 2;
                    if (!$this->Presupuestoscliente->save($presupuestoscliente)) {
                        pr($this->Presupuestoscliente->invalidFields());
                        pr($data);
                        $presupuestosclientes_bad++;
                    }
                } else {
                    $primera_fila = false;
                }
            }
            fclose($handle);
        }
        echo 'Migracion de Presupuestos de clientes Finalizada';
        echo '<br/>Total de Presupuestos de clientes  no añadidos: ' . $presupuestosclientes_bad;
    }

    function tareaspresupuestoclientes() {
        /*
          SET foreign_key_checks = 0;
          TRUNCATE TABLE `tareaspresupuestoclientes`;
         */

        $path = '../csvs/PREDET.csv';
        $primera_fila = true;
        $tareaspresupuestoclientes_bad = 0;
        if (($handle = fopen($path, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                if (!$primera_fila) {
                    $this->loadModel('Tareaspresupuestocliente');
                    $this->Tareaspresupuestocliente->create();
                    $tareaspresupuestocliente = array();
                    $tareaspresupuestocliente['Tareaspresupuestocliente']['numero'] = $data[0];
                    $tareaspresupuestocliente['Tareaspresupuestocliente']['tipo'] = 'repuestos';
                    $tareaspresupuestocliente['Tareaspresupuestocliente']['asunto'] = $data[4];
                    $tareaspresupuestocliente['Tareaspresupuestocliente']['materiales'] = str_replace(',', '.', $data[6]);
                    $tareaspresupuestocliente['Tareaspresupuestocliente']['mano_de_obra'] = str_replace(',', '.', $data[5]);
                    $tareaspresupuestocliente['Tareaspresupuestocliente']['servicios'] = 0;
                    $presupuestoscliente = $this->Tareaspresupuestocliente->Presupuestoscliente->find('first', array('contain' => array(), 'conditions' => array('Presupuestoscliente.serie' => $data[2], 'Presupuestoscliente.numero' => $data[3])));
                    $tareaspresupuestocliente['Tareaspresupuestocliente']['presupuestoscliente_id'] = $presupuestoscliente['Presupuestoscliente']['id'];
                    if (!$this->Tareaspresupuestocliente->save($tareaspresupuestocliente)) {
                        pr($this->Tareaspresupuestocliente->invalidFields());
                        pr($data);
                        $tareaspresupuestoclientes_bad++;
                    }
                } else {
                    $primera_fila = false;
                }
            }
            fclose($handle);
        }
        echo 'Migracion de Tareas de Presupuestos de clientes Finalizada';
        echo '<br/>Total de Tareas de Presupuestos de clientes  no añadidos: ' . $tareaspresupuestoclientes_bad;
    }

    function materiales() {
        /*
          SET foreign_key_checks = 0;
          TRUNCATE TABLE `materiales`;
         */

        $path = '../csvs/PREMATE.csv';
        $primera_fila = true;
        $materiales_bad = 0;
        if (($handle = fopen($path, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                if (!$primera_fila) {
                    $this->loadModel('Materiale');
                    $this->Materiale->create();
                    $materiale = array();
                    $materiale['Materiale']['precio_unidad'] = str_replace(',', '.', $data[9]);
                    $materiale['Materiale']['descuento'] = str_replace(',', '.', $data[5]);
                    $materiale['Materiale']['cantidad'] = str_replace(',', '.', $data[4]);
                    $materiale['Materiale']['importe'] = ($materiale['Materiale']['precio_unidad'] * $materiale['Materiale']['cantidad']) * (1 - $materiale['Materiale']['descuento'] / 100);
                    $articulo = $this->Materiale->Articulo->find('first', array('contain' => array(), 'conditions' => array('Articulo.ref' => $data[0])));
                    $materiale['Materiale']['articulo_id'] = $articulo['Articulo']['id'];
                    if (strlen($data[2]) < 2)
                        $data[2] = '0' . $data[2];
                    $presupuestoscliente = $this->Materiale->Tareaspresupuestocliente->Presupuestoscliente->find('first', array('contain' => array(), 'conditions' => array('Presupuestoscliente.serie' => $data[2], 'Presupuestoscliente.numero' => $data[3])));
                    $Tareaspresupuestocliente = $this->Materiale->Tareaspresupuestocliente->find('first', array('contain' => array(), 'conditions' => array('Tareaspresupuestocliente.numero' => $data[10], 'Tareaspresupuestocliente.presupuestoscliente_id' => $presupuestoscliente['Presupuestoscliente']['id'])));
                    $materiale['Materiale']['tareaspresupuestocliente_id'] = $Tareaspresupuestocliente['Tareaspresupuestocliente']['id'];
                    if (!$this->Materiale->save($materiale)) {
                        pr($this->Materiale->invalidFields());
                        pr($data);
                        $materiales_bad++;
                    }
                } else {
                    $primera_fila = false;
                }
            }
            fclose($handle);
        }
        echo 'Migracion de Materiales de Tareas de Presupuestos de clientes Finalizada';
        echo '<br/>Total de Materiales de Tareas de Presupuestos de clientes  no añadidos: ' . $materiales_bad;
    }

    function manodeobras() {
        /*
          SET foreign_key_checks = 0;
          TRUNCATE TABLE `manodeobras`;
         */

        $path = '../csvs/PREOBRA.csv';
        $primera_fila = true;
        $manodeobras_bad = 0;
        if (($handle = fopen($path, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                if (!$primera_fila) {
                    $this->loadModel('Manodeobra');
                    $this->Manodeobra->create();
                    $manodeobra = array();
                    $manodeobra['Manodeobra']['horas'] = str_replace(',', '.', $data[5]);
                    $manodeobra['Manodeobra']['precio_hora'] = str_replace(',', '.', $data[10]);
                    $manodeobra['Manodeobra']['descuento'] = str_replace(',', '.', $data[6]);
                    $manodeobra['Manodeobra']['descripcion'] = $data[4];
                    $manodeobra['Manodeobra']['importe'] = ($manodeobra['Manodeobra']['precio_hora'] * $manodeobra['Manodeobra']['horas']) * (1 - $manodeobra['Manodeobra']['descuento'] / 100);
                    $presupuestoscliente = $this->Manodeobra->Tareaspresupuestocliente->Presupuestoscliente->find('first', array('contain' => array(), 'conditions' => array('Presupuestoscliente.serie' => $data[2], 'Presupuestoscliente.numero' => $data[3])));
                    $Tareaspresupuestocliente = $this->Manodeobra->Tareaspresupuestocliente->find('first', array('contain' => array(), 'conditions' => array('Tareaspresupuestocliente.numero' => $data[11], 'Tareaspresupuestocliente.presupuestoscliente_id' => $presupuestoscliente['Presupuestoscliente']['id'])));
                    $manodeobra['Manodeobra']['tareaspresupuestocliente_id'] = $Tareaspresupuestocliente['Tareaspresupuestocliente']['id'];
                    if (!$this->Manodeobra->save($manodeobra)) {
                        pr($this->Manodeobra->invalidFields());
                        pr($data);
                        $manodeobras_bad++;
                    }
                } else {
                    $primera_fila = false;
                }
            }
            fclose($handle);
        }
        echo 'Migracion de Manodeobras de Tareas de Presupuestos de clientes Finalizada';
        echo '<br/>Total de Manodeobras de Tareas de Presupuestos de clientes  no añadidos: ' . $manodeobras_bad;
    }

    function tareaspresupuestoclientes_otrosservicios() {
        /*
          SET foreign_key_checks = 0;
          TRUNCATE TABLE `tareaspresupuestoclientes_otrosservicios`;
         */

        $path = '../csvs/PRECAB.csv';
        $primera_fila = true;
        $tareaspresupuestoclientes_otrosservicios_bad = 0;
        if (($handle = fopen($path, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                if (!$primera_fila) {

                    /* Primero creamos la tarea para los Otros Servicios */

                    $this->loadModel('Tareaspresupuestocliente');
                    $this->Tareaspresupuestocliente->create();
                    $tareaspresupuestocliente = array();
                    $tareaspresupuestocliente['Tareaspresupuestocliente']['numero'] = 99;
                    $tareaspresupuestocliente['Tareaspresupuestocliente']['tipo'] = 'centro';
                    $tareaspresupuestocliente['Tareaspresupuestocliente']['asunto'] = 'Otros Servicios';
                    $tareaspresupuestocliente['Tareaspresupuestocliente']['materiales'] = 0;
                    $tareaspresupuestocliente['Tareaspresupuestocliente']['mano_de_obra'] = 0;
                    $tareaspresupuestocliente['Tareaspresupuestocliente']['servicios'] = 0;
                    $presupuestoscliente = $this->Tareaspresupuestocliente->Presupuestoscliente->find('first', array('contain' => array(), 'conditions' => array('Presupuestoscliente.serie' => $data[1], 'Presupuestoscliente.numero' => $data[2])));
                    $tareaspresupuestocliente['Tareaspresupuestocliente']['presupuestoscliente_id'] = $presupuestoscliente['Presupuestoscliente']['id'];
                    $this->Tareaspresupuestocliente->save($tareaspresupuestocliente);

                    /* Ahora añadimos a la tarea los Otros Servicios */

                    $this->loadModel('TareaspresupuestoclientesOtrosservicio');
                    $this->TareaspresupuestoclientesOtrosservicio->create();
                    $TareaspresupuestoclientesOtrosservicio = array();
                    $TareaspresupuestoclientesOtrosservicio['TareaspresupuestoclientesOtrosservicio']['desplazamiento'] = 0;
                    $TareaspresupuestoclientesOtrosservicio['TareaspresupuestoclientesOtrosservicio']['manoobradesplazamiento'] = doubleval(str_replace(',', '.', $data[20])) * doubleval(str_replace(',', '.', $data[21]));
                    $TareaspresupuestoclientesOtrosservicio['TareaspresupuestoclientesOtrosservicio']['kilometraje'] = doubleval(str_replace(',', '.', $data[22])) * doubleval(str_replace(',', '.', $data[23]));
                    $TareaspresupuestoclientesOtrosservicio['TareaspresupuestoclientesOtrosservicio']['dietas'] = doubleval(str_replace(',', '.', $data[24]));
                    $TareaspresupuestoclientesOtrosservicio['TareaspresupuestoclientesOtrosservicio']['varios'] = doubleval(str_replace(',', '.', $data[15]));
                    $TareaspresupuestoclientesOtrosservicio['TareaspresupuestoclientesOtrosservicio']['varios_descripcion'] = 'Portes';
                    $TareaspresupuestoclientesOtrosservicio['TareaspresupuestoclientesOtrosservicio']['total'] = $TareaspresupuestoclientesOtrosservicio['TareaspresupuestoclientesOtrosservicio']['manoobradesplazamiento'] + $TareaspresupuestoclientesOtrosservicio['TareaspresupuestoclientesOtrosservicio']['kilometraje'] + $TareaspresupuestoclientesOtrosservicio['TareaspresupuestoclientesOtrosservicio']['dietas'] + $TareaspresupuestoclientesOtrosservicio['TareaspresupuestoclientesOtrosservicio']['varios'];
                    $TareaspresupuestoclientesOtrosservicio['TareaspresupuestoclientesOtrosservicio']['tareaspresupuestocliente_id'] = $this->Tareaspresupuestocliente->id;
                    if (!$this->TareaspresupuestoclientesOtrosservicio->save($TareaspresupuestoclientesOtrosservicio)) {
                        pr($this->TareaspresupuestoclientesOtrosservicio->getLastQuery());
                        pr($this->TareaspresupuestoclientesOtrosservicio->invalidFields());
                        pr($data);
                        $tareaspresupuestoclientes_otrosservicios_bad++;
                    }
                } else {
                    $primera_fila = false;
                }
            }
            fclose($handle);
        }
        echo 'Migracion de Otros Servicios de Tareas de PRESUPUESTOS de CLIENTES Finalizada';
        echo '<br/>Total de Otros Servicios de Tareas de PRESUPUESTOS de CLIENTES  no añadidos: ' . $tareaspresupuestoclientes_otrosservicios_bad;
    }

    /*
     * PEDIDOS DE CLIENTES
     *
     * 
      SET foreign_key_checks = 0;
      TRUNCATE TABLE `pedidosclientes`;
      TRUNCATE TABLE `tareaspedidosclientes`;
      TRUNCATE TABLE `materiales_tareaspedidosclientes`;
      TRUNCATE TABLE `manodeobras_tareaspedidosclientes`;
      TRUNCATE TABLE `tareaspedidosclientes_otrosservicios`;
     */


    /*
     * ALBARANES DE REPUESTOS
     */

    function albaranescliente() {
        /*
          SET foreign_key_checks = 0;
          TRUNCATE TABLE `albaranesclientes`;
          TRUNCATE TABLE `tareasalbaranesclientes`;
          TRUNCATE TABLE `materiales_tareasalbaranesclientes`;
          TRUNCATE TABLE `manodeobras_tareasalbaranesclientes`;
          TRUNCATE TABLE `tareasalbaranesclientes_otrosservicios`;
         */
        $cantidad_albaranes_bad = 0;
        $cantidad_albaranestot_bad = 0;
        $path = '../csvs/ALFACAB-VENTA.csv';
        $primera_fila = true;
        $this->loadModel('Albaranescliente');

        if (($handle = fopen($path, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                if (!$primera_fila) {
                    $this->Albaranescliente->create();
                    $albaranescliente = array();
                    $albaranescliente['Albaranescliente']['serie'] = $data[1];
                    $albaranescliente['Albaranescliente']['numero'] = intval($data[2]);
                    $albaranescliente['Albaranescliente']['fecha'] = str_fecha_mysql($data[0]);
                    $albaranescliente['Albaranescliente']['observaciones'] = $data[17];
                    $albaranescliente['Albaranescliente']['albaranescaneado'] = '';
                    $albaranescliente['Albaranescliente']['facturable'] = 1;
                    $fecha_del_albaran = new DateTime(str_fecha_mysql($data[0]));
                    $fecha_de_cambio_de_iva = new DateTime("2011-07-1");
                    if ($fecha_del_albaran < $fecha_de_cambio_de_iva)
                        $albaranescliente['Albaranescliente']['tiposiva_id'] = 11;
                    else
                        $albaranescliente['Albaranescliente']['tiposiva_id'] = 1;
                    $cliente = $this->Albaranescliente->Cliente->find('first', array('contain' => array('Centrostrabajo'), 'conditions' => array('Cliente.codcli' => $data[4])));
                    $albaranescliente['Albaranescliente']['cliente_id'] = $cliente['Cliente']['id'];
                    $albaranescliente['Albaranescliente']['centrostrabajo_id'] = $cliente['Centrostrabajo'][0]['id'];
                    $maquina = $this->Albaranescliente->Maquina->find('first', array('contain' => array(), 'conditions' => array('Maquina.codigo' => $data[11])));
                    $albaranescliente['Albaranescliente']['maquina_id'] = $maquina['Maquina']['id'];
                    $almacene = $this->Albaranescliente->Almacene->find('first', array('contain' => array(), 'conditions' => array('Almacene.codalm' => $data[3])));
                    $albaranescliente['Albaranescliente']['almacene_id'] = $almacene['Almacene']['id'];
                    $albaranescliente['Albaranescliente']['facturas_cliente_id'] = null; // Al añadir las facturas hay que actualizar
                    $albaranescliente['Albaranescliente']['es_devolucion'] = 0;
                    $albaranescliente['Albaranescliente']['numero_aceptacion_aportado'] = '';
                    $albaranescliente['Albaranescliente']['comerciale_id'] = null;
                    $albaranescliente['Albaranescliente']['centrosdecoste_id'] = null;
                    $albaranescliente['Albaranescliente']['estadosalbaranescliente_id'] = 3;
                    if (!$this->Albaranescliente->save($albaranescliente)) {
                        //pr($this->Albaranescliente->invalidFields());
                        //pr($data);
                        $cantidad_albaranes_bad++;
                    }
                } else {
                    $primera_fila = false;
                }
            }
            fclose($handle);
        }
        // ahora tenemos que ponerle la base imponible que se encuentra  en otro archivo: ALFATOT
        $path = '../csvs/ALFATOT.csv';
        $primera_fila = true;
        if (($handle = fopen($path, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                if (!$primera_fila && $data[0] == 'A') {
                    $this->loadModel('Albaranescliente');
                    $albaranescliente = $this->Albaranescliente->find('first', array('fields' => array('id'), 'contain' => array(), 'conditions' => array('Albaranescliente.serie' => $data[2], 'Albaranescliente.numero' => intval($data[3]))));
                    if (!empty($albaranescliente['Albaranescliente']['id'])) {
                        $this->Albaranescliente->id = $albaranescliente['Albaranescliente']['id'];
                        $this->Albaranescliente->saveField('baseimponible', str_replace(',', '.', $data[7]));
                    } else {
                        //pr($data);
                        $cantidad_albaranestot_bad++;
                    }
                } else {
                    $primera_fila = false;
                }
            }
            fclose($handle);
        }
        // Fin
        echo('Migracion de Albranes de Repuestos ( Ordenes )  Finalizada');
        echo '<br/>Cantidad de ALFACAB Repuestos No añadida: ' . $cantidad_albaranes_bad;
        echo '<br/>Cantidad de AFATOT No añadida: ' . $cantidad_albaranestot_bad;
    }

    function tareasalbaranesclientes() {
        /*
          SET foreign_key_checks = 0;
          TRUNCATE TABLE `tareasalbaranesclientes`;
         */
        $cantidad_tareas_bad = 0;
        $path = '../csvs/ALFADET-VENTA.csv';
        $primera_fila = true;
        $this->loadModel('Tareasalbaranescliente');
        if (($handle = fopen($path, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                if (!$primera_fila) {

                    $this->Tareasalbaranescliente->create();
                    $tarea = array();
                    $tarea['Tareasalbaranescliente']['numero'] = $data[0];
                    $tarea['Tareasalbaranescliente']['tipo'] = 'repuestos';
                    $tarea['Tareasalbaranescliente']['asunto'] = $data[4];
                    $tarea['Tareasalbaranescliente']['mano_de_obra'] = doubleval(str_replace(',', '.', $data[5]));
                    $tarea['Tareasalbaranescliente']['materiales'] = doubleval(str_replace(',', '.', $data[6]));
                    $tarea['Tareasalbaranescliente']['servicios'] = 0;
                    $conditions = array('Albaranescliente.serie' => $data[2], 'Albaranescliente.numero' => intval($data[3]));
                    $albaranescliente = $this->Tareasalbaranescliente->Albaranescliente->find('first', array('contain' => array(), 'conditions' => $conditions));
                    if (empty($albaranescliente['Albaranescliente']['id'])) {
                        //pr($conditions);
                    }
                    $tarea['Tareasalbaranescliente']['albaranescliente_id'] = $albaranescliente['Albaranescliente']['id'];
                    //Se tiene que desactivar afterSave
                    if (!$this->Tareasalbaranescliente->save($tarea)) {
                        $cantidad_tareas_bad++;
                        //pr($this->Tareasalbaranescliente->invalidFields());
                        // pr($data);
                    }
                } else {
                    $primera_fila = false;
                }
            }
            fclose($handle);
        }
        echo('Migracion de Tareas de Albaranes Repuestos Finalizada');
        echo('<br/>Total tareas Albaranes  Repuestos  no anadidas: ' . $cantidad_tareas_bad);
    }

    function materiales_tareasalbaranesclientes() {
        /*
          SET foreign_key_checks = 0;
          TRUNCATE TABLE `materiales_tareasalbaranesclientes`;
         */
        $materiales_bad = 0;

        $path = '../csvs/ALFAMAT-VENTA1.csv';
        $primera_fila = true;
        $this->loadModel('MaterialesTareasalbaranescliente');
        if (($handle = fopen($path, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                if (!$primera_fila) {

                    $this->MaterialesTareasalbaranescliente->create();
                    $materiale = array();
                    $materiale['MaterialesTareasalbaranescliente']['precio_unidad'] = str_replace(',', '.', $data[13]);
                    $materiale['MaterialesTareasalbaranescliente']['descuento'] = str_replace(',', '.', $data[9]);
                    $materiale['MaterialesTareasalbaranescliente']['cantidad'] = str_replace(',', '.', $data[7]);
                    $materiale['MaterialesTareasalbaranescliente']['importe'] = ($materiale['MaterialesTareasalbaranescliente']['precio_unidad'] * $materiale['MaterialesTareasalbaranescliente']['cantidad']) * (1 - $materiale['MaterialesTareasalbaranescliente']['descuento'] / 100);
                    $articulo = $this->MaterialesTareasalbaranescliente->Articulo->find('first', array('contain' => array(), 'conditions' => array('Articulo.ref' => $data[2], 'Articulo.almacene_id' => intval($data[1]))));
                    $materiale['MaterialesTareasalbaranescliente']['articulo_id'] = $articulo['Articulo']['id'];
                    $albaranescliente = $this->MaterialesTareasalbaranescliente->Tareasalbaranescliente->Albaranescliente->find('first', array('contain' => array(), 'conditions' => array('Albaranescliente.serie' => $data[5], 'Albaranescliente.numero' => $data[6])));
                    $tareasalbaranescliente = $this->MaterialesTareasalbaranescliente->Tareasalbaranescliente->find('first', array('contain' => array(), 'conditions' => array('Tareasalbaranescliente.numero' => $data[0], 'Tareasalbaranescliente.albaranescliente_id' => $albaranescliente['Albaranescliente']['id'])));
                    $materiale['MaterialesTareasalbaranescliente']['tareasalbaranescliente_id'] = $tareasalbaranescliente['Tareasalbaranescliente']['id'];
                    if (!$this->MaterialesTareasalbaranescliente->save($materiale)) {
                        pr($this->MaterialesTareasalbaranescliente->invalidFields());
                        pr($data);
                        $materiales_bad++;
                    }
                } else {
                    $primera_fila = false;
                }
            }
            fclose($handle);
        }

        $path = '../csvs/ALFAMAT-VENTA2.csv';
        $primera_fila = true;
        $this->loadModel('MaterialesTareasalbaranescliente');
        if (($handle = fopen($path, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                if (!$primera_fila) {

                    $this->MaterialesTareasalbaranescliente->create();
                    $materiale = array();
                    $materiale['MaterialesTareasalbaranescliente']['precio_unidad'] = str_replace(',', '.', $data[13]);
                    $materiale['MaterialesTareasalbaranescliente']['descuento'] = str_replace(',', '.', $data[9]);
                    $materiale['MaterialesTareasalbaranescliente']['cantidad'] = str_replace(',', '.', $data[7]);
                    $materiale['MaterialesTareasalbaranescliente']['importe'] = ($materiale['MaterialesTareasalbaranescliente']['precio_unidad'] * $materiale['MaterialesTareasalbaranescliente']['cantidad']) * (1 - $materiale['MaterialesTareasalbaranescliente']['descuento'] / 100);
                    $articulo = $this->MaterialesTareasalbaranescliente->Articulo->find('first', array('contain' => array(), 'conditions' => array('Articulo.ref' => $data[2], 'Articulo.almacene_id' => intval($data[1]))));
                    $materiale['MaterialesTareasalbaranescliente']['articulo_id'] = $articulo['Articulo']['id'];
                    $albaranescliente = $this->MaterialesTareasalbaranescliente->Tareasalbaranescliente->Albaranescliente->find('first', array('contain' => array(), 'conditions' => array('Albaranescliente.serie' => $data[5], 'Albaranescliente.numero' => $data[6])));
                    $tareasalbaranescliente = $this->MaterialesTareasalbaranescliente->Tareasalbaranescliente->find('first', array('contain' => array(), 'conditions' => array('Tareasalbaranescliente.numero' => $data[0], 'Tareasalbaranescliente.albaranescliente_id' => $albaranescliente['Albaranescliente']['id'])));
                    $materiale['MaterialesTareasalbaranescliente']['tareasalbaranescliente_id'] = $tareasalbaranescliente['Tareasalbaranescliente']['id'];
                    if (!$this->MaterialesTareasalbaranescliente->save($materiale)) {
                        pr($this->MaterialesTareasalbaranescliente->invalidFields());
                        pr($data);
                        $materiales_bad++;
                    }
                } else {
                    $primera_fila = false;
                }
            }
            fclose($handle);
        }
        echo 'Migracion de Materiales de Tareas de Albaranesclientes Repuestos de clientes Finalizada';
        echo '<br/>Total de Materiales de Tareas de Albaranesclientes Repuestos de clientes  no añadidos: ' . $materiales_bad;
    }

    function tareasalbaranesclientes_otrosservicios() {
        /*
          SET foreign_key_checks = 0;
          TRUNCATE TABLE `tareasalbaranesclientes_otrosservicios`;
         */

        $path = '../csvs/ALFACAB-VENTA.csv';
        $primera_fila = true;
        $tareasalbaranesclientes_otrosservicios_bad = 0;
        $this->loadModel('Tareasalbaranescliente');
        $this->loadModel('TareasalbaranesclientesOtrosservicio');
        if (($handle = fopen($path, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                if (!$primera_fila) {

                    /* Primero creamos la tarea para los Otros Servicios */


                    $this->Tareasalbaranescliente->create();
                    $tareasalbaranescliente = array();
                    $tareasalbaranescliente['Tareasalbaranescliente']['numero'] = 99;
                    $tareasalbaranescliente['Tareasalbaranescliente']['tipo'] = 'centro';
                    $tareasalbaranescliente['Tareasalbaranescliente']['asunto'] = 'Otros Servicios';
                    $tareasalbaranescliente['Tareasalbaranescliente']['materiales'] = 0;
                    $tareasalbaranescliente['Tareasalbaranescliente']['mano_de_obra'] = 0;
                    $tareasalbaranescliente['Tareasalbaranescliente']['servicios'] = 0;
                    $albaranescliente = $this->Tareasalbaranescliente->Albaranescliente->find('first', array('contain' => array(), 'conditions' => array('Albaranescliente.serie' => $data[1], 'Albaranescliente.numero' => $data[2])));
                    $tareasalbaranescliente['Tareasalbaranescliente']['albaranescliente_id'] = $albaranescliente['Albaranescliente']['id'];
                    $this->Tareasalbaranescliente->save($tareasalbaranescliente);

                    /* Ahora añadimos a la tarea los Otros Servicios */


                    $this->TareasalbaranesclientesOtrosservicio->create();
                    $TareasalbaranesclientesOtrosservicio = array();
                    $TareasalbaranesclientesOtrosservicio['TareasalbaranesclientesOtrosservicio']['desplazamiento'] = 0;
                    $TareasalbaranesclientesOtrosservicio['TareasalbaranesclientesOtrosservicio']['manoobradesplazamiento'] = doubleval(str_replace(',', '.', $data[20])) * doubleval(str_replace(',', '.', $data[21]));
                    $TareasalbaranesclientesOtrosservicio['TareasalbaranesclientesOtrosservicio']['kilometraje'] = doubleval(str_replace(',', '.', $data[22])) * doubleval(str_replace(',', '.', $data[23]));
                    $TareasalbaranesclientesOtrosservicio['TareasalbaranesclientesOtrosservicio']['dietas'] = doubleval(str_replace(',', '.', $data[28]));
                    $TareasalbaranesclientesOtrosservicio['TareasalbaranesclientesOtrosservicio']['varios'] = doubleval(str_replace(',', '.', $data[34]));
                    $TareasalbaranesclientesOtrosservicio['TareasalbaranesclientesOtrosservicio']['varios_descripcion'] = 'Portes';
                    $TareasalbaranesclientesOtrosservicio['TareasalbaranesclientesOtrosservicio']['total'] = $TareasalbaranesclientesOtrosservicio['TareasalbaranesclientesOtrosservicio']['manoobradesplazamiento'] + $TareasalbaranesclientesOtrosservicio['TareasalbaranesclientesOtrosservicio']['kilometraje'] + $TareasalbaranesclientesOtrosservicio['TareasalbaranesclientesOtrosservicio']['dietas'] + $TareasalbaranesclientesOtrosservicio['TareasalbaranesclientesOtrosservicio']['varios'];
                    $TareasalbaranesclientesOtrosservicio['TareasalbaranesclientesOtrosservicio']['tareasalbaranescliente_id'] = $this->Tareasalbaranescliente->id;
                    if (!$this->TareasalbaranesclientesOtrosservicio->save($TareasalbaranesclientesOtrosservicio)) {
                        pr($this->TareasalbaranesclientesOtrosservicio->getLastQuery());
                        pr($this->TareasalbaranesclientesOtrosservicio->invalidFields());
                        pr($data);
                        $tareasalbaranesclientes_otrosservicios_bad++;
                    }
                } else {
                    $primera_fila = false;
                }
            }
            fclose($handle);
        }
        echo 'Migracion de Otros Servicios de Tareas de Albaranes de Repuestos Finalizada';
        echo '<br/>Total de Otros Servicios de Tareas de Albaranes de Repuestos  no añadidos: ' . $tareasalbaranesclientes_otrosservicios_bad;
    }

    /*
     * FACTURAS DE CLIENTE - VENTA
     */

    function facturas_clientes() {
        /*
          SET foreign_key_checks = 0;
          TRUNCATE TABLE `facturas_clientes`;
         */
        $facturas_clientes_bad = 0;
        $this->loadModel('FacturasCliente');
        $this->loadModel('Albaranescliente');
        $this->loadModel('Albaranesclientesreparacione');

        /*
         * Albaranes de Repuestos
         * 
         *//*
          $primera_fila = true;
          $path = '../csvs/ALFACAB-VENTA.csv';
          if (($handle = fopen($path, "r")) !== FALSE) {
          while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
          if (!$primera_fila) {

          $albaranescliente = $this->Albaranescliente->find('first', array('contain' => array(), 'conditions' => array('Albaranescliente.serie' => $data[1], 'Albaranescliente.numero' => $data[2])));
          // Si esta facturado
          if (!empty($data[19]) && !empty($data[30])) {
          //Comprobamos que no exista ya una factura:
          $facturas_cliente = $this->FacturasCliente->find('first', array('contain' => array(), 'conditions' => array('FacturasCliente.serie' => $data[30], 'FacturasCliente.numero' => $data[19])));
          if (empty($facturas_cliente)) {
          //No existe la factura
          $this->FacturasCliente->create();
          $FacturasCliente = array();
          $FacturasCliente['FacturasCliente']['serie'] = $data[30];
          $FacturasCliente['FacturasCliente']['numero'] = intval($data[19]);
          $FacturasCliente['FacturasCliente']['fecha'] = str_fecha_mysql($data[18]);
          $FacturasCliente['FacturasCliente']['observaciones'] = '-';
          $FacturasCliente['FacturasCliente']['facturaescaneada'] = '';
          $FacturasCliente['FacturasCliente']['baseimponible'] = 0; // Se rellena despues con ALFATOT tipo F
          $FacturasCliente['FacturasCliente']['impuestos'] = 0; // Se rellena despues con ALFATOT tipo F
          $FacturasCliente['FacturasCliente']['total'] = 0; // Se rellena despues con ALFATOT tipo F
          $cliente = $this->FacturasCliente->Cliente->find('first', array('contain' => array(), 'conditions' => array('Cliente.codcli' => $data[4])));
          $FacturasCliente['FacturasCliente']['cliente_id'] = $cliente['Cliente']['id'];
          $FacturasCliente['FacturasCliente']['estadosfacturascliente_id'] = 2;
          if (!$this->FacturasCliente->save($FacturasCliente)) {
          pr($this->FacturasCliente->invalidFields());
          pr($data);
          $facturas_clientes_bad++;
          }
          $this->Albaranescliente->id = $albaranescliente['Albaranescliente']['id'];
          $this->Albaranescliente->saveField('facturas_cliente_id', $this->FacturasCliente->id);
          $this->Albaranescliente->saveField('facturable', 0);
          } else {
          // Si existe la factura
          $this->Albaranescliente->id = $albaranescliente['Albaranescliente']['id'];
          $this->Albaranescliente->saveField('facturas_cliente_id', $facturas_cliente['FacturasCliente']['id']);
          $this->Albaranescliente->saveField('facturable', 0);
          }
          }
          } else {
          $primera_fila = false;
          }
          }
          fclose($handle);
          } */
        /*
         * Albaranes de Rearacion 
         * 
         */
        $primera_fila = true;
        $path = '../csvs/ALFACAB-REPARACION.csv';
        if (($handle = fopen($path, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                if (!$primera_fila) {

                    $albaranescliente = $this->Albaranesclientesreparacione->find('first', array('contain' => array(), 'conditions' => array('Albaranesclientesreparacione.serie' => $data[1], 'Albaranesclientesreparacione.numero' => $data[2])));
                    // Si esta facturado
                    if (!empty($data[19]) && !empty($data[30])) {
                        //Comprobamos que no exista ya una factura:
                        $facturas_cliente = $this->FacturasCliente->find('first', array('contain' => array(), 'conditions' => array('FacturasCliente.serie' => $data[30], 'FacturasCliente.numero' => $data[19])));
                        if (empty($facturas_cliente)) {
                            //No existe la factura
                            $this->FacturasCliente->create();
                            $FacturasCliente = array();
                            $FacturasCliente['FacturasCliente']['serie'] = $data[30];
                            $FacturasCliente['FacturasCliente']['numero'] = intval($data[19]);
                            $FacturasCliente['FacturasCliente']['fecha'] = str_fecha_mysql($data[18]);
                            $FacturasCliente['FacturasCliente']['observaciones'] = '-';
                            $FacturasCliente['FacturasCliente']['facturaescaneada'] = '';
                            $FacturasCliente['FacturasCliente']['baseimponible'] = 0; // Se rellena despues con ALFATOT tipo F
                            $FacturasCliente['FacturasCliente']['impuestos'] = 0; // Se rellena despues con ALFATOT tipo F
                            $FacturasCliente['FacturasCliente']['total'] = 0; // Se rellena despues con ALFATOT tipo F
                            $cliente = $this->FacturasCliente->Cliente->find('first', array('contain' => array(), 'conditions' => array('Cliente.codcli' => $data[4])));
                            $FacturasCliente['FacturasCliente']['cliente_id'] = $cliente['Cliente']['id'];
                            $FacturasCliente['FacturasCliente']['estadosfacturascliente_id'] = 2;
                            if (!$this->FacturasCliente->save($FacturasCliente)) {
                                pr($this->FacturasCliente->invalidFields());
                                pr($data);
                                $facturas_clientes_bad++;
                            }
                            $this->Albaranesclientesreparacione->id = $albaranescliente['Albaranesclientesreparacione']['id'];
                            $this->Albaranesclientesreparacione->saveField('facturas_cliente_id', $this->FacturasCliente->id);
                            $this->Albaranesclientesreparacione->saveField('facturable', 0);
                        } else {
                            // Si existe la factura
                            $this->Albaranesclientesreparacione->id = $albaranescliente['Albaranesclientesreparacione']['id'];
                            $this->Albaranesclientesreparacione->saveField('facturas_cliente_id', $facturas_cliente['FacturasCliente']['id']);
                            $this->Albaranesclientesreparacione->saveField('facturable', 0);
                        }
                    }
                } else {
                    $primera_fila = false;
                }
            }
            fclose($handle);
        }
        /*
         * COMPLETAMOS 
         * 
         */
        $primera_fila = true;
        $path = '../csvs/ALFATOT.csv';
        if (($handle = fopen($path, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                if (!$primera_fila) {
                    if ($data[0] == 'F') {
                        //Comprobamos que exista ya una factura:
                        $facturas_cliente = $this->FacturasCliente->find('first', array('contain' => array(), 'conditions' => array('FacturasCliente.serie' => $data[2], 'FacturasCliente.numero' => $data[3])));
                        if (!empty($facturas_cliente)) {
                            // Si existe la factura
                            $this->FacturasCliente->id = $facturas_cliente['FacturasCliente']['id'];
                            $this->FacturasCliente->saveField('baseimponible', doubleval(str_replace(',', '.', $data[7])));
                            $this->FacturasCliente->saveField('impuestos', doubleval(str_replace(',', '.', $data[8])));
                            $this->FacturasCliente->saveField('total', doubleval(str_replace(',', '.', $data[7])) + doubleval(str_replace(',', '.', $data[8])));
                        }
                    }
                } else {
                    $primera_fila = false;
                }
            }
            fclose($handle);
        }
        echo 'Migracion de Facturas De Cliente Finalizada';
        echo '<br/>Total de Facturas De Cliente no añadidos: ' . $facturas_clientes_bad;
    }

    /*
     * PRESUPUESTOS PROVEEDORES
     * 
     * 
      SET foreign_key_checks = 0;
      TRUNCATE TABLE `presupuestosproveedores`;
      TRUNCATE TABLE `articulos_presupuestosproveedores`;
     */

    /*
     * PEDIDOS PROVEEDORES
     */

    function pedidosproveedores() {
        /*
          SET foreign_key_checks = 0;
          TRUNCATE TABLE `pedidosproveedores`;
          TRUNCATE TABLE `articulos_pedidosproveedores`;
         */
        $pedidosproveedores_bad = 0;
        $path = '../csvs/PEDCOMC.csv';
        $primera_fila = true;
        $this->loadModel('Pedidosproveedore');

        if (($handle = fopen($path, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                if (!$primera_fila) {
                    $this->Pedidosproveedore->create();
                    $pedidosproveedore = array();
                    $pedidosproveedore['Pedidosproveedore']['serie'] = $data[2];
                    $pedidosproveedore['Pedidosproveedore']['numero'] = intval($data[3]);
                    $pedidosproveedore['Pedidosproveedore']['fecha'] = str_fecha_mysql($data[1]);
                    $fecha_del_albaran = new DateTime(str_fecha_mysql($data[1]));
                    $fecha_de_cambio_de_iva = new DateTime("2011-07-1");
                    if ($fecha_del_albaran < $fecha_de_cambio_de_iva)
                        $pedidosproveedore['Pedidosproveedore']['tiposiva_id'] = 11;
                    else
                        $pedidosproveedore['Pedidosproveedore']['tiposiva_id'] = 1;
                    $pedidosproveedore['Pedidosproveedore']['observaciones'] = $data[18];
                    $pedidosproveedore['Pedidosproveedore']['pedidoescaneado'] = '';
                    $pedidosproveedore['Pedidosproveedore']['confirmado'] = 1;
                    $pedidosproveedore['Pedidosproveedore']['fecharecepcion'] = str_fecha_mysql($data[16]);
                    $proveedore = $this->Pedidosproveedore->Proveedore->find('first', array('contain' => array(), 'conditions' => array('Proveedore.codpro' => $data[5])));
                    $pedidosproveedore['Pedidosproveedore']['proveedore_id'] = $proveedore['Proveedore']['id'];
                    $almacene = $this->Pedidosproveedore->Almacene->find('first', array('contain' => array(), 'conditions' => array('Almacene.codalm' => intval($data[0]))));
                    $pedidosproveedore['Pedidosproveedore']['almacene_id'] = $almacene['Almacene']['id'];
                    $pedidosproveedore['Pedidosproveedore']['estadospedidosproveedore_id'] = 3;
                    if (!$this->Pedidosproveedore->save($pedidosproveedore)) {
                        //pr($this->Pedidosproveedore->invalidFields());
                        //pr($data);
                        $pedidosproveedores_bad++;
                    }
                } else {
                    $primera_fila = false;
                }
            }
            fclose($handle);
        }
        // Fin
        echo('Migracion de Pedidos de Proveedore Finalizada');
        echo '<br/>Cantidad de Pedidos de Proveedores  No anadido: ' . $pedidosproveedores_bad;
    }

    function articulos_pedidosproveedores() {
        /*
          SET foreign_key_checks = 0;
          TRUNCATE TABLE `articulos_pedidosproveedores`;
         */
        $ArticulosPedidosproveedore_bad = 0;
        $path = '../csvs/PEDCOMD.csv';
        $primera_fila = true;
        $this->loadModel('ArticulosPedidosproveedore');

        if (($handle = fopen($path, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                if (!$primera_fila) {
                    $this->ArticulosPedidosproveedore->create();
                    $ArticulosPedidosproveedore = array();
                    $articulo = $this->ArticulosPedidosproveedore->Articulo->find('first', array('contain' => array(), 'conditions' => array('Articulo.ref' => $data[1], 'Articulo.almacene_id' => $data[0])));
                    $ArticulosPedidosproveedore['ArticulosPedidosproveedore']['articulo_id'] = $articulo['Articulo']['id'];
                    if (is_numeric($data[4]))
                        $data[4] = intval($data[4]);
                    $pedidosproveedore = $this->ArticulosPedidosproveedore->Pedidosproveedore->find('first', array('contain' => array(), 'conditions' => array('Pedidosproveedore.serie' => $data[3], 'Pedidosproveedore.numero' => $data[4])));
                    $ArticulosPedidosproveedore['ArticulosPedidosproveedore']['pedidosproveedore_id'] = $pedidosproveedore['Pedidosproveedore']['id'];
                    $ArticulosPedidosproveedore['ArticulosPedidosproveedore']['cantidad'] = doubleval(str_replace(',', '.', $data[5]));
                    $ArticulosPedidosproveedore['ArticulosPedidosproveedore']['precio_proveedor'] = doubleval(str_replace(',', '.', $data[7]));
                    $ArticulosPedidosproveedore['ArticulosPedidosproveedore']['descuento'] = doubleval(str_replace(',', '.', $data[10]));
                    $ArticulosPedidosproveedore['ArticulosPedidosproveedore']['neto'] = $ArticulosPedidosproveedore['ArticulosPedidosproveedore']['precio_proveedor'] * (1 - $ArticulosPedidosproveedore['ArticulosPedidosproveedore']['descuento'] / 100);
                    $ArticulosPedidosproveedore['ArticulosPedidosproveedore']['total'] = $ArticulosPedidosproveedore['ArticulosPedidosproveedore']['neto'] * $ArticulosPedidosproveedore['ArticulosPedidosproveedore']['cantidad'];
                    $ArticulosPedidosproveedore['ArticulosPedidosproveedore']['tarea_id'] = null;
                    if (!$this->ArticulosPedidosproveedore->save($ArticulosPedidosproveedore)) {
                        //pr($this->ArticulosPedidosproveedore->invalidFields());
                        //pr($data);
                        $ArticulosPedidosproveedore_bad++;
                    }
                } else {
                    $primera_fila = false;
                }
            }
            fclose($handle);
        }
        // Fin
        echo('Migracion de Articulos de Pedidos de Proveedore Finalizada');
        echo '<br/>Cantidad de Articulos de Pedidos de Proveedores  No anadido: ' . $ArticulosPedidosproveedore_bad;
    }

    /*
     * ALBARANES PROVEEDORES
     */

    function albaranesproveedores() {
        /*
          SET foreign_key_checks = 0;
          TRUNCATE TABLE `albaranesproveedores`;
          TRUNCATE TABLE `articulos_albaranesproveedores`;
         */
        $albaranesproveedores_bad = 0;
        $path = '../csvs/COMPRAT.csv';
        $primera_fila = true;
        $this->loadModel('Albaranesproveedore');
        if (($handle = fopen($path, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                if (!$primera_fila) {
                    $this->Albaranesproveedore->create();
                    $albaranesproveedore = array();
                    $albaranesproveedore['Albaranesproveedore']['serie'] = $data[2];
                    $albaranesproveedore['Albaranesproveedore']['numero'] = intval($data[3]);
                    $albaranesproveedore['Albaranesproveedore']['fecha'] = str_fecha_mysql($data[1]);
                    $fecha_del_albaran = new DateTime(str_fecha_mysql($data[1]));
                    $fecha_de_cambio_de_iva = new DateTime("2011-07-1");
                    if ($fecha_del_albaran < $fecha_de_cambio_de_iva)
                        $albaranesproveedore['Albaranesproveedore']['tiposiva_id'] = 11;
                    else
                        $albaranesproveedore['Albaranesproveedore']['tiposiva_id'] = 1;
                    $albaranesproveedore['Albaranesproveedore']['baseimponible'] = doubleval(str_replace(',', '.', $data[7]));
                    $albaranesproveedore['Albaranesproveedore']['observaciones'] = '-';
                    $albaranesproveedore['Albaranesproveedore']['albaranescaneado'] = '';
                    $albaranesproveedore['Albaranesproveedore']['numero_albaran_proporcionado'] = '-';
                    $albaranesproveedore['Albaranesproveedore']['confirmado'] = 1;
                    $proveedore = $this->Albaranesproveedore->Proveedore->find('first', array('contain' => array(), 'conditions' => array('Proveedore.codpro' => $data[4])));
                    $albaranesproveedore['Albaranesproveedore']['proveedore_id'] = $proveedore['Proveedore']['id'];
                    $albaranesproveedore['Albaranesproveedore']['estadosalbaranesproveedore_id'] = 2;
                    $albaranesproveedore['Albaranesproveedore']['almacene_id'] = null;
                    $albaranesproveedore['Albaranesproveedore']['facturasproveedore_id'] = null;
                    $albaranesproveedore['Albaranesproveedore']['centrosdecoste_id'] = 4;
                    if (!$this->Albaranesproveedore->save($albaranesproveedore)) {
                        pr($this->Albaranesproveedore->invalidFields());
                        pr($data);
                        $albaranesproveedores_bad++;
                    }
                } else {
                    $primera_fila = false;
                }
            }
            fclose($handle);
        }
        $path = '../csvs/MOVALMC-03.csv';
        $primera_fila = true;
        $this->loadModel('Albaranesproveedore');
        if (($handle = fopen($path, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                if (!$primera_fila) {
                    $albaranesproveedore = $this->Albaranesproveedore->find('first', array('fields' => array('id'), 'contain' => array(), 'conditions' => array('Albaranesproveedore.serie' => $data[3], 'Albaranesproveedore.numero' => $data[4])));
                    if (!empty($albaranesproveedore)) {
                        $this->Albaranesproveedore->id = $albaranesproveedore['Albaranesproveedore']['id'];
                        $almacene = $this->Albaranesproveedore->Almacene->find('first', array('contain' => array(), 'conditions' => array('Almacene.codalm' => $data[1])));
                        $this->Albaranesproveedore->saveField('almacene_id', $almacene['Almacene']['id']);
                    }
                } else {
                    $primera_fila = false;
                }
            }
            fclose($handle);
        }
        // Fin
        echo('Migracion de Albaranes de Proveedore Finalizada');
        echo '<br/>Cantidad de Albaranes de Proveedores  No anadido: ' . $albaranesproveedores_bad;
    }

    function articulos_albaranesproveedores() {
        /*
          SET foreign_key_checks = 0;
          TRUNCATE TABLE `articulos_albaranesproveedores`;
         */
        $articulosAlbaranesproveedore_bad = 0;
        $path = '../csvs/MOVALMD1.csv';
        $primera_fila = true;
        $this->loadModel('ArticulosAlbaranesproveedore');

        if (($handle = fopen($path, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                if (!$primera_fila) {
                    $this->ArticulosAlbaranesproveedore->create();
                    $ArticulosAlbaranesproveedore = array();
                    $articulo = $this->ArticulosAlbaranesproveedore->Articulo->find('first', array('contain' => array(), 'conditions' => array('Articulo.ref' => $data[3])));
                    $ArticulosAlbaranesproveedore['ArticulosAlbaranesproveedore']['articulo_id'] = $articulo['Articulo']['id'];
                    $albaranesproveedore = $this->ArticulosAlbaranesproveedore->Albaranesproveedore->find('first', array('contain' => array(), 'conditions' => array('Albaranesproveedore.serie' => $data[5], 'Albaranesproveedore.numero' => $data[6])));
                    $ArticulosAlbaranesproveedore['ArticulosAlbaranesproveedore']['albaranesproveedore_id'] = $albaranesproveedore['Albaranesproveedore']['id'];
                    $ArticulosAlbaranesproveedore['ArticulosAlbaranesproveedore']['cantidad'] = doubleval(str_replace(',', '.', $data[7]));
                    $ArticulosAlbaranesproveedore['ArticulosAlbaranesproveedore']['precio_proveedor'] = doubleval(str_replace(',', '.', $data[10]));
                    $ArticulosAlbaranesproveedore['ArticulosAlbaranesproveedore']['descuento'] = doubleval(str_replace(',', '.', $data[13]));
                    $ArticulosAlbaranesproveedore['ArticulosAlbaranesproveedore']['neto'] = $ArticulosAlbaranesproveedore['ArticulosAlbaranesproveedore']['precio_proveedor'] * (1 - $ArticulosAlbaranesproveedore['ArticulosAlbaranesproveedore']['descuento'] / 100);
                    $ArticulosAlbaranesproveedore['ArticulosAlbaranesproveedore']['total'] = $ArticulosAlbaranesproveedore['ArticulosAlbaranesproveedore']['cantidad'] * $ArticulosAlbaranesproveedore['ArticulosAlbaranesproveedore']['neto'];
                    $ArticulosAlbaranesproveedore['ArticulosAlbaranesproveedore']['tarea_id'] = null;
                    if (!$this->ArticulosAlbaranesproveedore->save($ArticulosAlbaranesproveedore)) {
                        pr($this->ArticulosAlbaranesproveedore->invalidFields());
                        pr($data);
                        $articulosAlbaranesproveedore_bad++;
                    }
                } else {
                    $primera_fila = false;
                }
            }
            fclose($handle);
        }$path = '../csvs/MOVALMD2.csv';
        $primera_fila = true;
        $this->loadModel('ArticulosAlbaranesproveedore');

        if (($handle = fopen($path, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                if (!$primera_fila) {
                    $this->ArticulosAlbaranesproveedore->create();
                    $ArticulosAlbaranesproveedore = array();
                    $articulo = $this->ArticulosAlbaranesproveedore->Articulo->find('first', array('contain' => array(), 'conditions' => array('Articulo.ref' => $data[3])));
                    $ArticulosAlbaranesproveedore['ArticulosAlbaranesproveedore']['articulo_id'] = $articulo['Articulo']['id'];
                    $albaranesproveedore = $this->ArticulosAlbaranesproveedore->Albaranesproveedore->find('first', array('contain' => array(), 'conditions' => array('Albaranesproveedore.serie' => $data[5], 'Albaranesproveedore.numero' => $data[6])));
                    $ArticulosAlbaranesproveedore['ArticulosAlbaranesproveedore']['albaranesproveedore_id'] = $albaranesproveedore['Albaranesproveedore']['id'];
                    $ArticulosAlbaranesproveedore['ArticulosAlbaranesproveedore']['cantidad'] = doubleval(str_replace(',', '.', $data[7]));
                    $ArticulosAlbaranesproveedore['ArticulosAlbaranesproveedore']['precio_proveedor'] = doubleval(str_replace(',', '.', $data[10]));
                    $ArticulosAlbaranesproveedore['ArticulosAlbaranesproveedore']['descuento'] = doubleval(str_replace(',', '.', $data[13]));
                    $ArticulosAlbaranesproveedore['ArticulosAlbaranesproveedore']['neto'] = $ArticulosAlbaranesproveedore['ArticulosAlbaranesproveedore']['precio_proveedor'] * (1 - $ArticulosAlbaranesproveedore['ArticulosAlbaranesproveedore']['descuento'] / 100);
                    $ArticulosAlbaranesproveedore['ArticulosAlbaranesproveedore']['total'] = $ArticulosAlbaranesproveedore['ArticulosAlbaranesproveedore']['cantidad'] * $ArticulosAlbaranesproveedore['ArticulosAlbaranesproveedore']['neto'];
                    $ArticulosAlbaranesproveedore['ArticulosAlbaranesproveedore']['tarea_id'] = null;
                    if (!$this->ArticulosAlbaranesproveedore->save($ArticulosAlbaranesproveedore)) {
                        pr($this->ArticulosAlbaranesproveedore->invalidFields());
                        pr($data);
                        $articulosAlbaranesproveedore_bad++;
                    }
                } else {
                    $primera_fila = false;
                }
            }
            fclose($handle);
        }
        // Fin
        echo('Migracion de Articulos de Albaranes de Proveedore Finalizada');
        echo '<br/>Cantidad de Articulos de Albaranes de Proveedores  No anadido: ' . $articulosAlbaranesproveedore_bad;
    }

    /*
     * 
     * TELEFONOS 
     * 
     */

    function telefonos() {
        /*
          SET foreign_key_checks = 0;
          TRUNCATE TABLE `telefonos`;
         */

        $this->loadModel('Telefono');
        $telefonos_bad = 0;

        $path = '../csvs/CLIENTE.csv';
        $primera_fila = true;
        if (($handle = fopen($path, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                if (!$primera_fila) {
                    $cliente = $this->Telefono->Cliente->find('first', array('contain' => array(), 'conditions' => array('Cliente.codcli' => $data[0])));
                    $this->Telefono->create();
                    $telefono = array();
                    $telefono['Telefono']['cliente_id'] = $cliente['Cliente']['id'];
                    $telefono['Telefono']['telefono'] = $data[10];
                    if (!$this->Telefono->save($telefono)) {
                        $telefonos_bad++;
                    }
                    $this->Telefono->create();
                    $telefono = array();
                    $telefono['Telefono']['cliente_id'] = $cliente['Cliente']['id'];
                    $telefono['Telefono']['telefono'] = $data[11];
                    if (!$this->Telefono->save($telefono)) {
                        $telefonos_bad++;
                    }
                    $this->Telefono->create();
                    $telefono = array();
                    $telefono['Telefono']['cliente_id'] = $cliente['Cliente']['id'];
                    $telefono['Telefono']['telefono'] = $data[12];
                    if (!$this->Telefono->save($telefono)) {
                        $telefonos_bad++;
                    }
                    $this->Telefono->create();
                    $telefono = array();
                    $telefono['Telefono']['cliente_id'] = $cliente['Cliente']['id'];
                    $telefono['Telefono']['telefono'] = $data[13];
                    $telefono['Telefono']['nombre'] = 'Fax';
                    if (!$this->Telefono->save($telefono)) {
                        $telefonos_bad++;
                    }
                } else {
                    $primera_fila = false;
                }
            }
            fclose($handle);
        }
        $path = '../csvs/PROVEED.csv';
        $primera_fila = true;
        if (($handle = fopen($path, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                if (!$primera_fila) {
                    $proveedore = $this->Telefono->Proveedore->find('first', array('contain' => array(), 'conditions' => array('Proveedore.codpro' => $data[0])));
                    $this->Telefono->create();
                    $telefono = array();
                    $telefono['Telefono']['proveedore_id'] = $proveedore['Proveedore']['id'];
                    $telefono['Telefono']['telefono'] = $data[9];
                    if (!$this->Telefono->save($telefono)) {
                        $telefonos_bad++;
                    }
                    $this->Telefono->create();
                    $telefono = array();
                    $telefono['Telefono']['proveedore_id'] = $proveedore['Proveedore']['id'];
                    $telefono['Telefono']['telefono'] = $data[10];
                    if (!$this->Telefono->save($telefono)) {
                        $telefonos_bad++;
                    }
                    $this->Telefono->create();
                    $telefono = array();
                    $telefono['Telefono']['proveedore_id'] = $proveedore['Proveedore']['id'];
                    $telefono['Telefono']['telefono'] = $data[11];
                    if (!$this->Telefono->save($telefono)) {
                        $telefonos_bad++;
                    }
                    $this->Telefono->create();
                    $telefono = array();
                    $telefono['Telefono']['proveedore_id'] = $proveedore['Proveedore']['id'];
                    $telefono['Telefono']['telefono'] = $data[12];
                    $telefono['Telefono']['nombre'] = 'Fax';
                    if (!$this->Telefono->save($telefono)) {
                        $telefonos_bad++;
                    }
                } else {
                    $primera_fila = false;
                }
            }
            fclose($handle);
        }
        // Fin
        echo('Migracion de Telefonos Finalizada');
        echo '<br/>Cantidad de  Telefonos  No anadido: ' . $telefonos_bad;
    }

    function actuzalizar_articulos() {
        $path = '../csvs/ARTICAL.csv';
        $primera_fila = true;
        if (($handle = fopen($path, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";") ) !== FALSE) {
                /* Por cada fila insertar en base de datos */
                /*
                 * [0] => CODALM
                  [1] => CODPDT
                  [2] => LOCALIZ
                  [3] => SISVAL
                  [4] => PVP1
                  [5] => PRESTA
                  [6] => PREULT
                  [7] => PREMED
                  [8] => CANEXI
                  [9] => CODPRV
                  [10] => STOCKMIN
                  [11] => STOCKMAX
                 */
                //Si no es la primera fila
                if (!$primera_fila) {
                    $this->loadModel('Articulo');
                    $articulo = $this->Articulo->find('first', array('contain' => '', 'conditions' => array('Articulo.ref' => $data[1],'Articulo.proveedore_id' => null)));
                    if (!empty($articulo['Articulo']['id'])) {
                        $articulo['Articulo']['ultimopreciocompra'] = str_replace(',', '.', $data[10]);
                        $articulo['Articulo']['existencias'] = $data[12];
                        $articulo['Articulo']['stock_minimo'] = $data[14];
                        $articulo['Articulo']['stock_maximo'] = $data[15];
                        $proveedore = $this->Articulo->Proveedore->find('first', array('contain' => array(), 'conditions' => array('Proveedore.codpro' => zerofill($data[13],5))));
                        $articulo['Articulo']['proveedore_id'] = $proveedore['Proveedore']['id'];
                        if (!$this->Articulo->save($articulo)) {
                            pr($this->Articulo->invalidFields());
                        }
                    }
                } else {
                    $primera_fila = false;
                }
            }
        }
        fclose($handle);

        //echo('Migracion de Articulos Completada');
    }

    function migrar_auto() {
        set_time_limit(0); /*
          $this->familias();
          $this->proveedores();
          $this->almacenes();
          $this->articulos();
          $this->cuentascontables();
          $this->clientes();
          $this->formapagos();
          $this->cuentasbancarias();
          $this->maquinas();
          $this->mecanicos();
          $this->comerciales_proveedores();
          $this->ordenes();
          $this->tareas();
          $this->articulos_tareas();
          $this->partes();
          $this->partestalleres();
          $this->albaranesclientesreparaciones();
          $this->tareas_albaranesclientesreparaciones();
          $this->articulos_tareas_albaranesclientesreparaciones();
          $this->tareas_albaranesclientesreparaciones_partes();
          $this->tareas_albaranesclientesreparaciones_partestalleres();
          $this->presupuestosclientes();
          $this->tareaspresupuestoclientes();
          $this->materiales();
          $this->manodeobras();
          $this->tareaspresupuestoclientes_otrosservicios();
          $this->albaranescliente();
          $this->tareasalbaranesclientes();
          $this->materiales_tareasalbaranesclientes();
          $this->tareasalbaranesclientes_otrosservicios();
          $this->facturas_clientes();
          $this->pedidosproveedores();
          $this->articulos_pedidosproveedores();
          $this->albaranesproveedores();
          $this->articulos_albaranesproveedores();
          $this->telefonos(); */




        //$this->facturas_clientes();
        //$this->actuzalizar_articulos();

        die('<br/>Auto migrar finalizado');
    }

}

?>