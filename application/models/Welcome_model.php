<?php 
Class Welcome_model extends CI_Model{
	
	public function get_all_employee(){
				 $this->db->join('category','employees.category=category.cat_id','left');
		$query = $this->db->get('employees');

		return $query->result_array();
	}
	
	public function get_category(){
		$query = $this->db->get('category');
		return $query->result_array();
	}
	
	public function add_employee($data){
		$this->db->insert('employees',$data);
		return true;
	}
	
	public function delete_employee($id){
		$this->db->where('id',$id);
		$this->db->delete('employees');
		return true;
	}
	
	public function update_employee($id,$data){
		$this->db->where('id',$id);
		$this->db->update('employees',$data);
		return true;
	}
}

?>