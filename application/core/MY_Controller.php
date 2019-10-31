<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    public function __construct()
    {
            parent::__construct();
            $this->is_logged_in();
            $this->clear_cache();
    }

     public function is_logged_in() {
        if (!$this->session->userdata('username')) {
            redirect('admin/login/admin_login');
        }
    }

    public function clear_cache() {
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
    }

}       