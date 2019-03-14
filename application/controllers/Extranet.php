<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Extranet extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array(
            'numeroaletras',
            'tcpdf/tcpdf',
            'pdf_cotizacion_cliente'
        ));
        $this->load->model(array(
            'retenciones_model',
            'parametros_model',
            'provincias_model',
            'tipos_responsables_model',
            'cotizaciones_clientes_model',
            'clientes_model',
            'condiciones_de_venta_model',
            'monedas_model'
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
            $where = array(
                'idretencion' => $idretencion,
                'estado' => 'A'
            );
            $data['retencion'] = $this->retenciones_model->get_where($where);
            $hash_generado = sha1($data['retencion']['idretencion'] . $data['retencion']['punto'] . $data['retencion']['numero'] . $data['retencion']['idproveedor'] . $data['retencion']['proveedor'] . $data['retencion']['direccion'] . $data['retencion']['localidad']);

            if ($hash_generado == $hash) {
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

    public function cotizacion_cliente($idcotizacion_cliente = null, $hash = null) {
        if ($idcotizacion_cliente == null) {
            show_404();
        }
        if ($hash == null) {
            show_404();
        }



        if ($hash == $hash_generado) {
            $this->pdf = new Pdf_cotizacion_cliente;
            $this->pdf->AddPage();
            $this->pdf->AliasNbPages();

            $where = array(
                'idcotizacion_cliente' => $idcotizacion_cliente,
                'estado' => 'A'
            );
            $cotizacion_cliente = $this->cotizaciones_clientes_model->get_where($where);
            $items = $this->cotizaciones_clientes_model->gets_articulos_where($where);

            $where = array(
                'idcliente' => $cotizacion_cliente['idcliente']
            );
            $cliente = $this->clientes_model->get_where($where);

            $where = array(
                'idcliente' => $cliente['idcliente']
            );
            $sucursales = $this->clientes_model->gets_sucursales($where);

            $where = array(
                'idtipo_responsable' => $cliente['idtipo_responsable']
            );
            $tipo_responsable = $this->tipos_responsables_model->get_where($where);

            $where = array(
                'idcondicion_de_venta' => $cliente['idcondicion_de_venta']
            );
            $condicion_de_venta = $this->condiciones_de_venta_model->get_where($where);

            $where = array(
                'idmoneda' => $cotizacion_cliente['idmoneda']
            );
            $moneda = $this->monedas_model->get_where($where);


            $this->pdf->SetTextColor(0, 0, 0);
            $this->pdf->SetFont('Arial', 'B', 12);
            /*
              $this->pdf->SetFont('Arial','B',18);
              $this->pdf->SetXY(115, 16);
              $this->pdf->Cell(0,0,'A',0,0,'L');

              $this->pdf->SetFont('Arial','B', 8);
              $this->pdf->SetXY(113, 20);
              $this->pdf->Cell(0,0,'CODIGO',0,0,'L');


              $this->pdf->SetFont('Arial','',8);
              $this->pdf->SetXY(130, 10);
              $this->pdf->Cell(0,0,'comprobanteDescripcion',0,0,'L');
             */

            $this->pdf->SetXY(114, 15);
            $this->pdf->Cell(0, 0, utf8_decode('COTIZACIÓN: ') . str_pad($idcotizacion_cliente, 8, '0', STR_PAD_LEFT), 0, 0, 'L');

            $this->pdf->SetXY(165, 15);
            $this->pdf->Cell(0, 0, 'FECHA: ' . $this->formatear_fecha_para_mostrar($cotizacion_cliente['fecha']), 0, 0, 'L');


            $this->pdf->SetFont('Arial', 'B', 9);
            $this->pdf->SetXY(15, 58);
            $this->pdf->Cell(0, 0, utf8_decode($cotizacion_cliente['cliente']), 0, 0, 'L');

            /*
              $this->pdf->SetFont('Arial','B',9);
              $this->pdf->SetXY(15, 61);
              $this->pdf->Cell(0,0,'razonSocial2',0,0,'L');


              $this->pdf->SetFont('Arial', '', 9);
              $this->pdf->SetXY(124, 61);
              $this->pdf->Cell(0,0,'ordenDeCompra',0,0,'L');
             */
            $this->pdf->SetFont('Arial', '', 9);
            $this->pdf->SetXY(15, 64);
            $this->pdf->Cell(0, 0, 'DOMICILIO: ', 0, 0, 'L');

            $this->pdf->SetFont('Arial', '', 9);
            $this->pdf->SetXY(35, 64);
            $this->pdf->Cell(0, 0, $cotizacion_cliente['domicilio'], 0, 0, 'L');

            $this->pdf->SetFont('Arial', '', 9);
            $this->pdf->SetXY(35, 68);
            $this->pdf->Cell(0, 0, $cotizacion_cliente['localidad'], 0, 0, 'L');

            $this->pdf->SetFont('Arial', '', 9);
            $this->pdf->SetXY(15, 74);
            $this->pdf->Cell(0, 0, 'CONDICION IVA: ' . $tipo_responsable['tipo_responsable'], 0, 0, 'L');

            $this->pdf->SetFont('Courier', 'B', 10);
            $this->pdf->SetXY(55, 80);
            $this->pdf->Cell(0, 0, utf8_decode($condicion_de_venta['condicion_de_venta']), 0, 0, 'L');


            $this->pdf->SetFont('Courier', 'B', 10);
            $this->pdf->SetXY(140, 80);
            $this->pdf->Cell(0, 0, 'MONEDA: ' . utf8_decode($moneda['moneda']), 0, 0, 'L');

            /*
              $this->pdf->SetFont('Courier','',9);
              $this->pdf->SetXY(35, 88);
              $this->pdf->Cell(0,0,'condicion2',0,0,'L');
             */

            //Salto de línea
            $this->pdf->Ln(10);

            $Y = 96;
            $this->pdf->SetFont('Courier', '', 11);
            $total = 0;
            foreach ($items as $item) {
                $this->pdf->SetXY(5, $Y);
                $this->pdf->Cell(0, 8, str_pad($item['cantidad'], 5, ' ', STR_PAD_LEFT), 0, 1, 'L');

                $this->pdf->SetXY(30, $Y);
                $this->pdf->Cell(0, 8, $item['descripcion'], 0, 1, 'L');

                $this->pdf->SetXY(146, $Y);
                $this->pdf->Cell(0, 8, str_pad($item['precio'], 10, ' ', STR_PAD_LEFT), 0, 1, 'L');

                $this->pdf->SetXY(180, $Y);
                $this->pdf->Cell(0, 8, str_pad(number_format($item['cantidad'] * $item['precio'], 2), 10, ' ', STR_PAD_LEFT), 0, 1, 'L');

                $Y = $Y + 4;
                $total += $item['cantidad'] * $item['precio'];
            }

            /*
              $this->pdf->SetFont('Courier','B',11);
              $this->pdf->SetXY(180, $Y);
              $this->pdf->Cell(0, 8, str_pad(number_format($total, 2), 10, ' ', STR_PAD_LEFT), 0, 1, 'L');
             */
            /*
              $this->pdf->SetFont('Courier','B',12);
              $this->pdf->SetXY(105, 185);
              $this->pdf->Cell(0,0,'subtotal',0,0,'L');

              $this->pdf->SetFont('Courier','B',12);
              $this->pdf->SetXY(105, 190);
              $this->pdf->Cell(0,0,'bonificacion',0,0,'L');

              $this->pdf->SetFont('Courier','B',12);
              $this->pdf->SetXY(105, 195);
              $this->pdf->Cell(0,0,'gravado',0,0,'L');


              $this->pdf->SetFont('Courier','B',12);
              $this->pdf->SetXY(105, 200);
              $this->pdf->Cell(0,0,'exento',0,0,'L');

              $this->pdf->SetFont('Courier','B',12);
              $this->pdf->SetXY(105, 205);
              $this->pdf->Cell(0,0,'importeIva',0,0,'L');

              $this->pdf->SetFont('Courier','B',12);
              $this->pdf->SetXY(105, 210);
              $this->pdf->Cell(0,0,'iibb',0,0,'L');

              $this->pdf->SetFont('Courier','B',12);
              $this->pdf->SetXY(105, 215);
              $this->pdf->Cell(0,0,'iibb2',0,0,'L');
             */

            $this->pdf->SetFont('Courier', 'B', 11);
            $this->pdf->SetXY(105, 220);
            $this->pdf->Cell(0, 0, 'Total:', 0, 0, 'L');
            $this->pdf->SetXY(180, 220);
            $this->pdf->Cell(0, 0, str_pad(number_format($total, 2), 10, ' ', STR_PAD_LEFT), 0, 1, 'L');

            $this->pdf->SetFont('Courier', 'B', 9);
            $this->pdf->SetXY(10, 240);
            $this->pdf->Cell(0, 0, '', 0, 0, 'L');

            /*
              $this->pdf->SetXY(10, 244);
              $this->pdf->Cell(0,0,'dolar2',0,0,'L');

              $this->pdf->SetXY(10, 248);
              $this->pdf->Cell(0,0,'dolar3',0,0,'L');
             */
            // Footer
            $this->pdf->Pie($cotizacion_cliente);


            $this->pdf->Output('COTIZACION ' . str_pad($idcotizacion_cliente, 8, '0', STR_PAD_LEFT) . '.pdf', 'I');
        } else {
            show_404();
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