<?php
Class Dashboard_model extends CI_Model
{

    public function admin_login($username,$password)
    {
        $this->db->where('username', $username);
        $this->db->where('password', $password);
        $query = $this->db->get('master_admin'); 
        return $query;  
    }

        // Change Password
    public function check_oldpassword($id,$password){
            $this->db->where('id', $id);
            $this->db->where('password',md5($password));
            $this->db->from('master_admin');
            $query = $this->db->get();
            if($query->num_rows() > 0)
            {
                    return $row = $query->row();
            }
            else{
                   return false;
            }          
	}
	
    public function save_new_password($id,$data){
            $this->db->where('id', $id);
            $this->db->update('master_admin',$data);
	}
	
}    
?>
