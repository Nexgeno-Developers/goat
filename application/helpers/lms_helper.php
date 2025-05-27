<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
require FCPATH . 'vendor/autoload.php';
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
            if($role == 'inward')
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
            if($role == 'inward' || $role == 'gate_manager' || $role == 'admin' || $role == 'doctor')
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
            if($role == 'doctor')
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
            if($role == 'admin' || $role == 'gate_manager')
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
            if($role == 'gate_manager' || $role == 'admin')
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
            if($role == 'admin' || $role == 'inward' || $role == 'registration' || $role == 'gate_manager')
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
            if($role == 'outward' || $role == 'gate_manager' || $role == 'admin')
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
            if($role == 'admin' || $role == 'gate_manager')
            {
                return true;
            }
            else
            {
                return false;
            }         
        } 

        elseif($action == 'master_list') //manage admin page
        {
            if($role == 'admin' || $role == 'bmc')
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
            if($role == 'doctor' || $role == 'bmc' || $role == 'admin' || $role == 'inward' || $role == 'gate_manager' || $role == 'police') //$role == 'admin'
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
            if($role == 'admin' || $role == 'inward')
            {
                return true;
            }
            else
            {
                return false;
            }         
        }
        
        elseif($action == 'menu_agent')
        {
            if($role == 'admin')
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
            if($role == 'admin' || $role == 'gate_manager')
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
            if($role == 'bmc' || $role == 'admin' || $role == 'inward' || $role == 'gate_manager' ||  $role == 'police' || $role == 'doctor')
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
            if($role == 'doctor' || $role == 'admin' || $role == 'bmc')
            {
                return true;
            }
            else
            {
                return false;
            }         
        }  

        elseif($action == 'statewise_vyapari_report')
        {
            if($role == 'bmc' || $role == 'police' || $role == 'doctor')
            {
                return true;
            }
            else
            {
                return false;
            }         
        }  

        elseif($action == 'statewise_goat_report')
        {
            if($role == 'bmc' || $role == 'police' || $role == 'doctor')
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
    function sendEmail($to = [], $subject, $body, $cc = [], $replyTo = null)
    {

        $CI =& get_instance();
        // Load the config file
        $CI->load->config('api_keys');
        // Access the key
        $apiKey = $CI->config->item('BRAVIO_API');

        // API endpoint
        $url = 'https://api.brevo.com/v3/smtp/email';
        
        // Data to be sent
        $toRecipients = array_map(function ($email) {
            return ['email' => $email];
        }, (array) $to);

        // Convert "cc" emails to required format
        $ccRecipients = array_map(function ($email) {
            return ['email' => $email];
        }, (array) $cc);

        // Build the request payload
        $data = [
            "sender" => [
                "name" => "Nexgeno",
                "email" => "zaid.nexgeno@gmail.com"
            ],
            "to" => $toRecipients,
            "subject" => $subject,
            "htmlContent" => $body
        ];

        // Add CC if provided
        if (!empty($ccRecipients)) {
            $data['cc'] = $ccRecipients;
        }

        // Add replyTo if provided
        if (!empty($replyTo)) {
            $data['replyTo'] = ['email' => $replyTo];
        }

        // Send request
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'api-key: ' . $apiKey,
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_POST, true);

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


function save_qrcode(string $content, string $savePath, int $scale = 5): bool
{
    $options = new \chillerlan\QRCode\QROptions([
        'eccLevel'    => \chillerlan\QRCode\QRCode::ECC_H,
        'outputType'  => \chillerlan\QRCode\QRCode::OUTPUT_IMAGE_PNG,
        'imageBase64' => false,
        'scale'       => $scale,
    ]);

    $qrImage = (new \chillerlan\QRCode\QRCode($options))->render($content);

    // Ensure directory exists
    $dir = dirname($savePath);
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }

    return file_put_contents($savePath, $qrImage) !== false;
}