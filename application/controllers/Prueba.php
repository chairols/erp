<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Prueba extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function tcpdf() {
        $this->load->library(array(
            'tcpdf/tcpdf'
        ));
        $this->load->model(array(
            'importaciones_model'
        ));

        $importacion = $this->importaciones_model->get_where(array('idimportacion' => 8));
        $items = $this->importaciones_model->gets_items(array('idimportacion' => 8, 'importaciones_items.estado' => 'A'));

        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Hernán Balboa');
        $pdf->SetTitle('TCPDF Example 001');
        $pdf->SetSubject('TCPDF Tutorial');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE . ' 001', PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setFooterData(array(0, 64, 0), array(0, 64, 128));

// set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once(dirname(__FILE__) . '/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

// ---------------------------------------------------------
// set default font subsetting mode
        $pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
        $pdf->SetFont('dejavusans', '', 14, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
        $pdf->AddPage();

// set text shadow effect
        $pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));

// Set some content to print
        $html = <<<EOD
<h1>Welcome to <a href="http://www.tcpdf.org" style="text-decoration:none;background-color:#CC0000;color:black;">&nbsp;<span style="color:black;">TC</span><span style="color:white;">PDF</span>&nbsp;</a>!</h1>
<i>This is the first example of TCPDF library.</i>
<p>This text is printed using the <i>writeHTMLCell()</i> method but you can also use: <i>Multicell(), writeHTML(), Write(), Cell() and Text()</i>.</p>
<p>Please check the source code documentation and other examples for further information.</p>
<p style="color:#CC0000;">TO IMPROVE AND EXPAND TCPDF I NEED YOUR SUPPORT, PLEASE <a href="http://sourceforge.net/donate/index.php?group_id=128076">MAKE A DONATION!</a></p>
EOD;
        $html = "<table>"
                . "<thead>"
                . "<tr>"
                . "<th>Item</th>"
                . "<th>Cantidad</th>"
                . "<th>Precio Unitario</th>"
                . "</tr>"
                . "</thead>"
                . "<tbody>";
        foreach ($items as $item) {
            $html .= "<tr>"
                    . "<td>" . $item['articulo'] . "</td>"
                    . "<td>" . $item['cantidad'] . "</td>"
                    . "<td>" . $item['costo_fob'] . "</td>"
                    . "</tr>";
        }
        $html .= "</tbody>"
                . "</table>";

// Print text using writeHTMLCell()
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

// ---------------------------------------------------------
// Close and output PDF document
// This method has several options, check the source code documentation for more information.
        $pdf->Output('example_001.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
    }

    public function arba($cuit = 0, $fechadesde = null, $fechahasta = null) {
        require_once('assets/vendors/afip/wsfe-class-ci.php');

        // Certificado REAL
        $certificado = 'upload/certificados/PCAFIP_12e5d279ba7d69a7.crt';
        $clave = "upload/certificados/privada";

        // Configuración
        $CUIT = 33647656779;
        $urlwsaa = URLWSAA;
        /*
          $wsfe = new WsFE();
          $wsfe->CUIT = floatval($CUIT);
          $wsfe->setURL(URLWSW);
         */
        if ($fechadesde == null) {
            $fechadesde = date('Ym') . '01';
        }

        if ($fechahasta == null) {
            $mes = date('m');
            $anio = date('Y');
            $fechahasta = $anio . $mes . date("d", (mktime(0, 0, 0, $mes + 1, 1, $anio) - 1));
        }

        $wsfe = new WsFE();
        $wsfe->CUIT = floatval(30714016918);
        $wsfe->PasswodArba = "252729";
        if ($wsfe->ConsultaARBA(floatval($cuit), $fechadesde, $fechahasta, $alicuotas)) {
            $percepcion = $alicuotas->percepcion;
            $retencion = $alicuotas->retencion;
            $alicuotas->rand = rand(1, 99999);
            echo "<pre>";
            print_r($alicuotas);
            print_r(rand(1, 10000));
            echo "</pre>";
        } else {
            echo $wsfe->ErrorDesc;
        }
    }

    public function padron($cuit = 0) {
        //require_once('assets/vendors/afip/wsfe-class-ci.php');
        // Certificado REAL
        $certificado = 'upload/certificados/PCAFIP_12e5d279ba7d69a7.crt';
        $clave = "upload/certificados/privada";

        // Configuración
        $CUIT = 33647656779;
        $urlwsaa = URLWSAA;

        $wsfe = new WsFE();
        $wsfe->CUIT = floatval($CUIT);
        $wsfe->setURL(URLWSW);
    }

    public function nestable($idperfil) {
        $this->load->library(array(
            'session',
            'r_session'
        ));
        $this->load->model(array(
            'perfiles_model',
            'prueba_model'
        ));
        $data['title'] = 'Listado de Artículos';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['css'] = array(
            '/assets/modulos/prueba/css/nestable.css'
        );
        $data['javascript'] = array(
            '/assets/vendors/Nestable-master/jquery.nestable.js',
            '/assets/modulos/prueba/js/nestable.js'
        );

        $datos = array(
            'idperfil' => $idperfil
        );
        $data['perfil'] = $this->perfiles_model->get_where($datos);

        $ids = $this->menu_model->gets_menu_por_perfil($data['session']['perfil']);
        $data['ids'] = array();
        foreach ($ids as $id) {
            $data['ids'][] = $id['idmenu'];
        }
        $data['ids'] = implode(",", $data['ids']);

        $data['mmenu'] = $this->prueba_model->obtener_menu_por_padre(0, $idperfil);
        foreach ($data['mmenu'] as $key => $value) {
            $data['mmenu'][$key]['submenu'] = $this->prueba_model->obtener_menu_por_padre($value['idmenu'], $idperfil);
            foreach ($data['mmenu'][$key]['submenu'] as $k1 => $v1) {
                $data['mmenu'][$key]['submenu'][$k1]['submenu'] = $this->prueba_model->obtener_menu_por_padre($v1['idmenu'], $idperfil);
            }
        }


        $data['view'] = 'prueba/nestable';
        $this->load->view('layout/app', $data);
    }

    public function actualizar_accesos() {
        $this->load->library(array(
            'form_validation'
        ));
        $this->load->model(array(
            'prueba_model',
            'perfiles_model'
        ));

        $this->form_validation->set_rules('idmenu', 'Menú', 'required|integer');
        $this->form_validation->set_rules('idperfil', 'Perfil', 'required|integer');

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $where = array(
                'idperfil' => $this->input->post('idperfil'),
                'idmenu' => $this->input->post('idmenu')
            );
            $resultado = $this->prueba_model->get_where_perfiles_menu($where);

            if ($resultado) {
                $this->prueba_model->borrar_perfiles_menu($where);
                $json = array(
                    'status' => 'ok'
                );
                echo json_encode($json);
            } else {
                $this->perfiles_model->set_perfiles_menu($where);
                $json = array(
                    'status' => 'ok'
                );
                echo json_encode($json);
            }
        }
    }

    public function actualizar_orden() {
        $this->load->model(array(
            'prueba_model'
        ));
        $resultado = json_decode($this->input->post('orden'));

        $contador1 = 1;
        foreach ($resultado as $r1) {
            $data = array(
                'orden' => $contador1
            );
            $where = array(
                'idmenu' => $r1->id
            );
            $this->prueba_model->update_menu($data, $where);

            if (isset($r1->children)) {
                $contador2 = 1;
                foreach ($r1->children as $r2) {
                    $data = array(
                        'orden' => $contador2
                    );
                    $where = array(
                        'idmenu' => $r2->id
                    );
                    $this->prueba_model->update_menu($data, $where);


                    if (isset($r2->children)) {
                        $contador3 = 1;
                        foreach ($r2->children as $r3) {
                            $data = array(
                                'orden' => $contador3
                            );
                            $where = array(
                                'idmenu' => $r3->id
                            );
                            $this->prueba_model->update_menu($data, $where);

                            $contador3++;
                        }
                    }
                    $contador2++;
                }
            }

            $contador1++;
        }

        $json = array(
            'status' => 'ok'
        );
        echo json_encode($json);
    }

    public function chat() {
        $this->load->view('prueba/chat');
    }

    public function httpush() {
        //set_time_limit(0); //Establece el número de segundos que se permite la ejecución de un script.
        /*
         *  Muy importante tener en el index.php del raíz el comando ini_set('max_execution_time', 0);
         */
        $this->load->model(array(
            'prueba_model'
        ));
        $fecha_ac = isset($_POST['timestamp']) ? $_POST['timestamp'] : 0;
        $fecha_ac = strtotime(date("Y-m-d H:i:s"));

        //$fecha_bd = $row['timestamp'];
        $fecha = $this->prueba_model->get_ultimo_timestamp();
        $fecha_bd = strtotime($fecha['maximo']);

        while ($fecha_bd <= $fecha_ac) {
            $fecha = $this->prueba_model->get_ultimo_timestamp();

            usleep(100000); //anteriormente 10000
            clearstatcache();
            $fecha_bd = strtotime($fecha['maximo']);
        }

        /*
          $query = "SELECT * FROM mensajes ORDER BY timestamp DESC LIMIT 1";
          $datos_query = mysql_query($query);
          while ($row = mysql_fetch_array($datos_query)) {
          $ar["timestamp"] = strtotime($row['timestamp']);
          $ar["mensaje"] = $row['mensaje'];
          $ar["id"] = $row['id'];
          $ar["status"] = $row['status'];
          $ar["tipo"] = $row['tipo'];
          } */
        $ar = $this->prueba_model->gets_mensajes_chat();
        $dato_json = json_encode($ar);
        echo $dato_json;
    }

    public function insertar_chat() {
        $this->load->library(array(
            'form_validation'
        ));
        $this->load->model(array(
            'prueba_model'
        ));

        $this->form_validation->set_rules('mensaje', 'Mensaje', 'required');
        $this->form_validation->set_rules('tipo', 'Tipo', 'required');

        if ($this->form_validation->run() == FALSE) {
            
        } else {
            $datos = array(
                'mensaje' => $this->input->post('mensaje'),
                'timestamp' => date("Y-m-d H:i:s"),
                'tipo' => $this->input->post('tipo')
            );

            $this->prueba_model->set_chat($datos);
        }
        $this->load->view('prueba/insertar_chat');
    }

    public function ventana_chat() {
        $this->load->library(array(
            'session',
            'r_session'
        ));
        $data['title'] = 'Listado de Monedas';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array();

        $data['view'] = 'prueba/ventana_chat';
        $this->load->view('layout/app', $data);
    }

    public function posibilidades() {
        $this->load->model(array(
            'prueba_model'
        ));

        $where = array(
            'estado' => 'A'
        );
        $res = $this->prueba_model->cheques_gets_where($where);
        echo "<pre>";
        print_r($res);
        echo "</pre>";

        $array = array('Alpha', 'Beta', 'Gamma', 'Sigma');

        function depth_picker($arr, $temp_string, &$collect) {
            if ($temp_string != "")
                $collect [] = $temp_string;

            for ($i = 0; $i < sizeof($arr); $i++) {
                $arrcopy = $arr;
                $elem = array_splice($arrcopy, $i, 1); // removes and returns the i'th element
                if (sizeof($arrcopy) > 0) {
                    depth_picker($arrcopy, $temp_string . " " . $elem[0], $collect);
                } else {
                    $collect [] = $temp_string . " " . $elem[0];
                }
            }
        }

        $collect = array();
        depth_picker($array, "", $collect);
        echo "<pre>";
        print_r($collect);
        echo "</pre>";
    }

    public function importar_cheques() {
        $this->load->model(array(
            'prueba_model'
        ));

        $fp = fopen("upload/importar/CHEQUES.TXT", "r");

        $i = 0;
        while (!feof($fp)) {
            $linea = fgets($fp);
            $array = preg_split('/;/', $linea);

            $fecha = substr(trim($array[2]), -2, 2);
            if ($fecha > '70') {
                $fecha = '19' . $fecha . '-';
            } else {
                $fecha = '20' . $fecha . '-';
            }
            $fecha .= substr(trim($array[2]), -4, 2);
            $fecha .= '-';
            $fecha .= substr(trim($array[2]), -6, 2);


            $fecha_deposito = substr(trim($array[3]), -2, 2);
            if ($fecha_deposito > '70') {
                $fecha_deposito = '19' . $fecha_deposito . '-';
            } else {
                $fecha_deposito = '20' . $fecha_deposito . '-';
            }
            $fecha_deposito .= substr(trim($array[3]), -4, 2);
            $fecha_deposito .= '-';
            $fecha_deposito .= substr(trim($array[3]), -6, 2);


            $datos = array(
                'idcheque' => $array[0],
                'fecha' => $fecha,
                'estado' => $array[3],
                'fecha_deposito' => $fecha_deposito,
                'banco' => trim($array[12]),
                'importe' => $array[13]
            );
            $this->prueba_model->set_cheques($datos);

            if (($array[0] % 1000) == 0) {
                var_dump($datos);
            }
        }
    }

    public function email() {
        $this->load->library(array(
            'email'
        ));

        $subject = 'This is a test';
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
' . $message . '
</body>
</html>';
// Also, for getting full html you may use the following internal method:
//$body = $this->email->full_html($subject, $message);

        $result = $this->email
                ->from('hernan.balboa@rollerservice.com.ar', 'Hernan - CodeIgniter Prueba')
                ->reply_to('hernan.balboa@rollerservice.com.ar')    // Optional, an account where a human being reads.
                ->to('hernanbalboa@gmail.com')
                ->subject($subject)
                ->attach('https://erp.rollerservice.com.ar/prueba/tcpdf/', '', 'Nuevo Nombre.pdf')
                ->message($body)
                ->send();

        var_dump($result);
        echo '<br />';
        echo $this->email->print_debugger();

        exit;
    }

    public function trivia() {
        $this->load->view('prueba/trivia');
    }

    public function post() {
        $this->load->model(array(
            'parametros_model'
        ));
        require_once('assets/vendors/afip/wsfe-class-ci-homologacion.php');
        /*
         * Certificado de Homologación
         */
        $certificado = "upload/certificados/certificado-2019-06-14.crt";
        $clave = "upload/certificados/privada-2019-06-14";
        $urlwsaa = "https://wsaahomo.afip.gov.ar/ws/services/LoginCms";

        $data['parametro'] = $this->parametros_model->get_parametros_empresa();

        //$CUIT = $data['parametro']['cuit'];
        $CUIT = 20300348689;
        $urlwsaa = URLWSAA;

        $wsfe = new WsFE();
        $wsfe->CUIT = floatval($CUIT);
        $wsfe->setURL(URLWSW);

        $PtoVta = 3;
        $TipoComp = 1;
        $UltimoNroComprobante = 0;

        if ($wsfe->Login($certificado, $clave, $urlwsaa)) {
            if (!$wsfe->RecuperaLastCMP($PtoVta, $TipoComp)) {
                echo $wsfe->ErrorDesc;
            } else {
                $r = $wsfe->getUltimoComprobanteAutorizado($PtoVta, $TipoComp);
                $UltimoNroComprobante = $r->CbteNro;
                var_dump($r);
            }
        }

        $concepto = 1;  //  1=Producto
        $TipoDoc = 80;  //  80=CUIT
        $CuitCliente = 33647656779;
        $FechaComprobante = date("Ymd");
        $Total = 12400; // Total Gravado
        $ImpTotConc = 0; // Total no Gravado
        $ImpNeto = 10000;
        $ImpOpEx = 0;  //  Importe Exento
        $FchServDesde = "";  // Obligatorio en concepto 2 y 3
        $FchServHasta = "";  // Obligatorio en concepto 2 y 3
        $FchVtoPago = ""; // Obligatorio en concepto 2 y 3
        $MonedaId = "PES";
        $MonedaCotizacion = 1;

        /*
         *  Agregar IVA
         */
        $IdIVA = 5;   //  Tipo de IVA, ej 5 = 21%    FEParamGetTiposIVA
        $ImporteIVA = 2100;


        /*
         *  Agregar Tributo
         */
        $IdTributo = 2;   //  En este caso, 2 = Impuestos Provinciales   FEParamGetTiposTributos
        $TributoDescripcion = "Percepcion IIBB";
        $TributoBaseImponible = $ImpNeto;
        $TributoAlicuota = 3;
        $TributoImporte = 300;


        if ($wsfe->Login($certificado, $clave, $urlwsaa)) {
            if (!$wsfe->RecuperaLastCMP($PtoVta, $TipoComp)) {
                echo $wsfe->ErrorDesc;
            } else {
                $wsfe->Reset();
                $NumeroFacturaDesde = $wsfe->RespUltNro + 1;
                $NumeroFacturaHasta = $NumeroFacturaDesde;

                $wsfe->AgregaFactura($concepto, $TipoDoc, $CuitCliente, $NumeroFacturaDesde, $NumeroFacturaHasta, $FechaComprobante, $Total, $ImpTotConc, $ImpNeto, $ImpOpEx, $FchServDesde, $FchServHasta, $FchVtoPago, $MonedaId, $MonedaCotizacion);
                $wsfe->AgregaIva($IdIVA, $ImpNeto, $ImporteIVA);
                $wsfe->AgregaTributo($IdTributo, $TributoDescripcion, $TributoBaseImponible, $TributoAlicuota, $TributoImporte);


                $auth = false;
                try {
                    if ($wsfe->Autorizar($PtoVta, $TipoComp)) {
                        $auth = true;
                    } else {
                        echo $wsfe->ErrorDesc;
                    }
                } catch (Exception $e) {
                    if ($wsfe->CmpConsultar($TipoComp, $PtoVta, $NumeroFacturaDesde, $cbte)) {
                        $auth = true;
                    } else {
                        //cii
                    }
                }
                if ($auth) {
                    
                    $data['invoice_num'] = sprintf('%04d-', $PtoVta) . sprintf('%08d', $NumeroFacturaDesde);
                    $data['CAE'] = $wsfe->RespCAE;
                    $data['Vto'] = $wsfe->RespVencimiento;
                    //$data['barcode'] = $cuit . sprintf('%02d', $TipoComp) . sprintf('%04d', $PtoVta) . $wsfe->RespCAE . $wsfe->RespVencimiento;

                    echo "<pre>";
                    print_r($data);
                    print_r($wsfe);
                    echo "</pre>";
                }
            }
        }


        foreach ($this->input->post() as $post) {
            var_dump($post);
            var_dump(count($post));
        }
    }

}

?>
