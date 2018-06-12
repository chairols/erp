<?php
if ( ! defined('BASEPATH')) exit('No se permite acceso directo al script');

class R_session {
    private $CI;
    
    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->library(array(
            'session'
        ));
        $this->CI->load->helper(array(
            'url'
        ));
        $this->CI->load->model(array(
            'menu_model'
        ));
    }
    
    public function check($datos) {
        if(count($datos) < 6) {
            redirect('/usuarios/login/', 'refresh');
        }
        
        $this->comprobar_accesos();
    }
    
    private function comprobar_accesos() {
        $this->CI =& get_instance();
        
        $session = $this->CI->session->all_userdata();
        // $session['tipo_usuario']
        
        $string = '/'.$this->CI->uri->segment(1).'/';
        if($this->CI->uri->segment(2))
            $string .= $this->CI->uri->segment(2).'/';
        
        
        $acceso = $this->CI->menu_model->get_perfil_menu($session['perfil'], $string);
        
        if(empty($acceso)) {
            show_404();
        }
    }
    
    public function get_menu() {
        $this->CI =& get_instance();
        $this->CI->load->model(array(
            'menu_model'
        ));
        $this->CI->load->helper(array(
            'url'
        ));
        $this->CI->load->library(array(
            'session'
        ));
        $session = $this->CI->session->all_userdata();
        
        $string = '/'.$this->CI->uri->segment(1).'/';
        $segmentoaux = $string;
        if($this->CI->uri->segment(2))
            $string .= $this->CI->uri->segment(2).'/';
        
        
        $data['menu'] = $this->CI->menu_model->obtener_menu_por_padre_para_menu(0, $session['perfil']);
        foreach ($data['menu'] as $key => $value) {
            $data['menu'][$key]['submenu'] = $this->CI->menu_model->obtener_menu_por_padre_para_menu($value['idmenu'], $session['perfil']);
            $data['menu'][$key]['active'] = false;
            if($value['href'] == $string || $value['href'] == $segmentoaux) {
                $data['menu'][$key]['active'] = true;
            } 
            foreach($data['menu'][$key]['submenu'] as $k => $v) {
                $data['menu'][$key]['submenu'][$k]['submenu'] = $this->CI->menu_model->obtener_menu_por_padre_para_menu($v['idmenu'], $session['perfil']);
                $data['menu'][$key]['submenu'][$k]['active'] = false;
                if($v['href'] == $string || $v['href'] == $segmentoaux) {
                    $data['menu'][$key]['active'] = true;
                    $data['menu'][$key]['submenu'][$k]['active'] = true;
                } 
                foreach($data['menu'][$key]['submenu'][$k]['submenu'] as $k1 => $v1) {
                    $data['menu'][$key]['submenu'][$k]['submenu'][$k1]['active'] = false;
                    if($v1['href'] == $string || $v['href'] == $segmentoaux) {
                        $data['menu'][$key]['active'] = true;
                        $data['menu'][$key]['submenu'][$k]['active'] = true;
                        $data['menu'][$key]['submenu'][$k]['submenu'][$k1]['active'] = true;
                    } 
                }
            }
        }
        
        return $data;
    }
}
?>
