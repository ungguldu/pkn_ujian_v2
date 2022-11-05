
<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Core Class all other classes extend
 */
class MY_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library('authit');
        $this->load->helper(array('authit', 'tanggal', 'inflector'));

        if (!logged_in()) {
            $redirect = !empty(current_url()) ? current_url() : $this->input->server('REQUEST_URI');
            $this->session->set_tempdata('redirect', $redirect, 60);
            redirect('auth');
        }

        /* $settings = $this->settings_model->get_settings();
        $this->settings = new stdClass();
        foreach ($settings as $setting) {
            $this->settings->{$setting['name']} = (@unserialize($setting['value']) !== false) ? unserialize($setting['value']) : $setting['value'];
        } */

        $this->form_validation->set_error_delimiters('<div class="text-danger small error">', '</div>');
        $this->form_validation->set_message('min_length', '{field} minimal {param} karakter.');
        $this->form_validation->set_message('required', '{field} harus diisi!');
        $this->form_validation->set_message('matches', '{field} tidak cocok! Silakan ulangi');
        $this->form_validation->set_message('alpha_numeric_spaces', '{field} hanya karakter huruf, angka dan spasi!');
        $this->form_validation->set_message('alpha_dash', '{field} hanya karakter huruf dan dash!');
        $this->form_validation->set_message('is_unique', '{field} telah terdaftar! Isikan yang lain.');
        $this->form_validation->set_message('numeric', '{field} harus karakter angka!');
        $this->form_validation->set_message('is_natural_no_zero', 'Isi {field} pada pilihan tersedia!');
        $this->form_validation->set_message('regex_match', 'Karakter yang anda masukkan bukan text bebas! Gunakan tanda baca baku.');
        $this->form_validation->set_message('decimal', 'Gunakan format desimal!');
        $this->form_validation->set_message('valid_email', 'Format email tidak valid!');
        $this->form_validation->set_message('xss_clean', 'stop! kode berbahaya.');
    }
}
