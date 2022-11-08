<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_mahasiswa extends CI_Migration
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
            'nim' => array(
                'type' => 'VARCHAR',
                'constraint' => '20',
                'unique' => TRUE,
                'null' => TRUE,
            ),
            'nama_lengkap' => array(
                'type' => 'VARCHAR',
                'constraint' => '150',
                'null' => TRUE,
            ),
            'tanggal_lahir' => array(
                'type' => 'DATE',
                'null' => TRUE,
            ),
            'program_studi' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE,
            ),
            'kelas' => array(
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => TRUE,
            ),
        ));

        // Add Primary Key.
        $this->dbforge->add_key("id", TRUE);

        // Table attributes.

        $attributes = array(
            'ENGINE' => 'InnoDB',
        );

        // Create Table mahasiswa
        $this->dbforge->create_table("mahasiswa", TRUE, $attributes);

    }

    /**
     * down (drop table)
     *
     * @return void
     */
    public function down()
    {
        // Drop table mahasiswa
        $this->dbforge->drop_table("mahasiswa", TRUE);
    }

}
