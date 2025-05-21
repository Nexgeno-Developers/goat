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
	}

    public function clean_old_sessions_and_logs()
    {
        //echo 1; exit;
        // Path to session files (update if using a custom path)
        $session_path = APPPATH . 'ci_sessions/';

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
        $body = '
                <html>
                <head>
                    <style>
                        table {
                            width: 100%;
                            border-collapse: collapse;
                            font-family: Arial, sans-serif;
                        }
                        th, td {
                            border: 1px solid #dddddd;
                            text-align: left;
                            padding: 8px;
                        }
                        th {
                            background-color: #f2f2f2;
                        }
                    </style>
                </head>
                <body>
                    <h2>Goat Movement Summary Report</h2>
                    <table>
                        <tr>
                            <th>Item</th>
                            <th>Total</th>
                        </tr>
                        <tr>
                            <td>Inward Total Goat</td>
                            <td><b>' . $unblock . '</b></td>
                        </tr>
                        <tr>
                            <td>Outward Total Goat</td>
                            <td><b>' . $exit . '</b></td>
                        </tr>
                        <tr>
                            <td>Balance Total Goat</td>
                            <td><b>' . ($unblock - $exit) . '</b></td>
                        </tr>
                        <tr>
                            <td>Pass Blocked</td>
                            <td><b>' . $block . '</b></td>
                        </tr>
                        <tr>
                            <td>Registered Total Vyapari</td>
                            <td><b>' . $vyapari . '</b></td>
                        </tr>
                    </table>
                    <br>
                    <p><b>Regards,</b><br><b>Nexgeno Developer Team</b></p>
                </body>
                </html>';

        
        $test = sendEmail($email_bmc, $subject, $body, $ccList);

        var_dump($test);

    }

}
