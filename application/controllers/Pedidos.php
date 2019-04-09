<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pedidos extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array(
            'session',
            'r_session',
            'form_validation'
        ));
        $this->load->model(array(
            'pedidos_model',
            'monedas_model',
            'parametros_model',
            'tipos_iva_model',
            'clientes_model',
            'transportes_model',
            'condiciones_de_venta_model',
            'monedas_model',
            'tipos_iva_model',
            'log_model'
        ));

        $session = $this->session->all_userdata();
        $this->r_session->check($session);
    }

    public function agregar() {
        $data['title'] = 'Agregar Pedido';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array(
            '/assets/modulos/pedidos/js/agregar.js'
        );
        $data['view'] = 'pedidos/agregar';

        $data['dolar'] = $this->monedas_model->get_ultima_cotizacion_por_monedas(1); // 1 es id del dolar
        $data['parametro'] = $this->parametros_model->get_parametros_empresa();
        $data['tipos_iva'] = $this->tipos_iva_model->gets();

        $this->load->view('layout/app', $data);
    }

    public function agregar_ajax() {
        $session = $this->session->all_userdata();

        $this->form_validation->set_rules('idcliente', 'Cliente', 'required|integer');
        $this->form_validation->set_rules('idcliente_sucursal', 'Sucursal', 'required|integer');
        $this->form_validation->set_rules('idtransporte', 'Transporte', 'required|integer');
        $this->form_validation->set_rules('idcondicion_de_venta', 'Condición de Venta', 'required|integer');
        $this->form_validation->set_rules('imprime_despacho', 'Imprime Despacho', 'required');
        $this->form_validation->set_rules('idmoneda', 'Moneda', 'required|integer');
        $this->form_validation->set_rules('dolar_oficial', 'Dólar Oficial', 'required|decimal');
        $this->form_validation->set_rules('factor_correccion', 'Factor de Corrección', 'required|decimal');
        $this->form_validation->set_rules('idtipo_iva', 'Porcentaje de IVA', 'required|integer');

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $where = array(
                'idcliente' => $this->input->post('idcliente')
            );
            $cliente = $this->clientes_model->get_where($where);

            $where = array(
                'idcliente_sucursal' => $this->input->post('idcliente_sucursal')
            );
            $sucursal = $this->clientes_model->get_where_sucursal($where);

            $set = array(
                'idcliente' => $this->input->post('idcliente'),
                'cliente' => $cliente['cliente'],
                'idcliente_sucursal' => $this->input->post('idcliente_sucursal'),
                'sucursal' => $sucursal['sucursal'],
                'idtransporte' => $this->input->post('idtransporte'),
                'idcondicion_de_venta' => $this->input->post('idcondicion_de_venta'),
                'imprime_despacho' => $this->input->post('imprime_despacho'),
                'orden_de_compra' => $this->input->post('orden_de_compra'),
                'idmoneda' => $this->input->post('idmoneda'),
                'dolar_oficial' => $this->input->post('dolar_oficial'),
                'factor_correccion' => $this->input->post('factor_correccion'),
                'idtipo_iva' => $this->input->post('idtipo_iva'),
                'fecha_creacion' => date("Y-m-d H:i:s"),
                'idcreador' => $session['SID'],
                'actualizado_por' => $session['SID']
            );

            $id = $this->pedidos_model->set($set);

            if ($id) {
                $where = array(
                    'idtransporte' => $this->input->post('idtransporte')
                );
                $transporte = $this->transportes_model->get_where($where);

                $where = array(
                    'idcondicion_de_venta' => $this->input->post('idcondicion_de_venta')
                );
                $condicion_de_venta = $this->condiciones_de_venta_model->get_where($where);

                $where = array(
                    'idmoneda' => $this->input->post('idmoneda')
                );
                $moneda = $this->monedas_model->get_where($where);

                $where = array(
                    'idtipo_iva' => $this->input->post('idtipo_iva')
                );
                $tipo_iva = $this->tipos_iva_model->get_where($where);

                $log = array(
                    'tabla' => 'pedidos',
                    'idtabla' => $id,
                    'texto' => "<h2><strong>Se creó el pedido número: " . $id . "</strong></h2>

<p>
<strong>ID Cliente: </strong>" . $this->input->post('idcliente') . "<br />
<strong>Cliente: </strong>" . $cliente['cliente'] . "<br />
<strong>ID Sucursal: </strong>" . $this->input->post('idcliente_sucursal') . "<br />
<strong>Sucursal: </strong>" . $sucursal['sucursal'] . "<br />
<strong>ID Transporte: </strong>" . $this->input->post('idtransporte') . "<br />
<strong>Transporte: </strong>" . $transporte['transporte'] . "<br />
<strong>ID Condición de Venta </strong>" . $this->input->post('idcondicion_de_venta') . "<br />
<strong>Condición de Venta </strong>" . $condicion_de_venta['condicion_de_venta'] . "<br />
<strong>Imprime Despacho: </strong>" . $this->input->post('imprime_despacho') . "<br />
<strong>Orden de Compra: </strong>" . $this->input->post('orden_de_compra') . "<br />
<strong>ID Moneda: </strong>" . $this->input->post('idmoneda') . "<br />
<strong>Moneda: </strong>" . $moneda['moneda'] . "<br />
<strong>Dólar Oficial: </strong>" . $this->input->post('dolar_oficial') . "<br />
<strong>Factor de Corrección: </strong>" . $this->input->post('factor_correccion') . "<br />
<strong>ID Tipo de IVA: </strong>" . $this->input->post('idtipo_iva') . "<br />
<strong>Tipo de IVA: </strong>" . $tipo_iva['porcentaje'] . "
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

    public function modificar($idpedido = null) {
        if ($idpedido == null) {
            redirect('/pedidos/listar/', 'refresh');
        }

        $data['title'] = 'Modificar Pedido';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array(
            '/assets/modulos/pedidos/js/modificar.js'
        );
        $data['view'] = 'pedidos/modificar';

        $where = array(
            'idpedido' => $idpedido
        );
        $data['pedido'] = $this->pedidos_model->get_where($where);
        $where = array(
            'idmoneda' => $data['pedido']['idmoneda']
        );
        $data['pedido']['moneda'] = $this->monedas_model->get_where($where);

        $data['monedas'] = $this->monedas_model->gets();
        $data['tipos_iva'] = $this->tipos_iva_model->gets();

        $this->load->view('layout/app', $data);
    }

    public function actualizar_cabecera_ajax() {
        $session = $this->session->all_userdata();

        $this->form_validation->set_rules('idpedido', 'Número de Pedido', 'required|integer');
        $this->form_validation->set_rules('idcliente', 'Cliente', 'required|integer');
        $this->form_validation->set_rules('idcliente_sucursal', 'Sucursal', 'required|integer');
        $this->form_validation->set_rules('idtransporte', 'Transporte', 'required|integer');
        $this->form_validation->set_rules('idcondicion_de_venta', 'Condición de Venta', 'required|integer');
        $this->form_validation->set_rules('imprime_despacho', 'Imprime Despacho', 'required');
        $this->form_validation->set_rules('idmoneda', 'Moneda', 'required|integer');
        $this->form_validation->set_rules('dolar_oficial', 'Dólar Oficial', 'required|decimal');
        $this->form_validation->set_rules('factor_correccion', 'Factor de Corrección', 'required|decimal');
        $this->form_validation->set_rules('idtipo_iva', 'Porcentaje de IVA', 'required|integer');

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $where = array(
                'idcliente' => $this->input->post('idcliente')
            );
            $cliente = $this->clientes_model->get_where($where);

            $where = array(
                'idcliente_sucursal'
            );
            $sucursal = $this->clientes_model->get_where_sucursal($where);

            $update = array(
                'idcliente' => $this->input->post('idcliente'),
                'cliente' => $cliente['cliente'],
                'idcliente_sucursal' => $this->input->post('idcliente_sucursal'),
                'sucursal' => $sucursal['sucursal'],
                'idtransporte' => $this->input->post('idtransporte'),
                'idcondicion_de_venta' => $this->input->post('idcondicion_de_venta'),
                'imprime_despacho' => $this->input->post('imprime_despacho'),
                'orden_de_compra' => $this->input->post('orden_de_compra'),
                'idmoneda' => $this->input->post('idmoneda'),
                'dolar_oficial' => $this->input->post('dolar_oficial'),
                'factor_correccion' => $this->input->post('factor_correccion'),
                'idtipo_iva' => $this->input->post('idtipo_iva'),
                'actualizado_por' => $session['SID']
            );
            $where = array(
                'idpedido' => $this->input->post('idpedido')
            );
            $resultado = $this->pedidos_model->update($update, $where);

            if ($resultado) {
                $json = array(
                    'status' => 'ok',
                    'data' => 'La cabecera se actualizó correctamente.'
                );
                echo json_encode($json);
            } else {
                $json = array(
                    'status' => 'error',
                    'data' => 'No se pudieron actualizar los datos.'
                );
                echo json_encode($json);
            }
        }
    }

    public function agregar_articulo_ajax() {
        $session = $this->session->all_userdata();
        
        $this->form_validation->set_rules('idpedido', 'ID Pedido', 'required|integer');
        $this->form_validation->set_rules('idarticulo', 'Artículo', 'required|integer');
        $this->form_validation->set_rules('muestra_marca', 'Muestra Marca', 'required');
        $this->form_validation->set_rules('almacen', 'Almacén', 'required|integer');
        $this->form_validation->set_rules('cantidad', 'Cantidad', 'required|integer');
        $this->form_validation->set_rules('precio', 'Precio', 'required|decimal');
        
        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        }
    }
}

?>