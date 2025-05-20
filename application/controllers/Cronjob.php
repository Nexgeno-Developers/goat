<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
*  @author   : Creativeitem
*  date      : November, 2019
*  Ekattor School Management System With Addons
*  http://codecanyon.net/user/Creativeitem
*  http://support.creativeitem.com
*/

class Cronjob extends CI_Controller {

	function __construct()
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

}
