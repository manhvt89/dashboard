<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Assessment extends MY_Controller
{
    function __construct(){

        parent::__construct();
        auth_check(); // check login auth
        $this->rbac->check_module_access();

		$this->load->model('admin/admin_model', 'admin');
		$this->load->model('admin/Activity_model', 'activity_model');
		$this->load->model('admin/Assessment_model', 'assessment_model');
    }

	//-----------------------------------------------------		
	function index_($id=''){
		if($this->input->post('submit')){

			$this->form_validation->set_rules('area_name', 'area_name', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
				$data = array(
					'errors' => validation_errors()
				);
				$this->session->set_flashdata('errors', $data['errors']);
				redirect(base_url('admin/assessment/index'),'refresh');
			}
			else{
				$id = $this->input->post('id');
				$data = array(
					'name' => $this->input->post('area_name'),
					'status' => $this->input->post('area_status'),
					'orderby' => $this->input->post('area_order'),
					'created_date' => time(),
					'updated_date' => 0,
				);
				$data = $this->security->xss_clean($data);
				if($id == 0)
				{
					$result = $this->assessment_model->add_area($data);
				} else {
					$result = $this->assessment_model->update_area($data,$id);
				}
				if($result){

					// Activity Log 
					$this->activity_model->add_log(4);

					$this->session->set_flashdata('success', 'Admin has been added successfully!');
					redirect(base_url('admin/assessment/index'),'refresh');
				}
			}

			redirect(base_url('admin/assessment/index'),'refresh');
		}

		
			$arrAreas = $this->assessment_model->get_forms($id);
			$theForm = array();
			$data['title'] = 'Form manage';
			$data['records'] = $arrAreas;
			
			$theArea = null;
			$data['id'] = 0;			 
			$data['theRecord'] = $theArea;
			$this->load->view('admin/includes/_header');
			$this->load->view('admin/assessment/form', $data);
			$this->load->view('admin/includes/_footer');

		
		
	}

	function index($id = '')
	{
		if($this->input->post('submit')){

			$this->form_validation->set_rules('form_name', 'form_name', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
				$data = array(
					'errors' => validation_errors()
				);
				$this->session->set_flashdata('errors', $data['errors']);
				redirect(base_url('admin/assessment/index'),'refresh');
			}
			else{
				$id = $this->input->post('id');
				$data = array(
					'name' => $this->input->post('form_name'),
					'status' => $this->input->post('form_status')=='on'?'1':'0',
					//'orderby' => $this->input->post('area_order'),
					'created_date' => time(),
					'updated_date' => 0,
				);
				$data = $this->security->xss_clean($data);
				if($id == 0)
				{
					$result = $this->assessment_model->add_form($data);
				} else {
					$result = $this->assessment_model->update_form($data,$id);
				}
				if($result){

					// Activity Log 
					$this->activity_model->add_log(4);

					$this->session->set_flashdata('success', 'Admin has been added successfully!');
					redirect(base_url('admin/assessment/index'),'refresh');
				}
			}

			redirect(base_url('admin/assessment/index'),'refresh');
		}

			$arrForms = $this->assessment_model->get_forms();
			$theForm = array();
			$data['title'] = 'Form manage';
			$data['records'] = $arrForms;
			
			if($id == '')
			{
				$theForm = null;
				$data['id'] = 0;
			} else {
				$theForm = $this->assessment_model->get_the_form($id);
				if($theForm['status']==3)
				{
					$theForm = null;
					$data['id'] = 0;
				} else {
					$data['id'] = $id;
				}
			}
			$data['theRecord'] = $theForm;
			$this->load->view('admin/includes/_header');
			$this->load->view('admin/assessment/index', $data);
			$this->load->view('admin/includes/_footer');
		
	}

	function form($assessment_id='',$area_id='')
	{
		
		if($assessment_id == '')
		{
			redirect('admin/assessment');
		} else {
			if($this->input->post('submit')){
				//echo $assessment_id; die();
				$this->form_validation->set_rules('area_name', 'area_name', 'trim|required');
				if ($this->form_validation->run() == FALSE) {
					$data = array(
						'errors' => validation_errors()
					);
					$this->session->set_flashdata('errors', $data['errors']);
					redirect(base_url('admin/assessment/form/'.$assessment_id),'refresh');
				}
				else{
					$id = $this->input->post('id');
					$data = array(
						'name' => $this->input->post('area_name'),
						'status' => $this->input->post('area_status')=='on'?'1':'0',
						'orderby' => $this->input->post('area_order'),
						'form_id'=>$assessment_id,
						'created_date' => time(),
						'updated_date' => 0,
					);
					//var_dump($data); die();
					$data = $this->security->xss_clean($data);
					if($id == 0)
					{
						$result = $this->assessment_model->add_area($data);
					} else {
						$result = $this->assessment_model->update_area($data,$id);
					}
					//var_dump($result);die();
					if($result){	
						// Activity Log 
						$this->activity_model->add_log(4);
	
						$this->session->set_flashdata('success', 'Admin has been added successfully!');
						redirect(base_url('admin/assessment/form/'.$assessment_id),'refresh');
					}
				}
	
				redirect(base_url('admin/assessment/form/'.$assessment_id),'refresh');
			}
			$arrForm = $this->assessment_model->get_the_form($assessment_id);
			if($arrForm == null)
			{
				redirect(base_url('admin/assessment/'),'refresh');
			} 
			elseif($arrForm['status'] > 2) // 3 or 4
			{
				redirect(base_url('admin/assessment/previewform/'.$assessment_id),'refresh');
			}
			$arrAreas = $this->assessment_model->get_areas($assessment_id);
			$theArea = array();
			$data['title'] = 'Form manage';
			$data['records'] = $arrAreas;
			$data['status_form'] = $arrForm['status'];
			
			if($area_id == '')
			{
				$theArea = null;
				$data['area_id'] = 0;
			} else {
				$theArea = $this->assessment_model->get_the_area($area_id);
				$data['area_id'] = $area_id;
			}
			$data['assessment_id'] = $assessment_id;
			$data['theRecord'] = $theArea;
			$this->load->view('admin/includes/_header');
			$this->load->view('admin/assessment/assessment', $data);
			$this->load->view('admin/includes/_footer');
		}
	}

	function delete_area()
	{
		$id = $this->input->post('id');
		if($id=='')
		{
			$result = 1;
		} else{
			$theArea = $this->assessment_model->get_the_area($id); //Lấy khu thông tin khu vực.
			if(($theArea['status'] < 3))
			{
				if($this->assessment_model->delete_the_area($id))
				{
					$result = 0;
				} else {
					$result = 1;
				}

			} else {
				$result = 1;
			}
		}

		echo json_encode(array('result'=>$result));
	}

	function delete_category()
	{
		$id = $this->input->post('id');
		if($id=='')
		{
			$result = 1;
		} else{
			$theCategory = $this->assessment_model->get_the_category($id);
			if(($theCategory['status'] < 3))
			{
				if($this->assessment_model->delete_the_category($id))
				{
					$result = 0;
				} else {
					$result = 1;
				}

			} else {
				$result = 1;
			}
		}

		echo json_encode(array('result'=>$result));
	}

	function delete_question()
	{
		$id = $this->input->post('id');
		if($id=='')
		{
			$result = 1;
		} else{
			$theQuestion = $this->assessment_model->get_the_question($id); //Lấy khu thông tin khu vực.
			if(($theQuestion['status'] < 3))
			{
				if($this->assessment_model->delete_the_question($id))
				{
					$result = 0;
				} else {
					$result = 1;
				}

			} else {
				$result = 1;
			}
		}

		echo json_encode(array('result'=>$result));
	}
	/*
	* Start 01. disable y ManhVT 04,Feb,2022
	*/
	/*
	function area($id='')
	{
		if($id == '')
		{
			$theArea = null;
			$data['id'] = 0;
		} else {
			$theArea = $this->assessment_model->get_the_area($id);
			$data['id'] = $id;
			
			$theForm = $this->assessment_model->get_the_form($theArea['form_id']);
			if(empty($theForm))
			{
				redirect(base_url('admin/assessment/'),'refresh');
			}
			if($theForm['status'] > 2)
			{
				redirect(base_url('admin/assessment/previewform/'.$theForm['id']),'refresh');
			}
			
			$categories = $this->assessment_model->get_category_by_area($id);
			$cates = array();
			foreach($categories as $category)
			{
				$category['questions'] = $this->assessment_model->get_questions_by_category($category['id']);
				$cates[] = $category;
			}

			

			$data['categories'] = $cates;
			$data['theArea'] = $theArea;
			$data['status_form'] = $theForm['status'];
			//
			if($category_id =='')
			//{
			//	$data['category_id'] = 0;
			//	$data['theCategory'] = null;
			//} else{
			//	$data['category_id'] = $category_id;
			//	$data['theCategory'] = $this->assessment_model->get_the_category($category_id);
			//}

			//if($question_id == '')
			//{
			//	$data['question_id'] = 0;
			//} else {
			//	$data['question_id'] = $question_id;
			//	$data['theQuestion'] = $this->assessment_model->get_the_question()($question_id);
			//}
			//
		}

		$data['theArea'] = $theArea;
		$this->load->view('admin/includes/_header');
		$this->load->view('admin/assessment/viewarea', $data);
		$this->load->view('admin/includes/_footer');
	}

	*/
	/*
	* End 01
	*/

	function area($id='')
	{
		if($id == '')
		{
			$theArea = null;
			$data['id'] = 0;
		} else {
			$theArea = $this->assessment_model->get_the_area($id);
			if(!empty($theArea))
			{
				$data['id'] = $id;
				$categories = $this->assessment_model->get_category_by_area($id);
				$cates = array();
				foreach($categories as $category)
				{
					$questions = $this->assessment_model->get_questions_by_category($category['id']);
					$quests = array();
					foreach($questions as $key=>$question)
					{
						$criterias = $this->assessment_model->get_criterias_by_question($question['id']);
						$question['criterias'] = $criterias;
						$quests[] = $question;
						
					}
					//var_dump($quests);
					$category['questions'] = $quests;
					$cates[] = $category;
				}

				$data['categories'] = $cates;
				$data['theArea'] = $theArea;
			} else{
				$theArea = null;
				$data['id'] = 0;
			}
		}

		$data['theArea'] = $theArea;
		$this->load->view('admin/includes/_header');
		$this->load->view('admin/assessment/viewarea', $data);
		$this->load->view('admin/includes/_footer');
	}

	function add_question_detail()
	{
		$question_id = $this->input->post('question_id');
		$range = $this->input->post('range');
		$name = $this->input->post('name');
		$content = $this->input->post('content');
		$order = $this->input->post('order');
		//$question_detail_max = $this->input->post('question_detail_max');
		$question = $this->assessment_model->get_the_question($question_id);
		//$arrTmp = explode('.',$content);
		//$order = $arrTmp[0];
		if(!empty($question))
		{
			$name = $order;
			$data = array(
				'question_id'=>$question_id,
				'form_id'=>$question['form_id'],
				'category_id'=>$question['category_id'],
				'area_id'=>$question['area_id'],
				'name'=>$name,
				'content'=>$content,
				'percent'=>$range,
				'orderby'=>$order,
				'max_grade'=>$order
			);
			/* tạm thời ko sử dụng 
			$data = array(
				'question_id'=>$question_id,
				'form_id'=>$question['form_id'],
				'category_id'=>$question['category_id'],
				'area_id'=>$question['area_id'],
				'name'=>$name,
				'content'=>$content,
				'percent'=>$range,
				'orderby'=>$order,
				'max_grade'=>$question_detail_max,
			);
			*/

			$rr = $this->assessment_model->add_criteria($data);
			$rs = array(
				'result'=>0
			);
			echo json_encode($rs);
		} else{
			$rs = array(
				'result'=>1
			);
			echo json_encode($rs);
		}
	}

	function save_question_detail()
	{
		$criteria_id = $this->input->post('criteria_id');
		$range = $this->input->post('range');		
		$content = $this->input->post('content');
		
		//$question_detail_max = $this->input->post('question_detail_max');
		$criteria = $this->assessment_model->get_the_criteria($criteria_id);
		//$arrTmp = explode('.',$content);
		//$order = $arrTmp[0];
		if(!empty($criteria))
		{
			$data = array(
				'content'=>$content,
				'percent'=>$range,
			);
			
			$rr = $this->assessment_model->edit_criteria($data,$criteria_id);
			$rs = array(
				'result'=>0
			);
			echo json_encode($rs);
		} else{
			$rs = array(
				'result'=>0
			);
			echo json_encode($rs);
		}
	}

	function add_category()
	{
		if($this->input->post('submit')){

			$area_id = $this->input->post('area_id');

			$this->form_validation->set_rules('category_name', 'category_name', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
				$data = array(
					'errors' => validation_errors()
				);
				$this->session->set_flashdata('errors', $data['errors']);
				redirect(base_url('admin/assessment/area/'.$area_id),'refresh');
			}
			else{

				$area = $this->assessment_model->get_the_area($area_id);
				
				$data = array(
					'name' => $this->input->post('category_name'),
					'status' => $this->input->post('category_status'),
					'orderby' => $this->input->post('category_order'),
					'area_id'=>$area_id,
					'form_id'=>$area['form_id'],
					'created_date' => time(),
					'updated_date' => 0,
				);
				$data = $this->security->xss_clean($data);
				$result = $this->assessment_model->add_category($data);
				
				if($result){

					// Activity Log 
					$this->activity_model->add_log(4);

					$this->session->set_flashdata('success', trans('add_category_successfull'));
					redirect(base_url('admin/assessment/area/'.$area_id),'refresh');
				}
			}
		}
	}

	function update_category()
	{
		$id = $this->input->post('id');
		$data = array(
			'name'=>$this->input->post('name')
		);
		$this->assessment_model->update_category($data,$id);
		$rs = array(
			'result'=>0
		);
		echo json_encode($rs);
	}

	function add_question()
	{
		$category_id = $this->input->post('id');
		$name = $this->input->post('name');
		$content = $this->input->post('content');
		$order = $this->input->post('order');

		$category = $this->assessment_model->get_the_category($category_id);
		if(!empty($category))
		{
			$data = array(
				'name'=>$name,
				'content'=>$content,
				'category_id'=>$category_id,
				'form_id'=>$category['form_id'],
				'area_id'=>$category['area_id'],
				'orderby'=>$order,
				'status'=>1,
				'created_date'=>time(),
				'updated_date'=>0
			);

			$result = $this->assessment_model->add_question($data);
			if($result)
			{
				$rs = array(
					'result'=>0
				);
			} else {
				$rs = array(
					'result'=>1
				);
			}	
		} else {
			$rs = array(
				'result'=>2
			);
		}
		echo json_encode($rs);

	}

	function update_question()
	{
		$id = $this->input->post('id');
		$data = array(
			'name'=>$this->input->post('name'),
			'content'=>$this->input->post('content'),
			'orderby'=>$this->input->post('order'),
			'updated_date'=>time()
		);
		$this->assessment_model->update_question($data,$id);
		$rs = array(
			'result'=>0
		);
		echo json_encode($rs);
	}

	function previewform($id='')
	{
		if($id=='')
			$id =1;
		$form = $this->assessment_model->get_the_form($id);
		$areas = $this->assessment_model->get_areas($id);
		$arrAreas = array();
		foreach($areas  as $area)
		{
			$categories = $this->assessment_model->get_category_by_area($area['id']);
			$arrCategories = array();
			foreach($categories as $category)
			{
				//$category['questions'] = $this->assessment_model->get_questions_by_category($category['id']);
				//$arrCategories[] = $category;

				$questions = $this->assessment_model->get_questions_by_category($category['id']);
				$quests = array();
				foreach($questions as $key=>$question)
				{
					$criterias = $this->assessment_model->get_criterias_by_question($question['id']);
					$question['criterias'] = $criterias;
					$quests[] = $question;
					
				}
				//var_dump($quests);
				$category['questions'] = $quests;
				$arrCategories[] = $category;
			}
			$area['categories'] = $arrCategories;
			$arrAreas[] = $area;
		}
		$data['theRecords'] = $arrAreas;
		$data['form'] = $form;
		//var_dump($arrAreas); die();
		$this->load->view('admin/includes/_header');
		$this->load->view('admin/assessment/pewviewform', $data);
		$this->load->view('admin/includes/_footer');

	}

	function lock_form()
	{
		$id = $this->input->post('id');
		if($id == '')
		{
			redirect(base_url('admin/assessment/previewform/'.$id),'refresh');
		} else {
			$form = $this->assessment_model->get_the_form($id);
			if(!empty($form))
			{
				$this->assessment_model->lock_form($form);
				redirect(base_url('admin/assessment/previewform/'.$id),'refresh');
			} else {
				redirect(base_url('admin/assessment/previewform/'.$id),'refresh');
			}
		}

	}

	function copy_form($id='')
	{
		if($id == '')
		{
			redirect(base_url('admin/assessment/index/'),'refresh');
		} else {
			$form = $this->assessment_model->get_the_form($id);
			if(!empty($form))
			{
				$this->assessment_model->copy_form($form);
				redirect(base_url('admin/assessment/index/'),'refresh');
			} else {
				redirect(base_url('admin/assessment/index/'),'refresh');
			}
		}
	}

	function delete_form()
	{
		$id = $this->input->post('id');
		if($id=='')
		{
			$result = 1;
		} else{
			$theForm = $this->assessment_model->get_the_form($id);
			if(($theForm['status'] < 3))
			{
				
				if($this->assessment_model->delete_the_form($theForm)) // chuyển trạng thái status = -1;
				{
					$result = 0;
				} else {
					$result = 1;
				}
				//$result = 0;
			} else {
				$result = 1;
			}
		}

		echo json_encode(array('result'=>$result));
	}
	//---------------------------------------------------------
	function filterdata(){

		$this->session->set_userdata('filter_type',$this->input->post('type'));
		$this->session->set_userdata('filter_status',$this->input->post('status'));
		$this->session->set_userdata('filter_keyword',$this->input->post('keyword'));
	}

	//--------------------------------------------------		
	function list_data(){

		$data['info'] = $this->admin->get_all();
		$this->load->view('admin/admin/list',$data);
	}

	//-----------------------------------------------------------
	function change_status(){

		$this->rbac->check_operation_access(); // check opration permission

		$this->admin->change_status();
	}
	
	//--------------------------------------------------
	function add(){

		$this->rbac->check_operation_access(); // check opration permission

		//$data['admin_roles'] = $this->admin->get_admin_roles();
		$admin_roles = $this->admin->get_admin_roles();
		if(!$this->session->userdata('is_supper'))
		{
			foreach($admin_roles as $admin_role)
			{
				if($admin_role['admin_role_id'] != 1)
				{
					$data['admin_roles'][] = $admin_role;
				}
			}
			//var_dump($data['admin_roles']);
		} else {
			$data['admin_roles'] = $admin_roles;
		}

		if($this->input->post('submit')){
				$this->form_validation->set_rules('username', 'Username', 'trim|alpha_numeric|is_unique[ci_admin.username]|required');
				$this->form_validation->set_rules('firstname', 'Firstname', 'trim|required');
				$this->form_validation->set_rules('lastname', 'Lastname', 'trim|required');
				$this->form_validation->set_rules('email', 'Email', 'trim|valid_email|required');
				$this->form_validation->set_rules('mobile_no', 'Number', 'trim|required');
				$this->form_validation->set_rules('password', 'Password', 'trim|required');
				$this->form_validation->set_rules('role', 'Role', 'trim|required');
				if ($this->form_validation->run() == FALSE) {
					$data = array(
						'errors' => validation_errors()
					);
					$this->session->set_flashdata('errors', $data['errors']);
					redirect(base_url('admin/admin/add'),'refresh');
				}
				else{
					$data = array(
						'admin_role_id' => $this->input->post('role'),
						'username' => $this->input->post('username'),
						'firstname' => $this->input->post('firstname'),
						'lastname' => $this->input->post('lastname'),
						'email' => $this->input->post('email'),
						'mobile_no' => $this->input->post('mobile_no'),
						'password' =>  password_hash($this->input->post('password'), PASSWORD_BCRYPT),
						'is_active' => 1,
						'created_at' => date('Y-m-d : h:m:s'),
						'updated_at' => date('Y-m-d : h:m:s'),
					);
					$data = $this->security->xss_clean($data);
					$result = $this->admin->add_admin($data);
					if($result){

						// Activity Log 
						$this->activity_model->add_log(4);

						$this->session->set_flashdata('success', 'Admin has been added successfully!');
						redirect(base_url('admin/admin'));
					}
				}
			}
			else
			{
				$this->load->view('admin/includes/_header', $data);
        		$this->load->view('admin/admin/add');
        		$this->load->view('admin/includes/_footer');
			}
	}

	//--------------------------------------------------
	function edit($id=""){

		$this->rbac->check_operation_access(); // check opration permission

		$data['admin_roles'] = $this->admin->get_admin_roles();

		if($this->input->post('submit')){
			$this->form_validation->set_rules('username', 'Username', 'trim|alpha_numeric|required');
			$this->form_validation->set_rules('firstname', 'Firstname', 'trim|required');
			$this->form_validation->set_rules('lastname', 'Lastname', 'trim|required');
			$this->form_validation->set_rules('email', 'Email', 'trim|valid_email|required');
			$this->form_validation->set_rules('mobile_no', 'Number', 'trim|required');
			$this->form_validation->set_rules('password', 'Password', 'trim|min_length[5]');
			$this->form_validation->set_rules('role', 'Role', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
				$data = array(
					'errors' => validation_errors()
				);
				$this->session->set_flashdata('errors', $data['errors']);
				redirect(base_url('admin/admin/edit/'.$id),'refresh');
			}
			else{
				$data = array(
					'admin_role_id' => $this->input->post('role'),
					'username' => $this->input->post('username'),
					'firstname' => $this->input->post('firstname'),
					'lastname' => $this->input->post('lastname'),
					'email' => $this->input->post('email'),
					'mobile_no' => $this->input->post('mobile_no'),
					'is_active' => 1,
					'updated_at' => date('Y-m-d : h:m:s'),
				);

				if($this->input->post('password') != '')
				$data['password'] = password_hash($this->input->post('password'), PASSWORD_BCRYPT);

				$data = $this->security->xss_clean($data);
				$result = $this->admin->edit_admin($data, $id);

				if($result){
					// Activity Log 
					$this->activity_model->add_log(5);

					$this->session->set_flashdata('success', 'Admin has been updated successfully!');
					redirect(base_url('admin/admin'));
				}
			}
		}
		elseif($id==""){
			redirect('admin/admin');
		}
		else{
			$data['admin'] = $this->admin->get_admin_by_id($id);
			
			$this->load->view('admin/includes/_header');
			$this->load->view('admin/admin/edit', $data);
			$this->load->view('admin/includes/_footer');
		}		
	}

	//--------------------------------------------------
	function check_username($id=0){

		$this->db->from('admin');
		$this->db->where('username', $this->input->post('username'));
		$this->db->where('admin_id !='.$id);
		$query=$this->db->get();
		if($query->num_rows() >0)
			echo 'false';
		else 
	    	echo 'true';
    }

    //------------------------------------------------------------
	function delete($id=''){
	   
		$this->rbac->check_operation_access(); // check opration permission

		$this->admin->delete($id);

		// Activity Log 
		$this->activity_model->add_log(6);

		$this->session->set_flashdata('success','User has been Deleted Successfully.');	
		redirect('admin/admin');
	}
	
}

?>
