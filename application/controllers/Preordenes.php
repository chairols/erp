<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Preordenes extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array(
            'session',
            'r_session',
            'form_validation',
            'pagination'
        ));
        $this->load->model(array(
            'preordenes_model',
            'listas_de_precios_model',
            'parametros_model',
            'proveedores_model',
            'importaciones_model',
            'monedas_model',
            'articulos_model'
        ));

        $session = $this->session->all_userdata();
        $this->r_session->check($session);
    }

    public function agregar_modificar_item_ajax() {
        $session = $this->session->all_userdata();

        $this->form_validation->set_rules('cantidad', 'Cantidad', 'required|integer');
        $this->form_validation->set_rules('idlista_de_precios_comparacion_item', 'ID del Item', 'required|integer');

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $where = array(
                'idlista_de_precios_comparacion_item' => $this->input->post('idlista_de_precios_comparacion_item')
            );
            $item = $this->preordenes_model->get_where($where);

            if ($item) {
                $datos = array(
                    'cantidad' => $this->input->post('cantidad'),
                    'estado' => 'A',
                    'modificado_por' => $session['SID']
                );
                $where = array(
                    'idpre_orden' => $item['idpre_orden']
                );

                if ($this->input->post('cantidad') == 0) {
                    $datos['estado'] = 'I';
                }

                $resultado = $this->preordenes_model->update($datos, $where);

                if ($resultado) {
                    $json = array(
                        'status' => 'ok',
                        'data' => 'Se actualizó correctamente el item ' . $item['articulo']
                    );
                    echo json_encode($json);
                } else {
                    $json = array(
                        'status' => 'error',
                        'data' => 'No se pudo actualizar el item ' . $item['articulo']
                    );
                    echo json_encode($json);
                }
            } else {
                $where = array(
                    'idlista_de_precios_comparacion_item' => $this->input->post('idlista_de_precios_comparacion_item')
                );
                $item_comparacion = $this->listas_de_precios_model->get_where_comparacion_item($where);

                $where = array(
                    'idlista_de_precios_item' => $item_comparacion['idlista_de_precios_item']
                );
                $item_lista = $this->listas_de_precios_model->get_where_item($where);

                $where = array(
                    'idlista_de_precios' => $item_lista['idlista_de_precios']
                );
                $lista = $this->listas_de_precios_model->get_where($where);

                $set = array(
                    'idproveedor' => $lista['idproveedor'],
                    'proveedor' => $lista['proveedor'],
                    'idmoneda' => $lista['idmoneda'],
                    'cantidad' => $this->input->post('cantidad'),
                    'articulo' => $item_lista['articulo'],
                    'precio' => $item_lista['precio'],
                    'idmarca' => $item_lista['idmarca'],
                    'marca' => $item_lista['marca'],
                    'idlista_de_precios_comparacion_item' => $item_comparacion['idlista_de_precios_comparacion_item'],
                    'idlista_de_precios_comparacion' => $item_comparacion['idlista_de_precios_comparacion'],
                    'idlista_de_precios_item' => $item_lista['idlista_de_precios_item'],
                    'idarticulo_generico' => $item_lista['idarticulo_generico'],
                    'idcreador' => $session['SID'],
                    'fecha_creacion' => date("Y-m-d H:i:s"),
                    'modificado_por' => $session['SID']
                );

                $id = $this->preordenes_model->set($set);

                if ($id) {  // Si se creó
                    $json = array(
                        'status' => 'ok',
                        'data' => 'Se agregó el item ' . $item_lista['articulo']
                    );
                    echo json_encode($json);
                } else {  // Si no se pudo crear
                    $json = array(
                        'status' => 'error',
                        'data' => 'Ocurrió un error inesperado, no se pudo agregar'
                    );
                    echo json_encode($json);
                }
            }
        }
    }

    public function listar($pagina = 0) {
        $data['title'] = 'Listado de Preórdenes';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['view'] = 'preordenes/listar';


        $per_page = $this->parametros_model->get_valor_parametro_por_usuario('per_page', $data['session']['SID']);
        $per_page = $per_page['valor'];

        $where = $this->input->get();
        $where['pre_ordenes.estado'] = 'A';

        /*
         * inicio paginador
         */
        $total_rows = $this->preordenes_model->get_cantidad_where($where);
        $config['reuse_query_string'] = TRUE;
        $config['base_url'] = '/retenciones/listar/';
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

        $data['preordenes'] = $this->preordenes_model->gets_where_limit($where, $per_page, $pagina);
        foreach($data['preordenes'] as $key => $value) {
            $where = array(
                'idmoneda' => $value['idmoneda']
            );
            $data['preordenes'][$key]['moneda'] = $this->monedas_model->get_where($where);
        }

        $this->load->view('layout/app', $data);
    }

    public function modificar($idproveedor = null, $idmoneda = null) {
        $data['title'] = 'Modificar Preorden';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array(
            '/assets/modulos/preordenes/js/modificar.js'
        );
        $data['view'] = 'preordenes/modificar';

        if ($idproveedor == null || $idmoneda == null) {
            redirect('/preordenes/listar/', 'refresh');
        }

        $where = array(
            'idproveedor' => $idproveedor,
            'idmoneda' => $idmoneda,
            'estado' => 'A'
        );
        $data['preorden'] = $this->preordenes_model->gets_where($where);
        
        $data['total'] = $this->preordenes_model->get_total($where);
        
        foreach($data['preorden'] as $key => $value) {
            $where = array(
                'idlista_de_precios_item' => $value['idlista_de_precios_item']
            );
            $item = $this->listas_de_precios_model->get_where_item($where);
            $data['preorden'][$key]['stock'] = $item['stock'];
        }


        $data['idproveedor'] = $idproveedor;
        $data['idmoneda'] = $idmoneda;

        $this->load->view('layout/app', $data);
    }

    public function modificar_cantidad_ajax() {
        $session = $this->session->all_userdata();

        $this->form_validation->set_rules('idpreorden', 'ID Preorden', 'required|integer');
        $this->form_validation->set_rules('cantidad', 'Cantidad', 'required|integer');

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $datos = array(
                'cantidad' => $this->input->post('cantidad')
            );
            $where = array(
                'idpre_orden' => $this->input->post('idpreorden')
            );
            $resultado = $this->preordenes_model->update($datos, $where);

            if ($resultado) {
                $where = array(
                    'idpre_orden' => $this->input->post('idpreorden')
                );
                $item = $this->preordenes_model->get_where($where); // Obtengo el total del item

                $where = array(
                    'idproveedor' => $item['idproveedor'],
                    'estado' => 'A'
                );
                $total = $this->preordenes_model->get_total($where);

                $json = array(
                    'status' => 'ok',
                    'subtotal' => number_format($item['cantidad'] * $item['precio'], 2),
                    'total' => number_format($total['total'], 2),
                    'data' => 'Se actualizó correctamente la cantidad'
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

    public function generar_orden_ajax() {
        $session = $this->session->all_userdata();
        
        $this->form_validation->set_rules('idproveedor', 'Proveedor', 'required|integer');
        $this->form_validation->set_rules('idmoneda', 'Moneda', 'required|integer');

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $where = array(
                'idproveedor' => $this->input->post('idproveedor')
            );
            $proveedor = $this->proveedores_model->get_where($where);

            $where = array(
                'idproveedor' => $proveedor['idproveedor'],
                'idmoneda' => $this->input->post('idmoneda'),
                'estado' => 'A',
                'cantidad >=' => 0
            );
            $preorden = $this->preordenes_model->gets_where($where);

            if (count($preorden)) {  //  Si existen items
                $set = array(
                    'idproveedor' => $proveedor['idproveedor'],
                    'idmoneda' => $preorden[0]['idmoneda'],
                    'fecha_pedido' => date("Y-m-d"),
                    'fecha_creacion' => date("Y-m-d H:i:s"),
                    'idcreador' => $session['SID'],
                    'actualizado_por' => $session['SID']
                );
                
                $idimportacion = $this->importaciones_model->set($set);  // Creo el pedido de importación
                
                foreach ($preorden as $item) {  // Recorro los items para agregar a la orden y borrar de la preorden
                    $where = array(
                        'idarticulo_generico' => $item['idarticulo_generico'],
                        'idmarca' => $item['idmarca'],
                        'estado' => 'A'
                    );
                    $articulo = $this->articulos_model->get_where($where);  // Busco a que artículo asociar
                    
                    $item = array(
                        'idimportacion' => $idimportacion,
                        'articulo' => $item['articulo'],
                        'cantidad' => $item['cantidad'],
                        'cantidad_pendiente' => $item['cantidad'],
                        'precio' => $item['precio'],
                        'idmarca' => $item['idmarca'],
                        'marca' => $item['marca'],
                        'idpre_orden' => $item['idpre_orden'],
                        'idcreador' => $session['SID'],
                        'fecha_creacion' => date("Y-m-d H:i:s"),
                        'modificado_por' => $session['SID']
                    );
                    if($articulo) {
                        $item['idarticulo'] = $articulo['idarticulo'];
                    }
                    
                    $iditem = $this->importaciones_model->set_item($item);  // Agrego artículo a la orden
                    
                    $datos = array(
                        'estado' => 'I'
                    );
                    $where = array(
                        'idpre_orden' => $item['idpre_orden']
                    );
                    $this->preordenes_model->update($datos, $where); // Borrado lógico de item
                } 
                $json = array(
                    'status' => 'ok',
                    'data' => 'Se generó el pedido de Importación N° '.$idimportacion,
                    'id' => $idimportacion
                );
                echo json_encode($json);
            } else {  // No hay items para el proveedor
                $json = array(
                    'status' => 'error',
                    'data' => 'No se pudo generar una orden sin items'
                );
                echo json_encode($json);
            }
        }
    }

}

?>