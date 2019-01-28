<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Importaciones extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array(
            'session',
            'r_session',
            'form_validation',
            'tcpdf/tcpdf',
            'pagination'
        ));
        $this->load->model(array(
            'importaciones_model',
            'log_model',
            'proveedores_model',
            'parametros_model',
            'monedas_model',
            'articulos_model',
            'marcas_model'
        ));

        $session = $this->session->all_userdata();
        $this->r_session->check($session);
    }

    public function agregar() {
        $data['title'] = 'Agregar Pedido de Importación';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array(
            '/assets/modulos/importaciones/js/agregar.js'
        );
        $data['view'] = 'importaciones/agregar';

        $this->form_validation->set_rules('proveedor', 'Proveedor', 'required|integer');
        $this->form_validation->set_rules('moneda', 'Moneda', 'required|integer');
        $this->form_validation->set_rules('fecha_pedido', 'Fecha de Pedido', 'required');

        if ($this->form_validation->run() == FALSE) {
            
        } else {
            $datos = array(
                'idproveedor' => $this->input->post('proveedor'),
                'idmoneda' => $this->input->post('moneda'),
                'fecha_pedido' => $this->formatear_fecha($this->input->post('fecha_pedido')),
                'fecha_creacion' => date("Y-m-d H:i:s"),
                'idcreador' => $data['session']['SID']
            );

            $id = $this->importaciones_model->set($datos);

            if ($id) {
                $log = array(
                    'tabla' => 'importaciones',
                    'idtabla' => $id,
                    'texto' => 'Se agregó la importación ' . $id . '<br>' .
                    'Con número de Proveedor: ' . $datos['idproveedor'] . '<br>' .
                    'ID Moneda: ' . $datos['idmoneda'],
                    'idusuario' => $data['session']['SID'],
                    'tipo' => 'add'
                );

                $this->log_model->set($log);

                redirect('/importaciones/agregar_items/' . $id . '/', 'refresh');
            }
        }

        $data['monedas'] = $this->monedas_model->gets();

        $this->load->view('layout/app', $data);
    }

    public function agregar_ajax() {
        $data['session'] = $this->session->all_userdata();

        $this->form_validation->set_rules('idproveedor', 'Proveedor', 'required|integer');
        $this->form_validation->set_rules('idmoneda', 'Moneda', 'required|integer');
        $this->form_validation->set_rules('fecha', 'Fecha de Pedido', 'required');

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $datos = array(
                'idproveedor' => $this->input->post('idproveedor'),
                'idmoneda' => $this->input->post('idmoneda'),
                'fecha_pedido' => $this->formatear_fecha($this->input->post('fecha')),
                'fecha_creacion' => date("Y-m-d H:i:s"),
                'idcreador' => $data['session']['SID']
            );

            $id = $this->importaciones_model->set($datos);

            if ($id) {
                $where = array(
                    'idproveedor' => $datos['idproveedor']
                );
                $proveedor = $this->proveedores_model->get_where($where);

                $where = array(
                    'idmoneda' => $datos['idmoneda']
                );
                $moneda = $this->monedas_model->get_where($where);

                $log = array(
                    'tabla' => 'importaciones',
                    'idtabla' => $id,
                    'texto' => "<h2><strong>Se cre&oacute; el pedido de importaci&oacute;n n&uacute;mero: " . $id . "</strong></h2>

<p><strong>Proveedor: </strong>" . $proveedor['proveedor'] . "<br />
<strong>Moneda: </strong>" . $moneda['moneda'] . "<br />
&nbsp;</p>
",
                    'idusuario' => $data['session']['SID'],
                    'tipo' => 'add'
                );

                $this->log_model->set($log);

                $json = array(
                    'status' => 'ok',
                    'data' => 'Se creó exitosamente',
                    'id' => $id
                );
                echo json_encode($json);

                //redirect('/importaciones/agregar_items/' . $id . '/', 'refresh');
            } else {
                $json = array(
                    'status' => 'error',
                    'data' => 'No se pudo crear el pedido de importación'
                );
                echo json_encode($json);
            }
        }
    }

    public function agregar_items($idimportacion = null) {
        if (!$idimportacion) {
            redirect('/importaciones/listar/', 'refresh');
        }
        $data['title'] = 'Modificar Importación';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array(
            '/assets/modulos/importaciones/js/agregar_items.js'
        );
        $data['view'] = 'importaciones/agregar_items';




        $datos = array(
            'idimportacion' => $idimportacion
        );
        $data['importacion'] = $this->importaciones_model->get_where($datos);
        $data['importacion']['fecha_pedido'] = $this->formatear_fecha_para_mostrar($data['importacion']['fecha_pedido']);

        $data['proveedor'] = $this->proveedores_model->get_where(array('idproveedor' => $data['importacion']['idproveedor']));

        $data['monedas'] = $this->monedas_model->gets();

        $this->load->view('layout/app', $data);
    }

    public function agregar_item_ajax() {
        $this->form_validation->set_rules('idimportacion', 'ID Importación', 'required|integer');
        $this->form_validation->set_rules('idarticulo', 'Artículo', 'required|integer');
        $this->form_validation->set_rules('cantidad', 'Cantidad', 'required|integer');
        $this->form_validation->set_rules('costo_fob', 'Costo FOB', 'required');

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $datos = array(
                'idimportacion' => $this->input->post('idimportacion'),
                'idarticulo' => $this->input->post('idarticulo'),
                'cantidad' => $this->input->post('cantidad'),
                'cantidad_pendiente' => $this->input->post('cantidad'),
                'costo_fob' => $this->input->post('costo_fob')
            );
            $resultado = $this->importaciones_model->set_item($datos);
            if ($resultado) {
                $json = array(
                    'status' => 'ok',
                    'data' => 'Se agregó correctamente'
                );
                echo json_encode($json);
            } else {
                $json = array(
                    'status' => 'error',
                    'data' => 'No se pudo agregar el item'
                );
                echo json_encode($json);
            }
        }
    }

    public function gets_items_pedido_ajax() {
        $datos = array(
            'importaciones_items.idimportacion' => $this->input->post('idimportacion'),
            'importaciones_items.estado' => 'A',
            'importaciones_items.cantidad >' => 0
        );
        $data['items'] = $this->importaciones_model->gets_items($datos);

        $this->load->view('importaciones/gets_items_pedido_ajax', $data);
    }

    public function actualizar_cabecera_importacion_ajax() {
        $session = $this->session->all_userdata();

        $this->form_validation->set_rules('idimportacion', 'ID Importación', 'required|integer');
        $this->form_validation->set_rules('idproveedor', 'Proveedor', 'required|integer');
        $this->form_validation->set_rules('idmoneda', 'Moneda', 'required|integer');
        $this->form_validation->set_rules('fecha_pedido', 'Fecha de Pedido', 'required');

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $datos = array(
                'idproveedor' => $this->input->post('idproveedor'),
                'idmoneda' => $this->input->post('idmoneda'),
                'fecha_pedido' => $this->formatear_fecha($this->input->post('fecha_pedido')),
                'actualizado_por' => $session['SID']
            );
            $where = array(
                'idimportacion' => $this->input->post('idimportacion')
            );
            $resultado = $this->importaciones_model->update($datos, $where);
            if ($resultado) {
                $json = array(
                    'status' => 'ok',
                    'data' => 'Los datos se actualizaron correctamente'
                );
                echo json_encode($json);
            } else {
                $json = array(
                    'status' => 'error',
                    'data' => 'No se pudieron actualizar los datos'
                );
                echo json_encode($json);
            }
        }
    }

    public function listar($pagina = 0) {
        $data['title'] = 'Listado de Importaciones';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array();
        $data['view'] = 'importaciones/listar';


        $per_page = $this->parametros_model->get_valor_parametro_por_usuario('per_page', $data['session']['SID']);
        $per_page = $per_page['valor'];

        $where = $this->input->get();
        //$where['importaciones.estado'] = 'P';

        /*
         * inicio paginador
         */
        $total_rows = $this->importaciones_model->get_cantidad_where($where);
        $config['reuse_query_string'] = TRUE;
        $config['base_url'] = '/importaciones/listar/';
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

        $data['importaciones'] = $this->importaciones_model->gets_where_limit($where, $per_page, $pagina);
        foreach ($data['importaciones'] as $key => $value) {
            $data['importaciones'][$key]['cantidad_items'] = $this->importaciones_model->get_cantidad_items($value['idimportacion']);
        }

        $this->load->view('layout/app', $data);
    }
    
    public function listar_confirmaciones($pagina = 0) {
        $data['title'] = 'Listado de Importaciones Confirmadas';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['view'] = 'importaciones/listar_confirmaciones';
        
        $per_page = $this->parametros_model->get_valor_parametro_por_usuario('per_page', $data['session']['SID']);
        $per_page = $per_page['valor'];
        
        $where = $this->input->get();
        
        /*
         * inicio paginador
         */
        $total_rows = $this->importaciones_model->get_cantidad_confirmaciones_where($where);
        $config['reuse_query_string'] = TRUE;
        $config['base_url'] = '/importaciones/listar_confirmaciones/';
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
        $data['confirmaciones'] = $this->importaciones_model->gets_confirmaciones_where_limit($where, $per_page, $pagina);
        
        $this->load->view('layout/app', $data);
    }

    public function borrar_item() {
        $this->form_validation->set_rules('idimportacion_item', 'ID Item', 'required|integer');

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
                'idimportacion_item' => $this->input->post('idimportacion_item')
            );
            $resultado = $this->importaciones_model->update_item($datos, $where);

            if ($resultado) {
                $json = array(
                    'status' => 'ok',
                    'data' => 'Se eliminó correctamente'
                );
                echo json_encode($json);
            } else {
                $json = array(
                    'status' => 'error',
                    'data' => '<p>No se pudo eliminar el item.</p>'
                );
                echo json_encode($json);
            }
        }
    }

    public function modificar_item($idimportacion_item = null) {
        if (!$idimportacion_item) {
            redirect('/importaciones/listar/', 'refresh');
        }
        $data['title'] = 'Modificar Item de Pedido de Importación';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array();
        $data['view'] = 'importaciones/modificar_item';

        $this->form_validation->set_rules('idarticulo', 'Artículo', 'required|integer');
        $this->form_validation->set_rules('cantidad', 'Cantidad', 'required|integer');
        $this->form_validation->set_rules('costo_fob', 'Costo FOB', 'required|numeric');

        if ($this->form_validation->run() == FALSE) {
            
        } else {
            $datos = array(
                'idarticulo' => $this->input->post('idarticulo'),
                'cantidad' => $this->input->post('cantidad'),
                'cantidad_pendiente' => $this->input->post('cantidad'),
                'costo_fob' => $this->input->post('costo_fob')
            );

            $this->importaciones_model->update_item($datos, $idimportacion_item);
        }

        $datos = array(
            'idimportacion_item' => $idimportacion_item
        );
        $data['item'] = $this->importaciones_model->get_where_item($datos);

        $datos = array(
            'idarticulo' => $data['item']['idarticulo']
        );
        $data['articulo'] = $this->articulos_model->get_where($datos);

        $datos = array(
            'idmarca' => $data['articulo']['idmarca']
        );
        $data['articulo']['marca'] = $this->marcas_model->get_where($datos);

        $this->load->view('layout/app', $data);
    }

    public function confirmacion() {
        $data['title'] = 'Confirmar Pedido de Importación';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array(
            '/assets/modulos/importaciones/js/confirmacion.js'
        );
        $data['view'] = 'importaciones/confirmacion';


        $data['proveedores'] = $this->importaciones_model->gets_proveedores_con_items_pendientes();

        $this->load->view('layout/app', $data);
    }

    public function confirmacion_ajax() {
        $data['session'] = $this->session->all_userdata();

        $this->form_validation->set_rules('idproveedor', 'Proveedor', 'required|numeric');
        $this->form_validation->set_rules('fecha_confirmacion', 'Fecha de Confirmación', 'required');

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $datos = array(
                'idproveedor' => $this->input->post('idproveedor'),
                'fecha_confirmacion' => $this->formatear_fecha($this->input->post('fecha_confirmacion')),
                'fecha_creacion' => date("Y-m-d H:i:s"),
                'idcreador' => $data['session']['SID']
            );
            $id = $this->importaciones_model->set_importacion_confirmacion($datos);
            if ($id) {
                $json = array(
                    'status' => 'ok',
                    'data' => 'Se realizó la confirmación exitosamente',
                    'id' => $id
                );
                echo json_encode($json);
            } else {
                $json = array(
                    'status' => 'error',
                    'data' => 'No se pudo confirmar la importación'
                );
                echo json_encode($json);
            }
        }
    }

    public function confirmacion_items($idimportacion_confirmacion = null) {
        if ($idimportacion_confirmacion == null) {
            redirect('/importaciones/listar/', 'refresh');
        }
        $data['title'] = 'Confirmar Items de Pedidos';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array(
            '/assets/modulos/importaciones/js/confirmacion_items.js'
        );
        $data['view'] = 'importaciones/confirmacion_items';


        $datos = array(
            'idimportacion_confirmacion' => $idimportacion_confirmacion
        );
        $data['confirmacion'] = $this->importaciones_model->get_confirmacion_where($datos);

        $data['items_backorder'] = $this->importaciones_model->gets_items_backorder($data['confirmacion']['idproveedor']);

        $this->load->view('layout/app', $data);
    }

    public function confirmar_item_de_pedido_ajax() {
        $session = $this->session->all_userdata();

        $this->form_validation->set_rules('cantidad', 'Cantidad a confirmar', 'required|integer');
        $this->form_validation->set_rules('idimportacion_confirmacion', 'Identificador de Confirmación', 'required|integer');
        $this->form_validation->set_rules('idimportacion_item', 'Identificador del Item', 'required|integer');
        $this->form_validation->set_rules('fecha_confirmacion', 'Fecha Prometida', 'required');

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $flag = true;
            $datos = array(
                'idimportacion_item' => $this->input->post('idimportacion_item')
            );
            $item_pedido = $this->importaciones_model->get_where_item($datos);

            if ($this->input->post('cantidad') <= 0 && $flag) {
                $json = array(
                    'status' => 'error',
                    'data' => 'La cantidad a confirmar no puede ser un valor menor o igual a 0'
                );
                echo json_encode($json);
                $flag = false;
            }

            if ($this->input->post('cantidad') > $item_pedido['cantidad_pendiente'] && $flag) {
                $json = array(
                    'status' => 'error',
                    'data' => 'No se puede confirmar una cantidad superior a lo pendiente'
                );
                echo json_encode($json);
                $flag = false;
            }

            if ($flag) {
                $datos = array(
                    'idimportacion_confirmacion' => $this->input->post('idimportacion_confirmacion'),
                    'idimportacion_item' => $this->input->post('idimportacion_item'),
                    'cantidad' => $this->input->post('cantidad'),
                    'fecha_confirmacion' => $this->formatear_fecha($this->input->post('fecha_confirmacion')),
                    'idcreador' => $session['SID'],
                    'fecha_creacion' => date("Y-m-d H:i:s")
                );

                $idconfirmacion_item = $this->importaciones_model->set_confirmacion_item($datos);

                if ($idconfirmacion_item) {
                    $nueva_cantidad_pendiente = ($item_pedido['cantidad_pendiente'] - $this->input->post('cantidad'));

                    $datos = array(
                        'cantidad_pendiente' => $nueva_cantidad_pendiente
                    );
                    $where = array(
                        'idimportacion_item' => $this->input->post('idimportacion_item')
                    );
                    $rows_afectadas = $this->importaciones_model->update_item($datos, $where);

                    if ($rows_afectadas) {
                        $json = array(
                            'status' => 'ok'
                        );
                        echo json_encode($json);
                    } else {
                        $json = array(
                            'status' => 'error',
                            'data' => 'No se pudo actualizar la cantidad pendiente'
                        );
                        echo json_encode($json);
                    }
                } else {
                    $json = array(
                        'status' => 'error',
                        'data' => 'No se pudo confirmar el item'
                    );
                    echo json_encode($json);
                }
            }
        }
    }

    public function items_backorder_ajax() {
        $data['items_backorder'] = $this->importaciones_model->gets_items_backorder($this->input->post('idproveedor'));
        $this->load->view('importaciones/items_backorder_ajax', $data);
    }

    public function confirmacion_items_ajax() {
        $data['items'] = $this->importaciones_model->gets_items_confirmados($this->input->post('idimportacion_confirmacion'));

        foreach ($data['items'] as $key => $value) {
            $data['items'][$key]['fecha_confirmacion'] = $this->formatear_fecha_para_mostrar($value['fecha_confirmacion']);
        }

        $this->load->view('importaciones/confirmacion_items_ajax', $data);
    }

    public function borrar_item_confirmado_ajax() {
        $session = $this->session->all_userdata();

        $this->form_validation->set_rules('idimportacion_confirmacion_item', 'Identificador de Item', 'required|integer');

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $datos = array(
                'idimportacion_confirmacion_item' => $this->input->post('idimportacion_confirmacion_item')
            );
            $item_confirmado = $this->importaciones_model->get_where_item_confirmado($datos);

            $datos = array(
                'idimportacion_item' => $item_confirmado['idimportacion_item']
            );
            $item_pedido = $this->importaciones_model->get_where_item($datos);

            $nueva_cantidad_pendiente = ($item_pedido['cantidad_pendiente'] + $item_confirmado['cantidad']);

            $datos = array(
                'cantidad_pendiente' => $nueva_cantidad_pendiente
            );
            $filas_afectadas = $this->importaciones_model->update_item($datos, $item_pedido['idimportacion_item']);
            if ($filas_afectadas) {
                $datos = array(
                    'estado' => 'I',
                    'actualizado_por' => $session['SID'],
                    'fecha_modificacion' => date("Y-m-d H:i:s")
                );
                $filas_afectadas = $this->importaciones_model->update_item_confirmado($datos, $item_confirmado['idimportacion_confirmacion_item']);
                if ($filas_afectadas) {
                    $json = array(
                        'status' => 'ok'
                    );
                    echo json_encode($json);
                } else {
                    $json = array(
                        'status' => 'error',
                        'data' => 'No se pudo actualizar el item en la confirmación'
                    );
                    echo json_encode($json);
                }
            } else {
                $json = array(
                    'status' => 'error',
                    'data' => 'No se pudo actualizar el item en el pedido'
                );
                echo json_encode($json);
            }
        }
    }
    
    public function pedido_pdf($idimportacion = null) {
        if($idimportacion == null) {
            redirect('/importaciones/listar/', 'refresh');
        }
        
        $where = array(
            'idimportacion' => $idimportacion,
            'importaciones_estado' => 'P'
        );
        $data['importacion'] = $this->importaciones_model->get_where($where);
       
        $where = array(
            'idproveedor' => $data['importacion']['idproveedor']
        );
        $data['proveedor'] = $this->proveedores_model->get_where($where);
        
        $where = array(
            'idmoneda' => $data['importacion']['idmoneda']
        );
        $data['moneda'] = $this->monedas_model->get_where($where);
        
        $datos = array(
            'importaciones_items.idimportacion' => $idimportacion,
            'importaciones_items.estado' => 'A'
        );
        $data['items'] = $this->importaciones_model->gets_items($datos);
        
        // create new PDF document
        $pdf = new Tcpdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('ROLLER SERVICE S.A.');
        $pdf->SetTitle('Pedido ' . str_pad($data['importacion']['idimportacion'], 8, '0', STR_PAD_LEFT));
        //$pdf->SetSubject('TCPDF Tutorial');
        //$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
        // set default header data
        $pdf->SetHeaderData('', '150', '', '');

        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));


        //$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);


        $pdf->AddPage();

        $html = $this->load->view('importaciones/pedido_pdf', $data);

        // output the HTML content
        $pdf->writeHTML($html->output->final_output, true, false, true, false, '');

        //$pdf->setFooterData(array(0, 64, 0), array(0, 64, 128));


        $pdf->Output('Pedido ' . str_pad($data['importacion']['idimportacion'], 8, '0', STR_PAD_LEFT) . '.pdf', 'I');
        
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
