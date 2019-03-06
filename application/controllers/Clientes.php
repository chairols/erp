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
            'sucursales_model',
            'parametros_model',
            'provincias_model',
            'monedas_model',
            'paises_model',
            'log_model',
            'tipos_responsables_model'
        ));

        $session = $this->session->all_userdata();
        $this->r_session->check($session);
    }

    public function listar($pagina = 0) {
        $data['title'] = 'Listado de Clientes';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['view'] = 'clientes/listar';

        $per_page = $this->parametros_model->get_valor_parametro_por_usuario('per_page', $data['session']['SID']);
        $per_page = $per_page['valor'];

        $where = $this->input->get();
        $where['clientes.estado'] = 'A';

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

    public function agregar() {

        $data['title'] = 'Agregar Cliente';

        $data['session'] = $this->session->all_userdata();

        $data['menu'] = $this->r_session->get_menu();

        $data['javascript'] = array(
            '/assets/modulos/clientes/js/agregar.js'
        );

        $data['view'] = 'clientes/agregar';

        $this->load->view('layout/app', $data);
    }

    public function agregar_ajax() {
        $session = $this->session->all_userdata();

        $this->form_validation->set_rules('cliente', 'Cliente', 'required');
        $this->form_validation->set_rules('cuit', 'CUIT', 'required');

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $set = $this->input->post();
            $set['cuit'] = str_replace("-", "", $set['cuit']);
            $set['fecha_creacion'] = date("Y-m-d H:i:s");
            $set['idcreador'] = $session['SID'];
            $set['actualizado_por'] = $session['SID'];
            $id = $this->clientes_model->set($set);

            if ($id) {
                $log = array(
                    'tabla' => 'clientes',
                    'idtabla' => $id,
                    'texto' => "<h2><strong>Se agregó el cliente: " . $this->input->post('cliente') . "</strong></h2>
                    <p><strong>ID Cliente: </strong>" . $id . "<br />
                    <strong>CUIT: </strong>" . $this->input->post('cuit') . "<br />",
                    'idusuario' => $session['SID'],
                    'tipo' => 'add'
                );

                $this->log_model->set($log);

                $json = array(
                    'status' => 'ok',
                    'data' => 'Se agregó el cliente ' . $this->input->post('cliente'),
                    'id' => $id
                );

                echo json_encode($json);
            } else {

                $json = array(
                    'status' => 'error',
                    'data' => 'No se pudo agregar'
                );

                echo json_encode($json);
            }
        }
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

        $where['estado'] = 'A';
        $data['sucursales'] = $this->sucursales_model->gets_where($where);

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
        $this->form_validation->set_rules('cliente', 'Cliente', 'required');
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

    public function nueva_sucursal_ajax() {

        $session = $this->session->all_userdata();

        $this->form_validation->set_rules('idcliente', 'ID de Cliente', 'required|integer');

        $this->form_validation->set_rules('nombre', 'Nombre Sucursal', 'required');

        if ($this->form_validation->run() == FALSE) {

            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );

            echo json_encode($json);
        } else {

            $datos = array(
                'idcliente' => $this->input->post('idcliente'),
                'sucursal' => $this->input->post('nombre'),
                'estado' => 'P',
                'creado_por' => $session['SID']
            );

            $resultado = $this->sucursales_model->set($datos);

            if ($resultado) {

                $where = array('idcliente' => $this->input->post('idcliente'));

                $data['cliente'] = $this->clientes_model->get_where($where);

                $where['idcliente_sucursal'] = $resultado;

                $data['sucursales'] = $this->sucursales_model->gets_where($where);

                $data['provincias'] = $this->provincias_model->gets();

                $data['paises'] = $this->paises_model->gets();

                $html = $this->load->view('clientes/sucursal', $data, TRUE);

                $json = array(
                    'html' => $html,
                    'menu_html' => '<div class="boton_sucursal_menu info-box-number" id="boton_sucursal_menu_' . $resultado . '" sucursal="' . $resultado . '" style="border-bottom:1px solid #eee;padding:10px 0px;cursor:pointer;">' . $this->input->post('nombre') . '</div>',
                    'status' => 'ok',
                    'data' => 'La sucursal ' . $this->input->post('nombre') . ' se creó correctamente'
                );

                echo json_encode($json);
            } else {

                $json = array(
                    'status' => 'error',
                    'data' => 'No se pudo crear la Sucursal'
                );

                echo json_encode($json);
            }
        }
    }

    public function modificar_sucursal_ajax() {

        $session = $this->session->all_userdata();

        $this->form_validation->set_rules('idcliente', 'ID de Cliente', 'required|integer');

        $this->form_validation->set_rules('idcliente_sucursal', 'ID de Sucursal de Cliente', 'required|integer');

        $this->form_validation->set_rules('sucursal', 'Nombre Sucursal', 'required');

        if ($this->form_validation->run() == FALSE) {

            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );

            echo json_encode($json);
        } else {

            $where = array(
                'idcliente' => $this->input->post('idcliente'),
                'idcliente_sucursal' => $this->input->post('idcliente_sucursal')
            );

            $datos = array(
                'sucursal' => $this->input->post('sucursal'),
                'estado' => 'A',
                'actualizado_por' => $session['SID']
            );

            if ($this->input->post('idpais')) {

                $datos['idpais'] = $this->input->post('idpais');
            }

            if ($this->input->post('idprovincia')) {

                $datos['idprovincia'] = $this->input->post('idprovincia');
            }

            if ($this->input->post('localidad')) {

                $datos['localidad'] = $this->input->post('localidad');
            }

            if ($this->input->post('direccion')) {

                $datos['direccion'] = $this->input->post('direccion');
            }

            if ($this->input->post('codigo_postal')) {

                $datos['codigo_postal'] = $this->input->post('codigo_postal');
            }

            if ($this->input->post('casa_central')) {

                $datos['casa_central'] = $this->input->post('casa_central');

                if ($datos['casa_central'] == 'S') {

                    $this->sucursales_model->update(array('casa_central' => 'N'), array('idcliente' => $this->input->post('idcliente')));
                }
            }

            $resultado = $this->sucursales_model->update($datos, $where);

            if (intval($resultado) >= 0) {

                $json = array(
                    'registros_modificados' => $resultado,
                    'status' => 'ok',
                    'data' => 'La sucursal ' . $this->input->post('sucursal') . ' se modificó correctamente'
                );

                echo json_encode($json);
            } else {

                $json = array(
                    'status' => 'error',
                    'data' => 'No se pudo modificar la Sucursal ' . $this->input->post('sucursal')
                );

                echo json_encode($json);
            }
        }
    }

    public function eliminar_sucursal_ajax() {

        $session = $this->session->all_userdata();

        $this->form_validation->set_rules('idcliente', 'ID de Cliente', 'required|integer');

        $this->form_validation->set_rules('idcliente_sucursal', 'ID de Sucursal de Cliente', 'required|integer');

        if ($this->form_validation->run() == FALSE) {

            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );

            echo json_encode($json);
        } else {

            $where = array(
                'idcliente' => $this->input->post('idcliente'),
                'idcliente_sucursal' => $this->input->post('idcliente_sucursal')
            );


            $datos = array(
                'estado' => 'I'
            );

            $resultado = $this->sucursales_model->update($datos, $where);

            if (intval($resultado) > 0) {

                $json = array(
                    'registros_modificados' => $resultado,
                    'status' => 'ok',
                    'data' => 'La sucursal ' . $this->input->post('sucursal') . ' se eliminó correctamente'
                );

                echo json_encode($json);
            } else {

                $json = array(
                    'status' => 'error',
                    'data' => 'No se pudo eliminar la Sucursal ' . $this->input->post('sucursal'),
                    'where' => $where
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

    public function validar_cuit_ajax() {

        $where = array(
            'cuit' => str_replace('-', '', $this->input->post('cuit'))
        );

        $clientes = $this->clientes_model->gets_where($where);

        if (count($clientes) > 0) {

            $json = array(
                'valid' => false
            );
        } else {

            $json = array(
                'valid' => true
            );
        }

        echo json_encode($json);
    }

}

?>
