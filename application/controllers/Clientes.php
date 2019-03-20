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
            'log_model',
            'tipos_responsables_model',
            'condiciones_de_venta_model',
            'transportes_model',
            'empresas_tipos_model',
            'dias_model',
            'tipos_horarios_model',
            'cargos_model'
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

        $where['clientes_sucursales.estado'] = 'A';
        $data['sucursales'] = $this->clientes_model->gets_sucursales($where);

        $data['provincias'] = $this->provincias_model->gets();

        $data['paises'] = $this->paises_model->gets();

        $data['tipos_responsables'] = $this->tipos_responsables_model->gets();

        $data['empresas_tipos'] = $this->empresas_tipos_model->gets();

        $data['monedas'] = $this->monedas_model->gets();

        $data['condiciones'] = $this->condiciones_de_venta_model->gets();

        $data['dias'] = $this->dias_model->gets();

        $data['tipos_horarios'] = $this->tipos_horarios_model->gets();

        $data['transportes'] = $this->transportes_model->gets();
        
        $data['cargos'] = $this->cargos_model->gets();

        $this->load->view('layout/app', $data);
    }

    public function modificar_ajax() {
        $session = $this->session->all_userdata();

        $_POST['cuit'] = str_replace("-", "", $this->input->post('cuit'));

        $this->form_validation->set_rules('idcliente', 'ID de Cliente', 'required|integer');
        $this->form_validation->set_rules('cliente', 'Cliente', 'required');
        $this->form_validation->set_rules('idtipo_responsable', 'Tipo de IVA', 'required|integer');
        $this->form_validation->set_rules('saldo_cuenta_corriente', 'Saldo Cuenta Corriente', 'required|decimal');
        $this->form_validation->set_rules('saldo_inicial', 'Saldo Inicial', 'required|decimal');
        $this->form_validation->set_rules('saldo_a_cuenta', 'Saldo a Cuenta', 'required|decimal');
        $this->form_validation->set_rules('idmoneda', 'Moneda', 'required|integer');
        $this->form_validation->set_rules('idcondicion_de_venta', 'Condición de Venta', 'required|integer');
        $this->form_validation->set_rules('idmoneda_limite', 'Moneda Límite de Crédito', 'required|integer');
        $this->form_validation->set_rules('limite_credito', 'Límite de Crédito', 'required|decimal');

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
        $this->form_validation->set_rules('nombre', 'Nombre de Sucursal', 'required');
        
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
                'estado' => 'A',
                'creado_por' => $session['SID']
            );
            $resultado = $this->clientes_model->set_sucursal($datos);
            
            if ($resultado) {
                $where = array(
                    'idcliente' => $this->input->post('idcliente')
                );
                $data['cliente'] = $this->clientes_model->get_where($where);

                $where['idcliente_sucursal'] = $resultado;

                $data['sucursales'] = $this->clientes_model->gets_sucursales($where);
                $data['paises'] = $this->paises_model->gets();
                $data['provincias'] = $this->provincias_model->gets();
                $data['transportes'] = $this->transportes_model->gets();

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

            $datos = $this->input->post();
            $datos['estado'] = 'A';
            $datos['actualizado_por'] = $session['SID'];

            $resultado = $this->clientes_model->update_sucursal($datos, $where);

            if ($resultado) {
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
            $resultado = $this->clientes_model->update_sucursal($datos, $where);

            if($resultado) {
                $where = array(
                    'idcliente' => $this->input->post('idcliente'),
                    'idcliente_sucursal' => $this->input->post('idcliente_sucursal')
                );
                $sucursal = $this->clientes_model->get_where_sucursal($where);
                
                $where = array(
                    'idcliente' => $this->input->post('idcliente')
                );
                $cliente = $this->clientes_model->get_where($where);
                
                $log = array(
                    'tabla' => 'clientes_sucursales',
                    'idtabla' => $this->input->post('idcliente_sucursal'),
                    'texto' => "<h2><strong>Se eliminó la sucursal: " . $sucursal['sucursal'] . "</strong></h2>
                    <p><strong>ID Sucursal: </strong>" . $this->input->post('idcliente_sucursal') . "<br />
                    <strong>ID Cliente: </strong>".$cliente['idcliente']."<br />
                    <strong>Cliente: </strong>".$cliente['cliente'],
                    'idusuario' => $session['SID'],
                    'tipo' => 'del'
                );

                $this->log_model->set($log);
                
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

    public function agregar_horario_ajax() {
        $session = $this->session->all_userdata();

        $this->form_validation->set_rules('idcliente', 'ID de Cliente', 'required|integer');
        $this->form_validation->set_rules('iddia', 'Día de la Semana', 'required|integer');
        $this->form_validation->set_rules('desde', 'Horario Desde', 'required');
        $this->form_validation->set_rules('hasta', 'Horario Hasta', 'required');
        $this->form_validation->set_rules('idtipo_horario', 'Tipo de Horario', 'required|integer');

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $set = array(
                'idcliente' => $this->input->post('idcliente'),
                'iddia' => $this->input->post('iddia'),
                'desde' => $this->input->post('desde'),
                'hasta' => $this->input->post('hasta'),
                'idtipo_horario' => $this->input->post('idtipo_horario'),
                'observaciones' => $this->input->post('observaciones'),
                'fecha_creacion' => date("Y-m-d H:i:s"),
                'idcreador' => $session['SID'],
                'actualizado_por' => $session['SID']
            );

            
            $hora_desde = substr($this->input->post('desde'), 0, 2);
            $am_pm = substr($this->input->post('desde'), 6, 2);
            if($am_pm == 'PM') {
                $hora_desde += 12;
                if($hora_desde == 24){
                    $hora_desde = 12;
                }
            }
            $set['desde'] = $hora_desde.":".substr($this->input->post('desde'), 3, 2).":00";
            
            $hora_hasta = substr($this->input->post('hasta'), 0, 2);
            $am_pm = substr($this->input->post('hasta'), 6, 2);
            if($am_pm == 'PM') {
                $hora_hasta += 12;
                if($hora_hasta == 24) {
                    $hora_hasta = 12;
                }
            }
            $set['hasta'] = $hora_hasta.":".substr($this->input->post('hasta'), 3, 2).":00";
            
            
            $id = $this->clientes_model->set_horario($set);

            if ($id) {
                $where = array(
                    'iddia' => $this->input->post('iddia')
                );
                $dia = $this->dias_model->get_where($where);
                
                $where = array(
                    'idcliente' => $this->input->post('idcliente')
                );
                $cliente = $this->clientes_model->get_where($where);
                
                $where = array(
                    'idtipo_horario' => $this->input->post('idtipo_horario')
                );
                $tipo_horario = $this->tipos_horarios_model->get_where($where);
                
                
                $log = array(
                    'tabla' => 'clientes_horarios',
                    'idtabla' => $id,
                    'texto' => "<h2><strong>Se agregó el horario: " . $dia['dia'] . " ".$set['desde']." - ".$set['hasta']."</strong></h2>
                    <p><strong>ID Cliente: </strong>" . $this->input->post('idcliente') . "<br />
                    <strong>Cliente: </strong>".$cliente['cliente']."<br />
                    <strong>Tipo de Horario: </strong>".$tipo_horario['tipo_horario']."<br />
                    <strong>Observaciones: </strong>" . $this->input->post('observaciones'),
                    'idusuario' => $session['SID'],
                    'tipo' => 'add'
                );
                $this->log_model->set($log);
                
                $json = array(
                    'status' => 'ok',
                    'data' => 'Se agregó el horario'
                );
                echo json_encode($json);
            } else {
                $json = array(
                    'status' => 'error',
                    'data' => 'No se pudo agregar el horario'
                );
                echo json_encode($json);
            }
        }
    }

    public function gets_horarios_tabla() {
        $this->form_validation->set_rules('idcliente', 'ID de Cliente', 'required|integer');
        
        if($this->form_validation->run() == FALSE) {
            echo "<h3 class='txC'><strong>ERROR - No se hace referencia al Cliente</strong></h3>";
        } else {
            $where = array(
                'clientes_horarios.idcliente' => $this->input->post('idcliente'),
                'clientes_horarios.estado' => 'A'
            );
            $data['horarios'] = $this->clientes_model->gets_horarios_where($where);
            
            $this->load->view('clientes/gets_horarios_tabla', $data);
        }
    }
    
    public function borrar_horario_ajax() {
        $session = $this->session->all_userdata();
        
        $this->form_validation->set_rules('idcliente_horario', 'ID Horario de Cliente', 'required|integer');
        
        if($this->form_validation->run() == FALSE) {
            echo "<h3 class='txC'><strong>ERROR - No se hace referencia al Cliente</strong></h3>";
        } else {
            $datos = array(
                'estado' => 'I'
            );
            $where = array(
                'idcliente_horario' => $this->input->post('idcliente_horario')
            );
            
            $resultado = $this->clientes_model->update_horario($datos, $where);
            
            if ($resultado) {
                $where = array(
                    'idcliente_horario' => $this->input->post('idcliente_horario')
                );
                $cliente_horario = $this->clientes_model->get_where_horario($where);
                
                $where = array(
                    'iddia' => $cliente_horario['iddia']
                );
                $dia = $this->dias_model->get_where($where);
                
                $where = array(
                    'idcliente' => $cliente_horario['idcliente']
                );
                $cliente = $this->clientes_model->get_where($where);
                
                $log = array(
                    'tabla' => 'clientes_horarios',
                    'idtabla' => $this->input->post('idcliente_horario'),
                    'texto' => "<h2><strong>Se eliminó el horario: " . $dia['dia'] . "- ".$cliente_horario['desde']." - ".$cliente_horario['hasta']."</strong></h2>
                    <p><strong>ID Cliente: </strong>".$cliente['idcliente']."<br />
                    <strong>Cliente: </strong>".$cliente['cliente']."<br />",
                    'idusuario' => $session['SID'],
                    'tipo' => 'del'
                );

                $this->log_model->set($log);
                
                $json = array(
                    'status' => 'ok',
                    'data' => 'Se eliminó el horario'
                );
                echo json_encode($json);
            } else {
                $json = array(
                    'status' => 'error',
                    'data' => 'No se pudo borrar el horario'
                );
                echo json_encode($json);
            }
        }
    }
    
    public function agregar_agente_ajax() {
        $session = $this->session->all_userdata();
        
        $this->form_validation->set_rules('idcliente', 'Cliente', 'required|integer');
        $this->form_validation->set_rules('idcliente_sucursal', 'Sucursal', 'required|integer');
        $this->form_validation->set_rules('idcargo', 'Cargo', 'required|integer');
        $this->form_validation->set_rules('agente', 'Nombre', 'required');
        $this->form_validation->set_rules('email', 'Email', 'valid_email');
        
        if($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $set = array(
                'idcliente' => $this->input->post('idcliente'),
                'idcliente_sucursal' => $this->input->post('idcliente_sucursal'),
                'agente' => $this->input->post('agente'),
                'idcargo' => $this->input->post('idcargo'),
                'email' => $this->input->post('email'),
                'telefono' => $this->input->post('telefono'),
                'fecha_creacion' => date("Y-m-d H:i:s"),
                'idcreador' => $session['SID'],
                'actualizado_por' => $session['SID']
            );
            
            $id = $this->clientes_model->set_agente($set);
            
            if ($id) {
                $where = array(
                    'idcargo' => $this->input->post('idcargo')
                );
                $cargo = $this->cargos_model->get_where($where);
                
                $where = array(
                    'idcliente' => $this->input->post('idcliente')
                );
                $cliente = $this->clientes_model->get_where($where);
                
                $where = array(
                    'idcliente_sucursal' => $this->input->post('idcliente_sucursal')
                );
                $sucursal = $this->clientes_model->get_where_sucursal($where);
                
                $log = array(
                    'tabla' => 'clientes_agentes',
                    'idtabla' => $id,
                    'texto' => "<h2><strong>Se agregó el agente: " . $this->input->post('agente') . "</strong></h2>
                    <p><strong>ID Agente: </strong>" . $id . "<br />
                    <strong>Cliente: </strong>".$cliente['cliente']."<br />
                    <strong>ID Sucursal: </strong>" . $this->input->post('idcliente_sucursal'). "<br />
                    <strong>Sucursal: </strong>" . $sucursal['sucursal'] ."<br />
                    <strong>Cargo: </strong>" . $cargo['cargo'] ."<br />
                    <strong>Email: </strong>" . $this->input->post('email'). "<br />
                    <strong>Teléfono: </strong>" . $this->input->post('telefono'),
                    'idusuario' => $session['SID'],
                    'tipo' => 'add'
                );

                $this->log_model->set($log);
                
                $json = array(
                    'status' => 'ok',
                    'data' => 'Se agregó el agente'
                );
                echo json_encode($json);
            } else {
                $json = array(
                    'status' => 'error',
                    'data' => 'No se pudo agregar el agente'
                );
                echo json_encode($json);
            }
        }
    }
    
    public function gets_agentes_tabla() {
        $this->form_validation->set_rules('idcliente', 'ID de Cliente', 'required|integer');
        
        if($this->form_validation->run() == FALSE) {
            echo "<h3 class='txC'><strong>ERROR - No se hace referencia al Cliente</strong></h3>";
        } else {
            $where = array(
                'clientes_agentes.idcliente' => $this->input->post('idcliente'),
                'clientes_agentes.estado' => 'A'
            );
            $data['agentes'] = $this->clientes_model->gets_agentes_where($where);
            
            $this->load->view('clientes/gets_agentes_tabla', $data);
        }
    }
    
    public function borrar_agente_ajax() {
        $session = $this->session->all_userdata();
        
        $this->form_validation->set_rules('idcliente_agente', 'ID Horario de Cliente', 'required|integer');
        
        if($this->form_validation->run() == FALSE) {
            echo "<h3 class='txC'><strong>ERROR - No se hace referencia al Cliente</strong></h3>";
        } else {
            $datos = array(
                'estado' => 'I'
            );
            $where = array(
                'idcliente_agente' => $this->input->post('idcliente_agente')
            );
            
            $resultado = $this->clientes_model->update_agente($datos, $where);
            
            if ($resultado) {
                $where = array(
                    'idcliente_agente' => $this->input->post('idcliente_agente')
                );
                $agente = $this->clientes_model->get_where_agente($where);
                
                $where = array(
                    'idcliente' => $agente['idcliente']
                );
                $cliente = $this->clientes_model->get_where($where);
                
                $where = array(
                    'idcliente_sucursal' => $agente['idcliente_sucursal']
                );
                $sucursal = $this->clientes_model->get_where_sucursal($where);
                
                $log = array(
                    'tabla' => 'clientes_agentes',
                    'idtabla' => $this->input->post('idcliente_agente'),
                    'texto' => "<h2><strong>Se eliminó el agente: " . $agente['agente'] . "</strong></h2>
                    <p><strong>ID Agente: </strong>" . $this->input->post('idcliente_agente') . "<br />
                    <strong>ID Cliente: </strong>".$cliente['idcliente']."<br />
                    <strong>Cliente: </strong>".$cliente['cliente']."<br />
                    <strong>ID Sucursal: </strong>".$sucursal['idcliente_sucursal']."<br />
                    <strong>Sucursal: </strong>".$sucursal['sucursal'],
                    'idusuario' => $session['SID'],
                    'tipo' => 'del'
                );

                $this->log_model->set($log);
                
                $json = array(
                    'status' => 'ok',
                    'data' => 'Se eliminó el agente'
                );
                echo json_encode($json);
            } else {
                $json = array(
                    'status' => 'error',
                    'data' => 'No se pudo borrar el agente'
                );
                echo json_encode($json);
            }
        }
    }
}

?>
