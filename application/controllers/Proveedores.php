<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Proveedores extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array(
            'session',
            'r_session',
            'pagination',
            'form_validation'
        ));
        $this->load->model(array(
            'proveedores_model',
            'parametros_model',
            'provincias_model',
            'monedas_model',
            'paises_model',
            'tipos_responsables_model'
        ));

        $session = $this->session->all_userdata();
        $this->r_session->check($session);
    }

    public function gets_proveedores_ajax() {

        $where = $this->input->post();

        echo json_encode($this->proveedores_model->gets_where($where));
    }

    public function listar($pagina = 0) {
        $data['title'] = 'Listado de Proveedores';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['view'] = 'proveedores/listar';

        $per_page = $this->parametros_model->get_valor_parametro_por_usuario('per_page', $data['session']['SID']);
        $per_page = $per_page['valor'];

        $where = $this->input->get();
        $where['proveedores.estado'] = 'A';

        /*
         * inicio paginador
         */
        $total_rows = $this->proveedores_model->get_cantidad_where($where);
        $config['reuse_query_string'] = TRUE;
        $config['base_url'] = '/proveedores/listar/';
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

        $data['proveedores'] = $this->proveedores_model->gets_where_limit($where, $per_page, $pagina);

        $this->load->view('layout/app', $data);
    }

    public function modificar($idproveedor = null) {
        if ($idproveedor == null) {
            redirect('/proveedores/listar/', 'refresh');
        }
        $data['title'] = 'Modificar Proveedor';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array(
            '/assets/modulos/proveedores/js/modificar.js'
        );
        $data['view'] = 'proveedores/modificar';

        $where = array(
            'idproveedor' => $idproveedor
        );
        $data['proveedor'] = $this->proveedores_model->get_where($where);

        $data['provincias'] = $this->provincias_model->gets();

        $data['paises'] = $this->paises_model->gets();

        $data['tipos_responsables'] = $this->tipos_responsables_model->gets();

        $data['monedas'] = $this->monedas_model->gets();

        $this->load->view('layout/app', $data);
    }

    public function modificar_ajax() {
        $session = $this->session->all_userdata();

        $_POST['cuit'] = str_replace("-", "", $this->input->post('cuit'));

        $this->form_validation->set_rules('idproveedor', 'ID de Proveedor', 'required|integer');
        $this->form_validation->set_rules('domicilio', 'Domicilio', 'required');
        $this->form_validation->set_rules('localidad', 'Localidad', 'required');
        $this->form_validation->set_rules('proveedor', 'Proveedor', 'required');
        $this->form_validation->set_rules('idprovincia', 'Provincia', 'required|integer');
        $this->form_validation->set_rules('idpais', 'Pais', 'required|integer');
        $this->form_validation->set_rules('idtipo_responsable', 'Tipo de IVA', 'required|integer');
        $this->form_validation->set_rules('saldo_cuenta_corriente', 'Saldo Cuenta Corriente', 'required|decimal');
        $this->form_validation->set_rules('saldo_inicial', 'Saldo Inicial', 'required|decimal');
        $this->form_validation->set_rules('saldo_a_cuenta', 'Saldo a Cuenta', 'required|decimal');
        $this->form_validation->set_rules('idmoneda', 'Moneda', 'required|integer');

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $datos = $this->input->post();
            $datos['actualizado_por'] = $session['SID'];
            $where = array(
                'idproveedor' => $this->input->post('idproveedor')
            );

            $resultado = $this->proveedores_model->update($datos, $where);
            if ($resultado) {
                $json = array(
                    'status' => 'ok',
                    'data' => 'El proveedor ' . $this->input->post('proveedor') . ' se actualizó correctamente'
                );
                echo json_encode($json);
            } else {
                $json = array(
                    'status' => 'error',
                    'data' => 'No se pudo actualizar el Proveedor'
                );
                echo json_encode($json);
            }
        }
    }

    public function agregar() {
        $data['title'] = 'Agregar Proveedor';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array(
            '/assets/modulos/proveedores/js/agregar.js'
        );
        $data['view'] = 'proveedores/agregar';

        $data['provincias'] = $this->provincias_model->gets();
        $data['paises'] = $this->paises_model->gets();
        $data['tipos_responsables'] = $this->tipos_responsables_model->gets();
        $data['monedas'] = $this->monedas_model->gets();


        $this->load->view('layout/app', $data);
    }

    public function agregar_ajax() {
        $session = $this->session->all_userdata();

        $this->form_validation->set_rules('proveedor', 'Proveedor', 'required');
        $this->form_validation->set_rules('domicilio', 'Domicilio', 'required');
        $this->form_validation->set_rules('localidad', 'Localidad', 'required');
        $this->form_validation->set_rules('idprovincia', 'Provincia', 'required|integer');
        $this->form_validation->set_rules('idpais', 'País', 'required|integer');
        $this->form_validation->set_rules('idtipo_responsable', 'Tipo de IVA', 'required|integer');
        $this->form_validation->set_rules('saldo_cuenta_corriente', 'Saldo Cuenta Corriente', 'required|decimal');
        $this->form_validation->set_rules('saldo_inicial', 'Saldo Inicial', 'required|decimal');
        $this->form_validation->set_rules('saldo_a_cuenta', 'Saldo a Cuenta', 'required|decimal');
        $this->form_validation->set_rules('idmoneda', 'Moneda', 'required|integer');

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $set = $this->input->post();
            $set['fecha_creacion'] = date("Y-m-d H:i:s");
            $set['idcreador'] = $session['SID'];
            $set['actualizado_por'] = $session['SID'];

            $id = $this->proveedores_model->set($set);

            if ($id) {
                
            } else {
                $json = array(
                    'status' => 'error',
                    'data' => 'No se pudo agregar'
                );
                echo json_encode($json);
            }
        }
    }

    public function checkCUIT_ajax() {
        $cuit = str_replace('-', "", $this->input->post('cuit'));

        if ($this->validarCUIT($cuit)) {
            $where = array(
                'cuit' => $cuit
            );
            $proveedor = $this->proveedores_model->get_where($where);

            if ($proveedor) {
                $json = array(
                    'status' => 'error',
                    'data' => 'Ya existe el CUIT con el proveedor ' . $proveedor['proveedor']
                );
            } else {
                $where = array(
                    'identificador' => 'url_consulta_cuit'
                );
                $parametro = $this->parametros_model->get_where($where);
                $url = $parametro['valor_sistema'];
                
                
                
                $json = array(
                    'status' => 'ok',
                    'data' => 'El CUIT es válido',
                    'url' => $url.$cuit
                );
            }

            echo json_encode($json);
        } else {
            $json = array(
                'status' => 'error',
                'data' => 'El CUIT es incorrecto'
            );
            echo json_encode($json);
        }
    }

    private function validarCUIT($cuit) {
        if (strlen($cuit) < 11) {
            return false;
        }

        $cadena = str_split($cuit);
        $result = $cadena[0] * 5;
        $result += $cadena[1] * 4;
        $result += $cadena[2] * 3;
        $result += $cadena[3] * 2;
        $result += $cadena[4] * 7;
        $result += $cadena[5] * 6;
        $result += $cadena[6] * 5;
        $result += $cadena[7] * 4;
        $result += $cadena[8] * 3;
        $result += $cadena[9] * 2;

        $div = intval($result / 11);
        $resto = $result - ($div * 11);
        if ($resto == 0) {
            if ($resto == $cadena[10]) {
                return true;
            } else {
                return false;
            }
        } elseif ($resto == 1) {
            if ($cadena[10] == 9 AND $cadena[0] == 2 AND $cadena[1] == 3) {
                return true;
            } elseif ($cadena[10] == 4 AND $cadena[0] == 2 AND $cadena[1] == 3) {
                return true;
            }
        } elseif ($cadena[10] == (11 - $resto)) {
            return true;
        } else {
            return false;
        }
    }

}

?>
