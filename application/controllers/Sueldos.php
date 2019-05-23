<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sueldos extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array(
            'session',
            'r_session',
            'form_validation',
            'pagination'
        ));
        $this->load->model(array(
            'sueldos_model',
            'parametros_model',
            'empleados_model',
            'calificaciones_model'
        ));

        $session = $this->session->all_userdata();
        $this->r_session->check($session);
    }

    public function agregar_concepto() {
        $data['title'] = 'Agregar Concepto';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array(
            '/assets/modulos/sueldos/js/agregar_concepto.js'
        );
        $data['view'] = 'sueldos/agregar_concepto';

        $this->load->view('layout/app', $data);
    }

    public function agregar_concepto_ajax() {
        $session = $this->session->all_userdata();

        $this->form_validation->set_rules('idsueldo_concepto', 'Número de Concepto', 'required|integer');
        $this->form_validation->set_rules('sueldo_concepto', 'Concepto', 'required');
        $this->form_validation->set_rules('tipo', 'Tipo', 'required');
        $this->form_validation->set_rules('cantidad', 'Cantidad', 'required|decimal');
        $this->form_validation->set_rules('unidad', 'Unidad', 'required');

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $where = array(
                'idsueldo_concepto' => $this->input->post('idsueldo_concepto')
            );
            $concepto = $this->sueldos_model->get_where_concepto($where);

            if ($concepto) {
                $json = array(
                    'status' => 'error',
                    'data' => 'Ya existe el concepto ' . $this->input->post('idsueldo_concepto')
                );
                echo json_encode($json);
            } else {
                $set = array(
                    'idsueldo_concepto' => $this->input->post('idsueldo_concepto'),
                    'sueldo_concepto' => $this->input->post('sueldo_concepto'),
                    'tipo' => $this->input->post('tipo'),
                    'cantidad' => $this->input->post('cantidad'),
                    'unidad' => $this->input->post('unidad')
                );

                $idsueldo_concepto = $this->sueldos_model->set_concepto($set);
                if ($idsueldo_concepto) {
                    $json = array(
                        'status' => 'ok',
                        'data' => 'Se agregó el concepto ' . $this->input->post('sueldo_concepto')
                    );
                    echo json_encode($json);
                } else {
                    $json = array(
                        'status' => 'error',
                        'data' => 'No se pudo agregar el concepto'
                    );
                    echo json_encode($json);
                }
            }
        }
    }

    public function conceptos_listar($pagina = 0) {
        $data['title'] = 'Listado de Conceptos';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array();
        $data['view'] = 'sueldos/conceptos_listar';


        $per_page = $this->parametros_model->get_valor_parametro_por_usuario('per_page', $data['session']['SID']);
        $per_page = $per_page['valor'];

        $where = $this->input->get();
        $where['sueldos_conceptos.estado'] = 'A';

        /*
         * inicio paginador
         */
        $total_rows = $this->sueldos_model->get_cantidad_conceptos_where($where);
        $config['reuse_query_string'] = TRUE;
        $config['base_url'] = '/sueldos/conceptos_listar/';
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

        $data['conceptos'] = $this->sueldos_model->gets_where_conceptos_limit($where, $per_page, $pagina);

        $this->load->view('layout/app', $data);
    }

    public function conceptos_modificar($idsueldo_concepto = null) {
        if ($idsueldo_concepto == null) {
            redirect('/sueldos/conceptos_listar/', 'refresh');
        }
        $data['title'] = 'Modificar Concepto';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array(
            '/assets/modulos/sueldos/js/modificar_concepto.js'
        );
        $data['view'] = 'sueldos/modificar_concepto';

        $where = array(
            'idsueldo_concepto' => $idsueldo_concepto,
            'estado' => 'A'
        );
        $data['sueldo_concepto'] = $this->sueldos_model->get_where_concepto($where);

        $this->load->view('layout/app', $data);
    }

    public function conceptos_modificar_ajax() {
        $session = $this->session->all_userdata();

        $this->form_validation->set_rules('idsueldo_concepto', 'Número de Concepto', 'required|integer');
        $this->form_validation->set_rules('sueldo_concepto', 'Concepto', 'required');
        $this->form_validation->set_rules('tipo', 'Tipo', 'required');
        $this->form_validation->set_rules('cantidad', 'Cantidad', 'required|decimal');
        $this->form_validation->set_rules('unidad', 'Unidad', 'required');

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $datos = array(
                'sueldo_concepto' => $this->input->post('sueldo_concepto'),
                'tipo' => $this->input->post('tipo'),
                'cantidad' => $this->input->post('cantidad'),
                'unidad' => $this->input->post('unidad')
            );
            $where = array(
                'idsueldo_concepto' => $this->input->post('idsueldo_concepto')
            );
            $resultado = $this->sueldos_model->update_concepto($datos, $where);

            if ($resultado) {
                $json = array(
                    'status' => 'ok',
                    'data' => 'Se actualizó correctamente'
                );
                echo json_encode($json);
            } else {
                $json = array(
                    'status' => 'error',
                    'data' => 'No se pudo actualizar el Concepto'
                );
                echo json_encode($json);
            }
        }
    }

    public function agregar() {
        $data['title'] = 'Agregar Recibo de Sueldo';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array(
            '/assets/modulos/sueldos/js/agregar.js'
        );
        $data['view'] = 'sueldos/agregar';

        $where = array(
            'estado' => 'A'
        );
        $data['empleados'] = $this->empleados_model->gets_where($where);

        $this->load->view('layout/app', $data);
    }

    public function agregar_ajax() {
        $session = $this->session->all_userdata();

        $this->form_validation->set_rules('idempleado', 'Empleado', 'required|integer');
        $this->form_validation->set_rules('periodo_mes', 'Mes', 'required|integer');
        $this->form_validation->set_rules('periodo_anio', 'Año', 'required|integer');
        $this->form_validation->set_rules('presentismo', 'Presentismo', 'required');
        $this->form_validation->set_rules('prestamo', 'Pago Préstamo', 'required|less_than[1]');

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {

            $where = array(
                'idempleado' => $this->input->post('idempleado'),
                'estado' => 'A'
            );
            $empleado = $this->empleados_model->get_where($where);

            $where = array(
                'idcalificacion' => $empleado['idcalificacion']
            );
            $calificacion = $this->calificaciones_model->get_where($where);

            $where = array(
                'idcalificacion' => $calificacion['padre']
            );
            $categoria = $this->calificaciones_model->get_where($where);

            $where = array(
                'idcalificacion' => $categoria['padre']
            );
            $seccion = $this->calificaciones_model->get_where($where);

            $set = array(
                'idempleado' => $this->input->post('idempleado'),
                'empleado' => trim($empleado['nombre'] . ' ' . $empleado['apellido']),
                'idcalificacion' => $empleado['idcalificacion'],
                'seccion' => $seccion['calificacion'],
                'categoria' => $categoria['calificacion'],
                'calificacion' => $calificacion['calificacion'],
                'fecha_ingreso' => $empleado['fecha_ingreso'],
                'periodo_mes' => $this->input->post('periodo_mes'),
                'periodo_anio' => $this->input->post('periodo_anio'),
                'sueldo_bruto' => $empleado['sueldo_bruto'],
                'fecha_creacion' => date("Y-m-d H:i:s"),
                'idcreador' => $session['SID'],
                'actualizado_por' => $session['SID']
            );

            $idsueldo = $this->sueldos_model->set($set);

            if ($idsueldo) {

                /*
                 *  Concepto Sueldo
                 */
                $where = array(
                    'idsueldo_concepto' => 201
                );
                $concepto_sueldo = $this->sueldos_model->get_where_concepto($where);

                $set = array(
                    'idsueldo' => $idsueldo,
                    'idsueldo_concepto' => 201,
                    'concepto' => $concepto_sueldo['sueldo_concepto'],
                    'cantidad' => $concepto_sueldo['cantidad'],
                    'unidad' => $concepto_sueldo['unidad'],
                    'tipo' => $concepto_sueldo['tipo'],
                    'valor' => $empleado['sueldo_bruto']
                );
                $this->sueldos_model->set_item($set);
                /*
                 *  Fin Concepto Sueldo
                 */

                /*
                 *  Concepto Comida
                 */
                $where = array(
                    'idsueldo_concepto' => 213
                );
                $concepto_comida = $this->sueldos_model->get_where_concepto($where);

                $where = array(
                    'idsueldo_parametro' => 'comida'
                );
                $comida = $this->sueldos_model->get_where_parametro($where);

                $set = array(
                    'idsueldo' => $idsueldo,
                    'idsueldo_concepto' => 213,
                    'concepto' => $concepto_comida['sueldo_concepto'],
                    'cantidad' => $concepto_comida['cantidad'],
                    'unidad' => $concepto_comida['unidad'],
                    'tipo' => $concepto_comida['tipo'],
                    'valor' => $comida['valor']
                );
                $this->sueldos_model->set_item($set);
                /*
                 *  Fin Concepto Comida
                 */

                /*
                 *  Concepto Antigüedad
                 */
                $where = array(
                    'idsueldo_concepto' => 216
                );
                $concepto_antiguedad = $this->sueldos_model->get_where_concepto($where);

                $ingreso = new DateTime($empleado['fecha_ingreso']);
                $hoy = new DateTime();
                $annos = $hoy->diff($ingreso);
                //echo $annos->y;

                $antiguedad_valor = (($empleado['sueldo_bruto'] + $comida['valor']) * $annos->y) / 100;

                $set = array(
                    'idsueldo' => $idsueldo,
                    'idsueldo_concepto' => 216,
                    'concepto' => $concepto_antiguedad['sueldo_concepto'],
                    'cantidad' => $concepto_antiguedad['cantidad'],
                    'unidad' => $concepto_antiguedad['unidad'],
                    'tipo' => $concepto_antiguedad['tipo'],
                    'valor' => $antiguedad_valor
                );
                $this->sueldos_model->set_item($set);
                /*
                 *  Fin Concepto Antigüedad
                 */

                /*
                 *  Concepto Presentismo
                 */
                if ($this->input->post('presentismo') == 'S') {
                    $where = array(
                        'idsueldo_concepto' => 205
                    );
                    $concepto_presentismo = $this->sueldos_model->get_where_concepto($where);

                    $presentismo_valor = ($empleado['sueldo_bruto'] + $comida['valor'] + $antiguedad_valor) / 12;

                    $set = array(
                        'idsueldo' => $idsueldo,
                        'idsueldo_concepto' => 216,
                        'concepto' => $concepto_presentismo['sueldo_concepto'],
                        'cantidad' => $concepto_presentismo['cantidad'],
                        'unidad' => $concepto_presentismo['unidad'],
                        'tipo' => $concepto_presentismo['tipo'],
                        'valor' => $presentismo_valor
                    );
                    $this->sueldos_model->set_item($set);
                }
                /*
                 *  Fin Concepto Presentismo
                 */

                $where = array(
                    'sueldos_items.idsueldo' => $idsueldo,
                    'sueldos_items.tipo' => 'R',
                    'sueldos_items.estado' => 'A'
                );
                $items = $this->sueldos_model->gets_where_items($where);
                $total = 0;
                foreach ($items as $item) {
                    $total += $item['valor'];
                }

                /*
                 *  Concepto Jubilación
                 */
                $where = array(
                    'idsueldo_concepto' => 401
                );
                $concepto_jubilacion = $this->sueldos_model->get_where_concepto($where);

                $jubilacion_valor = ($total * $concepto_jubilacion['cantidad']) / 100;

                $set = array(
                    'idsueldo' => $idsueldo,
                    'idsueldo_concepto' => 401,
                    'concepto' => $concepto_jubilacion['sueldo_concepto'],
                    'cantidad' => $concepto_jubilacion['cantidad'],
                    'unidad' => $concepto_jubilacion['unidad'],
                    'tipo' => $concepto_jubilacion['tipo'],
                    'valor' => $jubilacion_valor
                );
                $this->sueldos_model->set_item($set);
                /*
                 *  Fin Concepto Jubilación
                 */

                /*
                 *  Concepto LEY 19032
                 */
                $where = array(
                    'idsueldo_concepto' => 402
                );
                $concepto_19032 = $this->sueldos_model->get_where_concepto($where);

                $valor_19032 = ($total * $concepto_19032['cantidad']) / 100;

                $set = array(
                    'idsueldo' => $idsueldo,
                    'idsueldo_concepto' => 402,
                    'concepto' => $concepto_19032['sueldo_concepto'],
                    'cantidad' => $concepto_19032['cantidad'],
                    'unidad' => $concepto_19032['unidad'],
                    'tipo' => $concepto_19032['tipo'],
                    'valor' => $valor_19032
                );
                $this->sueldos_model->set_item($set);
                /*
                 *  Fin Concepto LEY 19032
                 */

                /*
                 *  Concepto LEY 23660
                 */
                $where = array(
                    'idsueldo_concepto' => 405
                );
                $concepto_23660 = $this->sueldos_model->get_where_concepto($where);

                $valor_23660 = ($total * 0.03 * 0.9);

                $set = array(
                    'idsueldo' => $idsueldo,
                    'idsueldo_concepto' => 405,
                    'concepto' => $concepto_23660['sueldo_concepto'],
                    'cantidad' => $concepto_23660['cantidad'],
                    'unidad' => $concepto_23660['unidad'],
                    'tipo' => $concepto_23660['tipo'],
                    'valor' => $valor_23660
                );
                $this->sueldos_model->set_item($set);
                /*
                 *  Fin Concepto LEY 23660
                 */

                /*
                 *  Concepto A.N.S.S.A.L.
                 */
                $where = array(
                    'idsueldo_concepto' => 406
                );
                $concepto_anssal = $this->sueldos_model->get_where_concepto($where);

                $valor_anssal = ($total * 0.03 * 0.1);

                $set = array(
                    'idsueldo' => $idsueldo,
                    'idsueldo_concepto' => 406,
                    'concepto' => $concepto_anssal['sueldo_concepto'],
                    'cantidad' => $concepto_anssal['cantidad'],
                    'unidad' => $concepto_anssal['unidad'],
                    'tipo' => $concepto_anssal['tipo'],
                    'valor' => $valor_anssal
                );
                $this->sueldos_model->set_item($set);
                /*
                 *  Fin Concepto A.N.S.S.A.L.
                 */

                /*
                 *  Concepto FAECYS
                 */
                $where = array(
                    'idsueldo_concepto' => 421
                );
                $concepto_faecys = $this->sueldos_model->get_where_concepto($where);

                $faecys_valor = ($total * $concepto_faecys['cantidad']) / 100;

                $set = array(
                    'idsueldo' => $idsueldo,
                    'idsueldo_concepto' => 421,
                    'concepto' => $concepto_faecys['sueldo_concepto'],
                    'cantidad' => $concepto_faecys['cantidad'],
                    'unidad' => $concepto_faecys['unidad'],
                    'tipo' => $concepto_faecys['tipo'],
                    'valor' => $faecys_valor
                );
                $this->sueldos_model->set_item($set);
                /*
                 *  Fin Concepto FAECYS
                 */

                /*
                 *  Concepto Fondo Asistencial
                 */
                $where = array(
                    'idsueldo_concepto' => 422
                );
                $concepto_fondo_asistencial = $this->sueldos_model->get_where_concepto($where);
                $fondo_asistencial_valor = ($total * $concepto_fondo_asistencial['cantidad']) / 100;

                $set = array(
                    'idsueldo' => $idsueldo,
                    'idsueldo_concepto' => 422,
                    'concepto' => $concepto_fondo_asistencial['sueldo_concepto'],
                    'cantidad' => $concepto_fondo_asistencial['cantidad'],
                    'unidad' => $concepto_fondo_asistencial['unidad'],
                    'tipo' => $concepto_fondo_asistencial['tipo'],
                    'valor' => $fondo_asistencial_valor
                );
                $this->sueldos_model->set_item($set);
                /*
                 *  Fin Concepto Fondo Asistencial
                 */

                /*
                 *  Concepto Pago Préstamo
                 */
                if ($this->input->post('prestamo') < 0) {
                    $where = array(
                        'idsueldo_concepto' => 431
                    );
                    $concepto_pago_prestamo = $this->sueldos_model->get_where_concepto($where);
                    $pago_prestamo = $this->input->post('prestamo');

                    $set = array(
                        'idsueldo' => $idsueldo,
                        'idsueldo_concepto' => 431,
                        'concepto' => $concepto_pago_prestamo['sueldo_concepto'],
                        'cantidad' => $concepto_pago_prestamo['cantidad'],
                        'unidad' => $concepto_pago_prestamo['unidad'],
                        'tipo' => $concepto_pago_prestamo['tipo'],
                        'valor' => $pago_prestamo
                    );
                    $this->sueldos_model->set_item($set);
                }


                $json = array(
                    'status' => 'ok',
                    'data' => $idsueldo
                );
                echo json_encode($json);
            } else {
                $json = array(
                    'status' => 'error',
                    'data' => 'No se pudo crear el recibo de sueldo'
                );
                echo json_encode($json);
            }
        }
    }

    public function modificar($idsueldo = null) {
        if ($idsueldo == null) {
            redirect('/sueldos/listar/', 'refresh');
        }
        $session = $this->session->all_userdata();
        $data['title'] = 'Modificar Recibo de Sueldo';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array(
            '/assets/modulos/sueldos/js/modificar.js'
        );
        $data['view'] = 'sueldos/modificar';

        $where = array(
            'idsueldo' => $idsueldo,
            'estado' => 'A'
        );
        $data['sueldo'] = $this->sueldos_model->get_where($where);

        $this->load->view('layout/app', $data);
    }

    public function check() {
        $this->form_validation->set_rules('idempleado', 'Empleado', 'required|integer');
        $this->form_validation->set_rules('periodo_mes', 'Mes', 'required|integer');
        $this->form_validation->set_rules('periodo_anio', 'Año', 'required|integer');

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $where = array(
                'idempleado' => $this->input->post('idempleado'),
                'periodo_mes' => $this->input->post('periodo_mes'),
                'periodo_anio' => $this->input->post('periodo_anio')
            );
            $resultado = $this->sueldos_model->get_where($where);

            if ($resultado) {
                $json = array(
                    'status' => 'ok',
                    'data' => ''
                );
                echo json_encode($json);
            } else {
                $json = array(
                    'status' => 'agregar',
                    'data' => ''
                );
                echo json_encode($json);
            }
        }
    }

    public function gets_items_tabla() {
        $where = array(
            'sueldos_items.idsueldo' => $this->input->post('idsueldo'),
            'sueldos_items.estado' => 'A'
        );
        $data['items'] = $this->sueldos_model->gets_where_items($where);

        $this->load->view('sueldos/gets_items_tabla', $data);
    }

    public function parametros() {
        $data['title'] = 'Parámetros de Recibos de Sueldos';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array(
            '/assets/modulos/sueldos/js/parametros.js'
        );
        $data['view'] = 'sueldos/parametros';

        $where = array(
            'idsueldo_parametro' => 'comida'
        );
        $data['comida'] = $this->sueldos_model->get_where_parametro($where);

        $this->load->view('layout/app', $data);
    }

    public function parametros_ajax() {
        $session = $this->session->all_userdata();

        $this->form_validation->set_rules('comida', 'Valor Comida', 'required|decimal');

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $flag = true;

            $datos = array(
                'valor' => $this->input->post('comida')
            );
            $where = array(
                'idsueldo_parametro' => 'comida'
            );

            $resultado = $this->sueldos_model->update_parametros($datos, $where);
            if (!$resultado) {
                $flag = false;
            }

            if ($flag) {
                $json = array(
                    'status' => 'ok',
                    'data' => 'Se actualizaron los parámetros'
                );
                echo json_encode($json);
            } else {
                $json = array(
                    'status' => 'error',
                    'data' => 'No se pudieron actualizar los parámetros'
                );
                echo json_encode($json);
            }
        }
    }

}

?>