<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class auth_model extends Model
{


    public function __construct()
    {

        parent::__construct();

        if ( ! $this->googlecalendar->isLogin()) {

            redirect(base_url() . "ambulatorio/guia/agendagoogle/", "refresh");

        }

    }

}