<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Listas_de_precios extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array(
            'session',
            'r_session',
            'form_validation',
            'Excel_reader/excel_reader'
        ));
        $this->load->model(array(
            'monedas_model',
            'listas_de_precios_model',
            'marcas_model'
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
                            'marca' => $fila[4],
                            'fecha_creacion' => date("Y-m-d H:i:s"),
                            'idcreador' => $data['session']['SID']
                        );
                        
                        if(!isset($fila[3])) {
                            $d['stock'] = 0;
                        } else {
                            $d['stock'] = $fila[3];
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
        }
        
        $data['marcas_lista'] = $this->listas_de_precios_model->gets_marcas_por_idlista_de_precios($idlista_de_precios);
        
        $data['marcas'] = $this->marcas_model->gets();
        
        $data['view'] = 'listas_de_precios/asociar_marcas';
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

}

?>
