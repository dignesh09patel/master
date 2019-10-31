<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->is_logged_in();
        $this->clear_cache();
    }

    function is_logged_in() {

        if ($this->session->userdata('username')) {
            redirect('admin/dashboard');
        }
    }

    function clear_cache() {
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
    }

    function index() {
        $data['title'] = 'Admin Login';
        $this->load->view('admin/login', $data);
    }

    public function admin_login() {
        $this->form_validation->set_rules('username', 'username', 'required');
        $this->form_validation->set_rules('password', 'password', 'required');

        if ($this->form_validation->run()==False) {
			$data['title'] = 'Admin Login';
			$this->load->view('admin/login', $data);
		}else{
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $this->load->model('dashboard_model');
            $data = $this->dashboard_model->admin_login($username, md5($password));
            $numRow = $data->num_rows();
            if ($numRow == 1) {
                foreach ($data->result() as $dataResult) {
                    $username = $dataResult->username;
                    $userid = $dataResult->id;
                }
                $this->session->set_userdata('username', $username);
                $this->session->set_userdata('userid', $userid);
                redirect('admin/dashboard');
            } else {
                $this->session->set_flashdata('messg', 'Sorry ! The Username & Password do not match');
                redirect('admin/login', 'refresh');
            }
        }
        
    }

}

?>
