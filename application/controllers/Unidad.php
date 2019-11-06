<?php

/**
 * Created by PhpStorm.
 * User: Juan
 * Date: 23/03/2018
 * Time: 08:37 PM
 */
class Unidad extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('unidad_model','unidad');
    }

    public function get_all(){
        if ($this->input->is_ajax_request()) {
            echo json_encode($this->unidad->get_all());
        } else {
            show_404();
        }
    }

    public function registrar(){
        if ($this->input->is_ajax_request()) {
            echo $this->unidad->registrar_unidad();
        } else {
            show_404();
        }
    }
}