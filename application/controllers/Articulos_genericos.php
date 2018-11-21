<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Articulos_genericos extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array(
            'session',
            'r_session',
            'pagination',
            'form_validation'
        ));
        $this->load->model(array(
            'parametros_model',
            'articulos_genericos_model',
            'articulos_model',
            'lineas_model',
            'log_model'
        ));

        $session = $this->session->all_userdata();
        $this->r_session->check($session);
    }

    function finalizados($pagina = 0) {
        $data['title'] = 'Listado de Artículos Genéricos Finalizados';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array();


        $per_page = $this->parametros_model->get_valor_parametro_por_usuario('per_page', $data['session']['SID']);
        $per_page = $per_page['valor'];

        $where = $this->input->get();
        $where['estado_relacion'] = 'F';

        /*
         * inicio paginador
         */
        $total_rows = $this->articulos_genericos_model->get_cantidad_where($where);
        $config['reuse_query_string'] = TRUE;
        $config['base_url'] = '/articulos_genericos/finalizados/';
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

        $data['articulos'] = $this->articulos_genericos_model->get_cantidad_where_limit($where, $per_page, $pagina);
        foreach ($data['articulos'] as $key => $value) {
            $data['articulos'][$key]['stock'] = $this->articulos_model->get_sum_stock_por_idarticulo_generico($value['idarticulo_generico']);
            $datos = array(
                'articulos.idarticulo_generico' => $value['idarticulo_generico'],
                'articulos.estado' => 'A'
            );
            $data['articulos'][$key]['articulos'] = $this->articulos_model->gets_where($datos);
        }

        $data['view'] = 'articulos_genericos/finalizados';
        $this->load->view('layout/app', $data);
    }

    function pendientes($pagina = 0) {
        $data['title'] = 'Listado de Artículos Genéricos Pendientes';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array();


        $per_page = $this->parametros_model->get_valor_parametro_por_usuario('per_page', $data['session']['SID']);
        $per_page = $per_page['valor'];

        $where = $this->input->get();
        $where['estado_relacion'] = 'A';

        /*
         * inicio paginador
         */
        $total_rows = $this->articulos_genericos_model->get_cantidad_where($where);
        $config['reuse_query_string'] = TRUE;
        $config['base_url'] = '/articulos_genericos/pendientes/';
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

        $data['articulos'] = $this->articulos_genericos_model->get_cantidad_where_limit($where, $per_page, $pagina);
        foreach ($data['articulos'] as $key => $value) {
            $data['articulos'][$key]['stock'] = $this->articulos_model->get_sum_stock_por_idarticulo_generico($value['idarticulo_generico']);
            $datos = array(
                'articulos.idarticulo_generico' => $value['idarticulo_generico'],
                'articulos.estado' => 'A'
            );
            $data['articulos'][$key]['articulos'] = $this->articulos_model->gets_where($datos);
        }

        $data['view'] = 'articulos_genericos/pendientes';
        $this->load->view('layout/app', $data);
    }

    public function gets_articulos_ajax() {
        $where = $this->input->post();
        $where['estado'] = 'A';
        echo json_encode($this->articulos_genericos_model->gets_where($where));
    }

    public function gets_articulos_tabla_ajax() {
        $where = $this->input->post();
        $where['estado'] = 'A';
        $data['articulos'] = $this->articulos_genericos_model->gets_where($where);

        $this->load->view('articulos_genericos/gets_articulos_tabla_ajax', $data);
    }

    public function agregar() {
        $data['title'] = 'Agregar Artículo Genérico';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array(
            '/assets/modulos/articulos_genericos/js/agregar.js'
        );

        $data['view'] = 'articulos_genericos/agregar';
        $this->load->view('layout/app', $data);
    }

    public function agregar_ajax() {
        $session = $this->session->all_userdata();

        $this->form_validation->set_rules('idlinea', 'Línea', 'required|integer');
        $this->form_validation->set_rules('articulo_generico', 'Artículo Genérico', 'required');
        $this->form_validation->set_rules('numero_orden', 'Número de Orden', 'required|integer');

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            // Comprobar si el genérico ya existe
            $datos = array(
                'idlinea' => $this->input->post('idlinea'),
                'articulo_generico' => $this->input->post('articulo_generico')
            );

            $resultado = $this->articulos_genericos_model->get_where($datos);
            if ($resultado) {
                $json = array(
                    'status' => 'error',
                    'data' => '<p>El artículo genérico ' . $resultado['articulo_generico'] . ' ya existe.</p>'
                );
                echo json_encode($json);
            } else {
                $datos = array(
                    'idlinea' => $this->input->post('idlinea'),
                    'articulo_generico' => $this->input->post('articulo_generico'),
                    'numero_orden' => $this->input->post('numero_orden'),
                    'fecha_creacion' => date("Y-m-d H:i:s"),
                    'idcreador' => $session['SID'],
                    'actualizado_por' => $session['SID']
                );
                $id = $this->articulos_genericos_model->set($datos);
                if ($id) {
                    $where = array(
                        'idlinea' => $this->input->post('idlinea')
                    );
                    $linea = $this->lineas_model->get_where($where);
                    
                    $log = array(
                        'tabla' => 'articulos_genericos',
                        'idtabla' => $id,                     
                        'texto' => '<h2><strong>Se cre&oacute; el art&iacute;culo gen&eacute;rico: '.$this->input->post('articulo_generico').'</strong></h2>

<p><strong>L&iacute;nea: </strong>'.$linea['linea'].'<br />
<strong>N&uacute;mero de Orden: </strong>'.$this->input->post('numero_orden').'<br /></p>',
                        'idusuario' => $session['SID'],
                        'tipo' => 'add'
                    );
                    $this->log_model->set($log);

                    $json = array(
                        'status' => 'ok',
                        'data' => '<p>Se creó el genérico ' . $datos['articulo_generico'] . '</p>'
                    );
                    echo json_encode($json);
                } else {
                    $json = array(
                        'status' => 'error',
                        'data' => '<p>No se pudo crear el genérico ' . $datos['articulo_generico'] . '</p>'
                    );
                    echo json_encode($json);
                }
            }
        }
    }

    public function borrar_ajax() {
        $this->form_validation->set_rules('idarticulo_generico', 'Artículo Genérico', 'required|integer');

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $datos = array(
                'estado' => 'I'
            );
            $where = array(
                'idarticulo_generico' => $this->input->post('idarticulo_generico')
            );

            $resultado = $this->articulos_genericos_model->update($datos, $where);
            if ($resultado) {
                $json = array(
                    'status' => 'ok',
                    'data' => 'Se eliminó correctamente'
                );
                echo json_encode($json);
            } else {
                $json = array(
                    'status' => 'error',
                    'data' => 'No se pudo eliminar'
                );
                echo json_encode($json);
            }
        }
    }

}

?>
