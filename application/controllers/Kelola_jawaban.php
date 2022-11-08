<?php

defined('BASEPATH') or exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Kelola_jawaban extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (user()->role !== 'akademik') {
            redirect('welcome');
        }
        // batasi lanjut jika aplikasi belum disetting
        if ($this->db->count_all_results('apps_setting') < 6) {
            set_alert('warning', 'Lengkapi setting aplikasi dulu ya min... 😒', 'welcome');
        }
        // load config
        $this->load->config('apps_ujian');
    }

    public function index()
    {
        $data = [
            'page' => 'pages/akademik/kelola_jawaban_index',
        ];
        $this->load->view('template_apps', $data ?? null, false);
    }

    public function setting_email(string $mode = null)
    {
        if (!empty($mode) and $mode !== 'update') {
            set_alert('warning', 'Parameter setting email tidak valid!', 'kelola_jawaban/setting_email');
        }

        $this->form_validation->set_rules('smtp_host', 'SMTP Host', 'trim|required|valid_url|xss_clean');
        $this->form_validation->set_rules('smtp_email', 'Email', 'trim|required|valid_email|xss_clean');
        $this->form_validation->set_rules('smtp_password', 'Password', 'trim|required|xss_clean');
        $this->form_validation->set_rules('smtp_sec', 'SMTP Secure type', 'trim|required|in_list[smtp,tls]|xss_clean');
        if ($this->form_validation->run() == true) {
            $ins = [
                'smtp_host' => $this->input->post('smtp_host', true),
                'smtp_email' => $this->input->post('smtp_email', true),
                'smtp_password' => $this->input->post('smtp_password', true),
                'smtp_sec' => $this->input->post('smtp_sec', true),
            ];
            // setting ada ?
            $set = $this->db->get_where('apps_setting', ['nama' => 'email_setting'])->row();
            if (empty($set)) {
                $this->db->insert('apps_setting', ['nama' => 'email_setting', 'isi' => json_encode($ins)]);
                set_alert('success', 'Data seting email berhasil disimpan', 'kelola_jawaban/setting_email');
            } else {
                $this->db->update('apps_setting', ['isi' => json_encode($ins)], ['id' => $set->id]);
                set_alert('success', 'Data seting email berhasil diupdate', 'kelola_jawaban/setting_email');
            }
        } else {
            $data = [
                'mode' => $mode,
                'page' => 'pages/akademik/kelola_jawaban_setting_email',
                'email_setting' => $this->db->get_where('apps_setting', ['nama' => 'email_setting'])->row()
            ];
            $this->load->view('template_apps', $data ?? null, false);
        }
    }

    public function kirim_jawaban(string $var = null)
    {
        // filter kelas dan mode ujian

        // ambil data jawaban, matakuliah, email dosen, BA

        // tampilkan BA dan data jawaban yang akan dikirim.

        // jika BA tidak ada maka tampilkan form untuk buat BA, dan upload file BA

        // krim jawaban
        $this->form_validation->set_rules('mode', 'Mode Ujian', 'trim|required|in_list[reguler,nebeng]');
        $this->form_validation->set_rules('prodi', 'Program Studi', 'trim|required|xss_clean');
        $this->form_validation->set_rules('matkul', 'Mata Kuliah', 'trim|required|xss_clean');
        $this->form_validation->set_rules('kelas', 'Kelas', 'trim|required|alpha_dash|xss_clean');


        if ($this->form_validation->run() == true or false) {
            $mode = set_value('mode', true);
            // cari data dosen
            $where_dosen = [
                'program_studi' => set_value('prodi', true),
                'mata_kuliah' => set_value('matkul', true),
                'kelas' => set_value('kelas', true),
            ];
            $dosen = $this->db->get_where('mata_kuliah', $where_dosen)->row();
            // cari data riwayat upload
            $where_riw = [
                'program_studi' => underscore(str_replace('/', ' ', set_value('prodi', true))),
                'mata_kuliah' => underscore(set_value('matkul', true)),
                'kelas' => ($mode === 'reguler') ? set_value('kelas', true) : $mode
            ];

            $riw_upl = $this->db->get_where('riwayat_upload_jawaban', $where_riw)->result();

            $data = [
                'mode' => $mode,
                'program_studi' => set_value('prodi', true),
                'mata_kuliah' => set_value('matkul', true),
                'kelas' => ($mode === 'reguler') ? set_value('kelas', true) : $mode,
                'basedir' => WRITEPATH . 'jawaban' . DIRECTORY_SEPARATOR,
                'page' => 'pages/akademik/kelola_jawaban_kirim_jawaban',
                'dosen' => $dosen,
                'jawaban' => $riw_upl
            ];
            //tampilkan_json($data);
        } else {
            // ambil patokan data dari jadwal
            $jadwal = $this->db->get_where('jadwal_ujian', 'tanggal <= CURRENT_DATE()')->result_array();
            $this->db->select('program_studi, kelas');
            $this->db->from('mahasiswa');
            $this->db->group_by('program_studi, kelas');
            $matkul = $this->db->get()->result_array();

            function _group_by_mata_kuliah($array, $key)
            {
                $return = array();
                foreach ($array as $val) {
                    $return[$val[$key]][] = $val['mata_kuliah'];
                }
                return $return;
            }

            function _group_by_kelas($array, $key)
            {
                $return = array();
                foreach ($array as $val) {
                    $return[$val[$key]][] = $val['kelas'];
                }
                return $return;
            }

            $json_jadwal = _group_by_mata_kuliah($jadwal, 'program_studi');
            $json_matkul = _group_by_kelas($matkul, 'program_studi');
            //tampilkan_json($json_matkul);
            $data = [
                'jadwal' => json_encode($json_jadwal, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
                'matkul' => json_encode($json_matkul, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
                'prodi' => array_keys($json_jadwal),
                'page' => 'pages/akademik/kelola_jawaban_kirim_jawaban',
                //'email_setting' => $this->db->get_where('apps_setting', ['nama' => 'email_setting'])->row()
            ];
        }
        $this->load->view('template_apps', $data ?? null, false);
    }

    /**
     * Test kirim email function
     * adalah fungsi untuk mengecek apakah setting sudah benar jika $mode = test
     * @return void
     */
    public function kirim_email(string $mode = null)
    {
        // ambil setting
        $set = $this->db->get_where('apps_setting', ['nama' => 'email_setting'])->row();
        if (empty($set)) {
            set_alert('warning', 'Setting email belum diatur. Cek kembali data setting email!', $this->agent->referrer() ?? 'kelola_jawaban/setting_email');
        }
        // decode setting to array
        $smtp = (array) json_decode($set->isi);

        $mail = new PHPMailer(true);
        $mail->ClearAddresses();
        $mail->ClearAttachments();
        //Server settings ambil dari apps_setting
        $mail->isSMTP();
        $mail->Host       = $smtp['smtp_host'];
        $mail->SMTPAuth   = true;
        $mail->Username   = $smtp['smtp_email'];
        $mail->Password   = $smtp['smtp_password'];
        $mail->SMTPSecure = $smtp['smtp_sec'] === 'smtp' ? PHPMailer::ENCRYPTION_SMTPS : PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = $smtp['smtp_sec'] === 'smtp' ? 465 : 587;

        switch ($mode) {
            case 'test':
                $this->form_validation->set_rules('email_test', 'Email Tes', 'trim|required|valid_email|xss_clean');

                if ($this->form_validation->run() == true) {
                    $email_to = $this->input->post('email_test', true);
                    try {
                        //Recipients
                        $mail->setFrom($smtp['smtp_email'], 'Aplikasi Portal Ujian PKN STAN');
                        $mail->addAddress($email_to);

                        $mail->isHTML(true);
                        $mail->Subject = 'Email Uji Coba Portal Ujian PKN STAN';
                        $mail->Body    = $this->load->view('pages/akademik/kelola_jawaban_test_email', null, true);
                        $mail->AltBody = 'ini adalah email ujicoba untuk fitur kirim email. Abaikan jika Anda mendapat kiriman pesan ini. Terima kasih';
                        $mail->send();

                        set_alert('success', 'Yeeeyy.. Tes email berhasil dikirim. Cek pada inbox email tes.', $this->agent->referrer() ?: 'kelola_jawaban/setting_email');
                    } catch (Exception $e) {
                        //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                        set_alert('warning', 'Maaf, gagal kirim tes email. Cek pesan error berikut: <br/>' . $mail->ErrorInfo, $this->agent->referrer() ?: 'kelola_jawaban/setting_email');
                    }
                } else {
                    set_alert('warning', 'Data email tes tidak valid!', $this->agent->referrer() ?? 'kelola_jawaban/setting_email');
                }
                break;
            case 'dosen':
                // get files dan dosen
                $email_dosen = $this->input->post('email_dosen', true);
                $prodi = $this->input->post('prodi', true);
                $matkul = $this->input->post('matkul', true);
                $kelas = $this->input->post('kelas', true);
                $files = explode(',', $this->input->post('files', true));
                $base_dir_jawaban = WRITEPATH . 'jawaban' . DIRECTORY_SEPARATOR;
                $base_dir_kirim = WRITEPATH . 'kirim' . DIRECTORY_SEPARATOR;
                if (empty($this->input->post('files', true)) or !is_array($files) or count($files) < 1) {
                    set_alert('warning', 'Lembar jawaban yang akan dikirim kosong. Kirim email jawaban dibatalkan!', $this->agent->referrer());
                }
                // buatkan zip files jawaban
                /* $nama_zip = $base_dir_kirim . underscore($matkul) . '-' . underscore(str_replace('-', '_', $kelas)) . '-' . underscore(str_replace(['@', '.'], '_', $email_dosen) . '-' . time() . '.zip');
                $zip = new ZipArchive();
                if ($zip->open($nama_zip, ZipArchive::CREATE) === true) {
                    // Add files to the zip file
                    foreach ($files as $file) {
                        $file_ada = is_file(realpath($base_dir_jawaban . $file));
                        $options = array('add_path' => $kelas . DIRECTORY_SEPARATOR, 'remove_all_path' => true);
                        $file_ada and $zip->addGlob($base_dir_jawaban . $file, 0, $options);
                    }
                    $zip->close();
                } else {
                    // error
                    set_alert('danger', 'File zip kirim jawaban gagal dibuat! Ulangi kembali atau kontak administrator.', 'kelola_jawaban/kirim_jawaban');
                } */
                // kirim email ? cek sudah dikirim
                $dt = [
                    'program_studi' => $prodi,
                    'mata_kuliah' => $matkul,
                    'kelas' => $kelas,
                    'email_dosen' => $email_dosen,
                    //'file_zip' => substr($nama_zip, strlen($base_dir_kirim)),
                ];

                $sudah_kirim = $this->db->get_where('riwayat_kirim_jawaban', $dt)->row();
                if (!empty($sudah_kirim)) {
                    set_alert('info', 'File zip jawaban sudah dikirim ke email: ' . $email_dosen, 'kelola_jawaban/kirim_jawaban');
                } else {
                    // BA pengawas
                    $ba_pengawas = $this->db->get_where('riwayat_ba_pengawas', ['program_studi' => $prodi, 'mata_kuliah' => $matkul, 'kelas' => $kelas])->row();
                    $jadwal = $this->db->get_where('jadwal_ujian', ['program_studi' => $prodi, 'mata_kuliah' => $matkul])->row();
                    $soal = (!empty($jadwal)) ? $this->db->get_where('soal_ujian', ['id_jadwal' => $jadwal->id])->row() : false;
                    // data html
                    $dt_html = [
                        'prodi' => $prodi,
                        'matkul' => $matkul,
                        'kelas' => $kelas,
                        'jumlah_file' => count($files),
                        'ba_pengawas' => !empty($ba_pengawas) ? true : false,
                    ];
                    //Recipients
                    $mail->setFrom($smtp['smtp_email'], 'Aplikasi Portal Ujian PKN STAN');
                    $mail->addAddress($email_dosen);

                    $mail->isHTML(true);
                    $mail->Subject = 'Lembar Jawaban Ujian Akhir Semester (UAS) Genap Tahun Akademik 2021/2022';
                    // TODO: ambil body email dari data pengawas
                    $mail->Body    = $this->load->view('pages/akademik/kelola_jawaban_kirim_email_jawaban', $dt_html, true);
                    $mail->AltBody = 'Lembar jawaban ujian mata kuliah: ' . $matkul . ' program studi: ' . $prodi . ' kelas: ' . $kelas . ' UAS 2021/2022. Terima kasih';
                    // setting email dan ambil zip sebagai attachment
                    // $mail->addAttachment(realpath($nama_zip), underscore(str_replace('/', '-', $prodi)) . '_' . $kelas . '.zip');
                    if (!empty($ba_pengawas)) {
                        $ba_path = WRITEPATH . $ba_pengawas->file_path;
                        $ba_name = explode(DIRECTORY_SEPARATOR, $ba_pengawas->file_path);
                        $mail->addAttachment(realpath($ba_path), end($ba_name));
                    }

                    if (!empty($soal)) {
                        $soal_utama_path = WRITEPATH . 'masalah' . DIRECTORY_SEPARATOR . $soal->path_file;
                        $soal_att_path = (!empty($soal->attachment1_path)) ? WRITEPATH . 'masalah' . DIRECTORY_SEPARATOR . $soal->attachment1_path : false;
                        // tambah ke attachment
                        $mail->addAttachment(realpath($soal_utama_path), 'Soal_' . $soal->path_file);
                        if ($soal_att_path !== false) {
                            $mail->addAttachment(realpath($soal_att_path), 'Soal_tambahan_' . $soal->attachment1_path);
                        }
                    }
                    $mail->send();

                    // simpan ke riwayat kirim
                    //$dt['hash_zip'] = md5_file(realpath($nama_zip));
                    $dt['dikirim_oleh'] = user()->id;
                    $dt['dikirim_pada'] = date('Y-m-d H:i:s');

                    $this->db->insert('riwayat_kirim_jawaban', $dt);
                    set_alert('success', 'File jawaban dan berita acara pengawas berhasil dikirim ke email: ' . $email_dosen, 'kelola_jawaban/kirim_jawaban');
                }
                break;
            default:
                //$this->load->view('pages/akademik/kelola_jawaban_test_email', $data ?? null, false);
                set_alert('warning', 'Parameter data tidak valid!', $this->agent->referrer() ?: 'kelola_jawaban');
                break;
        }
    }

    /**
     * File jawaban function
     * untuk menghasilkan file zip untuk setiap data pata table mata_kuliah.
     * @return void
     */
    public function file_jawaban()
    {
        $this->load->model('Apps_model');

        $q = !empty($this->input->get('cari', true)) ? urldecode(xss_clean($this->input->get('cari', true))) : null;
        $start = is_numeric($this->input->get('mulai', true)) ? intval($this->input->get('mulai', true)) : 0;
        $per_page = is_numeric($this->input->get('per_page', true)) ? intval($this->input->get('per_page', true)) : 10;

        $config['base_url'] = current_url();
        $config['first_url'] = current_url();
        $config['per_page'] = $per_page;
        $config['page_query_string'] = true;
        $config['total_rows'] = $this->Apps_model->total_data('mata_kuliah', $q);
        $this->load->library('pagination');
        $this->pagination->initialize($config);
        $mydata = $this->Apps_model->data_limit('mata_kuliah', $config['per_page'], $start, $q)->result();

        $data = [
            'mata_kuliah' => !empty($mydata) ? $mydata : false,
            'q' => $q,
            'start' => $start,
            'halaman' => paginasi($config['total_rows'], $start, count($mydata), $this->pagination->create_links()),
            'page' => 'pages/akademik/file_jawaban'
        ];
        //tampilkan_json($data);

        $this->load->view('template_apps', $data, FALSE);
    }

    public function gen_jawaban(int $id = null, bool $exe = false)
    {
        $redirect_to = $this->input->get('ref', true);

        if (empty($id)) {
            set_alert('warning', 'ID data kosong. Data tidak ditemukan!', $this->agent->referrer());
        }
        $matkul = $this->db->get_where('mata_kuliah', ['id' => $id])->row();
        if (empty($matkul)) {
            set_alert('warning', 'Data mata kuliah tidak ditemukan!', $this->agent->referrer());
        }
        $where_jawaban = [
            'mata_kuliah' => underscore(str_replace(['/', '(', ')', '.'], '', $matkul->mata_kuliah)),
            'program_studi' => underscore(str_replace('/', '_', $matkul->program_studi)),
            'kelas' => underscore($matkul->kelas),
        ];
        // ambil jawaban
        $jawaban = $this->db->get_where('riwayat_upload_jawaban', $where_jawaban)->result();
        if (empty($jawaban)) {
            set_alert('warning', 'Data jawaban kosong. Ujian belum berlangsung atau file belum disinkronisasi.', $this->agent->referrer());
        }
        // ambil soal
        $where_jadwal = [
            'mata_kuliah' => str_replace(['/', '(', ')', '.'], '', $matkul->mata_kuliah),
            'program_studi' => $matkul->program_studi,
        ];
        $jadwal = $this->db->get_where('jadwal_ujian', $where_jadwal)->row();
        if (empty($jadwal)) {
            set_alert('warning', 'Data jadwal tidak valid. Cocokkan kembali data ujian data mata pelajaran.', $this->agent->referrer());
        }
        $soal = $this->db->get_where('soal_ujian', ['id_jadwal' => $jadwal->id])->row();

        // ambil BA
        $where = [
            'mata_kuliah' => str_replace(['/', '(', ')', '.'], '', $matkul->mata_kuliah),
            'program_studi' => str_replace(['/', '(', ')', '.'], '', $matkul->program_studi),
            'kelas' => $matkul->kelas,
        ];
        $ba = $this->db->get_where('riwayat_ba_pengawas', $where)->row();

        // zipkan
        if ($exe !== false) {
            $this->load->helper('string');
            $sesi = $jadwal->sesi;
            $folder = underscore(str_replace(['/', '(', ')', '.'], '', $jadwal->mata_kuliah));

            $base_dir = WRITEPATH . 'zip_to_dosen' . DIRECTORY_SEPARATOR . $sesi . DIRECTORY_SEPARATOR;
            if (!is_dir(realpath($base_dir))) {
                mkdir($base_dir, 0775, true);
            }

            $nama_zip = $base_dir . random_string('alnum', 16) . '.zip';
            $zip_mode = (is_file($nama_zip) and file_exists($nama_zip)) ? ZipArchive::OVERWRITE : ZipArchive::CREATE;

            // buat zip dan download
            $zip = new ZipArchive();
            if ($zip->open($nama_zip, $zip_mode) === true) {
                // soal
                $file_soal = !empty($soal) ? $soal->path_file : false;
                if (!empty($file_soal)) {
                    $file = WRITEPATH . 'masalah' . DIRECTORY_SEPARATOR . $file_soal;
                    $file_ada = is_file(realpath($file));
                    $options = array('add_path' => $folder . DIRECTORY_SEPARATOR, 'remove_all_path' => true);
                    $file_ada and $zip->addGlob($file, 0, $options);
                }
                // BA
                $file_ba = !empty($ba) ? $ba->file_path : false;
                if (!empty($file_ba)) {
                    $file = WRITEPATH . $file_ba;
                    $file_ada = is_file(realpath($file));
                    $options = array('add_path' => $folder . DIRECTORY_SEPARATOR, 'remove_all_path' => true);
                    $file_ada and $zip->addGlob($file, 0, $options);
                }
                // jawaban
                if (!empty($jawaban)) {
                    foreach ($jawaban as $item) {
                        $file = WRITEPATH . 'jawaban' . DIRECTORY_SEPARATOR . $item->file_path;
                        $file_ada = is_file(realpath($file));
                        $options = array('add_path' => $folder . DIRECTORY_SEPARATOR, 'remove_all_path' => true);
                        $file_ada and $zip->addGlob($file, 0, $options);
                    }
                }
                // Add files to the zip file
                $zip->close();
                // update ke path mata kuliah
                $upd = ['file_jawaban' => str_replace(WRITEPATH, '', $nama_zip)];
                $this->db->update('mata_kuliah', $upd, ['id' => $id]);
                // kasih notif
                set_alert('success', 'File zip berhasil digenerate dengan nama file: <strong>' . str_replace(WRITEPATH, '', $nama_zip) . '</strong>.', $redirect_to ?? 'kelola_jawaban/file_jawaban');
            } else {
                // error
                set_alert('danger', 'File zip kirim jawaban gagal dibuat! Ulangi kembali atau kontak administrator.', $this->agent->referrer());
            }
            // update DB mata_
        } else {
            $data = [
                'matkul' => $matkul,
                'jawaban' => $jawaban,
                'jadwal' => $jadwal,
                'soal' => $soal,
                'ba' => $ba,
                'id' => $id,
                'ref' => $this->agent->referrer(),
                'page' => 'pages/akademik/gen_jawaban'
            ];
            //tampilkan_json($data);
            $this->load->view('template_apps', $data, FALSE);
        }
    }
}

/* End of file Kelola_jawaban.php */
