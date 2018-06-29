<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Importaciones extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array(
            'session',
            'r_session',
            'form_validation',
            'pagination'
        ));
        $this->load->model(array(
            'importaciones_model',
            'log_model',
            'empresas_model',
            'parametros_model',
            'monedas_model',
            'articulos_model',
            'marcas_model'
        ));

        $session = $this->session->all_userdata();
        $this->r_session->check($session);
    }

    public function agregar() {
        $data['title'] = 'Agregar Importación';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array();
        $data['view'] = 'importaciones/agregar';

        $this->form_validation->set_rules('empresa', 'Empresa', 'required');
        $this->form_validation->set_rules('moneda', 'Moneda', 'required|integer');
        $this->form_validation->set_rules('fecha_pedido', 'Fecha de Pedido', 'required');

        if ($this->form_validation->run() == FALSE) {
            
        } else {
            $datos = array(
                'idproveedor' => $this->input->post('empresa'),
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

        $this->form_validation->set_rules('empresa', 'Empresa', 'required|integer');
        $this->form_validation->set_rules('moneda', 'Moneda', 'required|integer');
        $this->form_validation->set_rules('fecha_pedido', 'Fecha de Pedido', 'required');
        $this->form_validation->set_rules('idarticulo', 'Artículo', 'required|integer');
        $this->form_validation->set_rules('cantidad', 'Cantidad', 'required|integer');
        $this->form_validation->set_rules('costo_fob', 'Costo FOB', 'required');

        if ($this->form_validation->run() == FALSE) {
            
        } else {
            $datos = array(
                'idproveedor' => $this->input->post('empresa'),
                'idmoneda' => $this->input->post('moneda'),
                'fecha_pedido' => $this->formatear_fecha($this->input->post('fecha_pedido')),
                'actualizado_por' => $data['session']['SID']
            );
            $this->importaciones_model->update($datos, $idimportacion);

            $datos = array(
                'idimportacion' => $idimportacion,
                'idarticulo' => $this->input->post('idarticulo'),
                'cantidad' => $this->input->post('cantidad'),
                'cantidad_pendiente' => $this->input->post('cantidad'),
                'costo_fob' => $this->input->post('costo_fob')
            );
            $this->importaciones_model->set_item($datos);
        }

        $datos = array(
            'idimportacion' => $idimportacion
        );
        $data['importacion'] = $this->importaciones_model->get_where($datos);
        $data['importacion']['fecha_pedido'] = $this->formatear_fecha_para_mostrar($data['importacion']['fecha_pedido']);

        $data['proveedor'] = $this->empresas_model->get_where(array('idempresa' => $data['importacion']['idproveedor']));

        $datos = array(
            'importaciones_items.idimportacion' => $idimportacion,
            'importaciones_items.estado' => 'A'
        );
        $data['items'] = $this->importaciones_model->gets_items($datos);

        $data['monedas'] = $this->monedas_model->gets();

        $this->load->view('layout/app', $data);
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

    public function borrar_item($idimportacion_item) {
        $datos = array(
            'estado' => 'I'
        );
        $resultado = $this->importaciones_model->update_item($datos, $idimportacion_item);
        if ($resultado) {
            $json = array(
                'status' => 'ok'
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
        
        if($this->form_validation->run() == FALSE) {
            
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
