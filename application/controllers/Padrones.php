<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Padrones extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array(
            'session',
            'r_session',
            'form_validation',
            'pagination'
        ));
        $this->load->model(array(
            'provincias_model',
            'parametros_model',
            'padrones_model'
        ));
        $session = $this->session->all_userdata();
        $this->r_session->check($session);
    }

    public function importar() {
        $data['title'] = 'Importar Padrón';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array(
            '/assets/modulos/padrones/js/importar.js'
        );
        $data['view'] = 'padrones/importar';

        $data['jurisdicciones'] = $this->provincias_model->gets();

        $where = array(
            'identificador' => 'ruta_upload',
            'estado' => 'A'
        );
        $ruta_upload = $this->parametros_model->get_where($where);

        $data['archivos'] = opendir("." . $ruta_upload['valor_sistema']);

        $this->load->view('layout/app', $data);
    }

    public function procesar_ajax() {
        $this->form_validation->set_rules('jurisdiccion', 'Jurisdicción', 'required|integer');
        $this->form_validation->set_rules('archivo', 'Archivo', 'required');

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $jurisdiccion = $this->input->post('jurisdiccion');

            switch ($jurisdiccion) {
                case '901':  // CABA
                    $this->jurisdiccion_901($this->input->post('archivo'));
                    break;
                default :
                    $json = array(
                        'status' => 'error',
                        'data' => 'No existe proceso para esta jurisdicción'
                    );
                    echo json_encode($json);
                    break;
            }
        }
    }

    public function listar($pagina = 0) {
        $data['title'] = 'Listado de Importaciones';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array();
        $data['view'] = 'padrones/listar';


        $per_page = $this->parametros_model->get_valor_parametro_por_usuario('per_page', $data['session']['SID']);
        $per_page = $per_page['valor'];

        $where = $this->input->get();

        /*
         * inicio paginador
         */
        $total_rows = $this->padrones_model->get_cantidad_where($where);
        $config['reuse_query_string'] = TRUE;
        $config['base_url'] = '/padrones/listar/';
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $per_page;
        $config['first_link'] = '<i class="fa fa-angle-double-left"></i>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = '<i class="fa fa-angle-double-right"></i>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#"><b>';
        $config['cur_tag_close'] = '</b></a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $this->pagination->initialize($config);
        $data['links'] = $this->pagination->create_links();
        $data['total_rows'] = $total_rows;
        /*
         * fin paginador
         */

        $data['padrones'] = $this->padrones_model->gets_where_limit($where, $per_page, $pagina);

        $this->load->view('layout/app', $data);
    }

    private function jurisdiccion_901($archivo) {  //  CABA
        $where = array(
            'identificador' => 'ruta_upload',
            'estado' => 'A'
        );
        $ruta_upload = $this->parametros_model->get_where($where);

        $url = substr($ruta_upload['valor_sistema'], 1); // Quito el primer caracter
        
        /*
         *  Código para guardar en padron
         */
        $fp = fopen($url . $archivo, "r");
        $linea = fgets($fp);
        $array = preg_split('/;/', $linea);
        $set = array(
            'idjurisdiccion_afip' => 901,
            'fecha_publicacion' => $this->formatear_fecha($array[0]),
            'fecha_desde' => $this->formatear_fecha($array[1]),
            'fecha_hasta' => $this->formatear_fecha($array[2])
        );
        $idpadron = $this->padrones_model->set($set);
        fclose($fp);
        /*
         *  Fin de código para guardar en padrón
         */
        
        /*
         *  Cógido para guardar items de padrón
         */
        $fp = fopen($url . $archivo, "r");

        while (!feof($fp)) {

            $linea = fgets($fp);
            $array = preg_split('/;/', $linea);
            /*
             *  [0] = Fecha publicación
             *  [1] = Fecha desde
             *  [2] = Fecha hasta
             *  [3] = CUIT
             *  [7] = Percepción
             *  [8] = Retención
             *  [11] = Razon Social
             */

            $set = array(
                'idpadron' => $idpadron,
                'cuit' => $array[3],
                'percepcion' => str_replace(",", ".", $array[7]),
                'retencion' => str_replace(",", ".", $array[8]),
                'razonsocial' => trim($array[11])
            );

            $this->padrones_model->set_item($set);
        }
        /*
         * Fin de código para guardar items de padrón
         */

        $json = array(
            'status' => 'ok',
            'data' => 'Se completó el proceso correctamente'
        );
        echo json_encode($json);
    }

    private function formatear_fecha($fecha) {
        $aux = '';
        $aux .= substr($fecha, 4, 4);
        $aux .= '-';
        $aux .= substr($fecha, 2, 2);
        $aux .= '-';
        $aux .= substr($fecha, 0, 2);

        return $aux;
    }

}

?>
