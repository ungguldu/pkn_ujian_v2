<?php defined('BASEPATH') or exit('No direct script access allowed');

class Migration_create_riwayat_ba_pengawas extends CI_Migration
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
            'id_pengawas' => array(
                'type' => 'INT',
                'constraint' => '11',
            ),
            'id_jadwal' => array(
                'type' => 'INT',
                'constraint' => '11',
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
            'kelas' => array(
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => TRUE,
            ),
            'ruang' => array(
                'type' => 'VARCHAR',
                'constraint' => '150',
                'null' => TRUE,
            ),
            'peserta_total' => array(
                'type' => 'INT',
                'constraint' => '3',
                'null' => TRUE,
            ),
            'peserta_hadir' => array(
                'type' => 'INT',
                'constraint' => '3',
                'null' => TRUE,
            ),
            'peserta_absen' => array(
                'type' => 'INT',
                'constraint' => '3',
                'null' => TRUE,
            ),
            'catatan' => array(
                'type' => 'TEXT',
                'null' => TRUE,
            ),
            'file_path' => array(
                'type' => 'TEXT',
                'null' => TRUE,
            ),
            'dibuat_pada datetime default current_timestamp',
        ));

        // Add Primary Key.
        $this->dbforge->add_key("id", TRUE);

        // Table attributes.

        $attributes = array(
            'ENGINE' => 'InnoDB',
        );

        // Create Table riwayat_ba_pengawas
        $this->dbforge->create_table("riwayat_ba_pengawas", TRUE, $attributes);
    }

    /**
     * down (drop table)
     *
     * @return void
     */
    public function down()
    {
        // Drop table riwayat_ba_pengawas
        $this->dbforge->drop_table("riwayat_ba_pengawas", TRUE);
    }
}
