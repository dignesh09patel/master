<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('dashboard_model');
	}
        
	function index(){        
		$data['main_content'] = 'admin/dashboard/dashboard';
		$data['title'] = 'Admin Dashboard';	
		$this->load->view('admin/template/template', $data);
	}
 //Logout 
        public function logout()
	{
		$this->session->sess_destroy();
		$this->session->set_userdata('username','');
		redirect('admin/login');
	}
	
//change password    
    function change_password(){
        $id = $this->session->userdata('userid');
        $this->form_validation->set_rules('old_password', 'Old Password', 'required');
        $this->form_validation->set_rules('new_password', 'New Password Password', 'required');
        $data['main_content'] = 'admin/dashboard/change_password';
        $data['title'] = 'Admin Change Password';
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('admin/template/template',$data);
        }else{
             $old_password = $_POST['old_password'];
             $password = $_POST['new_password'];
             if($this->dashboard_model->check_oldpassword($id,$old_password)){
                $data = array(
                        'password' => md5($password)
                    );
                    $this->dashboard_model->save_new_password($id,$data);
                    $this->session->set_flashdata('message', 'Password successfully changed');
                    redirect('admin/dashboard/change_password','refresh');	 
             }else{
                    $this->session->set_flashdata('message_eroor', 'Old password wrong enter');
                    redirect('admin/dashboard/change_password','refresh');
             }
        }
    }

	
}

?>
