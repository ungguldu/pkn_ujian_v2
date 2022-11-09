<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_jadwal_ujian extends CI_Migration
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
            'tanggal' => array(
                'type' => 'DATE',
                'null' => TRUE,
            ),
            'waktu_mulai' => array(
                'type' => 'TIME',
                'null' => TRUE,
            ),
            'sesi' => array(
                'type' => 'INT',
                'constraint' => '2',
                'null' => TRUE,
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
            'durasi_pengerjaan' => array(
                'type' => 'INT',
                'constraint' => '3',
                'null' => TRUE,
            ),
            'semester' => array(
                'type' => 'VARCHAR',
                'constraint' => '25',
                'null' => TRUE,
            ),
            'sks' => array(
                'type' => 'INT',
                'constraint' => '1',
                'null' => TRUE,
            ),
        ));

        // Add Primary Key.
        $this->dbforge->add_key("id", TRUE);

        // Table attributes.

        $attributes = array(
            'ENGINE' => 'InnoDB',
        );

        // Create Table jadwal_ujian
        $this->dbforge->create_table("jadwal_ujian", TRUE, $attributes);

    }

    /**
     * down (drop table)
     *
     * @return void
     */
    public function down()
    {
        // Drop table jadwal_ujian
        $this->dbforge->drop_table("jadwal_ujian", TRUE);
    }

}
