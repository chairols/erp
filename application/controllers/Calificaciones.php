<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Calificaciones extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array(
            'session',
            'r_session',
            'form_validation'
        ));
        $this->load->model(array(
            'calificaciones_model'
        ));

        $session = $this->session->all_userdata();
        $this->r_session->check($session);
    }

    public function agregar() {
        $data['title'] = 'Agregar Calificación';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array(
            '/assets/modulos/calificaciones/js/agregar.js'
        );
        $data['view'] = 'calificaciones/agregar';



        $this->load->view('layout/app', $data);
    }

    public function agregar_ajax() {
        $session = $this->session->all_userdata();

        $this->form_validation->set_rules('calificacion', 'Calificación', 'required');

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $set = array(
                'calificacion' => $this->input->post('calificacion'),
                'orden' => 0,
                'padre' => 0
            );

            $id = $this->calificaciones_model->set($set);

            if ($id) {
                $json = array(
                    'status' => 'ok',
                    'data' => 'Se creó la calificación '.$this->input->post('calificacion').' correctamente'
                );
                echo json_encode($json);
            } else {
                $json = array(
                    'status' => 'error',
                    'data' => 'No se pudo crear la calificación'
                );
                echo json_encode($json);
            }
        }
    }
    
    public function ordenar() {
        $data['title'] = 'Ordenar Calificaciones';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['css'] = array(
            '/assets/modulos/calificaciones/css/ordenar.css'
        );
        $data['javascript'] = array(
            '/assets/vendors/Nestable-master/jquery.nestable.js',
            '/assets/modulos/calificaciones/js/ordenar.js'
        );
        $data['view'] = 'calificaciones/ordenar';

        $where = array(
            'padre' => 0,
            'estado' => 'A'
        );
        $data['calificaciones'] = $this->calificaciones_model->gets_where($where);
        foreach ($data['calificaciones'] as $key => $value) {
            $where = array(
                'padre' => $value['idcalificacion'],
                'estado' => 'A'
            );
            $data['calificaciones'][$key]['calificaciones'] = $this->calificaciones_model->gets_where($where);
            foreach($data['calificaciones'][$key]['calificaciones'] as $key2 => $value2) {
                $where = array(
                    'padre' => $value2['idcalificacion'],
                    'estado' => 'A'
                );
                $data['calificaciones'][$key]['calificaciones'][$key2]['calificaciones'] = $this->calificaciones_model->gets_where($where);
            }
        }

        $this->load->view('layout/app', $data);
    }

    public function actualizar_orden() {
        $this->form_validation->set_rules('orden', 'Orden', 'required');

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $resultado = json_decode($this->input->post('orden'));

            $contador1 = 1;
            foreach ($resultado as $r1) {
                $data = array(
                    'orden' => $contador1,
                    'padre' => 0
                );
                $where = array(
                    'idcalificacion' => $r1->id
                );
                $this->calificaciones_model->update($data, $where);

                if (isset($r1->children)) {
                    $contador2 = 1;
                    foreach ($r1->children as $r2) {
                        $data = array(
                            'orden' => $contador2,
                            'padre' => $r1->id
                        );
                        $where = array(
                            'idcalificacion' => $r2->id
                        );
                        $this->calificaciones_model->update($data, $where);


                        if (isset($r2->children)) {
                            $contador3 = 1;
                            foreach ($r2->children as $r3) {
                                $data = array(
                                    'orden' => $contador3,
                                    'padre' => $r2->id
                                );
                                $where = array(
                                    'idcalificacion' => $r3->id
                                );
                                $this->calificaciones_model->update($data, $where);

                                $contador3++;
                            }
                        }
                        $contador2++;
                    }
                }

                $contador1++;
            }

            $json = array(
                'status' => 'ok',
                'data' => 'Se ordenó correctamente'
            );
            echo json_encode($json);
        }
    }
}

?>