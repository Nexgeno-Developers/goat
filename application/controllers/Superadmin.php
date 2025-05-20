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
    //$this->load->model('Payment_model',  'payment_model');
    $this->load->model('Email_model',    'email_model');
    //$this->load->model('Addon_model',    'addon_model');
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

  /*public function dashboard() {
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
  }*/

  public function dashboard() {
      $cache_duration = cache_duration();
      $CI = &get_instance();  // Get CI instance once

      $page_data['page_title'] = 'Dashboard';
      $page_data['folder_name'] = 'dashboard';

      $date_start = "2024-06-05 00:00:00";
      $date_end = "2024-06-20 00:00:00";

      $page_data['startdate'] = date('d', strtotime($date_start));
      $page_data['month'] = date('m', strtotime($date_start));
      $page_data['days'] = date('t', strtotime($date_start));

      // Total Vyapari Count
      $page_data['vyapari'] = cache_with_ttl('dashboard.vyapari', function() use ($CI) {
          return $CI->db->count_all('app_vyapari');
      }, $cache_duration);

      // Total Unblock + Exit QR Codes
      $page_data['unblock'] = cache_with_ttl('dashboard.unblock', function() use ($CI) {
          return $CI->db->where_in('status', ['unblock', 'exit'])->count_all_results('app_qrcode');
      }, $cache_duration);

      // Total Block QR Codes
      $page_data['block'] = cache_with_ttl('dashboard.block', function() use ($CI) {
          return $CI->db->where('status', 'block')->count_all_results('app_qrcode');
      }, $cache_duration);

      // Total Exit QR Codes
      $page_data['exit'] = cache_with_ttl('dashboard.exit', function() use ($CI) {
          return $CI->db->where('status', 'exit')->count_all_results('app_qrcode');
      }, $cache_duration);

      // Daily Inward Animal Count
      $page_data['aniamalin'] = cache_with_ttl('dashboard.aniamalin', function() use ($CI, $date_start, $date_end) {
          //$CI->db->query("SET @@sql_mode=''"); // Remove if not needed
          $query = $CI->db->select('DAY(inward_date) AS DATE, COUNT(inward_date) AS count')
                          ->from('app_qrcode USE Index(idx_status_inwarddate)')
                          ->where_in('status', ['unblock', 'exit'])
                          ->where('inward_date >=', $date_start)
                          ->where('inward_date <=', $date_end)
                          ->group_by('DATE(inward_date)')
                          ->get()
                          ->result();
          return json_encode($query);
      }, $cache_duration);

      // Daily Exit Animal Count
      $page_data['aniamalout'] = cache_with_ttl('dashboard.aniamalout', function() use ($CI, $date_start, $date_end) {
          //$CI->db->query("SET @@sql_mode=''"); // Remove if not needed
          $query = $CI->db->select('DAY(exit_date) AS DATE, COUNT(exit_date) AS count')
                          ->from('app_qrcode USE INDEX (idx_status_exitdate)')
                          ->where('status', 'exit')
                          ->where('exit_date >=', $date_start)
                          ->where('exit_date <=', $date_end)
                          ->group_by('DATE(exit_date)')
                          ->get()
                          ->result();
          return json_encode($query);
      }, $cache_duration);

      // State-wise Vyapari Count
      $page_data['state_wise_vyapari'] = cache_with_ttl('dashboard.state_wise_vyapari', function() use ($CI) {
          $CI->db->select('CONCAT(UCASE(SUBSTRING(state, 1, 1)), LCASE(SUBSTRING(state, 2))) AS state, COUNT(vyapari_id) as total');
          $CI->db->from('app_vyapari');
          $CI->db->group_by('state');
          $CI->db->order_by('total', 'DESC');
          return $CI->db->get()->result_array();
      }, $cache_duration);

      // Total Exit QR Codes
      $page_data['active_admins'] = cache_with_ttl('dashboard.active_admins', function() use ($CI) {
          return $CI->db->where('user_status', 'active')->count_all_results('users');
      }, $cache_duration);      

      $this->load->view('backend/index', $page_data);
  }

  //SETTINGS MANAGER
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
    if (empty($param1) || $param1 == 'other_settings') {
      $page_data['page_content']  = 'other_settings';
    }
    // if(empty($param1) || $param1 == 'general_settings'){
    //   $page_data['page_content']  = 'general_settings';
    // }

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

  public function update_digits_settings($param1 = "") {
    $data1['description'] = $this->input->post('printing_qrcode_digit');
    $data2['description'] = $this->input->post('printing_qrcode_version');
    $data3['description'] = $this->input->post('validate_qrcode_digit');
    $this->db->where('type', 'printing_qrcode_digit');
    $this->db->update('common_settings', $data1);

    $this->db->where('type', 'printing_qrcode_version');
    $this->db->update('common_settings', $data2);

    $this->db->where('type', 'validate_qrcode_digit');
    $this->db->update('common_settings', $data3);

    $response = array(
      'status' => true,
      'notification' => get_phrase('digits_settings_updated')
    );
    echo json_encode($response);
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
  
  public function aadhar_vyapari_detail(){
      $aadhar_no = $this->input->post('Aadhar_no');
      
      $vyapari_data = $this->db->where('aadhar_no', $aadhar_no)->get('vyapari_detail')->row();
      
      if($vyapari_data){
          echo json_encode(array("Status" => "True","vyapari" => $vyapari_data));
      }else{
          echo json_encode(array("Status" => "False"));
      }
  }

  public function clear_cache()
  {
      // Clear all cache (ensure you have a valid clear_all_cache() helper or method)
      if (function_exists('clear_all_cache')) {
          clear_all_cache();
      }

      // Set a flash message
      $this->session->set_flashdata('flash_message', get_phrase('all_cache_cleared'));

      // Redirect to previous page
      $referrer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : base_url();
      redirect($referrer);
  } 
  
}
