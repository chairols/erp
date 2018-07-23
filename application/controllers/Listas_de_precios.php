<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Listas_de_precios extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array(
            'session',
            'r_session',
            'form_validation',
            'pagination',
            'Excel_reader/excel_reader'
        ));
        $this->load->model(array(
            'monedas_model',
            'listas_de_precios_model',
            'marcas_model',
            'empresas_model',
            'parametros_model'
        ));

        $session = $this->session->all_userdata();
        $this->r_session->check($session);
    }

    public function importar() {
        $data['title'] = 'Importar Lista de Precios';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();

        $this->form_validation->set_rules('empresa', 'Empresa', 'required|integer');
        $this->form_validation->set_rules('fecha', 'Fecha', 'required');
        $this->form_validation->set_rules('moneda', 'Moneda', 'required|integer');

        if ($this->form_validation->run() == FALSE) {
            
        } else {
            $config['upload_path'] = "./upload/listas_de_precios/";
            $config['allowed_types'] = '*';
            $config['remove_spaces'] = true;

            $this->load->library('upload', $config);
            $adjunto = null;

            if (!$this->upload->do_upload('archivo')) {
                $error = array('error' => $this->upload->display_errors());
            } else {
                $adjunto = array('upload_data' => $this->upload->data());
            }
            
            $data['adjunto'] = $adjunto;
            
            $datos = array();
            if ($adjunto != null) {
                $this->excel_reader->read('./upload/listas_de_precios/'.$adjunto['upload_data']['file_name']);
                
                $excel = $this->excel_reader->sheets[0];
                
                $datos = array(
                    'idempresa' => $this->input->post('empresa'),
                    'idmoneda' => $this->input->post('moneda'),
                    'fecha' => $this->formatear_fecha($this->input->post('fecha')),
                    'archivo' => '/upload/listas_de_precios/' . $adjunto['upload_data']['file_name'],
                    'nombre_archivo' => $adjunto['upload_data']['orig_name'],
                    'comentarios' => $this->input->post('comentarios'),
                    'idcreador' => $data['session']['SID']
                );
                
                $idlista_de_precio = $this->listas_de_precios_model->set($datos);
                
                foreach($excel['cells'] as $fila) {
                    if($fila['1'] != 'Codigo' && $fila[2] != 'Precio') {
                        $d = array(
                            'idlista_de_precios' => $idlista_de_precio,
                            'idmarca' => $this->input->post('marca'),
                            'articulo' => $fila[1],
                            'precio' => $fila[2],
                            //'stock' => $fila[3],  Ver debajo
                            //'marca' => $fila[4],
                            'fecha_creacion' => date("Y-m-d H:i:s"),
                            'idcreador' => $data['session']['SID']
                        );
                        
                        if(!isset($fila[3])) {
                            $d['stock'] = 0;
                        } else {
                            $d['stock'] = $fila[3];
                        }
                        if(!isset($fila[4])) {
                            if($this->input->post('TextAutoCompletemarca') != '') {
                                $d['marca'] = $this->input->post('TextAutoCompletemarca');
                            } else {
                                $d['marca'] = '';
                            }
                        } else {
                            $d['marca'] = $fila[4];
                        }
                        
                            
                        $this->listas_de_precios_model->set_item($d);
                    }
                }
            }

            
            redirect('/listas_de_precios/asociar_marcas/'.$idlista_de_precio.'/', 'refresh');

        }

        
        
        $data['monedas'] = $this->monedas_model->gets();

        $data['view'] = 'listas_de_precios/importar';
        $this->load->view('layout/app', $data);
    }
    
    public function asociar_marcas($idlista_de_precios = null) {
        $data['title'] = 'Asociar Marcas en Lista de Precios';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        
        if(count($this->input->post())) {
            $post = $this->input->post();
            
            foreach($post as $key => $value) {
                $datos = array(
                    'idmarca' => $value
                );
                $where = array(
                    'idlista_de_precios' => $idlista_de_precios,
                    'marca' => $key
                );
                
                $this->listas_de_precios_model->update_items($datos, $where);
            }
            
            redirect('/listas_de_precios/asociar_generico/'.$idlista_de_precios.'/', 'refresh');
        }
        
        $data['marcas_lista'] = $this->listas_de_precios_model->gets_marcas_por_idlista_de_precios($idlista_de_precios);
        foreach ($data['marcas_lista'] as $key => $value) {
            $datos = array(
                'marca' => $value['marca_lista'],
                'idmarca >' => 0
            );
            $resultado = $this->listas_de_precios_model->get_where_item($datos);
            
            if($resultado) {
                $data['marcas_lista'][$key]['idmarca'] = $resultado['idmarca'];
            }
        }
        
        
        $data['marcas'] = $this->marcas_model->gets();
        
        $data['view'] = 'listas_de_precios/asociar_marcas';
        $this->load->view('layout/app', $data);
    }
    
    public function asociar_generico($idlista_de_precios = null, $pagina = 0) {
        $data['title'] = 'Asociar Artículos a Lista de Precios';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array(
            '/assets/modulos/listas_de_precios/js/asociar_generico.js'
        );
        
        
        $per_page = $this->parametros_model->get_valor_parametro_por_usuario('per_page', $data['session']['SID']);
        $per_page = $per_page['valor'];

        $where = $this->input->get();
        $where['listas_de_precios_items.estado'] = 'A';
        $where['listas_de_precios_items.idlista_de_precios'] = $idlista_de_precios;
        
        
        /*
         * inicio paginador
         */
        $total_rows = $this->listas_de_precios_model->get_cantidad_items_where($where);
        $config['reuse_query_string'] = TRUE;
        $config['base_url'] = '/listas_de_precios/asociar_generico/'.$idlista_de_precios.'/';
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
        
        $data['items'] = $this->listas_de_precios_model->get_cantidad_items_where_limit($where, $per_page, $pagina);
        
        
        
        $datos = array(
            'idlista_de_precios' => $idlista_de_precios
        );
        $data['lista_de_precios'] = $this->listas_de_precios_model->get_where($datos);
        $data['lista_de_precios']['fecha'] = $this->formatear_fecha_para_mostrar($data['lista_de_precios']['fecha']);
        
        $datos = array(
            'idempresa' => $data['lista_de_precios']['idempresa']
        );
        $data['lista_de_precios']['empresa'] = $this->empresas_model->get_where($datos);
        
        $data['monedas'] = $this->monedas_model->gets();
        
        $data['view'] = 'listas_de_precios/asociar_generico';
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
