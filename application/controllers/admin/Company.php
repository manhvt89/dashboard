<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Company extends MY_Controller
{
    function __construct(){

        parent::__construct();
        auth_check(); // check login auth
        $this->rbac->check_module_access();

		$this->load->model('admin/admin_model', 'admin');
		$this->load->model('admin/Activity_model', 'activity_model');
		$this->load->model('admin/Company_model', 'company_model');
    }

	//-----------------------------------------------------		
	function index($type=''){

		$data['title'] = 'Companies List';
		$this->load->view('admin/includes/_header');
		$this->load->view('admin/company/index', $data);
		$this->load->view('admin/includes/_footer');
	}

	function list_companies_json()
	{
		$start = empty($this->input->get('start')) ? 0:$this->input->get('start');
		$length = empty($this->input->get('length')) ? 25 : $this->input->get('length');
		$role_id = $this->session->userdata('admin_role_id');
		$records['data'] = $this->company_model->get_all_company($start,$length,$role_id);
		$data = array();
		$i=0;
		foreach ($records['data']  as $row) 
		{  
			//$status = $status . '<label class="tgl-btn" for="cb_'. $row['id'].'"></label>';
			$company_view_evaluation = '';
			if($row['count_branches'] > 0)
			{
				$company_view_evaluation = '<a href="'.base_url('admin/campaign/view_evaluation_company/').$row['id'].'">'.trans('company_view_evaluation').'</a>';
			}
			$company_create_evaluation = '<a href="'.base_url('admin/campaign/create_evaluation/').$row['id'].'">'.trans('company_create_evaluation').'</a>';
			
			$name = "<a href='".base_url("admin/company/view/").$row['company_uuid']."'>".$row['name']."</a>";
			$act =  "<a href='".base_url("admin/company/edit/").$row['company_uuid']."'>Sửa</a>";
			
			$data[]= array(
				++$i,
				$row['id'],
				$name,
				'',
				$row['tel'],
				$row['address'],
				$company_view_evaluation,
				$company_create_evaluation,
				$act,

			);
		}
		$records["draw"] = 1;
		$records["recordsTotal"] = count($data);
		$records["recordsFiltered"] = 57;
		$records['data'] = $data;
		echo json_encode($records);
	}

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

		//$Arrfields = $this->company_model->get_fields(1);
		$typies = array(
			array(
				'id'=>0,
				'text'=>'Công ty mẹ',
				'type_id'=>0
			),
			array(
				'id'=>1,
				'text'=>'CN/VPĐD/NM',
				'type_id'=>1
			),
		);
		
		//$ArrUsers = $this->company_model->get_specialists(1);
		$users = array();
		

		$data['wards'] = json_encode($wards);
		$data['cities'] = json_encode($cities);
		$data['states'] = json_encode($states);
		$data['typies'] = json_encode($typies);
		$data['users'] = json_encode($users);

		$data['messages'] = $this->load->view('admin/includes/_messages',array(), TRUE);

		if($this->input->post('submit')){
				$this->form_validation->set_rules('companyname', 'companyname', 'trim|required|xss_clean|strip_tags');

				$this->form_validation->set_rules('address', 'address', 'trim|required|xss_clean|strip_tags');
				$this->form_validation->set_rules('company_tel', 'Number', 'trim|required|xss_clean|strip_tags');
				//$this->form_validation->set_rules('company_fax', 'Number', 'trim|required');
				$this->form_validation->set_rules('state', 'state', 'trim|required');
				$this->form_validation->set_rules('city', 'city', 'trim|required');
				$this->form_validation->set_rules('ward', 'ward', 'trim|required');
				//$this->form_validation->set_rules('leader', 'leader', 'trim|required');
				//$this->form_validation->set_rules('member', 'member', 'trim|required');
				//$leader = $this->input->post('leader');
				//$members = $this->input->post('member[]');
				// if(!empty($members))
				// {
				// 	foreach($members as $key=>$member)
				// 	{
				// 		if($member == $leader)
				// 		{
				// 			unset($members[$key]);
				// 		}
				// 	}
				// }
				//var_dump($members);die();
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
						'tel' => $this->input->post('company_tel'),
						'company_number' => $this->input->post('company_number'),
						'type' => $this->input->post('type'),
						
						'state_id' => $this->input->post('state'),
						'city_id' => $this->input->post('city'),
						'wards_id' => $this->input->post('ward'),
						'created_date' => date('m-d-Y h:m:s',time()),
						'type'=>0,
						'country_id'=>238, //Vietnam
						'code'=>time(),
						'owner_id'=>0,
						'creator_id' => $this->session->userdata('id')
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

	function view($id=""){
		if($id==""){
			redirect('admin/company');
		}
		else{
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

			$Arrfields = $this->company_model->get_fields(1);
			$fields = array();

			foreach($Arrfields as $field)
			{
				$t = array(
					'id'=>$field['id'],
					'text'=>$field['name']
				);
				$fields[] = $t;
			}

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

			$data['wards'] = json_encode($wards);
			$data['cities'] = json_encode($cities);
			$data['states'] = json_encode($states);
			$data['fields'] = json_encode($fields);
			$data['users'] = json_encode($users);

			$data['record'] = $this->company_model->get_the_company($id);
			if(!empty($data['record']))
			{
				$company_address = $data['record']['address'].', '.$wards[$data['record']['wards_id']].', '.$cities[$data['record']['city_id']].', '.$states[$data['record']['state_id']];
			} else {
				$company_address = '';
			}
			$data['company_address'] = $company_address;
			$this->load->view('admin/includes/_header');
			$this->load->view('admin/company/view', $data);
			$this->load->view('admin/includes/_footer');
		}
	}
	function edit($id=""){

		if($this->input->post('submit')){
			$id = $this->input->post('id');
			$this->form_validation->set_rules('companyname', 'companyname', 'trim|required|xss_clean|strip_tags');
			$this->form_validation->set_rules('company_authorized', 'company_authorized', 'trim|required|xss_clean|strip_tags');
			$this->form_validation->set_rules('main_product', 'main_product', 'trim|required|xss_clean|strip_tags');
			$this->form_validation->set_rules('address', 'address', 'trim|required|xss_clean|strip_tags');
			$this->form_validation->set_rules('company_phone', 'Number', 'trim|required|xss_clean|strip_tags');
			$this->form_validation->set_rules('company_fax', 'Number', 'trim|required|xss_clean|strip_tags');
			$this->form_validation->set_rules('state', 'state', 'trim|required');
			$this->form_validation->set_rules('city', 'city', 'trim|required');
			$this->form_validation->set_rules('ward', 'ward', 'trim|required');
			$this->form_validation->set_rules('field', 'field', 'trim|required');
			//$this->form_validation->set_rules('leader', 'leader', 'trim|required');
		
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
					'field_id'=>$this->input->post('field'),
				);
				$data = $this->security->xss_clean($data);
				
				$result = $this->company_model->edit_company($data, $id);
				//var_dump($result); die();
				if($result){
					// Activity Log 
					$this->activity_model->add_log(5);

					$this->session->set_flashdata('success', 'Admin has been updated successfully!');
					redirect(base_url('admin/company'));
				}
			}
		}
		elseif($id==""){
			redirect('admin/company');
		}
		else{
			$this->rbac->check_operation_access(); // check opration permission
			
			$data['record'] = $this->company_model->get_the_company($id);

			//var_dump($data['record']); die();
			if(empty($data['record']))
			{
				redirect('admin/company');
			}
			
			$ArrStates = $this->company_model->get_states();
			$states = array();
			
			foreach($ArrStates as $state)
			{
				if($state['id'] == $data['record']['state_id'])
				{
					$t = array(
						'id'=>$state['id'],
						'text'=>$state['name'],
						'selected'=>true,
					);

				} else {
					$t = array(
						'id'=>$state['id'],
						'text'=>$state['name'],
					);
				}
				$states[] = $t;
			}

			//var_dump($states);die();

			$ArrCity = $this->company_model->get_cities();
			$cities = array();
			foreach($ArrCity as $city)
			{
				if($city['id'] == $data['record']['city_id'])
				{
					$t = array(
						'id'=>$city['id'],
						'text'=>$city['name'],
						'selected'=>true,
						'state_id'=>$city['state_id']
						
					);

				} else{
					$t = array(
						'id'=>$city['id'],
						'text'=>$city['name'],
						'state_id'=>$city['state_id']
					);
				}
				$cities[] = $t;
			}

			$ArrWards = $this->company_model->get_wards();
			$wards = array();
			foreach($ArrWards as $city)
			{
				if($city['id'] == $data['record']['wards_id'])
				{
					$t = array(
						'id'=>$city['id'],
						'text'=>$city['name'],
						'selected'=>true,
						'city_id'=>$city['city_id']
						
					);
				} else {
					$t = array(
						'id'=>$city['id'],
						'text'=>$city['name'],
						'city_id'=>$city['city_id']
					);
				}
				$wards[] = $t;
			}

			$Arrfields = $this->company_model->get_fields(1);
			$fields = array();

			foreach($Arrfields as $field)
			{
				if($field['id'] == $data['record']['field_id'])
				{
					$t = array(
						'id'=>$field['id'],
						'text'=>$field['name'],
						'selected'=>true,
					);
				} else {
					$t = array(
						'id'=>$field['id'],
						'text'=>$field['name']
					);
				}
				
				$fields[] = $t;
			}

			$ArrUsers = $this->company_model->get_specialists(1);
			

			$data['jsonwards'] = json_encode($wards);
			$data['jsoncities'] = json_encode($cities);
			$data['jsonstates'] = json_encode($states);
			$data['jsonfields'] = json_encode($fields);
			//$data['jsonusers'] = json_encode($users);

			$data['wards'] = $wards;
			$data['cities'] = $cities;
			$data['states'] = $states;
			$data['fields'] = $fields;

			$data['record'] = $this->company_model->get_the_company($id);
			// $members_company = $this->company_model->get_users_company($id);
			// $_leader = '';
			// $_members = array();
			// if(!empty($members_company))
			// {
			// 	foreach($members_company as $key=>$value)
			// 	{
			// 		if($value['type'] == 1)
			// 		{
			// 			$_leader=$value;
			// 		} else{
			// 			$_members[$value['user_id']] = $value['user_id'];
			// 		}
			// 	}
			// }
			// $data['_members'] = json_encode($_members);
			// $data['leader'] = $_leader;
			// Xử lý dropbox Member
			// $arrMember = array();
			// foreach($ArrUsers as $user)
			// {
			// 	if($user['id'] == $_leader['user_id'])
			// 	{
			// 		$t = array(
			// 			'id'=>$user['id'],
			// 			'text'=>$user['name'],
			// 			"disabled"=> true
			// 		);
			// 	} else {
			// 		if(isset($_members[$user['id']]))
			// 		{
			// 			$t = array(
			// 				'id'=>$user['id'],
			// 				'text'=>$user['name'],
			// 				"selected"=> true
			// 			);
			// 		} else {
			// 			$t = array(
			// 				'id'=>$user['id'],
			// 				'text'=>$user['name']
			// 			);
			// 		}
			// 	}
			// 	$arrMember[] = $t;
			// }
			//xử lý dropbox leader 
			// $arrLeader = array();
			// foreach($ArrUsers as $user)
			// {
				
			// 	if(isset($_members[$user['id']]))
			// 	{
			// 		$t = array(
			// 			'id'=>$user['id'],
			// 			'text'=>$user['name'],
			// 			"disabled"=> true
			// 		);
			// 	} else {
			// 		if($user['id'] == $_leader['user_id'])
			// 		{
			// 			$t = array(
			// 				'id'=>$user['id'],
			// 				'text'=>$user['name'],
			// 				"selected"=> true
			// 			);
			// 		} else {
			// 			$t = array(
			// 				'id'=>$user['id'],
			// 				'text'=>$user['name']
			// 			);
			// 		}
			// 	}
			// 	$arrLeader[] = $t;
			// }
			
			// $data['arrLeader'] = json_encode($arrLeader);
			// $data['arrMember'] = json_encode($arrMember);

			//var_dump($leader); die();			
			
			$this->load->view('admin/includes/_header');
			$this->load->view('admin/company/edit', $data);
			$this->load->view('admin/includes/_footer');
		}		
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
