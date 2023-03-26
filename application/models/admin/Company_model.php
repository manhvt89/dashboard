<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Company_model extends CI_Model{

	
	public function get_the_company($id = 0)
	{
		# code...
		if($id == 0) return null;
		$query = $this->db->get_where('companies', array('id' => $id));
		return $query->row_array();
	}

	public function get_the_company_by_uuid($uuid = 0)
	{
		# code...
		if($uuid == 0) return null;
		$query = $this->db->get_where('companies', array('company_uuid' => $uuid));
		return $query->row_array();
	}
	/*
	Lây thông tin chi tiết của công ty, gồm cả thông tin người dùng chủ sở hữu
	*/
	public function get_the_company_info($uuid = 0)
	{
		if($uuid == 0) return null;
		$this->db->select('companies.*, users.type, users.firstname, users.lastname, users.email, users.user_uuid');
		$this->db->from('companies');
		$this->db->join('users','companies.owner_id = users.id','left');
		$this->db->where('company_uuid',$uuid);
		$query = $this->db->get();
		return $query->row_array();
	}

	public function get_users_company($id)
	{
		$query = $this->db->get_where('user_company', array('company_id' => $id));
		return $query->result_array();
	}
	
	// Lấy danh sách người dùng thuộc công ty, không bảo gồm người dùng sở hữu;
	public function get_users_by_company($id)
	{
		$this->db->select('users.*, users_companies.type');
		$this->db->from('users');
		$this->db->join('users_companies','users_companies.user_id = users.id','left');
		$this->db->where('users_companies.id',$id);
		$query = $this->db->get();
		return $query->result_array();
	}

	// Cập nhật, để giúp người tạo doanh nghiệp phân quyền leader và member vào doanh nghiệp
	public function add_company($data)
	{
		//$this->db->trans_start();
		$this->db->insert('companies', $data);
		$company_id = $this->db->insert_id();
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
		$this->db->select('c.*, COUNT(b.id) as count_branches');
		$this->db->from('companies as c');
		
		$this->db->join('companies as b','b.parent_id = c.id AND b.deleted = 0','left');
		if($role!="")
		{
			if($role == 6){
				$this->db->join('user_company','user_company.company_id = ci_companies.id','left');
				$this->db->where('user_company.type',1);
				$this->db->where('user_company.user_id',$this->session->userdata('admin_id'));
			}
			
		}
		$this->db->where('c.parent_id',0);
		$this->db->group_by('c.id');
		$this->db->order_by('c.id','desc');
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
		$this->db->select('states.*');
		$this->db->from('states');
		$this->db->order_by('states.name','asc');

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
		$this->db->select('cities.*');
		$this->db->from('cities');
		$this->db->order_by('cities.name','asc');

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
		$this->db->select('wards.*');
		$this->db->from('wards');
		$this->db->order_by('wards.name','asc');

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
		
		$records = array();

		
		return $records;
	}

	public function get_specialists($status='')
	{
		$this->db->select('users.id, CONCAT(users.username,"|",users.firstname, " ", users.lastname) as name');
		$this->db->from('users');
		if($status != '')
			$this->db->where('is_active',$status);
		$this->db->where('user_role_id',6);
		$this->db->or_where('id',2);	
		$this->db->order_by('users.firstname','asc');

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
