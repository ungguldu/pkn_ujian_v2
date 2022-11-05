<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?= form_open('', 'class="card card-md" name="auth_mahasiswa"'); ?>
<div class="card-body">
    <h2 class="text-center mb-4">Login</h2>
    <?= (show_alert()) ? show_alert() : ''; ?>
    <div class="mb-3">
        <label class="form-label">Nomor Induk Mahasiswa (NIM)</label>
        <input type="text" name="nim" id="nim" class="form-control<?= !empty(form_error('nim')) ? ' is-invalid' : ''; ?>" placeholder="masukkan NIM .. " autocomplete="off" autofocus value="<?= set_value('nim'); ?>">
        <?= form_error('nim'); ?>
    </div>
    <div class="mb-3">
        <label class="form-label">Kode Keamanan</label>
        <input type="password" name="pass_key" id="pass_key" class="form-control<?= !empty(form_error('pass_key')) ? ' is-invalid' : ''; ?>" placeholder="masukkan kode keamanan .. " autocomplete="off" value="<?= set_value('pass_key'); ?>">
        <?= form_error('pass_key'); ?>
    </div>
    <div class="mb-3">
        <div class="form-label">Sesi</div>
        <?php
        $options = [1 => '1', 2 => '2', 3 => '3', 4 => '4', 5 => '5'];
        echo form_dropdown('sesi', $options, set_value('sesi'), 'class="form-select" name="sesi"');
        echo form_error('sesi');
        ?>
    </div>
    <div class="form-footer">
        <button type="submit" class="btn btn-primary w-100">Mulai Ujian</button>
    </div>
</div>
<?= form_close(); ?>