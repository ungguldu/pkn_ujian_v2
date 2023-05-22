<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Kelola_presensi extends MY_Controller {
    
    public function __construct()
    {
        parent::__construct();
        //
        if (user()->role !== 'akademik') {
            redirect('welcome');
        }
        // batasi lanjut jika aplikasi belum disetting
        if ($this->db->count_all_results('apps_setting') < 6) {
            set_alert('warning', 'Lengkapi setting aplikasi dulu ya min... 😒', 'welcome');
        }
    }

    public function index()
    {
        // jika ada tampilkan tabel jadwal dan form
        $q = !empty($this->input->get('cari', true)) ? urldecode(xss_clean($this->input->get('cari', true))) : null;
        $start = is_numeric($this->input->get('mulai', true)) ? intval($this->input->get('mulai', true)) : 0;
        $per_page = is_numeric($this->input->get('per_page', true)) ? intval($this->input->get('per_page', true)) : 10;

        $this->load->model('Apps_model');

        $config['base_url'] = current_url();
        $config['first_url'] = current_url();
        $config['per_page'] = $per_page;
        $config['page_query_string'] = true;
        $config['total_rows'] = $this->Apps_model->total_data('riwayat_presensi', $q);

        // load
        $this->load->library('pagination');
        $this->pagination->initialize($config);
        
        $presensi = $this->db->limit($per_page, $start)->get('riwayat_presensi a')->result();

        $data = [
            'start' => $start,
            'total' => $config['total_rows'],
            'halaman' => paginasi($config['total_rows'], $start, $per_page, $this->pagination->create_links()),
            'presensi' => $presensi,
            'page' => 'pages/akademik/kelola_presensi_index',
        ];

        $this->load->view('template_apps', $data ?? null, false);
    }

}

/* End of file Kelola_presensi.php */
