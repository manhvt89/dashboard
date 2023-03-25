<?php
class Admin_roles_model extends CI_Model{
   
   	public function __construct()
	{
		parent::__construct();
	}

	//-----------------------------------------------------
	function get_role_by_id($id)
    {
		$this->db->from('users_roles');
		$this->db->where('id',$id);
		$query=$this->db->get();
		return $query->row_array();
    }

	function get_role_by_uuid($uuid)
    {
		$this->db->from('users_roles');
		$this->db->where('user_role_uuid',$uuid);
		$query=$this->db->get();
		return $query->row_array();
    }

	//-----------------------------------------------------
	function get_all()
    {
		$this->db->from('users_roles');
		$query = $this->db->get();
        return $query->result_array();
    }
	
	//-----------------------------------------------------
	function insert()
	{		
		$this->db->set('title',$this->input->post('admin_role_title'));
		$this->db->set('status',$this->input->post('admin_role_status'));
		$this->db->set('created_on',date('Y-m-d h:i:sa'));
		$this->db->insert('users_roles');
	}
	 
	//-----------------------------------------------------
	function update()
	{		
		$this->db->set('title',$this->input->post('admin_role_title'));
		$this->db->set('status',$this->input->post('admin_role_status'));
		$this->db->set('modified_on',date('Y-m-d h:i:sa'));
		$this->db->where('id',$this->input->post('admin_role_id'));
		$this->db->update('users_roles');
	} 
	
	//-----------------------------------------------------
	function change_status()
	{		
		$this->db->set('status',$this->input->post('status'));
		$this->db->where('id',$this->input->post('id'));
		$this->db->update('users_roles');
	} 
	
	//-----------------------------------------------------
	function delete($id)
	{		
		$this->db->where('admin_role_id',$id);
		$this->db->delete('users_roles');
	} 
	
	//-----------------------------------------------------
	function get_modules()
    {
		$this->db->from('modules');
		$this->db->order_by('sort_order','asc');
		$query=$this->db->get();
		return $query->result_array();
    }
    
	//-----------------------------------------------------
	function set_access()
	{
		if($this->input->post('status')==1)
		{
			$this->db->set('user_role_id',$this->input->post('admin_role_id'));
			$this->db->set('module',$this->input->post('module'));
			$this->db->set('operation',$this->input->post('operation'));
			$this->db->insert('modules_accesses');
		}
		else
		{
			$this->db->where('user_role_id',$this->input->post('admin_role_id'));
			$this->db->where('module',$this->input->post('module'));
			$this->db->where('operation',$this->input->post('operation'));
			$this->db->delete('modules_accesses');
		}
	} 
	//-----------------------------------------------------
	function get_access($user_role_id)
	{
		$this->db->from('modules_accesses');
		$this->db->where('user_role_id',$user_role_id);
		$query=$this->db->get();
		$data=array();
		foreach($query->result_array() as $v)
		{
			$data[]=$v['module'].'/'.$v['operation'];
		}
		return $data;
	} 	

	/* SIDE MENU & SUB MENU */

	//-----------------------------------------------------
	function get_all_module()
    {
		$this->db->select('modules.*');
		$this->db->order_by('sort_order','asc');
		$query = $this->db->get('modules');
        return $query->result_array();
    }

    //-----------------------------------------------------
	function add_module($data)
    {
		$this->db->insert('modules', $data);
		return $this->db->insert_id();
    }

    //---------------------------------------------------
	// Edit Module
	public function edit_module($data, $id){
		$this->db->where('id', $id);
		$this->db->update('modules', $data);
		return true;
	}

	//-----------------------------------------------------
	function delete_module($id)
	{		
		$this->db->where('id',$id);
		$this->db->delete('modules');
	} 

	//-----------------------------------------------------
	function get_module_by_id($id)
    {
		$this->db->from('modules');
		$this->db->where('id',$id);
		$query=$this->db->get();
		return $query->row_array();
    }

	function get_module_by_uuid($uuid)
    {
		$this->db->from('modules');
		$this->db->where('module_uuid',$uuid);
		$query=$this->db->get();
		return $query->row_array();
    }

    /*------------------------------
		Sub Module / Sub Menu  
	------------------------------*/

	//-----------------------------------------------------
	function add_sub_module($data)
    {
		$this->db->insert('sub_modules',$data);
		return $this->db->insert_id();
    } 

	//-----------------------------------------------------
	function get_sub_module_by_id($id)
    {
		$this->db->from('sub_modules');
		$this->db->where('id',$id);
		$query=$this->db->get();
		return $query->row_array();
    } 	

	//-----------------------------------------------------
	function get_sub_module_by_module($id)
    {
		$this->db->select('*');
		$this->db->where('parent_id',$id);
		$this->db->order_by('sort_order','asc');
		$query = $this->db->get('sub_modules');
		return $query->result_array();
    }

    //----------------------------------------------------
    function edit_sub_module($data, $id)
    {
    	$this->db->where('id', $id);
		$this->db->update('sub_modules', $data);
		return true;
    }

    //-----------------------------------------------------
	function delete_sub_module($id)
	{		
		$this->db->where('id',$id);
		$this->db->delete('sub_modules');
		return true;
	} 

}
?>