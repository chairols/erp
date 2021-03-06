<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Parametros extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array(
            'session',
            'r_session',
            'form_validation',
            'table',
            'pagination'
        ));
        $this->load->model(array(
            'parametros_model',
            'log_model',
            'provincias_model',
            'tipos_responsables_model',
            'certificados_model',
            'tipos_iva_model'
        ));

        $session = $this->session->all_userdata();
        $this->r_session->check($session);
    }

    public function usuario() {
        $data['title'] = 'Listado de Parámetros para Usuarios';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array();

        if ($this->input->post()) {
            $post = $this->input->post();

            foreach ($post as $key => $value) {
                $id = explode("-", $key);
                $idparametro = $id['1'];

                $resultado = $this->parametros_model->get_parametro_por_usuario($idparametro, $data['session']['SID']);

                if ($resultado) {
                    $this->parametros_model->update_parametros_usuarios($value, $idparametro, $data['session']['SID']);
                } else {
                    $datos = array(
                        'idparametro' => $idparametro,
                        'idusuario' => $data['session']['SID'],
                        'valor' => $value
                    );

                    $this->parametros_model->set_parametros_usuarios($datos);
                }
            }
        }

        $data['parametros'] = $this->parametros_model->gets_parametros_por_usuario($data['session']['SID']);

        $data['view'] = 'parametros/usuario';
        $this->load->view('layout/app', $data);
    }
    
    public function sistema() {
        $data['title'] = 'Listado de Parámetros de Sistema';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['view'] = 'parametros/sistema';
        
        if ($this->input->post()) {
            $post = $this->input->post();

            foreach ($post as $key => $value) {
                $id = explode("-", $key);
                $idparametro = $id['1'];

                $datos = array(
                    'valor_sistema' => $value
                );
                $where = array(
                    'idparametro' => $idparametro
                );
                
                $this->parametros_model->update($datos, $where);
                
            }
        }
        
        $data['parametros'] = $this->parametros_model->gets_parametros_sistema();
        
        $this->load->view('layout/app', $data);
    }

    public function agregar() {
        $data['title'] = 'Agregar Parámetro';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array(
            '/assets/modulos/parametros/js/agregar.js'
        );

        $data['tipos'] = $this->parametros_model->gets_tipos_parametros();

        $data['view'] = 'parametros/agregar';
        $this->load->view('layout/app', $data);
    }

    public function agregar_ajax() {
        $session = $this->session->all_userdata();

        $this->form_validation->set_rules('parametro', 'Parámetro', 'required');
        $this->form_validation->set_rules('identificador', 'Identificador', 'required');
        $this->form_validation->set_rules('tipo', 'Tipo de Parámetro', 'required');

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $datos = array(
                'identificador' => $this->input->post('identificador'),
                'idparametro_tipo' => $this->input->post('tipo'),
                'estado' => 'A'
            );
            $resultado = $this->parametros_model->get_where($datos);

            /*
             * Compruebo si ya existe el link
             */
            if ($resultado) {
                $json = array(
                    'status' => 'error',
                    'data' => '<p>El Parámetro <strong>' . $resultado['parametro'] . '</strong> ya existe. </p>'
                );
                echo json_encode($json);
            } else {
                $datos = array(
                    'parametro' => $this->input->post('parametro'),
                    'identificador' => $this->input->post('identificador'),
                    'idparametro_tipo' => $this->input->post('tipo')
                );

                $id = $this->parametros_model->set($datos);

                /*
                 * Compruebo si fue exitoso y agrego al log
                 */
                if ($id) {
                    $log = array(
                        'tabla' => 'parametros',
                        'idtabla' => $id,
                        'texto' => $this->table->generate(array($datos)),
                        'idusuario' => $session['SID'],
                        'tipo' => 'add'
                    );

                    $this->log_model->set($log);

                    $json = array(
                        'status' => 'ok'
                    );
                    echo json_encode($json);
                } else {
                    $json = array(
                        'status' => 'error',
                        'data' => '<p>No se pudo agregar el menú.</p>'
                    );
                    echo json_encode($json);
                }
            }
        }
    }

    public function listar($pagina = 0) {
        $data['title'] = 'Listado de Parámetros';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array();


        $per_page = 10;
        $where = $this->input->get();
        $where['parametros.estado'] = 'A';

        /*
         * inicio paginador
         */
        $total_rows = $this->parametros_model->get_cantidad_where($where);
        $config['reuse_query_string'] = TRUE;
        $config['base_url'] = '/empresas/todas/';
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

        $data['parametros'] = $this->parametros_model->get_cantidad_where_limit($where, $per_page, $pagina);


        $data['view'] = 'parametros/listar';
        $this->load->view('layout/app', $data);
    }

    public function empresa() {
        $data['title'] = 'Listado de Parámetros';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array(
            '/assets/modulos/parametros/js/empresa.js'
        );
        $data['view'] = 'parametros/empresa';

        $data['parametro'] = $this->parametros_model->get_parametros_empresa();
        $data['provincias'] = $this->provincias_model->gets();
        $data['tipos_responsables'] = $this->tipos_responsables_model->gets();
        $data['certificados'] = $this->certificados_model->gets();
        $data['tipos_iva'] = $this->tipos_iva_model->gets();

        $this->load->view('layout/app', $data);
    }

    public function empresa_modificar_ajax() {
        $session = $this->session->all_userdata();

        $this->form_validation->set_rules('empresa', 'Nombre de la Empresa', 'required');
        $this->form_validation->set_rules('actividad', 'Actividad', 'required');
        $this->form_validation->set_rules('direccion', 'Dirección', 'required');
        $this->form_validation->set_rules('codigo_postal', 'Cógido Postal', 'required');
        $this->form_validation->set_rules('idprovincia', 'Provincia', 'required|is_natural_no_zero');
        $this->form_validation->set_rules('telefono', 'Teléfono', 'required');
        $this->form_validation->set_rules('email', 'E-mail', 'required|valid_email');
        $this->form_validation->set_rules('idtipo_responsable', 'Tipo de Responsable', 'required|is_natural_no_zero');
        $this->form_validation->set_rules('idtipo_iva', 'Porcentaje de IVA', 'required|is_natural_no_zero');
        $this->form_validation->set_rules('cuit', 'CUIT', 'required');
        $this->form_validation->set_rules('ingresos_brutos', 'Ingresos Brutos', 'required');
        $this->form_validation->set_rules('numero_importador', 'Número de Importador', 'required');
        $this->form_validation->set_rules('idcertificado', 'ID Certificado', 'required|integer');
        $this->form_validation->set_rules('factor_correccion', 'Factor de Corrección', 'required|decimal');

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $where = $this->input->post();

            $id = $this->parametros_model->update_parametros_empresa($where);

            if ($id) {
                $json = array(
                    'status' => 'ok'
                );
                echo json_encode($json);
            } else {
                $json = array(
                    'status' => 'error',
                    'data' => '<p>No se pudieron actualizar los datos.</p>'
                );
                echo json_encode($json);
            }
        }
    }
    
    public function get_parametros_empresa_json() {
        $parametro = $this->parametros_model->get_parametros_empresa();
        
        echo json_encode($parametro);
    }

}

?>
