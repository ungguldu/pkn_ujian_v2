<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_soal_ujian extends CI_Migration
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
            'id_jadwal' => array(
                'type' => 'INT',
                'constraint' => '11',
            ),
            'path_file' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
            ),
            'id_user' => array(
                'type' => 'INT',
                'constraint' => '11',
            ),
            'diupload_pada' => array(
                'type' => 'DATETIME',
                'null' => TRUE,
            ),
            'ada_attachment' => array(
                'type' => 'TINYINT',
                'constraint' => '1',
                'null' => TRUE,
            ),
            'attachment1_type' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => TRUE,
            ),
            'attachment1_path' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE,
            ),
            'attachment2_type' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => TRUE,
            ),
            'attachment2_path' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE,
            ),
        ));

        // Add Primary Key.
        $this->dbforge->add_key("id", TRUE);

        // Table attributes.

        $attributes = array(
            'ENGINE' => 'InnoDB',
        );

        // Create Table soal_ujian
        $this->dbforge->create_table("soal_ujian", TRUE, $attributes);

    }

    /**
     * down (drop table)
     *
     * @return void
     */
    public function down()
    {
        // Drop table soal_ujian
        $this->dbforge->drop_table("soal_ujian", TRUE);
    }

}
