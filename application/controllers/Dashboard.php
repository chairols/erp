<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array(
            'session',
            'r_session'
        ));

        $session = $this->session->all_userdata();
        $this->r_session->check($session);
    }

    public function index() {
        $data['title'] = 'Dashboard';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array();

        $data['view'] = 'dashboard/index';
        $this->load->view('layout/app', $data);
    }
}
?>
