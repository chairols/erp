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

    public function arba($cuit = 0) {
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
        $fechadesde = date('Ym') . '01';

        $mes = date('m');
        $anio = date('Y');
        $fechahasta = $anio . $mes . date("d", (mktime(0, 0, 0, $mes + 1, 1, $anio) - 1));


        $wsfe = new WsFE();
        $wsfe->CUIT = floatval(30714016918);
        $wsfe->PasswodArba = "252729";
        if ($wsfe->ConsultaARBA(floatval($cuit), $fechadesde, $fechahasta, $alicuotas)) {
            $percepcion = $alicuotas->percepcion;
            $retencion = $alicuotas->retencion;
            var_dump($alicuotas);
        } else {
            echo $wsfe->ErrorDesc;
        }
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
        foreach($resultado as $r1) {
            $data = array(
                'orden' => $contador1
            );
            $where = array(
                'idmenu' => $r1->id
            );
            $this->prueba_model->update_menu($data, $where);
            
            if(isset($r1->children)) {
                $contador2 = 1;
                foreach($r1->children as $r2) {
                    $data = array(
                        'orden' => $contador2
                    );
                    $where = array(
                        'idmenu' => $r2->id
                    );
                    $this->prueba_model->update_menu($data, $where);
                    
                    
                    if(isset($r2->children)) {
                        $contador3 = 1;
                        foreach($r2->children as $r3) {
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
}

?>
