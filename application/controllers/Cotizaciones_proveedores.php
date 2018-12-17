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
            'log_model',
            'parametros_model'
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
                    'texto' => "<h2><strong>Se creó la cotización de proveedor número: " . $id . "</strong></h2>

<p>
<strong>Proveedor: </strong>" . $proveedor['proveedor'] . "<br />
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

    public function modificar($idcotizacion_proveedor = null) {
        if ($idcotizacion_proveedor == null) {
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

    public function actualizar_cabecera_ajax() {
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
            $datos = array(
                'idproveedor' => $this->input->post('idproveedor'),
                'idmoneda' => $this->input->post('idmoneda'),
                'fecha' => $this->formatear_fecha($this->input->post('fecha')),
                'observaciones' => $this->input->post('observaciones'),
                'actualizado_por' => $session['SID']
            );
            $where = array(
                'idcotizacion_proveedor' => $this->input->post('idcotizacion_proveedor')
            );

            $resultado = $this->cotizaciones_proveedores_model->update($datos, $where);

            if ($resultado) {
                $where = array(
                    'idproveedor' => $this->input->post('idproveedor')
                );
                $proveedor = $this->proveedores_model->get_where($where);

                $where = array(
                    'idmoneda' => $this->input->post('idmoneda')
                );
                $moneda = $this->monedas_model->get_where($where);

                $log = array(
                    'tabla' => 'retenciones',
                    'idtabla' => $this->input->post('idcotizacion_proveedor'),
                    'texto' => "<h2><strong>Se actualizó la cabecera de la cotización de proveedor N°: " . $this->input->post('idcotizacion_proveedor') . "</strong></h2>

<p><strong>Proveedor: </strong>" . $proveedor['proveedor'] . "<br />
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

    public function agregar_archivos_ajax() {
        $session = $this->session->all_userdata();
        
        $this->form_validation->set_rules('idcotizacion_proveedor', 'ID Cotización', 'required|integer');

        if ($this->form_validation->run() == FALSE) {
            show_404();
        } else {
            $where = array(
                'identificador' => 'url_files_cotiz_prov',
                'idparametro_tipo' => 3
            );
            $url = $this->parametros_model->get_where($where);
            
            $filesCount = count($_FILES['files']['name']);
            for ($i = 0; $i < $filesCount; $i++) {
                $_FILES['file']['name'] = $_FILES['files']['name'][$i];
                $_FILES['file']['type'] = $_FILES['files']['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
                $_FILES['file']['error'] = $_FILES['files']['error'][$i];
                $_FILES['file']['size'] = $_FILES['files']['size'][$i];

                $f = explode('.', $_FILES['file']['name']);

                $config['upload_path'] = '.'.$url['valor_sistema'];
                $config['allowed_types'] = '*';
                //$config['file_name'] = $_FILES['file']['name'];
                $config['owerwrite'] = FALSE;
                $config['encrypt_name'] = TRUE;

                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('file')) {
                    $error = array('error' => $this->upload->display_errors());
                    show_404();
                } else {
                    $data = array('upload_data' => $this->upload->data());
                    
                    $datos = array(
                        'idcotizacion_proveedor' => $this->input->post('idcotizacion_proveedor'),
                        'nombre' => $_FILES['file']['name'],
                        'url' => $url['valor_sistema'].$data['upload_data']['file_name'],
                        'fecha_creacion' => date("Y-m-d H:i:s"),
                        'idcreador' => $session['SID'],
                        'actualizado_por' => $session['SID']
                    );
                    
                    $this->cotizaciones_proveedores_model->set_archivos($datos);
                    
                }
            }
        }

    }

    public function listar_archivos_tabla_ajax() {
        $where = array(
            'idcotizacion_proveedor' => $this->input->post('idcotizacion_proveedor')
        );
        $data['archivos'] = $this->cotizaciones_proveedores_model->gets_archivos_where($where);

        $this->load->view('cotizaciones_proveedores/listar_archivos_tabla_ajax', $data);
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