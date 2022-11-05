<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?= form_open('', 'class="card card-md" name="auth_mahasiswa"'); ?>
<div class="card-body">
    <h2 class="text-center card-title mb-4 font-uppercase">Login Admin</h2>
    <?= (show_alert()) ? show_alert() : ''; ?>
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="text" name="email" id="email" class="form-control<?= !empty(form_error('email')) ? ' is-invalid' : ''; ?>" placeholder="masukkan email .. " autocomplete="off" autofocus value="<?= set_value('email'); ?>">
        <?= form_error('email'); ?>
    </div>
    <div class="mb-3">
        <label class="form-label">Kode Keamanan</label>
        <input type="password" name="password" id="password" class="form-control<?= !empty(form_error('password')) ? ' is-invalid' : ''; ?>" placeholder="masukkan kode keamanan .. " autocomplete="off" value="<?= set_value('password'); ?>">
        <?= form_error('password'); ?>
    </div>
    <div class="form-footer">
        <button type="submit" class="btn btn-primary w-100">Masuk</button>
    </div>
</div>
<?= form_close(); ?>