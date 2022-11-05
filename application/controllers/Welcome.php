<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('string');
    }

    public function index()
    {
        switch (user()->role) {
            case 'akademik':
                $data = [
                    'page' => 'pages/akademik/welcome',
                ];

                $this->load->view('template_apps', $data ?? null, false);
                break;
            case 'si_super':
                # code...
                break;
            case 'pengawas':
                redirect('pengawas');
                break;
            default:
                redirect('mahasiswa');
                break;
        }
    }

    public function download(string $mode = null)
    {
        $file = sanitize_filename($this->input->get('file', true));
        $base_path = WRITEPATH . 'data' . DIRECTORY_SEPARATOR;
        if (is_file(realpath($base_path . $file))) {
            $this->load->helper('download');
            force_download($base_path . $file, null);
        } else {
            set_alert('warning', 'File tidak ditemukan. Gunakan tautan yang disediakan!', $this->agent->referrer());
        }
    }
}
