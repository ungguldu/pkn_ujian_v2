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
                $setting = $this->db->select('nama, isi')->get('apps_setting')->result_array();
                $setting = array_column($setting, 'isi', 'nama');           
                $data = [
                    'page' => 'pages/akademik/welcome',
                    'setting' => $setting ?? null,
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

    public function simpan_setting()
    {
        if((user()->role !== 'akademik')) {
            show_404();
        }
        $post = $this->input->post();
        // cek apakah nama setting sudah ada
        $post_name = array_keys($post);
        $cek = $this->db->where_in('nama', $post_name)->from('apps_setting')->get()->result_array();
        // konstruksi data menjadi array
        $data = [];
        foreach ($post as $i => $item) {
            $data[$i] = ['nama' => $i, 'isi' => $item];
        }

        if(empty($cek)){
            if(count($data) > 1) {
                $this->db->insert_batch('apps_setting', $data);
            } else {
                $this->db->insert('apps_setting', $data[$post_name[0]]);
            }
            set_alert('success', 'Setting berhasil disimpan.', $this->agent->referrer() ?? 'welcome');         
        } else {
            if(count($data) > 1){
                $this->db->update_batch('apps_setting', $data, 'nama');
            } else {
                $upd = $data[$post_name[0]];
                unset($upd['nama']);
                $this->db->update('apps_setting', $upd, ['nama' => $post_name[0]]);
            }
            set_alert('success', 'Setting berhasil diupdate.', $this->agent->referrer() ?? 'welcome');  
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
