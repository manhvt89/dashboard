<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Company_model extends CI_Model{

	
	public function get_the_company($id = 0)
	{
		# code...
		if($id == 0) return null;
		$query = $this->db->get_where('ci_companies', array('id' => $id));
		return $result = $query->row_array();
	}

	public function get_users_company($id)
	{
		$query = $this->db->get_where('user_company', array('company_id' => $id));
		return $query->result_array();
	}
	
	public function get_users_by_company($id)
	{
		$this->db->select('ci_admin.*, user_company.type');
		$this->db->from('ci_admin');
		$this->db->join('user_company','user_company.user_id = ci_admin.admin_id','left');
		$this->db->where('user_company.company_id',$id);
		$query = $this->db->get();
		return $query->result_array();
	}
	// Cập nhật, để giúp người tạo doanh nghiệp phân quyền leader và member vào doanh nghiệp
	public function add_company($data)
	{
		//$this->db->trans_start();
		$this->db->insert('ci_companies', $data);
		$company_id = $this->db->insert_id();
		// $ld['user_id'] = $leader;
		// $ld['company_id'] = $company_id;
		// $ld['type'] = 1; //leader
		// $ld['created_date'] = time(); //
		// $this->db->insert('user_company', $ld);
		// if(!empty($members))
		// {
		// 	foreach($members as $key=>$value)
		// 	{
		// 		$mb['user_id'] = $value;
		// 		$mb['company_id'] = $company_id;
		// 		$mb['type'] = 0; //member
		// 		$mb['created_date'] = time(); //
		// 		$this->db->insert('user_company', $mb);
		// 	}
			
		// }
		// $this->db->trans_complete();

		// if ($this->db->trans_status() === FALSE)
		// {
		// 		// generate an error... or use the log_message() function to log your error
		// } else {
		// 	return $company_id;
		// }
		return $company_id;
	}

	public function delete_member($id)
	{

	}

	public function edit_company($data, $id)
	{
		
		//1. Lấy toàn bộ thành viên của doanh nghiệp ($id doanh nghiệp)
		$this->db->where('id', $id);
		return	$this->db->update('ci_companies', $data);
	}

	public function update_company($data,$id)
	{
		$this->db->where('id', $id);
		return $this->db->update('ci_companies', $data);
	}

	public function get_all_company($start,$length,$role="")
	{
		$this->db->select('ci_companies.*, COUNT(campaign.id) as count_campaign');
		$this->db->from('ci_companies');
		
		$this->db->join('campaign','campaign.company_id = ci_companies.id AND campaign.deleted = 0','left');
		if($role!="")
		{
			if($role == 6){
				$this->db->join('user_company','user_company.company_id = ci_companies.id','left');
				$this->db->where('user_company.type',1);
				$this->db->where('user_company.user_id',$this->session->userdata('admin_id'));
			}
			
		}
		$this->db->group_by('ci_companies.id');
		$this->db->order_by('ci_companies.id','desc');
		$this->db->limit($length,$start);
		$query = $this->db->get();
		$records = array();
		if ($query->num_rows() > 0) 
		{
			$records = $query->result_array();
		}
		return $records;
	}

	public function get_states()
	{
		$this->db->select('ci_states.*');
		$this->db->from('ci_states');
		$this->db->order_by('ci_states.name','asc');

		$query = $this->db->get();

		$records = array();

		if ($query->num_rows() > 0) 
		{
			$records = $query->result_array();
		}
		return $records;
	}

	public function get_cities()
	{
		$this->db->select('ci_cities.*');
		$this->db->from('ci_cities');
		$this->db->order_by('ci_cities.name','asc');

		$query = $this->db->get();

		$records = array();

		if ($query->num_rows() > 0) 
		{
			$records = $query->result_array();
		}
		return $records;
	}

	public function get_wards()
	{
		$this->db->select('ci_wards.*');
		$this->db->from('ci_wards');
		$this->db->order_by('ci_wards.name','asc');

		$query = $this->db->get();

		$records = array();

		if ($query->num_rows() > 0) 
		{
			$records = $query->result_array();
		}
		return $records;
	}

	public function get_fields($status='')
	{
		$this->db->select('company_field.*');
		$this->db->from('company_field');
		if($status != '')
			$this->db->where('status',$status);
		$this->db->order_by('company_field.name','asc');

		$query = $this->db->get();

		$records = array();

		if ($query->num_rows() > 0) 
		{
			$records = $query->result_array();
		}
		return $records;
	}

	public function get_specialists($status='')
	{
		$this->db->select('ci_admin.admin_id as id, CONCAT(ci_admin.username,"|",ci_admin.firstname, " ", ci_admin.lastname) as name');
		$this->db->from('ci_admin');
		if($status != '')
			$this->db->where('is_active',$status);
		$this->db->where('admin_role_id',6);
		$this->db->or_where('admin_role_id',2);	
		$this->db->order_by('ci_admin.firstname','asc');

		$query = $this->db->get();

		$records = array();

		if ($query->num_rows() > 0) 
		{
			$records = $query->result_array();
		}
		return $records;
	}

	public function get_forms()
	{
		$this->db->select('form.*');
		$this->db->from('form');
		$this->db->where('status',3); // đã được duyệt, và khóa, ko cho phép chỉnh sửa form;
		$this->db->order_by('form.name','asc');
		$query = $this->db->get();
		$records = array();

		if ($query->num_rows() > 0) 
		{
			$records = $query->result_array();
		}
		//var_dump($records);
		return $records;
	}


	//////////////////////////////
}

?>
