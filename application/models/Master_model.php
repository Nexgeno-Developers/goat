<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
*  @author   : Creativeitem
*  date      : November, 2019
*  Ekattor School Management System With Addons
*  http://codecanyon.net/user/Creativeitem
*  http://support.creativeitem.com
*/

class Master_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}
	
	function create_user()
	{
		$data['applicant_name'] = html_escape($this->input->post('applicant_name'));
		$data['license_no'] = html_escape($this->input->post('license_no'));
		$data['registration_no'] = html_escape($this->input->post('registration_no'));

	    $data['valid_from'] = html_escape(date("d-m-Y", strtotime($this->input->post('valid_from'))));
	    $data['valid_to'] = html_escape(date("d-m-Y", strtotime($this->input->post('valid_to'))));
	    $data['application_date'] = html_escape(date("d-m-Y", strtotime($this->input->post('application_date'))));
	    $data['application_status'] = html_escape($this->input->post('application_status'));
	    $data['license_type'] = html_escape($this->input->post('license_type'));
	    $data['fees'] = html_escape($this->input->post('fees'));


		$this->db->insert('app_broker', $data);
		
		$log = array(
			'name' => 'broker_creation',
			'description' => '<b>'.$data['applicant_name'].'</b> Added successfully.',
		 );
		 app_log($log);			

		$response = array(
			'status' => true,
			'notification' => get_phrase('broker_added_successfully')
		);

		return json_encode($response);	    
	}
	
	
	function update_user($id = "")
	{
	    
		$data['applicant_name'] = html_escape($this->input->post('applicant_name'));
		$data['license_no'] = html_escape($this->input->post('license_no'));
		$data['registration_no'] = html_escape($this->input->post('registration_no'));

	    $data['valid_from'] = html_escape(date("d-m-Y", strtotime($this->input->post('valid_from'))));
	    $data['valid_to'] = html_escape(date("d-m-Y", strtotime($this->input->post('valid_to'))));
        $data['application_date'] = html_escape(date("d-m-Y", strtotime($this->input->post('application_date'))));
	    $data['application_status'] = html_escape($this->input->post('application_status'));
	    $data['license_type'] = html_escape($this->input->post('license_type'));
	    $data['fees'] = html_escape($this->input->post('fees'));
	    
	    $this->db->where('id', $id);
	    $this->db->update('app_broker', $data);
	    
			$log = array(
				'name' => 'broker_update',
				'description' => '<b>'.$data['applicant_name'].'</b> Updated successfully.',
			 );
			 app_log($log);	    
	    
		$response = array(
			'status' => true,
			'notification' => get_phrase('broker_updated_successfully')
		);	
		return json_encode($response);	  
	}
	
	
	function create_user_gwala()
	{
		$data['applicant_name'] = html_escape($this->input->post('applicant_name'));
		$data['license_no'] = html_escape($this->input->post('license_no'));
		$data['registration_no'] = html_escape($this->input->post('registration_no'));

	    $data['valid_from'] = html_escape(date("d-m-Y", strtotime($this->input->post('valid_from'))));
	    $data['valid_to'] = html_escape(date("d-m-Y", strtotime($this->input->post('valid_to'))));
	    $data['application_date'] = html_escape(date("d-m-Y", strtotime($this->input->post('application_date'))));
	    $data['application_status'] = html_escape($this->input->post('application_status'));
	    $data['license_type'] = html_escape($this->input->post('license_type'));
	    $data['fees'] = html_escape($this->input->post('fees'));


		$this->db->insert('app_gwala', $data);
		
		$log = array(
			'name' => 'broker_creation',
			'description' => '<b>'.$data['applicant_name'].'</b> Added successfully.',
		 );
		 app_log($log);			

		$response = array(
			'status' => true,
			'notification' => get_phrase('gwala_added_successfully')
		);

		return json_encode($response);	    
	}
	
	
	function update_user_gwala($id = "")
	{
	    
		$data['applicant_name'] = html_escape($this->input->post('applicant_name'));
		$data['license_no'] = html_escape($this->input->post('license_no'));
		$data['registration_no'] = html_escape($this->input->post('registration_no'));

	    $data['valid_from'] = html_escape(date("d-m-Y", strtotime($this->input->post('valid_from'))));
	    $data['valid_to'] = html_escape(date("d-m-Y", strtotime($this->input->post('valid_to'))));
        $data['application_date'] = html_escape(date("d-m-Y", strtotime($this->input->post('application_date'))));
	    $data['application_status'] = html_escape($this->input->post('application_status'));
	    $data['license_type'] = html_escape($this->input->post('license_type'));
	    $data['fees'] = html_escape($this->input->post('fees'));
	    
	    $this->db->where('id', $id);
	    $this->db->update('app_gwala', $data);
	    
			$log = array(
				'name' => 'broker_update',
				'description' => '<b>'.$data['applicant_name'].'</b> Updated successfully.',
			 );
			 app_log($log);	    
	    
		$response = array(
			'status' => true,
			'notification' => get_phrase('gwala_updated_successfully')
		);	
		return json_encode($response);	  
	}

}