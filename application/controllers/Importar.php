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
            'articulos_model'
        ));
        $this->load->helper(array(
            'file'
        ));

        $session = $this->session->all_userdata();
        $this->r_session->check($session);
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

    public function actualizar_articulos() {
        $data['title'] = 'Listado de Artículos';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array();
        $data['view'] = 'importar/actualizar_articulos';

        $this->form_validation->set_rules('archivo', 'Archivo', 'required');

        if ($this->form_validation->run() == FALSE) {
            
        } else {
            $this->benchmark->mark('inicio');
            
            $cantidad = $this->articulos_model->get_cantidad_where(array());
            
            var_dump($cantidad);
            
            $fp = fopen(base_url() . "/upload/importar/" . $this->input->post('archivo'), "r");
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

        $data['archivos'] = get_dir_file_info('upload/importar/');

        $this->load->view('layout/app', $data);
    }

}

?>
