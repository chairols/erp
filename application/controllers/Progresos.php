<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Progresos extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array(
            'session',
            'r_session'
        ));
        $this->load->model(array(
            'progresos_model'
        ));
        
        $session = $this->session->all_userdata();
        //$this->r_session->check($session);
    }

    function get($tabla) {
        $session = $this->session->all_userdata();
        
        $where = array(
            'idusuario' => $session['SID'],
            'tabla' => $tabla
        );
        $resultado = $this->progresos_model->get_where($where);
        
        $json = array(
            'status' => 'ok',
            'data' => $resultado['progreso']
        );
        echo json_encode($json);
    }

    public function get_where() {
        $query = $this->db->get_where('progresos', $where);
        
        return $query->row_array();
    }
    
    public function set($datos) {
        $this->db->insert('progresos', $datos);
        return $this->db->insert_id();
    }
}

?>
