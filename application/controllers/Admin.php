<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = [
            'page' => 'pages/admin/index',
        ];
        $this->load->view('template_apps', $data ?? null, FALSE);

    }

}

/* End of file Admin.php */
