<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_create_users extends CI_Migration
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
                'auto_increment' => true,
            ),
            'email' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'unique' => true,
            ),
            'password' => array(
                'type' => 'VARCHAR',
                'constraint' => '150',
            ),
            'nip' => array(
                'type' => 'VARCHAR',
                'constraint' => '18',
                'null' => true,
            ),
            'nama_lengkap' => array(
                'type' => 'VARCHAR',
                'constraint' => '120',
                'null' => true,
            ),
            'role' => array(
                'type' => 'VARCHAR',
                'constraint' => '20',
                'default' => 'akademik',
            ),
            'aktif' => array(
                'type' => 'TINYINT',
                'constraint' => '1',
                'default' => '1',
            ),
            'dibuat_pada' => array(
                'type' => 'DATETIME',
                'null' => true,
            ),
            'login_pada' => array(
                'type' => 'DATETIME',
                'null' => true,
            ),
            'ip_address' => array(
                'type' => 'VARCHAR',
                'constraint' => '18',
                'null' => true,
            ),
        ));

        // Add Primary Key.
        $this->dbforge->add_key("id", true);

        // Table attributes.

        $attributes = array(
            'ENGINE' => 'InnoDB',
        );

        // Create Table users
        $this->dbforge->create_table("users", true, $attributes);
        // insert defautl user
        $ins = [
            'email' => 'admin00@pknstan.ac.id',
            'password' => '$2y$10$tVwhgKmluPW6IMqRkyYdPOaMMGhHk/VxsddufialQj7APo9NB1YPK',
            'nip' => '00000000000000001',
            'nama_lengkap' => 'Admin default',
            'role' => 'akademik',
            'aktif' => 1,
            'dibuat_pada' => date('Y-m-d H:i:s'),
            'login_pada' => null,
            'ip_address' => '0.0.0.0'
        ];
        $this->db->insert('users', $ins);
    }

    /**
     * down (drop table)
     *
     * @return void
     */
    public function down()
    {
        // Drop table users
        $this->dbforge->drop_table("users", true);
    }
}
