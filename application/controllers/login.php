<?php if (!defined('BASEPATH')) die();

Class Login extends CI_Controller{


	# Main index fucntion for the login controller
	public function index(){

		$data['menu'] = 'templates/menubar';		
		$data['main_content'] = 'templates/login';
		$this->load->view('include/template', $data);
	}

	
	# Validate the credentials entered at login
	public function validate_credentials(){

		$this->load->model('users_model');

		$query = $this->users_model->validate();

		if ($query) {
			$data  = array(
					'username' => $this->input->post('username'),
					'is_logged_in' => true
					);
		
			$this->session->set_userdata($data);
		
			redirect('site/members_area');
		
		} else {

			$this->index();
		}

	}

	public function create_member(){

		$this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email');
		$this->form_validation->set_rules('firstname', 'First Name', 'trim|required');
		$this->form_validation->set_rules('lastname', 'Last Name', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[7]');
		$this->form_validation->set_rules('icode', 'Password Confirmation', 'trim|required|matches[password]');

		if($this->form_validation->run() == FALSE){

			$this->load->view();

		}

	}


}

/* End of file login.php */
/* Location: ./application/controllers/login.php */