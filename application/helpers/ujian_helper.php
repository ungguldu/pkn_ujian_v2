<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function izinkan_ujian(object|array $jadwal = null)
{
    if(empty($jadwal)) return false;
    $CI = &get_instance();

    $sesi = $jadwal->sesi;
    switch ($sesi) {
        case '3':
            $pengerjaan = $CI->config->item('durasi_3sks');
            break;
        case '2':
            $pengerjaan = $CI->config->item('durasi_2sks');
            break;
        case '1':
            $pengerjaan = $CI->config->item('durasi_1sks');
            break;
        default:
            $pengerjaan = 0;
            break;
    }

    $durasi_ujian = $CI->config->item('durasi_pengumpulan') + $pengerjaan; // dalam menit
    $waktu_akses = date('Y-m-d H:i:s');
    $waktu_ujian = $jadwal->tanggal . ' ' . $jadwal->waktu_mulai;
    $sesi_max = date('Y-m-d H:i:s', strtotime($waktu_ujian . ' + '.$durasi_ujian.' minutes'));
    $izinkan = ($waktu_akses > $waktu_ujian and $waktu_akses < $sesi_max) ? true : false;
    $sisa_sesi = strtotime($sesi_max) - strtotime($waktu_akses);
    return ['izinkan' => $izinkan, 'sisa_sesi' => $sisa_sesi, 'durasi_ujian' => $durasi_ujian];
}

function nama_file_folder(string $str = null)
{
    if(empty($str)) return false;
    return str_replace(['.', '\'', '(', ')', ':', '/', '-', ',', ' '], '_', $str);
}