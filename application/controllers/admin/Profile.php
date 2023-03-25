<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends MY_Controller {
	
	public function __construct(){
		
		parent::__construct();
		auth_check(); // check login auth
		$this->load->model('admin/admin_model', 'admin_model');
	}

	//-------------------------------------------------------------------------
	public function index(){

		if($this->input->post('submit')){
			$data = array(				
				'firstname' => $this->input->post('firstname'),
				'lastname' => $this->input->post('lastname'),
				'email' => $this->input->post('email'),
				'mobile_no' => $this->input->post('mobile_no'),
				'updated_at' => date('Y-m-d : h:m:s'),
			);
			$data = $this->security->xss_clean($data);
			$result = $this->admin_model->update_user($data);
			if($result){
				$this->session->set_flashdata('success', 'Profile has been Updated Successfully!');
				redirect(base_url('admin/profile'), 'refresh');
			}
		}
		else{

			$data['title'] = 'Admin Profile';
			$data['admin'] = $this->admin_model->get_user_detail();
			
			$this->load->view('admin/includes/_header');
			$this->load->view('admin/profile/index', $data);
			$this->load->view('admin/includes/_footer');
		}
	}

	//-------------------------------------------------------------------------
	public function change_pwd(){

		$id = $this->session->userdata('id');
		var_dump($id);

		if($this->input->post('submit')){

			$this->form_validation->set_rules('old_password', 'Password', 'trim|required');
			$this->form_validation->set_rules('password', 'Password', 'trim|required');
			$this->form_validation->set_rules('confirm_pwd', 'Confirm Password', 'trim|required|matches[password]');

			if ($this->form_validation->run() == FALSE) {
				$data = array(
					'errors' => validation_errors()
				);
				$this->session->set_flashdata('errors', $data['errors']);
				redirect(base_url('admin/profile/change_pwd'),'refresh');
			}
			else{

				$old_password = $this->input->post('old_password');
				//echo $old_password;

				$user = $this->admin_model->get_admin_by_id($id);
				var_dump($user);die();
				if(password_verify($old_password,$user['password']))
				{
					$data = array(
						'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT)
					);

					$data = $this->security->xss_clean($data);
					$result = $this->admin_model->change_pwd($data, $id);
					if($result){
						$this->session->set_flashdata('success', 'Password has been changed successfully!');
						redirect(base_url('admin/profile/change_pwd'));
					}
				} else {
					$this->session->set_flashdata('error', 'Mật khẩu cũ không đúng, vui lòng thử lại!');
						redirect(base_url('admin/profile/change_pwd'));
				}
			}
		}
		else{
			
			$data['title'] = 'Change Password';
			$data['user'] = $this->admin_model->get_user_detail();
			
			$this->load->view('admin/includes/_header');
			$this->load->view('admin/profile/change_pwd', $data);
			$this->load->view('admin/includes/_footer');
		}
	}
}

?>	
