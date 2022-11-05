<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Tester extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if (ENVIRONMENT !== 'development') {
            redirect('auth', 'auto', 301);
        }
        // load library
        //$this->load->library();
    }

    public function index()
    {
        echo 'tester untuk upload file sesuai konfig';
    }

}

/* End of file Tester.php */
