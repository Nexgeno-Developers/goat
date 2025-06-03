<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller
{
    private $max_requests = 3; // Max requests allowed
    private $time_window = 60; // Time window in seconds

    public function __construct()
    {
        parent::__construct();

        // Set security headers globally
        header('Content-Type: application/json');
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: SAMEORIGIN');
        header('X-XSS-Protection: 1; mode=block');

        // Allow only same-origin requests (Referer or Origin must match base_url)
        $base_url = base_url();
        $referer = $_SERVER['HTTP_REFERER'] ?? '';
        $origin = $_SERVER['HTTP_ORIGIN'] ?? '';

        if (
            (strpos($referer, $base_url) !== 0) &&
            (strpos($origin, $base_url) !== 0)
        ) {
            echo json_encode([
                'status' => false,
                'notification' => 'Cross-origin requests are not allowed.'
            ]);
            exit; // Stop further execution
        }

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
     * API Endpoint: Location
     */
    // private function is_within_range($userLat, $userLng)
    // {
    //     //return true;
    //     // Your fixed location (e.g., event location)
    //     $targetLat = 19.0565457;  // Deonar latitude
    //     $targetLng = 72.917362;  // Deonar longitude 19.0565457,72.917362

    //     // $targetLat = 26.8467;
    //     // $targetLng = 80.9462;        

    //     // Calculate distance using Haversine formula
    //     $earthRadius = 6371; // Radius of Earth in km

    //     $dLat = deg2rad($targetLat - $userLat);
    //     $dLng = deg2rad($targetLng - $userLng);

    //     $a = sin($dLat/2) * sin($dLat/2) +
    //         cos(deg2rad($userLat)) * cos(deg2rad($targetLat)) *
    //         sin($dLng/2) * sin($dLng/2);

    //     $c = 2 * atan2(sqrt($a), sqrt(1-$a));
    //     $distance = $earthRadius * $c;

    //     // Check if within 5 km radius
    //     return $distance <= 3;
    // }  
    
    private function is_within_range($userLat, $userLng)
    {
        return true;
        // Fixed location (Deonar)
        $targetLat = 19.0565457;
        $targetLng = 72.917362;

        // Earth’s radius in KM
        $earthRadius = 6371;

        // Convert all to radians
        $userLatRad = deg2rad($userLat);
        $userLngRad = deg2rad($userLng);
        $targetLatRad = deg2rad($targetLat);
        $targetLngRad = deg2rad($targetLng);

        // Differences
        $latDelta = $targetLatRad - $userLatRad;
        $lngDelta = $targetLngRad - $userLngRad;

        // Haversine formula
        $a = sin($latDelta / 2) * sin($latDelta / 2) +
            cos($userLatRad) * cos($targetLatRad) *
            sin($lngDelta / 2) * sin($lngDelta / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = $earthRadius * $c;

        // Optional: log for debug
        // error_log("Distance from Deonar: " . $distance . " km");

        // Check if within 2 km
        return $distance <= 2;
    }    

    /**
     * API Endpoint: Verify Pass by QR code
     */
    public function pass_verify()
    {
        //sleep(3);
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


        $latitude = trim($this->db->escape_str($this->input->post('latitude', true)));
        $longitude = trim($this->db->escape_str($this->input->post('longitude', true)));
        if (!$this->is_within_range($latitude, $longitude)) {
            echo json_encode([
                'status' => false,
                'notification' => 'You are not within the allowed location range.'
            ]); 
            return;       
        }        

        $qrcode = trim($this->db->escape_str($this->input->post('qrcode', true)));
        $validate_qrcode_digit = get_common_settings('validate_qrcode_digit');

        // Validate QR code length
        if (strlen($qrcode) != $validate_qrcode_digit) {
            echo json_encode([
                'status' => false,
                'notification' => "Invalid Pass Number : {$qrcode}"
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
                'name' => ucfirst($result['name']),
                'photo' => base_url('uploads/vyapari_photo/' . $result['photo']) . '?' . time()
            ];
            $response = [
                'status' => true,
                'notification' => "Valid Pass Number : {$qrcode}",
                'data' => $data
            ];
        } else {
            $response = [
                'status' => false,
                'notification' => "Invalid Pass Number : {$qrcode}"
            ];
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    /**
     * API Endpoint: Verify Pass by QR code
     */
    public function vyapari_verify()
    {
        //sleep(3);
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


        $latitude = trim($this->db->escape_str($this->input->post('latitude', true)));
        $longitude = trim($this->db->escape_str($this->input->post('longitude', true)));
        if (!$this->is_within_range($latitude, $longitude)) {
            echo json_encode([
                'status' => false,
                'notification' => 'You are not within the allowed location range.'
            ]); 
            return;       
        }        

        $qrcodeInput = trim($this->db->escape_str($this->input->post('qrcode', true)));

        // Check if base64 encoded
        $decodedQrcode = base64_decode($qrcodeInput, true);
        $isBase64 = $decodedQrcode !== false && base64_encode($decodedQrcode) === $qrcodeInput;

        $vyapariId = $isBase64 ? $decodedQrcode : end(explode('-', $qrcodeInput));        

        // Fetch data
        // $this->db->select('vyapari_id, name, photo, timestamp');
        // $this->db->from('app_vyapari');
        // $this->db->where('vyapari_id', base64_decode($qrcode));
        // $result = $this->db->get()->row_array();

        $this->db->select('
            v.vyapari_id,
            v.name,
            v.photo,
            v.timestamp,
            v.phone,
            COUNT(q.qrcode_id) as total_inward,
            SUM(CASE WHEN q.status = "exit" THEN 1 ELSE 0 END) as total_outward,
            SUM(CASE WHEN q.status = "block" THEN 1 ELSE 0 END) as total_block
        ');
        $this->db->from('app_vyapari v');
        $this->db->join('app_qrcode q', 'q.vyapari_id = v.vyapari_id', 'left');
        $this->db->where('v.vyapari_id', $vyapariId);
        $this->db->group_by('v.vyapari_id');

        $result = $this->db->get()->row_array();

        // Format response
        if ($result) {
            $data = [
                'vyapari_id' => vyapari_id($result['vyapari_id']),
                'name' => ucfirst($result['name']),
                'total_inward' => $result['total_inward'],
                'total_outward' => $result['total_outward'],
                'total_block' => $result['total_block'],
                'phone' => $result['phone'],
                'date' => date('d M, Y H:iA', strtotime($result['timestamp'])),
                'photo' => base_url('uploads/vyapari_photo/' . $result['photo']) . '?' . time()
            ];
            $response = [
                'status' => true,
                'notification' => "Vyapari ID is Valid",
                'data' => $data
            ];
        } else {
            $response = [
                'status' => false,
                'notification' => "Invalid Vyapari ID"
            ];
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }    
}