<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_riwayat_presensi extends CI_Migration
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
                'constraint' => '12',
                'null' => TRUE,
            ),
            'program_studi' => array(
                'type' => 'VARCHAR',
                'constraint' => '200',
                'null' => TRUE,
            ),
            'kelas' => array(
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => TRUE,
            ),
            'id_ujian' => array(
                'type' => 'INT',
                'constraint' => '11',
                'null' => TRUE,
            ),
            'mata_kuliah' => array(
                'type' => 'VARCHAR',
                'constraint' => '200',
                'null' => TRUE,
            ),
            'presensi_pada datetime default current_timestamp',
            'ip_address' => array(
                'type' => 'VARCHAR',
                'constraint' => '16',
                'null' => TRUE,
            ),
        ));

        // Add Primary Key.
        $this->dbforge->add_key("id", TRUE);

        // Table attributes.

        $attributes = array(
            'ENGINE' => 'InnoDB',
            'COMMENT' => '\'untuk mencatat presensi peserta ujian ketika membuka soal pada kesempatan pertama\'',
        );

        // Create Table riwayat_presensi
        $this->dbforge->create_table("riwayat_presensi", TRUE, $attributes);

    }

    /**
     * down (drop table)
     *
     * @return void
     */
    public function down()
    {
        // Drop table riwayat_presensi
        $this->dbforge->drop_table("riwayat_presensi", TRUE);
    }

}
