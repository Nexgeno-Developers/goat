<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('Settings_model', 'settings_model');
    }

    function pass_verification()
    {
        $page_data['data'] = null;
		$this->load->view('frontend/qrcode/pass_verification', $page_data);
    }

    function vyapari_verification()
    {
        $page_data['data'] = null;
		$this->load->view('frontend/qrcode/vyapari_verification', $page_data);
    }    
}
