<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Mahasiswa extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Ujian_model');
        $this->load->helper('ujian_helper');
        
    }

    public function index()
    {
        $this->jadwal();
    }

    public function jadwal(int $id_jadwal = null)
    {
        # mahasiswa, ambil data jadwal sesuai krs siswa
        $sesi = ($this->config->item('sesi_ditampilkan') == '1') ? user()->sesi : null;
        $jadwal_by_krs = $this->Ujian_model->jadwal_by_krs(user()->nim, user()->program_studi, $sesi);

        // buat ngecek apakah mahasiswa sudah mengambil ujian atau belum
        if (!$this->session->has_userdata('jadwal_dipilih')) {
            $jadwal = $jadwal_by_krs;
        } else {
            $jadwal_dipilih = $this->session->userdata('jadwal_dipilih');
            $id_jadwal = $this->session->userdata('id_jadwal');
            // mode ujian , harusnya sudah ga perlu
            $mode = $this->session->userdata('mode');
            $jadwal = $this->db->get_where('jadwal_ujian', ['id' => $id_jadwal])->row();
        }
        // cek file upload jawaban jika sudah
        if (empty($id_jadwal)) {
            $jawaban = !empty($jadwal) ? $this->db->get_where('riwayat_upload_jawaban', ['id_jadwal' => $jadwal->id, 'nim' => user()->nim])->row() : null;
        } else {
            $jawaban = $this->db->get_where('riwayat_upload_jawaban', ['id_jadwal' => $id_jadwal, 'nim' => user()->nim])->row();
        }
        // jika jawaban tidak kosong dan sudah dikunci maka logoukan
        if (!empty($jawaban) and $jawaban->kunci_jawaban == 1) {
            $this->authit->logout('auth/mahasiswa');
        }

        $data = [            
            'mode' => !empty($mode) ? $mode : 'reguler',
            'jadwal_dipilih' => !empty($jadwal_dipilih) ? $jadwal_dipilih : false,
            'sisa_sesi' => $this->session->userdata('sesi_soal') ?: 0,
            'durasi_ujian' => $this->session->userdata('durasi_ujian') ?: 0,
            'jadwal' => $jadwal,
            'jawaban' => $jawaban,
            'page' => 'pages/mahasiswa/welcome',
        ];
        //tampilkan_json($this->Ujian_model->krs_mahasiswa(user()->nim));
        $this->load->view('template_apps', $data ?? null, false);
    }

    /**
     * Ikut ujian function
     * adalah mothod untuk join ujian, baik reguler atau nebeng
     * PENTING!!! ketika ikut ujian, simpan variable sesi soal, id jadwal dll ke sesi user agar konsisten 1 ujian.
     * sesuaikan ya bro 🤣;
     * @param string $mode
     * @return void
     */
    public function ikut_ujian(string $mode = 'reguler', int $id = null)
    {
        // mode dan id harus diisi
        $avail_mode = ['reguler', 'nebeng'];
        if (!in_array($mode, $avail_mode) or empty($id)) {
            set_alert('warning', 'Parameter data tidak cocok!', 'mahasiswa');
        }
        // ambil jadwal
        $jadwal = $this->db->get_where('jadwal_ujian', ['id' => $id])->row();
        // batasi akses sesuai tanggal dan jam
        $izinkan = izinkan_ujian($jadwal);
        // alihkan jika false
        if ($izinkan['izinkan'] === false) {
            set_alert('danger', 'Ujian hanya dapat diakses pada waktunya!', 'mahasiswa');
        }
        // ambil soal
        $soal = $this->db->get_where('soal_ujian', ['id_jadwal' => $id])->row();

        if (!empty($soal)) {            
            // encript soal path
            $filename = (string) $soal->path_file;
            $soal_name = urlencode(base64_encode(samarkan($filename)));
            $soal_utama = site_url('mahasiswa/file/pdf/' . $jadwal->id . '?file=' . $soal_name . '&tipe=masalah#toolbar=0');
            // kunci jadwal dipilih
            $jadwal_dipilih = ['jadwal_dipilih' => true, 'mode' => $mode, 'id_jadwal' => $jadwal->id];
            // simpan pada session
            if (!$this->session->has_userdata('jadwal_dipilih')) {
                $this->session->set_userdata($jadwal_dipilih);
            }

            // seting durasi ujian ke sesi agar dapat diambil dari halaman lain
            $durasi_ujian = $izinkan['durasi_ujian'];
            $this->session->set_userdata('durasi_ujian', $durasi_ujian);
            // sesi soal = sesi max
            $sisa_sesi = $izinkan['sisa_sesi'];
            if (empty($this->session->userdata('sesi_soal'))) {
                $this->session->set_userdata('sesi_soal', $sisa_sesi);
            } else {
                // update sesi
                $this->session->unset_userdata('sesi_soal');
                $this->session->set_userdata('sesi_soal', $sisa_sesi);
            }
        } else {
            set_alert('warning', 'Soal ujian belum diupload. Hubungi petugas!', 'mahasiswa');
        }

        $data = [
            'page' => 'pages/mahasiswa/ikut_ujian',
            'soal_utama' => $soal_utama,
            'soal' => $soal,
            'mode' => $mode,
            'sisa_sesi' => $this->session->userdata('sesi_soal'),
            'durasi_ujian' => $izinkan['durasi_ujian'],
            'jadwal' => $jadwal
        ];

        $this->load->view('template_apps', $data ?? null, false);
    }

    /* public function nebeng_ujian()
    {
        // ambil seluruh prodi dan matkul
        $this->db->where('tanggal', date('Y-m-d'));
        $pilihan = $this->db->get('jadwal_ujian')->result_array();

        function aksi(int $id_jadwal = null)
        {
            $str = '<a href="' . site_url('mahasiswa/ikut_ujian/nebeng/' . $id_jadwal) . '" class="btn btn-outline-info">Pilih nebeng ujian ini 😁</a>';
            return $str;
        }
        $new_pil = [];
        foreach ($pilihan as $pil => $dt) {
            $aksi = ['pilih_ujian' => aksi($dt['id'])];
            $new_pil[$pil] = array_merge($dt, $aksi);
        }

        if(!empty($new_pil)) { 
            tampilkan_json($new_pil);
        } else {
            show_404();
        }
    } */

    /**
     * File Soal Ujian function
     * Menampilkan soal, attachmen dan file jawaban mahasiswa. dijadikan satu biar tidak duplikasi fungsi
     * @return void
     */
    public function file(string $mime = null, int $id_jadwal = null)
    {
        $file = $this->input->get('file', true);
        $jenis_file = $this->input->get('tipe', true);
        $jadwal = $this->db->get_where('jadwal_ujian', ['id' => $id_jadwal])->row();
        $akses = izinkan_ujian($jadwal);
        $izinkan = $akses['izinkan'];

        if (empty($file) or empty($id_jadwal) or !in_array($jenis_file, ['masalah', 'jawaban']) or !$izinkan) {
            return $this->load->view('template_apps', ['page' => 'pages/404'], false);
        }
        // basedir
        $dir = WRITEPATH . $jenis_file . DIRECTORY_SEPARATOR;
        // decode
        $filename = samarkan(base64_decode(urldecode($file)), true);

        if ($jenis_file == 'jawaban') {
            $type_file = get_mime_by_extension($dir . $filename);
        } else {
            $filename = $this->security->sanitize_filename($filename);
            $type_file = get_mime_by_extension($filename);
        }

        $this->load->helper('download');

        $mimes = ['video/mp4', 'video/mpeg', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/zip', 'application/x-zip', 'application/pdf'];

        switch ($mime) {
            case 'video':
                if (in_array($type_file, $mimes) and file_exists($dir . $filename) and $izinkan) {
                    include_once APPPATH . "libraries/VideoStream.php";
                    $stream = new VideoStream($dir . $filename);
                    $stream->start();
                    exit;
                } else {
                    set_alert('warning', 'File video tidak ditemukan', $this->agent->referrer());
                }
                break;
            case 'excel':
                if (in_array($type_file, $mimes) and file_exists($dir . $filename) and $izinkan) {
                    force_download($dir . $filename, null);
                } else {
                    set_alert('warning', 'File excel tidak ditemukan', $this->agent->referrer());
                }
                break;
            case 'zip':
                if (in_array($type_file, $mimes) and file_exists($dir . $filename) and $izinkan) {
                    force_download($dir . $filename, null);
                } else {
                    set_alert('warning', 'File zip tidak ditemukan', $this->agent->referrer());
                }
                break;
            case 'powerpoint':
                if (in_array($type_file, $mimes) and file_exists($dir . $filename) and $izinkan) {
                    force_download($dir . $filename, null);
                } else {
                    set_alert('warning', 'File power point tidak ditemukan', $this->agent->referrer());
                }
                break;
            default:
                if (in_array($type_file, $mimes) and file_exists($dir . $filename) and $izinkan) {
                    header('Content-type: application/pdf');
                    header('Content-Disposition: inline; filename="' . $filename . '"');
                    header('Content-Transfer-Encoding: binary');
                    header('Accept-Ranges: bytes');
                    @readfile($dir . $filename);
                } else {
                    show_404();
                }
                break;
        }
    }

    public function upload_jawaban(string $mode = 'reguler')
    {
        $avail_mode = ['reguler', 'nebeng'];
        if (!in_array($mode, $avail_mode)) {
            set_alert('warning', 'Parameter data tidak cocok!', 'mahasiswa');
        }
        $this->load->helper('string');

        $this->form_validation->set_rules('nim', 'Nomor Induk Mahasiswa', 'trim|required|is_natural_no_zero|xss_clean');
        $this->form_validation->set_rules('kelas', 'Kelas', 'trim|required|alpha_dash|xss_clean');
        $this->form_validation->set_rules('mata_kuliah', 'Mata Kuliah', 'trim|required|alpha_dash|xss_clean');
        $this->form_validation->set_rules('program_studi', 'Program Studi', 'trim|required|xss_clean');

        $kelas = nama_file_folder($this->input->post('kelas', true));
        $mat_kul = nama_file_folder($this->input->post('mata_kuliah', true));
        $prodi = nama_file_folder($this->input->post('program_studi', true));
        $nim = $this->input->post('nim', true);
        $id_jadwal = $this->input->post('id_jadwal', true);

        // base upload directory
        $base_upl_dir = WRITEPATH . 'jawaban' . DIRECTORY_SEPARATOR;

        if ($this->form_validation->run() == true) {
            // dir program_studi/mata_kuliah/kelas/id
            $dir_reguler = $base_upl_dir . $prodi . DIRECTORY_SEPARATOR . $mat_kul . DIRECTORY_SEPARATOR . $kelas . DIRECTORY_SEPARATOR;
            // dir nebeng/program_studi/mata_kuliah/id
            $dir_nebeng = $base_upl_dir . DIRECTORY_SEPARATOR . 'nebeng' . DIRECTORY_SEPARATOR . $prodi . DIRECTORY_SEPARATOR . $mat_kul . DIRECTORY_SEPARATOR;

            if ($mode == 'nebeng') {
                $dir_jawaban = $dir_nebeng;
            } else {
                $dir_jawaban = $dir_reguler;
            }
            if (is_dir($dir_jawaban)) {
                $upl_dir_jawab = $dir_jawaban;
            } else {
                // mkdir
                mkdir($dir_jawaban, 0777, true);
                $upl_dir_jawab = $dir_jawaban;
            }
        } else {
            $error = validation_errors('<span class="text-danger">', '</span>');
            set_alert('warning', 'Data upload jawaban gagal diupload. Cek kesalahan berikut:<br>', 'mahasiswa');
        }

        $config = [
            'upload_path' => $upl_dir_jawab,
            'allowed_types' => 'pdf|zip',
            'max_size' => 10240,
            'overwrite' => true,
            'file_ext_tolower' => true,
            'encrypt_name' => false,
            'file_name' => $nim . '_' . underscore(str_replace(['.', '-'], '', strip_quotes(user()->nama_lengkap)))
        ];

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('jawaban')) {
            $error = $this->upload->display_errors('<span class="text-danger">', '</span>');
            set_alert('danger', 'File gagal diupload. Periksa catatan error berikut: <br/>' . $error, 'mahasiswa');
        } else {
            $data = $this->upload->data();
            $file = $data['full_path'];

            if (isset($file) and !empty($file)) {
                // cek sudah pernah upload apa belum
                $row_riwayat = $this->db->get_where('riwayat_upload_jawaban', ['id_jadwal' => $id_jadwal, 'nim' => $nim])->row();

                if (empty($row_riwayat)) {
                    // insert data
                    $ins = [
                        'id_jadwal' => $id_jadwal,
                        'nim' => user()->nim,
                        'kelas' => ($mode == 'nebeng') ? $mode : $kelas,
                        'mata_kuliah' => $mat_kul,
                        'program_studi' => $prodi,
                        'file_path' => substr($file, strlen($base_upl_dir)),
                        'hash_file' => md5_file($file),
                        'diupload_pada' => date('Y-m-d H:i:s'),
                        'ip_address' => $this->input->ip_address(),
                    ];

                    $this->db->insert('riwayat_upload_jawaban', $ins);
                    set_alert('success', 'File berhasil diupload dan data soal berhasil disimpan ke database.', 'mahasiswa/jadwal/' . $id_jadwal);
                } else {
                    // update riwayat
                    $upd = [
                        'id_jadwal' => $id_jadwal,
                        'nim' => user()->nim,
                        'kelas' => ($mode == 'nebeng') ? $mode : $kelas,
                        'mata_kuliah' => $mat_kul,
                        'program_studi' => $prodi,
                        'file_path' => substr($file, strlen($base_upl_dir)),
                        'hash_file' => md5_file($file),
                        'diupload_pada' => date('Y-m-d H:i:s'),
                        'ip_address' => $this->input->ip_address(),
                    ];
                    $this->db->update('riwayat_upload_jawaban', $upd, ['id' => $row_riwayat->id]);
                    // hapus file terupload jika mime extnya berbeda.
                    if (get_mime_by_extension($file) != get_mime_by_extension($base_upl_dir . $row_riwayat->file_path)) {
                        is_file($base_upl_dir . $row_riwayat->file_path) and unlink($base_upl_dir . $row_riwayat->file_path);
                    }
                    set_alert('success', 'File berhasil diupload dan data soal berhasil diupdate ke database.', 'mahasiswa/jadwal/' . $id_jadwal);
                }
            } else {
                unlink($file);
                set_alert('danger', 'Awas!! <br>File berhasil diupload namun data soal gagal disimpan ke database.', 'mahasiswa');
            }
        }
    }

    public function kuisioner()
    {
        $this->form_validation->set_rules('nim', 'NIM', 'trim|required|is_natural_no_zero|xss_clean');
        $this->form_validation->set_rules('program_studi', 'Program Studi', 'trim|required|alpha_numeric_spaces|xss_clean');
        $this->form_validation->set_rules('angkatan', 'Agkatan', 'trim|required|is_natural_no_zero|xss_clean');
        $this->form_validation->set_rules('gender', 'Jenis Kelamin', 'trim|required|in_list[pria,wanita]|xss_clean');
        $this->form_validation->set_rules('formasi', 'Formasi', 'trim|required|in_list[reguler,alih_program]|xss_clean');
        $this->form_validation->set_rules('isian_1', 'Isian 1', 'trim|required|is_natural|xss_clean');
        $this->form_validation->set_rules('isian_2', 'Isian 2', 'trim|required|is_natural|xss_clean');
        $this->form_validation->set_rules('isian_3', 'Isian 3', 'trim|required|is_natural|xss_clean');
        $this->form_validation->set_rules('isian_4', 'Isian 4', 'trim|required|is_natural|xss_clean');
        $this->form_validation->set_rules('isian_5', 'Isian 5', 'trim|required|is_natural|xss_clean');
        $this->form_validation->set_rules('isian_6', 'Isian 6', 'trim|required|is_natural|xss_clean');
        $this->form_validation->set_rules('isian_7', 'Isian 7', 'trim|required|is_natural|xss_clean');
        $this->form_validation->set_rules('isian_8', 'Isian 8', 'trim|required|is_natural|xss_clean');
        $this->form_validation->set_rules('isian_9', 'Isian 9', 'trim|required|is_natural|xss_clean');
        $this->form_validation->set_rules('isian_10', 'Isian 10', 'trim|required|is_natural|xss_clean');
        $this->form_validation->set_rules('masukan_1', 'Masukan 1', 'trim|required|min_length[20]|xss_clean');
        $this->form_validation->set_rules('masukan_2', 'Masukan 2', 'trim|required|min_length[20]|xss_clean');
        $this->form_validation->set_rules('masukan_3', 'Masukan 3', 'trim|required|min_length[20]|xss_clean');
        $this->form_validation->set_rules('masukan_4', 'Masukan 4', 'trim|required|min_length[20]|xss_clean');

        if ($this->form_validation->run() == TRUE) {
            # simpan
            $dt_post = (array) $this->input->post();
            $dt = array_merge($dt_post, ['dibuat_pada' => date('Y-m-d H:i:s')]);
            $this->db->insert('kuisioner', $dt);
            # logout
            redirect('auth/logout');
        }

        $data = [
            'page' => 'pages/mahasiswa/kuisioner'
        ];

        $this->load->view('template_apps', $data, FALSE);
    }

    public function kunci_jawaban(int $id_riwayat_jawaban = null)
    {
        if (empty($id_riwayat_jawaban) or !is_numeric($id_riwayat_jawaban)) {
            set_alert('warning', 'Parameter data tidak cocok!', 'mahasiswa');
        }
        $this->db->update('riwayat_upload_jawaban', ['kunci_jawaban' => 1], ['id' => $id_riwayat_jawaban]);
        // ambil kuisioner jika belum
        /* $kuisi = $this->db->get_where('kuisioner', ['nim' => user()->nim])->row();
        if (empty($kuisi)) {
            set_alert('info', 'Jawaban berhasil dikunci dan kami mohon bantuan isi kuisioner ya. pliiisss.. 😊', 'mahasiswa/kuisioner');
        } */
        $this->authit->logout('auth/mahasiswa');
    }
}

/* End of file Mahasiswa.php */
