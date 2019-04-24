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
            'comprobantes_model'
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
                    
                    $id = $this->comprobantes_model->set($set);
                    
                    $json = array(
                        'status' => 'ok',
                        'data' => $id
                    );
                    echo json_encode($json);
                } else {
                    $json = array(
                        'status' => 'error',
                        'data' => 'El cliente '.$cliente['cliente']. ' no tiene asignado un domicilio fiscal'
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