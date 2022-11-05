<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_kuisioner extends CI_Migration
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
                'null' => TRUE,
            ),
            'program_studi' => array(
                'type' => 'VARCHAR',
                'constraint' => '150',
                'null' => TRUE,
            ),
            'angkatan' => array(
                'type' => 'YEAR',
                'constraint' => '4',
                'null' => TRUE,
            ),
            'gender' => array(
                'type' => 'VARCHAR',
                'constraint' => '10',
                'null' => TRUE,
            ),
            'formasi' => array(
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => TRUE,
            ),
            'isian_1' => array(
                'type' => 'INT',
                'constraint' => '1',
                'null' => TRUE,
            ),
            'isian_2' => array(
                'type' => 'INT',
                'constraint' => '1',
                'null' => TRUE,
            ),
            'isian_3' => array(
                'type' => 'INT',
                'constraint' => '1',
                'null' => TRUE,
            ),
            'isian_4' => array(
                'type' => 'INT',
                'constraint' => '1',
                'null' => TRUE,
            ),
            'isian_5' => array(
                'type' => 'INT',
                'constraint' => '1',
                'null' => TRUE,
            ),
            'isian_6' => array(
                'type' => 'INT',
                'constraint' => '1',
                'null' => TRUE,
            ),
            'isian_7' => array(
                'type' => 'INT',
                'constraint' => '1',
                'null' => TRUE,
            ),
            'isian_8' => array(
                'type' => 'INT',
                'constraint' => '1',
                'null' => TRUE,
            ),
            'isian_9' => array(
                'type' => 'INT',
                'constraint' => '1',
                'null' => TRUE,
            ),
            'isian_10' => array(
                'type' => 'INT',
                'constraint' => '1',
                'null' => TRUE,
            ),
            'masukan_1' => array(
                'type' => 'TEXT',
                'null' => TRUE,
            ),
            'masukan_2' => array(
                'type' => 'TEXT',
                'null' => TRUE,
            ),
            'masukan_3' => array(
                'type' => 'TEXT',
                'null' => TRUE,
            ),
            'masukan_4' => array(
                'type' => 'TEXT',
                'null' => TRUE,
            ),
            'dibuat_pada' => array(
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

        // Create Table kuisioner
        $this->dbforge->create_table("kuisioner", TRUE, $attributes);

    }

    /**
     * down (drop table)
     *
     * @return void
     */
    public function down()
    {
        // Drop table kuisioner
        $this->dbforge->drop_table("kuisioner", TRUE);
    }

}
