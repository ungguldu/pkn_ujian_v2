<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="card">
    <div class="card-body">
        <div class="card-title">Formulir <?= ucfirst($act); ?> Data Pengawas</div>
        <p class="text-muted">
            Gunakan formulir dibawah ini untuk melengkapi data isian pengawas.
        </p>
        <div class="my-3">
            <?= form_open('', 'name="form_pengawas"'); ?>
            <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Nama Lengkap</label>
                <div class="col">
                    <input type="text" class="form-control<?= !empty(form_error('nama_lengkap')) ? ' is-invalid' : ''; ?>" name="nama_lengkap" placeholder="Nama Lengkap" value="<?= set_value('nama_lengkap', !empty($nama_lengkap) ? $nama_lengkap : ''); ?>" autofocus>
                    <?= form_error('nama_lengkap'); ?>
                </div>
            </div>
            <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Kode Pengawas</label>
                <div class="col">
                    <input type="text" class="form-control<?= !empty(form_error('kode_pengawas')) ? ' is-invalid' : ''; ?>" name="kode_pengawas" placeholder="Kode Pengawas" value="<?= set_value('kode_pengawas', !empty($kode_pengawas) ? $kode_pengawas : ''); ?>">
                    <?= form_error('kode_pengawas'); ?>
                </div>
            </div>
            <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">NIK</label>
                <div class="col">
                    <input type="text" class="form-control<?= !empty(form_error('nik')) ? ' is-invalid' : ''; ?>" name="nik" placeholder="NIK" value="<?= set_value('nik', !empty($nik) ? $nik : ''); ?>">
                    <?= form_error('nik'); ?>
                </div>
            </div>
            <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Pilih Program Studi</label>
                <div class="col">
                    <?php
                    $selected_prodi = set_value('program_studi', !empty($program_studi) ? $program_studi : '');
                    echo form_dropdown('program_studi', $opt_prodi, $selected_prodi, 'class="form-select" placeholder="Pilih program studi" id="program_studi"');
                    ?>
                    <?= form_error('program_studi'); ?>
                </div>
            </div>
            <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Pilih Kelas</label>
                <div class="col">
                    <?php
                    $selected_kelas = set_value('kelas', !empty($kelas) ? $kelas : '');
                    if (empty($selected_kelas)) {
                        $opt_kel = ['' => 'Pilih kelas'];
                    } else {
                        $kel_avail = (array) json_decode($opt_kelas);
                        $kel_prodi = $kel_avail[$selected_prodi];
                        $opt_kel = ['' => 'Pilih kelas'];
                        foreach ($kel_prodi as $item) {
                            $opt_kel[$item] = $item;
                        }
                    }

                    echo form_dropdown('kelas', $opt_kel, $selected_kelas, 'class="form-select" placeholder="Pilih program studi" id="kelas"');
                    ?>
                    <?= form_error('kelas'); ?>
                </div>
            </div>
            <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Pilih Jadwal</label>
                <div class="col">
                    <?php
                    $selected_jadwal = set_value('id_jadwal', !empty($id_jadwal) ? $id_jadwal : '');
                    if (empty($selected_jadwal)) {
                        $opt_jad = ['' => 'Pilih jadwal'];
                    } else {
                        $jad_avail = (array) json_decode($opt_jadwal);
                        $jad_prodi = $jad_avail[$selected_prodi];
                        $opt_jad = ['' => 'Pilih jadwal'];
                        foreach ($jad_prodi as $item) {
                            $opt_jad[$item->id] = $item->mata_kuliah;
                        }
                    }
                    echo form_dropdown('id_jadwal', $opt_jad, $selected_jadwal, 'class="form-select" placeholder="Pilih id_jadwal" id="id_jadwal"');
                    ?>
                    <?= form_error('id_jadwal'); ?>
                </div>
            </div>
            <div class="form-group row">
                <label class="form-label col-3 col-form-label pt-0">Aktif</label>
                <div class="col">
                    <label class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="status" value="1" <?= (set_value('status', $status ?? 0)) ? 'checked' : ''; ?>>
                        <span class="form-check-label">Aktifkan</span>
                    </label>
                    <?= form_error('status'); ?>
                </div>
            </div>
            <div class="form-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="<?= site_url('akademik/pengawas') ?>" class="btn">Batal</a>
            </div>
            </form>
        </div>

    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var kelas = <?= $opt_kelas; ?>;
        var jadwal = <?= $opt_jadwal; ?>;

        document.getElementById('program_studi').addEventListener('change', function() {
            let val = this.value;
            let optj = jadwal[val];
            let selj = <?= set_value('id_jadwal') ?: '""'; ?>;
            let optk = kelas[val];
            let selk = <?= set_value('kelas') ?: '""'; ?>;
            let sel_jadwal = document.getElementById('id_jadwal');
            let sel_kelas = document.getElementById('kelas');

            sel_jadwal.innerHTML = '<option>Pilih jadwal </option>';
            sel_kelas.innerHTML = '<option>Pilih kelas </option>';

            for (var i = 0; i < optj.length; i++) {
                var optn = optj[i];
                var el = document.createElement("option");
                el.textContent = optn.mata_kuliah;
                el.value = optn.id;
                if (selj !== null && selj === optn) el.selected = true;
                sel_jadwal.appendChild(el);
            }

            for (var i = 0; i < optk.length; i++) {
                var optn = optk[i];
                var el = document.createElement("option");
                el.textContent = optn;
                el.value = optn;
                if (selk !== null && selk === optn) el.selected = true;
                sel_kelas.appendChild(el);
            }
        });
    })
</script>