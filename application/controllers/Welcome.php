<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct(){
		
		parent::__construct();
		
		$this->load->model('welcome_model');
	}
	public function index()
	{
		$data['employees'] = $this->welcome_model->get_all_employee();	
		$data['categorys'] = $this->welcome_model->get_category();	
		$this->load->view('welcome_message',$data);
	}
	
	public function add_employee(){
	
			$config['upload_path'] = './uploads/profile/';
            $config['allowed_types'] = 'gif|jpg|png|JPEG';
            $config['max_size'] = '10000';
            $new_name = time().mt_rand(100000, 999999);
            $ext = explode(".", $_FILES["file"]["name"]);
			$fext = end($ext);
            $config['file_name'] = $new_name;
			$profile_pic = $new_name.".".$fext;
            $this->load->library('upload', $config);
			 if ( ! $this->upload->do_upload('file'))
            {
				echo json_encode(array("status" => FAlSE));
			}else{
			$data = array(
					'name' => $this->input->post('name'),
					'contact_number' => $this->input->post('contact'),
					'hobby' => $this->input->post('hobby'),
					'category' => $this->input->post('category'),
					'profile_picture' => $profile_pic
				);
				$insert = $this->welcome_model->add_employee($data);
				echo json_encode(array("status" => TRUE));
			}
	}
	
	public function delete_employee($id){
		 if($this->welcome_model->delete_employee($id)){
			 echo json_encode(array("status" => TRUE));
		 } 
		
	}
	
	public function delete_checked_employee(){
		$ids = explode(',',$this->input->post('ids'));
		foreach($ids as $id){
			$this->welcome_model->delete_employee($id);
		}
	}
	
	public function update_employee(){
		$id =  $this->input->post('id');
		if(isset($id)&&!empty($id)){
				$data = array(
					'name' => $this->input->post('name'),
					'contact_number' => $this->input->post('contact'),
					'hobby' => $this->input->post('hobby'),
					'category' => $this->input->post('category'),
					//'profile_picture' => $profile_pic
				);
				 if($this->welcome_model->update_employee($id,$data)){
					echo json_encode(array("status" => 'ok',$data));
				 }
		}
	}
}
