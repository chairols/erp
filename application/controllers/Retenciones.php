<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Retenciones extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array(
            'session',
            'r_session',
            'form_validation',
            'pagination',
            'tcpdf/tcpdf'
        ));
        $this->load->model(array(
            'provincias_model',
            'proveedores_model',
            'parametros_model',
            'retenciones_model',
            'tipos_responsables_model',
            'padrones_model',
            'log_model'
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
        $session = $this->session->all_userdata();
        
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
                'alicuota' => 0
            );

            if ($this->input->post('idjurisdiccion') == "914") {  // Si la retención es de Misiones
                if ($proveedor['idprovincia'] == "14") {  // Si el proveedor es de misiones
                    $where = array(
                        'identificador' => '914_misiones'
                    );
                    $valor = $this->parametros_model->get_where($where);
                    $set['alicuota'] = $valor['valor_sistema'];
                } else {   // Si el proveedor no es misiones
                    $where = array(
                        'identificador' => '914_no_misiones'
                    );
                    $valor = $this->parametros_model->get_where($where);
                    $set['alicuota'] = $valor['valor_sistema'];
                }
            }

            if ($this->input->post('idjurisdiccion') == "901") { // Si la retención es de CABA
                $where = array(
                    'idjurisdiccion_afip' => $this->input->post('idjurisdiccion'),
                    'cuit' => $proveedor['cuit'],
                    'fecha_desde <=' => $this->formatear_fecha($this->input->post('fecha')),
                    'fecha_hasta >=' => $this->formatear_fecha($this->input->post('fecha'))
                );
                $resultado = $this->padrones_model->get_where($where);

                if ($resultado) {
                    $set['alicuota'] = $resultado['retencion'];
                }
            }

            $id = $this->retenciones_model->set($set);
            if ($id) {
                $log = array(
                    'tabla' => 'retenciones',
                    'idtabla' => $id,
                    'texto' => "<h2><strong>Se cre&oacute; la retenci&oacute;n n&uacute;mero: ". str_pad($set['punto'], 4, '0', STR_PAD_LEFT)."-". str_pad($set['numero'], 8, '0', STR_PAD_LEFT)."</strong></h2>

<p><strong>Punto de la retenci&oacute;n: </strong>".str_pad($set['punto'], 4, '0', STR_PAD_LEFT)."<br />
<strong>N&uacute;mero de Retenci&oacute;n: </strong>".str_pad($set['numero'], 8, '0', STR_PAD_LEFT)."<br />
<strong>ID Proveedor: </strong>".$set['idproveedor']."<br />
<strong>Proveedor: </strong>".$set['proveedor']."<br />
<strong>Direcci&oacute;n: </strong>".$set['direccion']."<br />
<strong>Localidad: </strong>".$set['localidad']."<br />
<strong>C&oacute;digo Postal: </strong>".$set['codigopostal']."<br />
<strong>ID Provincia: </strong>".$set['idprovincia']."<br />
<strong>Provincia: </strong>".$set['provincia']."<br />
<strong>CUIT: </strong>".$set['cuit']."<br />
<strong>Ingresos Brutos: </strong>".$set['iibb']."<br />
<strong>Fecha: </strong>".$this->formatear_fecha($this->input->post('fecha'))."<br />
<strong>ID Jurisdiccion: </strong>".$this->input->post('idjurisdiccion')."<br />
<strong>Al&iacute;cuota: </strong>".$set['alicuota']."</p>",
                    'idusuario' => $session['SID'],
                    'tipo' => 'add'
                );
                $this->log_model->set($log);
                
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
            redirect('/retenciones/listar/', 'refresh');
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

    public function gets_items_table_body_ajax() {
        $this->form_validation->set_rules('idretencion', 'ID de Retención', 'required|integer');

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $where = array(
                'idretencion' => $this->input->post('idretencion'),
                'estado' => 'A'
            );
            $data['retencion'] = $this->retenciones_model->get_where($where);
            $data['items'] = $this->retenciones_model->gets_items_where($where);

            foreach ($data['items'] as $key => $value) {
                $data['items'][$key]['fecha_formateada'] = $this->formatear_fecha_para_mostrar($value['fecha']);
            }

            $this->load->view('retenciones/gets_items_table_body_ajax', $data);
        }
    }

    public function agregar_item_ajax() {
        $this->form_validation->set_rules('idretencion', 'ID de Retención', 'required|integer');
        $this->form_validation->set_rules('punto_de_venta', 'Punto de Venta', 'required|integer');
        $this->form_validation->set_rules('comprobante', 'Comprobante', 'required|integer');
        $this->form_validation->set_rules('fecha', 'Fecha', 'required');
        $this->form_validation->set_rules('base_imponible', 'Base Imponible', 'required|decimal');

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $datos = array(
                'idretencion' => $this->input->post('idretencion'),
                'punto_de_venta' => $this->input->post('punto_de_venta'),
                'comprobante' => $this->input->post('comprobante'),
                'fecha' => $this->formatear_fecha($this->input->post('fecha')),
                'base_imponible' => $this->input->post('base_imponible')
            );
            $resultado = $this->retenciones_model->set_item($datos);
            if ($resultado) {
                $json = array(
                    'status' => 'ok',
                    'data' => 'Se agregó el comprobante.'
                );
                echo json_encode($json);
            } else {
                $json = array(
                    'status' => 'error',
                    'data' => 'No se pudo agregar el comprobante.'
                );
                echo json_encode($json);
            }
        }
    }

    public function borrar_item() {
        $this->form_validation->set_rules('idretencion_item', 'ID de Item de la Retención', 'required|integer');

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $datos = array(
                'estado' => 'I'
            );
            $where = array(
                'idretencion_item' => $this->input->post('idretencion_item')
            );
            $resultado = $this->retenciones_model->update_item($datos, $where);
            if ($resultado) {
                $json = array(
                    'status' => 'ok',
                    'data' => 'Se eliminó el comprobante.'
                );
                echo json_encode($json);
            } else {
                $json = array(
                    'status' => 'error',
                    'data' => 'No se pudo eliminar el comprobante.'
                );
                echo json_encode($json);
            }
        }
    }

    public function listar($pagina = 0) {
        $data['title'] = 'Listado de Retenciones';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array();
        $data['view'] = 'retenciones/listar';


        $per_page = $this->parametros_model->get_valor_parametro_por_usuario('per_page', $data['session']['SID']);
        $per_page = $per_page['valor'];

        $where = $this->input->get();
        $where['retenciones.estado'] = 'A';

        /*
         * inicio paginador
         */
        $total_rows = $this->retenciones_model->get_cantidad_where($where);
        $config['reuse_query_string'] = TRUE;
        $config['base_url'] = '/retenciones/listar/';
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

        $data['retenciones'] = $this->retenciones_model->gets_where_limit($where, $per_page, $pagina);

        $this->load->view('layout/app', $data);
    }

    public function pdf($idretencion = null) {
        if ($idretencion == null) {
            redirect('/retenciones/listar/', 'refresh');
        }
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

        // Parámetros de sistema
        $where = array(
            'identificador' => 'firma_presidente'
        );
        $data['firma'] = $this->parametros_model->get_where($where);

        // Datos de Retención
        $where = array(
            'idretencion' => $idretencion,
            'estado' => 'A'
        );
        $data['retencion'] = $this->retenciones_model->get_where($where);
        $data['retencion']['fecha_formateada'] = $this->formatear_fecha_para_mostrar($data['retencion']['fecha']);

        $where = array(
            'idjurisdiccion_afip' => $data['retencion']['idjurisdiccion_afip']
        );
        $data['jurisdiccion'] = $this->provincias_model->get_where($where);

        $where = array(
            'idretencion' => $data['retencion']['idretencion'],
            'estado' => 'A'
        );
        $data['retencion']['items'] = $this->retenciones_model->gets_items_where($where);
        foreach ($data['retencion']['items'] as $key => $value) {
            $data['retencion']['items'][$key]['fecha_formateada'] = $this->formatear_fecha_para_mostrar($value['fecha']);
        }

        // create new PDF document
        $pdf = new Tcpdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('ROLLER SERVICE S.A.');
        $pdf->SetTitle('Retención ' . str_pad($data['retencion']['punto'], 4, '0', STR_PAD_LEFT) . '-' . str_pad($data['retencion']['numero'], 8, '0', STR_PAD_LEFT));
        //$pdf->SetSubject('TCPDF Tutorial');
        //$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
        // set default header data
        $pdf->SetHeaderData('', '150', '', 'ORIGINAL');

        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));


        //$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);


        $pdf->AddPage();

        $html = $this->load->view('retenciones/pdf', $data);

        // output the HTML content
        $pdf->writeHTML($html->output->final_output, true, false, true, false, '');

        //$pdf->setFooterData(array(0, 64, 0), array(0, 64, 128));


        $pdf->Output('Retencion IIBB ' . str_pad($data['retencion']['punto'], 4, '0', STR_PAD_LEFT) . '-' . str_pad($data['retencion']['numero'], 8, '0', STR_PAD_LEFT) . '.pdf', 'I');
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