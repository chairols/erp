<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cotizaciones_proveedores extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array(
            'session',
            'r_session',
            'form_validation'
        ));
        $this->load->model(array(
            'monedas_model',
            'cotizaciones_proveedores_model',
            'proveedores_model',
            'monedas_model',
            'log_model'
        ));

        $session = $this->session->all_userdata();
        $this->r_session->check($session);
    }

    public function agregar() {
        $data['title'] = 'Nueva Cotización de Proveedores';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array(
            '/assets/modulos/cotizaciones_proveedores/js/agregar.js'
        );
        $data['view'] = 'cotizaciones_proveedores/agregar';

        $data['monedas'] = $this->monedas_model->gets();

        $this->load->view('layout/app', $data);
    }

    public function agregar_ajax() {
        $session = $this->session->all_userdata();

        $this->form_validation->set_rules('idproveedor', 'Proveedor', 'required|integer');
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
                'idproveedor' => $this->input->post('idproveedor'),
                'idmoneda' => $this->input->post('idmoneda'),
                'fecha' => $this->formatear_fecha($this->input->post('fecha')),
                'observaciones' => $this->input->post('observaciones'),
                'fecha_creacion' => date("Y-m-d H:i:s"),
                'idcreador' => $session['SID'],
                'actualizado_por' => $session['SID']
            );

            $id = $this->cotizaciones_proveedores_model->set($set);

            if ($id) {
                $where = array(
                    'idproveedor' => $this->input->post('idproveedor')
                );
                $proveedor = $this->proveedores_model->get_where($where);
                
                $where = array(
                    'idmoneda' => $this->input->post('idmoneda')
                );
                $moneda = $this->monedas_model->get_where($where);
                
                $log = array(
                    'tabla' => 'cotizaciones_proveedores',
                    'idtabla' => $id,
                    'texto' => "<h2><strong>Se creó la cotización de proveedor número: ".$id."</strong></h2>

<p>
<strong>Proveedor: </strong>". $proveedor['proveedor']."<br />
<strong>Moneda: </strong>".$moneda['moneda']."<br />
<strong>Fecha de Cotización: </strong>".$this->input->post('fecha')."<br />
<strong>Observaciones: </strong>".$this->input->post('observaciones')."
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
    
    public function modificar($idcotizacion_proveedor = null) {
        if($idcotizacion_proveedor == null) {
            redirect('/cotizaciones_proveedores/listar/', 'refresh');
        }
        
        $data['title'] = 'Modificar Cotización de Proveedores';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array(
            '/assets/modulos/cotizaciones_proveedores/js/modificar.js'
        );
        $data['view'] = 'cotizaciones_proveedores/modificar';
        
        $where = array(
            'idcotizacion_proveedor' => $idcotizacion_proveedor
        );
        $data['cotizacion_proveedor'] = $this->cotizaciones_proveedores_model->get_where($where);
        
        $where = array(
            'idproveedor' => $data['cotizacion_proveedor']['idproveedor']
        );
        $data['cotizacion_proveedor']['proveedor'] = $this->proveedores_model->get_where($where);
        
        $data['monedas'] = $this->monedas_model->gets();
        
        $data['cotizacion_proveedor']['fecha_formateada'] = $this->formatear_fecha_para_mostrar($data['cotizacion_proveedor']['fecha']);
        
        $this->load->view('layout/app', $data);
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