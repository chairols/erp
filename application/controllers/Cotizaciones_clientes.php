<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cotizaciones_clientes extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array(
            'session',
            'r_session',
            'form_validation'
        ));
        $this->load->model(array(
            'monedas_model',
            'cotizaciones_clientes_model',
            'clientes_model',
            'log_model'
        ));
        
        $session = $this->session->all_userdata();
        $this->r_session->check($session);
    }

    public function agregar() {
        $data['title'] = 'Nueva Cotización';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array(
            '/assets/modulos/cotizaciones_clientes/js/agregar.js'
        );
        $data['view'] = 'cotizaciones_clientes/agregar';
        
        $data['monedas'] = $this->monedas_model->gets();

        $this->load->view('layout/app', $data);
    }

    public function agregar_ajax() {
        $session = $this->session->all_userdata();
        
        $this->form_validation->set_rules('idcliente', 'Cliente', 'required|integer');
        $this->form_validation->set_rules('idmoneda', 'Moneda', 'required|integer');
        $this->form_validation->set_rules('fecha', 'Fecha', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $set = array(
                'idcliente' => $this->input->post('idcliente'),
                'idmoneda' => $this->input->post('idmoneda'),
                'fecha' => $this->formatear_fecha($this->input->post('fecha')),
                'observaciones' => $this->input->post('observaciones'),
                'fecha_creacion' => date("Y-m-d H:i:s"),
                'idcreador' => $session['SID'],
                'actualizado_por' => $session['SID']
            );

            $id = $this->cotizaciones_clientes_model->set($set);
            
            if ($id) {
                $where = array(
                    'idcliente' => $this->input->post('idcliente')
                );
                $cliente = $this->clientes_model->get_where($where);

                $where = array(
                    'idmoneda' => $this->input->post('idmoneda')
                );
                $moneda = $this->monedas_model->get_where($where);

                $log = array(
                    'tabla' => 'cotizaciones_clientes',
                    'idtabla' => $id,
                    'texto' => "<h2><strong>Se creó la cotización de cliente número: " . $id . "</strong></h2>

<p>
<strong>Cliente: </strong>" . $cliente['cliente'] . "<br />
<strong>Moneda: </strong>" . $moneda['moneda'] . "<br />
<strong>Fecha de Cotización: </strong>" . $this->input->post('fecha') . "<br />
<strong>Observaciones: </strong>" . $this->input->post('observaciones') . "
</p>",
                    'idusuario' => $session['SID'],
                    'tipo' => 'add'
                );
                $this->log_model->set($log);

                $json = array(
                    'status' => 'ok',
                    'data' => $id
                );
                echo json_encode($json);
            }
        }
    }
    
    public function modificar($idcotizacion_cliente = null) {
        if ($idcotizacion_cliente == null) {
            redirect('/cotizaciones_clientes/listar/', 'refresh');
        }
        
        $data['title'] = 'Modificar Cotización a Cliente';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array(
            '/assets/modulos/cotizaciones_clientes/js/modificar.js'
        );
        $data['view'] = 'cotizaciones_clientes/modificar';

        $where = array(
            'idcotizacion_cliente' => $idcotizacion_cliente
        );
        $data['cotizacion_cliente'] = $this->cotizaciones_clientes_model->get_where($where);

        $where = array(
            'idcliente' => $data['cotizacion_cliente']['idcliente']
        );
        $data['cotizacion_cliente']['cliente'] = $this->clientes_model->get_where($where);

        $data['monedas'] = $this->monedas_model->gets();

        $data['cotizacion_cliente']['fecha_formateada'] = $this->formatear_fecha_para_mostrar($data['cotizacion_cliente']['fecha']);

        $this->load->view('layout/app', $data);
    }
    
    public function actualizar_cabecera_ajax() {
        $session = $this->session->all_userdata();

        $this->form_validation->set_rules('idcliente', 'Cliente', 'required|integer');
        $this->form_validation->set_rules('idmoneda', 'Moneda', 'required|integer');
        $this->form_validation->set_rules('fecha', 'Fecha', 'required');

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $datos = array(
                'idcliente' => $this->input->post('idcliente'),
                'idmoneda' => $this->input->post('idmoneda'),
                'fecha' => $this->formatear_fecha($this->input->post('fecha')),
                'observaciones' => $this->input->post('observaciones'),
                'actualizado_por' => $session['SID']
            );
            $where = array(
                'idcotizacion_cliente' => $this->input->post('idcotizacion_cliente')
            );

            $resultado = $this->cotizaciones_clientes_model->update($datos, $where);

            if ($resultado) {
                $where = array(
                    'idcliente' => $this->input->post('idcliente')
                );
                $cliente = $this->clientes_model->get_where($where);

                $where = array(
                    'idmoneda' => $this->input->post('idmoneda')
                );
                $moneda = $this->monedas_model->get_where($where);

                $log = array(
                    'tabla' => 'cotizaciones_clientes',
                    'idtabla' => $this->input->post('idcotizacion_cliente'),
                    'texto' => "<h2><strong>Se actualizó la cabecera de la cotización de cliente N°: " . $this->input->post('idcotizacion_cliente') . "</strong></h2>

<p><strong>Proveedor: </strong>" . $cliente['cliente'] . "<br />
<strong>Moneda: </strong>" . $moneda['moneda'] . "<br />
<strong>Fecha de Cotizació: </strong>" . $this->input->post('fecha') . "<br />
<strong>Observaciones: </strong>" . $this->input->post('observaciones') . "</p>",
                    'idusuario' => $session['SID'],
                    'tipo' => 'edit'
                );
                $this->log_model->set($log);

                $json = array(
                    'status' => 'ok',
                    'data' => 'Se actualizó la cabecera de la cotización'
                );
                echo json_encode($json);
            } else {
                $json = array(
                    'status' => 'error',
                    'data' => 'No se pudo actualizar la cabecera de la cotización'
                );
                echo json_encode($json);
            }
        }
    }
    
    public function listar_articulos_tabla_ajax() {
        $where = array(
            'idcotizacion_cliente' => $this->input->post('idcotizacion_cliente'),
            'estado' => 'A'
        );

        $data['articulos'] = $this->cotizaciones_clientes_model->gets_articulos_where($where);
        foreach ($data['articulos'] as $key => $value) {
            $where = array(
                'idarticulo' => $value['idarticulo']
            );
            $data['articulos'][$key]['articulo'] = $this->articulos_model->get_where($where);

            $where = array(
                'idmarca' => $data['articulos'][$key]['articulo']['idmarca']
            );
            $data['articulos'][$key]['marca'] = $this->marcas_model->get_where($where);

            $data['articulos'][$key]['fecha_formateada'] = $this->formatear_fecha_para_mostrar($value['fecha']);
        }

        $this->load->view('cotizaciones_clientes/listar_articulos_tabla_ajax', $data);
    }
    
    private function formatear_fecha($fecha) {
        $aux = '';
        $aux .= substr($fecha, 6, 4);
        $aux .= '-';
        $aux .= substr($fecha, 3, 2);
        $aux .= '-';
        $aux .= substr($fecha, 0, 2);

        return $aux;
    }
    
    private function formatear_fecha_para_mostrar($fecha) {
        $aux = '';
        $aux .= substr($fecha, 8, 2);
        $aux .= '/';
        $aux .= substr($fecha, 5, 2);
        $aux .= '/';
        $aux .= substr($fecha, 0, 4);

        return $aux;
    }
}

?>