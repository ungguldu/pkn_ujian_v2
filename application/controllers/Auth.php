<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library(['authit', 'apps_config']);
        $this->load->helper(['authit', 'inflector', 'ujian_helper']);

        // inisiasi config
        $this->apps_config->apps_config();
        // form validasi
        $this->form_validation->set_error_delimiters('<div class="invalid-feedback">', '</div>');
        $this->form_validation->set_message('min_length', '{field} minimal {param} karakter.');
        $this->form_validation->set_message('required', '{field} harus diisi!');
        $this->form_validation->set_message('alpha_numeric_spaces', '{field} hanya karakter huruf, angka dan spasi!');
        $this->form_validation->set_message('alpha_dash', '{field} hanya karakter huruf dan dash!');
        $this->form_validation->set_message('numeric', '{field} harus karakter angka!');
        $this->form_validation->set_message('is_natural_no_zero', 'Isi {field} pada pilihan tersedia!');
        $this->form_validation->set_message('regex_match', 'Karakter yang anda masukkan bukan text bebas! Gunakan tanda baca baku.');
        $this->form_validation->set_message('valid_email', 'Format email tidak valid!');
        $this->form_validation->set_message('xss_clean', 'stop! kode berbahaya.');
    }

    public function index()
    {
        if (logged_in()) {
            redirect('welcome');
        }
        $this->load->view('template_auth', $data ?? null, false);
    }

    public function mahasiswa()
    {
        if (logged_in()) {
            redirect('welcome');
        }

        $this->form_validation->set_rules('nim', 'NIM Mahasiswa', 'trim|required|alpha_numeric|callback_nim_check|xss_clean');
        $this->form_validation->set_rules('pass_key', 'Kode Keamanan', 'trim|required|numeric|max_length[8]|xss_clean');
        if($this->config->item('sesi_ditampilkan') == 1) $this->form_validation->set_rules('sesi', 'Kode Keamanan', 'trim|required|is_natural_no_zero|xss_clean');

        if ($this->form_validation->run() == true) {
            $where = [
                'nim' => $this->input->post('nim', true),
                'tanggal_lahir' => date('Y-m-d', strtotime($this->input->post('pass_key', true)))
            ];
            $mhs = $this->db->get_where('mahasiswa', $where)->row();
            
            if (!empty($mhs)) {
                // konstruksi data sesi mhs
                $mhs->role = 'mahasiswa';
                // cek konfig sesi
                if($this->config->item('sesi_ditampilkan') == 1) { 
                    $mhs->sesi = $this->input->post('sesi', true);
                };
                // meloginkan
                if ($this->authit->login('mahasiswa', $mhs)) {
                    set_alert('success', 'Selamat Datang ' . $mhs->nama_lengkap . ' di portal ujian.', 'mahasiswa');
                } else {
                    set_alert('warning', 'Terjadi kesalahan login peserta. Cek data Anda kembali.', 'auth/mahasiswa');
                }
            }
            set_alert('danger', 'Kombinasi NIM dan kode keamanan tidak cocok!', 'auth/mahasiswa');
        }

        $data = ['page' => 'pages/auth/mahasiswa'];
        $this->load->view('template_auth', $data ?? null, false);
    }

    public function admin()
    {
        if (logged_in()) {
            redirect('welcome');
        }

        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');

        if ($this->form_validation->run() == true) {
            $where = ['email' => $this->input->post('email', true)];
            $user = $this->db->get_where('users', $where)->row();

            if (!empty($user) and $user->aktif == 0) {
                set_alert('warning', 'Akun Anda belum diotorisasi!', 'auth/admin');
            }

            if (!empty($user) and $this->authit->verify_password($this->input->post('password', true), $user->password)) {
                // loginkan
                if ($this->authit->login('akademik', $user)) {
                    $str = !empty($user->nama_lengkap) ? $user->nama_lengkap : $user->email;
                    set_alert('success', 'Selamat Datang <strong>' . $str . '</strong>', 'welcome');
                } else {
                    set_alert('warning', 'Terjadi kesalahan login. Cek data Anda kembali.', 'auth/admin');
                }
            }
            set_alert('danger', 'Kombinasi email dan/atau password tidak cocok!', 'auth/admin');
        }

        $data = ['page' => 'pages/auth/admin'];
        $this->load->view('template_auth', $data ?? null, false);
    }

    public function pengawas()
    {
        if (logged_in()) {
            redirect('welcome');
        }

        $this->form_validation->set_rules('kode_pengawas', 'Kode Pengawas', 'trim|required|numeric|xss_clean');
        $this->form_validation->set_rules('pass_key', 'Kode Keamanan', 'trim|required|numeric|xss_clean');

        if ($this->form_validation->run() == true) {
            $where = [
                'kode_pengawas' => $this->input->post('kode_pengawas', true),
                'nik' => $this->input->post('pass_key', true),
                'status' => 1
            ];

            $user = $this->db->get_where('pengawas', $where)->row();

            if (!empty($user) and $user->status == 0) {
                set_alert('warning', 'Akun Anda belum diotorisasi!', 'auth/pengawas');
            }
            // cek jadwal
            $jadwal = $this->db->get_where('jadwal_ujian', ['id' => $user->id_jadwal])->row();
            $akses = izinkan_ujian($jadwal, -15); // reques mas fahrizal

            // batasi login
            if ($akses['izinkan'] == false) {
                set_alert('warning', 'Ujian telah berakhir. Anda tidak diizinkan login!', 'auth/pengawas');
            }
            // loginkan user
            if (!empty($user) and $user->kode_pengawas == $this->input->post('kode_pengawas', true)) {
                // loginkan
                $user->role = 'pengawas';
                if ($this->authit->login('pengawas', $user)) {
                    $str = !empty($user->nama_lengkap) ? $user->nama_lengkap : $user->kode_pengawas;
                    set_alert('success', 'Selamat Datang <strong>' . $str . '</strong>', 'pengawas');
                } else {
                    set_alert('warning', 'Terjadi kesalahan login. Cek data Anda kembali.', 'auth/pengawas');
                }
            }
            set_alert('danger', 'Kombinasi email dan/atau password tidak cocok!', 'auth/pengawas');
        }

        $data = ['page' => 'pages/auth/pengawas'];
        $this->load->view('template_auth', $data ?? null, false);
    }

    public function error($code = 404)
    {
        // set header error code
        $this->output->set_status_header($code);
        // set view
        if (logged_in()) {
            return $this->load->view('template_apps', ['page' => 'pages/404'], false);
        } else {
            return $this->load->view('template_auth', ['page' => 'pages/404'], false);
        }
    }

    public function nim_check($nim)
    {
        $temu = $this->db->get_where('mahasiswa', ['nim' => $nim])->num_rows();
        if ($temu === 1) {
            return true;
        } else {
            $this->form_validation->set_message('nim_check', '{field} tidak ditemukan!');
            return false;
        }
    }

    public function logout()
    {
        // load library
        $this->authit->logout(base_url());
    }
}

/* End of file Auth.php */
