<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Ujian_model extends CI_Model {
    
    public function __construct()
    {
        parent::__construct();
    }

    public function krs_by_jadwal(string $npm = null, int $sesi = null)
    {
        // konstruksi where
        $sesi =  !empty($sesi) ? ' AND sesi = '.$sesi : '';
        // sql statement
        $sql = 'SELECT * FROM krs_mahasiswa WHERE (program_studi, mata_kuliah, semester) IN (SELECT program_studi, mata_kuliah, semester FROM jadwal_ujian WHERE tanggal = DATE(NOW()) '.$sesi.') AND npm = \''.$npm.'\'';

        return $this->db->query($sql)->row();
    }
    
    public function krs_mahasiswa(string $npm = null, string $matkul = null)
    {
        // krs by mahasiswa, matkul
        if(!empty($npm) and !empty($matkul)) {
            $this->db->where('npm', $npm);
            $this->db->where('mata_kuliah', $matkul);            
            return $this->db->get('krs_mahasiswa')->row(); 
        }
        // krs by mahasiswa
        if (!empty($npm)) {
            return $this->db->get_where('krs_mahasiswa', ['npm' => $npm])->result();
        }
        // krs all ambil dari apps model
        return false; 
    }
}

/* End of file Ujian_model.php */
