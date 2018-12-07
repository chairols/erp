<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Extranet extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array(
            'numeroaletras',
            'tcpdf/tcpdf'
        ));
        $this->load->model(array(
            'retenciones_model',
            'parametros_model',
            'provincias_model',
            'tipos_responsables_model'
        ));
    }

    public function retencion($idretencion = null, $hash = null) {
        if ($idretencion == null) {
            show_404();
        }
        if ($hash == null) {
            show_404();
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

        //var_dump(sha1($data['retencion']['idretencion'].$data['retencion']['punto'].$data['retencion']['numero'].$data['retencion']['idproveedor'].$data['retencion']['proveedor'].$data['retencion']['direccion'].$data['retencion']['localidad']));

        $hash_generado = sha1($data['retencion']['idretencion'] . $data['retencion']['punto'] . $data['retencion']['numero'] . $data['retencion']['idproveedor'] . $data['retencion']['proveedor'] . $data['retencion']['direccion'] . $data['retencion']['localidad']);

        if ($hash == $hash_generado) {
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
        } else {
            show_404();
        }
    }
    
    public function confirmar_retencion_email($idretencion = null, $hash = null) {
        if ($idretencion == null || $hash == null) {
            // No mostrar nada
        } else {
            $retencion = $this->retenciones_model->get_where($idretencion);
            $hash_generado = sha1($retencion['idretencion'] . $retencion['punto'] . $retencion['numero'] . $retencion['idproveedor'] . $retencion['proveedor'] . $retencion['direccion'] . $retencion['localidad']);
            
            if($hash_generado == $hash) {
                $datos = array(
                    'estado_mail' => 'R'
                );
                $where = array(
                    'idretencion' => $idretencion
                );
                $this->retenciones_model->update($datos, $where);
            }
        }
        
        
        
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