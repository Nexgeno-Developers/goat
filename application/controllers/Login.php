<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
*  @author   : Creativeitem
*  date      : November, 2019
*  Ekattor School Management System With Addons
*  http://codecanyon.net/user/Creativeitem
*  http://support.creativeitem.com
*/

class Login extends CI_Controller {


	public function __construct(){
		parent::__construct();

		$this->load->database();
		$this->load->library('session');

		/*LOADING ALL THE MODELS HERE*/
		$this->load->model('Crud_model',     'crud_model');
		$this->load->model('User_model',     'user_model');
		$this->load->model('Settings_model', 'settings_model');
		$this->load->model('Email_model',    'email_model');
		$this->load->model('Frontend_model', 'frontend_model');

		/*cache control*/
		$this->output->set_header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
		$this->output->set_header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
		$this->output->set_header("Cache-Control: post-check=0, pre-check=0", false);
		$this->output->set_header("Pragma: no-cache");

		/*SET DEFAULT TIMEZONE*/
		timezone();
		
	}

	public function index(){
		if($this->session->userdata('superadmin_login') ==  true){
			redirect(route('dashboard'), 'refresh');
		}elseif($this->session->userdata('admin_login') ==  true){
			redirect(route('dashboard'), 'refresh');
		}elseif($this->session->userdata('teacher_login') ==  true){
			redirect(route('dashboard'), 'refresh');
		}elseif($this->session->userdata('parent_login') ==  true){
			redirect(route('dashboard'), 'refresh');
		}elseif($this->session->userdata('student_login') ==  true){
			redirect(route('dashboard'), 'refresh');
		}elseif($this->session->userdata('accountant_login') ==  true){
			redirect(route('dashboard'), 'refresh');
		}elseif($this->session->userdata('librarian_login') ==  true){
			redirect(route('dashboard'), 'refresh');
		}else{
			$this->load->view('login');
		}

	}

	public function validate_login(){
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$credential = array('email' => $email, 'password' => sha1($password));

		// Checking login credential for admin
		$query = $this->db->get_where('users', $credential);
		if ($query->num_rows() > 0) {
			$row = $query->row();
			
			if($row->user_status == 'inactive')
			{
    			$this->session->set_flashdata('error_message', get_phrase('you_ara_temperory_inactivated_by_superadmin'));
    			redirect(site_url('login'), 'refresh');			    
			}


			date_default_timezone_set('Asia/Kolkata');
			$current_time = date('H:i:s');

			$login_time  = $row->login_in_time;
			$logout_time = $row->login_out_time;


			if (!empty($login_time) && !empty($logout_time)) {
				// Case 1: Normal shift (login_time < logout_time)
				// Case 2: Overnight shift (e.g., 22:00:00 to 06:00:00)
				if (
					($login_time <= $logout_time && $current_time >= $login_time && $current_time <= $logout_time) ||
					($login_time > $logout_time && ($current_time >= $login_time || $current_time <= $logout_time))
				) {
					// Time is within allowed range — continue
				} else {
					// Time not allowed — redirect with error
					$this->session->set_flashdata(
						'error_message',
						'Login is only allowed between ' . date('h:i A', strtotime($login_time)) . ' and ' . date('h:i A', strtotime($logout_time))
					);
					redirect(site_url('login'), 'refresh');
				}
			}

			
			$this->session->set_userdata('user_login_type', true);
			if($row->role == 'superadmin'){
				$this->session->set_userdata('superadmin_login', true);
				$this->session->set_userdata('user_id', $row->id);
				$this->session->set_userdata('school_id', $row->school_id);
				$this->session->set_userdata('user_name', $row->name);
				$this->session->set_userdata('user_type', 'superadmin');
				$this->session->set_userdata('role_type', $row->role_type);
				$this->session->set_userdata('gate_no', $row->gate_no);
				$this->session->set_flashdata('flash_message', get_phrase('welcome_back'));
				
    			$log = array(
    				'name' => 'login',
    				'description' => 'logged in successfully.',
    			 );
    			 app_log($log);					
				
				redirect(site_url('superadmin/dashboard'), 'refresh');
			}
			elseif($row->role == 'admin'){
				$this->session->set_userdata('admin_login', true);
				$this->session->set_userdata('user_id', $row->id);
				$this->session->set_userdata('school_id', $row->school_id);
				$this->session->set_userdata('user_name', $row->name);
				$this->session->set_userdata('user_type', 'admin');
				$this->session->set_flashdata('flash_message', get_phrase('welcome_back'));
				redirect(site_url('admin/dashboard'), 'refresh');
			}
			elseif($row->role == 'teacher'){
				$this->session->set_userdata('teacher_login', true);
				$this->session->set_userdata('user_id', $row->id);
				$this->session->set_userdata('school_id', $row->school_id);
				$this->session->set_userdata('user_name', $row->name);
				$this->session->set_userdata('user_type', 'teacher');
				$this->session->set_flashdata('flash_message', get_phrase('welcome_back'));
				redirect(site_url('teacher/dashboard'), 'refresh');
			}
			elseif($row->role == 'student'){
				$this->session->set_userdata('student_login', true);
				$this->session->set_userdata('user_id', $row->id);
				$this->session->set_userdata('school_id', $row->school_id);
				$this->session->set_userdata('user_name', $row->name);
				$this->session->set_userdata('user_type', 'student');
				$this->session->set_flashdata('flash_message', get_phrase('welcome_back'));
				redirect(site_url('student/dashboard'), 'refresh');
			}
			elseif($row->role == 'parent'){
				$this->session->set_userdata('parent_login', true);
				$this->session->set_userdata('user_id', $row->id);
				$this->session->set_userdata('school_id', $row->school_id);
				$this->session->set_userdata('user_name', $row->name);
				$this->session->set_userdata('user_type', 'parent');
				$this->session->set_flashdata('flash_message', get_phrase('welcome_back'));
				redirect(site_url('parents/dashboard'), 'refresh');
			}
			elseif($row->role == 'librarian'){
				$this->session->set_userdata('librarian_login', true);
				$this->session->set_userdata('user_id', $row->id);
				$this->session->set_userdata('school_id', $row->school_id);
				$this->session->set_userdata('user_name', $row->name);
				$this->session->set_userdata('user_type', 'librarian');
				$this->session->set_flashdata('flash_message', get_phrase('welcome_back'));
				redirect(site_url('librarian/dashboard'), 'refresh');
			}
			elseif($row->role == 'accountant'){
				$this->session->set_userdata('accountant_login', true);
				$this->session->set_userdata('user_id', $row->id);
				$this->session->set_userdata('school_id', $row->school_id);
				$this->session->set_userdata('user_name', $row->name);
				$this->session->set_userdata('user_type', 'accountant');
				$this->session->set_flashdata('flash_message', get_phrase('welcome_back'));
				redirect(site_url('accountant/dashboard'), 'refresh');
			}
		}else{
			$this->session->set_flashdata('error_message', get_phrase('invalid_your_email_or_password'));
			redirect(site_url('login'), 'refresh');
		}
	}

	public function logout() {

		$log = array(
			'name' => 'logout',
			'description' => 'logout successfully.',
		 );
		 app_log($log);	
		 
		$this->session->sess_destroy();
		$this->session->set_flashdata('info_message', get_phrase('logged_out'));
		redirect(site_url('login'), 'refresh');
	}

	// RETREIVE PASSWORD
	public function retrieve_password() {
	    echo 'Not found';exit;
		$email = $this->input->post('email');
		$query = $this->db->get_where('users', array('email' => $email));
		if ($query->num_rows() > 0) {
			$query = $query->row_array();
			$new_password = substr( md5( rand(100000000,20000000000) ) , 0,7);

			// updating the database
			$updater = array(
				'password' => sha1($new_password)
			);
			$this->db->where('id', $query['id']);
			$this->db->update('users', $updater);

			// sending mail to user
			$this->email_model->password_reset_email($new_password, $query['id']);

			$this->session->set_flashdata('flash_message', get_phrase('please_check_your_mail_inbox'));
			redirect(site_url('login'), 'refresh');
		}else{
			$this->session->set_flashdata('error_message', get_phrase('wrong_credential'));
			redirect(site_url('login'), 'refresh');
		}
	}
}
