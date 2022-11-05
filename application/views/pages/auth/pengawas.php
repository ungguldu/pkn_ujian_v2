<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?= form_open('', 'class="card card-md" name="authPengawas"'); ?>
<div class="card-body">
    <h2 class="text-center mb-4">Login Pengawas</h2>
    <?= (show_alert()) ? show_alert() : ''; ?>
    <div class="mb-3">
        <label class="form-label">Kode Pengawas</label>
        <input type="text" name="kode_pengawas" id="kode_pengawas" class="form-control<?= !empty(form_error('kode_pengawas')) ? ' is-invalid' : ''; ?>" placeholder="masukkan kode pengawas .. " autocomplete="off" autofocus value="<?= set_value('kode_pengawas'); ?>">
        <?= form_error('kode_pengawas'); ?>
    </div>
    <div class="mb-3">
        <label class="form-label">Kode Keamanan</label>
        <input type="password" name="pass_key" id="pass_key" class="form-control<?= !empty(form_error('pass_key')) ? ' is-invalid' : ''; ?>" placeholder="masukkan kode keamanan .. " autocomplete="off" value="<?= set_value('pass_key'); ?>">
        <?= form_error('pass_key'); ?>
    </div>
    <div class="form-footer">
        <button type="submit" class="btn btn-primary w-100">Masuk</button>
    </div>
</div>
<?= form_close(); ?>