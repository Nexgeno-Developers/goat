<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('Settings_model', 'settings_model');
    }

    function verification()
    {
        $page_data['data'] = null;
		$this->load->view('frontend/qrcode/verification', $page_data);
    }
}
