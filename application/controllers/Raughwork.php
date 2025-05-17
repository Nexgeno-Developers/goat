<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
*  @author   : Creativeitem
*  date      : November, 2019
*  Ekattor School Management System With Addons
*  http://codecanyon.net/user/Creativeitem
*  http://support.creativeitem.com
*/


class Raughwork extends CI_Controller {

	public function __construct(){
		parent::__construct();

		$this->load->database();
		$this->load->library('session');

		/*cache control*/
		$this->output->set_header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
		$this->output->set_header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
		$this->output->set_header("Cache-Control: post-check=0, pre-check=0", false);
		$this->output->set_header("Pragma: no-cache");


	}

    function test() {
        // Check if form is submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Retrieve the posted QR code
            $qrcode = $this->input->post('qrcode');
            
            // Perform the database query
            $this->db->select('status, exit_gate, qrcode');
            $this->db->from('app_qrcode use index(qrcode)');
            $this->db->where('qrcode', $qrcode);
            $result = $this->db->get()->row_array();
    
            // Display the result
            echo '<pre>';
            var_dump($result);
            echo '</pre>';
        } else {
            // Display the form if not submitted
            echo '
            <form method="POST" action="">
                <label for="qrcode">QR Code:</label>
                <input type="text" id="qrcode" name="qrcode" required>
                <button type="submit">Submit</button>
            </form>
            ';
        }
    }

    function get_inward_exit_counts($date_start = '2024-06-05 00:00:00', $date_end = '2024-06-20 00:00:00') {
        $CI =& get_instance();

        // Benchmark exit_date query
        $CI->benchmark->mark('exit_query_start');

                    // $this->db->select("p.name AS pandaal_no, COUNT(q.pandaal_no) AS balance_pass");
                    // $this->db->from("app_pandols p");
                    // $this->db->join("app_qrcode q", "p.name = q.pandaal_no AND q.status != 'exit'", "left");
                    // $this->db->group_by("p.name");
                    // $pandol_report = $this->db->get()->result_array();      

                    $this->db->select("p.name AS pandaal_no, COUNT(q.pandaal_no) AS balance_pass");
                    $this->db->from("app_pandols p");

                    // Use STRAIGHT_JOIN to force join order, if needed
                    $this->db->join("app_qrcode q USE INDEX (idx_status_pandaal_no)", "p.name = q.pandaal_no AND q.status != 'exit'", "left");

                    $this->db->group_by("p.name");
                    $pandol_report = $this->db->get()->result_array();                    

        $CI->benchmark->mark('exit_query_end');


        echo '<pre>';
        //var_dump($results['exit_data']);
        echo "\nExecution Time: " . $CI->benchmark->elapsed_time('exit_query_start', 'exit_query_end') . " seconds";
        echo '</pre>';
    }   
	
}