<?php

Class Master_model extends CI_Model {

    public function get_all_blog($limit,$offset){
				$this->db->limit($limit,$offset);	
        $query = $this->db->get('blog');
        return $query->result_array(); 
    }
	
	 public function get_num_blog(){
        $query = $this->db->get('blog');
        return $query->num_rows(); 
    }

    public function add_blog($data){
         $this->db->insert('blog',$data);
        return true;
    }
	
    public function get_blog_id($id){
           $this->db->where('id',$id);
           $query = $this->db->get('blog');
          return $query->row_array();  
    }
    
    public function update_blog($id,$data){
        $this->db->where('id', $id);
        return $this->db->update('blog', $data);
    }
    
    public function delete_blog($id){
        $this->db->where('id', $id);
        return  $this->db->delete('blog');
    }
	
	public function search_result($search,$limit,$offset){
				  $this->db->like('title',$search);
				  $this->db->limit($limit,$offset);	
		 $query = $this->db->get('blog');
		 return $query->result_array();  
	}
	 
		
	public function get_num_serach_blog($search){
				$this->db->like('title',$search);
		$query = $this->db->get('blog');
        return $query->num_rows(); 
	}
  	
    
}

?>
