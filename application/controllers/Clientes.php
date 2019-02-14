<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Clientes extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->library(array(
            'session',
            'r_session',
            'pagination',
            'form_validation'
        ));
        $this->load->model(array(
            'clientes_model',
            'parametros_model',
            'provincias_model',
            'monedas_model',
            'paises_model',
            'tipos_responsables_model'
        ));

        $session = $this->session->all_userdata();
        $this->r_session->check($session);
    }

    public function listar( $pagina = 0 )
    {

        $data[ 'title' ] = 'Listado de Clientes';

        $data[ 'session' ] = $this->session->all_userdata();

        $data[ 'menu' ] = $this->r_session->get_menu();

        $data[ 'view' ] = 'clientes/listar';

        $per_page = $this->parametros_model->get_valor_parametro_por_usuario( 'per_page', $data[ 'session' ][ 'SID' ] );

        $per_page = $per_page['valor'];

        $where = $this->input->get();

        $where[ 'clientes.estado' ] = 'A';

        /*
         * inicio paginador
         */
        $total_rows = $this->clientes_model->get_cantidad_where($where);
        $config['reuse_query_string'] = TRUE;
        $config['base_url'] = '/clientes/listar/';
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

        $data['clientes'] = $this->clientes_model->gets_where_limit($where, $per_page, $pagina);

        $this->load->view('layout/app', $data);
    }

    public function modificar($idcliente = null) {
        if ($idcliente == null) {
            redirect('/clientes/listar/', 'refresh');
        }
        $data['title'] = 'Modificar Cliente';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array(
            '/assets/modulos/clientes/js/modificar.js'
        );
        $data['view'] = 'clientes/modificar';

        $where = array(
            'idcliente' => $idcliente
        );
        $data['cliente'] = $this->clientes_model->get_where($where);

        $data['provincias'] = $this->provincias_model->gets();

        $data['paises'] = $this->paises_model->gets();

        $data['tipos_responsables'] = $this->tipos_responsables_model->gets();

        $data['monedas'] = $this->monedas_model->gets();

        $this->load->view('layout/app', $data);
    }

    public function modificar_ajax() {
        $session = $this->session->all_userdata();

        $_POST['cuit'] = str_replace("-", "", $this->input->post('cuit'));

        $this->form_validation->set_rules('idcliente', 'ID de Cliente', 'required|integer');
        $this->form_validation->set_rules('domicilio_fiscal', 'Domicilio Fiscal', 'required');
        $this->form_validation->set_rules('localidad', 'Localidad', 'required');
        $this->form_validation->set_rules('cliente', 'Cliente', 'required');
        $this->form_validation->set_rules('idprovincia', 'Provincia', 'required|integer');
        // $this->form_validation->set_rules('idpais', 'Pais', 'required|integer');
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
                'idcliente' => $this->input->post('idcliente')
            );

            $resultado = $this->clientes_model->update($datos, $where);
            if ($resultado) {
                $json = array(
                    'status' => 'ok',
                    'data' => 'El cliente ' . $this->input->post('cliente') . ' se actualizó correctamente'
                );
                echo json_encode($json);
            } else {
                $json = array(
                    'status' => 'error',
                    'data' => 'No se pudo actualizar el Cliente'
                );
                echo json_encode($json);
            }
        }
    }

    public function gets_clientes_ajax() {

        $where = $this->input->post();

        echo json_encode($this->clientes_model->gets_where($where));
    }

    public function gets_sucursales_select() {
        $where = array(
            'idcliente' => $this->input->post('idcliente')
        );
        $data['sucursales'] = $this->clientes_model->gets_sucursales($where);

        $this->load->view('clientes/gets_sucursales_select', $data);
    }
}

?>
