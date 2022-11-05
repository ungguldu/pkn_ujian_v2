<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Authit
{
    private $CI;

    public function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->database();
    }

    /**
     * Logged In function
     * Cek apakah user sudah login atau belum
     * @return boolean
     */

    public function logged_in()
    {
        $gula = '##___Bismill@h99*.Aman.Lancar.____##';
        $kode = hash_hmac("sha256", date('Y_M_d'), $gula);

        if (!empty($this->CI->session->userdata('logged_in')) and hash_equals($this->CI->session->userdata('logged_in'), $kode)) {
            return true;
        }
        return false;
    }

    /**
     * Login function
     * loginkan user
     * @param [string] $role
     * @param [object] $user
     * @return void
     */

    public function login($role = null, $user = null)
    {
        $gula = '##___Bismill@h99*.Aman.Lancar.____##';
        $logged_in_code = hash_hmac("sha256", date('Y_M_d'), $gula);

        if (!empty($role) and !empty($user)) {
            switch ($role) {
                case 'akademik':
                case 'si_super':
                    $upd = [
                        'login_pada' => date('Y-m-d H:i:s'),
                        'ip_address' => $this->CI->input->ip_address()
                    ];
                    $this->CI->db->update('users', $upd, ['id' => $user->id]);
                    if (!empty($user->password)) {
                        unset($user->password);
                    }
                    $this->CI->session->set_userdata(array(
                        'logged_in' => $logged_in_code,
                        'user' => $user,
                    ));
                    return true;
                    break;
                case 'pengawas':
                    $this->CI->session->set_userdata(array(
                        'logged_in' => $logged_in_code,
                        'user' => $user,
                    ));
                    break;
                case 'mahasiswa':
                    $riwayat = [
                        'id_mahasiswa' => $user->nim,
                        'login_pada' => date('Y-m-d H:i:s'),
                        'ip_address' => $this->CI->input->ip_address()
                    ];
                    $this->CI->db->insert('riwayat_login', $riwayat);
                    $this->CI->session->set_userdata(array(
                        'logged_in' => $logged_in_code,
                        'user' => $user,
                    ));
                    return true;
                    break;
                default:
                    return false;
                    break;
            }
        }
        return false;
    }

    public function register(string $email = null, string $password = null)
    {
        $data = [
            'email' => $email,
            'password' => $this->encode_password($password),
            'dibuat_pada' => date('Y-m-d H:i:s'),
            'ip_address' => $this->CI->input->ip_address()
        ];
        if ($this->CI->db->insert('users', $data)) {
            return true;
        }
        return false;
    }

    /**
     * Encode password function
     * Mengembalikan password yang sudah dihash
     * @param string|null $password
     * @return string
     */

    public function encode_password(string $password = null)
    {
        $gula = '###__Bismill@h99!_Lancar.Aman.Barokah__###';
        $pwd_digulai = hash_hmac("sha256", $password, $gula);

        return password_hash($pwd_digulai, PASSWORD_DEFAULT);
    }

    public function verify_password(string $input = null, string $hash = null)
    {
        $gula = '###__Bismill@h99!_Lancar.Aman.Barokah__###';
        $password = hash_hmac("sha256", $input, $gula);
        return password_verify($password, $hash);
    }

    public function logout($redirect = false)
    {
        $this->CI->session->sess_destroy();
        if ($redirect) {
            redirect($redirect, 'refresh');
        }
    }
}

/* End of file: Authit.php */
/* Location: application/libraries/Authit.php */
