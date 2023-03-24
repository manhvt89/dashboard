<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Campaign_model extends CI_Model{

	
	public function get_the_campaign(int $id = 0)
	{
		# code...
		if($id == 0) return null;
		$query = $this->db->get_where('campaign', array('id' => $id));
		return $result = $query->row_array();
	}

	public function delete_the_campaign($data)
	{
		if(!empty($data))
		{
			$this->db->trans_start();
			$data['deleted'] = 1;
			$this->db->where('id', $data['id']);
			$this->db->update('campaign', $data);

			$form['deleted'] = 1;
			$this->db->where('id', $data['form_id']);
			$this->db->update('form', $form);
			$this->db->trans_complete();

			if ($this->db->trans_status() === FALSE)
			{
				return 0;
			} else {
				return 1;
			}
		} else {
			return 0;
		}
	}

	/*
		Cập nhật, để giúp người tạo doanh nghiệp phân quyền leader và member vào cuộc đánh giá
	*/
	public function add_campaign($data, $leader, $members)
	{
		$this->db->trans_start();

		$this->db->insert('campaign', $data);
		$return = $this->db->insert_id();
		//cập nhật form sang trạng thái 4: đang sử dụng
		$_data = array('status'=>4);
		$this->db->where('id', $data['form_id']);
		$this->db->update('form', $_data);

		$ld['user_id'] = $leader;
		$ld['campaign_id'] = $return;
		$ld['type'] = 1; //leader
		$ld['created_date'] = time(); //
		$this->db->insert('user_campaign', $ld);
		if(!empty($members))
		{
			foreach($members as $key=>$value)
			{
				$mb['user_id'] = $value;
				$mb['campaign_id'] = $return;
				$mb['type'] = 0; //member
				$mb['created_date'] = time(); //
				$this->db->insert('user_campaign', $mb);
			}
			
		}

		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE)
		{
			return false;
		} else {
			return $return;
		}
	}

	public function update_campaign($data,$id)
	{
		$this->db->where('id', $id);
		return $this->db->update('campaign', $data);
	}

	public function get_all_campaign($start,$length,$role='')
	{
		$this->db->select('campaign.*, ci_companies.name as company_name');
		$this->db->from('campaign');
		$this->db->join('ci_companies','campaign.company_id = ci_companies.id','left');
		if($role!="")
		{
			if($role == 6){
				$this->db->join('user_campaign','user_campaign.campaign_id = campaign.id','left');
				//$this->db->where('user_company.type',1);
				$this->db->where('user_campaign.user_id',$this->session->userdata('admin_id'));
			}
			
		}
		$this->db->where('deleted',0);
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

	public function get_campaign($id="")
	{
		if($id == 0) return null;
		$select = 'campaign.*, ci_companies.name as company_name, ci_companies.address as company_address, ci_companies.state_id as company_state_id, ';
		$select = $select . 'ci_companies.city_id as company_city_id, ci_companies.wards_id as company_wards_id, ci_companies.tel, ci_companies.fax, ci_companies.authorized,';
		$select = $select . ' ci_companies.designation, ci_companies.product';
		$this->db->select($select);
		$this->db->from('campaign');
		$this->db->join('ci_companies','campaign.company_id = ci_companies.id','left');
		$this->db->where('campaign.id', $id);
		$query = $this->db->get();
		return $query->row_array();
	}
	
	public function get_role_of_member_on_campaign($user_id,$campaign_id)
	{
		$this->db->select('user_campaign.*');
		$this->db->from('user_campaign');
		$this->db->where('campaign_id', $campaign_id);
		$this->db->where('user_id', $user_id);
		$query = $this->db->get();
		return $query->row_array();
	}

	public function get_users_by_campaign($id)
	{
		$this->db->select('ci_admin.*, user_campaign.type');
		$this->db->from('ci_admin');
		$this->db->join('user_campaign','user_campaign.user_id = ci_admin.admin_id','left');
		$this->db->where('user_campaign.campaign_id',$id);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function has_the_campaign($campaign_id)
	{
		if($this->session->userdata('admin_role_id') == 6)
		{
			$this->db->select('user_campaign.*');
			$this->db->from('user_campaign');
			$this->db->where('campaign_id', $campaign_id);
			$this->db->where('user_id', $this->session->userdata('admin_id'));
			$query = $this->db->get();

			$records = false;

			if ($query->num_rows() > 0) 
			{
				$records = true;
			}
			return $records;
		} else {
			return true;
		}
	}

	public function update_status($id,$status)
	{
		$data = array('status'=>$status);
		return $this->update_campaign($data,$id);
		
	}

	//Lây các khu vực với tổng câu hỏi và tổng điểm
	public function get_areas_with_result($campaign_id, $form_id, $status='')
	{
		if($form_id == '' || $campaign_id == '')
		{
			return null;
		}
		$this->db->select('area.*,COUNT(result.id) AS count_result, COALESCE(sum(result.score),0) as total_score');
		$this->db->from('area');
		$this->db->join('result',('result.area_id = area.id AND result.campaign_id = '.$campaign_id),'left');
		$this->db->group_by('area.id');
		$this->db->where(array('form_id'=>$form_id));
		$this->db->order_by('area.orderby','asc');
		if($status != '')
			$this->db->where(array('status' => $status));
		$query = $this->db->get();

		$records = array();

		if ($query->num_rows() > 0) 
		{
			$records = $query->result_array();
		}
		return $records;
	}

	public function get_area_with_best_practices($campaign_id, $form_id)
	{
		$this->db->select('area.*, best_practices.id as best_practices_id, best_practices.content as best_practices_content');
		$this->db->from('area');
		$this->db->join('best_practices',('best_practices.area_id = area.id AND best_practices.campaign_id ='.$campaign_id),'left');
		$this->db->where(array('form_id'=>$form_id));
		$this->db->order_by('area.orderby','asc');
		$query = $this->db->get();

		$records = array();

		if ($query->num_rows() > 0) 
		{
			$records = $query->result_array();
		}
		return $records;
	}
	public function get_area_with_assessment_findings($campaign_id, $form_id)
	{
		$this->db->select('area.*, assessment_findings.id as assessment_findings_id, assessment_findings.content as assessment_findings_content');
		$this->db->from('area');
		$this->db->join('assessment_findings',('assessment_findings.area_id = area.id AND assessment_findings.campaign_id ='.$campaign_id),'left');
		$this->db->where(array('form_id'=>$form_id));
		$this->db->order_by('area.orderby','asc');
		$query = $this->db->get();

		$records = array();

		if ($query->num_rows() > 0) 
		{
			$records = $query->result_array();
		}
		return $records;
	}

	public function add_best_practices($data)
	{
		$this->db->insert('best_practices', $data);
		return $this->db->insert_id();
	}

	public function add_assessment_findings($data)
	{
		$this->db->insert('assessment_findings', $data);
		return $this->db->insert_id();
	}

	public function edit_assessment_findings($data,$id)
	{
		$this->db->where('id', $id);
		return $this->db->update('assessment_findings', $data);
	}

	public function edit_best_practices($data,$id)
	{
		$this->db->where('id', $id);
		return $this->db->update('best_practices', $data);
	}

	public function get_the_best_practices($id=0,$campaign_id=0)
	{
		# code...
		if($id == 0) return null;
		$query = $this->db->get_where('best_practices', array('id' => $id,'campaign_id'=>$campaign_id));
		return $result = $query->row_array();
	}

	public function get_the_assessment_findings($id=0,$campaign_id=0)
	{
		# code...
		if($id == 0) return null;
		$query = $this->db->get_where('assessment_findings', array('id' => $id,'campaign_id'=>$campaign_id));
		return $result = $query->row_array();
	}

	//////////////////////////////
}

?>
