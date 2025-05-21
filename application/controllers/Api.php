<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller
{
    private $max_requests = 3; // Max requests allowed
    private $time_window = 120; // Time window in seconds

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->database();
    }

    /**
     * Rate limiter using session storage
     */
    private function rate_limit_check($key)
    {
        $now = time();
        $requests = $this->session->userdata($key) ?? [];

        // Remove timestamps older than the time window
        $requests = array_filter($requests, function ($timestamp) use ($now) {
            return ($timestamp + $this->time_window) > $now;
        });

        if (count($requests) >= $this->max_requests) {
            return false; // Rate limit exceeded
        }

        // Add current timestamp
        $requests[] = $now;
        $this->session->set_userdata($key, $requests);
        return true;
    }

    /**
     * API Endpoint: Verify Pass by QR code
     */
    public function pass_verify()
    {
        header('Content-Type: application/json');

        // Allow only POST method
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode([
                'status' => false,
                'notification' => 'Requests not allowed.'
            ]);
            return;
        }

        // Apply rate limit
        if (!$this->rate_limit_check('verification_requests')) {
            echo json_encode([
                'status' => false,
                'notification' => 'Too many attempts. please try again after sometime.'
            ]);
            return;
        }

        $qrcode = trim($this->db->escape_str($this->input->post('qrcode', true)));
        $validate_qrcode_digit = get_common_settings('validate_qrcode_digit');

        // Validate QR code length
        if (strlen($qrcode) != $validate_qrcode_digit) {
            echo json_encode([
                'status' => false,
                'notification' => "The pass number {$qrcode} is invalid."
            ]);
            return;
        }

        // Fetch data
        $this->db->select('app_qrcode.vyapari_id, app_vyapari.name, app_vyapari.photo');
        $this->db->from('app_qrcode');
        $this->db->join('app_vyapari', 'app_vyapari.vyapari_id = app_qrcode.vyapari_id', 'left');
        $this->db->where([
            'app_qrcode.status' => 'unblock',
            'app_qrcode.qrcode' => $qrcode
        ]);
        $result = $this->db->get()->row_array();

        // Format response
        if ($result) {
            $data = [
                'vyapari_id' => vyapari_id($result['vyapari_id']),
                'name' => $result['name'],
                'photo' => base_url('uploads/vyapari_photo/' . $result['photo']) . '?' . time()
            ];
            $response = [
                'status' => true,
                'notification' => "The pass number {$qrcode} is valid.",
                'data' => $data
            ];
        } else {
            $response = [
                'status' => false,
                'notification' => "The pass number {$qrcode} is invalid."
            ];
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}