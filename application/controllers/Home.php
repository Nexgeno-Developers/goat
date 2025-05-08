<?php
defined('BASEPATH') OR exit('No direct script access allowed');
echo 'no access';exit;
/*
*  @author   : Creativeitem
*  date      : November, 2019
*  Ekattor School Management System With Addons
*  http://codecanyon.net/user/Creativeitem
*  http://support.creativeitem.com
*/

class Home extends CI_Controller {
	protected $theme;
	protected $active_school_id;

	public function __construct(){
		parent::__construct();

		$this->load->database();
		$this->load->library('session');

		/*LOADING ALL THE MODELS HERE*/
		$this->load->model('Crud_model',     'crud_model');
		$this->load->model('User_model',     'user_model');
		$this->load->model('Settings_model', 'settings_model');
		$this->load->model('Payment_model',  'payment_model');
		$this->load->model('Email_model',    'email_model');
		$this->load->model('Addon_model',    'addon_model');
		$this->load->model('Frontend_model', 'frontend_model');

		if (addon_status('alumni')) {
			$this->load->model('addons/Alumni_model','alumni_model');
		}
		/*cache control*/
		$this->output->set_header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
		$this->output->set_header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
		$this->output->set_header("Cache-Control: post-check=0, pre-check=0", false);
		$this->output->set_header("Pragma: no-cache");

		/*SET DEFAULT TIMEZONE*/
		timezone();

		$this->theme = get_frontend_settings('theme');
		$this->active_school_id = $this->frontend_model->get_active_school_id();

		//redirect(site_url(), 'refresh');
	}

	// INDEX FUNCTION
	// default function
	public function index() {
		$page_data['page_name']  = 'home';
		$page_data['page_title'] = get_phrase('home');
		$this->load->view('frontend/'.$this->theme.'/index', $page_data);
	}

	//ABOUT PAGE
	function about() {
		$page_data['page_name']  = 'about';
		$page_data['page_title'] = get_phrase('about_us');
		$this->load->view('frontend/'.$this->theme.'/index', $page_data);
	}

	// TEACHERS PAGE
	function teachers() {
		$count_teachers = $this->db->get_where('users', array('role' => 'teacher', 'school_id' => $this->active_school_id))->num_rows();
		$config = array();
		$config = manager($count_teachers, 9);
		$config['base_url']  = site_url('home/teachers/');
		$this->pagination->initialize($config);

		$page_data['per_page']    = $config['per_page'];
		$page_data['page_name']  = 'teacher';
		$page_data['page_title'] = get_phrase('teachers');
		$this->load->view('frontend/'.$this->theme.'/index', $page_data);
	}

	// EVENTS GETTING
	function events() {
		$count_events = $this->db->get_where('frontend_events', array('status' => 1, 'school_id' => $this->active_school_id))->num_rows();
		$config = array();
		$config = manager($count_events, 8);
		$config['base_url']  = site_url('home/events/');
		$this->pagination->initialize($config);

		$page_data['per_page']    = $config['per_page'];
		$page_data['page_name']  = 'event';
		$page_data['page_title'] = get_phrase('event_list');
		$this->load->view('frontend/'.$this->theme.'/index', $page_data);
	}

	// SCHOOL WISE GALLERY
	function gallery() {
		$count_gallery = $this->db->get_where('frontend_gallery', array('show_on_website' => 1, 'school_id' => $this->active_school_id))->num_rows();
		$config = array();
		$config = manager($count_gallery, 6);
		$config['base_url']  = site_url('home/gallery/');
		$this->pagination->initialize($config);

		$page_data['per_page']    = $config['per_page'];
		$page_data['page_name']  = 'gallery';
		$page_data['page_title'] = get_phrase('gallery');
		$this->load->view('frontend/'.$this->theme.'/index', $page_data);
	}

	// GALLERY DETAILS
	function gallery_view($gallery_id = '') {
		$count_images = $this->db->get_where('frontend_gallery_image', array(
			'frontend_gallery_id' => $gallery_id
		))->num_rows();
		$config = array();
		$config = manager($count_images, 9);
		$config['base_url']  = site_url('home/gallery_view/'.$gallery_id.'/');
		$this->pagination->initialize($config);

		$page_data['per_page']    = $config['per_page'];
		$page_data['gallery_id']  = $gallery_id;
		$page_data['page_name']  = 'gallery_view';
		$page_data['page_title'] = get_phrase('gallery');
		$this->load->view('frontend/'.$this->theme.'/index', $page_data);
	}

	//GET THE CONTACT PAGE
	function contact($param1 = '') {

		if ($param1 == 'send') {
			if(!$this->crud_model->check_recaptcha() && get_common_settings('recaptcha_status') == true){
				redirect(site_url('home/contact'), 'refresh');
			}
			$this->frontend_model->send_contact_message();
			redirect(site_url('home/contact'), 'refresh');
		}
		$page_data['page_name']  = 'contact';
		$page_data['page_title'] = get_phrase('contact_us');
		$this->load->view('frontend/'.$this->theme.'/index', $page_data);
	}

	//GET THE PRIVACY POLICY PAGE
	function privacy_policy() {
		$page_data['page_name']  = 'privacy_policy';
		$page_data['page_title'] = get_phrase('privacy_policy');
		$this->load->view('frontend/'.$this->theme.'/index', $page_data);
	}

	//GET THE TERMS AND CONDITION PAGE
	function terms_conditions() {
		$page_data['page_name']  = 'terms_conditions';
		$page_data['page_title'] = get_phrase('terms_and_conditions');
		$this->load->view('frontend/'.$this->theme.'/index', $page_data);
	}

	//GET THE ALLUMNI EVENT PAGE IF THE ADDON IS ENABLED
	function alumni_event() {
		if (addon_status('alumni')) {
			$page_data['page_name']  = 'alumni_event';
			$page_data['page_title'] = get_phrase('alumni_event');
			$this->load->view('frontend/'.$this->theme.'/index', $page_data);
		}else{
			redirect(site_url(), 'refresh');
		}
	}

	//GET THE ALLUMNI GALLERY PAGE IF THE ADDON IS ENABLED
	function alumni_gallery() {
		if (addon_status('alumni')) {
			$page_data['page_name']  = 'alumni_gallery';
			$page_data['page_title'] = get_phrase('alumni_gallery');
			$this->load->view('frontend/'.$this->theme.'/index', $page_data);
		}else{
			redirect(site_url(), 'refresh');
		}
	}

	//GET THE ALLUMNI GALLERY DETAILS
	function alumni_gallery_view($gallery_id = '') {
		if (addon_status('alumni')) {
			$count_images = $this->db->get_where('alumni_gallery_photos', array(
				'gallery_id' => $gallery_id
			))->num_rows();
			$config = array();
			$config = manager($count_images, 9);
			$config['base_url']  = site_url('home/alumni_gallery_view/'.$gallery_id.'/');
			$this->pagination->initialize($config);

			$page_data['per_page']    = $config['per_page'];
			$page_data['gallery_id']  = $gallery_id;
			$page_data['page_name']  = 'alumni_gallery_view';
			$page_data['page_title'] = get_phrase('alumni_gallery');
			$this->load->view('frontend/'.$this->theme.'/index', $page_data);
		}else{
			redirect(site_url(), 'refresh');
		}
	}

	// NOTICEBOARD
	function noticeboard() {
		$count_notice = $this->db->get_where('noticeboard', array('show_on_website' => 1, 'school_id' => $this->active_school_id, 'session' => active_session()))->num_rows();
		$config = array();
		$config = manager($count_notice, 9);
		$config['base_url']  = site_url('home/noticeboard/');
		$this->pagination->initialize($config);

		$page_data['per_page']    = $config['per_page'];
		$page_data['page_name']  = 'noticeboard';
		$page_data['page_title'] = get_phrase('noticeboard');
		$this->load->view('frontend/'.$this->theme.'/index', $page_data);
	}

	function notice_details($notice_id = '') {
		$page_data['notice_id'] = $notice_id;
		$page_data['page_name']  = 'notice_details';
		$page_data['page_title'] = get_phrase('notice_details');
		$this->load->view('frontend/'.$this->theme.'/index', $page_data);
	}


	// ACTIVE SCHOOL ID FOR FRONTEND
	function active_school_id_for_frontend($active_school_id) {
		if (addon_status('multi-school')) {
			$this->session->set_userdata('active_school_id', $active_school_id);
		}else{
			$active_school_id = get_settings('school_id');
			$this->session->set_userdata('active_school_id', $active_school_id);
		}
	}
	
	
	public function prebooking_registration(){
	    $this->load->view('frontend/prebooking_registration');
	}
	
	public function create_prebooking(){
	    ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
	    
        $this->load->library('form_validation');
        
        // Set validation rules for each input field
        $this->form_validation->set_rules('name', 'Name', 'required|min_length[3]|max_length[50]');
        $this->form_validation->set_rules('phone', 'Phone', 'required|min_length[10]|max_length[10]');
        $this->form_validation->set_rules('aadhar_no', 'Aadhar Number', 'required|min_length[12]|max_length[12]');
        $this->form_validation->set_rules('address', 'Address', 'required|min_length[3]|max_length[90]');
        $this->form_validation->set_rules('goat_no', 'Animal Quantity', 'required|max_length[10]');
        $this->form_validation->set_rules('state', 'State', 'required|min_length[3]|max_length[50]');
        $this->form_validation->set_rules('locality', 'Location', 'required|min_length[3]|max_length[50]');
        $this->form_validation->set_rules('exp_date', 'Expected Date', 'required|min_length[3]|max_length[20]');
        $this->form_validation->set_rules('vehicle_no', 'Vehicle Number', 'required|min_length[3]|max_length[20]');
        $this->form_validation->set_rules('route', 'Route', 'required|min_length[3]|max_length[90]');
        $this->form_validation->set_rules('image', 'Image', 'callback_validate_image');
        
        if ($this->form_validation->run() === FALSE) {
            // Get validation errors
            $validation_errors = validation_errors();
        
            // Store the form data in session
            $this->session->set_userdata('user_vyapari', $this->input->post());
        
            // Set flash data with validation errors
            $this->session->set_flashdata('error_msg', $validation_errors);
        
            // Redirect to the same page
            redirect(base_url('prebooking_registration'));
        } else {
            // Form validation passed, proceed with data insertion
            
            // Validation succeeded, process the uploaded image
            $upload_config['upload_path'] = './uploads/vyapari_photo/';  // Specify the directory where you want to upload the image
            $upload_config['allowed_types'] = 'jpg|jpeg|png';  // Define the allowed image formats
            $upload_config['max_size'] = 2048;  // Set the maximum file size in kilobytes (2MB in this case)
            $upload_config['encrypt_name'] = TRUE;  // Rename the uploaded file

            $this->load->library('upload', $upload_config);

            if (!$this->upload->do_upload('image')) {
                // Image upload failed, handle the error
                
                $this->session->set_userdata('user_vyapari', $this->input->post());
                
                $this->session->set_flashdata('error_msg', 'Your Image does not match the required format. Please upload a valid Image <br> आपका फोटो आवश्यक प्रारूप से मेल नहीं खाता है। कृपया एक वैध फोटो अपलोड करें');                
                redirect(base_url('prebooking_registration'));
                
            } else {
                $upload_data = $this->upload->data();
                $file_name = $upload_data['file_name'];
                $image_path = 'uploads/vyapari_photo/' . $file_name;
            }            
        
            // Retrieve the validated input values
            $app_vyapari['name'] = $this->input->post('name', TRUE);
            $app_vyapari['phone'] = $this->input->post('phone', TRUE);
            $app_vyapari['aadhar_no'] = $this->input->post('aadhar_no', TRUE);
            $app_vyapari['address'] = $this->input->post('address', TRUE);
            $app_vyapari['animal_quantity'] = $this->input->post('goat_no', TRUE);
            $app_vyapari['state'] = $this->input->post('state', TRUE);
            $app_vyapari['locality'] = $this->input->post('locality', TRUE);
            $app_vyapari['photo'] = $image_path;
            $app_vyapari['expected_date'] = $this->input->post('exp_date', TRUE);
            $app_vyapari['vehicle_no'] = $this->input->post('vehicle_no', TRUE);
            $app_vyapari['route'] = $this->input->post('route', TRUE);
            $app_vyapari['timestamp'] = date('Y-m-d H:i:s');
        	    
	        /*$photoname = time();
            if (!empty($_FILES['image']['name'])) {
                $app_vyapari['photo'] = $photoname . 'photo.jpg';
                $path = 'uploads/vyapari_photo/' . $app_vyapari['photo'];
                move_uploaded_file($_FILES['image']['tmp_name'], $path);
                // compressImage($path, $path, 30);
            }*/
            
            $is_exist_phone = $this->db->select('id')->where('phone', $app_vyapari['phone'])->get('vyapari_detail')->num_rows();
            $is_exist_aadhar_no = $this->db->select('vyapari_id')->where('aadhar_no', $app_vyapari['aadhar_no'])->get('app_vyapari')->num_rows();
            
            if($is_exist_phone > 0)
    		{
    		    $this->session->set_userdata('user_vyapari', $this->input->post());
    		    
                $this->session->set_flashdata('error_msg', 'Phone Number Alreadyc Exist <br> फ़ोन नंबर पहले से मौजूद है');
                redirect(base_url('prebooking_registration'));
    		}
    		
    		if($is_exist_aadhar_no > 0)
    		{
    		    $this->session->set_userdata('user_vyapari', $this->input->post());
    		    
                $this->session->set_flashdata('error_msg', 'Aadhar Number Alreadyc Exist <br> आधार नंबर पहले से मौजूद हैूद है');
                redirect(base_url('prebooking_registration'));
    		}
            
		    $this->db->insert('prebooking_vyapari', $app_vyapari);
		    old_vyapari_check($this->input->post());
		    
		    $this->session->unset_userdata('user_vyapari');
		    
		    $this->session->set_flashdata('success_msg', 'Your information has been successfully incorporated <br> आपकी जानकारी सफलतापूर्वक शामिल कर ली गई है ');
		    
		    redirect(base_url('prebooking_registration'));
        }
	    
	}
	
	
    public function validate_image($image) {
        if (empty($_FILES['image']['name'])) {
            $this->form_validation->set_message('validate_image', 'The {field} field is required.');
            return FALSE;
        } elseif ($_FILES['image']['size'] > 2048 * 1024) {
            $this->form_validation->set_message('validate_image', 'The {field} size must not exceed 2MB.');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
      public function aadhar_vyapari_detail(){
          $aadhar_no = $this->input->post('Aadhar_no');
          
          $vyapari_data = $this->db->where('aadhar_no', $aadhar_no)->get('vyapari_detail')->row();
          
          if($vyapari_data){
              echo json_encode(array("Status" => "True","vyapari" => $vyapari_data));
          }else{
              echo json_encode(array("Status" => "False"));
          }
      }
	
	public function email_alldayrecord(){
	     /*$total_in = $this->db->select('status')->from('app_qrcode')->where_in('status', array('unblock', 'exit'))->get()->num_rows();
	     $total_out = $this->db->select('status')->from('app_qrcode')->where('status', 'exit')->get()->num_rows();
	     

	     
	     $current_date = date('Y-m-d 06:00:00');
         $date = date('Y-m-d H:i:s', strtotime($current_date. ' - 1 days'));
         
	     
	     $this->db->select('exit_gate, COUNT("vyapari_id") AS Number_of_Goat');
	     $this->db->from('app_qrcode');
	     $this->db->where('status', 'exit');
	     $this->db->where('inward_date BETWEEN "'. $date .'" AND "'. $current_date .'"');
	     $this->db->group_by('exit_gate');
	     $exit_data = $this->db->get()->result();
	     
	     echo nl2br('Yesterday Goat IN and OUT Report'."\n");
	     
	     echo nl2br('inward :'.$total_in."\n");
	     echo nl2br('Outward :'.$total_out."\n");
	     
	     
	     foreach($exit_data as $row){
	         echo nl2br('Gate No : '.$row->exit_gate.' No of Goat Exit is '.$row->Number_of_Goat);
	         echo nl2br("\n");
	     };
	     
	    
	    
	    $this->load->library('email');

        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'smtp-relay.sendinblue.com',
            'smtp_port' => '2525',
            'smtp_user' => 'bigdeals24x7@gmail.com',
            'smtp_pass' => 'pmXZONY29gckQ3dK',
            'mailtype' => 'html',
            'charset' => 'utf-8'
        );
        
        $config['newline'] = "\r\n";
        
        $this->email->initialize($config);
        
        $this->email->from('khanfaisal.makent@gmail.com', 'faisal');
        $this->email->to('webdeveloper@nexgeno.in');
        
        $this->email->subject('Email Subject');
        $this->email->message('hi');
        
        if ($this->email->send()) {
            echo 'Email sent successfully.';
        } else {
            echo 'Error sending email: ' . $this->email->print_debugger();
        }
	   
	     */
        
	}
	

	
}
