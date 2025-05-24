<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
*  @author   : Creativeitem
*  date      : November, 2019
*  Ekattor School Management System With Addons
*  http://codecanyon.net/user/Creativeitem
*  http://support.creativeitem.com
*/

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

require FCPATH . 'vendor/autoload.php';

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

            $this->db->select('pandaal_no,COUNT(pandaal_no) as balance_pass');
            $this->db->from('app_qrcode');
            $this->db->group_by('pandaal_no');
            $this->db->where('status !=', 'exit');
            $this->db->where('pandaal_no !=', '');
            $pandol_report = $this->db->get()->result_array();              

        $CI->benchmark->mark('exit_query_end');


        echo '<pre>';
        //var_dump($results['exit_data']);
        echo "\nExecution Time: " . $CI->benchmark->elapsed_time('exit_query_start', 'exit_query_end') . " seconds";
        echo '</pre>';
    } 
    
public function test_custom_qrcode()
{
    $text = '123456789';
    $logoPath = FCPATH . 'assets/logo.png'; // <-- Make sure this exists and is PNG format

    $options = new \chillerlan\QRCode\QROptions([
        'eccLevel' => \chillerlan\QRCode\QRCode::ECC_H, // High error correction
        'outputType' => \chillerlan\QRCode\QRCode::OUTPUT_IMAGE_PNG,
        'scale' => 10,
        'imageBase64' => false,
        'version' => 5,
        'foregroundColor' => [30, 58, 138],       // Dark Blue
        'backgroundColor' => [255, 255, 255],     // White
    ]);

    // Generate QR image and save temporarily
    $qrcode = (new \chillerlan\QRCode\QRCode($options))->render($text);
    $tempQRPath = FCPATH . 'uploads/temp_qr.png';
    var_dump($tempQRPath);exit;
    file_put_contents($tempQRPath, $qrcode);

    // Load QR and logo
    $qr = imagecreatefrompng($tempQRPath);
    $logo = imagecreatefrompng($logoPath);

    // Calculate sizes
    $qr_width = imagesx($qr);
    $qr_height = imagesy($qr);
    $logo_width = imagesx($logo);
    $logo_height = imagesy($logo);

    // Resize logo to 1/3 of QR code
    $logo_qr_width = $qr_width / 3;
    $scale = $logo_width / $logo_qr_width;
    $logo_qr_height = $logo_height / $scale;
    $from_width = ($qr_width - $logo_qr_width) / 2;

    // Merge logo to QR code
    imagecopyresampled(
        $qr,
        $logo,
        $from_width, $from_width, // Center
        0, 0,
        $logo_qr_width, $logo_qr_height,
        $logo_width, $logo_height
    );

    // Output image
    header('Content-Type: image/png');
    imagepng($qr);
    imagedestroy($qr);
    exit;
}

public function generate_qr_with_logo()
{
    $text = '123456789'; // Your QR data
    $logoPath = FCPATH . 'uploads/system/logo/header-logo.png'; // Must be a PNG file
    $finalSavePath = FCPATH . 'uploads/final_qr.png'; // Output file path

    $options = new \chillerlan\QRCode\QROptions([
        'eccLevel' => \chillerlan\QRCode\QRCode::ECC_H,
        'outputType' => \chillerlan\QRCode\QRCode::OUTPUT_IMAGE_PNG,
        'scale' => 10,
        'imageBase64' => false,
        'version' => 5,
        'foregroundColor' => [0, 0, 0],
        'backgroundColor' => [255, 255, 255],
    ]);

    // Generate base QR code
    $qrcode = (new \chillerlan\QRCode\QRCode($options))->render($text);
    $tempQRPath = FCPATH . 'uploads/temp_qr.png';
    file_put_contents($tempQRPath, $qrcode);

    // Load QR and logo
    $qr = imagecreatefrompng($tempQRPath);
    $logo = imagecreatefrompng($logoPath);

    // Sizes
    $qr_width = imagesx($qr);
    $qr_height = imagesy($qr);
    $logo_width = imagesx($logo);
    $logo_height = imagesy($logo);

    // Resize logo to 1/3 size of QR code
    $logo_qr_width = $qr_width / 3;
    $scale = $logo_width / $logo_qr_width;
    $logo_qr_height = $logo_height / $scale;
    $from_width = ($qr_width - $logo_qr_width) / 2;

    // Merge logo onto QR
    imagecopyresampled(
        $qr, $logo,
        $from_width, $from_width, // Center position
        0, 0,
        $logo_qr_width, $logo_qr_height,
        $logo_width, $logo_height
    );

    // Save the final QR code with logo
    imagepng($qr, $finalSavePath);
    imagedestroy($qr);
    imagedestroy($logo);

    echo 'QR Code with logo saved to <b>' . $finalSavePath . '</b>';
}

// public function save_qrcode(string $content, string $savePath, int $scale = 5): bool
// {
//     $options = new \chillerlan\QRCode\QROptions([
//         'eccLevel'    => \chillerlan\QRCode\QRCode::ECC_H,
//         'outputType'  => \chillerlan\QRCode\QRCode::OUTPUT_IMAGE_PNG,
//         'imageBase64' => false,
//         'scale'       => $scale,
//     ]);

//     $qrImage = (new \chillerlan\QRCode\QRCode($options))->render($content);

//     // Ensure directory exists
//     $dir = dirname($savePath);
//     if (!is_dir($dir)) {
//         mkdir($dir, 0755, true);
//     }

//     return file_put_contents($savePath, $qrImage) !== false;
// }


    public function test1($vyapari_id = 'v2025-10001') {
        $content = base64_encode($vyapari_id);
        $savePath = FCPATH . "uploads/vyapari_qrcode/{$vyapari_id}.png"; // ✅ use double quotes

        if (save_qrcode($content, $savePath)) {
            echo "QR code saved to: " . $savePath;
        } else {
            echo "Failed to save QR code.";
        }
    } //
	
}