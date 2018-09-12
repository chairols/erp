<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Retenciones extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array(
            'session',
            'r_session',
            'form_validation'
        ));
        $this->load->model(array(
            'provincias_model',
            'empresas_model',
            'parametros_model',
            'retenciones_model'
        ));

        $session = $this->session->all_userdata();
        $this->r_session->check($session);
    }

    public function agregar() {
        $data['title'] = 'Agregar Retención';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array(
            '/assets/modulos/retenciones/js/agregar.js'
        );
        $data['view'] = 'retenciones/agregar';

        $data['jurisdicciones'] = $this->provincias_model->gets();

        $this->load->view('layout/app', $data);
    }

    public function agregar_ajax() {
        $this->form_validation->set_rules('idempresa', 'Proveedor', 'required|integer');
        $this->form_validation->set_rules('idjurisdiccion', 'Jurisdicción', 'required|integer');
        $this->form_validation->set_rules('fecha', 'Fecha', 'required');

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $where = array(
                'idempresa' => $this->input->post('idempresa')
            );
            $empresa = $this->empresas_model->get_where($where);

            $where = array(
                'identificador' => 'url_consulta_cuit'
            );
            $url_api = $this->parametros_model->get_where($where);
            $contenido = json_decode(file_get_contents($url_api['valor_sistema'] . $empresa['cuit']));

            $where = array(
                'identificador' => 'punto_retencion'
            );
            $punto_retencion = $this->parametros_model->get_where($where);

            $where = array(
                'punto' => $punto_retencion['valor_sistema']
            );
            $ultimo_numero_array = $this->retenciones_model->get_max_numero_where($where);
            $ultimo_numero = 1;
            if ($ultimo_numero_array['numero']) {
                $ultimo_numero = $ultimo_numero_array['numero'] + 1;
            }

            $set = array(
                'punto' => $punto_retencion['valor_sistema'],
                'numero' => $ultimo_numero,
                'idempresa' => $this->input->post('idempresa'),
                'empresa' => $empresa['empresa'],
                //'direccion' =>  OK
                //'localidad' => OK
                //'codigopostal' =>  OK
                //'idprovincia' => OK
                //'provincia' => OK
                'cuit' => $empresa['cuit'],
                'iibb' => $empresa['iibb'],
                'idtipo_responsable' => $empresa['iva_id'],
                'fecha' => $this->formatear_fecha($this->input->post('fecha')),
                'idjurisdiccion_afip' => $this->input->post('idjurisdiccion'),
                    //'porcentaje' =>
            );

            if (!$contenido->errorGetData) {
                $set['direccion'] = $contenido->Contribuyente->domicilioFiscal->direccion;
                if(is_null($contenido->Contribuyente->domicilioFiscal->localidad)) {
                    $set['localidad'] = '';
                } else {
                    $set['localidad'] = $contenido->Contribuyente->domicilioFiscal->localidad;
                }
                $set['codigopostal'] = $contenido->Contribuyente->domicilioFiscal->codPostal;
                $set['idprovincia'] = $contenido->Contribuyente->domicilioFiscal->idProvincia;
                $set['provincia'] = $contenido->Contribuyente->domicilioFiscal->nombreProvincia;
            }

            $id = $this->retenciones_model->set($set);
            if ($id) {
                $json = array(
                    'status' => 'ok',
                    'data' => $id
                );
                echo json_encode($json);
            } else {
                $json = array(
                    'status' => 'error',
                    'data' => 'No se pudo crear la retención.'
                );
                echo json_encode($json);
            }
        }
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

}

?>
