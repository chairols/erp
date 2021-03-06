<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Articulos extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array(
            'session',
            'r_session',
            'pagination',
            'form_validation'
        ));
        $this->load->model(array(
            'parametros_model',
            'articulos_model',
            'marcas_model',
            'lineas_model',
            'log_model'
        ));
        $session = $this->session->all_userdata();
        $this->r_session->check($session);
    }

    public function listar($pagina = 0) {
        $data['title'] = 'Listado de Artículos';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array(
            '/assets/modulos/articulos/js/listar.js'
        );

        $per_page = $this->parametros_model->get_valor_parametro_por_usuario('per_page', $data['session']['SID']);
        $per_page = $per_page['valor'];
        $data['per_page'] = $per_page;

        $where = array();
        $like = array();
        $where['articulos.estado'] = 'A';
        if ($this->input->get('articulo')) {
            $like['articulos.articulo'] = $this->input->get('articulo');
        }
        if ($this->input->get('numero_orden')) {
            $where['articulos.numero_orden'] = $this->input->get('numero_orden');
        }
        if ($this->input->get('idmarca')) {
            $where['articulos.idmarca'] = $this->input->get('idmarca');
        }
        if (strlen($this->input->get('idlinea'))) {
            $where['articulos.idlinea'] = $this->input->get('idlinea');
        }
        if (strlen($this->input->get('stock'))) {
            if ($this->input->get('stock') == 'S') {
                $where['articulos.stock >'] = 0;
            } else if ($this->input->get('stock') == 'N') {
                $where['articulos.stock'] = 0;
            }
        }
        if (strlen($this->input->get('precio'))) {
            if ($this->input->get('precio') == 'S') {
                $where['articulos.precio >'] = 0;
            } else if ($this->input->get('precio') == "N") {
                $where['articulos.precio'] = 0;
            }
        }

        /*
         * inicio paginador
         */
        $total_rows = $this->articulos_model->get_cantidad_where($where, $like);
        $config['reuse_query_string'] = TRUE;
        $config['base_url'] = '/articulos/listar/';
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
        $data['base_url'] = $config['base_url'];
        /*
         * fin paginador
         */

        $data['articulos'] = $this->articulos_model->gets_where_limit($where, $like, $per_page, $pagina);
        $where = array(
            'estado' => 'A'
        );
        $data['lineas'] = $this->lineas_model->gets_where($where);
        $data['marcas'] = $this->marcas_model->gets_where($where);

        $data['view'] = 'articulos/listar';
        $this->load->view('layout/app', $data);
    }

    public function gets_articulos_ajax() {
        $where = $this->input->post();
        $articulos = $this->articulos_model->gets_where_para_ajax($where, 255);

        foreach ($articulos as $key => $value) {
            $articulos[$key]['text'] = $value['text'] . " - ";
            $where = array(
                'idmarca' => $value['idmarca']
            );
            $resultado = $this->marcas_model->get_where($where);

            $articulos[$key]['text'] .= $resultado['marca'];
        }
        echo json_encode($articulos);
    }

    public function borrar_ajax() {
        $where = $this->input->post();
        $this->articulos_model->update(array('estado' => 'I'), $where['idarticulo']);
    }

    public function activar_ajax() {
        $where = $this->input->post();
        $this->articulos_model->update(array('estado' => 'A'), $where['idarticulo']);
    }

    public function agregar_ajax() {
        $session = $this->session->all_userdata();

        $this->form_validation->set_rules('articulo', 'Artículo', 'required');
        $this->form_validation->set_rules('idmarca', 'Marca', 'required|integer');
        $this->form_validation->set_rules('numero_orden', 'Número de Orden', 'required|integer');
        $this->form_validation->set_rules('idlinea', 'Línea', 'required|integer');

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            /*
             * Busco si existe el articulo
             */
            $where = array(
                'articulo' => $this->input->post('articulo'),
                'idmarca' => $this->input->post('idmarca')
            );
            $articulo = $this->articulos_model->get_where($where);

            if ($articulo) { // Si existe
                if ($articulo['estado'] == 'A') { // Si existe y está activo
                    $json = array(
                        'status' => 'error',
                        'data' => 'El artículo ' . $articulo['articulo'] . ' ya existe'
                    );
                    echo json_encode($json);
                } elseif ($articulo['estado'] == 'I') {  // Si existe y está inactivo
                    $datos = array(
                        'estado' => 'A'
                    );
                    $where = array(
                        'idarticulo' => $articulo['idarticulo']
                    );

                    $resultado = $this->articulos_model->update($datos, $where);
                    if ($resultado) {
                        $json = array(
                            'status' => 'ok',
                            'data' => 'El artículo ' . $articulo['articulo'] . ' se volvió a activar'
                        );
                        echo json_encode($json);
                    } else {
                        $json = array(
                            'status' => 'error',
                            'data' => 'No se pudo volver al estado activo al artículo ' . $articulo['articulo']
                        );
                        echo json_encode($json);
                    }
                }
            } else { // Si no existe el artículo
                $datos = array(
                    'articulo' => $this->input->post('articulo'),
                    'idmarca' => $this->input->post('idmarca'),
                    'numero_orden' => $this->input->post('numero_orden'),
                    'idlinea' => $this->input->post('idlinea'),
                    'fecha_creacion' => date("Y-m-d H:i:s"),
                    'idcreador' => $session['SID'],
                    'actualizado_por' => $session['SID']
                );

                $id = $this->articulos_model->set($datos);

                if ($id) {
                    $where = array(
                        'idmarca' => $this->input->post('idmarca')
                    );
                    $marca = $this->marcas_model->get_where($where);

                    $where = array(
                        'idlinea' => $this->input->post('idlinea')
                    );
                    $linea = $this->lineas_model->get_where($where);

                    $log = array(
                        'tabla' => 'articulos',
                        'idtabla' => $id,
                        'texto' => "<h2><strong>Se creó el artículo: " . $this->input->post('articulo') . "</strong></h2>
                    <p><strong>ID Artículo: </strong>" . $id . "<br />
                    <strong>Marca: </strong>" . $marca['marca'] . "<br />
                    <strong>Número de Orden: </strong>" . $this->input->post('numero_orden') . "<br />
                    <strong>Línea: </strong>" . $linea['linea'],
                        'idusuario' => $session['SID'],
                        'tipo' => 'add'
                    );
                    $this->log_model->set($log);

                    $json = array(
                        'status' => 'ok',
                        'data' => 'El creó el artículo ' . $this->input->post('articulo')
                    );
                    echo json_encode($json);
                }
            }
        }
    }

    public function get_where_json() {
        $where = $this->input->post();
        $articulo = $this->articulos_model->get_where($where);

        if ($articulo) {
            $where = array(
                'idmarca' => $articulo['idmarca']
            );
            $articulo['marca'] = $this->marcas_model->get_where($where);

            $where = array(
                'idlinea' => $articulo['idlinea']
            );
            $articulo['linea'] = $this->lineas_model->get_where($where);
        } else {
            $articulo = array();
        }

        echo json_encode($articulo);
    }

    public function gets_articulos_ajax_stock_y_precio() {
        $like = $this->input->post();
        $where['stock >'] = 0;

        $articulos = $this->articulos_model->gets_where_para_ajax_con_stock_y_precio($like, $where, 255);

        $where = array();
        $where['stock <='] = 0;
        $articulos_sin_stock = $this->articulos_model->gets_where_para_ajax_con_stock_y_precio($like, $where, 255);

        foreach ($articulos_sin_stock as $key => $value) {
            $articulos[] = $value;
        }

        foreach ($articulos as $key => $value) {
            $articulos[$key]['text'] = $value['text'] . " - ";
            $where = array(
                'idmarca' => $value['idmarca']
            );
            $resultado = $this->marcas_model->get_where($where);

            $articulos[$key]['text'] .= "<b>" . $resultado['marca'] . "</b>";
            $articulos[$key]['text'] .= " - " . $value['stock'];
            $articulos[$key]['text'] .= ' - <b>U$S ' . $value['precio'] . "</b>";
        }


        echo json_encode($articulos);
    }

    public function modificar($idarticulo = null) {
        if ($idarticulo == null) {
            redirect('/articulos/listar/', 'refresh');
        }
        $data['title'] = 'Modificar Artículo';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array(
            '/assets/modulos/articulos/js/modificar.js'
        );

        $where = array(
            'idarticulo' => $idarticulo
        );
        $data['articulo'] = $this->articulos_model->get_where($where);

        $where = array(
            'idmarca' => $data['articulo']['idmarca']
        );
        $data['articulo']['marca'] = $this->marcas_model->get_where($where);

        $where = array(
            'estado' => 'A'
        );
        $data['lineas'] = $this->lineas_model->gets_where($where);

        $data['view'] = 'articulos/modificar';
        $this->load->view('layout/app', $data);
    }

    public function modificar_ajax() {
        $session = $this->session->all_userdata();

        $this->form_validation->set_rules('idarticulo', 'ID de Artículo', 'required|integer');
        $this->form_validation->set_rules('numero_orden', 'Número de Orden', 'required|integer');
        $this->form_validation->set_rules('idlinea', 'Línea', 'required|integer');
        // Despacho no es obligatorio
        $this->form_validation->set_rules('precio', 'Precio de Venta', 'required|decimal');
        $this->form_validation->set_rules('stock', 'Stock', 'required|integer');
        $this->form_validation->set_rules('stock_min', 'Stock Mínimo', 'required|integer');
        $this->form_validation->set_rules('stock_max', 'Stock Máximo', 'required|integer');
        $this->form_validation->set_rules('costo_fob', 'Costo FOB', 'required|decimal');
        $this->form_validation->set_rules('costo_despachado', 'Costo Despachado', 'required|decimal');
        // Estantería no es obligatorio
        // Observaciones no es obligatorio

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $datos = array(
                'numero_orden' => $this->input->post('numero_orden'),
                'idlinea' => $this->input->post('idlinea'),
                'despacho' => $this->input->post('despacho'),
                'precio' => $this->input->post('precio'),
                'stock' => $this->input->post('stock'),
                'stock_min' => $this->input->post('stock_min'),
                'stock_max' => $this->input->post('stock_max'),
                'costo_fob' => $this->input->post('costo_fob'),
                'costo_despachado' => $this->input->post('costo_despachado'),
                'rack' => $this->input->post('rack'),
                'observaciones' => $this->input->post('observaciones')
            );
            $where = array(
                'idarticulo' => $this->input->post('idarticulo')
            );
            $resultado = $this->articulos_model->update($datos, $where);

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

    public function agregar() {
        $data['title'] = 'Agregar Artículo';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array(
            '/assets/modulos/articulos/js/agregar.js'
        );

        $where = array(
            'estado' => 'A'
        );
        $data['marcas'] = $this->marcas_model->gets();
        $data['lineas'] = $this->lineas_model->gets_where($where);

        $data['view'] = 'articulos/agregar';
        $this->load->view('layout/app', $data);
    }

    public function agregar_full_ajax() {
        $session = $this->session->all_userdata();

        $this->form_validation->set_rules('articulo', 'Artículo', 'required');
        $this->form_validation->set_rules('idmarca', 'Marca', 'required');
        $this->form_validation->set_rules('numero_orden', 'Número de Orden', 'required|integer');
        $this->form_validation->set_rules('idlinea', 'Línea', 'required|integer');
        // Despacho no es obligatorio
        $this->form_validation->set_rules('precio', 'Precio de Venta', 'decimal');
        $this->form_validation->set_rules('stock', 'Stock', 'integer');
        $this->form_validation->set_rules('stock_min', 'Stock Mínimo', 'integer');
        $this->form_validation->set_rules('stock_max', 'Stock Máximo', 'integer');
        $this->form_validation->set_rules('costo_fob', 'Costo FOB', 'decimal');
        $this->form_validation->set_rules('costo_despachado', 'Costo Despachado', 'decimal');
        // Estantería no es obligatorio
        // Observaciones no es obligatorio

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $where = array(
                'articulo' => $this->input->post('articulo'),
                'idmarca' => $this->input->post('idmarca')
            );
            $articulo = $this->articulos_model->get_where($where);
            if ($articulo) { // Si el artículo existe
                $json = array(
                    'status' => 'error',
                    'data' => 'El artículo ' . $this->input->post('articulo') . ' ya existe'
                );
                echo json_encode($json);
            } else {  // Si el artículo no existe
                $datos = array(
                    'articulo' => $this->input->post('articulo'),
                    'idmarca' => $this->input->post('idmarca'),
                    'numero_orden' => $this->input->post('numero_orden'),
                    'idlinea' => $this->input->post('idlinea'),
                    'despacho' => $this->input->post('despacho'),
                    'precio' => $this->input->post('precio'),
                    'stock' => $this->input->post('stock'),
                    'stock_min' => $this->input->post('stock_min'),
                    'stock_max' => $this->input->post('stock_max'),
                    'costo_fob' => $this->input->post('costo_fob'),
                    'costo_despachado' => $this->input->post('costo_despachado'),
                    'rack' => $this->input->post('rack'),
                    'observaciones' => $this->input->post('observaciones')
                );
                $id = $this->articulos_model->set($datos);
                if ($id) { // Si se agregó
                    $where = array(
                        'idmarca' => $this->input->post('idmarca')
                    );
                    $marca = $this->marcas_model->get_where($where);

                    $where = array(
                        'idlinea' => $this->input->post('idlinea')
                    );
                    $linea = $this->lineas_model->get_where($where);

                    $log = array(
                        'tabla' => 'articulos',
                        'idtabla' => $id,
                        'texto' => "<h2><strong>Se agregó el artículo: " . $this->input->post('articulo') . "</strong></h2>
                    <p><strong>ID Artículo: </strong>" . $id . "<br />
                    <strong>ID Marca: </strong>" . $this->input->post('idmarca') . "<br />
                    <strong>Marca: </strong>" . $marca['marca'] . "<br />
                    <strong>Número de Orden: </strong>" . $this->input->post('numero_orden') . "<br />
                    <strong>ID Línea: </strong>" . $this->input->post('idlinea') . "<br />
                    <strong>Línea: </strong>" . $linea['linea'] . "<br />
                    <strong>Despacho de Aduana: </strong>" . $this->input->post('despacho') . "<br />
                    <strong>Precio de Venta: </strong>" . $this->input->post('precio') . "<br />
                    <strong>Stock: </strong>" . $this->input->post('stock') . "<br />
                    <strong>Stock Mínimo: </strong>" . $this->input->post('stock_min') . "<br />
                    <strong>Stock Máximo: </strong>" . $this->input->post('stock_max') . "<br />
                    <strong>Costo FOB: </strong>" . $this->input->post('costo_fob') . "<br />
                    <strong>Costo Despachado: </strong>" . $this->input->post('costo_despachado') . "<br />
                    <strong>Estantería: </strong>" . $this->input->post('rack') . "<br />
                    <strong>Observaciones: </strong>" . $this->input->post('observaciones') . "</p>",
                        'idusuario' => $session['SID'],
                        'tipo' => 'add'
                    );

                    $this->log_model->set($log);

                    $json = array(
                        'status' => 'ok',
                        'data' => 'El artículo ' . $this->input->post('articulo') . ' se creó correctamente'
                    );
                    echo json_encode($json);
                } else { // Si no se pudo agregar
                    $json = array(
                        'status' => 'error',
                        'data' => 'No se pudo crear el artículo'
                    );
                    echo json_encode($json);
                }
            }
        }
    }

    public function borrar_articulo_ajax() {
        $session = $this->session->all_userdata();

        $this->form_validation->set_rules('idarticulo', 'ID Artículo', 'required|integer');

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
                'idarticulo' => $this->input->post('idarticulo')
            );
            $resultado = $this->articulos_model->update($datos, $where);
            if ($resultado) {
                $where = array(
                    'idarticulo' => $this->input->post('idarticulo'),
                    'estado' => 'I'
                );
                $articulo = $this->articulos_model->get_where($where);
                
                $where = array(
                    'idmarca' => $articulo['idmarca']
                );
                $marca = $this->marcas_model->get_where($where);
                
                $log = array(
                    'tabla' => 'articulos',
                    'idtabla' => $this->input->post('idarticulo'),
                    'texto' => "<h2><strong>Se eliminó el artículo: " . $articulo['articulo'] . "</strong></h2>
                    <p><strong>ID Artículo: </strong>" . $this->input->post('idarticulo') . "<br />
                    <strong>ID Marca: </strong>" . $marca['idmarca'] . "<br />
                    <strong>Marca: </strong>" . $marca['marca'] . "</p>",
                    'idusuario' => $session['SID'],
                    'tipo' => 'add'
                );

                $this->log_model->set($log);

                $json = array(
                    'status' => 'ok',
                    'data' => 'Se borró correctamente'
                );
                echo json_encode($json);
            } else {
                $json = array(
                    'status' => 'error',
                    'data' => 'No se pudo borrar la retención.'
                );
                echo json_encode($json);
            }
        }
    }
    
    public function reporte() {
        $data['title'] = 'Reporte de Artículos';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array(
            '/assets/modulos/articulos/js/reporte.js'
        );
        
        $where = array(
            'estado' => 'A'
        );
        $data['lineas'] = $this->lineas_model->gets_where($where);
        $data['marcas'] = $this->marcas_model->gets_where($where);
        
        $data['view'] = 'articulos/reporte';
        $this->load->view('layout/app', $data);
    }
    
    public function reporte_ajax() {
        $where = array();
        $like = array();
        $where['articulos.estado'] = 'A';
        if ($this->input->get('articulo')) {
            $like['articulos.articulo'] = $this->input->get('articulo');
        }
        if ($this->input->get('numero_orden')) {
            $where['articulos.numero_orden'] = $this->input->get('numero_orden');
        }
        if ($this->input->get('idmarca')) {
            $where['articulos.idmarca'] = $this->input->get('idmarca');
        }
        if (strlen($this->input->get('idlinea'))) {
            $where['articulos.idlinea'] = $this->input->get('idlinea');
        }
        if (strlen($this->input->get('stock'))) {
            if ($this->input->get('stock') == 'S') {
                $where['articulos.stock >'] = 0;
            } else if ($this->input->get('stock') == 'N') {
                $where['articulos.stock'] = 0;
            }
        }
        if (strlen($this->input->get('precio'))) {
            if ($this->input->get('precio') == 'S') {
                $where['articulos.precio >'] = 0;
            } else if ($this->input->get('precio') == "N") {
                $where['articulos.precio'] = 0;
            }
        }
        
        $data['articulos'] = $this->articulos_model->gets_where_like($where, $like);
        
        $this->load->view('articulos/reporte_ajax', $data);
        /*echo "<pre>";
        print_r($data);
        echo "</pre>";*/
    }
}

?>
