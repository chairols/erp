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
            'tcpdf/tcpdf',
            'numeroaletras',
            'email'
        ));
        $this->load->model(array(
            'provincias_model',
            'proveedores_model',
            'parametros_model',
            'retenciones_model',
            'tipos_responsables_model',
            'padrones_model',
            'log_model',
            'tipos_comprobantes_model'
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

        $data['jurisdicciones'] = $this->provincias_model->gets_order_by('idjurisdiccion_afip');

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
                'punto' => $punto_retencion['valor_sistema'],
                'estado' => 'A'
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

            if ($this->input->post('idjurisdiccion') == "902") { // Si la retención es de ARBA
                require_once('assets/vendors/afip/wsfe-class-ci.php');

                $anio = substr($this->input->post('fecha'), 6, 4);
                $mes = substr($this->input->post('fecha'), 3, 2);

                $fechadesde = $anio . $mes . '01';
                $fechahasta = $anio . $mes . date("d", (mktime(0, 0, 0, $mes + 1, 1, $anio) - 1));

                $wsfe = new WsFE();
                $wsfe->CUIT = floatval(30714016918);
                $wsfe->PasswodArba = "252729";

                if ($wsfe->ConsultaARBA(floatval($proveedor['cuit']), $fechadesde, $fechahasta, $alicuotas)) {
                    $percepcion = $alicuotas->percepcion;
                    $retencion = $alicuotas->retencion;

                    $set['alicuota'] = $retencion;
                }
            }

            $id = $this->retenciones_model->set($set);
            if ($id) {
                $log = array(
                    'tabla' => 'retenciones',
                    'idtabla' => $id,
                    'texto' => "<h2><strong>Se cre&oacute; la retenci&oacute;n n&uacute;mero: " . str_pad($set['punto'], 4, '0', STR_PAD_LEFT) . "-" . str_pad($set['numero'], 8, '0', STR_PAD_LEFT) . "</strong></h2>

<p><strong>Punto de la retenci&oacute;n: </strong>" . str_pad($set['punto'], 4, '0', STR_PAD_LEFT) . "<br />
<strong>N&uacute;mero de Retenci&oacute;n: </strong>" . str_pad($set['numero'], 8, '0', STR_PAD_LEFT) . "<br />
<strong>ID Proveedor: </strong>" . $set['idproveedor'] . "<br />
<strong>Proveedor: </strong>" . $set['proveedor'] . "<br />
<strong>Direcci&oacute;n: </strong>" . $set['direccion'] . "<br />
<strong>Localidad: </strong>" . $set['localidad'] . "<br />
<strong>C&oacute;digo Postal: </strong>" . $set['codigopostal'] . "<br />
<strong>ID Provincia: </strong>" . $set['idprovincia'] . "<br />
<strong>Provincia: </strong>" . $set['provincia'] . "<br />
<strong>CUIT: </strong>" . $set['cuit'] . "<br />
<strong>Ingresos Brutos: </strong>" . $set['iibb'] . "<br />
<strong>Fecha: </strong>" . $this->formatear_fecha($this->input->post('fecha')) . "<br />
<strong>ID Jurisdiccion: </strong>" . $this->input->post('idjurisdiccion') . "<br />
<strong>Al&iacute;cuota: </strong>" . $set['alicuota'] . "</p>",
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
        $where = array(
            'activo' => 'A'
        );
        $data['tipos_comprobantes'] = $this->tipos_comprobantes_model->gets_where($where);

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
        $session = $this->session->all_userdata();

        $this->form_validation->set_rules('idretencion', 'ID de Retención', 'required|integer');
        $this->form_validation->set_rules('idtipo_comprobante', 'Tipo de Comprobante', 'required|integer');
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
                'idtipo_comprobante' => $this->input->post('idtipo_comprobante'),
                'punto_de_venta' => $this->input->post('punto_de_venta'),
                'comprobante' => $this->input->post('comprobante'),
                'fecha' => $this->formatear_fecha($this->input->post('fecha')),
                'base_imponible' => $this->input->post('base_imponible')
            );
            $resultado = $this->retenciones_model->set_item($datos);
            if ($resultado) {
                $where = array(
                    'idtipo_comprobante' => $this->input->post('idtipo_comprobante')
                );
                $tipo_comprobante = $this->tipos_comprobantes_model->get_where($where);

                $log = array(
                    'tabla' => 'retenciones',
                    'idtabla' => $datos['idretencion'],
                    'texto' => "<h2><strong>Se agreg&oacute; el comprobante : " . str_pad($datos['punto_de_venta'], 4, '0', STR_PAD_LEFT) . "-" . str_pad($datos['comprobante'], 8, '0', STR_PAD_LEFT) . "</strong></h2>

<p>
<strong>Tipo de Comprobante: </strong>" . $tipo_comprobante['tipo_comprobante'] . " <br />
<strong>Punto del comprobante: </strong>" . str_pad($datos['punto_de_venta'], 4, '0', STR_PAD_LEFT) . "<br />
<strong>N&uacute;mero del comprobante: </strong>" . str_pad($datos['comprobante'], 8, '0', STR_PAD_LEFT) . "<br />
<strong>Fecha: </strong>" . $this->input->post('fecha') . "<br />
<strong>Base Imponible: </strong>" . $datos['base_imponible'] . "</p>",
                    'idusuario' => $session['SID'],
                    'tipo' => 'add'
                );
                $this->log_model->set($log);

                $where = array(
                    'idretencion' => $this->input->post('idretencion'),
                    'estado' => 'A'
                );
                $data['retencion'] = $this->retenciones_model->get_where($where);
                $data['items'] = $this->retenciones_model->gets_items_where($where);

                $total_base_imponible = 0;
                foreach ($data['items'] as $key => $value) {
                    $data['items'][$key]['fecha_formateada'] = $this->formatear_fecha_para_mostrar($value['fecha']);
                    $total_base_imponible += $value['base_imponible'];
                }

                $datos = array(
                    'monto_retenido' => round(($total_base_imponible * $data['retencion']['alicuota']) / 100, 2)
                );
                $where = array(
                    'idretencion' => $this->input->post('idretencion')
                );
                $this->retenciones_model->update($datos, $where);


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
        $session = $this->session->all_userdata();

        $this->form_validation->set_rules('idretencion_item', 'ID de Item de la Retención', 'required|integer');

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $where = array(
                'idretencion_item' => $this->input->post('idretencion_item')
            );
            $item = $this->retenciones_model->get_where_item($where);

            $datos = array(
                'estado' => 'I'
            );
            $where = array(
                'idretencion_item' => $this->input->post('idretencion_item')
            );
            $resultado = $this->retenciones_model->update_item($datos, $where);
            if ($resultado) {
                $log = array(
                    'tabla' => 'retenciones',
                    'idtabla' => $item['idretencion'],
                    'texto' => "<h2><strong>Se hizo borrado l&oacute;gico de comprobante " . str_pad($item['punto_de_venta'], 4, '0', STR_PAD_LEFT) . "-" . str_pad($item['comprobante'], 8, '0', STR_PAD_LEFT) . "</strong></h2>

<p><strong>ID Retenci&oacute;n: </strong>" . $item['idretencion'] . "<br />
<strong>ID Retenci&oacute;n Item: </strong>" . $item['idretencion_item'] . "<br />
<strong>Punto de Venta: </strong>" . str_pad($item['punto_de_venta'], 4, '0', STR_PAD_LEFT) . "<br />
<strong>N&uacute;mero de Comprobante: </strong>" . str_pad($item['comprobante'], 8, '0', STR_PAD_LEFT) . "<br />
<strong>Fecha: </strong>" . $this->formatear_fecha_para_mostrar($item['fecha']) . "<br />
<strong>Base Imponible: </strong>" . $item['base_imponible'] . "</p>",
                    'idusuario' => $session['SID'],
                    'tipo' => 'del'
                );
                $this->log_model->set($log);


                $where = array(
                    'idretencion' => $item['idretencion'],
                    'estado' => 'A'
                );
                $data['retencion'] = $this->retenciones_model->get_where($where);
                $data['items'] = $this->retenciones_model->gets_items_where($where);

                $total_base_imponible = 0;
                foreach ($data['items'] as $key => $value) {
                    $data['items'][$key]['fecha_formateada'] = $this->formatear_fecha_para_mostrar($value['fecha']);
                    $total_base_imponible += $value['base_imponible'];
                }

                $datos = array(
                    'monto_retenido' => round(($total_base_imponible * $data['retencion']['alicuota']) / 100, 2)
                );
                $where = array(
                    'idretencion' => $item['idretencion']
                );
                $this->retenciones_model->update($datos, $where);


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
        $data['javascript'] = array(
            '/assets/modulos/retenciones/js/listar.js'
        );
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
        
        $data['numeroaletras'] = $this->numeroaletras->convertir($data['retencion']['monto_retenido'], 'pesos', 'centavos');

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

    public function borrar_retencion_ajax() {
        $session = $this->session->all_userdata();

        $this->form_validation->set_rules('idretencion', 'ID Retención', 'required|integer');

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
                'idretencion' => $this->input->post('idretencion')
            );
            $resultado = $this->retenciones_model->update($datos, $where);
            if ($resultado) {
                $log = array(
                    'tabla' => 'retenciones',
                    'idtabla' => $this->input->post('idretencion'),
                    'texto' => "<h2><strong>Se borró la retención (Borrado lógico)</strong></h2>",
                    'idusuario' => $session['SID'],
                    'tipo' => 'del'
                );
                $this->log_model->set($log);

                $json = array(
                    'status' => 'ok',
                    'data' => 'Se borró correctamente'
                );
                echo json_encode($json);
            } else {
                $json = array(
                    'status' => 'error',
                    'data' => 'No se pudo borrar la retención.'
                );
                echo json_encode($json);
            }
        }
    }

    public function update_monto_retenido() {
        $this->form_validation->set_rules('monto_retenido', 'Monto Retenido', 'required|decimal');
        $this->form_validation->set_rules('idretencion', 'ID Retención', 'required|integer');

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $datos = array(
                'monto_retenido' => $this->input->post('monto_retenido')
            );
            $where = array(
                'idretencion' => $this->input->post('idretencion')
            );
            $resultado = $this->retenciones_model->update($datos, $where);
            if ($resultado) {
                $json = array(
                    'status' => 'ok',
                    'data' => 'Se actualizo correctamente el monto retenido'
                );
                echo json_encode($json);
            } else {
                $json = array(
                    'status' => 'error',
                    'data' => 'Ocurrió un error inesperado'
                );
                echo json_encode($json);
            }
        }
    }

    public function reporte() {
        $data['title'] = 'Reporte de Retenciones';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array(
            '/assets/modulos/retenciones/js/reporte.js'
        );
        $data['view'] = 'retenciones/reporte';

        $data['provincias'] = $this->provincias_model->gets();

        $this->load->view('layout/app', $data);
    }

    public function reporte_ajax() {
        $this->form_validation->set_rules('idjurisdiccion_afip', 'Jurisdiccion', 'required');
        $this->form_validation->set_rules('fecha_desde', 'Fecha Desde', 'required');
        $this->form_validation->set_rules('fecha_hasta', 'Fecha Hasta', 'required');


        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $where = array(
                'idjurisdiccion_afip' => $this->input->post('idjurisdiccion_afip')
            );
            $data['provincia'] = $this->provincias_model->get_where($where);

            $where = array(
                'retenciones.fecha >=' => $this->formatear_fecha($this->input->post('fecha_desde')),
                'retenciones.fecha <=' => $this->formatear_fecha($this->input->post('fecha_hasta')),
                'retenciones.idjurisdiccion_afip' => $this->input->post('idjurisdiccion_afip'),
                'retenciones.estado' => 'A'
            );
            $data['where'] = array(
                'fecha_desde' => $this->input->post('fecha_desde'),
                'fecha_hasta' => $this->input->post('fecha_hasta')
            );

            $data['retenciones'] = $this->retenciones_model->gets_where($where);
            foreach ($data['retenciones'] as $key => $value) {
                $data['retenciones'][$key]['fecha_formateada'] = $this->formatear_fecha_para_mostrar($value['fecha']);
            }

            $this->load->view('retenciones/reporte_ajax', $data);
        }
    }
    
    public function ddjj() {
        $this->form_validation->set_rules('idjurisdiccion_afip', 'ID Jurisdicción Afip', 'required|integer');
        $this->form_validation->set_rules('fecha_desde', 'Fecha Desde', 'required');
        $this->form_validation->set_rules('fecha_hasta', 'Fecha Hasta', 'required');
        
        if($this->form_validation->run() == FALSE) {
            show_404(validation_errors());
        } else {
            $where = array(
                'retenciones.fecha >=' => $this->formatear_fecha($this->input->post('fecha_desde')),
                'retenciones.fecha <=' => $this->formatear_fecha($this->input->post('fecha_hasta')),
                'retenciones.idjurisdiccion_afip' => $this->input->post('idjurisdiccion_afip'),
                'retenciones.estado' => 'A'
            );
            $retenciones = $this->retenciones_model->gets_where($where);
            foreach($retenciones as $key => $value) {
                $where = array(
                    'idretencion' => $value['idretencion'],
                    'estado' => 'A'
                );
                $retenciones[$key]['items'] = $this->retenciones_model->gets_items_where($where);
            }
            
            if($this->input->post('idjurisdiccion_afip') == '914') {  // Si es Misiones
                header("Content-type: text/plain");
                header("Content-Disposition: attachment; filename=Misiones.txt");
                $string = "";
                foreach($retenciones as $retencion) {
                    $string .= str_replace("/", "-", $this->formatear_fecha_para_mostrar($retencion['fecha']));
                    $string .= ",";
                    $string .= str_pad($retencion['punto'], 4, '0', STR_PAD_LEFT);
                    $string .= str_pad($retencion['numero'], 8, '0', STR_PAD_LEFT);
                    $string .= ",";
                    $string .= str_replace(",", ".", $retencion['proveedor']);
                    $string .= ",";
                    $string .= str_replace(",", ".", $retencion['direccion']);
                    $string .= ",";
                    $string .= substr($retencion['cuit'], 0, 2);
                    $string .= "-";
                    $string .= substr($retencion['cuit'], 2, 8);
                    $string .= "-";
                    $string .= substr($retencion['cuit'], 10, 1);
                    $string .= ",";
                    $base_imponible = 0;
                    foreach($retencion['items'] as $item) {
                        $base_imponible += $item['base_imponible'];
                    }
                    $string .= $base_imponible;
                    $string .= ",";
                    $string .= $retencion['alicuota'];
                    
                    $string .= "\r\n";
                } 
                
                echo $string;
            } elseif($this->input->post('idjurisdiccion_afip') == '902') {  // Si es Buenos Aires
                $empresa = $this->parametros_model->get_parametros_empresa();
                $quincena = '';
                
                if(substr($this->input->post('fecha_desde'), 0, 2) <= 15) {
                    $quincena = '1';
                } else {
                    $quincena = '2';
                }
                
                $archivo = 'AR-';
                $archivo .= $empresa['cuit'];
                $archivo .= '-';
                $archivo .= substr($this->input->post('fecha_desde'), 6, 4); // Recolecto el año
                $archivo .= substr($this->input->post('fecha_desde'), 3, 2); // Recolecto el mes
                $archivo .= $quincena;
                $archivo .= '-6-LOTE1';
                
                header("Content-type: text/plain");
                header("Content-Disposition: attachment; filename=".$archivo.".TXT");
                $string = "";
                foreach($retenciones as $retencion) {
                    $string .= substr($retencion['cuit'], 0, 2);
                    $string .= "-";
                    $string .= substr($retencion['cuit'], 2, 8);
                    $string .= "-";
                    $string .= substr($retencion['cuit'], 10, 1);
                    $string .= $this->formatear_fecha_para_mostrar($retencion['fecha']);
                    $string .= str_pad($retencion['punto'], 4, '0', STR_PAD_LEFT);
                    $string .= str_pad($retencion['numero'], 8, '0', STR_PAD_LEFT);
                    $string .= str_pad($retencion['monto_retenido'], 11, '0', STR_PAD_LEFT);
                    $string .= 'A';
                    
                    $string .= "\r\n";
                }
                
                echo $string;
            }
        }
    }
    
    public function get_retencion_ajax() {

        $where = $this->input->post();
        $retencion = $this->retenciones_model->get_where($where);
        
        $where = array(
            'idproveedor' => $retencion['idproveedor']
        );
        $retencion['p'] = $this->proveedores_model->get_where($where);

        echo json_encode($retencion);
    }
    
    public function enviar_mail() {
        $where = array(
            'idretencion' => $this->input->post('idretencion')
        );
        $retencion = $this->retenciones_model->get_where($where);
        
        $subject = 'Se generó la retención '. str_pad($retencion['punto'], 4, '0', STR_PAD_LEFT).'-'. str_pad($retencion['numero'], 8, '0', STR_PAD_LEFT);
        
        $message = '<p>This message has been sent for testing purposes.</p>';

// Get full html:
        $body = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=' . strtolower(config_item('charset')) . '" />
    <title>' . html_escape($subject) . '</title>
    <style type="text/css">
        body {
            font-family: Arial, Verdana, Helvetica, sans-serif;
            font-size: 16px;
        }
    </style>
</head>
<body>
' . $message . ' <br>
    '. base_url().'retenciones/pdf/'.$this->input->post('idretencion').'/' .'
</body>
</html>';
// Also, for getting full html you may use the following internal method:
//$body = $this->email->full_html($subject, $message);
        
        $result = $this->email
                ->from('hernan.balboa@rollerservice.com.ar', 'Hernan - CodeIgniter Prueba')
                ->reply_to('hernan.balboa@rollerservice.com.ar')    // Optional, an account where a human being reads.
                ->to('hernanbalboa@gmail.com')
                //->to($this->input->post('email'))
                ->subject($subject)
                //->attach(base_url().'retenciones/pdf/'.$this->input->post('idretencion').'/', '', 'Nuevo Nombre.pdf')
                ->attach(base_url().'prueba/tcpdf/', '', 'Prueba de PDF generico.pdf')
                ->message($body)
                ->send();
        
        var_dump($result);
        echo '<br />';
        echo $this->email->print_debugger();

        exit;
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