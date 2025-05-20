<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
*  @author   : Creativeitem
*  date      : November, 2019
*  Ekattor School Management System With Addons
*  http://codecanyon.net/user/Creativeitem
*  http://support.creativeitem.com
*/

function app_log($data)
{
    $CI =& get_instance();

    $insert['user_id']     = $CI->session->userdata('user_id');
    $insert['name']        = $data['name'];
    $insert['description'] = $data['description'];
    $insert['timestamp']   = date('Y-m-d H:i:s');

    $CI->db->insert('app_log', $insert);
}

function get_all_states()
{
    $CI =& get_instance();
    $states = $CI->db->get('state')->result_array();
    return $states;
}

function get_locality_by_state($state_id)
{
    $CI =& get_instance();
    $localities = $CI->db->where('state_id', $state_id)->get('locality')->result_array();
    return $localities;
}

function vyapari_id($id = "")
{
    //    return 'V2024-'.$id;
    return 'V' . date('Y') . '-' . $id;
}

function compressImage($source, $destination, $quality) 
{
	// Get image info
	$imgInfo = getimagesize($source);
	$mime = $imgInfo['mime'];
	
	// Create a new image from file
	switch($mime){
		case 'image/jpeg':
			$image = imagecreatefromjpeg($source);
			break;
		case 'image/png':
			$image = imagecreatefrompng($source);
			break;
		case 'image/gif':
			$image = imagecreatefromgif($source);
			break;
		default:
			$image = imagecreatefromjpeg($source);
	}
	// Save image
    imagejpeg($image, $destination, $quality);
}


function access($action)
{
    $CI = & get_instance();
    $role = $CI->session->userdata('role_type');
    
    if($role == 'superadmin')
    {
        return true;
    }
    else
    {
        if($action == 'registration_button') //registration of vyapari
        {
            if($role == 'inward')
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        elseif($action == 'printid_button') //print id of vyapari
        {
            if($role == 'inward' || $role == 'gate_manager')
            {
                return true;
            }
            else
            {
                return false;
            }        
        }
        elseif($action == 'allocate_pass_button') //print id of vyapari
        {
            if($role == 'inward')
            {
                return true;
            }
            else
            {
                return false;
            }        
        }
        elseif($action == 'allocate_pandol') //print id of vyapari
        {
            if($role == 'inward')
            {
                return true;
            }
            else
            {
                return false;
            }        
        }
        elseif($action == 'manage_pass_button') //block /unblock pass of vyapari
        {
            if($role == 'inward' || $role == 'gate_manager')
            {
                return true;
            }
            else
            {
                return false;
            }         
        }
        
         elseif($action == 'manage_bulk_pass_button') //block /unblock pass of vyapari
        {
            if($role == 'inward')
            {
                return true;
            }
            else
            {
                return false;
            }         
        }
        elseif($action == 'manage_user_button') //user activate
        {
            if($role == 'admin1' || $role == 'gate_manager')
            {
                return true;
            }
            else
            {
                return false;
            }         
        }
        elseif($action == 'print_user_button') //user activate
        {
            if($role == 'gate_manager')
            {
                return true;
            }
            else
            {
                return false;
            }         
        }        
        elseif($action == 'gate_edit_button') //user activate
        {
            if($role == 'gate_manager')
            {
                return false;
            }
            else
            {
                return false;
            }         
        }        
        elseif($action == 'manage_vyapari') //vyapari page
        {
            if($role == 'admin' || $role == 'inward' || $role == 'outward' || $role == 'registration' || $role == 'bmc' || $role == 'gate_manager')
            {
                return true;
            }
            else
            {
                return false;
            }         
        } 
        elseif($action == 'exit_verification') //exit page
        {
            if($role == 'outward' || $role == 'gate_manager')
            {
                return true;
            }
            else
            {
                return false;
            }         
        }  
        elseif($action == 'manage_admins') //manage admin page
        {
            if($role == 'admin' || $role == 'bmc' || $role == 'gate_manager')
            {
                return true;
            }
            else
            {
                return false;
            }         
        } 
        elseif($action == 'reports') //report page
        {
            if($role == 'doctor' || $role == 'bmc' || $role == 'admin' || $role == 'outward' || $role == 'inward' || $role == 'gate_manager') //$role == 'admin'
            {
                return true;
            }
            else
            {
                return false;
            }         
        } 
        elseif($action == 'pass_inward_report')
        {
            if($role == 'bmc' || $role == 'admin' || $role == 'outward' || $role == 'inward' || $role == 'gate_manager')
            {
                return true;
            }
            else
            {
                return false;
            }         
        }   
        elseif($action == 'pass_outward_report')
        {
            if($role == 'bmc' || $role == 'admin' || $role == 'outward' || $role == 'inward' || $role == 'gate_manager')
            {
                return true;
            }
            else
            {
                return false;
            }         
        } 
        elseif($action == 'pass_block_report')
        {
            if($role == 'bmc' || $role == 'admin' || $role == 'outward' || $role == 'inward' || $role == 'gate_manager')
            {
                return true;
            }
            else
            {
                return false;
            }         
        }  
        elseif($action == 'pandol_info_report')
        {
            if($role == 'doctor' || $role == 'bmc' || $role == 'admin' || $role == 'inward' || $role == 'gate_manager')
            {
                return true;
            }
            else
            {
                return false;
            }         
        }         
    }
}

function old_vyapari_check($param){
    $CI      = & get_instance();
	$vyapari = $CI->input->post();
    
    $old_vyapari['name']      = $vyapari["name"];
	$old_vyapari['phone']     = $vyapari["phone"];
	$old_vyapari['aadhar_no'] = $vyapari["aadhar_no"];
	$old_vyapari['address']   = $vyapari["address"];
	$old_vyapari['state']     = $vyapari["state"];
	$old_vyapari['locality']  = $vyapari["locality"];
	
	$vapari_data = $CI->db->where('aadhar_no',$old_vyapari['aadhar_no'])->get('vyapari_detail')->row();
	
	if (empty($vapari_data)) {
       $CI->db->insert('vyapari_detail', $old_vyapari);
    } else {
       $CI->db->where('aadhar_no', $old_vyapari['aadhar_no'])->update('vyapari_detail', $old_vyapari);
    }
}


if(!function_exists('sendEmail')){
    function sendEmail($to, $subject, $body, $replyTo = null)
    {

        $CI =& get_instance();
        // Load the config file
        $CI->load->config('api_keys');
        // Access the key
        $apiKey = $CI->config->item('BRAVIO_API');

        // API endpoint
        $url = 'https://api.brevo.com/v3/smtp/email';
        
        // Data to be sent
        $data = [
            "sender" => [
                "name" => "Nexgeno",
                "email" => "mohammadzshaikh123@gmail.com"
            ],
            "to" => [
                [
                    "email" => $to,
                ]
            ],
            "subject" => $subject,
            "htmlContent" => $body
        ];

        $postData = json_encode($data);

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'accept: application/json',
            'api-key: ' . $apiKey,
            'content-type: application/json'
        ]);

        $response = curl_exec($ch);
        $error = curl_error($ch);

        curl_close($ch);

        if ($error) {
            log_message('error', 'Brevo Email Error: ' . $error);
            return false;
        } else {
            $responseData = json_decode($response, true);
            log_message('info', 'Brevo Email Response: ' . print_r($responseData, true));
            return $responseData;
        }
    
    }  
}
