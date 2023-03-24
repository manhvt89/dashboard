<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Assessment_model extends CI_Model{

	public function delete_the_area($id)
	{
		$this->db->trans_start();

		//working here
		$this->db->delete('area', array('id' => $id));

		//Get all categories of the area
		$categories = $this->get_category_by_area($id);
		$category_ids = array();
		if(!empty($categories))
		{
			foreach($categories as $key=>$cate)
			{
				$category_ids[] = $cate['id'];
			}
		}

		$this->db->where_in('id',$category_ids);
		$this->db->delete('category');

		$this->db->where_in('category_id',$category_ids);
		$this->db->delete('question');

		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE)
		{
			return false;
		} else {
			return true;
		}
	}

	public function delete_the_category($id)
	{
		$this->db->trans_start();

		//working here
		
		$this->db->where('id',$id);
		$this->db->delete('category');

		$this->db->where('category_id',$id);
		$this->db->delete('question');

		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE)
		{
			return false;
		} else {
			return true;
		}
	}

	public function delete_the_question($id)
	{
		$this->db->trans_start();

		//working here
		
		$this->db->where('id',$id);

		$this->db->delete('question');

		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE)
		{
			return false;
		} else {
			return true;
		}
	}



	public function get_areas($id, $status='')
	{
		$this->db->from('area');
		//echo $this->session->userdata('filter_type');
		if($status!='')
			$this->db->where('area.status',$status);
		if($id!='')
			$this->db->where('area.form_id',$id);	

		$this->db->order_by('area.orderby','asc');

		$query = $this->db->get();

		$records = array();

		if ($query->num_rows() > 0) 
		{
			$records = $query->result_array();
		}
		return $records;
	}

	public function get_forms($status = '')
	{
		$this->db->from('form');
		//echo $this->session->userdata('filter_type');
		if($status!='')
		{
			$this->db->where('form.status',$status);
		} else {
			$this->db->where('form.status > ',-1);
		}
		$this->db->where('form.deleted',0);
	
		$this->db->order_by('form.id','desc');

		$query = $this->db->get();

		$records = array();

		if ($query->num_rows() > 0) 
		{
			$records = $query->result_array();
		}
		return $records;

	}

	public function get_the_form($id='')
	{
		if($id == '')
		{
			return null;
		} 
		$query = $this->db->get_where('form', array('id' => $id));
		return $query->row_array();
	}

	public function get_the_area($id='')
	{
		if($id == '')
		{
			return null;
		} 
		$query = $this->db->get_where('area', array('id' => $id));
		return $query->row_array();
	}

	public function get_the_area_by_form($id='',$form_id='')
	{
		if($id == '' || $form_id == '')
		{
			return null;
		}
		$this->db->select('area.*');
		$this->db->from('area');
		$this->db->where(array('area.id' => $id,'form_id'=>$form_id));
		$query = $this->db->get();
		return $query->row_array();
	}

	public function add_area($data)
	{
		$this->db->insert('area', $data);
		return $this->db->insert_id();
	}

	public function update_area($data,$id)
	{
		$this->db->where('id', $id);
		return $this->db->update('area', $data);
	}
	
	public function get_category_by_area($area_id='')
	{
		$this->db->from('category');
		//echo $this->session->userdata('filter_type');
		if($area_id!='')
			$this->db->where('category.area_id',$area_id);

		$this->db->order_by('category.orderby','asc');

		$query = $this->db->get();

		$records = array();

		if ($query->num_rows() > 0) 
		{
			$records = $query->result_array();
		}
		return $records;
	}

	public function get_the_category($id=0)
	{
		if($id == '')
		{
			return null;
		} 
		$query = $this->db->get_where('category', array('id' => $id));
		return $query->row_array();
	}

	public function add_category($data)
	{
		$this->db->insert('category', $data);
		return $this->db->insert_id();
	}
	public function update_category($data,$id)
	{
		$this->db->where('id', $id);
		return $this->db->update('category', $data);
	}

	public function get_questions_by_category($category_id)
	{
		$this->db->from('question');
		//echo $this->session->userdata('filter_type');
		if($category_id!='')
			$this->db->where('question.category_id',$category_id);

		$this->db->order_by('question.orderby','asc');

		$query = $this->db->get();

		$records = array();

		if ($query->num_rows() > 0) 
		{
			$records = $query->result_array();
		}
		return $records;
	}

	//Get list of criterias by question via question ID
	// there are five criterias for each a question. 
	public function get_criterias_by_question($question_id)
	{
		$this->db->from('question_detail');
		if($question_id!='')
			$this->db->where('question_detail.question_id',$question_id);

		$this->db->order_by('question_detail.orderby','asc');

		$query = $this->db->get();

		$records = array();

		if ($query->num_rows() > 0) 
		{
			$records = $query->result_array();
		}
		return $records;
	}

	// Lây danh sách câu hỏi-câu trả lời
	public function get_questions_result_by_category($category_id)
	{
		$this->db->select('question.*, result.id as result_id, result.score, result.content as result_content');
		$this->db->from('question');
		$this->db->join('result',('result.question_id = question.id'),'left');
		//echo $this->session->userdata('filter_type');
		if($category_id!='')
			$this->db->where('question.category_id',$category_id);

		$this->db->order_by('question.orderby','asc');

		$query = $this->db->get();

		$records = array();

		if ($query->num_rows() > 0) 
		{
			$records = $query->result_array();
		}
		return $records;
	}

	public function add_criteria($data)
	{
		$this->db->insert('question_detail', $data);
		return $this->db->insert_id();
	}

	public function get_the_criteria($id = '')
	{
		# code...
		if($id == '')
		{
			return null;
		} 
		$query = $this->db->get_where('question_detail', array('id' => $id));
		return $query->row_array();
	}

	public function edit_criteria($data,$id)
	{
		$this->db->where('id', $id);
		return $this->db->update('question_detail', $data);
	}

	public function get_photo_best_practice_by_question($question_id)
	{
		$this->db->select('photo_assessment.*');
		$this->db->from('photo_assessment');
		$this->db->where('type',1); //best pracitce
		$this->db->where('question_id',$question_id);
		$this->db->order_by('photo_assessment.id','desc');
		$query = $this->db->get();

		$records = array();

		if ($query->num_rows() > 0) 
		{
			$records = $query->result_array();
		}
		return $records;
	}

	public function get_photo_finding_by_question($question_id)
	{
		$this->db->select('photo_assessment.*');
		$this->db->from('photo_assessment');
		$this->db->where('type',2); //finding
		$this->db->where('question_id',$question_id); //finding
		$this->db->order_by('photo_assessment.id','desc');
		$query = $this->db->get();

		$records = array();

		if ($query->num_rows() > 0) 
		{
			$records = $query->result_array();
		}
		return $records;
	}

	public function get_best_photos_by_area($area_id)
	{
		$this->db->select('photo_assessment.*');
		$this->db->from('photo_assessment');
		$this->db->where('type',1); //Best photos
		$this->db->where('area_id',$area_id); //Best photos
		$this->db->order_by('photo_assessment.id','desc');
		$query = $this->db->get();

		$records = array();

		if ($query->num_rows() > 0) 
		{
			$records = $query->result_array();
		}
		return $records;
	}

	public function get_finding_photos_by_area($area_id)
	{
		$this->db->select('photo_assessment.*');
		$this->db->from('photo_assessment');
		$this->db->where('type',2); //finding
		$this->db->where('area_id',$area_id);
		$this->db->order_by('photo_assessment.id','desc');
		$query = $this->db->get();

		$records = array();

		if ($query->num_rows() > 0) 
		{
			$records = $query->result_array();
		}
		return $records;
	}

	public function save_upload(
						$image,
						$_question_id,
						$_area_id,
						$_campaign_id,
						$_creator_id,
						$_type
						)
	{
		$data = array(
			'question_id'=>$_question_id,
			'area_id'=>$_area_id,
			'campaign_id'=>$_campaign_id,
			'creator_id'=>$_creator_id,
			'type'=>$_type,
			'updator_id'=>0,
			'created_date'=>time(),
			'path'=>$image
		);
		$this->db->insert('photo_assessment', $data);
		return $this->db->insert_id();
	}

	public function add_question($data)
	{
		$this->db->insert('question', $data);
		return $this->db->insert_id();
	}

	public function update_question($data,$id)
	{
		$this->db->where('id', $id);
		return $this->db->update('question', $data);
	}

	public function get_the_question($id = '')
	{
		# code...
		if($id == '')
		{
			return null;
		} 
		$query = $this->db->get_where('question', array('id' => $id));
		return $query->row_array();
	}

	public function add_form($data)
	{
		$this->db->insert('form', $data);
		return $this->db->insert_id();
	}

	public function update_form($data,$id)
	{
		$this->db->where('id', $id);
		return $this->db->update('form', $data);
	}

	public function delete_the_form($data)
	{
		if($data['status'] < 3)
		{
			$data['deleted'] = 1;
			$this->db->where('id', $data['id']);
			return $this->db->update('form', $data);
		} else {
			return 0;
		}
	}

	public function get_the_categories_by_form($form)
	{
		if(!empty($form))
		{
			$this->db->select('category.*');
			$this->db->from('category');
			$this->db->join('area','category.area_id = area.id','left');
			$this->db->where('area.form_id',$form['id']);

			$this->db->order_by('area.orderby','asc');

			$query = $this->db->get();

			$records = array();

			if ($query->num_rows() > 0) 
			{
				$records = $query->result_array();
			}
			return $records;
		} else {
			return null;
		}
	}

	public function get_the_areas_by_form($form)
	{
		if(!empty($form))
		{
			$this->db->select('area.*');
			$this->db->from('area');

			$this->db->where('area.form_id',$form['id']);

			$this->db->order_by('area.orderby','asc');

			$query = $this->db->get();

			$records = array();

			if ($query->num_rows() > 0) 
			{
				$records = $query->result_array();
			}
			return $records;
		} else {
			return null;
		}
	}

	public function get_the_questions_by_form($form)
	{
		if(!empty($form))
		{
			$this->db->select('question.*');
			$this->db->from('question');
			$this->db->join('category','question.category_id = category.id','left');
			$this->db->join('area','category.area_id = area.id','left');
			$this->db->where('area.form_id',$form['id']);

			$this->db->order_by('area.orderby','asc');

			$query = $this->db->get();

			$records = array();

			if ($query->num_rows() > 0) 
			{
				$records = $query->result_array();
			}
			return $records;
		} else {
			return null;
		}
	}

	public function get_the_criterias_by_form($form)
	{
		if(!empty($form))
		{
			$this->db->select('question_detail.*');
			$this->db->from('question_detail');
			$this->db->where('question_detail.form_id',$form['id']);
			$this->db->order_by('question_detail.orderby','asc');

			$query = $this->db->get();

			$records = array();

			if ($query->num_rows() > 0) 
			{
				$records = $query->result_array();
			}
			return $records;
		} else {
			return null;
		}
	}

	public function lock_form($form)
	{
		$status = 3;
		//get all categor of the form
		$areas = $this->get_the_areas_by_form($form);
		$data_areas = array();
		foreach($areas as $area)
		{
			$tmp['id'] = $area['id'];
			if($area['status'] ==1)
			{
				$tmp['status'] = $status;
				$data_areas[] = $tmp;
			}
		}

		$this->db->reset_query();

		$categories = $this->get_the_categories_by_form($form);
		$data_categories = array();
		foreach($categories as $category)
		{
			$tmp['id'] = $category['id'];
			if($category['status'] ==1)
			{
				$tmp['status'] = $status;
				$data_categories[] = $tmp;
			}
		}


		$this->db->reset_query();

		$questions = $this->get_the_questions_by_form($form);
		$data_questions = array();
		foreach($questions as $question)
		{
			$tmp['id'] = $question['id'];
			if($question['status'] ==1)
			{
				$tmp['status'] = $status;
				$data_questions[] = $tmp;
			}
		}

		$this->db->trans_start();

		//working here

		$form['status'] = $status;
		$this->db->where('id', $form['id']);
		$this->db->update('form', $form);
		if(!empty($data_areas))
		{
		$this->db->update_batch('area',$data_areas,'id');
		}
		if(!empty($data_categories))
		{
			$this->db->update_batch('category',$data_categories,'id');
		}
		if(!empty($data_questions))
		{
			$this->db->update_batch('question',$data_questions,'id');
		}
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE)
		{
			return false;
		} else {
			return true;
		}
	}

	public function copy_form($form)
	{
		$areas = $this->get_the_areas_by_form($form);
		$data_areas = array();
		

		$this->db->reset_query();

		$categories = $this->get_the_categories_by_form($form);
		$data_categories = array();
		
		$this->db->reset_query();

		$questions = $this->get_the_questions_by_form($form);
		$data_questions = array();

		$criterias = $this->get_the_criterias_by_form($form);
		$data_criterias = array();

		foreach($questions as $question)
		{
			$arrTmpQuestionGroup = array();
			foreach($criterias as $key=>$criteria)
			{
				if($criteria['question_id'] == $question['id'])
				{
					unset($criteria['id']); // Bỏ ID
					$arrTmpQuestionGroup[] = $criteria;
					unset($criterias[$key]);
				}
			}
			$question['criterias'] = $arrTmpQuestionGroup;
			$data_questions[] = $question;
		}

		foreach($categories as $categorie)
		{
			$arrTmpQuestionGroup = array();
			foreach($data_questions as $key=>$question)
			{
				if($question['category_id'] == $categorie['id'])
				{
					unset($question['id']); // Bỏ ID
					$arrTmpQuestionGroup[] = $question;
					unset($data_questions[$key]);
				}
			}
			$categorie['questions'] = $arrTmpQuestionGroup;
			$data_categories[] = $categorie;
		}
		
		foreach($areas as $area)
		{
			$area_id = $area['id'];
			$arrTmpCategoriesGroup = array();
			foreach($data_categories as $key=>$categorie)
			{
				if($categorie['area_id'] == $area_id)
				{
					unset($categorie['id']); // Bỏ ID
					$arrTmpCategoriesGroup[] = $categorie;
					unset($data_categories[$key]);
				}
			}
			$area['categories'] = $arrTmpCategoriesGroup;
			$data_areas[] = $area;
		}
		
		$this->db->trans_start();
		$time = time();
		unset($form['id']);
		$form['name'] = 'Copy of '.$form['name'];
		$form['status'] = 1;
		$form['created_date'] = $time;
		$this->db->insert('form',$form);
		$form_id = $this->db->insert_id();

		foreach($data_areas as $key=>$area)
		{
			$area['status'] = 1;
			$area['created_date'] = $time;
			$area['form_id'] = $form_id;
			$_categories = $area['categories'];
			unset($area['categories']);
			unset($area['id']);
			$this->db->insert('area',$area);
			$area_id = $this->db->insert_id();
			foreach($_categories as $key=>$category)
			{
				$category['status'] = 1;
				$category['created_date'] = $time;
				$category['area_id'] = $area_id;
				$_questions = $category['questions'];
				unset($category['questions']);
				$this->db->insert('category',$category);
				$category_id = $this->db->insert_id();
				foreach($_questions as $key=>$question)
				{
					$question['status'] = 1;
					$question['created_date'] = $time;
					$question['category_id'] = $category_id;
					$_criterias = $question['criterias'];
					unset($question['criterias']);					
					$this->db->insert('question',$question);
					$question_id = $this->db->insert_id();
					foreach($_criterias as $key=>$criteria)
					{
						$criteria['question_id'] = $question_id;
						$criteria['form_id '] = $form_id;
						$criteria['area_id '] = $area_id;
						$criteria['category_id '] = $category_id;
						$this->db->insert('question_detail',$criteria);
						$criteria_id = $this->db->insert_id();
					}
				}
			}
		}

		//working here

		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE)
		{
			return false;
		} else {
			return true;
		}
	}
	
	/////////////////////////////////////
	

	//-----------------------------------------------------
	function get_all_users($filter_keyword='', $type='')
	{

		$this->db->from('ci_admin');

		$this->db->join('ci_admin_roles','ci_admin_roles.admin_role_id=ci_admin.admin_role_id');
		//echo $this->session->userdata('filter_type');
		if($type!='')
			$this->db->where('ci_admin.admin_role_id',$type);

		
		$filterData = $filter_keyword;//$this->session->userdata('filter_keyword');
		$this->db->group_start();
		$this->db->like('ci_admin.firstname',$filterData);
		$this->db->or_like('ci_admin.lastname',$filterData);
		$this->db->or_like('ci_admin.email',$filterData);
		$this->db->or_like('ci_admin.mobile_no',$filterData);
		$this->db->or_like('ci_admin.username',$filterData);
		$this->db->group_end();
		$this->db->order_by('ci_admin.admin_id','desc');

		$query = $this->db->get();

		$module = array();

		if ($query->num_rows() > 0) 
		{
			$module = $query->result_array();
		}

		return $module;
	}

	public function get_parent($user){
		if(!empty($user))
		{
			$ref = $user['ref'];
			//var_dump($ref);
			$query = $this->db->get_where('ci_admin', array('ref_code' => $ref));
			return $query->row_array();
		}
		return null;
	}

	
	

}

?>
