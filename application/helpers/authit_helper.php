<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Authit Authentication Helper
 *
 * @package Authentication
 * @category Libraries
 * @author Ron Bailey customized by Farisz
 * @version 1.1
 */

function logged_in()
{
    $CI = &get_instance();
    return $CI->authit->logged_in();
}

/**
 * User function
 * Mengambil data user session.
 * @param string $key
 * @return string|object
 */
function user($key = '')
{
    $CI = &get_instance();

    $user = $CI->session->userdata('user');
    if ($key && isset($user->$key)) {
        return $user->$key;
    }
    return $user;
}

/**
 * Set Alert function
 * set flash data untuk alert
 *
 * @param string $type    pilihan color themes
 * @param string $pesan   isi pesan
 * @param boolean|string $redirect   halaman redirect
 * @return void
 */
function set_alert($type, $pesan, $redirect = false)
{
    $CI = &get_instance();
    $CI->session->set_flashdata('alert', array('type' => $type, 'pesan' => $pesan));
    if ($redirect) {
        redirect($redirect);
    }
}

/**
 * Show Alert function
 * Menampilkan flash data session sesuai theme dan pesan
 * @param boolean $dismiss  opsi dismiss alert
 * @return bool|string
 */
function show_alert($dismiss = true)
{
    $CI = &get_instance();
    if ($CI->session->flashdata('alert')) {
        $flash = $CI->session->flashdata('alert');
        $selamat = ($flash['type'] == 'success') ? 'Selamat !' : 'Perhatian !';
        $btn = ($dismiss) ? '<a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>' : '';

        return '<div class="alert alert-' . $flash['type'] . ' alert-dismissible" role="alert">
          <div class="d-flex">
            <div>
              <h4 class="alert-title">' . $selamat . '</h4>
              <div class="text-muted">' . $flash['pesan'] . '</div>
            </div>
          </div>
          ' . $btn . '
        </div>';
    };

    return false;
}

/**
 * Paginasi function
 * adalah helper untuk menampilkan paginasi pada bagian bawah tabel
 * @param integer $total_rows
 * @param integer $start
 * @param integer $per_page
 * @param string $links
 * @return string
 */
function paginasi(int $total_rows = 0, int $start = 0, int $per_page = 0, string $pagination_links = '')
{
    $start_str = ($total_rows == 0) ? 0 : 1;
    $text = ($total_rows < $per_page) ? 'Menampilkan <b>'.$start_str.'</b> data' : 'Menampilkan <b>'.$start_str. '</b> sampai ' . $start + $per_page . ' dari <b>' . $total_rows . '</b> data';
    $str = '<div class="mt-3 d-flex align-items-center">';
    $str .= '<p class="m-0 text-muted">'.$text.'</p>';
    $str .= $pagination_links;
    $str .= '</div>';

    return $str;
}

function soal_diupload($id_jadwal = null)
{
    if (empty($id_jadwal)) {
        return false;
    }

    $CI = &get_instance();
    $q = $CI->db->get_where('soal_ujian', ['id_jadwal' => $id_jadwal])->row();
    if (!empty($q)) {
        return $q;
    }
    return false;
}

/**
 * Samarkan function
 * adalah fungsi untuk menyamarkan (encript) string
 * @param boolean $decrip
 * @return string
 */
function samarkan(string $string = '', bool $decrip = false)
{
    if (empty($string)) {
        return false;
    }
    $CI = &get_instance();
    $CI->load->library('encryption');
    $CI->encryption->initialize(
        array(
            'cipher' => 'aes-256',
            'mode' => 'ctr',
            'key' => 'lDjCI1a3i4aoVXNVDkldX3mVqeboH7oG'
        )
    );

    if ($decrip) {
        return $CI->encryption->decrypt($string);
    } else {
        return $CI->encryption->encrypt($string);
    }
}

/**
 * Render JSON function
 * Menampilkan format json ke output
 *
 * @param array $data
 * @return void
 */
function tampilkan_json($data = null)
{
    $CI = &get_instance();
    $CI->output->set_status_header(200)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
        ->_display();
    exit;
}

/* End of file: authit_helper.php */
/* Location: application/helpers/authit_helper.php */
