<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_krs_mahasiswa extends CI_Migration
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
            'nama_lengkap' => array(
                'type' => 'VARCHAR',
                'constraint' => '200',
                'null' => TRUE,
            ),
            'npm' => array(
                'type' => 'BIGINT',
                'constraint' => '20',
                'null' => TRUE,
            ),
            'tanggal_lahir' => array(
                'type' => 'DATETIME',
                'null' => TRUE,
            ),
            'agama' => array(
                'type' => 'VARCHAR',
                'constraint' => '25',
                'null' => TRUE,
            ),
            'mata_kuliah' => array(
                'type' => 'VARCHAR',
                'constraint' => '200',
                'null' => TRUE,
            ),
            'sks' => array(
                'type' => 'INT',
                'constraint' => '2',
                'null' => TRUE,
            ),
            'periode' => array(
                'type' => 'INT',
                'constraint' => '5',
                'null' => TRUE,
            ),
            'bobot_nilai' => array(
                'type' => 'VARCHAR',
                'constraint' => '10',
                'null' => TRUE,
            ),
            'penilai' => array(
                'type' => 'VARCHAR',
                'constraint' => '150',
                'null' => TRUE,
            ),
            'program_studi' => array(
                'type' => 'VARCHAR',
                'constraint' => '200',
                'null' => TRUE,
            ),
            'kelas' => array(
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => TRUE,
            ),
        ));

        // Add Primary Key.
        $this->dbforge->add_key("id", TRUE);

        // Table attributes.

        $attributes = array(
            'ENGINE' => 'InnoDB',
        );

        // Create Table krs_mahasiswa
        $this->dbforge->create_table("krs_mahasiswa", TRUE, $attributes);

    }

    /**
     * down (drop table)
     *
     * @return void
     */
    public function down()
    {
        // Drop table krs_mahasiswa
        $this->dbforge->drop_table("krs_mahasiswa", TRUE);
    }

}
