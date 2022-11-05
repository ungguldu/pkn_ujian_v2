<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_mata_kuliah extends CI_Migration
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
            'mata_kuliah' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
            ),
            'program_studi' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
            ),
            'kelas' => array(
                'type' => 'VARCHAR',
                'constraint' => '20',
            ),
            'nama_dosen' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => TRUE,
            ),
            'email_dosen' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => TRUE,
            ),
        ));

        // Add Primary Key.
        $this->dbforge->add_key("id", TRUE);

        // Table attributes.

        $attributes = array(
            'ENGINE' => 'InnoDB',
        );

        // Create Table mata_kuliah
        $this->dbforge->create_table("mata_kuliah", TRUE, $attributes);

    }

    /**
     * down (drop table)
     *
     * @return void
     */
    public function down()
    {
        // Drop table mata_kuliah
        $this->dbforge->drop_table("mata_kuliah", TRUE);
    }

}
