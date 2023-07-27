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

        // filter param
        $sesi = !empty($this->input->get('sesi', true)) ? is_numeric(xss_clean($this->input->get('sesi', true))) : null;
        $prodi = !empty($this->input->get('prodi', true)) ? urldecode(xss_clean($this->input->get('prodi', true))) : null;
        $kelas = !empty($this->input->get('kelas', true)) ? urldecode(xss_clean($this->input->get('kelas', true))) : null;
        // filter
        $filter = ['sesi' => $sesi, 'program_studi' => $prodi, 'kelas' => $kelas];

        $this->load->model('Apps_model');

        $config['base_url'] = current_url();
        $config['first_url'] = current_url();
        $config['per_page'] = $per_page;
        $config['page_query_string'] = true;
        $config['total_rows'] = (!empty($sesi) and !empty($prodi) and !empty($kelas)) ? $this->db->where($filter)->from('riwayat_presensi')->count_all_results() : $this->Apps_model->total_data('riwayat_presensi', $q);

        // load
        $this->load->library('pagination');
        $this->pagination->initialize($config);
        // cari
        $like = ['nim' => $q, 'nama_lengkap' => $q, 'program_studi' => $q, 'kelas' => $q, 'sesi' => $q, 'mata_kuliah' => $q];
        
        !empty($q) ? $this->db->or_like($like) : false;
        (!empty($sesi) and !empty($prodi) and !empty($kelas)) ? $this->db->where($filter) : false;
        $presensi = $this->db->limit($per_page, $start)->order_by('sesi, program_studi, kelas ASC')->get('riwayat_presensi')->result();

        // helper group opt
        function _group_by($array, $key)
        {
            if(empty($array)) return [];
            $arr_key = array_keys($array[0]);
            $ret_key = array_values(array_diff($arr_key, [$key]));

            foreach ($array as $val) {
                $return[$val[$key]][] = $val[$ret_key[0]];
            }
            return $return;
        }

        $row_filter_sesi_prodi = $this->db->select('distinct program_studi, sesi', false)->order_by('sesi, program_studi ASC')->get('riwayat_presensi')->result_array();
        $row_filter_prodi_kelas = $this->db->select('distinct program_studi, kelas, sesi', false)->order_by('sesi, program_studi ASC')->get('riwayat_presensi')->result_array();
        $opt_sesi_prodi = _group_by($row_filter_sesi_prodi, 'sesi');
        $opt_prodi_kelas = _group_by($row_filter_prodi_kelas, 'program_studi');

        $data = [
            'q' => $q,
            'start' => $start,
            'total' => $config['total_rows'],
            'halaman' => paginasi($config['total_rows'], $start, $per_page, $this->pagination->create_links()),
            'presensi' => $presensi,
            'filter' => (!empty($sesi) and !empty($prodi) and !empty($kelas)),
            'opt_sesi' => !empty($opt_sesi_prodi) ? array_keys($opt_sesi_prodi) : [],
            'opt_sesi_prodi' => json_encode($opt_sesi_prodi ?? [], JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES),
            'opt_prodi_kelas' => json_encode($opt_prodi_kelas ?? [], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
            'page' => 'pages/akademik/kelola_presensi_index',
        ];

        $this->load->view('template_apps', $data ?? null, false);
    }

}

/* End of file Kelola_presensi.php */
