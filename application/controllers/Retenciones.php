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
            'proveedores_model',
            'parametros_model',
            'retenciones_model',
            'tipos_responsables_model'
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
        $this->form_validation->set_rules('idproveedor', 'Proveedor', 'required|integer');
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
                'idproveedor' => $this->input->post('idproveedor')
            );
            $proveedor = $this->proveedores_model->get_where($where);

            $where = array(
                'identificador' => 'url_consulta_cuit'
            );
            $url_api = $this->parametros_model->get_where($where);
            //$contenido = json_decode(file_get_contents($url_api['valor_sistema'] . $empresa['cuit']));
            // Se trae de nuevo para evitar errores, suele fallar en la primera consulta
            //$contenido = json_decode(file_get_contents($url_api['valor_sistema'] . $empresa['cuit']));

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

            $where = array(
                'idprovincia' => $proveedor['idprovincia']
            );
            $provincia = $this->provincias_model->get_where($where);

            $set = array(
                'punto' => $punto_retencion['valor_sistema'],
                'numero' => $ultimo_numero,
                'idproveedor' => $this->input->post('idproveedor'),
                'proveedor' => $proveedor['proveedor'],
                'direccion' => $proveedor['domicilio'],
                'localidad' => $proveedor['localidad'],
                'codigopostal' => $proveedor['codigo_postal'],
                'idprovincia' => $proveedor['idprovincia'],
                'provincia' => $provincia['provincia'],
                'cuit' => $proveedor['cuit'],
                'iibb' => $proveedor['iibb'],
                'idtipo_responsable' => $proveedor['idtipo_responsable'],
                'fecha' => $this->formatear_fecha($this->input->post('fecha')),
                'idjurisdiccion_afip' => $this->input->post('idjurisdiccion'),
                'porcentaje' => 0
            );



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

    public function modificar($idretencion = null) {
        if ($idretencion == null) {
            show_404();
        }
        $data['title'] = 'Modificar Retención';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array(
            '/assets/modulos/retenciones/js/modificar.js'
        );
        $data['view'] = 'retenciones/modificar';

        // Retención
        $where = array(
            'idretencion' => $idretencion
        );
        $data['retencion'] = $this->retenciones_model->get_where($where);
        $data['retencion']['fecha'] = $this->formatear_fecha_para_mostrar($data['retencion']['fecha']);
        $where = array(
            'idtipo_responsable' => $data['retencion']['idtipo_responsable']
        );
        $data['retencion']['iva'] = $this->tipos_responsables_model->get_where($where);
        $where = array(
            'idjurisdiccion_afip' => $data['retencion']['idjurisdiccion_afip']
        );
        $data['retencion']['jurisdiccion'] = $this->provincias_model->get_where($where);

        // Empresa emisora
        $data['parametro'] = $this->parametros_model->get_parametros_empresa();
        $where = array(
            'idprovincia' => $data['parametro']['idprovincia']
        );
        $data['parametro']['provincia'] = $this->provincias_model->get_where($where);
        $where = array(
            'idtipo_responsable' => $data['parametro']['idtipo_responsable']
        );
        $data['parametro']['iva'] = $this->tipos_responsables_model->get_where($where);

        $this->load->view('layout/app', $data);
    }

    public function update_ajax() {
        $this->form_validation->set_rules('alicuota', 'Alícuota', 'required|decimal');
        $this->form_validation->set_rules('idretencion', 'ID de Retención', 'required|integer');

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $datos = $this->input->post();
            $where = array(
                'idretencion' => $this->input->post('idretencion')
            );
            $resultado = $this->retenciones_model->update($datos, $where);

            if ($resultado) {
                $json = array(
                    'status' => 'ok',
                    'data' => 'La alícuota se actualizó correctamente'
                );
                echo json_encode($json);
            } else {
                $json = array(
                    'status' => 'error',
                    'data' => 'No se pudo actualizar'
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