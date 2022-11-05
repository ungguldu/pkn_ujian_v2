<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_riwayat_kirim_jawaban extends CI_Migration
{

    /**
     * up (create table)
     *
     * @return void
     */
    public function up()
    {
        $this->down();

        // Add Fields.
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'auto_increment' => TRUE,
            ),
            'program_studi' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE,
            ),
            'mata_kuliah' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE,
            ),
            'kelas' => array(
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => TRUE,
            ),
            'email_dosen' => array(
                'type' => 'VARCHAR',
                'constraint' => '150',
                'null' => TRUE,
            ),
            'file_zip' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE,
            ),
            'hash_zip' => array(
                'type' => 'VARCHAR',
                'constraint' => '150',
                'null' => TRUE,
            ),
            'dikirim_oleh' => array(
                'type' => 'INT',
                'constraint' => '11',
                'null' => TRUE,
            ),
            'dikirim_pada' => array(
                'type' => 'DATETIME',
                'null' => TRUE,
            ),
        ));

        // Add Primary Key.
        $this->dbforge->add_key("id", TRUE);

        // Table attributes.

        $attributes = array(
            'ENGINE' => 'InnoDB',
        );

        // Create Table riwayat_kirim_jawaban
        $this->dbforge->create_table("riwayat_kirim_jawaban", TRUE, $attributes);

    }

    /**
     * down (drop table)
     *
     * @return void
     */
    public function down()
    {
        // Drop table riwayat_kirim_jawaban
        $this->dbforge->drop_table("riwayat_kirim_jawaban", TRUE);
    }

}
