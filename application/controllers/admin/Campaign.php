<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Campaign extends MY_Controller
{
    private $user_id = 0;
	
	function __construct(){

        parent::__construct();
        auth_check(); // check login auth
        $this->rbac->check_module_access();

		$this->load->model('admin/admin_model', 'admin');
		$this->load->model('admin/Activity_model', 'activity_model');
		$this->load->model('admin/Company_model', 'company_model');
		$this->load->model('admin/Campaign_model', 'campaign_model');
		$this->load->model('admin/Assessment_model', 'assessment_model');
		$this->user_id = $this->session->userdata('admin_id');
    }



	function create_evaluation($id="") //id of company
	{
		$this->rbac->check_operation_access(); // check opration permission
		
		if($id == "")
		{
			$data['errors'] = trans('without_company_id');
			$this->session->set_flashdata('errors', $data['errors']);
			redirect(base_url('admin/campaign'),'refresh');
			return 0;
		}
		if(!$this->company_model->get_the_company($id))
		{
			$data['errors'] = trans('without_company_id');
			$this->session->set_flashdata('errors', $data['errors']);
			redirect(base_url('admin/campaign'),'refresh');
			return 0;
		}

		$data['company_id'] = $id;

		$Arrforms = $this->company_model->get_forms();
		//var_dump($Arrforms);
		$forms = array();
		foreach($Arrforms as $form)
		{
			$t = array(
				'id'=>$form['id'],
				'text'=>$form['name']
			);
			$forms[] = $t;
		}

		$data['forms'] = json_encode($forms);

		$ArrUsers = $this->company_model->get_specialists(1);
		$users = array();
		foreach($ArrUsers as $user)
		{
			$t = array(
				'id'=>$user['id'],
				'text'=>$user['name']
			);
			$users[] = $t;
		}
		$data['users'] = json_encode($users);

		
		$this->load->view('admin/includes/_header');
		$this->load->view('admin/campaign/create',$data);
		$this->load->view('admin/includes/_footer');
		
	}

	function save($id="")
	{
		if($id == "") // create new
		{
			$company_id = $this->input->post('company_id');
			if($this->input->post('submit')){
				$this->form_validation->set_rules('campaign_name', trans('campaign_name_field'), 'trim|required|xss_clean|strip_tags');
				$this->form_validation->set_rules('assessment_date', trans('assessment_date_field'), 'trim|required|xss_clean|strip_tags');
				$this->form_validation->set_rules('assessment_criteria', trans('assessment_criteria_field'), 'trim|required|xss_clean|strip_tags');
				$this->form_validation->set_rules('assessment_type', trans('assessment_type_field'), 'trim|required');
				$this->form_validation->set_rules('assessment_modelity', trans('assessment_modelity_field'), 'trim|required');
				$this->form_validation->set_rules('assessment_scope', trans('assessment_scope_field'), 'trim|required');
				$this->form_validation->set_rules('form', 'form', 'trim|required');
				$this->form_validation->set_rules('leader', 'leader', 'trim|required');
				//$this->form_validation->set_rules('member', 'member', 'trim|required');
				$leader = $this->input->post('leader');
				$members = $this->input->post('member[]');
				if(!empty($members))
				{
					foreach($members as $key=>$member)
					{
						if($member == $leader)
						{
							unset($members[$key]);
						}
					}
				}
				//die();
				if ($this->form_validation->run() == FALSE) {
					$data = array(
						'errors' => validation_errors()
					);
					$this->session->set_flashdata('errors', $data['errors']);
					redirect(base_url('admin/campaign/create_evaluation/'.$company_id),'refresh');
				}
				else{
					$data = array(
						'name' => $this->input->post('campaign_name'),
						'status'=>0, //Khởi tạo
						'assessment_date' => $this->input->post('assessment_date'),
						'assessment_criteria'=> $this->input->post('assessment_criteria'),
						'assessment_address' => '',//$this->input->post('assessment_address'),
						'assessment_type' => $this->input->post('assessment_type'),
						'comment ' =>'',
						'conclusions '=>'',
						'updated_date'=>0,
						'company_id '=>$company_id,
						'form_id'=>$this->input->post('form'),
						'state_id' => 0,//$this->input->post('state'),
						'city_id' => 0,//$this->input->post('city'),
						'wards_id' => 0,//$this->input->post('ward'),
						'created_date' => time(),
						'creator_id' => $this->session->userdata('admin_id'),
						'assessment_scope' => $this->input->post('assessment_scope'),
						'assessment_modelity' => $this->input->post('assessment_modelity'),
					);
					$data = $this->security->xss_clean($data);
					$result = $this->campaign_model->add_campaign($data, $leader, $members);
					if($result){
						// Activity Log 
						$this->activity_model->add_log(4);

						$this->session->set_flashdata('success', trans('company_has_been_added_successfully'));
						redirect(base_url('admin/company'));
					}
				}
		}
		} else { //update

		}
	}

	function view_evaluation_company($id="")
	{
		if($id == "")
		{
			$data['errors'] = trans('without_company_id');
			$this->session->set_flashdata('errors', $data['errors']);
			redirect(base_url('admin/campaign'),'refresh');
			return 0;
		} else{
			$ArrStates = $this->company_model->get_states();
			$states = array();
			foreach($ArrStates as $state)
			{
				$states[$state['id']] = $state['name'];
			}

			$ArrCity = $this->company_model->get_cities();
			$cities = array();
			foreach($ArrCity as $city)
			{
				$cities[$city['id']] = $city['name'];
			}

			$ArrWards = $this->company_model->get_wards();
			$wards = array();
			foreach($ArrWards as $city)
			{
				$wards[$city['id']] = $city['name'];
			}

			$data['wards'] = $wards;
			$data['cities'] = $cities;
			$data['states'] = $states;
			$data['record'] = $this->company_model->get_the_company($id);
			$data['company_address'] = $data['record']['address'] .', '.$wards[$data['record']['wards_id']]. ', ';
			$data['company_address'] = $data['company_address'] . $cities[$data['record']['city_id']] . ', ';
			$data['company_address'] = $data['company_address'] . $states[$data['record']['state_id']];
			
			$this->load->view('admin/includes/_header');
			$this->load->view('admin/company/view', $data);
			$this->load->view('admin/includes/_footer');
		}

	}

	function make_ready()
	{
		
		if($this->input->post('submit')){
			$id = $this->input->post('id');
			$rs = $this->campaign_model->update_status($id,1); //Sẵn sàng cho đánh giá
			if($rs)
			{
				$this->session->set_flashdata('success', trans('assessment_has_been_ready_to_use'));
				redirect(base_url('admin/campaign/view/').$id);
			} else{
				$this->session->set_flashdata('errors', trans('there_are_errors_when_assessment_updated'));
				redirect(base_url('admin/campaign/view/').$id);
			}
		}
	}

	//-----------------------------------------------------		
	function index($type=''){

		$data['title'] = 'Companies List';
		$this->load->view('admin/includes/_header');
		$this->load->view('admin/campaign/index', $data);
		$this->load->view('admin/includes/_footer');
	}

	function list_campaigns_json()
	{
		$start = empty($this->input->get('start')) ? 0:$this->input->get('start');
		$length = empty($this->input->get('length')) ? 25 : $this->input->get('length');
		$role_id = $this->session->userdata('admin_role_id');
		$records['data'] = $this->campaign_model->get_all_campaign($start,$length,$role_id);
		$data = array();
		$i=0;
		foreach ($records['data']  as $row) 
		{  
			//$status = $status . '<label class="tgl-btn" for="cb_'. $row['id'].'"></label>';
			//var_dump($row);
			if($row['status'] < 1)
			{
				$view_evaluation = "<a href='".base_url("admin/campaign/view/").$row['id']."'>".trans('view_evaluation')."</a> | <a data_id='".$row['id']."' class='delete_campaign' ><i class='fa fa-trash' aria-hidden='true'></i></a>";
			} else {
				$view_evaluation = "<a href='".base_url("admin/campaign/view/").$row['id']."'>".trans('view_evaluation')."</a>";
			}
			$name = "<a href='".base_url("admin/campaign/view/").$row['id']."'>".$row['name']."</a>";
			$status = "";
			$company_name = "<a href='".base_url("admin/campaign/view_evaluation_company/").$row['company_id']."'>".$row['company_name']."</a>";
			if($row['status'] == 0)
			{
				
				$status = trans('initial_assessment_status');
				//$status = '123';
				
			} else{
				switch($row['status'])
				{
					
					case 1:
						$status = '<a href="'.base_url('admin/campaign/view/').$row['id'].'">'.trans('ready_assessment').'</a>';
						break;
					case 2:
						$status = trans('editting_assessment'); //nhóm phê duyệt yêu cầu sửa lại
						break;	
					case 4:
						$status = trans('completed_assessment'); // Gửi lên nhóm phê duyệt
						break;
					case 3:
						$status = trans('redo_assessment'); //nhóm phê duyệt yêu cầu sửa lại
						break;
					case 5:
						$status = trans('finish_assessment'); //nhóm phê duyệt đã phê duyệt
						break;
					default:
						// chuỗi câu lệnh
						break;
				}
			}
			
			$data[]= array(
				++$i,
				$row['assessment_type'],
				$name,				
				$company_name,
				$row['assessment_date'],
				$status,
				$view_evaluation,
				'DT_RowId'=>'row_'.$row['id']
			);
		}
		$records['data'] = $data;
		echo json_encode($records);
	}
	/*
	function add(){

		$this->rbac->check_operation_access(); // check opration permission
		$ArrStates = $this->company_model->get_states();
		$states = array();
		foreach($ArrStates as $state)
		{
			$t = array(
				'id'=>$state['id'],
				'text'=>$state['name']
			);
			$states[] = $t;
		}

		$ArrCity = $this->company_model->get_cities();
		$cities = array();
		foreach($ArrCity as $city)
		{
			$t = array(
				'id'=>$city['id'],
				'text'=>$city['name'],
				'state_id'=>$city['state_id']
			);
			$cities[] = $t;
		}

		$ArrWards = $this->company_model->get_wards();
		$wards = array();
		foreach($ArrWards as $city)
		{
			$t = array(
				'id'=>$city['id'],
				'text'=>$city['name'],
				'city_id'=>$city['city_id']
			);
			$wards[] = $t;
		}

		$data['wards'] = json_encode($wards);
		$data['cities'] = json_encode($cities);
		$data['states'] = json_encode($states);

		if($this->input->post('submit')){
				$this->form_validation->set_rules('companyname', 'companyname', 'trim|required');
				$this->form_validation->set_rules('company_authorized', 'company_authorized', 'trim|required');
				$this->form_validation->set_rules('main_product', 'main_product', 'trim|required');
				$this->form_validation->set_rules('address', 'address', 'trim|required');
				$this->form_validation->set_rules('company_phone', 'Number', 'trim|required');
				$this->form_validation->set_rules('company_fax', 'Number', 'trim|required');
				$this->form_validation->set_rules('state', 'state', 'trim|required');
				$this->form_validation->set_rules('city', 'city', 'trim|required');
				$this->form_validation->set_rules('ward', 'ward', 'trim|required');
				if ($this->form_validation->run() == FALSE) {
					$data = array(
						'errors' => validation_errors()
					);
					$this->session->set_flashdata('errors', $data['errors']);
					redirect(base_url('admin/company/add'),'refresh');
				}
				else{
					$data = array(
						'name' => $this->input->post('companyname'),
						'address' => $this->input->post('address'),
						'tel' => $this->input->post('company_phone'),
						'fax' => $this->input->post('company_fax'),
						'authorized' => $this->input->post('company_authorized'),
						'designation' => $this->input->post('company_designation'),
						'product' => $this->input->post('main_product'),
						'state_id' => $this->input->post('state'),
						'city_id' => $this->input->post('city'),
						'wards_id' => $this->input->post('ward'),
						'created_date' => time(),
						'creator_id' => $this->session->userdata('admin_id'),
					);
					$data = $this->security->xss_clean($data);
					$result = $this->company_model->add_company($data);
					if($result){

						// Activity Log 
						$this->activity_model->add_log(4);

						$this->session->set_flashdata('success', trans('company_has_been_added_successfully'));
						redirect(base_url('admin/company'));
					}
				}
		}
		else
		{
			$this->load->view('admin/includes/_header');
			$this->load->view('admin/company/add',$data);
			$this->load->view('admin/includes/_footer');
		}
	}
	*/
	function view($id=""){
		if($id==""){
			redirect('admin/campaign');
		}
		else{
			$data['record'] = $this->campaign_model->get_campaign($id);

			if(!$this->campaign_model->has_the_campaign($data['record']['id']))
			{
				redirect('admin/campaign');
			}
			$flag = 0;

			//$data['area_assessment'] = $this->assessment_model->get_areas(form_id )
			//var_dump($data['record'] );die();
			if($data['record'])
			{
				$status = "";
				switch($data['record']['status'])
				{
					case 0:
						$status = trans('initial_assessment');
						break;
					case 1:
						$status = trans('ready_assessment');
						break;
					case 3:
						$status = trans('completed_assessment'); // Gửi lên nhóm phê duyệt
						break;
					case 2:
						$status = trans('redo_assessment'); //nhóm phê duyệt yêu cầu sửa lại
						break;
					case 5:
						$status = trans('finish_assessment'); //nhóm phê duyệt đã phê duyệt
						break;
					default:
						// chuỗi câu lệnh
						break;
				}
				$data['areas_assessment'] = $this->campaign_model->get_areas_with_result($id,$data['record']['form_id'],3);
				//var_dump($data['areas_assessment']);
				$data['areas_best_practices'] = $this->campaign_model->get_area_with_best_practices($id,$data['record']['form_id']);
				//var_dump($data['areas_best_practices']);die();
				$data['areas_assessment_findings'] = $this->campaign_model->get_area_with_assessment_findings($id,$data['record']['form_id']);

				foreach($data['areas_assessment'] as $area)
				{
					if($area['count_result'] > 0)
					{
						$flag++;
					}
				}
				if($data['record']['comment'] != "")
				{
					$flag++;
				}
				if($data['record']['conclusions'] != "")
				{
					$flag++;
				}

				foreach($data['areas_best_practices'] as $area)
				{
					if($area['best_practices_id'] != null)
					{
						$flag++;
					}
				}

				foreach($data['areas_assessment_findings'] as $area)
				{
					if($area['assessment_findings_id'] != null)
					{
						$flag++;
					}
				}

			} else {
				# code...
				redirect('admin/campaign');
			}

			$data['status'] = $status;
			$data['flag'] = $flag; //20: Đã hoàn thành đầy đủ thông tin; < 7 vẫn chưa hoàn thành đánh giá đầy đủ các hạng mục
			$this->load->view('admin/includes/_header');
			$this->load->view('admin/campaign/view', $data);
			$this->load->view('admin/includes/_footer');
		}
	}
	function edit($id=""){

		$this->rbac->check_operation_access(); // check opration permission
		$ArrStates = $this->company_model->get_states();
		$states = array();
		foreach($ArrStates as $state)
		{
			$t = array(
				'id'=>$state['id'],
				'text'=>$state['name']
			);
			$states[] = $t;
		}

		$ArrCity = $this->company_model->get_cities();
		$cities = array();
		foreach($ArrCity as $city)
		{
			$t = array(
				'id'=>$city['id'],
				'text'=>$city['name'],
				'state_id'=>$city['state_id']
			);
			$cities[] = $t;
		}

		$ArrWards = $this->company_model->get_wards();
		$wards = array();
		foreach($ArrWards as $city)
		{
			$t = array(
				'id'=>$city['id'],
				'text'=>$city['name'],
				'city_id'=>$city['city_id']
			);
			$wards[] = $t;
		}

		$data['wards'] = json_encode($wards);
		$data['cities'] = json_encode($cities);
		$data['states'] = json_encode($states);

		

		if($this->input->post('submit')){
			$this->form_validation->set_rules('companyname', 'companyname', 'trim|required');
				$this->form_validation->set_rules('company_authorized', 'company_authorized', 'trim|required');
				$this->form_validation->set_rules('main_product', 'main_product', 'trim|required');
				$this->form_validation->set_rules('address', 'address', 'trim|required');
				$this->form_validation->set_rules('company_phone', 'Number', 'trim|required');
				$this->form_validation->set_rules('company_fax', 'Number', 'trim|required');
				$this->form_validation->set_rules('state', 'state', 'trim|required');
				$this->form_validation->set_rules('city', 'city', 'trim|required');
				$this->form_validation->set_rules('ward', 'ward', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
				$data = array(
					'errors' => validation_errors()
				);
				$this->session->set_flashdata('errors', $data['errors']);
				redirect(base_url('admin/company/edit/'.$id),'refresh');
			}
			else{
				$data = array(
					'name' => $this->input->post('companyname'),
					'address' => $this->input->post('address'),
					'tel' => $this->input->post('company_phone'),
					'fax' => $this->input->post('company_fax'),
					'authorized' => $this->input->post('company_authorized'),
					'designation' => $this->input->post('company_designation'),
					'product' => $this->input->post('main_product'),
					'state_id' => $this->input->post('state'),
					'city_id' => $this->input->post('city'),
					'wards_id' => $this->input->post('ward'),
					'created_date' => time(),
					'creator_id' => $this->session->userdata('admin_id'),
				);
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
			redirect('admin/company');
		}
		else{
			$data['record'] = $this->company_model->get_the_company($id);
			
			$this->load->view('admin/includes/_header');
			$this->load->view('admin/company/edit', $data);
			$this->load->view('admin/includes/_footer');
		}		
	}
	//Edit assessment result
	//$assessment_id campaign_id
	function edit_assessment($assessment_id="",$area_id="")
	{
		if($assessment_id=="" || $area_id== ""){
			redirect('admin/campaign');
		}
		else{
			$data['record'] = $this->campaign_model->get_campaign($assessment_id);
			if($data['record'])
			{
				$theArea = $this->assessment_model->get_the_area_by_form($area_id,$data['record']['form_id']);
				if($theArea)
				{
					$categories = $this->assessment_model->get_category_by_area($area_id);
					$cates = array();
					$strQuestionIds = "";
					$strResultIds = "";
					foreach($categories as $category)
					{
						$category['questions'] = $this->assessment_model->get_questions_result_by_category($category['id']);
						$_questions = array();
						foreach($category['questions'] as $question)
						{
							$strQuestionIds = $strQuestionIds.','.$question['id'];
							$strResultIds = $strResultIds.','.$question['result_id'];
							$best_practice_photos = $this->assessment_model->get_photo_best_practice_by_question($question['id']);
							$findin_photos = $this->assessment_model->get_photo_finding_by_question($question['id']);
							$question['best_photos'] = $best_practice_photos;
							$question['finding_photos'] = $findin_photos;
							$criterias = $this->assessment_model->get_criterias_by_question($question['id']);
							$question['criterias'] = $criterias;
							$_questions[] = $question;
						}
						$category['questions'] = $_questions;
						$cates[] = $category;
					}
					$best_photos = $this->assessment_model->get_best_photos_by_area($theArea['id']);
					$finding_photos = $this->assessment_model->get_finding_photos_by_area($theArea['id']);
					$strQuestionIds = ltrim($strQuestionIds,",");
					$strResultIds = ltrim($strResultIds,",");
					$data['record']['categories'] = $cates;
					$data['theArea'] = $theArea;
					$data['strQuestionIds'] = $strQuestionIds;
					$data['strResultIds'] = $strResultIds;
					$data['best_photos'] = $best_photos;
					$data['finding_photos'] = $finding_photos;

					$this->load->view('admin/includes/_header');
					$this->load->view('admin/campaign/edit_assessment', $data);
					$this->load->view('admin/includes/_footer');

				} else{
					redirect('admin/campaign');
				}

			} else{
				redirect('admin/campaign');
			}

		}
	}
	function make_edit_assessment()
	{
		if($this->input->post('submit')){
			$campain_id = $this->input->post('id');
			$result_ids = $this->input->post('result_ids');
			//var_dump($result_ids);die();
			$arrResultIds = explode(',',$result_ids);
			$data = array();
			if($arrResultIds)
			{
				foreach($arrResultIds as $result_id)
				{
					$item = array(
						'id'=>$result_id,
						'score'=>$this->input->post('result_score_'.$result_id),
						'content'=>$this->input->post('result_text_'.$result_id),
					);
					$data[] = $item;
				}

				$this->db->update_batch('result',$data,'id');
				$this->session->set_flashdata('success', trans('assessment_has_updated_successfull'));
				redirect(base_url('admin/campaign/view/').$campain_id);
			}
		}
	}
	//Step 1: Assessment
	function assessment($assessment_id="",$area_id="") //Id of assessment
	{
		
		if($assessment_id==""){
			redirect('admin/campaign');
		}
		else{
			$data['record'] = $this->campaign_model->get_campaign($assessment_id);
			if($data['record'])
			{
				$theArea = $this->assessment_model->get_the_area_by_form($area_id,$data['record']['form_id']);
				if($theArea)
				{
					$categories = $this->assessment_model->get_category_by_area($area_id);
					$cates = array();
					$strQuestionIds = "";
					foreach($categories as $category)
					{
						$category['questions'] = $this->assessment_model->get_questions_by_category($category['id']);
						//$questions = $this->assessment_model->get_questions_by_category($category['id']);
						$_questions = array();
						foreach($category['questions'] as $question)
						{
							$strQuestionIds = $strQuestionIds.','.$question['id'];
							$criterias = $this->assessment_model->get_criterias_by_question($question['id']);
							$question['criterias'] = $criterias;
							$_questions[] = $question;
						}
						$category['questions'] = $_questions;
						$cates[] = $category;
					}
					$best_photos = $this->assessment_model->get_best_photos_by_area($theArea['id']);
					$finding_photos = $this->assessment_model->get_finding_photos_by_area($theArea['id']);
					$data['best_photos'] = $best_photos;
					$data['finding_photos'] = $finding_photos;
					$strQuestionIds = ltrim($strQuestionIds,",");
					$data['record']['categories'] = $cates;
					$data['theArea'] = $theArea;
					$data['strQuestionIds'] = $strQuestionIds;

					$this->load->view('admin/includes/_header');
					$this->load->view('admin/campaign/assessment', $data);
					$this->load->view('admin/includes/_footer');

				} else {
					redirect('admin/campaign');
				}
			} else{
				redirect('admin/campaign');
			}
		}
	}
	function make_assessment() //save it
	{
		if($this->input->post('submit')){
			$question_ids = $this->input->post('question_ids');
			$company_id = $this->input->post('company_id');
			$campain_id = $this->input->post('id');
			$area_id = $this->input->post('area_id');
			$arrQuestionIds = explode(',',$question_ids);
			$data = array();
			if($arrQuestionIds)
			{
				$theCampaign = $this->campaign_model->get_the_campaign($campain_id);
				foreach($arrQuestionIds as $question_id)
				{
					$company_id = $this->input->post('');
					$company_id = $this->input->post('');
					$item = array('campaign_id'=>$campain_id,
								'company_id'=>$company_id,
								'question_id'=>$question_id,
								'created_date'=>time(),
								'creator_id'=>$this->session->userdata('admin_id'),
								'score'=>$this->input->post('question_point_'.$question_id),
								'content'=>$this->input->post('question_comment_'.$question_id),
								'area_id'=>$area_id,
								);
					$data[] = $item;			

				}
				$this->db->insert_batch('result', $data);
				$theCampaign['status'] = 2;
				$this->campaign_model->update_campaign($theCampaign,$campain_id);
				$this->session->set_flashdata('success', trans('assessment_has_been_successfull'));
				redirect(base_url('admin/campaign/view/').$campain_id);
			}
		}
	}

	// Step 2: General Comment (FORM)
	function general_comment($assessment_id) //Id of assessment
	{
		if($assessment_id==""){
			redirect('admin/campaign');
		}
		else{
			$data['record'] = $this->campaign_model->get_campaign($assessment_id);
			if($data['record'])
			{
				$this->load->view('admin/includes/_header');
				$this->load->view('admin/campaign/general_comment', $data);
				$this->load->view('admin/includes/_footer');
			} else{
				redirect('admin/campaign');
			}
		}
	}

	function make_general_comment() //save it
	{
		if($this->input->post('submit')){
			$id = $this->input->post('id');			
			$data = array(
				'archivement'=>$this->input->post('archivement'),
				'main_problem'=>$this->input->post('main_problem'),
				'comment'=>$this->input->post('archivement') . ' | '.$this->input->post('main_problem')
			);
			// $data = array(
			// 	'comment'=>$this->input->post('general_comment')
			// );
			$this->campaign_model->update_campaign($data,$id);
			$this->session->set_flashdata('success', trans('assessment_has_been_successfull'));
			redirect(base_url('admin/campaign/view/').$id);
		}
	}

	function edit_general_comment($assessment_id) //Id of assessment
	{
		if($assessment_id==""){
			redirect('admin/campaign');
		}
		else{
			$data['record'] = $this->campaign_model->get_campaign($assessment_id);
			if($data['record'])
			{
				$this->load->view('admin/includes/_header');
				$this->load->view('admin/campaign/edit_general_comment', $data);
				$this->load->view('admin/includes/_footer');
			} else{
				redirect('admin/campaign');
			}
		}
	}

	function make_edit_general_comment() //save it
	{
		if($this->input->post('submit')){
			$id = $this->input->post('id');
			// $data = array(
			// 	'comment'=>$this->input->post('general_comment')
			// );
			$data = array(
				'archivement'=>$this->input->post('archivement'),
				'main_problem'=>$this->input->post('main_problem'),
				'comment'=>$this->input->post('archivement') . ' | '.$this->input->post('main_problem')
			);
			$this->campaign_model->update_campaign($data,$id);
			$this->session->set_flashdata('success', trans('assessment_has_been_successfull'));
			redirect(base_url('admin/campaign/view/').$id);
		}
	}
	//Step 3: 
	function recommendation($assessment_id) //Id of assessment
	{
		if($assessment_id==""){
			redirect('admin/campaign');
		}
		else{
			$data['record'] = $this->campaign_model->get_campaign($assessment_id);
			if($data['record'])
			{
				$data['record']['conclusions'] = "1. {company_name} đạt {score} điểm thực hành 5S trên tổng số {max_score} điểm tại các khu vực được đánh giá, ";
				$data['record']['conclusions'] = $data['record']['conclusions'] ."tương ứng đạt {score_percent} tổng số điểm. Kết quả này đáp ứng yêu cầu xem xét cấp chứng chỉ Thực hành tốt 5S theo quy định (>= 70%). ";
				$data['record']['conclusions'] = $data['record']['conclusions'] ."Đoàn chuyên gia đánh giá sẽ hoàn thành hồ sơ và kiến nghị Viện Năng suất Việt Nam xem xét, ";
				$data['record']['conclusions'] = $data['record']['conclusions'] ."Quyết định cấp chứng chỉ Thực hành tốt 5S cho {company_name}. <br>";
				$data['record']['conclusions'] = $data['record']['conclusions'] ."2. {company_name} phải triển khai các điểm cần cải tiến trong báo cáo này và gửi lại báo cáo cải tiến (theo mẫu kèm theo) cho đoàn chuyên gia đánh giá trước ngày ";
				$data['record']['conclusions'] = $data['record']['conclusions'] ."{report_date} để làm cơ sở cho việc theo dõi và đánh giá tiếp theo.<br>";
				$data['record']['conclusions'] = $data['record']['conclusions'] ."3. Chứng chỉ thực hành tốt 5S có giá trị 2 năm kể từ ngày cấp. Thực hành tốt 5S của công ty sẽ được kiểm tra giám sát sau 1 năm và sẽ đánh giá lại sau 2 năm để gia hạn hiệu lực chứng chỉ.";
				$this->load->view('admin/includes/_header');
				$this->load->view('admin/campaign/recommendation', $data);
				$this->load->view('admin/includes/_footer');
			} else{
				redirect('admin/campaign');
			}
		}
	}

	function make_recommendation() //save it
	{
		if($this->input->post('submit')){
			$id = $this->input->post('id');
			$data = array(
				'conclusions'=>$this->input->post('recommendation')
			);
			$this->campaign_model->update_campaign($data,$id);
			$this->session->set_flashdata('success', trans('assessment_has_been_successfull'));
			redirect(base_url('admin/campaign/view/').$id);
		}
	}

	function edit_recommendation($assessment_id) //Id of assessment
	{
		if($assessment_id==""){
			redirect('admin/campaign');
		}
		else{
			$data['record'] = $this->campaign_model->get_campaign($assessment_id);
			if($data['record'])
			{
				$this->load->view('admin/includes/_header');
				$this->load->view('admin/campaign/edit_recommendation', $data);
				$this->load->view('admin/includes/_footer');
			} else{
				redirect('admin/campaign');
			}
		}
	}

	function make_edit_recommendation() //save it
	{
		if($this->input->post('submit')){
			$id = $this->input->post('id');
			$data = array(
				'conclusions'=>$this->input->post('recommendation')
			);
			$this->campaign_model->update_campaign($data,$id);
			$this->session->set_flashdata('success', trans('assessment_has_been_successfull'));
			redirect(base_url('admin/campaign/view/').$id);
		}
	}

	// Step 4: Best practice
	function best_practices($assessment_id="",$area_id="") //assessment_id of assessment (campaign_id)
	{
		if($assessment_id=="" || $area_id == ""){
			redirect('admin/campaign');
		}
		else{
			$data['record'] = $this->campaign_model->get_campaign($assessment_id);
			if($data['record'])
			{
				$theArea = $this->assessment_model->get_the_area_by_form($area_id,$data['record']['form_id']);
				$theBestPracticesPhotos = $this->assessment_model->get_best_photos_by_area($area_id);
				if($theArea)
				{
					$data['theArea'] = $theArea;
					$data['theBestPracticesPhotos'] = $theBestPracticesPhotos;
					$this->load->view('admin/includes/_header');
					$this->load->view('admin/campaign/best_practices', $data);
					$this->load->view('admin/includes/_footer');

				} else {
					redirect('admin/campaign');
				}
			} else{
				redirect('admin/campaign');
			}
		}
	}

	function make_best_practices() //save it
	{
		if($this->input->post('submit')){

			$campain_id = $this->input->post('id');
			$area_id = $this->input->post('area_id');
			
			
				
			$data = array('campaign_id'=>$campain_id,
						'created_date'=>time(),
						'updated_date'=>0,
						'creator_id'=>$this->session->userdata('admin_id'),
						'content'=>$this->input->post('best_practices'),
						'area_id'=>$area_id,
						);
			
			$this->campaign_model->add_best_practices($data);
			$this->session->set_flashdata('success', trans('assessment_has_been_successfull'));
			redirect(base_url('admin/campaign/view/').$campain_id);
			
		}
	}

	function edit_best_practices($campain_id,$id) //Id of assessment
	{
		if($campain_id=="" || $id == ""){
			redirect('admin/campaign');
		}
		else{
			$data['record'] = $this->campaign_model->get_campaign($campain_id);
			$data['best_practice'] = $this->campaign_model->get_the_best_practices($id,$campain_id);
			if($data['record'] && $data['best_practice'])
			{
				$area_id = $data['best_practice']['area_id'];
				$theArea = $this->assessment_model->get_the_area_by_form($area_id,$data['record']['form_id']);
				$theBestPracticesPhotos = $this->assessment_model->get_best_photos_by_area($area_id);
				//$thefindingPhotos = $this->assessment_model->get_finding_photos_by_area($area_id);
				if($theArea)
				{
					$data['theArea'] = $theArea;
					$data['theBestPracticesPhotos'] = $theBestPracticesPhotos;
					//$data['thefindingPhotos'] = $thefindingPhotos;
					$this->load->view('admin/includes/_header');
					$this->load->view('admin/campaign/edit_best_practices', $data);
					$this->load->view('admin/includes/_footer');

				} else {
					redirect('admin/campaign');
				}
			} else{
				redirect('admin/campaign');
			}
		}
	}

	function make_edit_best_practices() //save it
	{
		if($this->input->post('submit')){

			$id = $this->input->post('id');
			$campain_id = $this->input->post('campaign_id');
			$data = array(
						'updated_date'=>time(),						
						'content'=>$this->input->post('best_practices'),
						);
			
			$this->campaign_model->edit_best_practices($data,$id);
			$this->session->set_flashdata('success', trans('assessment_has_been_successfull'));
			redirect(base_url('admin/campaign/view/').$campain_id);
			
		}
	}
	// Step 5: Assessment Finding
	function assessment_finding($assessment_id, $area_id) //Id of assessment
	{
		if($assessment_id=="" || $area_id == ""){
			redirect('admin/campaign');
		}
		else{
			$data['record'] = $this->campaign_model->get_campaign($assessment_id);
			if($data['record'])
			{
				$theArea = $this->assessment_model->get_the_area_by_form($area_id,$data['record']['form_id']);
				$thefindingPhotos = $this->assessment_model->get_finding_photos_by_area($area_id);
				if($theArea)
				{
					$data['theArea'] = $theArea;
					$data['thefindingPhotos'] = $thefindingPhotos;
					$this->load->view('admin/includes/_header');
					$this->load->view('admin/campaign/assessment_finding', $data);
					$this->load->view('admin/includes/_footer');

				} else {
					redirect('admin/campaign');
				}
			} else{
				redirect('admin/campaign');
			}
		}
	}

	function make_assessment_finding() //save it
	{
		if($this->input->post('submit')){

			$campain_id = $this->input->post('id');
			$area_id = $this->input->post('area_id');
			
			$data = array('campaign_id'=>$campain_id,
						'created_date'=>time(),
						'updated_date'=>0,
						'creator_id'=>$this->session->userdata('admin_id'),
						'content'=>$this->input->post('content'),
						'area_id'=>$area_id,
						);
			
			$this->campaign_model->add_assessment_findings($data);
			$this->session->set_flashdata('success', trans('assessment_has_been_successfull'));
			redirect(base_url('admin/campaign/view/').$campain_id);
			
		}
	}

	function edit_assessment_finding($campain_id,$id) //Id of assessment
	{
		if($campain_id=="" || $id == ""){
			redirect('admin/campaign');
		}
		else{
			$data['record'] = $this->campaign_model->get_campaign($campain_id);
			$data['assessment_finding'] = $this->campaign_model->get_the_assessment_findings($id,$campain_id);
			if($data['record'] && $data['assessment_finding'])
			{
				$area_id = $data['assessment_finding']['area_id'];
				$theArea = $this->assessment_model->get_the_area_by_form($area_id,$data['record']['form_id']);
				$thefindingPhotos = $this->assessment_model->get_finding_photos_by_area($area_id);
				if($theArea)
				{
					$data['thefindingPhotos'] = $thefindingPhotos;
					$data['theArea'] = $theArea;
					$this->load->view('admin/includes/_header');
					$this->load->view('admin/campaign/edit_assessment_finding', $data);
					$this->load->view('admin/includes/_footer');

				} else {
					redirect('admin/campaign');
				}
			} else{
				redirect('admin/campaign');
			}
		}
	}

	function make_edit_assessment_finding() //save it
	{
		if($this->input->post('submit')){

			$id = $this->input->post('id');
			$campain_id = $this->input->post('campaign_id');
			$data = array(
						'updated_date'=>time(),						
						'content'=>$this->input->post('content'),
						);
			
			$this->campaign_model->edit_assessment_findings($data,$id);
			$this->session->set_flashdata('success', trans('assessment_has_been_successfull'));
			redirect(base_url('admin/campaign/view/').$campain_id);
			
		}
	}
	// Step 6: Gửi đi phê duyệt (completed), waiting ....


	//Preview
	function preview($id)
	{
		if($id == "")
		{
			redirect('admin/campaign');
		} else{
			$ArrStates = $this->company_model->get_states();
			$states = array();
			foreach($ArrStates as $state)
			{
				$states[$state['id']] = $state['name'];
			}

			$ArrCity = $this->company_model->get_cities();
			$cities = array();
			foreach($ArrCity as $city)
			{
				$cities[$city['id']] = $city['name'];
			}

			$ArrWards = $this->company_model->get_wards();
			$wards = array();
			foreach($ArrWards as $city)
			{
				$wards[$city['id']] = $city['name'];
			}

			$data['wards'] = $wards;
			$data['cities'] = $cities;
			$data['states'] = $states;
			//1 Lấy thông tin lần đánh giá này:
			$theCampaign = $this->campaign_model->get_campaign($id);
			$user_id = $this->session->userdata('admin_id');
			if($this->session->userdata('admin_role_id') == 6)
			{
				$theRole = $this->campaign_model->get_role_of_member_on_campaign($user_id, $theCampaign['company_id']);
				if(!empty($theRole))
				{
					$data['theRole'] = $theRole['type']; //0 thành viên; 1 leader
				} else{
					redirect('admin/campaign');
				}
			} else {
				$data['theRole'] = 3; //admin
			}
			$data['record'] = $theCampaign;
			
			$conclusions = $theCampaign['conclusions'];
			if($theCampaign)
			{
				//2. Lấy thông tin đánh giá/chấm điểm score (theo area)
				$data['areas_assessment'] = $this->campaign_model->get_areas_with_result($id,$data['record']['form_id'],3);
				$areas_assessment = array();
				if($data['areas_assessment'])
				{
					$max_markds = 0;
					$scored = 0;
					foreach($data['areas_assessment'] as $area)
					{
						$categories = $this->assessment_model->get_category_by_area($area['id']);
						$cates = array();
						$max_markds = $max_markds + $area['count_result']*5;
						$scored = $scored + $area['total_score'];
						foreach($categories as $category)
						{
							$category['questions'] = $this->assessment_model->get_questions_by_category($category['id']);
							/*
							$category['questions'] = $this->assessment_model->get_questions_result_by_category($category['id']);
							if($category['questions'])
							{
								foreach($category['questions'] as $question)
								{
									$max_markds = $max_markds + 5;
									$scored = $scored + $question['score'];
								}
							}*/
							$cates[] = $category;
						}
						$area['categories'] = $cates;
						
						
						$areas_assessment[] = $area;
					}
					$data['areas_assessment'] = $areas_assessment;
					$data['max_marks'] = $max_markds;
					$data['scored'] = $scored;
				}
				if($max_markds != 0)
				{
					$score_percent = number_format((100*$scored/$max_markds),2);
				} else {
					$score_percent = 0;
				}
				$conclusions = str_replace('{company_name}',$theCampaign['company_name'],$conclusions);
				$conclusions = str_replace('{score}',$scored,$conclusions);
				$conclusions = str_replace('{max_score}',$max_markds,$conclusions);
				$conclusions = str_replace('{score_percent}',$score_percent,$conclusions);
				$conclusions = str_replace('{report_date}',$theCampaign['assessment_date'],$conclusions);
				$data['conclusions'] = $conclusions;
				//3. Lấy thông tin best practices
				$data['areas_best_practices'] = $this->campaign_model->get_area_with_best_practices($id,$data['record']['form_id']);
				//var_dump($data['areas_best_practices']);
				//4. Lấy thông tin assessment findings
				$data['areas_assessment_findings'] = $this->campaign_model->get_area_with_assessment_findings($id,$data['record']['form_id']);

				$this->load->view('admin/includes/_header');
				$this->load->view('admin/campaign/preview', $data);
				$this->load->view('admin/includes/_footer');

			} else{
				redirect('admin/campaign');
			}
		}

	}


	function upload()
	{
		$_username = $this->input->post('username');
		$_question_id = $this->input->post('question_id');
		$_area_id = $this->input->post('area_id');
		$_campaign_id = $this->input->post('campaign_id');
		$_creator_id = $this->input->post('creator_id');
		$_type = $this->input->post('type');
		$_name_input_file = $this->input->post('name_input_file');
		
		$_upload_path ="./ckfinder/$_username/files/q".$_question_id."/";
		if(!file_exists($_upload_path))
		{
			mkdir($_upload_path, 0755, true);
		}
		//$_target = "./ckfinder/$_username/images/q".$_question_id."/";
		$_target_path = "./ckfinder/$_username/images/";
		if(!file_exists($_target_path))
		{
			mkdir($_target_path, 0755, true);
		}
		$config['upload_path'] = $_upload_path;
        $config['allowed_types']='gif|jpg|png';
        $config['encrypt_name'] = TRUE;
         
        $this->load->library('upload',$config);
		//var_dump($config);
        if($this->upload->do_upload('file')){
            $data = array('upload_data' => $this->upload->data());
			//var_dump($data);
            $image= $data['upload_data']['file_name'];
			$_source = "./ckfinder/$_username/files/q".$_question_id."/".$image;
			$_target = "./ckfinder/$_username/images/".$image;
			$_rs = $this->resizeImage($_source,$_target);
			if( $_rs == 1)
			{
				$result['url']= base_url("/ckfinder/$_username/images/"). $image;
				$_path_save_to = "/ckfinder/$_username/images/". $image;
				$result['question_id'] = $_question_id;
				$result['result']= $this->assessment_model->save_upload($_path_save_to,$_question_id,$_area_id,$_campaign_id,$_creator_id,$_type);
				$result['message'] = 'Bạn đã upload thành công';				
				echo json_encode($result);
				//echo $result['message'];
			} else{
				echo $_rs;
			}
        }
		else{
			//$error = array('error' => $this->upload->display_errors());
			$result['url'] = '';
			$result['result']= 0;
			//$result['error'] = 'Lỗi hoặc bạn chưa chọn ảnh để upload, hãy upload lại';
			$result['error'] =  $this->upload->display_errors();
			//echo json_encode($result);
			echo $result['error'];
		}
	}

	/**

    * Manage uploadImage

    *

    * @return Response

   */

  public function resizeImage($source,$target)

  {

	 $config_manip = array(

		 'image_library' => 'gd2',

		 'source_image' => $source,

		 'new_image' => $target,

		 'maintain_ratio' => TRUE,

		 'create_thumb' => TRUE,

		 'thumb_marker' => '',

		 'width' => 500,

		 'height' => 500

	 );


	 $this->load->library('image_lib', $config_manip);

	 if (!$this->image_lib->resize()) {

		 //echo $this->image_lib->display_errors();
		 $this->image_lib->clear();
		 return $this->image_lib->display_errors();

	 } else{
		$this->image_lib->clear();
		 return 1;
	 }
  }

  public function send_approve()
  {
	  $campain_id = $this->input->post('id');
	  $theCampaign = $this->campaign_model->get_the_campaign($campain_id);
	  if($this->session->userdata('admin_role_id') == 6)
	  {
		 if(!empty($theCampaign) && $theCampaign['creator_id'] == $this->user_id)
		 {
			 // Cập nhật
			 if($theCampaign['status'] < 4)
			 {
			 	$data['status'] = 4;
				$this->campaign_model->update_campaign($data,$campain_id);
				redirect(base_url('admin/campaign/preview/').$campain_id);
			 }
		 }
	  } else {
	  
	  }
  }

  public function approve()
  {
	$campain_id = $this->input->post('id');
	$theCampaign = $this->campaign_model->get_the_campaign($campain_id);
	$cm = $this->input->post('approve');
	if($this->session->userdata('admin_role_id') != 6)
	{
		if($cm == 'reject')
		{
			$data['status'] = 3;
				$this->campaign_model->update_campaign($data,$campain_id);
				redirect(base_url('admin/campaign/preview/').$campain_id);
		} else{
			$data['status'] = 5;
				$this->campaign_model->update_campaign($data,$campain_id);
				redirect(base_url('admin/campaign/preview/').$campain_id);
		}
	}
  }

  public function making_edition()
  {
	$campain_id = $this->input->post('id');
	$theCampaign = $this->campaign_model->get_the_campaign($campain_id);
	//$cm = $this->input->post('approve');
	if($this->session->userdata('admin_role_id') == 6)
	{
		if(!empty($theCampaign) && $theCampaign['creator_id'] == $this->user_id)
		{
			if($theCampaign['status'] == 3)
			{
				$data['status'] = 2;
				$this->campaign_model->update_campaign($data,$campain_id);
				redirect(base_url('admin/campaign/preview/').$campain_id);
			}
		}
		
	}
  }

  public function make_pdf($id='')
  {
		//echo phpinfo();
		$this->load->library('pdf');
		if($id == '')
			$id = 9;
		// Lấy dữ liệu
		$ArrStates = $this->company_model->get_states();
		$states = array();
		foreach($ArrStates as $state)
		{
			$states[$state['id']] = $state['name'];
		}

		$ArrCity = $this->company_model->get_cities();
		$cities = array();
		foreach($ArrCity as $city)
		{
			$cities[$city['id']] = $city['name'];
		}

		$ArrWards = $this->company_model->get_wards();
		$wards = array();
		foreach($ArrWards as $city)
		{
			$wards[$city['id']] = $city['name'];
		}

		$data['wards'] = $wards;
		$data['cities'] = $cities;
		$data['states'] = $states;
		//1 Lấy thông tin lần đánh giá này:
		
		$theCampaign = $this->campaign_model->get_campaign($id);
		 
		$user_id = $this->session->userdata('admin_id');
		if($this->session->userdata('admin_role_id') == 6)
		{
			$theRole = $this->campaign_model->get_role_of_member_on_campaign($user_id, $theCampaign['id']);
			if(!empty($theRole))
			{
				$data['theRole'] = $theRole['type']; //0 thành viên; 1 leader
			} else{
				redirect('admin/campaign');
			}
		} else {
			$data['theRole'] = 3; //admin
		}
		$data['record'] = $theCampaign;
		
		$conclusions = $theCampaign['conclusions'];
		if($theCampaign)
		{
			// Lấy đầy đủ địa chỉ, xã, huyện, tỉnh
			$data['company_address'] = $theCampaign['company_address'].', '.$wards[$theCampaign['company_wards_id']];
			$data['company_address'] = $data['company_address'].', '.$cities[$theCampaign['company_city_id']];
			$data['company_address'] = $data['company_address'].', '.$states[$theCampaign['company_state_id']];
			$members_company = $this->campaign_model->get_users_by_campaign($theCampaign['id']);
			//var_dump($members_company);
			$_arrMembers = array();
			$_index = 2;
			foreach($members_company as $members_company)
			{
				
				if($members_company['type'] == 1)
				{
					$_arrMembers[1] = array('name'=>$members_company['lastname'] . ' ' . $members_company['firstname'],'title'=>'');
				} else {
					$_arrMembers[$_index] = array('name'=>$members_company['lastname'] . ' ' . $members_company['firstname'],'title'=>'');
					$_index++;
				}
				//echo $_index;
			}
			//var_dump($_arrMembers); die();
			$data['members']  = $_arrMembers;
			//2. Lấy thông tin đánh giá/chấm điểm score (theo area)
			$data['areas_assessment'] = $this->campaign_model->get_areas_with_result($id,$data['record']['form_id'],3);
			$areas_assessment = array();
			if($data['areas_assessment'])
			{
				$max_markds = 0;
				$scored = 0;
				foreach($data['areas_assessment'] as $area)
				{
					$categories = $this->assessment_model->get_category_by_area($area['id']);
					$cates = array();
					$max_markds = $max_markds + $area['count_result']*5;
					$scored = $scored + $area['total_score'];
					foreach($categories as $category)
					{
						$category['questions'] = $this->assessment_model->get_questions_by_category($category['id']);
						/*
						$category['questions'] = $this->assessment_model->get_questions_result_by_category($category['id']);
						if($category['questions'])
						{
							foreach($category['questions'] as $question)
							{
								$max_markds = $max_markds + 5;
								$scored = $scored + $question['score'];
							}
						}*/
						$cates[] = $category;
					}
					$area['categories'] = $cates;
					
					
					$areas_assessment[] = $area;
				}
				$data['areas_assessment'] = $areas_assessment;
				$data['max_marks'] = $max_markds;
				$data['scored'] = $scored;
			}
			if($max_markds != 0)
			{
				$score_percent = number_format((100*$scored/$max_markds),2);
			} else {
				$score_percent = 0;
			}
			$conclusions = str_replace('{company_name}',$theCampaign['company_name'],$conclusions);
			$conclusions = str_replace('{score}',$scored,$conclusions);
			$conclusions = str_replace('{max_score}',$max_markds,$conclusions);
			$conclusions = str_replace('{score_percent}',$score_percent,$conclusions);
			$conclusions = str_replace('{report_date}',$theCampaign['assessment_date'],$conclusions);
			$data['conclusions'] = $conclusions;
			//3. Lấy thông tin best practices
			$data['areas_best_practices'] = $this->campaign_model->get_area_with_best_practices($id,$data['record']['form_id']);
			//var_dump($data['areas_best_practices']);
			//4. Lấy thông tin assessment findings
			$data['areas_assessment_findings'] = $this->campaign_model->get_area_with_assessment_findings($id,$data['record']['form_id']);
		} else {
			redirect(base_url('admin/campaign/view/').$id);
		}



		$this->pdf = new Pdf();
		//$this->pdf->Add_Page();

		
		$this->pdf->make_report($data);
		//die();
		//$this->pdf->Open();
	
		header("Content-type: application/pdf");
		$this->pdf->Output('page.pdf','I');
		//$this->pdf->Output();
  }

  public function delete_campaign()
  {
	$id = $this->input->post('id');
	if($id=='')
	{
		$result = 1;
	} else{
		$theCampaign = $this->campaign_model->get_the_campaign($id);
		if(($theCampaign['status'] < 1))
		{
			
			if($this->campaign_model->delete_the_campaign($theCampaign)) // chuyển trạng thái delete = 1;
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
	
	//--------------------------------------------------

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
