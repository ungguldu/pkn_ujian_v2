<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_riwayat_login extends CI_Migration
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
            'role' => array(
                'type' => 'VARCHAR',
                'constraint' => '20',
            ),
            'id_mahasiswa' => array(
                'type' => 'INT',
                'constraint' => '11',
            ),
            'login_pada' => array(
                'type' => 'DATETIME',
            ),
            'ip_address' => array(
                'type' => 'VARCHAR',
                'constraint' => '15',
            ),
        ));

        // Add Primary Key.
        $this->dbforge->add_key("id", TRUE);

        // Table attributes.

        $attributes = array(
            'ENGINE' => 'InnoDB',
        );

        // Create Table riwayat_login
        $this->dbforge->create_table("riwayat_login", TRUE, $attributes);

    }

    /**
     * down (drop table)
     *
     * @return void
     */
    public function down()
    {
        // Drop table riwayat_login
        $this->dbforge->drop_table("riwayat_login", TRUE);
    }

}
