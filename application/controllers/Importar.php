<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Importar extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array(
            'session',
            'r_session'
        ));
        $this->load->helper(array(
            'file'
        ));

        $session = $this->session->all_userdata();
        $this->r_session->check($session);
    }

    public function agregar() {
        $data['title'] = 'Listado de Artículos';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array();
        $data['view'] = 'importar/agregar';


        $config['upload_path'] = "./upload/importar/";
        $config['allowed_types'] = '*';
        $config['encrypt_name'] = false;
        $config['remove_spaces'] = true;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('archivo')) {
            $data['error'] = array('error' => $this->upload->display_errors());
        } else {
            $data['adjunto'] = array('upload_data' => $this->upload->data());
        }

        $data['archivos'] = get_dir_file_info('upload/importar/');
        

        $this->load->view('layout/app', $data);
    }

}

?>
