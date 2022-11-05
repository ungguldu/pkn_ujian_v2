<?php defined('BASEPATH') or exit('No direct script access allowed');

class Apps_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        //Do your magic here
    }

    /**
     * Total data function
     * adalah fungsi untuk menampilkan jumlah data hasil pencarian dari suatu tabel
     * @param string $table
     * @param string $q
     * @return int
     */
    public function total_data(string $table = '', string $q = null)
    {
        if (empty($table)) return false;

        $fields = $this->db->list_fields($table);
        if (!empty($q)) {
            foreach ($fields as $a => $field) {
                if ($a == 0) $this->db->like($field, $q);
                $this->db->or_like($field, $q);
            }
        };
        $this->db->from($table);
        return $this->db->count_all_results();
    }

    /**
     * Data Limit function
     * adalah fungsi untuk mengambil data dari database. jika $q tidak null maka akan ditampilkan sesuai pencarian.
     *
     * @param string $table
     * @param boolean $limit
     * @param integer $start
     * @param string $q
     * @return void
     */
    public function data_limit($table = '', $limit = FALSE, $start = 0, $q = null)
    {
        if (empty($table)) return false;

        $fields = $this->db->list_fields($table);
        if (!empty($q)) {
            foreach ($fields as $a => $field) {
                if ($a == 0) $this->db->like($field, $q);
                $this->db->or_like($field, $q);
            }
        };
        if ($limit) {
            $this->db->limit($limit, $start);
        }
        return $this->db->get($table);
    }
}

/* End of file Apps.php */