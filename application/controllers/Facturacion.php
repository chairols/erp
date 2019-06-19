<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Facturacion extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array(
            'session',
            'r_session',
            'form_validation'
        ));
        $this->load->model(array(
            'pedidos_model',
            'clientes_model',
            'provincias_model',
            'tipos_responsables_model',
            'condiciones_de_venta_model',
            'transportes_model',
            'monedas_model',
            'tipos_iva_model',
            'comprobantes_model',
            'parametros_model',
            'padrones_model'
        ));

        $session = $this->session->all_userdata();
        $this->r_session->check($session);
    }

    public function pedidos() {
        $data['title'] = 'Facturación de Pedidos';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array(
            '/assets/modulos/facturacion/js/pedidos.js'
        );
        $data['view'] = 'facturacion/pedidos';

        $this->load->view('layout/app', $data);
    }

    public function gets_pedidos_ajax() {
        $where['pedidos.idcliente'] = $this->input->post('idcliente');
        $where['pedidos.estado'] = 'P';
        $group_by = "pedidos.idcliente";
        $order_by = "pedidos.idpedido";

        $data['pedidos'] = $this->pedidos_model->gets_where($where, $group_by, $order_by);

        foreach ($data['pedidos'] as $key => $value) {
            $data['pedidos'][$key]['fecha_formateada'] = $this->formatear_fecha_para_mostrar($value['fecha_creacion']);
        }

        $this->load->view('facturacion/gets_pedidos_ajax', $data);
    }

    public function pedidos_ajax() {
        $session = $this->session->all_userdata();

        $this->form_validation->set_rules('idpedido', 'Pedido', 'required|integer');

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $where = array(
                'idpedido' => $this->input->post('idpedido'),
                'estado' => 'P'
            );
            $pedido = $this->pedidos_model->get_where($where);

            if ($pedido) {
                $where = array(
                    'idcliente' => $pedido['idcliente']
                );
                $cliente = $this->clientes_model->get_where($where);

                $where = array(
                    'idcliente' => $pedido['idcliente'],
                    'casa_central' => 'S',
                    'estado' => 'A'
                );
                $cliente_domicilio_fiscal = $this->clientes_model->get_where_sucursal($where);

                if ($cliente_domicilio_fiscal) {
                    $where = array(
                        'idprovincia' => $cliente_domicilio_fiscal['idprovincia']
                    );
                    $provincia_fiscal = $this->provincias_model->get_where($where);

                    $where = array(
                        'idcliente_sucursal' => $pedido['idcliente_sucursal'],
                        'estado' => 'A'
                    );
                    $cliente_sucursal = $this->clientes_model->get_where_sucursal($where);

                    $where = array(
                        'idprovincia' => $cliente_sucursal['idprovincia']
                    );
                    $provincia = $this->provincias_model->get_where($where);

                    $where = array(
                        'idtipo_responsable' => $cliente['idtipo_responsable']
                    );
                    $tipo_responsable = $this->tipos_responsables_model->get_where($where);

                    $where = array(
                        'idcondicion_de_venta' => $pedido['idcondicion_de_venta']
                    );
                    $condicion_de_venta = $this->condiciones_de_venta_model->get_where($where);

                    $where = array(
                        'idtransporte' => $pedido['idtransporte']
                    );
                    $transporte = $this->transportes_model->get_where($where);

                    $where = array(
                        'idmoneda' => $pedido['idmoneda']
                    );
                    $moneda = $this->monedas_model->get_where($where);

                    $dolar_oficial = $this->monedas_model->get_ultima_cotizacion_por_monedas(1);

                    $where = array(
                        'idtipo_iva' => $pedido['idtipo_iva']
                    );
                    $tipo_iva = $this->tipos_iva_model->get_where($where);

                    $set = array(
                        'idcliente' => $pedido['idcliente'],
                        'idpedido' => $this->input->post('idpedido'),
                        'cliente' => $cliente['cliente'],
                        'direccion_fiscal' => $cliente_domicilio_fiscal['direccion'],
                        'codigo_postal_fiscal' => $cliente_domicilio_fiscal['codigo_postal'],
                        'localidad_fiscal' => $cliente_domicilio_fiscal['localidad'],
                        'idprovincia_fiscal' => $cliente_domicilio_fiscal['idprovincia'],
                        'provincia_fiscal' => $provincia_fiscal['provincia'],
                        'idsucursal' => $cliente_sucursal['idcliente_sucursal'],
                        'sucursal' => $cliente_sucursal['sucursal'],
                        'direccion' => $cliente_sucursal['direccion'],
                        'codigo_postal' => $cliente_sucursal['codigo_postal'],
                        'localidad' => $cliente_sucursal['localidad'],
                        'idprovincia' => $cliente_sucursal['idprovincia'],
                        'provincia' => $provincia['provincia'],
                        'orden_de_compra' => $pedido['orden_de_compra'],
                        'idtipo_responsable' => $cliente['idtipo_responsable'],
                        'tipo_responsable' => $tipo_responsable['tipo_responsable'],
                        'cuit' => $cliente['cuit'],
                        'idcondicion_de_venta' => $pedido['idcondicion_de_venta'],
                        'condicion_de_venta' => $condicion_de_venta['condicion_de_venta'],
                        'dias_vencimiento' => $condicion_de_venta['dias'],
                        'idtransporte' => $pedido['idtransporte'],
                        'transporte' => $transporte['transporte'],
                        'imprime_despacho' => $pedido['imprime_despacho'],
                        'idmoneda' => $pedido['idmoneda'],
                        'moneda' => $moneda['moneda'],
                        'dolar_oficial' => $dolar_oficial['valor'],
                        'factor_correccion' => $pedido['factor_correccion'],
                        'idtipo_iva' => $pedido['idtipo_iva'],
                        'porcentaje_iva' => $tipo_iva['porcentaje'],
                        'fecha_creacion' => date("Y-m-d H:i:s"),
                        'idcreador' => $session['SID'],
                        'actualizado_por' => $session['SID']
                    );

                    $idcomprobante = $this->comprobantes_model->set($set);

                    if ($idcomprobante) {

                        $json = array(
                            'status' => 'ok',
                            'data' => $idcomprobante
                        );
                        echo json_encode($json);
                    } else {
                        $json = array(
                            'status' => 'error',
                            'data' => 'No se pudo crear el pre-comprobante'
                        );
                        echo json_encode($json);
                    }
                } else {
                    $json = array(
                        'status' => 'error',
                        'data' => 'El cliente ' . $cliente['cliente'] . ' no tiene asignado un domicilio fiscal'
                    );
                    echo json_encode($json);
                }
            } else {
                $json = array(
                    'status' => 'error',
                    'data' => 'No existe el pedido'
                );
                echo json_encode($json);
            }
        }
    }

    public function pedido_modificar($idcomprobante = null) {
        $session = $this->session->all_userdata();
        if ($idcomprobante == null) {
            redirect('/facturacion/pedidos/', 'refresh');
        }
        $data['title'] = 'Preparar Factura';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array(
            '/assets/modulos/facturacion/js/pedido_modificar.js'
        );

        $where = array(
            'idcomprobante' => $idcomprobante
        );
        $data['comprobante'] = $this->comprobantes_model->get_where($where);

        if ($data['comprobante']['estado'] != 'P') {
            redirect('/facturacion/pedidos/', 'refresh');
        }

        $data['condiciones'] = $this->condiciones_de_venta_model->gets();
        $data['transportes'] = $this->transportes_model->gets();
        $data['monedas'] = $this->monedas_model->gets();
        $data['dolar'] = $this->monedas_model->get_ultima_cotizacion_por_monedas(1); // 1 es id del dolar
        $data['parametro'] = $this->parametros_model->get_parametros_empresa();
        $data['tipos_iva'] = $this->tipos_iva_model->gets();

        $where = array(
            'idmoneda' => $data['comprobante']['idmoneda']
        );
        $data['comprobante']['moneda'] = $this->monedas_model->get_where($where);

        /*
         *  Traigo los items pendientes
         */
        $where = array(
            'idpedido' => $data['comprobante']['idpedido'],
            'estado' => 'P'
        );
        $data['comprobante']['items'] = $this->pedidos_model->gets_articulos_where($where);

        foreach ($data['comprobante']['items'] as $key => $value) {
            $data['comprobante']['items'][$key]['fecha_formateada'] = $this->formatear_fecha_para_mostrar($value['fecha_entrega']);
        }
        /*
         *  Fin de búsqueda de items
         */

        $data['view'] = 'facturacion/pedido_modificar';
        $this->load->view('layout/app', $data);
    }

    public function facturar_afip() {
        $this->form_validation->set_rules('idcomprobante', 'ID de Comprobante', 'required|integer');
        $this->form_validation->set_rules('cuit', 'CUIT del Cliente', 'required');
        $this->form_validation->set_rules('pendientes[]', 'Cantidad Pendiente', 'required');
        $this->form_validation->set_rules('precios[]', 'Precios', 'required');
        $this->form_validation->set_rules('idmoneda', 'Moneda', 'required|integer');
        $this->form_validation->set_rules('idtipo_iva', 'Porcentaje de IVA', 'required|integer');
        $this->form_validation->set_rules('tipo_comprobante', 'Tipo de Comprobante', 'required');

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $TipoComp = null;
            switch ($this->input->post('tipo_comprobante')) {
                case '1': // Factura A
                    $TipoComp = 1;
                    if (!$this->facturar_afip_check_ultimo_comprobante($TipoComp)) {
                        break;
                    }
                    break;
                case '1R': // Factura A y Remito
                    $TipoComp = 1;
                    if (!$this->facturar_afip_check_ultimo_comprobante($TipoComp)) {
                        break;
                    }
                    break;
                case '2': // Nota de Débito A
                    $TipoComp = 2;
                    if (!$this->facturar_afip_check_ultimo_comprobante($TipoComp)) {
                        break;
                    }
                    break;
                case '3': // Nota de Crédito A
                    $TipoComp = 3;
                    if (!$this->facturar_afip_check_ultimo_comprobante($TipoComp)) {
                        break;
                    }
                    break;
                case 'R':

                    break;
            }
        }
    }

    private function facturar_afip_check_ultimo_comprobante($TipoComp) {
        /*
         *  Para salir a producción hay que reemplazar
         *  
         *  require de homologación por real
         *  certificado de homologación por real
         *  clave de homologación por real
         *  urlwsaa de homologación por real
         *  $CUIT hardcodeado por el post
         */
        require_once('assets/vendors/afip/wsfe-class-ci-homologacion.php');
        /*
         * Certificado de Homologación
         */
        $certificado = "upload/certificados/certificado-2019-06-14.crt";
        $clave = "upload/certificados/privada-2019-06-14";
        $urlwsaa = "https://wsaahomo.afip.gov.ar/ws/services/LoginCms";

        //$data['parametro'] = $this->parametros_model->get_parametros_empresa();
        //$CUIT = $data['parametro']['cuit'];

        $CUIT = 20300348689;

        $wsfe = new WsFE();
        $wsfe->CUIT = floatval($CUIT);
        $wsfe->setURL(URLWSW);

        $where = array(
            'identificador' => 'punto_comprobantes'
        );
        $punto_comprobantes = $this->parametros_model->get_where($where);
        $PtoVta = $punto_comprobantes['valor_sistema'];

        if ($wsfe->Login($certificado, $clave, $urlwsaa)) {
            if (!$wsfe->RecuperaLastCMP($PtoVta, $TipoComp)) {
                $json = array(
                    'status' => 'error',
                    'data' => $wsfe->ErrorDesc
                );
                echo json_encode($json);
            } else {
                $r = $wsfe->getUltimoComprobanteAutorizado($PtoVta, $TipoComp);
                $UltimoNroComprobanteAfip = $r->CbteNro;

                $UltimoComprobante = $this->comprobantes_model->get_ultimo_comprobante($PtoVta, $TipoComp);

                if ($UltimoNroComprobanteAfip == $UltimoComprobante['numero']) {
                    return 1;
                } else {
                    $json = array(
                        'status' => 'error',
                        'data' => 'No coinciden los números de comprobantes<br>AFIP tiene último número ' . $UltimoNroComprobanteAfip . '<br>y en sistema el último número es ' . $UltimoComprobante['numero']
                    );
                    echo json_encode($json);
                    return 0;
                }
            }
        }
    }

    public function facturar_afip_original() {
        $this->form_validation->set_rules('idcomprobante', 'ID de Comprobante', 'required|integer');
        $this->form_validation->set_rules('cuit', 'CUIT del Cliente', 'required');
        $this->form_validation->set_rules('pendientes[]', 'Cantidad Pendiente', 'required');
        $this->form_validation->set_rules('precios[]', 'Precios', 'required');
        $this->form_validation->set_rules('idmoneda', 'Moneda', 'required|integer');
        $this->form_validation->set_rules('idtipo_iva', 'Porcentaje de IVA', 'required|integer');
        $this->form_validation->set_rules('tipo_comprobante', 'Tipo de Comprobante', 'required');

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
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

            $where = array(
                'identificador' => 'punto_comprobantes'
            );
            $punto_comprobantes = $this->parametros_model->get_where($where);
            $PtoVta = $punto_comprobantes['valor_sistema'];

            $TipoComp = null;
            switch ($this->input->post('tipo_comprobante')) {
                case '1':
                    $TipoComp = 1;
                    break;
                default:
                    break;
            }


            /*
             * Obtengo importe neto
             */
            $total_neto = 0;
            $pendientes = $this->input->post('pendientes[]');
            $precios = $this->input->post('precios[]');
            foreach ($pendientes as $key => $value) {
                $total_neto += $pendientes[$key] * $precios[$key];
            }
            /*
             *  Fin obtención de importe neto
             */

            /*
             * Obtengo percepción de CABA
             */
            $alicuota_caba = 0;
            $where = array(
                'padrones.idjurisdiccion_afip' => 901,
                'padrones_items.cuit' => $this->input->post('cuit'),
                'padrones.fecha_desde <=' => $this->formatear_fecha(date("d/m/Y")),
                'padrones.fecha_hasta >=' => $this->formatear_fecha(date("d/m/Y"))
            );
            $resultado = $this->padrones_model->get_where_join($where);

            if ($resultado) {
                $alicuota_caba = $resultado['percepcion'];
            }
            $percepcion_caba = round($total_neto * $alicuota_caba / 100, 2);
            /*
             * Fin de Obtención de Percepción de CABA
             */

            /*
             * Obtengo percepción de ARBA
             */
            $alicuota_arba = 0;
            $anio = date("Y");
            $mes = date("m");

            $fechadesde = $anio . $mes . '01';
            $fechahasta = $anio . $mes . date("d", (mktime(0, 0, 0, $mes + 1, 1, $anio) - 1));

            $wsfe = new WsFE();
            $wsfe->CUIT = floatval(30714016918);
            $wsfe->PasswodArba = "252729";

            if ($wsfe->ConsultaARBA(floatval($this->input->post('cuit')), $fechadesde, $fechahasta, $alicuotas)) {
                $alicuota_arba = $alicuotas->percepcion;
            }
            $percepcion_arba = round($total_neto * $alicuota_arba / 100, 2);
            /*
             * Fin de Obtención de Percepción de ARBA
             */

            $concepto = 1;  //  1=Producto
            $TipoDoc = 80;  //  80=CUIT
            $CuitCliente = 33647656779; //$this->input->post('cuit');
            $FechaComprobante = date("Ymd");
            $ImpNeto = round($total_neto, 2);
            $ImpTotConc = 0; // Total no Gravado
            $ImpOpEx = 0;  //  Importe Exento
            $FchServDesde = "";  // Obligatorio en concepto 2 y 3
            $FchServHasta = "";  // Obligatorio en concepto 2 y 3
            $FchVtoPago = ""; // Obligatorio en concepto 2 y 3

            /*
             *  Obtengo moneda
             */
            $where = array(
                'idmoneda' => $this->input->post('idmoneda')
            );
            $moneda = $this->monedas_model->get_where($where);
            $MonedaId = $moneda['codigo_afip'];

            $tipo_de_cambio = $this->monedas_model->get_ultima_cotizacion_por_monedas(1);
            $MonedaCotizacion = $tipo_de_cambio['valor'];

            /*
             *  Obtengo porcentaje de IVA
             */
            $where = array(
                'idtipo_iva' => $this->input->post('idtipo_iva')
            );
            $tipo_iva = $this->tipos_iva_model->get_where($where);

            $IdIVA = $this->input->post('idtipo_iva');   //  Tipo de IVA, ej 5 = 21%    FEParamGetTiposIVA
            $ImporteIVA = round($ImpNeto * $tipo_iva['porcentaje'] / 100, 2);
            /*
             *  Fin de IVA
             */

            /*
             *  Agrego tributos al comprobante
             */
            $IdTributo = 2;   //  En este caso, 2 = Impuestos Provinciales   FEParamGetTiposTributos
            $TributoDescripcion = "Percepcion IIBB";
            $TributoBaseImponible = $ImpNeto;
            $TributoAlicuota = round($alicuota_caba + $alicuota_arba, 2);
            $TributoImporte = round($percepcion_caba + $percepcion_arba, 2);
            /*
             *  Fin de tributos
             */

            $Total = round($total_neto + $percepcion_caba + $percepcion_arba + $ImporteIVA, 2);

            $wsfe = new WsFE();
            $wsfe->CUIT = floatval($CUIT);
            $wsfe->setURL(URLWSW);


            $UltimoNroComprobante = 0;
            if ($wsfe->Login($certificado, $clave, $urlwsaa)) {
                if (!$wsfe->RecuperaLastCMP($PtoVta, $TipoComp)) {
                    $json = array(
                        'status' => 'error',
                        'data' => $wsfe->ErrorDesc
                    );
                    echo json_encode($json);
                } else {
                    $r = $wsfe->getUltimoComprobanteAutorizado($PtoVta, $TipoComp);
                    $UltimoNroComprobante = $r->CbteNro;

                    $wsfe->Reset();
                    $NumeroFacturaDesde = $wsfe->RespUltNro + 1;
                    $NumeroFacturaHasta = $NumeroFacturaDesde;

                    $wsfe->AgregaFactura($concepto, $TipoDoc, 33647656779, $NumeroFacturaDesde, $NumeroFacturaHasta, $FechaComprobante, $Total, $ImpTotConc, $ImpNeto, $ImpOpEx, $FchServDesde, $FchServHasta, $FchVtoPago, $MonedaId, $MonedaCotizacion);
                    $wsfe->AgregaIva($IdIVA, $ImpNeto, $ImporteIVA);
                    $wsfe->AgregaTributo($IdTributo, $TributoDescripcion, $TributoBaseImponible, $TributoAlicuota, $TributoImporte);

                    $auth = false;
                    try {
                        if ($wsfe->Autorizar($PtoVta, $TipoComp)) {
                            $auth = true;
                        } else {
                            $json = array(
                                'status' => 'error',
                                'data' => $wsfe->ErrorDesc
                            );
                            echo json_encode($json);
                        }
                    } catch (Exception $e) {
                        if ($wsfe->CmpConsultar($TipoComp, $PtoVta, $NumeroFacturaDesde, $cbte)) {
                            $auth = true;
                        } else {
                            //cii
                        }
                    }

                    if ($auth) {
                        $datos = array(
                            'idtipo_comprobante' => $this->input->post('tipo_comprobante'),
                            'punto_de_venta' => $PtoVta,
                            'numero_comprobante' => $NumeroFacturaDesde,
                            'fecha' => date("Y-m-d"),
                            'cae' => $wsfe->RespCAE,
                            'vencimiento_cae' => $wsfe->RespVencimiento,
                            'estado' => 'F'
                        );
                        $where = array(
                            'idcomprobante' => $this->input->post('idcomprobante')
                        );
                        $this->comprobantes_model->update($datos, $where);
                        var_dump($datos);

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


            /*
              if ($wsfe->Login($certificado, $clave, $urlwsaa)) {
              if (!$wsfe->RecuperaLastCMP($PtoVta, $TipoComp)) {
              $json = array(
              'status' => 'error',
              'data' => $wsfe->ErrorDesc
              );
              echo json_encode($json);
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
             * 
             */
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