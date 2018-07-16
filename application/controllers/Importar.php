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
            'importar_model'
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

    public function actualizar_articulos($archivo = null) {
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

            var_dump($cantidad);

            $fp = fopen("upload/importar/" . $archivo, "r");
            $count = 0;
            $init = 0;
            $porcentaje = 0;

            while (!feof($fp)) {
                $linea = fgets($fp);
                $array = preg_split('/;/', $linea);
                $count++;
                $init++;

                if (round(($count * 100 / $cantidad)) > $porcentaje) {
                    $porcentaje = round(($count * 100 / $cantidad), 0, PHP_ROUND_HALF_DOWN);
                    echo $porcentaje . " %\n";
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

            var_dump($count);

            $this->benchmark->mark('fin');

            echo $this->benchmark->elapsed_time('inicio', 'fin');
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

}

?>
