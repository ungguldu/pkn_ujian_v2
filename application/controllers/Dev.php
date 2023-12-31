<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dev extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (ENVIRONMENT !== 'development' or !$this->input->is_cli_request()) {
            redirect('auth', 'auto', 301);
        }
        // load library
        $this->load->library(['authit', 'migration', 'cli']);
    }

    public function index()
    {
        $this->cli->log('Admin developing tools - Apps ujian Local LAN', 'light_green');
        // gen migrasi
        $this->cli->log('Untuk membuat file migrasi gunakan perintah >', false);
        $this->cli->log(' php index.php dev gen_migrate $table ', 'white', true, 'blue');
        // gen user
        $this->cli->log('Untuk membuat file migrasi gunakan perintah >', false);
        $this->cli->log(' php index.php dev gen_user $email $password ', 'white', true, 'blue');
        // do migration
        $this->cli->log('Untuk membuat file migrasi gunakan perintah >', false);
        $this->cli->log(' php index.php dev do_migration $version ', 'white', true, 'blue');
        // undo migration
        $this->cli->log('Untuk membuat file migrasi gunakan perintah >', false);
        $this->cli->log(' php index.php dev undo_migration $version ', 'white', true, 'blue');
        // reset migration
        $this->cli->log('Untuk membuat file migrasi gunakan perintah >', false);
        $this->cli->log(' php index.php dev reset_migration ', 'white', true, 'blue');
        $this->cli->log('', true);
        // other
        $this->cli->bell();
        $this->cli->log('fitur lain dalam pengembangan.', 'red');
    }

    public function gen_migration(string $table = null)
    {
        // cek param tabel
        empty($table) and exit('parameter table harus diisi!');
        // kondisikan param tabel
        !empty($table) and $table == 'all' ? $table = '*' : $table;
        // load library
        $this->load->library('Migration_generator');
        if (isset($table) and $this->migration_generator->generate($table)) {
            $this->cli->log('------------ File Migrasi tabel ' . $table . ' berhasil digenerate --------------', 'light_green');
        } else {
            $this->cli->log('!!!!!!!!!!!!!!!! File Migrasi gagal digenerate !!!!!!!!!!!!!!!!', 'light_green');
        }
    }

    public function gen_user(string $email = null, string $password = null)
    {
        $this->authit->register(urldecode($email), urldecode($password));
        $this->cli->log('------------ User berhasil digenerate --------------', 'light_green');
    }

    public function do_migration(string $version = null): bool
    {
        if (isset($version) && ($this->migration->version($version) === false)) {
            show_error($this->migration->error_string());
            return false;
        } elseif (is_null($version) && $this->migration->latest() === false) {
            show_error($this->migration->error_string());
            return false;
        } else {
            $this->cli->log('✅ The migration has concluded successfully.', 'light_green');
            return true;
        }
    }

    /**
     * Methode Undo
     * Melakukan pembatalan migrasi. Jika param null akan dimigrasi ke file migrasi urutan sebelumnya.
     * @param string $version
     * @return void
     */
    public function undo_migration(string $version = null)
    {
        $migrations = $this->migration->find_migrations();
        $migration_keys = array();
        foreach ($migrations as $key => $migration) {
            $migration_keys[] = $key;
        }
        if (isset($version) && array_key_exists($version, $migrations) && $this->migration->version($version)) {
            $this->cli->log('✅ Migrasi database berhasil direst ke versi: ' . $version, 'light_green');
            return true;
        } elseif (isset($version) && !array_key_exists($version, $migrations)) {
            $this->cli->log('🕵️ Migrasi versi: ' . $version . ' tidak ditemukan', 'red');
        } else {
            // Jika jumlah migrasi = 1 maka versi migrasi di 0 kan. jika lebih dari 1, mak migration ke key sebelumnya.
            $penultimate = (sizeof($migration_keys) == 1) ? 0 : $migration_keys[sizeof($migration_keys) - 2];
            if ($this->migration->version($penultimate)) {
                $this->cli->log('✅ Migrasi database berhasil dirollback.', 'light_green');
                exit;
            } else {
                $this->cli->log('🚫 Migrasi gagal dirollback! Ulangi kembali', 'red');
                exit;
            }
        }
    }

    /**
     * Fungsi Reset Migration
     * fungsi ini menjalankan reset migration sesuai versi pada migration
     * config. Jika ada table yang hendak di "keep" ubah migration config
     * sesuai dengan file migrasinya.
     *
     * @return true
     */

    public function reset_migration(): bool
    {
        if ($this->migration->current() !== false) {
            $this->cli->log('👌 Migrasi database berhasil direst sesuai config file.', 'light_green');
            return true;
        } else {
            $this->cli->log('🚫 Migrasi database gagal direst! Ulangi kembali', 'red');
            show_error($this->migration->error_string());
            return false;
        }
    }

    public function new_ujian(): void
    {
        $a = readline('Yakin memulai ujian baru? default[0, 1]: ');
        if(intval($a) == 1){
            // pindahkan hasil dan copi file database
            if(!$this->move_hasil()) { 
                $this->cli->log('Folder hasil ujian sebelumnya gagal pindahkan!', 'light_red');
                exit;
            }
            // reconnect DB
            $this->db->reconnect();
            // migrasikan DB
            if($this->reset_migration()) { 
                $this->do_migration();
                exit;
            }
        }
        $this->cli->log('Perintah dibatalkan!', 'yellow');
    }

    public function unzip_write(): bool
    {
        $write    = realpath(APPPATH);
        $root_dir = dirname($write, 1) . DIRECTORY_SEPARATOR;
        $file     = $root_dir . 'writeable.zip';
        
        $this->cli->log('memproses unzip ...', 'yellow');

        $zip = new ZipArchive;
        $res = $zip->open($file);
        if ($res === TRUE) {
            $zip->extractTo($root_dir);
            $zip->close();
            $this->cli->log('writeable folder unzipped', 'light_green'). PHP_EOL;
            return true;
        } else {
            $this->cli->log('UNZIP Failed!!!!', 'light_red') . PHP_EOL;
            return false;
        }
    }

    public function move_hasil(): bool
    {
        $write    = realpath(APPPATH);
        $root_dir = dirname($write, 1) . DIRECTORY_SEPARATOR;

        $db_ori = $root_dir.'database.php.ori';
        $db_ori_to = APPPATH.'config'.DIRECTORY_SEPARATOR.'database.php';

        $a = readline('Yakin pindah hasil ujian sebelumnya? [0, 1]: ');
        if (intval($a) == 1) {
            $write     = $root_dir.'writeable';
            if (is_dir($write)) {
                // rename folder writeable
                rename($write, $write . '_old_' . date('Ymdhis'));
                rename($db_ori_to, $db_ori_to . '.old');
                // copy config database ori
                copy($db_ori, $root_dir.'database.php');
                rename($root_dir.'database.php', $db_ori_to);
                return $this->unzip_write();
            }
            return $this->unzip_write();
        }
        return false;
    }
}

/* End of file Dev.php */