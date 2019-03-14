<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cotizaciones_clientes extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array(
            'session',
            'r_session',
            'form_validation',
            'pagination',
            'pdf_cotizacion_cliente',
            'email'
        ));
        $this->load->model(array(
            'monedas_model',
            'cotizaciones_clientes_model',
            'clientes_model',
            'log_model',
            'articulos_model',
            'marcas_model',
            'parametros_model',
            'lineas_model',
            'tipos_responsables_model',
            'condiciones_de_venta_model'
        ));

        $session = $this->session->all_userdata();
        $this->r_session->check($session);
    }

    public function agregar() {
        $data['title'] = 'Nueva Cotización';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array(
            '/assets/modulos/cotizaciones_clientes/js/agregar.js'
        );
        $data['view'] = 'cotizaciones_clientes/agregar';

        $data['monedas'] = $this->monedas_model->gets();

        $this->load->view('layout/app', $data);
    }

    public function agregar_ajax() {
        $session = $this->session->all_userdata();

        $this->form_validation->set_rules('idcliente', 'Cliente', 'required|integer');
        $this->form_validation->set_rules('idsucursal', 'Sucursal', 'required|integer');
        $this->form_validation->set_rules('idmoneda', 'Moneda', 'required|integer');
        $this->form_validation->set_rules('fecha', 'Fecha', 'required');

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

            $this->load->model(array(
                'prueba_model'
            ));
            $where = array(
                'idcliente_sucursal' => $this->input->post('idsucursal')
            );
            $sucursal = $this->prueba_model->get_sucursal_where($where);

            $set = array(
                'idcliente' => $this->input->post('idcliente'),
                'cliente' => $cliente['cliente'],
                'idsucursal' => $sucursal['idcliente_sucursal'],
                'domicilio' => $sucursal['direccion'],
                'localidad' => $sucursal['localidad'],
                'idmoneda' => $this->input->post('idmoneda'),
                'fecha' => $this->formatear_fecha($this->input->post('fecha')),
                'observaciones' => $this->input->post('observaciones'),
                'fecha_creacion' => date("Y-m-d H:i:s"),
                'idcreador' => $session['SID'],
                'actualizado_por' => $session['SID']
            );

            $id = $this->cotizaciones_clientes_model->set($set);

            if ($id) {
                $where = array(
                    'idmoneda' => $this->input->post('idmoneda')
                );
                $moneda = $this->monedas_model->get_where($where);

                $log = array(
                    'tabla' => 'cotizaciones_clientes',
                    'idtabla' => $id,
                    'texto' => "<h2><strong>Se creó la cotización de cliente número: " . $id . "</strong></h2>

<p>
<strong>Cliente: </strong>" . $cliente['cliente'] . "<br />
<strong>Moneda: </strong>" . $moneda['moneda'] . "<br />
<strong>Fecha de Cotización: </strong>" . $this->input->post('fecha') . "<br />
<strong>Observaciones: </strong>" . $this->input->post('observaciones') . "
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

    public function modificar($idcotizacion_cliente = null) {
        if ($idcotizacion_cliente == null) {
            redirect('/cotizaciones_clientes/listar/', 'refresh');
        }

        $data['title'] = 'Modificar Cotización a Cliente';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array(
            '/assets/modulos/cotizaciones_clientes/js/modificar.js'
        );
        $data['view'] = 'cotizaciones_clientes/modificar';

        $where = array(
            'idcotizacion_cliente' => $idcotizacion_cliente
        );
        $data['cotizacion_cliente'] = $this->cotizaciones_clientes_model->get_where($where);

        $where = array(
            'idcliente' => $data['cotizacion_cliente']['idcliente']
        );
        $data['cotizacion_cliente']['cliente'] = $this->clientes_model->get_where($where);

        $where = array(
            'clientes_agentes.idcliente' => $data['cotizacion_cliente']['idcliente'],
            'clientes_agentes.estado' => 'A'
        );
        $data['cotizacion_cliente']['cliente']['agentes'] = $this->clientes_model->gets_agentes_where($where);

        $data['monedas'] = $this->monedas_model->gets();

        $data['cotizacion_cliente']['fecha_formateada'] = $this->formatear_fecha_para_mostrar($data['cotizacion_cliente']['fecha']);

        $data['empresa'] = $this->parametros_model->get_parametros_empresa();

        $this->load->view('layout/app', $data);
    }

    public function actualizar_cabecera_ajax() {
        $session = $this->session->all_userdata();

        $this->form_validation->set_rules('idcliente', 'Cliente', 'required|integer');
        $this->form_validation->set_rules('idmoneda', 'Moneda', 'required|integer');
        $this->form_validation->set_rules('fecha', 'Fecha', 'required');

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $datos = array(
                'idcliente' => $this->input->post('idcliente'),
                'idmoneda' => $this->input->post('idmoneda'),
                'fecha' => $this->formatear_fecha($this->input->post('fecha')),
                'observaciones' => $this->input->post('observaciones'),
                'actualizado_por' => $session['SID']
            );
            $where = array(
                'idcotizacion_cliente' => $this->input->post('idcotizacion_cliente')
            );

            $resultado = $this->cotizaciones_clientes_model->update($datos, $where);

            if ($resultado) {
                $where = array(
                    'idcliente' => $this->input->post('idcliente')
                );
                $cliente = $this->clientes_model->get_where($where);

                $where = array(
                    'idmoneda' => $this->input->post('idmoneda')
                );
                $moneda = $this->monedas_model->get_where($where);

                $log = array(
                    'tabla' => 'cotizaciones_clientes',
                    'idtabla' => $this->input->post('idcotizacion_cliente'),
                    'texto' => "<h2><strong>Se actualizó la cabecera de la cotización de cliente N°: " . $this->input->post('idcotizacion_cliente') . "</strong></h2>

<p><strong>Proveedor: </strong>" . $cliente['cliente'] . "<br />
<strong>Moneda: </strong>" . $moneda['moneda'] . "<br />
<strong>Fecha de Cotizació: </strong>" . $this->input->post('fecha') . "<br />
<strong>Observaciones: </strong>" . $this->input->post('observaciones') . "</p>",
                    'idusuario' => $session['SID'],
                    'tipo' => 'edit'
                );
                $this->log_model->set($log);

                $json = array(
                    'status' => 'ok',
                    'data' => 'Se actualizó la cabecera de la cotización'
                );
                echo json_encode($json);
            } else {
                $json = array(
                    'status' => 'error',
                    'data' => 'No se pudo actualizar la cabecera de la cotización'
                );
                echo json_encode($json);
            }
        }
    }

    public function listar_articulos_tabla_ajax() {
        $where = array(
            'idcotizacion_cliente' => $this->input->post('idcotizacion_cliente'),
            'estado' => 'A'
        );

        $data['articulos'] = $this->cotizaciones_clientes_model->gets_articulos_where($where);
        foreach ($data['articulos'] as $key => $value) {
            $where = array(
                'idarticulo' => $value['idarticulo']
            );
            $data['articulos'][$key]['articulo'] = $this->articulos_model->get_where($where);

            $where = array(
                'idmarca' => $data['articulos'][$key]['articulo']['idmarca']
            );
            $data['articulos'][$key]['marca'] = $this->marcas_model->get_where($where);

            $data['articulos'][$key]['fecha_formateada'] = $this->formatear_fecha_para_mostrar($value['fecha_entrega']);
        }

        $this->load->view('cotizaciones_clientes/listar_articulos_tabla_ajax', $data);
    }

    public function agregar_articulo_ajax() {
        $session = $this->session->all_userdata();

        $this->form_validation->set_rules('idcotizacion_cliente', 'ID Cotizacion Cliente', 'required|integer');
        $this->form_validation->set_rules('cantidad', 'Cantidad', 'required|integer');
        $this->form_validation->set_rules('idarticulo', 'Artículo', 'required|integer');
        $this->form_validation->set_rules('descripcion', 'Descripción', 'required');
        $this->form_validation->set_rules('precio', 'Precio', 'required|decimal');
        $this->form_validation->set_rules('fecha', 'Fecha', 'required');

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $set = array(
                'idcotizacion_cliente' => $this->input->post('idcotizacion_cliente'),
                'cantidad' => $this->input->post('cantidad'),
                'idarticulo' => $this->input->post('idarticulo'),
                'descripcion' => $this->input->post('descripcion'),
                'precio' => $this->input->post('precio'),
                'fecha_entrega' => $this->formatear_fecha($this->input->post('fecha')),
                'observaciones_item' => $this->input->post('observaciones_item'),
                'idcreador' => $session['SID'],
                'fecha_creacion' => date("Y-m-d H:i:s"),
                'modificado_por' => $session['SID']
            );

            $id = $this->cotizaciones_clientes_model->set_item($set);

            if ($id) {
                $where = array(
                    'idarticulo' => $this->input->post('idarticulo')
                );
                $articulo = $this->articulos_model->get_where($where);

                $where = array(
                    'idmarca' => $articulo['idmarca']
                );
                $marca = $this->marcas_model->get_where($where);

                $log = array(
                    'tabla' => 'cotizaciones_clientes',
                    'idtabla' => $id,
                    'texto' => "<h2><strong>Se agregó item a la cotización de cliente número: " . $this->input->post('idcotizacion_cliente') . "</strong></h2>

<p>
<strong>Artículo: </strong>" . $articulo['articulo'] . "<br />
<strong>Marca: </strong>" . $marca['marca'] . "<br />
<strong>Descripcion: </strong>" . $this->input->post('descripcion') . "<br />
<strong>Precio: </strong>" . $this->input->post('precio') . "<br />
<strong>Fecha de Entrega: </strong>" . $this->input->post('fecha') . "<br />
<strong>Observaciones: </strong>" . $this->input->post('observaciones_item') . "<br />
</p>",
                    'idusuario' => $session['SID'],
                    'tipo' => 'add'
                );
                $this->log_model->set($log);

                $json = array(
                    'status' => 'ok',
                    'data' => 'Se agregó el artículo ' . $articulo['articulo'] . ' - ' . $marca['marca']
                );
                echo json_encode($json);
            } else {
                $json = array(
                    'status' => 'error',
                    'data' => 'No se pudo agregar el artículo'
                );
                echo json_encode($json);
            }
        }
    }

    public function borrar_articulo_ajax() {
        $session = $this->session->all_userdata();

        $this->form_validation->set_rules('idcotizacion_cliente_item', 'ID Cotización Item', 'required|integer');

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
                'idcotizacion_cliente_item' => $this->input->post('idcotizacion_cliente_item')
            );

            $resultado = $this->cotizaciones_clientes_model->update_item($datos, $where);

            if ($resultado) {

                $where = array(
                    'idcotizacion_cliente_item' => $this->input->post('idcotizacion_cliente_item')
                );
                $item = $this->cotizaciones_clientes_model->get_where_item($where);
                $log = array(
                    'tabla' => 'cotizaciones_clientes',
                    'idtabla' => $item['idcotizacion_cliente'],
                    'texto' => "<h2><strong>Se eliminó el item: " . $item['descripcion'] . "</strong></h2>

<p>
<strong>Cantidad: </strong>" . $item['cantidad'] . "<br />
<strong>Precio: </strong>" . $item['precio'] . "<br />
<strong>Fecha de Entrega: </strong>" . $item['fecha_entrega'] . "<br />
<strong>Observaciones: </strong>" . $item['observaciones_item'] . "<br />
</p>",
                    'idusuario' => $session['SID'],
                    'tipo' => 'del'
                );
                $this->log_model->set($log);

                $json = array(
                    'status' => 'ok',
                    'data' => 'Se eliminó correctamente el artículo'
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

    public function listar($pagina = 0) {
        $data['title'] = 'Listar Cotizaciones a Clientes';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array();
        $data['view'] = 'cotizaciones_clientes/listar';


        $per_page = $this->parametros_model->get_valor_parametro_por_usuario('per_page', $data['session']['SID']);
        $per_page = $per_page['valor'];

        $where = $this->input->get();
        $where['cotizaciones_clientes.estado'] = 'A';
        $where['cotizaciones_clientes_items.estado'] = 'A';

        /*
         * inicio paginador
         */
        $total_rows = $this->cotizaciones_clientes_model->get_cantidad_where($where);
        $config['reuse_query_string'] = TRUE;
        $config['base_url'] = '/cotizaciones_clientes/listar/';
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

        $data['cotizaciones'] = $this->cotizaciones_clientes_model->gets_where_limit($where, $per_page, $pagina);

        foreach ($data['cotizaciones'] as $key => $value) {
            $data['cotizaciones'][$key]['fecha_formateada'] = $this->formatear_fecha_para_mostrar($value['fecha']);

            $where = array(
                'idcliente' => $value['idcliente']
            );
            $data['cotizaciones'][$key]['cliente'] = $this->clientes_model->get_where($where);

            $where = array(
                'idmoneda' => $value['idmoneda']
            );
            $data['cotizaciones'][$key]['moneda'] = $this->monedas_model->get_where($where);

            $data['cotizaciones'][$key]['cotizacion_dolar'] = $this->monedas_model->get_ultima_cotizacion_por_monedas(1);
            $data['cotizaciones'][$key]['cotizacion_moneda'] = $this->monedas_model->get_ultima_cotizacion_por_monedas($data['cotizaciones'][$key]['idmoneda']);

            $where = array(
                'idcotizacion_cliente' => $value['idcotizacion_cliente'],
                'estado' => 'A'
            );
            $data['cotizaciones'][$key]['items'] = $this->cotizaciones_clientes_model->gets_articulos_where($where);
            foreach ($data['cotizaciones'][$key]['items'] as $key2 => $value2) {
                $where = array(
                    'idarticulo' => $value2['idarticulo']
                );
                $data['cotizaciones'][$key]['items'][$key2]['articulo'] = $this->articulos_model->get_where($where);

                $where = array(
                    'idlinea' => $data['cotizaciones'][$key]['items'][$key2]['articulo']['idlinea']
                );
                $data['cotizaciones'][$key]['items'][$key2]['articulo']['linea'] = $this->lineas_model->get_where($where);

                $where = array(
                    'idmarca' => $data['cotizaciones'][$key]['items'][$key2]['articulo']['idmarca']
                );
                $data['cotizaciones'][$key]['items'][$key2]['articulo']['marca'] = $this->marcas_model->get_where($where);

                $data['cotizaciones'][$key]['items'][$key2]['cotizacion_dolar'] = $this->monedas_model->get_ultima_cotizacion_por_monedas(1);
            }
        }

        $this->load->view('layout/app', $data);
    }

    public function pdf($idcotizacion_cliente = null, $modo = null) {

        if ($idcotizacion_cliente != null && $modo != null) {
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


            $this->pdf->Output('COTIZACION ' . str_pad($idcotizacion_cliente, 8, '0', STR_PAD_LEFT) . '.pdf', $modo);
        }
    }

    public function gets_antecedentes_ajax_tabla() {
        $this->form_validation->set_rules('idcliente', 'Cliente', 'required|integer');
        $this->form_validation->set_rules('idarticulo', 'Artículo', 'required|integer');

        if ($this->form_validation->run() == FALSE) {
            echo "No se realizó la consulta correctamente";
        } else {
            $where = array(
                'idarticulo' => $this->input->post('idarticulo')
            );
            $articulo = $this->articulos_model->get_where($where);

            if ($articulo['idarticulo_generico'] > 0) {
                $where = array(
                    'articulos.idarticulo_generico' => $articulo['idarticulo_generico'],
                    'cotizaciones_clientes.idcliente' => $this->input->post('idcliente'),
                    'cotizaciones_clientes.estado' => 'A',
                    'cotizaciones_clientes_items.estado' => 'A'
                );

                $data['articulos'] = $this->cotizaciones_clientes_model->gets_articulos_trazabilidad_where($where);

                foreach ($data['articulos'] as $key => $value) {
                    $data['articulos'][$key]['fecha_formateada'] = $this->formatear_fecha_para_mostrar($value['fecha']);
                }
                $this->load->view('cotizaciones_clientes/gets_antecedentes_ajax_tabla', $data);
            } else if ($articulo['idarticulo_generico'] == 0) {
                $where = array(
                    'articulos.idarticulo' => $this->input->post('idarticulo'),
                    'cotizaciones_clientes.idcliente' => $this->input->post('idcliente'),
                    'cotizaciones_clientes.estado' => 'A',
                    'cotizaciones_clientes_items.estado' => 'A'
                );

                $data['articulos'] = $this->cotizaciones_clientes_model->gets_articulos_trazabilidad_where($where);

                foreach ($data['articulos'] as $key => $value) {
                    $data['articulos'][$key]['fecha_formateada'] = $this->formatear_fecha_para_mostrar($value['fecha']);
                }
                $this->load->view('cotizaciones_clientes/gets_antecedentes_ajax_tabla', $data);
            }
        }
    }

    public function enviar_mail() {
        $this->form_validation->set_rules('correos[]', 'Direcciones de Correo', 'required');
        $this->form_validation->set_rules('idcotizacion_cliente', 'ID Cotización Cliente', 'required|integer');

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $where = array(
                'idcotizacion_cliente' => $this->input->post('idcotizacion_cliente')
            );
            $cotizacion = $this->cotizaciones_clientes_model->get_where($where);

            $subject = 'Cotización N° ' . str_pad($cotizacion['idcotizacion_cliente'], 8, '0', STR_PAD_LEFT);

            $message = '<p>Adjunto se encuentra nueva cotización.</p>';

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
</body>
</html>';
// Also, for getting full html you may use the following internal method:
//$body = $this->email->full_html($subject, $message);

            $result = $this->email
                    ->from('ventas@rollerservice.com.ar', 'Roller Service S.A.')
                    ->reply_to('ventas@rollerservice.com.ar')    // Optional, an account where a human being reads.
                    ->to('hernanbalboa@gmail.com')
                    //->to($this->input->post('email'))
                    ->subject($subject)
                    ->attach(base_url() . 'extranet/cotizacion_cliente/' . $this->input->post('idcotizacion_cliente') . '/' . $this->generar_hash_cotizacion_para_extranet($this->input->post('idcotizacion_cliente')) . '/', '', 'Cotización ' . str_pad($cotizacion['idcotizacion_cliente'], 8, '0', STR_PAD_LEFT) . '.pdf')
                    ->message($body)
                    ->send();

            if ($result) {
                $json = array(
                    'status' => 'ok',
                    'data' => 'El correo se envió satisfactoriamente'
                );
                echo json_encode($json);
            } else {
                $json = array(
                    'status' => 'error',
                    'data' => 'Ocurrió el siguiente error: <br>' . $this->email->print_debugger()
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

    private function generar_hash_cotizacion_para_extranet($idcotizacion_cliente) {
        // Datos de Retención
        $where = array(
            'idcotizacion_cliente' => $idcotizacion_cliente,
            'estado' => 'A'
        );
        $data['cotizacion'] = $this->cotizaciones_clientes_model->get_where($where);

        $hash_generado = sha1($data['cotizacion']['idcotizacion_cliente'] . $data['cotizacion']['idcliente'] . $data['cotizacion']['cliente'] . $data['cotizacion']['idsucursal'] . $data['cotizacion']['domicilio'] . $data['cotizacion']['localidad'] . $data['cotizacion']['fecha_creacion']);

        return $hash_generado;
    }

}

?>