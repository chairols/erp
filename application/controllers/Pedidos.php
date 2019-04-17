<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pedidos extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array(
            'session',
            'r_session',
            'form_validation',
            'pagination'
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
            'log_model',
            'articulos_model',
            'marcas_model'
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
            'identificador' => 'pedidos_dias_entrega',
            'idparametro_tipo' => 3
        );
        $data['dias_entrega'] = $this->parametros_model->get_where($where);

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
        $this->form_validation->set_rules('fecha_entrega', 'Fecha de Entrega', 'required');

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $where = array(
                'idarticulo' => $this->input->post('idarticulo')
            );
            $articulo = $this->articulos_model->get_where($where);

            $where = array(
                'idmarca' => $articulo['idmarca']
            );
            $marca = $this->marcas_model->get_where($where);

            $set = array(
                'idpedido' => $this->input->post('idpedido'),
                'idarticulo' => $this->input->post('idarticulo'),
                'articulo' => $articulo['articulo'],
                'marca' => $marca['marca'],
                'muestra_marca' => $this->input->post('muestra_marca'),
                'almacen' => $this->input->post('almacen'),
                'cantidad' => $this->input->post('cantidad'),
                'cantidad_pendiente' => $this->input->post('cantidad'),
                'precio' => $this->input->post('precio'),
                'fecha_entrega' => $this->formatear_fecha($this->input->post('fecha_entrega')),
                'despacho' => $articulo['despacho'],
                'fecha_creacion' => date("Y-m-d H:i:s"),
                'idcreador' => $session['SID'],
                'actualizado_por' => $session['SID']
            );

            $resultado = $this->pedidos_model->set_item($set);
            if ($resultado) {
                $json = array(
                    'status' => 'ok',
                    'data' => 'Se agregó el artículo ' . $articulo['articulo']
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

    public function gets_articulos_tabla() {
        $where = array(
            'idpedido' => $this->input->post('idpedido'),
            'estado' => 'P'
        );
        $data['articulos'] = $this->pedidos_model->gets_articulos_where($where);

        foreach($data['articulos'] as $key => $value) {
            $data['articulos'][$key]['fecha_formateada'] = $this->formatear_fecha_para_mostrar($value['fecha_entrega']);
        }
        $this->load->view('pedidos/gets_articulos_tabla', $data);
    }

    public function listar($pagina = 0) {
        $data['title'] = 'Listado de Pedidos';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array();
        $data['view'] = 'pedidos/listar';


        $per_page = $this->parametros_model->get_valor_parametro_por_usuario('per_page', $data['session']['SID']);
        $per_page = $per_page['valor'];

        $where['pedidos.estado'] = 'P';
        $where['clientes.cliente'] = $this->input->get('cliente');
        $where['articulos.articulo'] = $this->input->get('articulo');

        /*
         * inicio paginador
         */
        $total_rows = $this->pedidos_model->get_cantidad_where($where);
        $config['reuse_query_string'] = TRUE;
        $config['base_url'] = '/pedidos/listar/';
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

        $data['pedidos'] = $this->pedidos_model->gets_where_limit($where, $per_page, $pagina);

        foreach ($data['pedidos'] as $key => $value) {
            $data['pedidos'][$key]['fecha_formateada'] = $this->formatear_fecha_para_mostrar($value['fecha_creacion']);

            $where = array(
                'idcliente' => $value['idcliente']
            );
            $data['pedidos'][$key]['cliente'] = $this->clientes_model->get_where($where);

            $where = array(
                'idmoneda' => $value['idmoneda']
            );
            $data['pedidos'][$key]['moneda'] = $this->monedas_model->get_where($where);


            $data['pedidos'][$key]['cotizacion_dolar'] = $this->monedas_model->get_ultima_cotizacion_por_monedas(1);
            $data['pedidos'][$key]['cotizacion_moneda'] = $this->monedas_model->get_ultima_cotizacion_por_monedas($data['pedidos'][$key]['idmoneda']);

            $where = array(
                'idpedido' => $value['idpedido'],
                'estado' => 'P'
            );
            $data['pedidos'][$key]['items'] = $this->pedidos_model->gets_articulos_where($where);

            foreach ($data['pedidos'][$key]['items'] as $key2 => $value2) {
                $where = array(
                    'idarticulo' => $value2['idarticulo']
                );
                $data['pedidos'][$key]['items'][$key2]['articulo'] = $this->articulos_model->get_where($where);

                /*
                  $where = array(
                  'idlinea' => $data['pedidos'][$key]['items'][$key2]['articulo']['idlinea']
                  );
                  $data['pedidos'][$key]['items'][$key2]['articulo']['linea'] = $this->lineas_model->get_where($where);
                  /*
                  $where = array(
                  'idmarca' => $data['cotizaciones'][$key]['items'][$key2]['articulo']['idmarca']
                  );
                  $data['cotizaciones'][$key]['items'][$key2]['articulo']['marca'] = $this->marcas_model->get_where($where);

                  $data['cotizaciones'][$key]['items'][$key2]['cotizacion_dolar'] = $this->monedas_model->get_ultima_cotizacion_por_monedas(1);
                 * */
            }
        }
        /*
          foreach($data['pedidos'] as $key => $value) {
          $data['pedidos'][$key]['fecha_formateada'] = $this->formatear_fecha_para_mostrar($value['fecha_creacion']);

          $where = array(
          'pedidos_items.idpedido' => $value['idpedido'],
          'pedidos_items.estado' => 'P'
          );
          $data['pedidos'][$key]['items'] = $this->pedidos_model->gets_articulos_where($where);
          }
         * 
         */

        $this->load->view('layout/app', $data);
    }

    public function borrar_articulo_ajax() {
        $session = $this->session->all_userdata();

        $this->form_validation->set_rules('idpedido_item', 'ID Pedido Item', 'required|integer');

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
                'idpedido_item' => $this->input->post('idpedido_item')
            );

            $resultado = $this->pedidos_model->update_item($datos, $where);

            if ($resultado) {

                $where = array(
                    'idpedido_item' => $this->input->post('idpedido_item')
                );
                $item = $this->pedidos_model->get_where_item($where);
                $log = array(
                    'tabla' => 'pedidos',
                    'idtabla' => $item['idpedido'],
                    'texto' => "<h2><strong>Se eliminó el item: " . $item['articulo'] . "</strong></h2>

<p>
<strong>ID Artículo: </strong>" . $item['idarticulo'] . "<br />
<strong>Cantidad: </strong>" . $item['cantidad'] . "<br />
<strong>Cantidad Pendiente: </strong>" . $item['cantidad_pendiente'] . "<br />
<strong>Precio: </strong>" . $item['precio'] . "<br />
<strong>Marca: </strong>" . $item['marca'] . "<br />
<strong>Muestra Marca: </strong>" . $item['muestra_marca'] . "<br />
<strong>Almacén: </strong>" . $item['almacen'] . "<br />
</p>",
                    'idusuario' => $session['SID'],
                    'tipo' => 'del'
                );
                $this->log_model->set($log);

                $json = array(
                    'status' => 'ok',
                    'data' => 'Se eliminó correctamente el artículo ' . $item['articulo']
                );
                echo json_encode($json);
            } else {
                $json = array(
                    'status' => 'error',
                    'data' => 'No se pudo eliminar el artículo'
                );
                echo json_encode($json);
            }
        }
    }

    public function get_articulo_where_json() {
        $where = $this->input->post();

        $item = $this->pedidos_model->get_where_item($where);

        $where = array(
            'idarticulo' => $item['idarticulo']
        );
        $item['articulo'] = $this->articulos_model->get_where($where);
        
        $item['fecha_formateada'] = $this->formatear_fecha_para_mostrar($item['fecha_entrega']);

        echo json_encode($item);
    }
    
    public function modificar_item_ajax() {
        $session = $this->session->all_userdata();

        $this->form_validation->set_rules('idpedido', 'ID Pedido', 'required|integer');
        $this->form_validation->set_rules('idpedido_item', 'ID Pedido Item', 'required|integer');
        $this->form_validation->set_rules('cantidad', 'Cantidad', 'required');
        $this->form_validation->set_rules('muestra_marca', 'Imprime Marca', 'required');
        $this->form_validation->set_rules('almacen', 'Almacén', 'required|integer');
        $this->form_validation->set_rules('precio', 'Precio', 'required|decimal');
        $this->form_validation->set_rules('fecha_entrega', 'Fecha de Entrega', 'required');

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $datos = $this->input->post();
            $datos['fecha_entrega'] = $this->formatear_fecha($this->input->post('fecha_entrega'));
            $where = array(
                'idpedido_item' => $this->input->post('idpedido_item'),
                'idpedido' => $this->input->post('idpedido')
            );

            $resultado = $this->pedidos_model->update_item($datos, $where);

            if ($resultado) {
                $json = array(
                    'status' => 'ok',
                    'data' => 'Se actualizó el artículo'
                );
                echo json_encode($json);
            } else {
                $json = array(
                    'status' => 'error',
                    'data' => 'No se pudo actualizar el artículo'
                );
                echo json_encode($json);
            }
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