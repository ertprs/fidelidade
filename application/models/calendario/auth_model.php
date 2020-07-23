<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class auth_model extends Model
{


    public function __construct()
    {

        parent::__construct();

        // $this->load->model('calendario/googlecalendar_model', 'googlecalendar');

        // $this->load->library('session');

        if ( ! $this->googlecalendar->isLogin()) {

            // $this->session->sess_destroy();

            redirect(base_url() . "ambulatorio/guia/agendagoogle/", "refresh");

        }

    }

}