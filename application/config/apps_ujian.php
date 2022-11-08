<?php

defined('BASEPATH') or exit('No direct script access allowed');

$config['nama_aplikasi'] = 'Box Ujian - PKN STAN';
/**
 * config base directory masing topik.
 */
$config['dir_data'] = WRITEPATH.'data'.DIRECTORY_SEPARATOR;
$config['dir_template'] = WRITEPATH . 'templates' . DIRECTORY_SEPARATOR;
$config['dir_soal'] = WRITEPATH . 'masalah' . DIRECTORY_SEPARATOR;
$config['dir_jawaban'] = WRITEPATH . 'jawaban' . DIRECTORY_SEPARATOR;
$config['dir_zip'] = WRITEPATH . 'zip' . DIRECTORY_SEPARATOR;
$config['dir_BA'] = WRITEPATH . 'ba_ujian' . DIRECTORY_SEPARATOR;

/**
 * durasi pengerjaan
 */
$config['durasi_3sks'] = 180; // dalam menit
$config['durasi_2sks'] = 120; // dalam menit
$config['durasi_1sks'] = 120; // dalam menit

/**
 * Initial config jika di DB tidak diisi
 */
$config['nama_aplikasi'] = 'Portal Ujian - PKN STAN';
$config['sesi_ditampilkan'] = false;
$config['sesi_awal'] = 1;
$config['sesi_akhir'] = 5;
$config['durasi_pengumpulan'] = 30; // dalam menit
$config['nama_ujian'] = 'Ujian Test - UJI COBA UJIAN'; // untuk body BA