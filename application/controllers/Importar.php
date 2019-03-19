<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Importar extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array(
            'session',
            'r_session',
            'form_validation'
        ));
        $this->load->model(array(
            'articulos_model',
            'importar_model',
            'comprobantes_model',
            'progresos_model',
            'clientes_model',
            'proveedores_model'
        ));
        $this->load->helper(array(
            'file'
        ));

        $session = $this->session->all_userdata();
        //$this->r_session->check($session);
    }

    public function agregar() {
        $data['title'] = 'Listado de Artículos';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array();
        $data['view'] = 'importar/agregar';


        $config['upload_path'] = "./upload/importar/";
        $config['allowed_types'] = '*';
        $config['encrypt_name'] = false;
        $config['remove_spaces'] = true;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('archivo')) {
            $data['error'] = array('error' => $this->upload->display_errors());
        } else {
            $data['adjunto'] = array('upload_data' => $this->upload->data());
        }

        $data['archivos'] = get_dir_file_info('upload/importar/');


        $this->load->view('layout/app', $data);
    }

    public function actualizar_articulos_original($archivo = null) {
        /*
          $data['title'] = 'Listado de Artículos';
          $data['session'] = $this->session->all_userdata();
          $data['menu'] = $this->r_session->get_menu();
          $data['javascript'] = array();
          $data['view'] = 'importar/actualizar_articulos';
         */

        if ($archivo) {
            $this->benchmark->mark('inicio');

            $cantidad = $this->articulos_model->get_cantidad_where(array());

            //var_dump($cantidad);

            $fp = fopen("upload/importar/" . $archivo, "r");
            $count = 0;
            $init = 0;
            $porcentaje = 0;
            /*
             * Elimino las 2 filas extras
             */
            $linea = fgets($fp);
            $linea = fgets($fp);

            while (!feof($fp)) {
                $linea = fgets($fp);
                $array = preg_split('/;/', $linea);
                $count++;
                $init++;


                if (round(($count * 100 / $cantidad)) > $porcentaje) {
                    $porcentaje = round(($count * 100 / $cantidad), 0, PHP_ROUND_HALF_DOWN);
                    //echo $porcentaje . " %\n";
                }


                //  CARACTERES AL FINAL DEL VALOR
                //  { = POSITIVO
                //  } = NEGATIVO
                //  
                //  [0] = ARTICULO
                //  [1] = MARCA
                //  [2] = LINEA
                //  [3] = NUMERO DE ORDEN
                //  [4] = ESTANTERIA  
                //  [6] = PRECIO Lista 1   
                //  [9] = COSTO FOB   
                //  [11] = COSTO DESPACHADO 
                //  [13] = STOCK MINIMO  
                //  [19] = STOCK ALMACEN 1
                //  [20] = STOCK ALMACEN 2
                //  [21] = PEDIDO DE IMPORTACION
                //  [41] = OBSERVACIONES
                //  [42] = DESCRIPCION
                //if($array[0] == "6206 C3             ") {
                $where = array(
                    'articulo' => trim($array[0]),
                    'idmarca' => $array[1]
                );

                $resultado = $this->articulos_model->get_where($where);


                $convmap = array(0x80, 0x10ffff, 0, 0xffffff);
                $array[4] = preg_replace('/\x{EF}\x{BF}\x{BD}/u', '', mb_encode_numericentity(trim($array[4]), $convmap, "UTF-8"));


                //$array[4] = utf8_encode(trim($array[4]));
                //$array[4] = trim($array[4]);
                $array[6] = ($array[6] / 1000);  //  price
                $array[9] = ($array[9] / 1000);  //  price_fob
                $array[11] = ($array[11] / 1000); //  price_dispatch
                $array[13] = ($array[13] / 1000);  // stock_min
                $array[14] = ($array[14] / 1000);  // stock_max

                $signo = null;
                if ($array[19][9] == '}') {
                    $signo = -1;
                } else {
                    $signo = 1;
                }
                $array[19] = ((substr($array[19], 0, 9) / 100) * $signo);

                $signo = null;
                if ($array[20][9] == '}') {
                    $signo = -1;
                } else {
                    $signo = 1;
                }
                $array[20] = ((substr($array[20], 0, 9) / 100) * $signo);

                if ($array[21][9] == '}') {
                    $signo = -1;
                } else {
                    $signo = 1;
                }
                $array[21] = ((substr($array[21], 0, 9) / 100) * $signo);

                $array[41] = trim($array[41]);
                $array[42] = trim($array[42]);

                $update = array(
                    'idlinea' => $array[2],
                    'order_number' => $array[3],
                    'rack' => $array[4],
                    'precio' => $array[6],
                    'price_fob' => $array[9],
                    'price_dispatch' => $array[11],
                    'stock2' => $array[19],
                    'stock' => $array[20],
                    'stock_pending' => $array[21],
                    'stock_min' => $array[13],
                    'stock_max' => $array[14],
                    'observations' => $array[41],
                    'description' => $array[42]
                );

                if (count($resultado) > 0) {
                    $this->articulos_model->update($update, $resultado['idarticulo']);
                } else {
                    $update['articulo'] = trim($array[0]);
                    $update['idmarca'] = $array[1];
                    $this->articulos_model->set($update);
                }
                /*
                  echo "<PRE>";
                  print_r($array);
                  print_r($resultado);
                  print_r(count($resultado));
                  print_r($update);
                  //$this->productos_model->update($update, $resultado['product_id']);
                  echo "</PRE>"; */
                //}
            }

            //var_dump($count);

            $this->benchmark->mark('fin');

            $array = array(
                'status' => 'ok'
            );
            echo json_encode($array);
            //echo $this->benchmark->elapsed_time('inicio', 'fin');
        }

        //$data['archivos'] = get_dir_file_info('upload/importar/');
        //$this->load->view('layout/app', $data);
    }

    public function actualizar_articulos($archivo = null) {

        if ($archivo) {

            $this->importar_model->crear_tabla('articulos', 'articulos_auxiliar');
            $this->importar_model->copiar_tabla_y_registros('articulos', 'articulos_auxiliar');
            //$this->importar_model->truncate('articulos');

            $fp = fopen("upload/importar/" . $archivo, "r");
            $count = 0;
            $init = 0;
            $porcentaje = 0;
            /*
             * Elimino las 2 filas extras
             */
            $linea = fgets($fp);
            $linea = fgets($fp);
            $idarticulo = 100000;
            while (!feof($fp)) {
                $linea = fgets($fp);
                $array = preg_split('/;/', $linea);



                //  CARACTERES AL FINAL DEL VALOR
                //  { = POSITIVO
                //  } = NEGATIVO
                //  
                //  [0] = ARTICULO
                //  [1] = MARCA
                //  [2] = LINEA
                //  [3] = NUMERO DE ORDEN
                //  [4] = ESTANTERIA  
                //  [6] = PRECIO Lista 1   
                //  [9] = COSTO FOB   
                //  [11] = COSTO DESPACHADO 
                //  [13] = STOCK MINIMO  
                //  [19] = STOCK ALMACEN 1
                //  [20] = STOCK ALMACEN 2
                //  [21] = PEDIDO DE IMPORTACION
                //  [41] = OBSERVACIONES
                //  [42] = DESCRIPCION
                //if($array[0] == "6206 C3             ") {

                $convmap = array(0x80, 0x10ffff, 0, 0xffffff);
                $array[4] = preg_replace('/\x{EF}\x{BF}\x{BD}/u', '', mb_encode_numericentity(trim($array[4]), $convmap, "UTF-8"));

                $array[0] = preg_replace('/\x{EF}\x{BF}\x{BD}/u', '', mb_encode_numericentity(trim($array[0]), $convmap, "UTF-8"));

                //$array[4] = utf8_encode(trim($array[4]));
                //$array[4] = trim($array[4]);
                $array[6] = ($array[6] / 1000);  //  price
                $array[9] = ($array[9] / 1000);  //  price_fob
                $array[11] = ($array[11] / 1000); //  price_dispatch
                $array[13] = ($array[13] / 1000);  // stock_min
                $array[14] = ($array[14] / 1000);  // stock_max

                $signo = null;
                if ($array[19][9] == '}') {
                    $signo = -1;
                } else {
                    $signo = 1;
                }
                $array[19] = ((substr($array[19], 0, 9) / 100) * $signo);

                $signo = null;
                if ($array[20][9] == '}') {
                    $signo = -1;
                } else {
                    $signo = 1;
                }
                $array[20] = ((substr($array[20], 0, 9) / 100) * $signo);

                if ($array[21][9] == '}') {
                    $signo = -1;
                } else {
                    $signo = 1;
                }
                $array[21] = ((substr($array[21], 0, 9) / 100) * $signo);

                $array[41] = trim($array[41]);
                $array[42] = trim($array[42]);


                $update = array(
                    'idarticulo' => $idarticulo,
                    'articulo' => trim($array[0]),
                    'idmarca' => trim($array[1]),
                    'idlinea' => $array[2],
                    'numero_orden' => $array[3],
                    'rack' => $array[4],
                    'precio' => $array[6],
                    'price_fob' => $array[9],
                    'price_dispatch' => $array[11],
                    'stock2' => $array[19],
                    'stock' => $array[20],
                    'stock_pending' => $array[21],
                    'stock_min' => $array[13],
                    'stock_max' => $array[14],
                    'observations' => $array[41],
                    'description' => $array[42]
                );

                $this->articulos_model->set($update);

                $idarticulo++;
            }


            $array = array(
                'status' => 'ok'
            );
            echo json_encode($array);
            //echo $this->benchmark->elapsed_time('inicio', 'fin');
        }

        //$data['archivos'] = get_dir_file_info('upload/importar/');
        //$this->load->view('layout/app', $data);
    }

    public function migrar() {
        $data['session'] = $this->session->all_userdata();
        $this->r_session->check($data['session']);
        $data['title'] = 'Listado de Artículos';
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array(
            '/assets/modulos/importar/js/migrar.js'
        );

        $data['view'] = 'importar/migrar';
        $this->load->view('layout/app', $data);
    }

    public function migrar_product_articulos() {
        $origen = 'product';
        $destino = 'articulos';

        $this->importar_model->borrar_tabla($destino);

        $this->importar_model->crear_tabla($origen, $destino);

        $this->importar_model->copiar_tabla_y_registros($origen, $destino);

        $this->importar_model->alter_table($destino, 'product_id', 'idarticulo', 'INT(11) NOT NULL AUTO_INCREMENT');
        $this->importar_model->alter_table($destino, 'abstract_id', 'idarticulo_generico', 'INT(11) NOT NULL');
        $this->importar_model->borrar_campo($destino, 'organization_id');
        $this->importar_model->alter_table($destino, 'category_id', 'idlinea', 'INT(11) NOT NULL');
        $this->importar_model->alter_table($destino, 'brand_id', 'idmarca', 'INT(11) NOT NULL');
        $this->importar_model->alter_table($destino, 'code', 'articulo', 'VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL');
        $this->importar_model->alter_table($destino, 'price', 'precio', 'DECIMAL(10,2) NOT NULL');
        $this->importar_model->alter_table($destino, 'status', 'estado', "CHAR(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'A'");

        $json = array(
            'status' => 'ok'
        );
        echo json_encode($json);
    }

    public function migrar_product_abstract_articulos_genericos() {
        $origen = 'product_abstract';
        $destino = 'articulos_genericos';

        $this->importar_model->borrar_tabla($destino);

        $this->importar_model->crear_tabla($origen, $destino);

        $this->importar_model->copiar_tabla_y_registros($origen, $destino);

        $this->importar_model->alter_table($destino, 'abstract_id', 'idarticulo_generico', 'INT(11) NOT NULL AUTO_INCREMENT');
        $this->importar_model->alter_table($destino, 'category_id', 'idlinea', 'INT(11) NOT NULL');
        $this->importar_model->alter_table($destino, 'code', 'articulo_generico', 'VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL');
        $this->importar_model->alter_table($destino, 'order_number', 'numero_orden', 'INT(11) NOT NULL');
        $this->importar_model->alter_table($destino, 'status', 'estado', "CHAR(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'A'");
        $this->importar_model->alter_table($destino, 'relation_status', 'estado_relacion', "CHAR(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'A'");
        $this->importar_model->alter_table($destino, 'creation_date', 'fecha_creacion', "DATETIME NOT NULL");
        $this->importar_model->alter_table($destino, 'created_by', 'idcreador', 'INT(11) NOT NULL');
        $this->importar_model->alter_table($destino, 'modification_date', 'fecha_modificacion', 'TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP');
        $this->importar_model->alter_table($destino, 'updated_by', 'actualizado_por', 'INT(11) NOT NULL');
        $this->importar_model->borrar_campo($destino, 'organization_id');

        $json = array(
            'status' => 'ok'
        );
        echo json_encode($json);
    }

    public function agregar_comprobantes_notas_varias_items($archivo = null) {
        if ($archivo) {

            $fp = fopen("upload/importar/" . $archivo, "r");

            $this->importar_model->truncate('comprobantes_notas_varias_items');

            while (!feof($fp)) {
                $linea = fgets($fp);
                $array = preg_split('/;/', $linea);



                //  CARACTERES AL FINAL DEL VALOR
                //  { = POSITIVO
                //  } = NEGATIVO
                //  
                //  [0] = tipo
                //  [1] = letra
                //  [2] = punto de venta
                //  [3] = numero de comprobante
                //  [4] = numero de orden
                //  [5] = cantidad
                //  [6] = descripcion
                //  [7] = importe
                //  [8] = total  



                $datos = array(
                    'tipo' => trim($array[0]),
                    'letra' => trim($array[1]),
                    'punto_de_venta' => trim($array[2]),
                    'numero_comprobante' => trim($array[3]),
                    'numero_orden' => trim($array[4]),
                    'cantidad' => trim($array[5]),
                    'descripcion' => trim($array[6]),
                    'importe' => trim($array[7]),
                    'total' => trim($array[8])
                );

                $this->importar_model->set('comprobantes_notas_varias_items', $datos);
            }

            $json = array(
                'status' => 'ok'
            );
            echo json_encode($json);
        }
    }

    public function migrar_comprobantes($archivo = null) {
        if ($archivo) {

            $fp = fopen("upload/importar/" . $archivo, "r");

            $this->importar_model->truncate('comprobantes');
            while (!feof($fp)) {
                //for($i = 0; $i < 10; $i++) {
                $linea = fgets($fp);
                $array = preg_split('/;/', $linea);


                //  CARACTERES AL FINAL DEL VALOR
                //  { = POSITIVO
                //  } = NEGATIVO
                //  
                //  [0] = TIPO COMPROBANTE
                //  [1] = LETRA
                //  [2] = PUNTO DE VENTA
                //  [3] = NUMERO DE COMPROBANTE
                //  [4] = NUMERO DE CLIENTE
                //  [5] = FECHA DEL COMPROBANTE
                //  [6] = CORREDOR
                //  [7] = ESTADO DEL COMPROBANTE
                //  [8] = PRECIO NETO EXPRESADO EN PESOS
                //  [9] = PRECIO NETO EXPRESADO EN DOLARES
                //  [10] = PRECIO EXENTO EXPRESADO EN PESOS
                //  [11] = PRECIO EXENTO EXPRESADO EN DOLARES
                //  [14] = BONIFICACION EXPRESADA EN PESOS
                //  [15] = BONIFICACION EXPRESADA EN DOLARES
                //  [16] = IIBB EN PESOS => AHORA IMPUESTOS EN PESOS
                //  [17] = IIBB EN DOLARES => AHORA IMPUESTOS EN DOLARES
                //  [18] = IVA EN PESOS
                //  [19] = IVA EN DOLARES
                //  [22] = MONTO PAGADO

                $fecha = substr(trim($array[5]), -2, 2);
                if ($fecha > '70') {
                    $fecha = '19' . $fecha . '-';
                } else {
                    $fecha = '20' . $fecha . '-';
                }
                $fecha .= substr(trim($array[5]), -4, 2);
                $fecha .= '-';
                $fecha .= substr(trim($array[5]), -6, 2);

                $insert = array(
                    'tipo_comprobante' => trim($array[0]),
                    'letra' => trim($array[1]),
                    'punto_de_venta' => trim($array[2]),
                    'numero_comprobante' => trim($array[3]),
                    'idempresa' => trim($array[4]),
                    'fecha' => $fecha,
                    'estado' => trim($array[7]),
                    'precio_neto_pesos' => trim($array[8]),
                    'precio_neto_dolares' => trim($array[9]),
                    'precio_exento_pesos' => trim($array[10]),
                    'precio_exento_dolares' => trim($array[11]),
                    'bonificacion_pesos' => trim($array[14]),
                    'bonificacion_dolares' => trim($array[15]),
                    'impuestos_pesos' => trim($array[16]),
                    'impuestos_dolares' => trim($array[17]),
                    'iva_pesos' => trim($array[18]),
                    'iva_dolares' => trim($array[19]),
                    'monto_pagado' => trim($array[22])
                );


                $this->comprobantes_model->set($insert);
            }

            $array = array(
                'status' => 'ok'
            );
            echo json_encode($array);
        }
    }

    /*
     * Está pendiente
     */

    public function clientes($archivo = null) {
        $session = $this->session->all_userdata();

        if ($archivo) {
            $fp = fopen("upload/importar/" . $archivo, "r");
            $count = 0;
            $init = 0;
            $porcentaje = 0;

            $this->importar_model->truncate('clientes');
            $this->importar_model->truncate('clientes_sucursales');
            $this->importar_model->truncate('clientes_agentes');

            $linea = fgets($fp);  // Leo la primer línea en blanco
            $linea = fgets($fp);  // Leo la segunda linea de cabeceras

            while (!feof($fp)) {
                $linea = fgets($fp);
                $array = preg_split('/;/', $linea);
                $count++;
                $init++;
                //  CARACTERES AL FINAL DEL VALOR
                //  { = POSITIVO
                //  } = NEGATIVO
                //  
                //  [0] = ID CLIENTE
                //  [1] = RAZON SOCIAL 1
                //  [2] = RAZON SOCIAL 2
                //  [3] = CUIT
                //  [4] = DIRECCION
                //  [5] = CODIGO POSTAL
                //  [6] = LOCALIDAD
                //  [7] = ID PROVINCIA
                //  [8] = TELEFONO
                //  [9] = TIPO RESPONSABLE
                //  [10] = INGRESOS BRUTOS
                //  [11] = SALDO CUENTA CORRIENTE
                //  [12] = SALDO INICIAL
                //  [13] = SALDO A CUENTA
                //  [14] = BONIFICACION
                //  [15] = SUCURSAL
                //  [16] = NUMERO DE CORREDOR
                //  [17] = CONDICION DE VENTA
                //  [18] = MONEDA DE FACTURACION DEFAULT
                //  [19] = NUMERO DE PROVEEDOR
                //  [20] = MAL PAGADOR
                //  [21] = LIMITE DE CREDITO
                //  [22] = TIPO DE CLIENTE
                //  [23] = ATENDIDO POR
                //  [24] = HORARIO
                //  [25] = DESCRIPCION
                //  [26] = EMAIL
                //  [27] = WEB
                //  [28] = NUMERO DE GRUPO
                //  [29] = FLETE
                $where = array(
                    'cuit' => str_replace('-', '', $array[3])
                );
                $resultado = $this->clientes_model->get_where($where);

                if ($resultado && trim($array[3]) != '') {  // Si existe, actualizo
                    $datos = array(
                        'idcliente' => $resultado['idcliente'],
                        //'idpais' => Ver si se graba
                        'idprovincia' => $array[7],
                        //'idregion' => ???????
                        //'idzona' => ???????
                        'sucursal' => trim($array[1]) . ' ' . trim($array[2]),
                        'direccion' => $array[4],
                        'codigo_postal' => trim($array[5]),
                        'localidad' => trim($array[6]),
                        'telefono' => trim($array[8]),
                        'email' => trim($array[26]),
                    );
                    $idsucursal = $this->clientes_model->set_sucursal($datos);

                    $datos = array(
                        'idcliente' => $resultado['idcliente'],
                        'idcliente_sucursal' => $idsucursal,
                        'agente' => trim($array[23]),
                        'email' => trim($array[26]),
                        'telefono' => trim($array[8]),
                        'fecha_creacion' => date("Y-m-d H:i:s"),
                        'creado_por' => $session['SID']
                    );
                    $this->clientes_model->set_agente($datos);
                } else {  // Si no existe, lo creo
                    $datos = array(
                        'idcliente' => $array[0],
                        'cliente' => trim($array[1] . ' ' . $array[2]),
                        'cuit' => str_replace('-', '', $array[3]),
                        'domicilio_fiscal' => '',
                        'codigo_postal' => '',
                        'localidad' => '',
                        'idprovincia' => 0,
                        //'idtipo_resposable' => OK
                        'iibb' => trim($array[10]),
                        //'internacionales' => OK
                        'saldo_cuenta_corriente' => $array[11],
                        'saldo_inicial' => $array[12],
                        'saldo_a_cuenta' => $array[13],
                        'bonificacion' => $array[14],
                        'idcondicion_de_venta' => $array[17],
                        'idmoneda' => $array[18],
                        'idproveedor' => $array[19],
                        'mal_pagador' => trim($array[20]),
                        'limite_credito' => $array[21],
                        //'idempresa_tipo' => OK
                        'web' => trim($array[27]),
                        'fecha_creacion' => date("Y-m-d H:i:s"),
                        'idcreador' => $session['SID'],
                        'actualizado_por' => $session['SID']
                    );
                    switch ($array[9]) {
                        case 'IN':
                            $datos['idtipo_responsable'] = 1;
                            break;
                        case 'CF':
                            $datos['idtipo_responsable'] = 5;
                            break;
                        case 'EX':
                            $datos['idtipo_responsable'] = 4;
                            break;
                        case 'XE':
                            $datos['idtipo_responsable'] = 9;
                            break;
                        default:
                            $datos['idtipo_responsable'] = 0;
                            break;
                    }
                    if (trim($array[7]) >= 25) {
                        $datos['internacional'] = 'S';
                    }
                    if ($array[22] == 'R') {  // Tipo de Cliente
                        $datos['idempresa_tipo'] = 1;
                    } else {
                        $datos['idempresa_tipo'] = 2;
                    }

                    $idcliente = $this->clientes_model->set($datos);


                    $datos = array(
                        'idcliente' => $idcliente,
                        //'idpais' => Ver si se graba
                        'idprovincia' => $array[7],
                        //'idregion' => ???????
                        //'idzona' => ???????
                        'sucursal' => trim($array[1] . ' ' . $array[2]),
                        'direccion' => $array[4],
                        'codigo_postal' => trim($array[5]),
                        'localidad' => trim($array[6]),
                        'telefono' => trim($array[8]),
                        'email' => trim($array[26]),
                    );

                    $idsucursal = $this->clientes_model->set_sucursal($datos);

                    $datos = array(
                        'idcliente' => $idcliente,
                        'idcliente_sucursal' => $idsucursal,
                        'agente' => trim($array[23]),
                        'email' => trim($array[26]),
                        'telefono' => trim($array[8]),
                        'fecha_creacion' => date("Y-m-d H:i:s"),
                        'creado_por' => $session['SID']
                    );
                    $this->clientes_model->set_agente($datos);
                }
            }
        }
        $json = array(
            'status' => 'ok'
        );
        echo json_encode($json);
    }

    public function proveedores_anterior($archivo = null) {
        $session = $this->session->all_userdata();
        if ($archivo) {
            $fp = fopen("upload/importar/" . $archivo, "r");
            $linea = fgets($fp);  // Leo la primer línea en blanco
            $linea = fgets($fp);  // Leo la segunda linea de cabeceras

            $this->importar_model->truncate('proveedores');

            while (!feof($fp)) {
                $linea = fgets($fp);
                $array = preg_split('/;/', $linea);
                //  CARACTERES AL FINAL DEL VALOR
                //  { = POSITIVO
                //  } = NEGATIVO
                //  
                //  [0] = ID PROVEEDOR
                //  [1] = RAZON SOCIAL 1
                //  [2] = RAZON SOCIAL 2
                //  [3] = CUIT
                //  [4] = DOMICILIO
                //  [5] = CODIGO POSTAL
                //  [6] = LOCALIDAD
                //  [7] = PROVINCIA
                //  [8] = TELEFONO
                //  [9] = EMAIL
                //  [10] = PAIS
                //  [11] = CONTACTO
                //  [12] = TIPO DE IVA
                //  [13] = INGRESOS BRUTOS
                //  [14] = SALDO CUENTA CORRIENTE
                //  [15] = SALDO INICIAL
                //  [16] = SALDO A CUENTA
                //  [17] = 


                $datos = array(
                    'idproveedor' => $array[0],
                    'proveedor' => trim($array[1]) . ' ' . trim($array[2]),
                    'cuit' => str_replace('-', '', $array[3]),
                    'domicilio' => trim($array[4]),
                    'codigo_postal' => trim($array[5]),
                    'localidad' => trim($array[6]),
                    'idprovincia' => trim($array[7]),
                    'telefono' => trim($array[8]),
                    'email' => trim($array[9]),
                    'pais' => trim($array[10]),
                    'contacto' => trim($array[11]),
                    //'idtipo_responsable' => OK
                    'iibb' => trim($array[13]),
                    //'internacional' => OK
                    'saldo_cuenta_corriente' => $array[14],
                    'saldo_inicial' => $array[15],
                    'saldo_a_cuenta' => $array[16],
                    'idmoneda' => $array[19],
                    'fecha_creacion' => date("Y-m-d H:i:s"),
                    'idcreador' => $session['SID'],
                    'actualizado_por' => $session['SID']
                );
                switch ($array[12]) {
                    case 'IN':
                        $datos['idtipo_responsable'] = 1;
                        break;
                    case 'CF':
                        $datos['idtipo_responsable'] = 5;
                        break;
                    case 'EX':
                        $datos['idtipo_responsable'] = 4;
                        break;
                    case 'XE':
                        $datos['idtipo_responsable'] = 9;
                        break;
                    default:
                        $datos['idtipo_responsable'] = 0;
                        break;
                }
                if (trim($array[7]) >= 25) {
                    $datos['internacional'] = 'Y';
                }
                $idproveedor = $this->proveedores_model->set($datos);
            }
        }

        $json = array(
            'status' => 'ok'
        );
        echo json_encode($json);
    }

    public function proveedores($archivo = null) {
        $session = $this->session->all_userdata();
        if ($archivo) {
            $fp = fopen("upload/importar/" . $archivo, "r");
            $linea = fgets($fp);  // Leo la primer línea en blanco
            $linea = fgets($fp);  // Leo la segunda linea de cabeceras


            while (!feof($fp)) {
                $linea = fgets($fp);
                $array = preg_split('/;/', $linea);
                //  CARACTERES AL FINAL DEL VALOR
                //  { = POSITIVO
                //  } = NEGATIVO
                //  
                //  [0] = ID PROVEEDOR
                //  [1] = RAZON SOCIAL 1
                //  [2] = RAZON SOCIAL 2
                //  [3] = CUIT
                //  [4] = DOMICILIO
                //  [5] = CODIGO POSTAL
                //  [6] = LOCALIDAD
                //  [7] = PROVINCIA
                //  [8] = TELEFONO
                //  [9] = EMAIL
                //  [10] = PAIS
                //  [11] = CONTACTO
                //  [12] = TIPO DE IVA
                //  [13] = INGRESOS BRUTOS
                //  [14] = SALDO CUENTA CORRIENTE
                //  [15] = SALDO INICIAL
                //  [16] = SALDO A CUENTA
                //  [17] = 

                $where = array(
                    'idproveedor' => trim($array[0])
                );
                $resultado = $this->proveedores_model->get_where($where);

                if (!$resultado) {
                    $datos = array(
                        'idproveedor' => $array[0],
                        'proveedor' => trim($array[1]) . ' ' . trim($array[2]),
                        'cuit' => str_replace('-', '', $array[3]),
                        'domicilio' => trim($array[4]),
                        'codigo_postal' => trim($array[5]),
                        'localidad' => trim($array[6]),
                        'idprovincia' => trim($array[7]),
                        'telefono' => trim($array[8]),
                        'email' => trim($array[9]),
                        'pais' => trim($array[10]),
                        'contacto' => trim($array[11]),
                        //'idtipo_responsable' => OK
                        'iibb' => trim($array[13]),
                        //'internacional' => OK
                        'saldo_cuenta_corriente' => $array[14],
                        'saldo_inicial' => $array[15],
                        'saldo_a_cuenta' => $array[16],
                        'idmoneda' => $array[19],
                        'fecha_creacion' => date("Y-m-d H:i:s"),
                        'idcreador' => $session['SID'],
                        'actualizado_por' => $session['SID']
                    );
                    switch ($array[12]) {
                        case 'IN':
                            $datos['idtipo_responsable'] = 1;
                            break;
                        case 'CF':
                            $datos['idtipo_responsable'] = 5;
                            break;
                        case 'EX':
                            $datos['idtipo_responsable'] = 4;
                            break;
                        case 'XE':
                            $datos['idtipo_responsable'] = 9;
                            break;
                        default:
                            $datos['idtipo_responsable'] = 0;
                            break;
                    }
                    if (trim($array[7]) >= 25) {
                        $datos['internacional'] = 'Y';
                    } else {
                        $datos['idpais'] = 200;
                    }
                    $idproveedor = $this->proveedores_model->set($datos);
                }
            }
        }

        $json = array(
            'status' => 'ok'
        );
        echo json_encode($json);
    }

    public function progreso($tabla) {
        $session = $this->session->all_userdata();

        $fecha_actual = strtotime(date("Y-m-d H:i:s"));

        $where = array(
            'idusuario' => $session['SID'],
            'tabla' => $tabla
        );
        $resultado = $this->progresos_model->get_where($where);
        $fecha_db = $resultado['timestamp'];
        if ($fecha_db == null) {
            $datos = array(
                'idusuario' => $session['SID'],
                'tabla' => $tabla,
                'progreso' => 0
            );
            $this->progresos_model->set($datos);

            $json = array(
                'status' => 'ok',
                'progreso' => 0
            );
            echo json_encode($json);
        } else {
            $fecha_db = strtotime($fecha_db);

            while ($fecha_db < $fecha_actual) {
                $where = array(
                    'idusuario' => $session['SID'],
                    'tabla' => $tabla
                );
                $resultado = $this->progresos_model->get_where($where);

                usleep(100000); //anteriormente 10000
                clearstatcache();
                $fecha_db = strtotime($resultado['timestamp']);
            }
            $json = array(
                'status' => 'ok',
                'progreso' => $resultado['progreso'],
                'fecha_actual' => $fecha_actual,
                'fecha_db' => $fecha_db
            );
            echo json_encode($json);
        }
    }

}

?>
