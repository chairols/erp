<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Optimizar extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array(
            'session',
            'r_session',
            'form_validation'
        ));
        $this->load->model(array(
            'listas_de_precios_model'
        ));

        $session = $this->session->all_userdata();
        $this->r_session->check($session);
    }

    public function sistema() {
        $data['title'] = 'Otimizar Sistema';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array(
            '/assets/modulos/optimizar/js/sistema.js'
        );

        $data['view'] = 'optimizar/sistema';
        $this->load->view('layout/app', $data);
    }

    public function sistema_ajax() {
        $this->form_validation->set_rules('idproceso', 'ID de Proceso', 'required|integer');

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            switch ($this->input->post('idproceso')) {
                case 1:  //  Borrado de artículos sin asociar excepto última lista de cada proveedor
                    $this->proceso_1();
                    break;
                case 2:
                    $this->proceso_2();
                    break;
            }
        }
    }

    private function proceso_1() {
        $this->benchmark->mark('inicio');
        $listas = $this->listas_de_precios_model->gets_ultimas_listas_por_proveedor();

        $items_sin_asociar = 0;
        foreach ($listas as $key => $value) {
            $where = array(
                'listas_de_precios.idproveedor' => $value['idproveedor'],
                'listas_de_precios.fecha <' => $value['fecha'],
                'listas_de_precios_items.idarticulo_generico' => 0
            );
            $listas[$key]['items'] = $this->listas_de_precios_model->gets_items_full_where($where);
            foreach ($listas[$key]['items'] as $key2 => $item) {
                $where = array(
                    'idlista_de_precios_item' => $item['idlista_de_precios_item']
                );
                $this->listas_de_precios_model->borrar_item_where($where);
                $items_sin_asociar++;
            }
        }
        $this->benchmark->mark('fin');

        $tiempo = $this->benchmark->elapsed_time('inicio', 'fin');

        $json = array(
            'status' => 'ok',
            'data' => 'Se eliminaron ' . $items_sin_asociar . ' items.<br>El proceso duró ' . $tiempo . ' segundos.',
            'next_proceso' => '2',
            'next_destino' => 'articulos_duplicados'
        );
        echo json_encode($json);
    }

    private function proceso_2() {
        $this->benchmark->mark('inicio');
        $listas = $this->listas_de_precios_model->gets_ultimas_listas_por_proveedor();

        $items_duplicados = 0;
        foreach ($listas as $key => $value) {
            $where = array(
                'listas_de_precios.idlista_de_precios' => $value['idlista_de_precios']
            );
            $listas[$key]['items'] = $this->listas_de_precios_model->gets_items_full_where($where);


            foreach ($listas[$key]['items'] as $key2 => $value2) {
                $where = array(
                    'listas_de_precios_items.articulo' => $value2['articulo'],
                    'listas_de_precios.fecha <' => $value2['fecha']
                );
                $articulos = $this->listas_de_precios_model->gets_items_full_where($where);

                if ($articulos) {
                    foreach ($articulos as $articulo) {
                        $where = array(
                            'idlista_de_precios_item' => $articulo['idlista_de_precios_item']
                        );
                        $this->listas_de_precios_model->borrar_item_where($where);
                        $items_duplicados++;
                    }
                }
            }
        }
        $this->benchmark->mark('fin');
        $tiempo = $this->benchmark->elapsed_time('inicio', 'fin');

        $json = array(
            'status' => 'ok',
            'data' => 'Se eliminaron ' . $items_duplicados . ' items.<br>El proceso duró ' . $tiempo . ' segundos.',
            'next_proceso' => '3',
            'next_destino' => 'optimizar_base_de_datos'
        );
        echo json_encode($json);
    }

    private function proceso_3() {
        $this->benchmark->mark('inicio');
        
        $this->load->dbutil();
        $resultado = $this->dbutil->optimize_table('listas_de_precios_items');
        
        $this->benchmark->mark('fin');
        $tiempo = $this->benchmark->elapsed_time('inicio', 'fin');

        if ($resultado['Msg_text'] == 'OK') {
            $json = array(
                'status' => 'ok',
                'data' => 'Se optimizó la tabla Listas de Precios.<br>El proceso duró ' . $tiempo . ' segundos.',
                'next_proceso' => '4',
                'next_destino' => ''
            );
             echo json_encode($json);
        }
    }

}

?>