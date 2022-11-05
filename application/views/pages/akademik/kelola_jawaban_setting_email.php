<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-12 col-md-6 mb-3">
        <div class="card">
            <div class="card-body">
                <div class="card-title">Setting Email</div>
                <?php if (!empty($email_setting) and empty($mode)) : ?>
                    <div class="my-3">
                        <div class="alert alert-success" role="alert">
                            <h4 class="alert-title">OK! Setting email telah diset.</h4>
                            <div class="text-muted">
                                Pengaturan kirim email telah diset.
                                Detail pengaturan yang disimpan sebagai berikut: <br />
                                <pre class="my-3"><code><?= json_encode(json_decode($email_setting->isi), JSON_PRETTY_PRINT); ?></code></pre>
                                Klik pada tautan berikut untuk mengupdate data pengaturan email. Update <a href="<?= site_url('kelola_jawaban/setting_email/update'); ?>" class="btn-link">disini</a>.
                            </div>
                        </div>
                    </div>
                <?php else : ?>
                    <?= form_open('', 'name="configEmail"'); ?>
                    <?php if (!empty($email_setting)) {
    $set = !empty($email_setting->isi) ? (array) json_decode($email_setting->isi) : [];
} ?>
                    <div class="form-group mb-3 row">
                        <label class="form-label col-3 col-form-label">SMTP Host</label>
                        <div class="col">
                            <input type="text" name="smtp_host" id="smtp_host" class="form-control<?= !empty(form_error('smtp_host')) ? ' is-invalid' : ''; ?>" aria-describedby="smtp" placeholder="contoh: smtp.gmail.com" value="<?= set_value('smtp_host', !empty($set['smtp_host']) ? $set['smtp_host'] : '', true); ?>">
                            <?= form_error('smtp_host'); ?>
                            <small class="form-hint">adalah alamat domain smtp yang digunakan. contoh: smtp.gmail.com. atau cari pada google smtp provider email anda.</small>
                        </div>
                    </div>
                    <div class="form-group mb-3 row">
                        <label class="form-label col-3 col-form-label">Alamat Email</label>
                        <div class="col">
                            <input type="email" name="smtp_email" id="smtp_email" value="<?= set_value('smtp_email', !empty($set['smtp_email']) ? $set['smtp_email'] : '', true); ?>" class="form-control<?= !empty(form_error('smtp_email')) ? ' is-invalid' : ''; ?>" aria-describedby="email" placeholder="xxx@zxy.com">
                            <?= form_error('smtp_email'); ?>
                            <small class="form-hint">adalah alamat email yang akan digunakan sebagai pengirim.</small>
                        </div>
                    </div>
                    <div class="form-group mb-3 row">
                        <label class="form-label col-3 col-form-label">Password</label>
                        <div class="col">
                            <input type="password" name="smtp_password" id="smtp_password" class="form-control<?= !empty(form_error('smtp_password')) ? ' is-invalid' : ''; ?>" placeholder="*******" value="<?= set_value('smtp_password', !empty($set['smtp_password']) ? $set['smtp_password'] : '', true); ?>">
                            <?= form_error('smtp_password'); ?>
                            <small class="form-hint">adalah password email yang digunakan.</small>
                        </div>
                    </div>
                    <div class="form-group mb-3 row">
                        <div class="form-label col-3 col-form-label">Secure Type</div>
                        <div class="col">
                            <label class="form-check form-check-inline">
                                <input name="smtp_sec" class="form-check-input" type="radio" value="smtp" <?= (!empty($set['smtp_sec']) and $set['smtp_sec'] === 'smtp' or set_value('smtp_sec') === 'smtp' or empty(set_value('smtp_sec'))) ? 'checked' : '' ?>>
                                <span class="form-check-label">SMTP</span>
                            </label>
                            <label class="form-check form-check-inline">
                                <input name="smtp_sec" class="form-check-input" type="radio" value="tls" <?= (!empty($set['smtp_sec']) and $set['smtp_sec'] === 'tls' or set_value('smtp_sec') === 'tls') ? 'checked' : '' ?>>
                                <span class="form-check-label">TLS</span>
                            </label>
                            <small class="form-hint">adalah tipe pengamanan pada SMTP host Anda. Biarkan default atau pilih opsi yang tersedia. tipe SMTP menggunakan port 465 sedangkan TLS menggunakan port 587.</small>
                        </div>
                    </div>
                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary">Simpan Setting</button>
                        <button type="reset" class="btn">Reset</button>
                    </div>
                    <?= form_close(); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="card-title">Tes Kirim Email</div>
                <?php if (empty($email_setting)) : ?>
                    <div class="my-3">
                        <div class="alert alert-warning" role="alert">
                            <h4 class="alert-title">Pengaturan email belum diset!</h4>
                            <div class="text-muted">Maaf! fitur tes kirim email hanya bisa digunakan jika setting email sudah diset.</div>
                        </div>
                    </div>
                <?php else : ?>
                    <p class="text-muted my-3">
                        Gunakan fitur ini untuk mengecek apakah setting email yang Anda masukkan sudah benar.<br />
                        Pengaturan email yang benar ditandai dengan terkirimnya pesan ke alamat email yang Anda tuju.
                    </p>
                    <?= form_open('kelola_jawaban/kirim_email/test'); ?>
                    <div class="form-group mb-3 row">
                        <label class="form-label col-4 col-form-label">Masukkan Email</label>
                        <div class="col">
                            <input type="email" name="email_test" class="form-control" aria-describedby="email" placeholder="other@zxy.com">
                            <small class="form-hint">Gunakan alamat email selain yang diset pada pengaturan!</small>
                        </div>
                    </div>
                    <div class="form-group mb-3 row">
                        <div class="col-4"></div>
                        <div class="col">
                            <button class="btn btn-success">Kirim Email Uji Coba</button>
                        </div>
                    </div>
                    <?= form_close(); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>