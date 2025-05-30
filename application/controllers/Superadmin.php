<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
*  @author   : Creativeitem
*  date      : November, 2019
*  Ekattor School Management System With Addons
*  http://codecanyon.net/user/Creativeitem
*  http://support.creativeitem.com
*/

class Superadmin extends CI_Controller {
  public function __construct(){

    parent::__construct();

    $this->load->database();
    $this->load->library('session');
    $this->load->driver('cache', ['adapter' => 'file']);

    /*LOADING ALL THE MODELS HERE*/
    $this->load->model('Crud_model',     'crud_model');
    $this->load->model('User_model',     'user_model');
    $this->load->model('Settings_model', 'settings_model');
    $this->load->model('Payment_model',  'payment_model');
    $this->load->model('Email_model',    'email_model');
    $this->load->model('Addon_model',    'addon_model');
    $this->load->model('Frontend_model', 'frontend_model');
    $this->load->model('Deonar_model', 'deonar_model');
    $this->load->model('Master_model', 'master_model');

    /*cache control*/
    $this->output->set_header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
    $this->output->set_header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    $this->output->set_header("Cache-Control: post-check=0, pre-check=0", false);
    $this->output->set_header("Pragma: no-cache");

    /*SET DEFAULT TIMEZONE*/
    timezone();

    /*LOAD EXTERNAL LIBRARIES*/
    $this->load->library('pdf');

    if($this->session->userdata('superadmin_login') != 1){
      redirect(site_url('login'), 'refresh');
    }
  }
  //dashboard
  public function index(){
    redirect(route('dashboard'), 'refresh');
  }
  
  public function redirect_view()
  {
      if(!empty( $this->uri->segment(3)))
      {
          $vyapari_id = $this->db->where('temp_code', $this->uri->segment(3))->get('app_vyapari')->row()->vyapari_id;
          redirect(route('manage_vyapari/view/'.$vyapari_id));          
      }
  }

  public function manage_vyapari($param1 = '', $param2 = '', $param3 = ''){

    if($param1 == 'create')
    {
      $response = $this->deonar_model->vyapari_create();
      echo $response;
    }
    
    if($param1 == 'update_vyapari')
    {
      $response = $this->deonar_model->vyapari_update($param2);
      echo $response;
    }     
    
    if($param1 == 'UploadWebCamImage')
    {
      $response = $this->deonar_model->UploadWebCamImage();
      echo $response;
    }    

    if($param1 == 'update_pandaal')
    {
      $response = $this->deonar_model->vyapari_pandaal_update($param2);
      echo $response;
    }  
    
    if($param1 == 'insert_qrcode')
    {
      $response = $this->deonar_model->qrcode_insert();
      echo $response;
    }
    
    if($param1 == 'bulk_insert_qrcode')
    {
      $response = $this->deonar_model->bulk_insert_qrcode($param2);
      echo $response;
    }    
    
    if($param1 == 'complaint_qrcode')
    {
      $response = $this->deonar_model->qrcode_complaint($param2);
      echo $response;
    }  
    
    if($param1 == 'bulk_complaint_qrcode')
    {
      $response = $this->deonar_model->bulk_complaint_qrcode($param2);
      echo $response;
    }
    
    if($param1 == 'bulk_delete_qrcode')
    {
      $response = $this->deonar_model->bulk_delete_qrcode($param2);
      echo $response;
    } 
    
    if($param1 == 'bulk_transfer_qrcode')
    {
      $response = $this->deonar_model->bulk_transfer_qrcode($param2);
      echo $response;
    }    
    
    if($param1 == 'reallocate_qrcode')
    {
      $response = $this->deonar_model->reallocate_qrcode();
      echo $response;
    }    
    
    if($param1 == 'print')
    {
        set_time_limit(300);
        $this->load->library('pdf');
        $page_info['vyapari_id'] = $param2;
        $this->pdf->loadHtml($this->load->view('backend/superadmin/vyapari/printid', $page_info, true));
        //$this->pdf->set_paper(array(0,0,680,920)); //array(0,0,250,150) array(0,0,567.00,283.80)
        $this->pdf->render();		
        $filename = 'printid.pdf';
        $this->pdf->stream($filename, array("Attachment"=>0));
    }    
    
    if($param1 == 'get_localities')
    {
        $localities = get_locality_by_state($state_id);
        $options = '<option value="">Select Locality</option>';
        $x = 0;
        foreach($localities as $row)
        {
            $options .= '<option value="'.$row['id'].'">'.$row['locality'].'</option>';
            $x++;
        }
        
        if($x == 0)
        {
            $options = '<option value="">No Option Available...</option>';
        }            
        
        echo $options;
    }     

    if($param1 == 'delete'){
      $response = $this->crud_model->class_delete($param2);
      echo $response;
    }

    if($param1 == 'section'){
      $response = $this->crud_model->section_update($param2);
      echo $response;
    }

    // show data from database
    if ($param1 == 'list')
    {
      $this->load->view('backend/superadmin/vyapari/list');
    }

    // show data from database
    if($param1 == 'ajaxlist')
    {
        $post = $this->input->post();
        $data = $this->deonar_model->get_all_vyapari($post);
        echo json_encode($data);
    }  
    
    // view vyapari details
    if ($param1 == 'view')
    {
      $page_data['page_name']  = 'vyapari/view';
      $page_data['page_title'] = 'Vyapari Details';
      $page_data['vyapari_id'] = $param2;
      $this->load->view('backend/index', $page_data);
    }    

    if(empty($param1)){
      $page_data['folder_name'] = 'vyapari';
      $page_data['page_title'] = 'Manage vyapari';
      $this->load->view('backend/index', $page_data);
    }
  }
  
  public function manage_vyapari_prebooking($param1 = '', $param2 = '', $param3 = ''){

    // show data from database
    if ($param1 == 'list')
    {
      $this->load->view('backend/superadmin/vyapari_prebooking/list');
    }

    // show data from database
    if($param1 == 'ajaxlist')
    {
        $post = $this->input->post();
        $data = $this->deonar_model->get_all_prebooking_vyapari($post);
        echo json_encode($data);
    }  

    if(empty($param1)){
      $page_data['folder_name'] = 'vyapari_prebooking';
      $page_data['page_title'] = 'Vyapari Prebooking';
      $this->load->view('backend/index', $page_data);
    }
  }  
  
    public function exit_verification($param1 = '', $param2 = '', $param3 = '')
    {
        
        if($param1 == 'mark_complete')
        {
            $response = $this->deonar_model->mark_complete_qrcode();
            echo $response;
        }
        
        if (empty($param1))
        {
            $page_data['page_name']  = 'vyapari/exit-gate/verification';
            $page_data['page_title'] = 'Exit Verification';
            $this->load->view('backend/index', $page_data);
        }    
    } 
    
    public function reports($param1 = '', $param2 = '', $param3 = '')
    {
        if($param1 == 'blocked')
        {
            $page_data['page_name']  = 'vyapari/reports/blocked-qrcode';
            $page_data['page_title'] = 'Blocked Passes';
            $this->load->view('backend/index', $page_data);
        }
        
        if($param1 == 'blocked_ajaxlist')
        {
            $post = $this->input->post();
            $data = $this->deonar_model->blocked_ajaxlist($post);
            echo json_encode($data);
        }  
        
        if($param1 == 'inward')
        {
            $page_data['page_name']  = 'vyapari/reports/inward-qrcode';
            $page_data['page_title'] = 'Inward Passes';
            $this->load->view('backend/index', $page_data);
        }
        
        if($param1 == 'inward_ajaxlist')
        {
            $post = $this->input->post();
            $data = $this->deonar_model->inwardpasses_ajaxlist($post);
            echo json_encode($data);
        } 
        
        if($param1 == 'outward')
        {
            $page_data['page_name']  = 'vyapari/reports/outward-qrcode';
            $page_data['page_title'] = 'Outward Passes';
            $this->load->view('backend/index', $page_data);
        }
        
        if($param1 == 'outward_ajaxlist')
        {
            $post = $this->input->post();
            $data = $this->deonar_model->outwardpasses_ajaxlist($post);
            echo json_encode($data);
        }
        
        if($param1 == 'pandol-availability')
        {
            $page_data['page_name']  = 'vyapari/reports/pandol-availability';
            $page_data['page_title'] = 'Pandol Availability';
            $this->load->view('backend/index', $page_data);
        }

        if($param1 == 'pandol-availability-map')
        {
            $page_data['page_name']  = 'vyapari/reports/pandol-availability-map';
            $page_data['page_title'] = 'Pandol Availability Map';
            $this->load->view('backend/index', $page_data);
        }        
        
        if($param1 == 'gwala')
        {
            $page_data['page_name']  = 'vyapari/reports/gwala';
            $page_data['page_title'] = 'Agent (Dawanwala)';
            $this->load->view('backend/index', $page_data);
        }
        
        if($param1 == 'dawanwala_ajaxlist')
        {
            $post = $this->input->post();
            $data = $this->deonar_model->dawanwala_ajaxlist($post);
            echo json_encode($data);
        } 
    }
    
    public function manage_admins($param1 = '', $param2 = '', $param3 = '')
    {
        if($param1 == 'user_status')
        {
            $response = $this->deonar_model->admin_status($param2, $param3);
            echo $response;
        }
        
            if($param1 == 'create')
            {
                $response = $this->user_model->create_user($param2);
                echo $response;
            }
            
            if($param1 == 'update')
            {
                $response = $this->user_model->update_user($param2);
                echo $response;
            } 
            
            if($param1 == 'update_gate')
            {
                $response = $this->user_model->update_user_gate($param2);
                echo $response;
            }
            
            if($param1 == 'print')
            {
                set_time_limit(300);
                $this->load->library('pdf');
                $page_info['vyapari_id'] = $param2;
                $this->pdf->loadHtml($this->load->view('backend/superadmin/manage-users/printid', $page_info, true));
                $this->pdf->render();		
                $filename = 'printid.pdf';
                $this->pdf->stream($filename, array("Attachment"=>0));
            } 
        
        // show data from database
        if ($param1 == 'list')
        {
          $this->load->view('backend/superadmin/manage-users/list');
        }        
        
        if (empty($param1))
        {
            $page_data['folder_name']  = 'manage-users';
            $page_data['page_title'] = 'Manage Users';
            $this->load->view('backend/index', $page_data);
        }    
    }  
    
// ============= 2024 ========================== 
    
    public function manage_broker($param1 = '', $param2 = '', $param3 = '')
    {
            // if($param1 == 'user_status')
            // {
            //     $response = $this->deonar_model->admin_status($param2, $param3);
            //     echo $response;
            // }
        
            if($param1 == 'create')
            {
                $response = $this->master_model->create_user($param2);
                echo $response;
            }
            
            if($param1 == 'update')
            {
                $response = $this->master_model->update_user($param2);
                echo $response;
            } 
            
            // if($param1 == 'update_gate')
            // {
            //     $response = $this->master_model->update_user_gate($param2);
            //     echo $response;
            // }            
        
            // show data from database
            if ($param1 == 'list')
            {
              $this->load->view('backend/superadmin/manage-broker/list');
            }        
        
            if (empty($param1))
            {
                $page_data['folder_name']  = 'broker-users';
                $page_data['page_title'] = 'Broker Users';
                $this->load->view('backend/index', $page_data);
            }    
    }
    
    
    public function manage_gwala($param1 = '', $param2 = '', $param3 = '')
    {
            // if($param1 == 'user_status')
            // {
            //     $response = $this->deonar_model->admin_status($param2, $param3);
            //     echo $response;
            // }
        
            if($param1 == 'create')
            {
                $response = $this->master_model->create_user_gwala($param2);
                echo $response;
            }
            
            if($param1 == 'update')
            {
                $response = $this->master_model->update_user_gwala($param2);
                echo $response;
            } 
            
            // if($param1 == 'update_gate')
            // {
            //     $response = $this->master_model->update_user_gate($param2);
            //     echo $response;
            // }            
        
            // show data from database
            if ($param1 == 'list')
            {
              $this->load->view('backend/superadmin/manage-gwala/list');
            }        
        
            if (empty($param1))
            {
                $page_data['folder_name']  = 'gwala-users';
                $page_data['page_title'] = 'Gwala Users';
                $this->load->view('backend/index', $page_data);
            }    
    }
    
// ============== 2024 ==========================

  /*public function dashboard(){
      
    //ini_set('display_errors', 1);
    //ini_set('display_startup_errors', 1);
    //error_reporting(E_ALL);

    // $this->msg91_model->clickatell();
    $page_data['page_title'] = 'Dashboard';
    $page_data['folder_name'] = 'dashboard';
    $page_data['vyapari'] = $this->db->select('vyapari_id')->from('app_vyapari')->get()->num_rows();
    $page_data['unblock'] = $this->db->select('status')->from('app_qrcode')->where_in('status', array('unblock', 'exit'))->get()->num_rows();
    
   
    $current_date = date('Y-m-d 00:00:00');
    
    $date  = "2024-06-05 00:00:00";
    $date1 = "2024-06-05 00:00:00";
    $date2 = "2024-06-05 00:00:00";
    $date3 = "2024-06-20 00:00:00";
    
    $page_data['startdate'] =  date('d', strtotime($date));
    $page_data['month'] = date('m', strtotime($date));
    $page_data['days'] = date('t', strtotime($date));
    
    $this->db->query("SET @@sql_mode=''");
    $query = $this->db->select('DAY(inward_date) AS DATE , COUNT("inward_date") AS count')->from('app_qrcode')->where_in('status', array('unblock', 'exit'))->where('inward_date BETWEEN "'. $date2 .'" AND "'. $date3 .'"')->group_by('DATE(inward_date)')->get()->result();
    $page_data['aniamalin'] = json_encode($query);
    
    $this->db->query("SET @@sql_mode=''");
    $query1 = $this->db->select('DAY(exit_date) AS DATE , COUNT("exit_date") AS count')->from('app_qrcode')->where('status', 'exit')->where('exit_date BETWEEN "'. $date1 .'" AND "'. $date3 .'"')->group_by('DATE(exit_date)')->get()->result();
    $page_data['aniamalout'] = json_encode($query1);

    
    $page_data['block'] = $this->db->select('status')->from('app_qrcode')->where('status', 'block')->get()->num_rows();
    $page_data['exit'] = $this->db->select('status')->from('app_qrcode')->where('status', 'exit')->get()->num_rows();    
    $this->load->view('backend/index', $page_data);
  }*/

  public function dashboard() {
      //$this->load->driver('cache', ['adapter' => 'file']);

      // Define cache duration in seconds (change this value to adjust all cache times)
      $cache_duration = 0; // e.g., 60 seconds

      $page_data['page_title'] = 'Dashboard';
      $page_data['folder_name'] = 'dashboard';

      $date  = "2024-06-05 00:00:00";
      $date1 = "2024-06-05 00:00:00";
      $date2 = "2024-06-05 00:00:00";
      $date3 = "2024-06-20 00:00:00";

      $page_data['startdate'] =  date('d', strtotime($date));
      $page_data['month'] = date('m', strtotime($date));
      $page_data['days'] = date('t', strtotime($date));

      // vyapari count
      $page_data['vyapari'] = $this->cache->get('dash_vyapari');
      if ($page_data['vyapari'] === false) {
          $page_data['vyapari'] = $this->db->count_all('app_vyapari');
          $this->cache->save('dash_vyapari', $page_data['vyapari'], $cache_duration);
      }

      // unblock + exit count
      $page_data['unblock'] = $this->cache->get('dash_unblock');
      if ($page_data['unblock'] === false) {
          $page_data['unblock'] = $this->db->where_in('status', ['unblock', 'exit'])->count_all_results('app_qrcode');
          $this->cache->save('dash_unblock', $page_data['unblock'], $cache_duration);
      }

      // block count
      $page_data['block'] = $this->cache->get('dash_block');
      if ($page_data['block'] === false) {
          $page_data['block'] = $this->db->where('status', 'block')->count_all_results('app_qrcode');
          $this->cache->save('dash_block', $page_data['block'], $cache_duration);
      }

      // exit count
      $page_data['exit'] = $this->cache->get('dash_exit');
      if ($page_data['exit'] === false) {
          $page_data['exit'] = $this->db->where('status', 'exit')->count_all_results('app_qrcode');
          $this->cache->save('dash_exit', $page_data['exit'], $cache_duration);
      }

      // inward (aniamalin)
      $page_data['aniamalin'] = $this->cache->get('dash_aniamalin');
      if ($page_data['aniamalin'] === false) {
          $this->db->query("SET @@sql_mode=''");
          $query = $this->db->select('DAY(inward_date) AS DATE , COUNT("inward_date") AS count')
              ->from('app_qrcode')
              ->where_in('status', ['unblock', 'exit'])
              ->where("inward_date BETWEEN '{$date2}' AND '{$date3}'")
              ->group_by('DATE(inward_date)')
              ->get()
              ->result();
          $page_data['aniamalin'] = json_encode($query);
          $this->cache->save('dash_aniamalin', $page_data['aniamalin'], $cache_duration);
      }

      // outward (aniamalout)
      $page_data['aniamalout'] = $this->cache->get('dash_aniamalout');
      if ($page_data['aniamalout'] === false) {
          $this->db->query("SET @@sql_mode=''");
          $query1 = $this->db->select('DAY(exit_date) AS DATE , COUNT("exit_date") AS count')
              ->from('app_qrcode')
              ->where('status', 'exit')
              ->where("exit_date BETWEEN '{$date1}' AND '{$date3}'")
              ->group_by('DATE(exit_date)')
              ->get()
              ->result();
          $page_data['aniamalout'] = json_encode($query1);
          $this->cache->save('dash_aniamalout', $page_data['aniamalout'], $cache_duration);
      }

      //State-wise Vyapari Count
      $page_data['state_wise_vyapari'] = $this->cache->get('dash_state_wise_vyapari');
      if ($page_data['state_wise_vyapari'] === false) {
          $this->db->select('CONCAT(UCASE(SUBSTRING(state, 1, 1)), LCASE(SUBSTRING(state, 2))) AS state, COUNT(vyapari_id) as total');
          $this->db->from('app_vyapari'); // Use your actual users table
          $this->db->group_by('state');
          $this->db->order_by('total', 'DESC');  // Order by count descending
          //$this->db->limit(10);                  // Limit to top 10                    
          $query2 = $this->db->get();
          $page_data['state_wise_vyapari'] = $query2->result_array();
          
          $this->cache->save('dash_state_wise_vyapari', $page_data['state_wise_vyapari'], $cache_duration);
      }      

      $this->load->view('backend/index', $page_data);
  }

  //START CLASS secion
  public function manage_class($param1 = '', $param2 = '', $param3 = ''){

    if($param1 == 'create'){
      $response = $this->crud_model->class_create();
      echo $response;
    }

    if($param1 == 'delete'){
      $response = $this->crud_model->class_delete($param2);
      echo $response;
    }

    if($param1 == 'update'){
      $response = $this->crud_model->class_update($param2);
      echo $response;
    }

    if($param1 == 'section'){
      $response = $this->crud_model->section_update($param2);
      echo $response;
    }

    // show data from database
    if ($param1 == 'list') {
      $this->load->view('backend/superadmin/class/list');
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'class';
      $page_data['page_title'] = 'class';
      $this->load->view('backend/index', $page_data);
    }
  }
  //END CLASS section

  //	SECTION STARTED
  public function section($action = "", $id = "") {

    // PROVIDE A LIST OF SECTION ACCORDING TO CLASS ID
    if ($action == 'list') {
      $page_data['class_id'] = $id;
      $this->load->view('backend/superadmin/section/list', $page_data);
    }
  }
  //	SECTION ENDED

  //START CLASS_ROOM section
  public function class_room($param1 = '', $param2 = ''){

    if($param1 == 'create'){
      $response = $this->crud_model->class_room_create();
      echo $response;
    }

    if($param1 == 'update'){
      $response = $this->crud_model->class_room_update($param2);
      echo $response;
    }

    if($param1 == 'delete'){
      $response = $this->crud_model->class_room_delete($param2);
      echo $response;
    }

    // PROVIDE A LIST OF SECTION ACCORDING TO CLASS ID
    if ($param1 == 'list') {
      $this->load->view('backend/superadmin/class_room/list');
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'class_room';
      $page_data['page_title'] = 'class_room';
      $this->load->view('backend/index', $page_data);
    }
  }
  //END CLASS_ROOM section

  //START SUBJECT section
  public function subject($param1 = '', $param2 = ''){

    if($param1 == 'create'){
      $response = $this->crud_model->subject_create();
      echo $response;
    }

    if($param1 == 'update'){
      $response = $this->crud_model->subject_update($param2);
      echo $response;
    }

    if($param1 == 'delete'){
      $response = $this->crud_model->subject_delete($param2);
      echo $response;
    }

    if($param1 == 'list'){
      $page_data['class_id'] = $param2;
      $this->load->view('backend/superadmin/subject/list', $page_data);
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'subject';
      $page_data['page_title'] = 'subject';
      $this->load->view('backend/index', $page_data);
    }
  }

  public function class_wise_subject($class_id) {

    // PROVIDE A LIST OF SUBJECT ACCORDING TO CLASS ID
    $page_data['class_id'] = $class_id;
    $this->load->view('backend/superadmin/subject/dropdown', $page_data);
  }
  //END SUBJECT section


  //START DEPARTMENT section
  public function department($param1 = '', $param2 = ''){

    if($param1 == 'create'){
      $response = $this->crud_model->department_create();
      echo $response;
    }

    if($param1 == 'update'){
      $response = $this->crud_model->department_update($param2);
      echo $response;
    }

    if($param1 == 'delete'){
      $response = $this->crud_model->department_delete($param2);
      echo $response;
    }

    // Get the data from database
    if($param1 == 'list'){
      $this->load->view('backend/superadmin/department/list');
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'department';
      $page_data['page_title'] = 'department';
      $this->load->view('backend/index', $page_data);
    }
  }
  //END DEPARTMENT section


  //START SYLLABUS section
  public function syllabus($param1 = '', $param2 = '', $param3 = ''){

    if($param1 == 'create'){
      $response = $this->crud_model->syllabus_create();
      echo $response;
    }

    if($param1 == 'delete'){
      $response = $this->crud_model->syllabus_delete($param2);
      echo $response;
    }

    if($param1 == 'list'){
      $page_data['class_id'] = $param2;
      $page_data['section_id'] = $param3;
      $this->load->view('backend/superadmin/syllabus/list', $page_data);
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'syllabus';
      $page_data['page_title'] = 'syllabus';
      $this->load->view('backend/index', $page_data);
    }
  }
  //END SYLLABUS section

  // START ADMIN SECTION
  public function admin($param1 = "", $param2 = "", $param3 = "") {
    if($param1 == 'create'){
      $response = $this->user_model->create_admin();
      echo $response;
    }

    if($param1 == 'update'){
      $response = $this->user_model->update_admin($param2);
      echo $response;
    }

    if($param1 == 'delete'){
      $response = $this->user_model->delete_admin($param2);
      echo $response;
    }

    if ($param1 == 'list') {
      $this->load->view('backend/superadmin/admin/list');
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'admin';
      $page_data['page_title'] = 'admins';
      $this->load->view('backend/index', $page_data);
    }
  }
  // END ADMIN SECTION


  //START TEACHER section
  public function teacher($param1 = '', $param2 = '', $param3 = ''){


    if($param1 == 'create'){
      $response = $this->user_model->create_teacher();
      echo $response;
    }

    if($param1 == 'update'){
      $response = $this->user_model->update_teacher($param2);
      echo $response;
    }

    if($param1 == 'delete'){
      $teacher_id = $this->db->get_where('teachers', array('user_id' => $param2))->row('id');
      $response = $this->user_model->delete_teacher($param2, $teacher_id);
      echo $response;
    }

    if ($param1 == 'list') {
      $this->load->view('backend/superadmin/teacher/list');
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'teacher';
      $page_data['page_title'] = 'techers';
      $this->load->view('backend/index', $page_data);
    }
  }
  //END TEACHER section



  //START TEACHER PERMISSION section
  public function permission($param1 = '', $param2 = '', $param3 = ''){

    if($param1 == 'filter'){
      $page_data['class_id'] = $param2;
      $page_data['section_id'] = $param3;
      $this->load->view('backend/superadmin/permission/list', $page_data);
    }

    if($param1 == 'modify_permission'){
      $page_data['class_id'] = $this->input->post('class_id');
      $page_data['section_id'] = $this->input->post('section_id');
      $this->user_model->teacher_permission();
      $this->load->view('backend/superadmin/permission/list', $page_data);
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'permission';
      $page_data['page_title'] = 'teacher_permissions';
      $this->load->view('backend/index', $page_data);
    }
  }
  //END TEACHER PERMISSION section


  //START PARENT section
  public function parent($param1 = '', $param2 = ''){

    if($param1 == 'create'){
      $response = $this->user_model->parent_create();
      echo $response;
    }

    if($param1 == 'update'){
      $response = $this->user_model->parent_update($param2);
      echo $response;
    }

    if($param1 == 'delete'){
      $response = $this->user_model->parent_delete($param2);
      echo $response;
    }

    // show data from database
    if ($param1 == 'list') {
      $this->load->view('backend/superadmin/parent/list');
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'parent';
      $page_data['page_title'] = 'parent';
      $this->load->view('backend/index', $page_data);
    }
  }
  //END PARENT section


  //START ACCOUNTANT section
  public function accountant($param1 = '', $param2 = ''){

    if($param1 == 'create'){
      $response = $this->user_model->accountant_create();
      echo $response;
    }

    if($param1 == 'update'){
      $response = $this->user_model->accountant_update($param2);
      echo $response;
    }

    if($param1 == 'delete'){
      $response = $this->user_model->accountant_delete($param2);
      echo $response;
    }

    // show data from database
    if ($param1 == 'list') {
      $this->load->view('backend/superadmin/accountant/list');
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'accountant';
      $page_data['page_title'] = 'accountant';
      $this->load->view('backend/index', $page_data);
    }
  }
  //END ACCOUNTANT section


  //START LIBRARIAN section
  public function librarian($param1 = '', $param2 = ''){

    if($param1 == 'create'){
      $response = $this->user_model->librarian_create();
      echo $response;
    }

    if($param1 == 'update'){
      $response = $this->user_model->librarian_update($param2);
      echo $response;
    }

    if($param1 == 'delete'){
      $response = $this->user_model->librarian_delete($param2);
      echo $response;
    }

    // show data from database
    if ($param1 == 'list') {
      $this->load->view('backend/superadmin/librarian/list');
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'librarian';
      $page_data['page_title'] = 'librarian';
      $this->load->view('backend/index', $page_data);
    }
  }
  //END LIBRARIAN section

  //START CLASS ROUTINE section
  public function routine($param1 = '', $param2 = '', $param3 = '', $param4 = ''){

    if($param1 == 'create'){
      $response = $this->crud_model->routine_create();
      echo $response;
    }

    if($param1 == 'update'){
      $response = $this->crud_model->routine_update($param2);
      echo $response;
    }

    if($param1 == 'delete'){
      $response = $this->crud_model->routine_delete($param2);
      echo $response;
    }

    if($param1 == 'filter'){
      $page_data['class_id'] = $param2;
      $page_data['section_id'] = $param3;
      $this->load->view('backend/superadmin/routine/list', $page_data);
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'routine';
      $page_data['page_title'] = 'routine';
      $this->load->view('backend/index', $page_data);
    }
  }
  //END CLASS ROUTINE section


  //START DAILY ATTENDANCE section
  public function attendance($param1 = '', $param2 = '', $param3 = ''){

    if($param1 == 'take_attendance'){
      $response = $this->crud_model->take_attendance();
      echo $response;
    }

    if($param1 == 'filter'){
      $date = '01 '.$this->input->post('month').' '.$this->input->post('year');
      $page_data['attendance_date'] = strtotime($date);
      $page_data['class_id'] = $this->input->post('class_id');
      $page_data['section_id'] = $this->input->post('section_id');
      $page_data['month'] = $this->input->post('month');
      $page_data['year'] = $this->input->post('year');
      $this->load->view('backend/superadmin/attendance/list', $page_data);
    }

    if($param1 == 'student'){
      $page_data['attendance_date'] = strtotime($this->input->post('date'));
      $page_data['class_id'] = $this->input->post('class_id');
      $page_data['section_id'] = $this->input->post('section_id');
      $this->load->view('backend/superadmin/attendance/student', $page_data);
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'attendance';
      $page_data['page_title'] = 'attendance';
      $this->load->view('backend/index', $page_data);
    }
  }
  //END DAILY ATTENDANCE section


  //START EVENT CALENDAR section
  public function event_calendar($param1 = '', $param2 = ''){

    if($param1 == 'create'){
      $response = $this->crud_model->event_calendar_create();
      echo $response;
    }

    if($param1 == 'update'){
      $response = $this->crud_model->event_calendar_update($param2);
      echo $response;
    }

    if($param1 == 'delete'){
      $response = $this->crud_model->event_calendar_delete($param2);
      echo $response;
    }

    if($param1 == 'all_events'){
      echo $this->crud_model->all_events();
    }

    if ($param1 == 'list') {
      $this->load->view('backend/superadmin/event_calendar/list');
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'event_calendar';
      $page_data['page_title'] = 'event_calendar';
      $this->load->view('backend/index', $page_data);
    }
  }
  //END EVENT CALENDAR section



  //START STUDENT ADN ADMISSION section
  public function student($param1 = '', $param2 = '', $param3 = '', $param4 = '', $param5 = ''){

    if($param1 == 'create'){
      //form view
      if($param2 == 'bulk'){
        $page_data['aria_expand'] = 'bulk';
        $page_data['working_page'] = 'create';
        $page_data['folder_name'] = 'student';
        $page_data['page_title'] = 'add_student';
        $this->load->view('backend/index', $page_data);
      }elseif($param2 == 'excel'){
        $page_data['aria_expand'] = 'excel';
        $page_data['working_page'] = 'create';
        $page_data['folder_name'] = 'student';
        $page_data['page_title'] = 'add_student';
        $this->load->view('backend/index', $page_data);
      }else{
        $page_data['aria_expand'] = 'single';
        $page_data['working_page'] = 'create';
        $page_data['folder_name'] = 'student';
        $page_data['page_title'] = 'add_student';
        $this->load->view('backend/index', $page_data);
      }
    }

    //create to database
    if($param1 == 'create_single_student'){
      $response = $this->user_model->single_student_create();
      echo $response;
    }

    if($param1 == 'create_bulk_student'){
      $response = $this->user_model->bulk_student_create();
      echo $response;
    }

    if($param1 == 'create_excel'){
      $response = $this->user_model->excel_create();
      echo $response;
    }

    // form view
    if($param1 == 'edit'){
      $page_data['student_id'] = $param2;
      $page_data['working_page'] = 'edit';
      $page_data['folder_name'] = 'student';
      $page_data['page_title'] = 'update_student_information';
      $this->load->view('backend/index', $page_data);
    }

    //updated to database
    if($param1 == 'updated'){
      $response = $this->user_model->student_update($param2, $param3);
      echo $response;
    }
    //updated to database
    if($param1 == 'id_card'){
      $page_data['student_id'] = $param2;
      $page_data['folder_name'] = 'student';
      $page_data['page_title'] = 'identity_card';
      $page_data['page_name'] = 'id_card';
      $this->load->view('backend/index', $page_data);
    }

    if($param1 == 'delete'){
      $response = $this->user_model->delete_student($param2, $param3);
      echo $response;
    }

    if($param1 == 'filter'){
      $page_data['class_id'] = $param2;
      $page_data['section_id'] = $param3;
      $this->load->view('backend/superadmin/student/list', $page_data);
    }

    if(empty($param1)){
      $page_data['working_page'] = 'filter';
      $page_data['folder_name'] = 'student';
      $page_data['page_title'] = 'student_list';
      $this->load->view('backend/index', $page_data);
    }
  }
  //END STUDENT ADN ADMISSION section


  //START EXAM section
  public function exam($param1 = '', $param2 = ''){

    if($param1 == 'create'){
      $response = $this->crud_model->exam_create();
      echo $response;
    }

    if($param1 == 'update'){
      $response = $this->crud_model->exam_update($param2);
      echo $response;
    }

    if($param1 == 'delete'){
      $response = $this->crud_model->exam_delete($param2);
      echo $response;
    }

    if ($param1 == 'list') {
      $this->load->view('backend/superadmin/exam/list');
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'exam';
      $page_data['page_title'] = 'exam';
      $this->load->view('backend/index', $page_data);
    }
  }
  //END EXAM section

  //START MARKS section
  public function mark($param1 = '', $param2 = ''){

    if($param1 == 'list'){
      $page_data['class_id'] = $this->input->post('class_id');
      $page_data['section_id'] = $this->input->post('section_id');
      $page_data['subject_id'] = $this->input->post('subject');
      $page_data['exam_id'] = $this->input->post('exam');
      $this->crud_model->mark_insert($page_data['class_id'], $page_data['section_id'], $page_data['subject_id'], $page_data['exam_id']);
      $this->load->view('backend/superadmin/mark/list', $page_data);
    }

    if($param1 == 'mark_update'){
      $this->crud_model->mark_update();
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'mark';
      $page_data['page_title'] = 'marks';
      $this->load->view('backend/index', $page_data);
    }
  }

  // GET THE GRADE ACCORDING TO MARK
  public function get_grade($acquired_mark) {
    echo get_grade($acquired_mark);
  }
  //END MARKS sesction

  // GRADE SECTION STARTS
  public function grade($param1 = "", $param2 = "") {

    // store data on database
    if($param1 == 'create'){
      $response = $this->crud_model->grade_create();
      echo $response;
    }

    // update data on database
    if($param1 == 'update'){
      $response = $this->crud_model->grade_update($param2);
      echo $response;
    }

    // delelte data from database
    if($param1 == 'delete'){
      $response = $this->crud_model->grade_delete($param2);
      echo $response;
    }

    // show data from database
    if ($param1 == 'list') {
      $this->load->view('backend/superadmin/grade/list');
    }

    // showing the index file
    if(empty($param1)){
      $page_data['folder_name'] = 'grade';
      $page_data['page_title'] = 'grades';
      $this->load->view('backend/index', $page_data);
    }
  }
  // GRADE SECTION ENDS

  // STUDENT PROMOTION SECTION STARTS
  function promotion($param1 = "", $promotion_data = "") {

    // Promote students. Here promotion_data contains all the data of a student to promote
    if ($param1 == 'promote') {
      $response = $this->crud_model->promote_student($promotion_data);
      echo $response;
    }
    //showing the list of student to promote
    if ($param1 == 'list') {
      $page_data['session_from'] = $this->input->post('session_from');
      $page_data['session_to'] = $this->input->post('session_to');
      $page_data['class_id_from'] = $this->input->post('class_id_from');
      $page_data['class_id_to'] = $this->input->post('class_id_to');
      $page_data['class_from_details'] = $this->crud_model->get_classes($this->input->post('class_id_from'))->row_array();
      $page_data['class_to_details'] = $this->crud_model->get_classes($this->input->post('class_id_to'))->row_array();
      $page_data['session_from_details'] = $this->crud_model->get_session($this->input->post('session_from'))->row_array();
      $page_data['session_to_details'] = $this->crud_model->get_session($this->input->post('session_to'))->row_array();
      $page_data['enrolments'] = $this->crud_model->get_student_list()->result_array();
      $this->load->view('backend/superadmin/promotion/list', $page_data);
    }
    // showing the index file
    if(empty($param1)){
      $page_data['folder_name'] = 'promotion';
      $page_data['page_title'] = 'student_promotion';
      $this->load->view('backend/index', $page_data);
    }
  }
  // STUDENT PROMOTION SECTION ENDS

  // ACCOUNTING SECTION STARTS
  public function invoice($param1 = "", $param2 = "") {
    // For creating new invoice
    if ($param1 == 'single') {
      $response = $this->crud_model->create_single_invoice();
      echo $response;
    }

    // For creating new mass invoice
    if ($param1 == 'mass') {
      $response = $this->crud_model->create_mass_invoice();
      echo $response;
    }

    // For editing invoice
    if ($param1 == 'update') {
      $response = $this->crud_model->update_invoice($param2);
      echo $response;
    }

    // For deleting invoice
    if ($param1 == 'delete') {
      $response = $this->crud_model->delete_invoice($param2);
      echo $response;
    }

    // Get the list of student. Here param2 defines classId
    if ($param1 == 'student') {
      $page_data['enrolments'] = $this->user_model->get_student_details_by_id('class', $param2);
      $this->load->view('backend/superadmin/student/dropdown', $page_data);
    }

    // showing the list of invoices
    if ($param1 == 'invoice') {
      $page_data['invoice_id'] = $param2;
      $page_data['folder_name'] = 'invoice';
      $page_data['page_name'] = 'invoice';
      $page_data['page_title']  = 'invoice';
      $this->load->view('backend/index', $page_data);
    }

    // showing the list of invoices
    if ($param1 == 'list') {
      $date = explode('-', $this->input->get('date'));
      $page_data['date_from'] = strtotime($date[0].' 00:00:00');
      $page_data['date_to']   = strtotime($date[1].' 23:59:59');
      $page_data['selected_class'] = $this->input->get('selectedClass');
      $page_data['selected_status'] = $this->input->get('selectedStatus');
      $this->load->view('backend/superadmin/invoice/list', $page_data);
    }
    // showing the index file
    if(empty($param1)){
      $page_data['folder_name'] = 'invoice';
      $page_data['page_title']  = 'invoice';
      $first_day_of_month = "1 ".date("M")." ".date("Y").' 00:00:00';
      $last_day_of_month = date("t")." ".date("M")." ".date("Y").' 23:59:59';
      $page_data['date_from']   = strtotime($first_day_of_month);
      $page_data['date_to']     = strtotime($last_day_of_month);
      $page_data['selected_class'] = 'all';
      $page_data['selected_status'] = 'all';
      $this->load->view('backend/index', $page_data);
    }
  }

  //EXPORT STUDENT FEES
  public function export($param1 = "", $date_from = "", $date_to = "", $selected_class = "", $selected_status = "") {
    //RETURN EXPORT URL
    if ($param1 == 'url') {
      $type = $this->input->post('type');
      $date = explode('-', $this->input->post('dateRange'));
      $date_from = strtotime($date[0].' 00:00:00');
      $date_to   = strtotime($date[1].' 23:59:59');
      $selected_class = $this->input->post('selectedClass');
      $selected_status = $this->input->post('selectedStatus');
      echo route('export/'.$type.'/'.$date_from.'/'.$date_to.'/'.$selected_class.'/'.$selected_status);
    }
    // EXPORT AS PDF
    if($param1 == 'pdf' || $param1 == 'print') {
      $page_data['action']   = $param1;
      $page_data['date_from']   = $date_from;
      $page_data['date_to']     = $date_to;
      $page_data['selected_class'] = $selected_class;
      $page_data['selected_status'] = $selected_status;
      $html = $this->load->view('backend/superadmin/invoice/export',$page_data, true);

      $this->pdf->loadHtml($html);
      $this->pdf->set_paper("a4", "landscape" );
      $this->pdf->render();

      // FILE DOWNLOADING CODES
      if ($selected_status == 'all') {
        $paymentStatusForTitle = 'paid-and-unpaid';
      }else{
        $paymentStatusForTitle = $selected_status;
      }
      if ($selected_class == 'all') {
        $classNameForTitle = 'all_class';
      }else{
        $class_details = $this->crud_model->get_classes($selected_class)->row_array();
        $classNameForTitle = $class_details['name'];
      }
      $fileName = 'Student_fees-'.date('d-M-Y', $date_from).'-to-'.date('d-M-Y', $date_to).'-'.$classNameForTitle.'-'.$paymentStatusForTitle.'.pdf';

      if ($param1 == 'pdf') {
        $this->pdf->stream($fileName, array("Attachment" => 1));
      }else{
        $this->pdf->stream($fileName, array("Attachment" => 0));
      }
    }
    // EXPORT AS CSV
    if($param1 == 'csv'){
      $date_from   = $date_from;
      $date_to     = $date_to;
      $selected_class = $selected_class;
      $selected_status = $selected_status;

      $invoices = $this->crud_model->get_invoice_by_date_range($date_from, $date_to, $selected_class, $selected_status)->result_array();
      $csv_file = fopen("assets/csv_file/invoices.csv", "w");
      $header = array('Invoice-no', 'Student', 'Class', 'Invoice-Title', 'Total-Amount', 'Paid-Amount', 'Creation-Date', 'Payment-Date', 'Status');
      fputcsv($csv_file, $header);
      foreach ($invoices as $invoice) {
        $student_details = $this->user_model->get_student_details_by_id('student', $invoice['student_id']);
        $class_details = $this->crud_model->get_class_details_by_id($invoice['class_id'])->row_array();
        if ($invoice['updated_at'] > 0){
          $payment_date = date('d-M-Y', $invoice['updated_at']);
        }else{
          $payment_date = get_phrase('not_found');
        }
        $lines = array(sprintf('%08d', $invoice['id']), $student_details['name'], $class_details['name'], $invoice['title'], currency($invoice['total_amount']), currency($invoice['paid_amount']), date('d-M-Y', $invoice['created_at']), $payment_date, ucfirst($invoice['status']));
        fputcsv($csv_file, $lines);
      }

      // FILE DOWNLOADING CODES
      if ($selected_status == 'all') {
        $paymentStatusForTitle = 'paid-and-unpaid';
      }else{
        $paymentStatusForTitle = $selected_status;
      }
      if ($selected_class == 'all') {
        $classNameForTitle = 'all_class';
      }else{
        $class_details = $this->crud_model->get_classes($selected_class)->row_array();
        $classNameForTitle = $class_details['name'];
      }
      $fileName = 'Student_fees-'.date('d-M-Y', $date_from).'-to-'.date('d-M-Y', $date_to).'-'.$classNameForTitle.'-'.$paymentStatusForTitle.'.csv';
      $this->download_file('assets/csv_file/invoices.csv', $fileName);
    }
  }

  /*FUNCTION FOR DOWNLOADING A FILE*/
  function download_file($path, $name)
  {
    // make sure it's a file before doing anything!
    if(is_file($path))
    {
      // required for IE
      if(ini_get('zlib.output_compression')) { ini_set('zlib.output_compression', 'Off'); }

      // get the file mime type using the file extension
      $this->load->helper('file');

      $mime = get_mime_by_extension($path);

      // Build the headers to push out the file properly.
      header('Pragma: public');     // required
      header('Expires: 0');         // no cache
      header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
      header('Last-Modified: '.gmdate ('D, d M Y H:i:s', filemtime ($path)).' GMT');
      header('Cache-Control: private',false);
      header('Content-Type: '.$mime);  // Add the mime type from Code igniter.
      header('Content-Disposition: attachment; filename="'.basename($name).'"');  // Add the file name
      header('Content-Transfer-Encoding: binary');
      header('Content-Length: '.filesize($path)); // provide file size
      header('Connection: close');
      readfile($path); // push it out
      exit();
    }
  }


  // Expense Category
  public function expense_category($param1 = "", $param2 = "") {
    if ($param1 == 'create') {
      $response = $this->crud_model->create_expense_category();
      echo $response;
    }

    if ($param1 == 'update') {
      $response = $this->crud_model->update_expense_category($param2);
      echo $response;
    }

    if ($param1 == 'delete') {
      $response = $this->crud_model->delete_expense_category($param2);
      echo $response;
    }

    if ($param1 == 'list') {
      $this->load->view('backend/superadmin/expense_category/list');
    }
    // showing the index file
    if(empty($param1)){
      $page_data['folder_name'] = 'expense_category';
      $page_data['page_title']  = 'expense_category';
      $this->load->view('backend/index', $page_data);
    }
  }

  //Expense Manager
  public function expense($param1 = "", $param2 = "") {

    // adding expense
    if ($param1 == 'create') {
      $response = $this->crud_model->create_expense();
      echo $response;
    }

    // update expense
    if ($param1 == 'update') {
      $response = $this->crud_model->update_expense($param2);
      echo $response;
    }

    // deleting expense
    if ($param1 == 'delete') {
      $response = $this->crud_model->delete_expense($param2);
      echo $response;
    }
    // showing the list of expense
    if ($param1 == 'list') {
      $date = explode('-', $this->input->get('date'));
      $page_data['date_from'] = strtotime($date[0].' 00:00:00');
      $page_data['date_to']   = strtotime($date[1].' 23:59:59');
      $page_data['expense_category_id'] = $this->input->get('expense_category_id');
      $this->load->view('backend/superadmin/expense/list', $page_data);
    }

    // showing the index file
    if(empty($param1)){
      $page_data['folder_name'] = 'expense';
      $page_data['page_title']  = 'expense';
      $page_data['date_from']   = strtotime(date('d-M-Y', strtotime(' -30 day')).' 00:00:00');
      $page_data['date_to']     = strtotime(date('d-M-Y').' 23:59:59');
      $this->load->view('backend/index', $page_data);
    }
  }
  // ACCOUNTING SECTION ENDS

  // BACKOFFICE SECTION

  //START SESSION_MANAGER section
  public function session_manager($param1 = '', $param2 = ''){
    $school_id = school_id();

    if($param1 == 'create'){
      $response = $this->crud_model->session_create();
      echo $response;
    }

    if($param1 == 'update'){
      $response = $this->crud_model->session_update($param2);
      echo $response;
    }

    if($param1 == 'delete'){
      $response = $this->crud_model->session_delete($param2);
      echo $response;
    }

    if($param1 == 'active_session'){
      $response = $this->crud_model->active_session($param2);
      echo $response;
    }

    if($param1 == 'reopen_session'){
      echo $this->db->get_where('sessions', array('school_id' => $school_id, 'status' => 1))->row('name');
    }

    if($param1 == 'reopen_list'){
      $this->load->view('backend/superadmin/session/table_body');
    }

    if ($param1 == 'list') {
      $this->load->view('backend/superadmin/session/list');
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'session';
      $page_data['page_title'] = 'session_manager';
      $this->load->view('backend/index', $page_data);
    }
  }
  //END SESSION_MANAGER section

  //BOOK LIST MANAGER
  public function book($param1 = "", $param2 = "") {
    // adding book
    if ($param1 == 'create') {
      $response = $this->crud_model->create_book();
      echo $response;
    }

    // update book
    if ($param1 == 'update') {
      $response = $this->crud_model->update_book($param2);
      echo $response;
    }

    // deleting book
    if ($param1 == 'delete') {
      $response = $this->crud_model->delete_book($param2);
      echo $response;
    }
    // showing the list of book
    if ($param1 == 'list') {
      $this->load->view('backend/superadmin/book/list');
    }

    // showing the index file
    if(empty($param1)){
      $page_data['folder_name'] = 'book';
      $page_data['page_title']  = 'books';
      $this->load->view('backend/index', $page_data);
    }
  }

  //BOOK ISSUE LIST MANAGER
  public function book_issue($param1 = "", $param2 = "") {
    // adding book
    if ($param1 == 'create') {
      $response = $this->crud_model->create_book_issue();
      echo $response;
    }

    // update book
    if ($param1 == 'update') {
      $response = $this->crud_model->update_book_issue($param2);
      echo $response;
    }

    // Returning a book
    if ($param1 == 'return') {
      $response = $this->crud_model->return_issued_book($param2);
      echo $response;
    }

    // deleting book
    if ($param1 == 'delete') {
      $response = $this->crud_model->delete_book_issue($param2);
      echo $response;
    }
    // showing the list of book
    if ($param1 == 'list') {
      $date = explode('-', $this->input->get('date'));
      $page_data['date_from'] = strtotime($date[0].' 00:00:00');
      $page_data['date_to']   = strtotime($date[1].' 23:59:59');
      $this->load->view('backend/superadmin/book_issue/list', $page_data);
    }

    // showing the index file
    if(empty($param1)){
      $page_data['folder_name'] = 'book_issue';
      $page_data['page_title']  = 'book_issue';
      $page_data['date_from'] = strtotime(date('d-M-Y', strtotime(' -30 day')).' 00:00:00');
      $page_data['date_to']   = strtotime(date('d-M-Y').' 23:59:59');
      $this->load->view('backend/index', $page_data);
    }
  }

  // ADDON MANAGER
  public function addon_manager($param1 = "", $param2 = "") {
    if ($param1 == 'install') {
      $response = $this->addon_model->install_addon();
      echo $response;
    }

    // DEACTIVE ADDONS
    if ($param1 == 'deactive') {
      $response = $this->addon_model->deactivate_addon($param2);
      echo $response;
    }
    // ACTIVATE ADDONS
    if ($param1 == 'activate') {
      $response = $this->addon_model->activate_addon($param2);
      echo $response;
    }

    // DELETING ADDONS
    if ($param1 == 'delete') {
      $response = $this->addon_model->remove_addon($param2);
      echo $response;
    }
    // showing the list of book
    if ($param1 == 'list') {
      $this->load->view('backend/superadmin/addon/list');
    }
    // showing the index file
    if(empty($param1)){
      $page_data['folder_name'] = 'addon';
      $page_data['page_title']  = 'addon_manager';
      $this->load->view('backend/index', $page_data);
    }
  }

  // NOTICEBOARD MANAGER
  public function noticeboard($param1 = "", $param2 = "", $param3 = "") {
    // adding notice
    if ($param1 == 'create') {
      $response = $this->crud_model->create_notice();
      echo $response;
    }

    // update notice
    if ($param1 == 'update') {
      $response = $this->crud_model->update_notice($param2);
      echo $response;
    }

    // deleting notice
    if ($param1 == 'delete') {
      $response = $this->crud_model->delete_notice($param2);
      echo $response;
    }
    // showing the list of notice
    if ($param1 == 'list') {
      $this->load->view('backend/superadmin/noticeboard/list');
    }

    // showing the all the notices
    if ($param1 == 'all_notices') {
      $response = $this->crud_model->get_all_the_notices();
      echo $response;
    }

    // showing the index file
    if(empty($param1)){
      $page_data['folder_name'] = 'noticeboard';
      $page_data['page_title']  = 'noticeboard';
      $this->load->view('backend/index', $page_data);
    }
  }

  // SETTINGS MANAGER
  public function system_settings($param1 = "", $param2 = "") {
    if ($param1 == 'update') {
      $response = $this->settings_model->update_system_settings();
      echo $response;
    }

    if ($param1 == 'logo_update') {
      $response = $this->settings_model->update_system_logo();
      echo $response;
    }
    // showing the System Settings file
    if(empty($param1)){
      $page_data['folder_name'] = 'settings';
      $page_data['page_title']  = 'system_settings';
      $page_data['settings_type'] = 'system_settings';
      $this->load->view('backend/index', $page_data);
    }
  }

  // FRONTEND SETTINGS MANAGER
  public function website_settings($param1 = '', $param2 = '', $param3 = '') {
    if ($param1 == 'events') {
      $page_data['page_content']  = 'events';
    }
    if ($param1 == 'gallery') {
      $page_data['page_content']  = 'gallery';
    }
    if ($param1 == 'privacy_policy') {
      $page_data['page_content']  = 'privacy_policy';
    }
    if ($param1 == 'about_us') {
      $page_data['page_content']  = 'about_us';
    }
    if ($param1 == 'terms_and_conditions') {
      $page_data['page_content']  = 'terms_and_conditions';
    }
    if ($param1 == 'homepage_slider') {
      $page_data['page_content']  = 'homepage_slider';
    }
    if ($param1 == 'gallery_image') {
      $page_data['page_content']  = 'gallery_image';
      $page_data['gallery_id']  = $param2;
    }
    if ($param1 == 'other_settings') {
      $page_data['page_content']  = 'other_settings';
    }
    if(empty($param1) || $param1 == 'general_settings'){
      $page_data['page_content']  = 'general_settings';
    }

    $page_data['folder_name']   = 'website_settings';
    $page_data['page_title']    = 'website_settings';
    $page_data['settings_type'] = 'website_settings';
    $this->load->view('backend/index', $page_data);
  }

  public function website_update($param1 = "") {
    if ($param1 == 'general_settings') {
      $response = $this->frontend_model->update_frontend_general_settings();
    }

    echo $response;
  }

  public function other_settings_update($param1 = "") {
    $response = $this->frontend_model->other_settings_update();
    echo $response;
  }

  public function update_recaptcha_settings($param1 = "") {
    $response = $this->frontend_model->update_recaptcha_settings();
    echo $response;
  }

  public function events($param1 = "", $param2 = "") {
    // DEACTIVE ADDONS
    if ($param1 == 'create') {
      $response = $this->frontend_model->event_create();
      echo $response;
    }
    // ACTIVATE ADDONS
    if ($param1 == 'update') {
      $response = $this->frontend_model->event_update($param2);
      echo $response;
    }

    // DELETING ADDONS
    if ($param1 == 'delete') {
      $response = $this->frontend_model->event_delete($param2);
      echo $response;
    }
    // showing the list of book
    if ($param1 == 'list') {
      $this->load->view('backend/superadmin/website_settings/events');
    }

    // showing the System Settings file
    if(empty($param1)){
      redirect(route('website_settings/events'), 'refresh');
    }
  }

  //FRONTEND GALLERY
  public function frontend_gallery($param1 = "", $param2 = "", $param3 = "") {
    if ($param1 == 'create') {
      $response = $this->frontend_model->add_frontend_gallery();
      echo $response;
    }

    if ($param1 == 'update') {
      $response = $this->frontend_model->update_frontend_gallery($param2);
      echo $response;
    }

    if ($param1 == 'delete') {
      $response = $this->frontend_model->delete_frontend_gallery($param2);
      echo $response;
    }

    if ($param1 == 'gallery_list') {
      $this->load->view('backend/superadmin/website_settings/gallery');
    }

    // HERE STARTS THE GALLER IMAGES PART

    if ($param1 == 'gallery_photo_list') {
      $page_data['gallery_id'] = $param2;
      $this->load->view('backend/superadmin/website_settings/gallery_image', $page_data);
    }

    if ($param1 == 'gallery_photo_delete') {
      $response = $this->frontend_model->delete_gallery_photo($param2);
      echo $response;
    }

    if ($param1 == 'gallery_photo_upload') {
      $response = $this->frontend_model->upload_gallery_photo($param2);
      echo $response;
    }
  }

  //ABOUT US UPDATE
  public function about_us($param1 = "") {
    if ($param1 == 'update') {
      $response = $this->frontend_model->update_about_us();
      echo $response;
    }else{
      redirect(site_url(), 'refresh');
    }
  }

  //PRIVACY POLICY UPDATE
  public function privacy_policy($param1 = "") {
    if ($param1 == 'update') {
      $response = $this->frontend_model->update_privacy_policy();
      echo $response;
    }else{
      redirect(site_url(), 'refresh');
    }
  }

  //TERMS AND CONDITION UPDATE
  public function terms_and_conditions($param1 = "") {
    if ($param1 == 'update') {
      $response = $this->frontend_model->update_terms_and_conditions();
      echo $response;
    }else{
      redirect(site_url(), 'refresh');
    }
  }
  //TERMS AND CONDITION UPDATE
  public function homepage_slider($param1 = "") {
    if ($param1 == 'update') {
      $response = $this->frontend_model->update_homepage_slider();
      echo $response;
    }else{
      redirect(site_url(), 'refresh');
    }
  }

  // SETTINGS MANAGER
  public function school_settings($param1 = "", $param2 = "") {
    if ($param1 == 'update') {
      $response = $this->settings_model->update_current_school_settings();
      echo $response;
    }

    // showing the System Settings file
    if(empty($param1)){
      $page_data['folder_name'] = 'settings';
      $page_data['page_title']  = 'school_settings';
      $page_data['settings_type'] = 'school_settings';
      $this->load->view('backend/index', $page_data);
    }
  }

  // PAYMENT SETTINGS MANAGER
  public function payment_settings($param1 = "", $param2 = "") {
    if ($param1 == 'system') {
      $response = $this->settings_model->update_system_currency_settings();
      echo $response;
    }
    if ($param1 == 'paypal') {
      $response = $this->settings_model->update_paypal_settings();
      echo $response;
    }
    if ($param1 == 'stripe') {
      $response = $this->settings_model->update_stripe_settings();
      echo $response;
    }

    // showing the Payment Settings file
    if(empty($param1)){
      $page_data['folder_name'] = 'settings';
      $page_data['page_title']  = 'payment_settings';
      $page_data['settings_type'] = 'payment_settings';
      $this->load->view('backend/index', $page_data);
    }
  }

  // LANGUAGE SETTINGS
  public function language($param1 = "", $param2 = "") {
    // adding language
    if ($param1 == 'create') {
      $response = $this->settings_model->create_language();
      echo $response;
    }

    // update language
    if ($param1 == 'update') {
      $response = $this->settings_model->update_language($param2);
      echo $response;
    }

    // deleting language
    if ($param1 == 'delete') {
      $response = $this->settings_model->delete_language($param2);
      echo $response;
    }

    // showing the list of language
    if ($param1 == 'list') {
      $this->load->view('backend/superadmin/language/list');
    }

    // showing the list of language
    if ($param1 == 'active') {
      $this->settings_model->update_system_language($param2);
      redirect(route('language'), 'refresh');
    }

    // showing the list of language
    if ($param1 == 'update_phrase') {
      $current_editing_language = $this->input->post('currentEditingLanguage');
      $updatedValue = $this->input->post('updatedValue');
      $key = $this->input->post('key');
      saveJSONFile($current_editing_language, $key, $updatedValue);
      echo $current_editing_language.' '.$key.' '.$updatedValue;
    }

    // GET THE DROPDOWN OF LANGUAGES
    if($param1 == 'dropdown') {
      $this->load->view('backend/superadmin/language/dropdown');
    }
    // showing the index file
    if(empty($param1)){
      $page_data['folder_name'] = 'language';
      $page_data['page_title']  = 'languages';
      $this->load->view('backend/index', $page_data);
    }
  }
  // SMTP SETTINGS MANAGER
  public function smtp_settings($param1 = "", $param2 = "") {
    if ($param1 == 'update') {
      $response = $this->settings_model->update_smtp_settings();
      echo $response;
    }

    // showing the Smtp Settings file
    if(empty($param1)){
      $page_data['folder_name'] = 'settings';
      $page_data['page_title']  = 'smtp_settings';
      $page_data['settings_type'] = 'smtp_settings';
      $this->load->view('backend/index', $page_data);
    }
  }

  //MANAGE PROFILE STARTS
  public function profile($param1 = "", $param2 = "") {
    if ($param1 == 'update_profile') {
      $response = $this->user_model->update_profile();
      echo $response;
    }
    if ($param1 == 'update_password') {
      $response = $this->user_model->update_password();
      echo $response;
    }

    // showing the Smtp Settings file
    if(empty($param1)){
      $page_data['folder_name'] = 'profile';
      $page_data['page_title']  = 'manage_profile';
      $this->load->view('backend/index', $page_data);
    }
  }
  //MANAGE PROFILE ENDS

  // ABOUT APPLICATION STARTS
  public function about() {

    $page_data['application_details'] = $this->settings_model->get_application_details();
    $page_data['folder_name'] = 'about';
    $page_data['page_title']  = 'about';
    $this->load->view('backend/index', $page_data);
  }
  // ABOUT APPLICATION ENDS
  
  
  public function aadhar_vyapari_detail(){
      $aadhar_no = $this->input->post('Aadhar_no');
      
      $vyapari_data = $this->db->where('aadhar_no', $aadhar_no)->get('vyapari_detail')->row();
      
      if($vyapari_data){
          echo json_encode(array("Status" => "True","vyapari" => $vyapari_data));
      }else{
          echo json_encode(array("Status" => "False"));
      }
  }
  
}
