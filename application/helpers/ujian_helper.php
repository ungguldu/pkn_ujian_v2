<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function izinkan_ujian(objectarray $jadwal = null, int $adjust_waktu_mulai = 0)
{
    if(empty($jadwal)) return false;
    $CI = &get_instance();

    $sks = $jadwal->sks;
    switch ($sks) {
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
    $tambahan = $CI->config->item('durasi_pengumpulan');
    // ubah ke base integer strtotime
    $waktu_ujian_ori = strtotime($jadwal->tanggal . ' ' . $jadwal->waktu_mulai); // y-m-d
    $waktu_ujian = !empty($adjust_waktu_mulai) ? strtotime($jadwal->tanggal . ' ' . $jadwal->waktu_mulai .' '.$adjust_waktu_mulai .' minutes') : $waktu_ujian_ori;
    // durasi dalam menit
    $durasi_ujian = !empty($jadwal->durasi_pengerjaan) ? $jadwal->durasi_pengerjaan + $tambahan : $pengerjaan + $tambahan; // dalam menit
    // waktu akses base int
    $waktu_akses = strtotime(date('Y-m-d H:i:s'));
    // sesi max int
    $sesi_max = strtotime(date('Y-m-d H:i:s', $waktu_ujian_ori) . ' + '.$durasi_ujian.' minutes');
    $izinkan = ($waktu_akses > $waktu_ujian and $waktu_akses < $sesi_max) ? true : false;
    $sisa_sesi = $sesi_max - $waktu_akses;
    return ['izinkan' => $izinkan, 'sisa_sesi' => $sisa_sesi, 'durasi_ujian' => $durasi_ujian, 'akses_terakhir' => date('Y-m-d H:i:s', $sesi_max)];
}

function nama_file_folder(string $str = null)
{
    if(empty($str)) return false;
    return strtolower(str_replace(['.', '\'', '(', ')', ':', '/', '-', ',', ' '], '_', $str));
}