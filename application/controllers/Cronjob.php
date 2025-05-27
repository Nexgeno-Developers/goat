<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
*  @author   : Creativeitem
*  date      : November, 2019
*  Ekattor School Management System With Addons
*  http://codecanyon.net/user/Creativeitem
*  http://support.creativeitem.com
*/

class Cronjob extends CI_Controller {

	function __construct() //
	{
		parent::__construct();
        $this->load->model('settings_model');
	}

    public function clean_old_sessions_and_logs()
    {
        //echo 1; exit;
        // Path to session files (update if using a custom path)
        $session_path = APPPATH. 'ci_sessions/';

        // Path to CodeIgniter log files
        $log_path = APPPATH . 'logs/';

        // Path to error_log file (can be in project root or logs — adjust as needed)
        $error_log_path = FCPATH . 'error_log'; // FCPATH = project root

        $now = time();
        $expiration = 3 * 24 * 60 * 60; // 3 days in seconds

        // --- Clean session files ---
        $session_files = glob($session_path.'/*'); // CI 3 default prefix

        foreach ($session_files as $file) {
            if (is_file($file) && ($now - filemtime($file)) >= $expiration) {
                var_dump($file);
                unlink($file);
            }
        }

        // --- Clean log files ---
        $log_files = glob($log_path . '*.php');

        foreach ($log_files as $file) {
            if (is_file($file) && ($now - filemtime($file)) >= $expiration) {
                unlink($file);
            }
        }

        // --- Clean error_log file ---
        if (file_exists($error_log_path) && ($now - filemtime($error_log_path)) >= $expiration) {
            unlink($error_log_path);
        }        

        echo "Old session and log files deleted.";
    }


    public function daily_dashbaord_report_eamil(){
        $CI = &get_instance();  // Get CI instance once
        $CI->load->database();

        // Total Vyapari Count
        $vyapari = $CI->db->count_all('app_vyapari');

        // Total Unblock + Exit QR Codes
        $unblock = $CI->db
            ->where_in('status', ['unblock', 'exit'])
            ->count_all_results('app_qrcode');

        // Total Block QR Codes
        $block = $CI->db
            ->where('status', 'block')
            ->count_all_results('app_qrcode');

        // Total Exit QR Codes
        $exit = $CI->db
            ->where('status', 'exit')
            ->count_all_results('app_qrcode'); 

        $emails = $CI->db
                ->select('email')
                ->from('users')
                ->where('role_type', 'bmc')
                ->where('user_status','active')
                ->get()
                ->result();

        $email_bmc = array_column($emails, 'email');

        $ccEmails = $CI->db
            ->select('email')
            ->from('users')
            ->where('role_type', 'superadmin')
            ->get()
            ->result();

        $ccList = array_column($ccEmails, 'email');

        date_default_timezone_set('Asia/Kolkata');
        $subject = "Goat Movement Report Till Now " . date('d-M-Y h:i:s A');
        //$logoUrl = $this->settings_model->get_logo_light().'?v='.time();
        $logoUrl = 'https://i.ibb.co/nsP1fvGN/logo-dark-webp.webp';
        $body = '
<html>
<head>
    <style>
        @media only screen and (max-width: 620px) {
            .email-container {
                width: 100% !important;
                padding: 10px !important;
            }
        }
    </style>
</head>
<body style="margin:0; padding:0; background-color:#f9f9f9; padding-bottom:20px;">
    <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" class="email-container" style="width:600px; margin:auto; background-color:#ffffff; font-family: Arial, sans-serif; border:0px solid #e0e0e0;">
        <tr>
            <td align="center" style="padding:20px 0;">
                <img src="' . $logoUrl . '" alt="Logo" width="110" style="display:block;">
            </td>
        </tr>
        <tr>
            <td style="padding:20px; padding-top:0px !important;">
                <h2 style="color:#333333; margin-bottom:20px; text-align:center; margin-top:0px;">Goat Movement Summary Report</h2>
                <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse: collapse; font-size:14px;">
                    <thead>
                        <tr>
                            <th style="background-color:#f2f2f2; border:1px solid #dddddd; text-align:left; padding:10px;">Item</th>
                            <th style="background-color:#f2f2f2; border:1px solid #dddddd; text-align:left; padding:10px;">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="border:1px solid #dddddd; padding:10px;">Inward Total Goat</td>
                            <td style="border:1px solid #dddddd; padding:10px;"><b>' . $unblock . '</b></td>
                        </tr>
                        <tr>
                            <td style="border:1px solid #dddddd; padding:10px;">Outward Total Goat</td>
                            <td style="border:1px solid #dddddd; padding:10px;"><b>' . $exit . '</b></td>
                        </tr>
                        <tr>
                            <td style="border:1px solid #dddddd; padding:10px;">Balance Total Goat</td>
                            <td style="border:1px solid #dddddd; padding:10px;"><b>' . ($unblock - $exit) . '</b></td>
                        </tr>
                        <tr>
                            <td style="border:1px solid #dddddd; padding:10px;">Pass Blocked</td>
                            <td style="border:1px solid #dddddd; padding:10px;"><b>' . $block . '</b></td>
                        </tr>
                        <tr>
                            <td style="border:1px solid #dddddd; padding:10px;">Registered Total Vyapari</td>
                            <td style="border:1px solid #dddddd; padding:10px;"><b>' . $vyapari . '</b></td>
                        </tr>
                    </tbody>
                </table>
                <p style="margin-top:30px; font-size:14px; color:#555555;">
                    <b>Regards,</b><br>
                    Nexgeno Developer Team
                </p>
            </td>
        </tr>
    </table>
</body>
</html>';

        if($this->input->get('test') == 'true'){
            $email_bmc = ['rashid.makent@gmail.com'];
            $ccList = ['webdeveloper@nexgeno.in'];
        }
        echo '<pre>';
        print_r($email_bmc);
        print_r($ccList);
        print_r($logoUrl);
        echo '</pre>';
        
        $test = sendEmail($email_bmc, $subject, $body, $ccList);
        var_dump($test);

    }

}
