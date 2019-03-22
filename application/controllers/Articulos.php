<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Articulos extends CI_Controller {

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
            'articulos_model',
            'marcas_model',
            'lineas_model',
            'log_model'
        ));
        $session = $this->session->all_userdata();
        $this->r_session->check($session);
    }

    public function listar($pagina = 0) {
        $data['title'] = 'Listado de Artículos';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array();

        $per_page = $this->parametros_model->get_valor_parametro_por_usuario('per_page', $data['session']['SID']);
        $per_page = $per_page['valor'];
        $data['per_page'] = $per_page;

        $where = $this->input->get();
        $where['articulos.estado'] = 'A';

        /*
         * inicio paginador
         */
        $total_rows = $this->articulos_model->get_cantidad_where($where);
        $config['reuse_query_string'] = TRUE;
        $config['base_url'] = '/articulos/listar/';
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
        $data['base_url'] = $config['base_url'];
        /*
         * fin paginador
         */

        $data['articulos'] = $this->articulos_model->gets_where_limit($where, $per_page, $pagina);

        $data['view'] = 'articulos/listar';
        $this->load->view('layout/app', $data);
    }

    public function gets_articulos_ajax() {
        $where = $this->input->post();
        $articulos = $this->articulos_model->gets_where_para_ajax($where, 255);

        foreach ($articulos as $key => $value) {
            $articulos[$key]['text'] = $value['text'] . " - ";
            $where = array(
                'idmarca' => $value['idmarca']
            );
            $resultado = $this->marcas_model->get_where($where);

            $articulos[$key]['text'] .= $resultado['marca'];
        }
        echo json_encode($articulos);
    }

    public function borrar_ajax() {
        $where = $this->input->post();
        $this->articulos_model->update(array('estado' => 'I'), $where['idarticulo']);
    }

    public function activar_ajax() {
        $where = $this->input->post();
        $this->articulos_model->update(array('estado' => 'A'), $where['idarticulo']);
    }

    public function agregar_ajax() {
        $session = $this->session->all_userdata();

        $this->form_validation->set_rules('articulo', 'Artículo', 'required');
        $this->form_validation->set_rules('idmarca', 'Marca', 'required|integer');
        $this->form_validation->set_rules('numero_orden', 'Número de Orden', 'required|integer');
        $this->form_validation->set_rules('idlinea', 'Línea', 'required|integer');

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            /*
             * Busco si existe el articulo
             */
            $where = array(
                'articulo' => $this->input->post('articulo'),
                'idmarca' => $this->input->post('idmarca')
            );
            $articulo = $this->articulos_model->get_where($where);

            if ($articulo) { // Si existe
                if ($articulo['estado'] == 'A') { // Si existe y está activo
                    $json = array(
                        'status' => 'error',
                        'data' => 'El artículo ' . $articulo['articulo'] . ' ya existe'
                    );
                    echo json_encode($json);
                } elseif ($articulo['estado'] == 'I') {  // Si existe y está inactivo
                    $datos = array(
                        'estado' => 'A'
                    );
                    $where = array(
                        'idarticulo' => $articulo['idarticulo']
                    );

                    $resultado = $this->articulos_model->update($datos, $where);
                    if ($resultado) {
                        $json = array(
                            'status' => 'ok',
                            'data' => 'El artículo ' . $articulo['articulo'] . ' se volvió a activar'
                        );
                        echo json_encode($json);
                    } else {
                        $json = array(
                            'status' => 'error',
                            'data' => 'No se pudo volver al estado activo al artículo ' . $articulo['articulo']
                        );
                        echo json_encode($json);
                    }
                }
            } else { // Si no existe el artículo
                $datos = array(
                    'articulo' => $this->input->post('articulo'),
                    'idmarca' => $this->input->post('idmarca'),
                    'numero_orden' => $this->input->post('numero_orden'),
                    'idlinea' => $this->input->post('idlinea'),
                    'fecha_creacion' => date("Y-m-d H:i:s"),
                    'idcreador' => $session['SID'],
                    'actualizado_por' => $session['SID']
                );

                $id = $this->articulos_model->set($datos);

                if ($id) {
                    $where = array(
                        'idmarca' => $this->input->post('idmarca')
                    );
                    $marca = $this->marcas_model->get_where($where);
                    
                    $where = array(
                        'idlinea' => $this->input->post('idlinea')
                    );
                    $linea = $this->lineas_model->get_where($where);
                    
                    $log = array(
                        'tabla' => 'articulos',
                        'idtabla' => $id,
                        'texto' => "<h2><strong>Se creó el artículo: " . $this->input->post('articulo') . "</strong></h2>
                    <p><strong>ID Artículo: </strong>" . $id . "<br />
                    <strong>Marca: </strong>" . $marca['marca'] . "<br />
                    <strong>Número de Orden: </strong>" . $this->input->post('numero_orden') . "<br />
                    <strong>Línea: </strong>" . $linea['linea'],
                        'idusuario' => $session['SID'],
                        'tipo' => 'add'
                    );
                    $this->log_model->set($log);

                    $json = array(
                        'status' => 'ok',
                        'data' => 'El creó el artículo ' . $this->input->post('articulo')
                    );
                    echo json_encode($json);
                }
            }
        }
    }

    public function get_where_json() {
        $where = $this->input->post();
        $articulo = $this->articulos_model->get_where($where);

        $where = array(
            'idmarca' => $articulo['idmarca']
        );
        $articulo['marca'] = $this->marcas_model->get_where($where);

        $where = array(
            'idlinea' => $articulo['idlinea']
        );
        $articulo['linea'] = $this->lineas_model->get_where($where);

        echo json_encode($articulo);
    }

    public function gets_articulos_ajax_stock_y_precio() {
        $where = $this->input->post();
        $articulos = $this->articulos_model->gets_where_para_ajax_con_stock_y_precio($where, 255);

        foreach ($articulos as $key => $value) {
            $articulos[$key]['text'] = $value['text'] . " - ";
            $where = array(
                'idmarca' => $value['idmarca']
            );
            $resultado = $this->marcas_model->get_where($where);

            $articulos[$key]['text'] .= "<b>" . $resultado['marca'] . "</b>";
            $articulos[$key]['text'] .= " - " . $value['stock'];
            $articulos[$key]['text'] .= ' - <b>U$S ' . $value['precio'] . "</b>";
        }
        echo json_encode($articulos);
    }

}

?>
