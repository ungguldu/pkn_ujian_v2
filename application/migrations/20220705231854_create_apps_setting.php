<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_apps_setting extends CI_Migration
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
            'nama' => array(
                'type' => 'VARCHAR',
                'constraint' => '50',
                'unique' => TRUE,
                'null' => TRUE,
            ),
            'isi' => array(
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

        // Create Table apps_setting
        $this->dbforge->create_table("apps_setting", TRUE, $attributes);

    }

    /**
     * down (drop table)
     *
     * @return void
     */
    public function down()
    {
        // Drop table apps_setting
        $this->dbforge->drop_table("apps_setting", TRUE);
    }

}
