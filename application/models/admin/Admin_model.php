<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model{

	public function get_user_detail(){
		$id = $this->session->userdata('id');
		$query = $this->db->get_where('users', array('id' => $id));
		return $result = $query->row_array();
	}
	//--------------------------------------------------------------------
	public function update_user($data){
		$id = $this->session->userdata('id');
		$this->db->where('id', $id);
		$this->db->update('users', $data);
		return true;
	}
	//--------------------------------------------------------------------
	public function change_pwd($data, $id){
		$this->db->where('id', $id);
		$this->db->update('users', $data);
		return true;
	}
	//-----------------------------------------------------
	function get_admin_roles()
	{
		$this->db->from('users_roles');
		$this->db->where('status',1);
		//Added by ManhVT to support display
		$this->db->where('id > ',$this->session->userdata('role_id') - 1);
		$query=$this->db->get();
		return $query->result_array();
	}

	//-----------------------------------------------------
	function get_admin_by_id($id)
	{
		$this->db->select('users.*,users_roles.title, users_roles.status');
		$this->db->from('users');
		$this->db->join('users_roles','users_roles.id=users.user_role_id');
		$this->db->where('users.id',$id);
		$query=$this->db->get();
		return $query->row_array();
	}

	function get_admin_by_uuid($uuid)
	{
		$this->db->select('users.*,users_roles.title, users_roles.status');
		$this->db->from('users');
		$this->db->join('users_roles','users_roles.id=users.user_role_id');
		$this->db->where('users.user_uuid',$uuid);
		$query=$this->db->get();
		return $query->row_array();
	}

	//-----------------------------------------------------
	function get_all()
	{
		$this->db->select('users.*,users_roles.title, users_roles.status');
		$this->db->from('users');

		$this->db->join('users_roles','users_roles.id=users.user_role_id');
		
		//echo $this->session->userdata('filter_type');
		if($this->session->userdata('filter_type')!='')
			$this->db->where('users.user_role_id',$this->session->userdata('filter_type'));

		if($this->session->userdata('filter_status')!='')
			$this->db->where('users.is_active',$this->session->userdata('filter_status'));

		$filterData = $this->session->userdata('filter_keyword');
		$this->db->group_start();
		$this->db->like('users_roles.title',$filterData);
		$this->db->or_like('users.firstname',$filterData);
		$this->db->or_like('users.lastname',$filterData);
		$this->db->or_like('users.email',$filterData);
		$this->db->or_like('users.mobile_no',$filterData);
		$this->db->or_like('users.username',$filterData);
		$this->db->group_end();
		$this->db->where('users.is_supper', 0);

		$this->db->order_by('users.id','desc');

		$query = $this->db->get();

		$users = array();

		if ($query->num_rows() > 0) 
		{
			$users = $query->result_array();
		}

		return $users;
	}

	//-----------------------------------------------------
public function add_admin($data){
	$this->db->insert('users', $data);
	return true;
}

	//---------------------------------------------------
	// Edit Admin Record
public function edit_admin($data, $id){
	$this->db->where('id', $id);
	return $this->db->update('users', $data);
	//return true;
}

	//-----------------------------------------------------
function change_status()
{		
	$this->db->set('is_active',$this->input->post('status'));
	$this->db->where('id',$this->input->post('id'));
	$this->db->update('users');
} 

	//-----------------------------------------------------
function delete($id)
{		
	$this->db->where('id',$id);
	$this->db->delete('users');
} 

}

?>
