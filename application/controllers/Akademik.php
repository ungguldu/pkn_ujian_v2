<?php

defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class Akademik extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        // batasi user role
        if (user()->role !== 'akademik') {
            show_404();
        }
        // batasi lanjut jika aplikasi belum disetting
        if($this->db->count_all_results('apps_setting') < 6) {
            set_alert('warning', 'Lengkapi setting aplikasi dulu ya min... 😒', 'welcome');
        }
    }

    /**
     * Index function
     * Berisi tampilan form untuk upload dan delete file data.
     * @return void
     */
    public function index()
    {
        $dir = $this->config->item('dir_data');
        $myfiles = substr_replace(glob($dir . '*.xls*'), '', 0, strlen($dir));
        unset($myfiles[0]);

        $data = [
            'files' => $myfiles,
            'krs_mahasiswa' => $this->db->count_all_results('krs_mahasiswa'),
            'jadwal_ujian' => $this->db->count_all_results('jadwal_ujian'),
            'mata_kuliah' => $this->db->count_all_results('mata_kuliah'),
            'mahasiswa' => $this->db->count_all_results('mahasiswa'),
            'pengawas' => $this->db->count_all_results('pengawas'),
            'page' => 'pages/akademik/index',
        ];
        $this->load->view('template_apps', $data, false);
    }

    /**
     * Upload function
     * adalah fungsi upload data yang dibutuhkan oleh aplikasi.
     * @param string $data
     * @return void
     */
    public function upload()
    {
        $kategori_data = $this->input->post('kategori_data');
        switch ($kategori_data) {
            case 'mahasiswa':
                $file_name = time() . '_data_' . $kategori_data;
                $table_name = 'mahasiswa';
                break;
            case 'matkul':
                $file_name = time() . '_data_' . $kategori_data;
                $table_name = 'mata_kuliah';
                break;
            case 'jadwal':
                $file_name = time() . '_data_' . $kategori_data;
                $table_name = 'jadwal_ujian';
                break;
            case 'pengawas':
                $file_name = time() . '_data_' . $kategori_data;
                $table_name = 'pengawas';
                $this->db->query('UPDATE pengawas SET status = 0;');
                break;
            case 'krs_mahasiswa':
                $file_name = time() . '_data_' . $kategori_data;
                $table_name = 'krs_mahasiswa';
                break;
            default:
                set_alert('warning', 'Parameter data tidak ditemukan. Gunakan form tersedia!', 'akademik');
                break;
        }
        $config = [
            'upload_path' => WRITEPATH . 'data/',
            'allowed_types' => 'xls|xlsx',
            'max_size' => 4096,
            'overwrite' => true,
            'file_ext_tolower' => true,
            'file_name' => $file_name
        ];

        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('upload_' . $kategori_data)) {
            $error = $this->upload->display_errors('<span class="text-danger">', '</span>');
            set_alert('danger', 'File gagal diupload. Periksa catatan error berikut: <br/>' . $error, 'akademik');
        } else {
            $data = $this->upload->data();
            $file = $data['full_path'];
            $ext = $data['file_ext'];

            if (isset($file) and !empty($file)) {
                if ('csv' == $ext) {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
                } else {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                }
                $spreadsheet = $reader->load($file);
                $sheetData = $spreadsheet->getActiveSheet()->toArray();
                $key = array_shift($sheetData);
                $newkey = array_values(array_filter($key));

                $ins = [];
                $empty_data = [];
                foreach ($sheetData as $i => $v) {
                    // samakan panjang array header dan data row
                    if (!empty($v) and count($newkey) == count(array_filter($v))) {
                        $ins[$i] = array_combine($newkey, array_values(array_filter($v)));
                    } else {
                        $empty_data[$i] = 'data baris ke ' . $i . ' kosong';
                    }
                }
                
                // spesial buat data mahasiswa yang ada single quote nya
                if (!empty($ins)) {
                    $ins_new = array_walk_recursive($ins, function (&$value) {
                        $value = htmlspecialchars(trim($value));
                    });
                    
                    $this->db->insert_batch($table_name, $ins, true, 500);
                }
                //$this->db->insert_batch($table_name, $ins, true, 100);
                set_alert('success', 'File berhasil diupload dan data '.$kategori_data.' berhasil diimpor ke dalam database. Data kosong sebanyak '. count($empty_data). ' data.', $this->agent->referrer() ?? 'akademik');
            } else {
                unlink($file);
                set_alert('danger', 'File berhasil diupload namun data ' . $kategori_data . ' gagal diimpor ke dalam database.', $this->agent->referrer() ?? 'akademik');
            }
        }
    }

    /**
     * Hapus File function
     * adalah fungsi hapus file yang telah diupload. Pada kontroler ini khususnya file data yang diupload.
     * @return void
     */
    public function hapus_file(string $type = 'data')
    {
        $url = ($type != 'soal') ? 'akademik' : $this->agent->referrer();
        if (!in_array($type, ['soal', 'data'])) {
            set_alert('warning', 'Parameter file tidak ditemukan!', $url);
        }

        $file = $this->input->get('file', true);

        $this->load->helper('file');
        $filename = $this->security->sanitize_filename($file);
        $type_file = get_mime_by_extension($file);
        //mimes excel
        $mimes = array('application/vnd.ms-excel', 'application/msexcel', 'application/x-msexcel', 'application/x-ms-excel', 'application/x-excel', 'application/x-dos_ms_excel', 'application/xls', 'application/x-xls', 'application/excel', 'application/download', 'application/vnd.ms-office', 'application/msword', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/zip', 'application/vnd.ms-excel', 'application/msword', 'application/x-zip', 'application/pdf');

        if (in_array($type_file, $mimes)) {
            if ($type == 'soal') {
                $dir = WRITEPATH . 'masalah' . DIRECTORY_SEPARATOR;
                // setelah ada attachment
                $soal = $this->db->get_where('soal_ujian', ['path_file' => $file])->row();
                // unlink file di attachment
                if ($soal) {
                    !empty($soal->attachment1_path) and is_file($dir . $soal->attachment1_path) and unlink($dir . $soal->attachment1_path);
                    !empty($soal->attachment2_path) and is_file($dir . $soal->attachment2_path) and unlink($dir . $soal->attachment2_path);
                    $this->db->delete('soal_ujian', ['id' => $soal->id]);
                }
                $this->db->delete('soal_ujian', ['path_file' => $file]);
            } else {
                $dir = WRITEPATH . 'data' . DIRECTORY_SEPARATOR;
            }
            $path = $dir . $filename;
        } else {
            set_alert('warning', 'File data : ' . $file . ' tidak cocok!', $url);
        }

        if (unlink($path)) :
            set_alert('info', 'File data: ' . $file . ' berhasil dihapus.', $url);
        else :
            set_alert('warning', 'File data: ' . $file . ' gagal dihapus. Coba ulangi kembali.', $url);
        endif;
    }

    /**
     * Update data function
     * untuk keperluan update data
     * @author Faris Zain - farisz@pknstan.ac.id
     * @since 2022-11-08 11:11:18
     * 
     * @param  string|null $tabel
     * @return void
     */
    public function update_data(string $tabel = null)
    {
        $post = $this->input->post();
        $id = $this->input->post('id', true);

        switch ($tabel) {
            case 'jadwal_ujian':
                $this->form_validation->set_rules('durasi_pengerjaan', 'Durasi Pengerjaan', 'trim|is_natural|xss_clean');                
                if ($this->form_validation->run() == TRUE) {
                    unset($post['id']);
                    $this->db->update($tabel, $post, ['id' => $id]);
                    set_alert('success', 'Data durasi berhasil diupdate', $this->agent->referrer() ?? 'akademik');                   
                } else {
                    $err = validation_errors('<code>', '</code><br>');
                    set_alert('danger', '⛔ Terjadi kesalahan update data. Cek kesalahan berikut: <br>'.$err, $this->agent->referrer() ?? 'akademik');
                }
                break;
            case 'label':
                # code...
                break;
            default:
                show_404();
                break;
        }
    }

    /**
     * Reset data function
     * adalah fungsi untuk mengosongkan database tabel data yang dipilih
     * @return void
     */
    public function reset_data()
    {
        $this->form_validation->set_rules('table', 'Tabel', 'trim|required|alpha_dash|xss_clean');

        if ($this->form_validation->run() == true) {
            $this->db->truncate($this->input->post('table', true));
            set_alert('info', 'Data ' . $this->input->post('table', true) . ' berhasil dikosongkan.', 'akademik');
        } else {
            set_alert('info', 'Data ' . $this->input->post('table', true) . ' gagal dikosongkan. Kontak administrator.', 'akademik');
        }
    }

    /**
     * Generate data function
     * mengimport data dari data KRS mahasiswa, biar tidak banyak upload
     * @author Faris Zain - farisz@pknstan.ac.id
     * @since 2022-11-08 16:29:17
     *
     * @param  string|null $tabel
     * @return void
     */
    public function generate_data(string $tabel = null)
    {
        switch ($tabel) {
            case 'mahasiswa':
                $sql = 'INSERT INTO mahasiswa (nama_lengkap, nim, tanggal_lahir, program_studi, kelas) SELECT DISTINCT (nama_lengkap), npm AS nim, tanggal_lahir, program_studi, kelas  FROM krs_mahasiswa GROUP BY npm;';
                $this->db->query($sql);
                set_alert('info', 'Data '.$tabel.' berhasil digenerate dari KRS Mahasiswa.', 'akademik');
                break;
            case 'mata_kuliah':
                $sql = 'INSERT INTO mata_kuliah (mata_kuliah, program_studi, kelas, nama_dosen) SELECT mata_kuliah, program_studi, kelas, penilai AS nama_dosen FROM krs_mahasiswa GROUP BY program_studi, mata_kuliah, kelas ORDER BY program_studi, kelas, mata_kuliah';
                $this->db->query($sql);
                set_alert('info', 'Data ' . $tabel . ' berhasil digenerate dari KRS Mahasiswa.', 'akademik');
                break;
            default:
                show_404();
                break;
        }
    }

    /**
     * Kelola Data function
     * adalah method untuk view data yang tersimpan di database.
     * @param string $data
     * @return void
     */
    public function kelola_data(string $tabel = 'mahasiswa')
    {
        $list_table = ['mahasiswa', 'mata_kuliah', 'jadwal_ujian', 'soal_ujian', 'riwayat_upload_jawaban', 'riwayat_kirim_jawaban'];
        if (!in_array($tabel, $list_table)) {
            set_alert('warning', 'Parameter tampilkan data tidak valid!', 'akademik/kelola_data');
        }

        $q = !empty($this->input->get('cari', true)) ? urldecode(xss_clean($this->input->get('cari', true))) : null;
        $start = is_numeric($this->input->get('mulai', true)) ? intval($this->input->get('mulai', true)) : 0;
        $per_page = is_numeric($this->input->get('per_page', true)) ? intval($this->input->get('per_page', true)) : 10;

        $config['base_url'] = current_url();
        $config['first_url'] = current_url();

        $this->load->model('Apps_model');
        $this->load->library('table');

        $config['per_page'] = $per_page;
        $config['page_query_string'] = true;
        $config['total_rows'] = $this->Apps_model->total_data($tabel, $q);
        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $mydata = $this->Apps_model->data_limit($tabel, $config['per_page'], $start, $q)->result_array();
        $datas = [];
        $th = [];
        $mulai = $start + 1;
        foreach ($mydata as $i => $dt) {
            $th = array_keys($dt);
            unset($dt['id']);
            $datas[$i] = array_merge(['no' => $mulai++], $dt);
        };
        unset($th[0]);
        array_unshift($th, 'no');
        array_unshift($datas, $th);

        // library tabel
        $template = array(
            'table_open'            => '<table class="table table-vcenter card-table table-striped">'
        );
        $this->table->set_template($template);

        $data = array(
            'list_table' => $list_table,
            'mydata' => !empty($mydata) ? $this->table->generate($datas) : false,
            'q' => $q,
            'tabel' => $tabel,
            'start' => $start,
            'halaman' => paginasi($config['total_rows'], $start, count($mydata), $this->pagination->create_links()),
            'page' => 'pages/akademik/kelola_data'
        );

        $this->load->view('template_apps', $data ?? null, false);
    }

    /**
     * Soal function
     * adalah view untuk upload soal
     * @return void
     */
    public function soal()
    {
        // cek data jadwal ada apa kosong
        $ujian = $this->db->count_all_results('jadwal_ujian');
        // jika ada tampilkan tabel jadwal dan form
        $q = !empty($this->input->get('cari', true)) ? urldecode(xss_clean($this->input->get('cari', true))) : null;
        $start = is_numeric($this->input->get('mulai', true)) ? intval($this->input->get('mulai', true)) : 0;
        $per_page = is_numeric($this->input->get('per_page', true)) ? intval($this->input->get('per_page', true)) : 10;

        $this->load->model('Apps_model');

        $config['base_url'] = current_url();
        $config['first_url'] = current_url();
        $config['per_page'] = $per_page;
        $config['page_query_string'] = true;
        $config['total_rows'] = $this->Apps_model->total_data('jadwal_ujian', $q);

        $jadwal = $this->Apps_model->data_limit('jadwal_ujian', $config['per_page'], $start, $q)->result();
        $this->load->library('pagination');
        $this->pagination->initialize($config);
        // untuk attachment
        $file_type = ['video', 'zip', 'excel', 'powerpoint'];
        $mimes = ['video/mp4', 'video/mpeg', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/zip'];
        // data to view
        $data = array(
            'file_type' => $file_type, // untuk upload attachment
            'mimes' => $mimes,
            'jadwal' => $jadwal,
            'q' => $q,
            'ujian' => $ujian,
            'start' => $start,
            'halaman' => paginasi($config['total_rows'], $start, count($jadwal), $this->pagination->create_links()),
            'page' => 'pages/akademik/soal',
            'js' => 'pages/akademik/js'
        );

        $this->load->view('template_apps', $data ?? null, false);
    }

    /**
     * Soal Upload function
     * adalah proses untuk menyimpan file dan insert database
     * @return void
     */
    public function soal_upload(string $attach = 'soal', int $id_soal = null)
    {
        $redirect = empty($this->agent->referrer()) ? 'akademik/soal' : $this->agent->referrer();
        // saring method
        if (!in_array($attach, ['soal', 'attach1', 'attach2'])) {
            set_alert('warning', 'Method tidak ditemukan! Gunakan tautan tersedia.', $redirect);
        }
        // saring mimes
        $file_type = ['video', 'zip', 'excel', 'powerpoint'];
        $mimes = ['video/mp4', 'video/mpeg', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/zip'];

        // ambil data file_type
        $input_file_type = $this->input->post('file_type', true);
        // config
        if ($attach != 'soal' and in_array($input_file_type, $file_type)) {
            switch ($input_file_type) {
                case 'video':
                    $config1['allowed_types'] = 'mp4|mpeg';
                    break;
                case 'excel':
                    $config1['allowed_types'] = 'xlsx|xls';
                    break;
                case 'powerpoint':
                    $config1['allowed_types'] = 'pptx';
                    break;
                default:
                    $config1['allowed_types'] = 'zip';
                    break;
            }

            $config2 = [
                'upload_path' => WRITEPATH . 'masalah' . DIRECTORY_SEPARATOR,
                'max_size' => 10240,
                'overwrite' => true,
                'file_ext_tolower' => true,
                'encrypt_name' => true
            ];
            $config = array_merge($config1, $config2);
        } else {
            $config = [
                'upload_path' => WRITEPATH . 'masalah' . DIRECTORY_SEPARATOR,
                'allowed_types' => 'pdf',
                'max_size' => 8192,
                'overwrite' => true,
                'file_ext_tolower' => true,
                'encrypt_name' => true
            ];
        }

        $this->load->library('upload', $config);
        if (!$this->upload->do_upload($attach)) {
            $error = $this->upload->display_errors('<span class="text-danger">', '</span>');
            set_alert('danger', 'File gagal diupload. Periksa catatan error berikut: <br/>' . $error, $redirect);
        } else {
            $data = $this->upload->data();
            $file = $data['full_path'];

            if (isset($file) and !empty($file)) {
                if (!empty($attach) and $attach !== 'soal') {
                    $dt_soal = $this->db->get_where('soal_ujian', ['id' => $id_soal])->row();
                    if ($attach == 'attach2') {
                        $upd = [
                            'attachment2_type' => $input_file_type,
                            'attachment2_path' => substr($file, strlen($config['upload_path']))
                        ];
                    } else {
                        $upd = [
                            'ada_attachment' => 1,
                            'attachment1_type' => $input_file_type,
                            'attachment1_path' => substr($file, strlen($config['upload_path']))
                        ];
                    }

                    if (!empty($dt_soal)) {
                        $this->db->update('soal_ujian', $upd, ['id' => $dt_soal->id]);
                    } else {
                        unlink($file);
                        set_alert('warning', 'Data soal utama belum diupload', $redirect);
                    }
                } else {
                    $ins = [
                        'id_jadwal' => $this->input->post('id_jadwal', true),
                        'path_file' => substr($file, strlen($config['upload_path'])),
                        'id_user' => user()->id,
                        'diupload_pada' => date('Y-m-d H:i:s'),
                    ];
                    $this->db->insert('soal_ujian', $ins);
                }
                set_alert('success', 'File berhasil diupload dan data soal berhasil disimpan ke database.', $redirect);
            } else {
                unlink($file);
                set_alert('danger', 'Awas!! <br>File berhasil diupload namun data soal gagal disimpan ke database.', $redirect);
            }
        }
    }

    /**
     * View Soal function
     * menampilkan soal secara inline pada browser
     * @return void
     */
    public function view_soal(string $mime = null)
    {
        $file = $this->input->get('file', true);
        if (empty($file)) {
            $this->output->set_status_header(403);
            return $this->load->view('template_auth', ['page' => '404'], false);
        }
        $this->load->helper('download');
        // securing
        $filename = $this->security->sanitize_filename($file);
        $type_file = get_mime_by_extension($filename);
        $mimes = ['video/mp4', 'video/mpeg', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/zip', 'application/x-zip', 'application/pdf'];
        // basedir soal
        $dir = WRITEPATH . 'masalah' . DIRECTORY_SEPARATOR;
        switch ($mime) {
            case 'video':
                if (in_array($type_file, $mimes) and file_exists($dir . $filename)) {
                    include_once APPPATH . "libraries/VideoStream.php";
                    $stream = new VideoStream($dir . $filename);
                    $stream->start();
                    exit;
                    # kalau kepaksa pake ini
                    //force_download($dir . $filename, null);
                } else {
                    set_alert('warning', 'File excel tidak ditemukan', $this->agent->referrer());
                }
                break;
            case 'excel':
                if (in_array($type_file, $mimes) and file_exists($dir . $filename)) {
                    force_download($dir . $filename, null);
                } else {
                    set_alert('warning', 'File excel tidak ditemukan', $this->agent->referrer());
                }
                break;
            case 'zip':
                if (in_array($type_file, $mimes) and file_exists($dir . $filename)) {
                    force_download($dir . $filename, null);
                } else {
                    set_alert('warning', 'File zip tidak ditemukan', $this->agent->referrer());
                }
                break;
            case 'powerpoint':
                if (in_array($type_file, $mimes) and file_exists($dir . $filename)) {
                    force_download($dir . $filename, null);
                } else {
                    set_alert('warning', 'File power point tidak ditemukan', $this->agent->referrer());
                }
                break;
            default:
                if (in_array($type_file, $mimes) and file_exists($dir . $filename)) {
                    header('Content-type: application/pdf');
                    header('Content-Disposition: inline; filename="' . $file . '"');
                    header('Content-Transfer-Encoding: binary');
                    header('Accept-Ranges: bytes');
                    @readfile($dir . $file);
                } else {
                    $this->output->set_status_header(403);
                    return $this->load->view('template_auth', ['page' => '404'], false);
                }
                break;
        }
    }

    /**
     * Pengawas function
     * Kelola data pengawas, add, upload, edit delete data
     * @param string $act
     * @param integer $id
     * @return void
     */
    public function pengawas(string $act = null, int $id = null)
    {
        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'trim|required|min_length[2]|max_length[120]|alpha_numeric_spaces|xss_clean');
        $this->form_validation->set_rules('kode_pengawas', 'Kode Pengawas', 'trim|required|max_length[5]|numeric|xss_clean');
        $this->form_validation->set_rules('nik', 'NIK', 'trim|required|max_length[16]|numeric|xss_clean');
        $this->form_validation->set_rules('program_studi', 'Program Studi', 'trim|required|max_length[150]|xss_clean');
        $this->form_validation->set_rules('kelas', 'Kelas', 'trim|required|max_length[150]|xss_clean');
        $this->form_validation->set_rules('id_jadwal', 'ID Jadwal', 'trim|required|max_length[150]|alpha_numeric_spaces|xss_clean');
        $this->form_validation->set_rules('aktif', 'Aktif', 'trim|in_list[0,1]');

        // group opt
        function _group_by($array, $key)
        {
            $arr_key = array_keys($array[0]);
            $ret_key = array_values(array_diff($arr_key, [$key]));

            foreach ($array as $val) {
                $return[$val[$key]][] = $val[$ret_key[0]];
            }
            return $return;
        }

        function _group_jadwal($array, $key)
        {
            foreach ($array as $val) {
                $return[$val[$key]][] = [
                    'id' => (int) $val['id'],
                    'mata_kuliah' => tanggal_panjang($val['waktu'], true) . ' - ' . $val['mata_kuliah']
                ];
            }
            return $return;
        }

        switch ($act) {
            case 'tambah':

                if ($this->form_validation->run() == true) {
                    $ins = $this->input->post();
                    $this->db->insert('pengawas', $ins);
                    set_alert('success', 'Data pengawas berhasil ditambah', 'akademik/pengawas/tambah');
                } else {

                    $prod_kel = $this->db->query('SELECT program_studi, kelas FROM `mahasiswa` GROUP BY program_studi, kelas ORDER BY program_studi ASC;')->result_array();
                    $jadwal = $this->db->query('SELECT id, CONCAT(tanggal, \' \', waktu_mulai) as waktu, sesi, program_studi, mata_kuliah FROM `jadwal_ujian` ORDER BY `id` ASC;')->result_array();

                    $kelas_by_prodi = _group_by($prod_kel, 'program_studi');
                    $jadwal_by_prodi = _group_jadwal($jadwal, 'program_studi');
                    $opt_prodi = ['' => 'pilih program studi'];

                    foreach ($prod_kel as $i => $val) {
                        $opt_prodi[$val['program_studi']] = $val['program_studi'];
                        $opt_kelas[$val['kelas']] = $val['kelas'];
                    }

                    $data = [
                        'opt_prodi' => $opt_prodi,
                        'opt_kelas' => json_encode($kelas_by_prodi, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
                        'opt_jadwal' => json_encode($jadwal_by_prodi, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
                        'act' => $act,
                        'page' => 'pages/akademik/pengawas_form',
                    ];
                    //tampilkan_json($data);
                    $this->load->view('template_apps', $data ?? null, false);
                }
                break;

            case 'edit':
                $row = $this->db->get_where('pengawas', ['id' => $id])->row();
                if (empty($row)) {
                    set_alert('warning', 'Data pengawas gagal ditemukan.', 'akademik/pengawas');
                }

                if ($this->form_validation->run() == true) {
                    if (empty($this->input->post('status'))) {
                        $upd = $this->input->post();
                        $upd['status'] = 0;
                    } else {
                        $upd = $this->input->post();
                    };

                    $this->db->update('pengawas', $upd, ['id' => $row->id]);
                    set_alert('success', 'Data pengawas berhasil diperbarui.', 'akademik/pengawas');
                } else {

                    $prod_kel = $this->db->query('SELECT program_studi, kelas FROM `mahasiswa` GROUP BY program_studi, kelas ORDER BY program_studi ASC;')->result_array();
                    $jadwal = $this->db->query('SELECT id, CONCAT(tanggal, \' \', waktu_mulai) as waktu, sesi, program_studi, mata_kuliah FROM `jadwal_ujian` ORDER BY `id` ASC;')->result_array();
                    $opt_prodi = ['' => 'pilih program studi'];

                    $kelas_by_prodi = _group_by($prod_kel, 'program_studi');
                    $jadwal_by_prodi = _group_jadwal($jadwal, 'program_studi');

                    foreach ($prod_kel as $i => $val) {
                        $opt_prodi[$val['program_studi']] = $val['program_studi'];
                        $opt_kelas[$val['kelas']] = $val['kelas'];
                    }

                    $data = [
                        'opt_prodi' => $opt_prodi,
                        'opt_kelas' => json_encode($kelas_by_prodi, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
                        'opt_jadwal' => json_encode($jadwal_by_prodi, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
                        'nama_lengkap' => $row->nama_lengkap ?? set_value('nama_lengkap'),
                        'kode_pengawas' => $row->kode_pengawas ?? set_value('kode_pengawas'),
                        'nik' => $row->nik ?? set_value('nik'),
                        'program_studi' => $row->program_studi ?? set_value('program_studi'),
                        'kelas' => $row->kelas ?? set_value('kelas'),
                        'id_jadwal' =>  $row->id_jadwal ?? set_value('id_jadwal'),
                        'status' => $row->status ?? set_value('status'),
                        'act' => $act,
                        'page' => 'pages/akademik/pengawas_form',
                    ];
                    //tampilkan_json($data);
                    $this->load->view('template_apps', $data ?? null, false);
                }

                break;

            case 'delete':
                $row = $this->db->get_where('pengawas', ['id' => $id])->row();
                if (!empty($row)) {
                    $this->db->delete('pengawas', ['id' => $row->id]);
                    set_alert('success', 'Data pengawas dengan ID: ' . $id . ' berhasil dihapus', $this->agent->referrer() ?? 'akademik/pengawas');
                } else {
                    set_alert('warning', 'Data pengawas dengan ID: ' . $id . ' tidak ditemukan', $this->agent->referrer() ?? 'akademik/pengawas');
                }
                break;
            default:
                $q = !empty($this->input->get('cari', true)) ? urldecode(xss_clean($this->input->get('cari', true))) : null;
                $start = is_numeric($this->input->get('mulai', true)) ? intval($this->input->get('mulai', true)) : 0;
                $per_page = is_numeric($this->input->get('per_page', true)) ? intval($this->input->get('per_page', true)) : 10;

                $this->load->model('Apps_model');
                $this->load->library('table');


                $config['base_url'] = current_url();
                $config['first_url'] = current_url();
                $config['per_page'] = $per_page;
                $config['page_query_string'] = true;
                $config['total_rows'] = $this->Apps_model->total_data('pengawas', $q);
                $this->load->library('pagination');
                $this->pagination->initialize($config);

                //$mydata = $this->Apps_model->data_limit('pengawas', $config['per_page'], $start, $q)->result();
                if (!empty($q)) {
                    $sql = "SELECT p.*, j.tanggal, j.waktu_mulai, j.sesi, j.mata_kuliah FROM `pengawas` as p JOIN jadwal_ujian as j ON p.id_jadwal = j.id  WHERE `p`.`nama_lengkap` LIKE '%" . $q . "%' ESCAPE '!' OR `p`.`kode_pengawas` LIKE '%" . $q . "%' ESCAPE '!' OR `p`.`nik` LIKE '%" . $q . "%' ESCAPE '!' OR `p`.`program_studi` LIKE '%" . $q . "%' ESCAPE '!' OR `p`.`kelas` LIKE '%" . $q . "%' ESCAPE '!' OR `p`.`id_jadwal` LIKE '%" . $q . "%' ESCAPE '!' LIMIT " . $start . ", " . $config['per_page'] . ";";
                    $mydata = $this->db->query($sql)->result();
                } else {
                    $sql = 'SELECT p.*, j.tanggal, j.waktu_mulai, j.sesi, j.mata_kuliah FROM `pengawas` as p JOIN jadwal_ujian as j ON p.id_jadwal = j.id LIMIT ' . $start . ', ' . $config['per_page'] . ';';
                    $mydata = $this->db->query($sql)->result();
                }
                $data = [
                    'pengawas' => !empty($mydata) ? $mydata : false,
                    'q' => $q,
                    'start' => $start,
                    'halaman' => paginasi($config['total_rows'], $start, count($mydata), $this->pagination->create_links()),
                    'page' => 'pages/akademik/pengawas',
                ];
                $this->load->view('template_apps', $data ?? null, false);
                break;
        }
    }
    /**
     * BA Pengawas function
     * Menampilkan berita acara yang difilter sesuai tanggal dan sesi untuk monitoring dan download zip sebagai arsip BA
     * @return void
     */
    public function ba_pengawas()
    {
        $selected_hari = (!empty($this->input->get('tanggal')) and validateDate($this->input->get('tanggal'))) ? $this->input->get('tanggal'): 'all';
        $selected_sesi = (!empty($this->input->get('sesi')) and $this->form_validation->is_natural_no_zero($this->input->get('sesi'))) ? $this->input->get('sesi') : 'all';

        // Referensi : filter sesi
        $this->db->select('tanggal, sesi');
        $this->db->group_by('sesi');
        $sesi = $this->db->get('jadwal_ujian')->result_array();
        $tanggal_ujian = $this->db->select('tanggal')->group_by('tanggal')->order_by('tanggal', 'ASC')->from('jadwal_ujian')->get()->result_array();

        function _group_sesi($array, $key)
        {
            $return = array();
            foreach ($array as $val) {
                $return[$val[$key]][] = $val['sesi'];
            }
            return $return;
        }
        $group_sesi = _group_sesi($sesi, 'tanggal');
        $group_sesi = array_merge(['all' => ['Pilih sesi']], $group_sesi);
        // Referensi tanggal ujian
        $hari_ujian = [];
        foreach ($tanggal_ujian as $tgl) {
            $hari_ujian[$tgl['tanggal']] = tanggal_panjang($tgl['tanggal']);
        }
        $hari_ujian = array_merge(['all' => 'Pilih tanggal'], $hari_ujian);

        // ambil ba_pengawas joinkan all dan filter
        $this->db->join('jadwal_ujian as j', 'riwayat_ba_pengawas.id_jadwal = j.id', 'left');
        $this->db->join('pengawas as p', 'riwayat_ba_pengawas.id_pengawas = p.id', 'left');

        if((empty($selected_hari) or $selected_hari !== 'all') and (empty($selected_sesi) or $selected_sesi !== 'all')) {
            $this->db->where('j.tanggal', $selected_hari);
            $this->db->where('j.sesi', $selected_sesi);
        }

        $ba = $this->db->get('riwayat_ba_pengawas');

        // tampilan dibatasi per hari per sesi
        $data = [
            'page' => 'pages/akademik/pengawas_ba',
            'ba' => (empty($selected_hari) or $selected_hari == 'all') ? false : $ba->result(),
            'selected_hari' => $selected_hari,
            'selected_sesi' => $selected_sesi,
            'group_sesi' => $group_sesi,
            'hari_ujian' => $hari_ujian,
        ];
        //tampilkan_json($data);
        $this->load->view('template_apps', $data ?? null, FALSE);
    }

    public function ba_download(int $sesi = null)
    {
        $folder = WRITEPATH . 'BA' . DIRECTORY_SEPARATOR . $sesi.DIRECTORY_SEPARATOR;
        if(empty($sesi) or !is_dir($folder)) {
            set_alert('warning', 'Parameter data berita acara tidak valid. Gunakan tautan tersedia!', $this->agent->referrer());
        }

        //$base_dir = WRITEPATH.'BA'.DIRECTORY_SEPARATOR;
        $nama_zip = WRITEPATH.'BA'.DIRECTORY_SEPARATOR.'BA_'.$sesi.'.zip';
        $files = glob($folder.'*.pdf');
        $zip_mode = (is_file($nama_zip) and file_exists($nama_zip)) ? ZipArchive::OVERWRITE : ZipArchive::CREATE;
        // buat zip dan download
        $zip = new ZipArchive();
        if ($zip->open($nama_zip, $zip_mode) === true) {
            // Add files to the zip file
            foreach ($files as $file) {
                $file_ada = is_file(realpath($file));
                $options = array('add_path' => 'BA_'.$sesi . DIRECTORY_SEPARATOR, 'remove_all_path' => true);
                $file_ada and $zip->addGlob($file, 0, $options);
            }
            $zip->close();
            // download
            $this->load->helper('download');
            force_download($nama_zip, null);
        } else {
            // error
            set_alert('danger', 'File zip kirim jawaban gagal dibuat! Ulangi kembali atau kontak administrator.', $this->agent->referrer());
        }

    }

    /**
     * Riwayat jawaban function
     * adalah method untuk menampilkan data riwayat upload dari data base
     * @return void
     */
    public function riwayat_jawaban()
    {
        $base_dir = WRITEPATH . 'jawaban' . DIRECTORY_SEPARATOR;
        if (!empty($directory) and xss_clean($directory)) {
            $dir = $base_dir . DIRECTORY_SEPARATOR . $directory;
            $myfiles = scandir($dir);
            $files = array_diff($myfiles, ['.', '..']);
            tampilkan_json($files);
        } else {
            $dir = $base_dir;
            $myfiles = scandir($dir);
            $files = array_diff($myfiles, ['.', '..']);
        }
        $this->db->select('id, program_studi');
        $this->db->from('jadwal_ujian');
        $this->db->group_by('program_studi');
        $prodi = $this->db->get()->result_array();


        $data = [
            'base_dir' => $base_dir,
            'files' => $files,
            'prodi' => $prodi,
            'page' => 'pages/akademik/kelola_jawaban',
        ];

        $this->load->view('template_apps', $data ?? null, false);
    }

    /**
     * Kelola file jawaban function
     * sebagai kontrol kelengkapan jawaban dan kirim file soal ke dosen.
     * @return void
     */
    public function kelola_file_jawaban()
    {
        # pengelolaan file jawaban
        $this->load->view('template_apps', $data ?? null, false);
    }
}

/* End of file Akademik.php */
