<?php

defined('BASEPATH') or exit('No direct script access allowed');

use Dompdf\Dompdf;

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;

class Pengawas extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (user()->role != 'pengawas') {
            redirect('welcome');
        }
        $this->load->helper('ujian_helper');
    }

    public function index()
    {
        // jadwal
        $jadwal = $this->db->get_where('jadwal_ujian', ['id' => user()->id_jadwal])->row();
        // soal
        $soal = !empty($jadwal) ? $this->db->get_where('soal_ujian', ['id_jadwal' => $jadwal->id])->row() : false;
        // encript soal path
        $filename = !empty($soal) ? $soal->path_file : false;
        $soal_name = ($filename !== false) ? urlencode(base64_encode(samarkan($filename))) : false;
        $soal_utama = ($soal_name !== false) ? site_url('pengawas/file/pdf/' . $jadwal->id . '?file=' . $soal_name . '&tipe=masalah#toolbar=0') : '#';
        // mahasiswa pada prodi kelas
        $mhs = $this->db->get_where('krs_mahasiswa', ['program_studi' => user()->program_studi, 'mata_kuliah' => $jadwal->mata_kuliah, 'kelas' => user()->kelas])->result();
        // jawabanayat upload
        $this->db->where('kelas', nama_file_folder(user()->kelas));
        $this->db->where(['program_studi' => nama_file_folder($jadwal->program_studi), 'mata_kuliah' => nama_file_folder($jadwal->mata_kuliah)]);
        $riw = $this->db->get('riwayat_upload_jawaban')->result_array();


        function _group_by_nim($array, $key)
        {
            $return = array();
            foreach ($array as $val) {
                $return[$val[$key]][] = $val;
            }
            return $return;
        }
        $jawaban = _group_by_nim($riw, 'nim');

        $data = [
            'jadwal' => $jadwal,
            'mhs' => $mhs,
            'riw' => $riw,
            'jawaban' => $jawaban,
            'soal' => $soal,
            'soal_utama' => $soal_utama,
            'page' => 'pages/pengawas/index.php'
        ];

        $this->load->view('template_apps', $data ?? null, false);
    }

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
        $akses = izinkan_ujian($jadwal, -15); // reques mas fahrizal
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

    public function laporan()
    {
        $jadwal = $this->db->get_where('jadwal_ujian', ['id' => user()->id_jadwal])->row();
        // mahasiswa pada prodi kelas
        $mhs = $this->db->get_where('krs_mahasiswa', ['program_studi' => user()->program_studi, 'mata_kuliah' => $jadwal->mata_kuliah, 'kelas' => user()->kelas])->result();
        // jawabanayat upload
        $this->db->where('kelas', nama_file_folder(user()->kelas));
        $this->db->where(['program_studi' => nama_file_folder($jadwal->program_studi), 'mata_kuliah' => nama_file_folder($jadwal->mata_kuliah)]);
        $riw = $this->db->get('riwayat_upload_jawaban')->result();
        $data = [
            'jadwal' => $jadwal,
            'nama_ujian' => $this->config->item('nama_ujian'),
            'jum_mhs' => !empty($mhs) ? count($mhs) : 0,
            'jum_jawaban' => !empty($riw) ? count($riw) : 0,
            'page' => 'pages/pengawas/laporan',

        ];
        $this->load->view('template_apps', $data ?? null, FALSE);
    }

    public function simpan_laporan()
    {
        $this->form_validation->set_rules('ruang', 'Gedung/Ruang', 'trim|required|xss_clean');
        $this->form_validation->set_rules('peserta_total', 'Total Peserta', 'trim|required|is_natural|xss_clean');
        $this->form_validation->set_rules('peserta_hadir', 'Peserta Hadir', 'trim|required|is_natural|xss_clean');
        $this->form_validation->set_rules('peserta_absen', 'Peserta Tidak Hadir', 'trim|required|is_natural|xss_clean');
        $this->form_validation->set_rules('catatan', 'Catatan', 'trim|xss_clean');


        if ($this->form_validation->run() == TRUE) {
            if (($this->input->post('peserta_hadir', true) + $this->input->post('peserta_absen', true)) != $this->input->post('peserta_total', true)) {
                set_alert('warning', 'Jumlah jumlah peserta total tidak sesuai dengan jumlah peserta hadir dan absen!', $this->agent->referrer() ?? 'pengawas/laporan');
            }

            $jadwal = $this->db->get_where('jadwal_ujian', ['id' => $this->input->post('id_jadwal')])->row();
            $qr = $this->_gen_qr(user()->nik);
            $data = [
                'qr' => $qr,
                'nama_ujian' => $this->config->item('nama_ujian'),
                'jadwal' => $jadwal,
                'post' => $this->input->post()
            ];

            $html = $this->load->view('pages/pengawas/ba_pengawas', $data, true);

            $dompdf = new Dompdf();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            $stream = true;
            if (!$stream) {
                //$this->load->view('pages/pengawas/ba_pengawas', $data, FALSE);
                //$dompdf->stream('coba', array('Attachment' => 0));
            } else {
                //return $dompdf->output();
                $output = $dompdf->output();
                $base_ba = $this->config->item('dir_BA');
                $dir_file = $base_ba. $jadwal->sesi;
                // cek folder
                if (!is_dir(realpath($dir_file))) {
                    mkdir($dir_file, 755, true);
                }
                // siapkan file dengan filenamenya
                $nama_file = $dir_file . DIRECTORY_SEPARATOR . nama_file_folder($jadwal->program_studi) . '_' . nama_file_folder(user()->kelas) . '_' . nama_file_folder($jadwal->mata_kuliah) . '_' . nama_file_folder(user()->nama_lengkap) . '.pdf';

                file_put_contents($nama_file, $output);
            }

            // insert/update BA
            $where = [
                'id_pengawas' => $this->input->post('id_pengawas', true),
                'id_jadwal' => $this->input->post('id_jadwal', true),
                'program_studi' => $this->input->post('program_studi', true),
                'mata_kuliah' => $this->input->post('mata_kuliah', true),
                'kelas' => $this->input->post('kelas', true),
            ];

            $row = $this->db->get_where('riwayat_ba_pengawas', $where)->row();
            $add = [
                'ruang' => $this->input->post('ruang', true),
                'peserta_total' => $this->input->post('peserta_total', true),
                'peserta_hadir' => $this->input->post('peserta_hadir', true),
                'peserta_absen' => $this->input->post('peserta_absen', true),
                'peserta_absen' => $this->input->post('peserta_absen', true),
                'catatan' => $this->input->post('catatan', true),
                'file_path' => str_replace(WRITEPATH, '', $nama_file),
                'dibuat_pada' => date('Y-m-d H:i:s'),
            ];

            $ins = array_merge($where, $add);
            if (!empty($row)) {
                $this->db->update('riwayat_ba_pengawas', $ins, ['id' => $row->id]);
            } else {
                $this->db->insert('riwayat_ba_pengawas', $ins);
            }
            // akhir data
            $data['akhir'] = true;
            $data['nama_ujian'] = $this->config->item('nama_ujian');
            $this->load->view('pages/pengawas/ba_pengawas', $data, FALSE);
        } else {
            $err = validation_errors('<span class="text-danger small">', '</span><br>');
            set_alert('warning', 'Data berita acara pengawas tidak valid. Cek kesalahan berikut: <br>' . $err, $this->agent->referrer() ?? 'pengawas/laporan');
        }
    }

    public function _gen_qr(string $nik = null)
    {
        if (!empty($nik)) {
            $writer = new PngWriter();
            $qrCode = QrCode::create($nik)
                ->setEncoding(new Encoding('UTF-8'))
                ->setErrorCorrectionLevel(new ErrorCorrectionLevelHigh())
                ->setSize(120)
                ->setMargin(5)
                ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
                ->setForegroundColor(new Color(0, 0, 0))
                ->setBackgroundColor(new Color(255, 255, 255, 127));

            $result = $writer->write($qrCode);
            $dataUri = $result->getDataUri();
            return '<img src="' . $dataUri . '" style="display:inline-block;"/>';
        } else {
            return false;
        }
    }

    public function save_laporan($qr = null)
    {
        $html = $this->input->post();
        tampilkan_json($html);
    }
}

/* End of file Pengawas.php */
