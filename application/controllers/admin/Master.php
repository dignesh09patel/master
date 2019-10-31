<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master extends MY_Controller {
    
    function __construct()
    {
            parent::__construct();
			$this->load->library('pagination');
            $this->load->model('master_model');
    }   
   
   
    
    public function blog($search=''){
        $data['main_content'] = 'admin/master/blogs';
        $data['title'] = 'Blog';	
	
		$config = [
			'base_url' 		=> base_url('admin/master/blog'),
			'per_page' 		=> 5,
			'total_rows' 	=> $this->master_model->get_num_blog(),
			'full_tag_open'	=> "<ul class='pagination'>",
			'full_tag_close'=> "</ul>",
			'next_tag_open' => "<li>",
			'next_tag_close'=> "</li>",
			'previous_tag_open' => "<li>",
			'previous_tag_close'=> "</li>",
			'cur_tag_open'		=> "<li class='active'><a>",
			'cur_tag_close'		=> "</a></li>"
		];
		
		$this->pagination->initialize($config);
        $data['blogs'] = $this->master_model->get_all_blog($config['per_page'],$this->uri->segment(4));
        $this->load->view('admin//template/template', $data);
    }
	
	
	public function serach_result($search){
		if(isset($search)&&!empty($search)){
		$data['main_content'] = 'admin/master/blogs';
		
        $data['title'] = 'Blog Search';
			$config = [
				'base_url' 		=> base_url("admin/master/serach_result/$search"),
				'per_page' 		=> 1,
				'total_rows' 	=> $this->master_model->get_num_serach_blog($search),
				'uri_segment'	=> 5,
				'full_tag_open'	=> "<ul class='pagination'>",
				'full_tag_close'=> "</ul>",
				'next_tag_open' => "<li>",
				'next_tag_close'=> "</li>",
				'previous_tag_open' => "<li>",
				'previous_tag_close'=> "</li>",
				'cur_tag_open'		=> "<li class='active'><a>",
				'cur_tag_close'		=> "</a></li>"
			];
			
			$this->pagination->initialize($config);
			$data['blogs'] = $this->master_model->search_result($search,$config['per_page'],$this->uri->segment(5));
			$this->load->view('admin//template/template', $data);
		}
	}
    
    public function add_blog(){
        $data['main_content'] = 'admin/master/add_blog';
        $data['title'] = 'Add Blog';
		 $this->form_validation->set_rules('title', 'Blog Title', 'required');
		 $this->form_validation->set_rules('content', 'Blog Description', 'required');
		// $this->form_validation->set_rules('image', 'Blog Image', 'required');
		 $this->form_validation->set_rules('is_active', 'Blog Status', 'required');
        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('admin/template/template',$data);	
        }else{
		
            $config['upload_path'] = './uploads/blog';
            $config['allowed_types'] = 'gif|jpg|png|JPEG';
            $config['max_size'] = '10000';
            $new_name = time().mt_rand(100000, 999999);
            $ext =explode(".", $_FILES["image"]["name"]);
			$fext  = end($ext);
            $config['file_name'] = $new_name;
            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload('image'))
            {
               $data['error'] = $this->upload->display_errors();
               $this->load->view('admin/template/template', $data);

            }else{ 
                  $data = array(
                        'title'          =>  $_POST['title'],
                        'content'        =>  $_POST['content'],
                        'is_active'      =>  $_POST['is_active'],
						'slug'			 =>  url_title($this->input->post('title'), 'dash', TRUE),
                        'create_date'    =>  date('Y-m-d H:i:s')
                      
                    ); 
                if($this->master_model->add_blog($data)){
                   return  redirect('admin/master/blog');
                }
            }
        }
    }
    
    public function change_blog_status($deal_item_id = false, $statusUpdate = true) {
	 $url = $_SERVER['HTTP_REFERER'];
        if (!$deal_item_id) {
            $this->session->set_flashdata('error_message', 'Please choose Blog.');
            redirect('master/blog', 'refresh');
        } else {
            $this->db->where(array(
                'id' => $deal_item_id
            ));
            $this->db->update('blog', array(
                'is_active' => $statusUpdate
            ));
            $this->session->set_flashdata('succ_message', 'Blog status updated succssfully.');
            redirect($url, 'refresh');
        }
    }
    
    public function edit_blog(){
         $id = $this->uri->segment(4);
         $data['main_content'] = 'admin/master/edit_blog';
         $data['title'] = 'Edit Blog';
         $data['blog'] = $this->master_model->get_blog_id($id);
         $this->form_validation->set_rules('title', 'Blog Title', 'required');
		 $this->form_validation->set_rules('content', 'Blog Description', 'required');
		 $this->form_validation->set_rules('is_active', 'Blog Status', 'required');
		
        if (empty($id))
        {
            show_404();
        }
        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('admin/template/template', $data);	
        }
        else
        {
            $blog_id 	= 		$_POST['blog_id'];
            $title      =       $_POST['title'];
            $content    =       $_POST['content'];
            $is_active  =       $_POST['is_active'];
            if(!empty($_FILES["image"]["name"]))
            {
                $config['upload_path'] = './uploads/blog';
                $config['allowed_types'] = 'gif|jpg|png|JPEG';
                $config['max_size'] = '10000';
                $new_name = time().mt_rand(100000, 999999);
                $ext =end((explode(".", $_FILES["image"]["name"])));
                $config['file_name'] = $new_name;
                $ext = end((explode(".", $_FILES["image"]["name"])));
                $config['file_name'] = $new_name;
                $this->load->library('upload', $config);
                if (! $this->upload->do_upload('image')){
                    $data['error'] = $this->upload->display_errors();
                    $this->load->view('admin/template/template', $data);
                }else{
                    $image              = 	$new_name.'.'.$ext;
                    $data = array(
                        'title'          =>  $_POST['title'],
                        'content'        =>  $_POST['content'],
                        'meta_keyword'     =>  $this->input->post('meta_keyword'), 
                        'meta_description' =>  $this->input->post('meta_description'),
                        'is_active'      =>  $_POST['is_active'],
                        'image'          =>  $new_name.'.'.$ext
                    ); 
                    if($this->master_model->update_blog($blog_id,$data))
                    {
                            redirect('admin/master/blog');
                    }else{
                            $this->load->view('admin/template/template', $data);
                    }
                }
            }else{
                $data = array(
                        'title'          =>  $_POST['title'],
                        'content'        =>  $_POST['content'],
                        'is_active'      =>  $_POST['is_active']
                    ); 
                if($this->master_model->update_blog($blog_id,$data))
                {
                        redirect('admin/master/blog');
                }else{
                        $this->load->view('admin/template/template', $data);
                }
            }
            
        }
    }
    
        //Delete blog
    public function delete_blog()
    {
        $id = $this->uri->segment(4);
        if (empty($id))
        {
            show_404();
        }    
        $this->master_model->delete_blog($id);        
        redirect( base_url() . 'admin/master/blog');    
    }
	
		//search blog
	public function search(){
		$data['main_content'] = 'admin/master/blogs';
        $data['title'] = 'Blog';	
		   $this->form_validation->set_rules('search', 'Search', 'required');
			if ($this->form_validation->run() === FALSE)
			{
				$this->blog();
			}else{
				  $search = $this->input->post('search');
				  if(isset($search)&&!empty($search)){
					 return  redirect("admin/master/serach_result/$search");
				  }
			}
	}	
	
    
    
    //About page content
   public function about(){
        $data['main_content'] = 'admin/master/about';
        $data['title'] = 'About';	
        $data['about'] = $this->master_model->get_about();
        $this->load->view('admin//template/template', $data);
    }
    
    public function update_about(){
        $data['main_content'] = 'admin/master/about';
        $data['title'] = 'About';	
        $data['about'] = $this->master_model->get_about();
        $this->form_validation->set_rules('content_left', 'Content Left', 'required');
        $this->form_validation->set_rules('content_right', 'Content Right', 'required');

        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('admin/template/template', $data);	
        }
        else
        {
            $content_left            = 	$_POST['content_left'];
            $content_right           =  $_POST['content_right'];
            $vision                  = 	$_POST['vision'];
            $mission                 = 	$_POST['mission'];
           
           
            $data = array(
                    'content_left'              =>  $content_left,
                    'content_right'             =>  $content_right,
                    'vision'                    =>  $vision,
                    'mission'                   =>  $mission
                );
            if($this->master_model->update_about($data))
            {
                $this->session->set_flashdata('message', 'Update Successfully');
                    redirect('admin/master/about');
            }else{
                    redirect('admin/master/about');
            }
        }
    }
    
    public function core_team(){
        $data['main_content'] = 'admin/master/core_team';
        $data['title'] = 'Core Team';	
        $data['core_team'] = $this->master_model->get_core_team();
        $this->load->view('admin//template/template', $data);
    }
    
    public function add_core_team(){
        $data['main_content'] = 'admin/master/add_core_team';
        $data['title'] = 'Add Core Team Member';
        $this->form_validation->set_rules('name', 'Name', 'required');
        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('admin/template/template',$data);	
        }else{
            $config['upload_path'] = './uploads/core_team';
            $config['allowed_types'] = 'gif|jpg|png|JPEG';
            $config['max_size'] = '10000';
            $new_name = time().mt_rand(100000, 999999);
            $ext =end((explode(".", $_FILES["image"]["name"])));
            $config['file_name'] = $new_name;
            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload('image'))
            {
               $data['error'] = $this->upload->display_errors();
               $this->load->view('admin/template/template', $data);

            }else{ 
                  $data = array(
                        'name'                  =>  $this->input->post('name'),
                        'designation'           =>  $this->input->post('designation'),
                        'details'               =>  $this->input->post('details'), 
                        'fb_link'               =>  $this->input->post('fb_link'),
                        'linkdin_link'          =>  $this->input->post('linkdin_link'),
                        'twitter_link'          =>  $this->input->post('twitter_link'),
                        'insta_link'            =>  $this->input->post('insta_link'),
                        'status'                =>  $this->input->post('is_active'),
                        'image'                 =>  $new_name.'.'.$ext
                    ); 
                if($this->master_model->add_core_team($data)){
                   return  redirect('admin/master/core_team');
                }
            }
        }
    }
    
    public function edit_core_team(){
        $id = $this->uri->segment(4);
        $data['main_content'] = 'admin/master/edit_core_team';
        $data['title'] = 'Edit Core Team Member';
        $this->form_validation->set_rules('name', 'Name', 'required');
        $data['team'] = $this->master_model->get_core_team_id($id);
        if (empty($id))
        {
            show_404();
        }
        
        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('admin/template/template', $data);	
        }
        else
        {
            $core_team_id 	= 	$_POST['core_team_id'];
            if(!empty($_FILES["image"]["name"]))
            {
                $config['upload_path'] = './uploads/core_team';
                $config['allowed_types'] = 'gif|jpg|png|JPEG';
                $config['max_size'] = '10000';
                $new_name = time().mt_rand(100000, 999999);
                $ext =end((explode(".", $_FILES["image"]["name"])));
                $config['file_name'] = $new_name;
                $ext = end((explode(".", $_FILES["image"]["name"])));
                $config['file_name'] = $new_name;
                $this->load->library('upload', $config);
                if (! $this->upload->do_upload('image')){
                    $data['error'] = $this->upload->display_errors();
                    $this->load->view('admin/template/template', $data);
                }else{
                    $image              = 	$new_name.'.'.$ext;
                    $data = array(
                        'name'                  =>  $this->input->post('name'),
                        'designation'           =>  $this->input->post('designation'),
                        'details'               =>  $this->input->post('details'), 
                        'fb_link'               =>  $this->input->post('fb_link'),
                        'linkdin_link'          =>  $this->input->post('linkdin_link'),
                        'twitter_link'          =>  $this->input->post('twitter_link'),
                        'insta_link'            =>  $this->input->post('insta_link'),
                        'image'                 =>  $new_name.'.'.$ext
                    ); 
                    if($this->master_model->update_core_team($core_team_id,$data))
                    {
                            redirect('admin/master/core_team');
                    }else{
                            $this->load->view('admin/template/template', $data);
                    }
                }
            }else{
                 $data = array(
                        'name'                  =>  $this->input->post('name'),
                        'designation'           =>  $this->input->post('designation'),
                        'details'               =>  $this->input->post('details'), 
                        'fb_link'               =>  $this->input->post('fb_link'),
                        'linkdin_link'          =>  $this->input->post('linkdin_link'),
                        'twitter_link'          =>  $this->input->post('twitter_link'),
                        'insta_link'            =>  $this->input->post('insta_link')
                    ); 
                if($this->master_model->update_core_team($core_team_id,$data))
                {
                        redirect('admin/master/core_team');
                }else{
                        $this->load->view('admin/template/template', $data);
                }
            }
        }    
    }
    
     public function change_core_team_status($deal_item_id = false, $statusUpdate = true) {
        if (!$deal_item_id) {
            $this->session->set_flashdata('error_message', 'Please choose Team Member.');
            redirect('master/core_team', 'refresh');
        } else {
            $this->db->where(array(
                'id' => $deal_item_id
            ));
            $this->db->update('core_team', array(
                'status' => $statusUpdate
            ));
            $this->session->set_flashdata('succ_message', 'Team member status updated succssfully.');
            redirect('admin/master/core_team', 'refresh');
        }
    }
    
    public function delete_core_team()
    {
        $id = $this->uri->segment(4);
        if (empty($id))
        {
            show_404();
        }    
        $this->master_model->delete_core_team($id);        
        redirect( base_url() . 'admin/master/core_team');    
    }
    
    public function infrastructure(){
        $data['main_content'] = 'admin/master/infrastructure';
        $data['title'] = 'Infrastructure';	
        $data['infrastructures'] = $this->master_model->get_infrastructure();
        $this->load->view('admin//template/template', $data);
    }
    
    public function add_infrastructure(){
        $data['main_content'] = 'admin/master/add_infrastructure';
        $data['title'] = 'Add Infrastructure';
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');
        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('admin/template/template',$data);	
        }else{
            $config['upload_path'] = './uploads/infrastructure';
            $config['allowed_types'] = 'gif|jpg|png|JPEG';
            $config['max_size'] = '10000';
            $new_name = time().mt_rand(100000, 999999);
            $ext =end((explode(".", $_FILES["image"]["name"])));
            $config['file_name'] = $new_name;
            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload('image'))
            {
               $data['error'] = $this->upload->display_errors();
               $this->load->view('admin/template/template', $data);

            }else{ 
                  $data = array(
                        'title'                 =>  $this->input->post('title'),
                        'description'           =>  $this->input->post('description'),
                        'is_active'             =>  $this->input->post('is_active'),
                        'image'                 =>  $new_name.'.'.$ext
                    ); 
                if($this->master_model->add_infrastructure($data)){
                   return  redirect('admin/master/infrastructure');
                }
            }
        }
    }
    
    public function edit_infrastructure(){
        $id = $this->uri->segment(4);
        $data['main_content'] = 'admin/master/edit_infrastructure';
        $data['title'] = 'Edit Infrastructure';
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');
        $data['infrastructure'] = $this->master_model->get_infrastructure_id($id);
        if (empty($id))
        {
            show_404();
        }
        
        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('admin/template/template', $data);	
        }
        else
        {
            $infrastructure_id 	= 	$_POST['infrastructure_id'];
            if(!empty($_FILES["image"]["name"]))
            {
                $config['upload_path'] = './uploads/infrastructure';
                $config['allowed_types'] = 'gif|jpg|png|JPEG';
                $config['max_size'] = '10000';
                $new_name = time().mt_rand(100000, 999999);
                $ext =end((explode(".", $_FILES["image"]["name"])));
                $config['file_name'] = $new_name;
                $ext = end((explode(".", $_FILES["image"]["name"])));
                $config['file_name'] = $new_name;
                $this->load->library('upload', $config);
                if (! $this->upload->do_upload('image')){
                    $data['error'] = $this->upload->display_errors();
                    $this->load->view('admin/template/template', $data);
                }else{
                   $data = array(
                        'title'                 =>  $this->input->post('title'),
                        'description'           =>  $this->input->post('description'),
                        'is_active'             =>  $this->input->post('is_active'),
                        'image'                 =>  $new_name.'.'.$ext
                    );
                    if($this->master_model->update_infrastructure($infrastructure_id,$data))
                    {
                            redirect('admin/master/infrastructure');
                    }else{
                            $this->load->view('admin/template/template', $data);
                    }
                }
            }else{
                 $data = array(
                        'title'                 =>  $this->input->post('title'),
                        'description'           =>  $this->input->post('description'),
                        'is_active'             =>  $this->input->post('is_active')
                    );
                if($this->master_model->update_infrastructure($infrastructure_id,$data))
                {
                        redirect('admin/master/infrastructure');
                }else{
                        $this->load->view('admin/template/template', $data);
                }
            }
        }           
    }
    
    public function change_infrastructure_status($item_id = false, $statusUpdate = true) {
        if (!$item_id) {
            $this->session->set_flashdata('error_message', 'Please choose Infrastructure.');
            redirect('master/infrastructure', 'refresh');
        } else {
            $this->db->where(array(
                'id' => $item_id
            ));
            $this->db->update('infrastructure', array(
                'is_active' => $statusUpdate
            ));
            $this->session->set_flashdata('succ_message', 'Infrastructure status updated succssfully.');
            redirect('admin/master/infrastructure', 'refresh');
        }
    }
    
    public function delete_infrastructure()
    {
        $id = $this->uri->segment(4);
        if (empty($id))
        {
            show_404();
        }    
        $this->master_model->delete_infrastructure($id);        
        redirect( base_url() . 'admin/master/infrastructure');    
    }
    
    //Product
     public function product(){
        $data['main_content'] = 'admin/master/product';
        $data['title'] = 'Product';	
        $data['products'] = $this->master_model->get_product();
        $this->load->view('admin//template/template', $data);
     }
     
      public function change_product_status($product_id = false, $statusUpdate = true) {
        if (!$product_id) {
            $this->session->set_flashdata('error_message', 'Please choose product.');
            redirect('master/product', 'refresh');
        } else {
            $this->db->where(array(
                'id' => $product_id
            ));
            $this->db->update('product', array(
                'is_active' => $statusUpdate
            ));
            $this->session->set_flashdata('succ_message', 'Product status updated succssfully.');
            redirect('admin/master/product', 'refresh');
        }
    }
    
    public function add_product(){
        $data['main_content'] = 'admin/master/add_product';
        $data['title'] = 'Add Product';
        $this->form_validation->set_rules('product_name', 'Product Name', 'required');
        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('admin/template/template', $data);	
        }else{
            $config['upload_path'] = './uploads/product';
            $config['allowed_types'] = 'gif|jpg|png|JPEG';
            $config['max_size'] = '10000';
            $new_name = time().mt_rand(100000, 999999);
            $ext =end((explode(".", $_FILES["image"]["name"])));
            $config['file_name'] = $new_name;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (! $this->upload->do_upload('image')){
                    $data['error'] = $this->upload->display_errors();
                    $this->load->view('admin/template/template', $data);
            }else{
                  $fileData = $this->upload->data();
                   $image = $new_name . '.' . $ext;
                   $data = array(
                        'cat_id'             =>  $this->input->post('cat_id'),
                        'product_name'       =>  $this->input->post('product_name'),
                        'product_tag'        =>  $this->input->post('product_tag'),
                        'shape'              =>  $this->input->post('shape'),
                        'input_voltage'      =>  $this->input->post('voltage'),
                        'driver_efficiency'  =>  $this->input->post('efficiency'),
                        'surge_protection'   =>  $this->input->post('surge_protection'),
                        'lumens'             =>  $this->input->post('lumens'),
                        'meta_keyword'       =>  $this->input->post('meta_keyword'),
                        'meta_description'   =>  $this->input->post('meta_description'),
                        'is_active'          =>  $this->input->post('is_active'),
                        'image'              =>  $image
                    ); 
                 $insert_id = $this->master_model->add_product($data);
                 if(!empty($insert_id)){
                        $config['upload_path'] = './uploads/product_thumbnail';
                        $config['allowed_types'] = 'gif|jpg|png|JPEG';
                        $config['max_size'] = '10000';
                        $thumb_name = time() . mt_rand(100000, 999999);
                        $ext1 = end((explode(".", $_FILES["thumbnail"]["name"])));
                        $config['file_name'] = $thumb_name;
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        if (! $this->upload->do_upload('thumbnail')){
                            $this->session->set_flashdata('messg_thumb', 'Upload Product Thumbnail Image File not valid Please edit and upload again!');
                            redirect(base_url() . 'admin/master/product');
                        }else{
                             $fileData = $this->upload->data();
                             $thumb = $thumb_name . '.' . $ext1;
                             $this->master_model->update_thumb_product($insert_id,$thumb);
                        }
                        $wattage     = $this->input->post('wattage');
                        $color       = $this->input->post('color');

                        if(count($wattage!=0)){
                             foreach($wattage as $watt =>$wat){
                               $wattags = array(
                                   'product_id' =>  $insert_id,
                                   'wattage'    =>  $wat
                               );   
                               $this->master_model->product_wattage($wattags);

                             }
                         }
                   
                        if(count($color!=0)){
                            foreach($color as $coll =>$col){
                              $colors = array(
                                  'product_id' =>  $insert_id,
                                  'color'    =>  $col
                              );   
                              $this->master_model->product_color($colors);

                            }
                        }
                   return  redirect('admin/master/product');
                }
            }
        }
    }
    
    
    public function edit_product(){
        $id = $this->uri->segment(4);
        $data['main_content'] = 'admin/master/edit_product';
        $data['title'] = 'Edit Product';
        $data['products'] = $this->master_model->get_product_id($id);
        $data['product_wattage'] = $this->master_model->get_product_wattage($id);
        $data['product_color'] = $this->master_model->get_product_color($id);
        $this->form_validation->set_rules('product_name', 'Product Name', 'required');
        if (empty($id)) {
            show_404();
        }
        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('admin/template/template', $data);        
        }else {
            $id = $_POST['id'];
            
            $m = $_FILES['image']['name'];      
            $n = $_FILES['thumbnail']['name']; 
            if($m !== ""){
                $config['upload_path'] = './uploads/product';
                $config['allowed_types'] = 'gif|jpg|png|JPEG';
                $config['max_size'] = '10000';
                $image = time() . mt_rand(100000, 999999);
                $ext = end((explode(".", $_FILES["image"]["name"])));
                $config['file_name'] = $image;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if (! $this->upload->do_upload('image')){
                    $this->session->set_flashdata('messg_image', 'Upload Product Image File not valid Please edit and upload again!');
                    redirect(base_url() . 'admin/master/product');
                }else{
                     $fileData = $this->upload->data();
                     $image = $image . '.' . $ext;
                     $this->master_model->update_image_product($id,$image);
                }
            }
            
            if($n !== ""){
                $config['upload_path'] = './uploads/product_thumbnail';
                $config['allowed_types'] = 'gif|jpg|png|JPEG';
                $config['max_size'] = '10000';
                $thumbnail = time() . mt_rand(100000, 999999);
                $ext1 = end((explode(".", $_FILES["thumbnail"]["name"])));
                $config['file_name'] = $thumbnail;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if (! $this->upload->do_upload('thumbnail')){
                    $this->session->set_flashdata('messg_thumb', 'Upload Product Thumbnail Image File not valid Please edit and upload again!');
                    redirect(base_url() . 'admin/master/product');
                }else{
                     $fileData = $this->upload->data();
                     $thumb = $thumbnail . '.' . $ext1;
                     $this->master_model->update_thumb_product($id,$thumb);
                }
            }
            
            $wattages = $this->input->post('wattage');
           if(count($wattage!=0)){
                $this->db->delete('product_wattage', array(
                    'product_id' => $id
                ));

                foreach($wattages as $watt =>$wat){
                  $wattags = array(
                      'product_id' =>  $id,
                      'wattage'    =>  $wat
                  );   
                  $this->master_model->product_wattage($wattags);

                }
            }
            
            $colors = $this->input->post('color');
           if(count($colors!=0)){
                $this->db->delete('product_color', array(
                    'product_id' => $id
                ));

               foreach($colors as $coll =>$col){
                    $colors = array(
                        'product_id' =>  $id,
                        'color'    =>  $col
                    );   
                    $this->master_model->product_color($colors);
               }
            }
            
           $data = array(
                        'cat_id'             =>  $this->input->post('cat_id'),
                        'product_name'       =>  $this->input->post('product_name'),
						'product_tag'        =>  $this->input->post('product_tag'),
						'shape'              =>  $this->input->post('shape'),
                        'input_voltage'      =>  $this->input->post('voltage'),
                        'driver_efficiency'  =>  $this->input->post('efficiency'),
                        'surge_protection'   =>  $this->input->post('surge_protection'),
                        'lumens'             =>  $this->input->post('lumens'),
                        'meta_keyword'       =>  $this->input->post('meta_keyword'),
                        'meta_description'   =>  $this->input->post('meta_description'),
                        'is_active'          =>  $this->input->post('is_active')
                    ); 
            if($this->master_model->update_product($id,$data)){
                  return  redirect('admin/master/product');
            }
        }
    }
    
    
    public function delete_wattage($id){
        $this->master_model->delete_wattage($id);
        echo json_encode(array("status" => TRUE));  
    }
    
    public function delete_color($id){
        $this->master_model->delete_color($id);
        echo json_encode(array("status" => TRUE));  
    }
    
    public function delete_product()
    {
        $id = $this->uri->segment(4);
        if (empty($id))
        {
            show_404();
        }    
        $this->master_model->delete_product($id);        
        redirect( base_url() . 'admin/master/product');    
    }
    
    public function our_value_and_belief(){
        $data['main_content'] = 'admin/master/our_value_and_belief';
        $data['title'] = 'Our Values & Belief';	
        $data['beliefs'] = $this->master_model->get_belief();
        $this->load->view('admin//template/template', $data);
    }
    
     public function change_belief_status($id = false, $statusUpdate = true) {
        if (!$id) {
            $this->session->set_flashdata('error_message', 'Please choose our value and belief.');
            redirect('master/our_value_and_belief', 'refresh');
        } else {
            $this->db->where(array(
                'id' => $id
            ));
            $this->db->update('value_belif', array(
                'is_active' => $statusUpdate
            ));
            $this->session->set_flashdata('succ_message', 'Our value and belief status updated succssfully.');
            redirect('admin/master/our_value_and_belief', 'refresh');
        }
    }

    public function add_value_belif(){
        $data['main_content'] = 'admin/master/add_value_and_belief';
        $data['title'] = 'Add Our Value And Belief';
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('content', 'content', 'required');
        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('admin/template/template', $data);	
        }else{
             $data = array(
                        'title'          =>  $_POST['title'],
                        'content'        =>  $_POST['content'],
                        'is_active'      =>  $_POST['is_active']
                    ); 
            if($this->master_model->add_value_belif($data)){
               return  redirect('admin/master/our_value_and_belief');
            }
        }
    }

    
     public function edit_value_and_belief()
    {
        $id = $this->uri->segment(4);
        $data['main_content'] = 'admin/master/edit_value_and_belief';
        $data['title'] = 'Edit Our Value And Belief';
        $data['beliefs'] = $this->master_model->get_value_belief_id($id);
        $this->form_validation->set_rules('title', 'Title', 'required');
        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('admin/template/template', $data);	
        }else{
             $data = array(
                'title'          =>  $_POST['title'],
                'content'        =>  $_POST['content'],
                'is_active'      =>  $_POST['is_active']
            ); 
            if($this->master_model->update_value_belief($id,$data)){
               return  redirect('admin/master/our_value_and_belief');
            }
        }
    }
    
    public function delete_value_and_belief(){
        $id = $this->uri->segment(4);
        if (empty($id))
        {
            show_404();
        }   
        $this->master_model->delete_value_and_belief($id);        
        redirect( base_url() . 'admin/master/our_value_and_belief');    
    }
    
        //Client
     public function client(){
        $data['main_content'] = 'admin/master/client';
        $data['title'] = 'Client';
        $data['clients'] = $this->master_model->get_client();
        $this->load->view('admin//template/template', $data);
     }
     
     public function add_client(){
        $config['upload_path'] = './uploads/client';
        $config['allowed_types'] = 'gif|jpg|png|JPEG';
        $config['max_size'] = '10000';
        $new_name = time().mt_rand(100000, 999999);
        $ext =end((explode(".", $_FILES["image"]["name"])));
        $config['file_name'] = $new_name;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        $this->load->library('upload', $config);
        if (! $this->upload->do_upload('image')){
             $this->session->set_flashdata('messg', $this->upload->display_errors());
            return  redirect('admin/master/client');
        }else{
            $image              = 	$new_name.'.'.$ext;
            $data = array(
                    'image' => $image
             );
            if($this->master_model->add_client($data)){
                 return  redirect('admin/master/client');
            }
        }

     }
     
     public function delete_client(){
        $id = $this->uri->segment(4);
        if (empty($id))
        {
            show_404();
        }   
        $this->master_model->delete_client($id);        
        redirect( base_url() . 'admin/master/client');    
    }
    
}

?>

