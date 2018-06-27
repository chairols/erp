<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Importaciones extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array(
            'session',
            'r_session',
            'form_validation'
        ));
        $this->load->model(array(
            'importaciones_model',
            'log_model',
            'empresas_model'
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
        $this->form_validation->set_rules('fecha_pedido', 'Fecha de Pedido', 'required');

        if ($this->form_validation->run() == FALSE) {
            
        } else {
            $datos = array(
                'idproveedor' => $this->input->post('empresa'),
                'fecha_pedido' => $this->formatear_fecha($this->input->post('fecha_pedido')),
                'fecha_creacion' => date("Y-m-d H:i:s"),
                'idcreador' => $data['session']['SID']
            );

            $id = $this->importaciones_model->set($datos);

            if ($id) {
                $log = array(
                    'tabla' => 'importaciones',
                    'idtabla' => $id,
                    'texto' => 'Se agregó la importación '.$id.'<br>'.
                    'Con número de Proveedor: '.$datos['idproveedor'],
                    'idusuario' => $data['session']['SID'],
                    'tipo' => 'add'
                );

                $this->log_model->set($log);
                
                redirect('/importaciones/agregar_items/' . $id . '/', 'refresh');
            }
        }

        $this->load->view('layout/app', $data);
    }
    
    public function agregar_items($idimportacion = null) {
        if(!$idimportacion) {
            redirect('/importaciones/listar/', 'refresh');
        }
        $data['title'] = 'Agregar Importación';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array();
        $data['view'] = 'importaciones/agregar_items';
        
        $this->form_validation->set_rules('empresa', 'Empresa', 'required|integer');
        $this->form_validation->set_rules('fecha_pedido', 'Fecha de Pedido', 'required');
        $this->form_validation->set_rules('idarticulo', 'Artículo', 'required|integer');
        $this->form_validation->set_rules('cantidad', 'Cantidad', 'required|integer');
        $this->form_validation->set_rules('costo_fob', 'Costo FOB', 'required');
        
        if($this->form_validation->run() == FALSE) {
            
        } else {
            $datos = array(
                'idproveedor' => $this->input->post('empresa'),
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
