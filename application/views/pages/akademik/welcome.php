<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="card">
    <div class="card-body">
        <div>
            <h3 class="mb-3">Setting Aplikasi</h3>
            <div class="alert alert-<?= empty($setting) ? 'danger' : 'info'; ?>" role="alert">
                <div class="d-flex">
                    <div>
                        <span class="avatar float-start me-3">
                            <i class="icon ti ti-home-exclamation text-warning icon-tada"></i>
                        </span>
                    </div>
                    <div>
                        <p class="mb-0"> Lengkapi setting aplikasi berikut sebelum memulai ujian! Cek masing-masing kategori setting.</p>
                        <p class="mb-0">
                            <strong class="text-info">Lewati halaman ini jika setting sudah fix!</strong>
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-auto col-md-8 mb-3">
                    <div id="faq-1" class="accordion" role="tablist" aria-multiselectable="true">
                        <div class="accordion-item">
                            <div class="accordion-header" role="tab">
                                <button class="accordion-button" data-bs-toggle="collapse" data-bs-target="#faq-1-1" aria-expanded="true">Nama Aplikasi</button>
                            </div>
                            <div id="faq-1-1" class="accordion-collapse collapse show" role="tabpanel" data-bs-parent="#faq-1">
                                <div class="accordion-body pt-0">
                                    <div>
                                        <p>Nama Ujian digunakan sebagai judul pada setiap halaman atau sebagai pembeda dari beberapa ujian yang memakai aplikasi ini.</p>
                                        <?= form_open('welcome/simpan_setting', 'name="namaApps"'); ?>
                                        <div class="mb-3">
                                            <label class="form-label">Nama Aplikasi</label>
                                            <input type="text" class="form-control" name="nama_aplikasi" placeholder="ujian uts th ..." value="<?= set_value('nama_aplikasi', $setting && !empty($setting['nama_aplikasi']) ? $setting['nama_aplikasi'] : ''); ?>" required>
                                        </div>
                                        <div>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                        <?= form_close(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <div class="accordion-header" role="tab">
                                <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#faq-1-2" aria-expanded="false">Sesi Ujian</button>
                            </div>
                            <div id="faq-1-2" class="accordion-collapse collapse" role="tabpanel" data-bs-parent="#faq-1">
                                <div class="accordion-body pt-0">
                                    <div>
                                        <p>Setting sesi ujian apakah form pilihan sesi ditampilkan pada login peserta. Serta isian data urutan sesi.</p>
                                    </div>
                                    <?= form_open('welcome/simpan_setting', 'name="setSesi"'); ?>
                                    <div class="mb-3">
                                        <div class="form-label">Tampilkan Form Sesi <small class="text-muted">default: tidak</small></div>
                                        <div>
                                            <label class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="sesi_ditampilkan" value="1" <?= set_radio('sesi_ditampilkan', '1', !empty($setting) && array_key_exists('sesi_ditampilkan', $setting) && $setting['sesi_ditampilkan'] == '1' ? true : false); ?> required>
                                                <span class="form-check-label">Ya</span>
                                            </label>
                                            <label class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="sesi_ditampilkan" value="0" <?= set_radio('sesi_ditampilkan', '0', !empty($setting) && array_key_exists('sesi_ditampilkan', $setting) && ($setting['sesi_ditampilkan'] == '0') ? true : false); ?> required>
                                                <span class="form-check-label">Tidak</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-auto">
                                            <label class="form-label">Sesi Pertama</label>
                                            <input type="number" min="1" class="form-control" name="sesi_awal" placeholder="1" value="<?= set_value('sesi_awal', $setting && !empty($setting['sesi_awal']) ? $setting['sesi_awal'] : '') ?>" required>
                                        </div>
                                        <div class="col-auto">
                                            <label class="form-label">Sesi Terakhir</label>
                                            <input type="number" min="1" class="form-control" name="sesi_akhir" placeholder="18" value="<?= set_value('sesi_akhir', $setting && !empty($setting['sesi_akhir']) ? $setting['sesi_akhir'] : '') ?>" required>
                                        </div>
                                        <div class="col-auto">
                                            <label class="form-label required">Durasi Pengumpulan Jawaban <small class="text-muted">dalam menit</small></label>
                                            <input type="number" min="1" class="form-control" name="durasi_pengumpulan" value="<?= set_value('durasi_pengumpulan', $setting && !empty($setting['durasi_pengumpulan']) ? $setting['durasi_pengumpulan'] : '') ?>" placeholder="20" required>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                    <?= form_close(); ?>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <div class="accordion-header" role="tab">
                                <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#faq-1-3" aria-expanded="false">Narasi Berita Acara</button>
                            </div>
                            <div id="faq-1-3" class="accordion-collapse collapse" role="tabpanel" data-bs-parent="#faq-1">
                                <div class="accordion-body pt-0">
                                    <div>
                                        <p>Lengkapi Isian berikut untuk melengkapi narasi Berita Acara yang akan dibuat.</p>
                                    </div>
                                    <?= form_open('welcome/simpan_setting', 'name="setBA"'); ?>
                                    <div class="mb-3">
                                        <label class="form-label">Nama Ujian</label>
                                        <input type="text" class="form-control" name="nama_ujian" placeholder="Ujian uas/uts/sertifikasi ..." value="<?= set_value('nama_ujian', (!empty($setting) && !empty($setting['nama_ujian'])) ? $setting['nama_ujian'] : ''); ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                    <?= form_close(); ?>
                                </div>
                            </div>
                        </div>
                    </div> <!-- accordion -->
                </div> <!-- col-8 -->
                <div class="col-12 col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h4>Data Setting Aplikasi</h4>
                            <?php if (!empty($setting)) : ?>
                                <?php foreach ($setting as $i => $item) : ?>
                                    <p class="mb-1">
                                        <dd class="datagrid-title"><?= humanize($i); ?></dd>
                                        <dt><?= $item; ?></dt>
                                    </p>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <div class="empty">
                                    <div class="empty-img">
                                        <img src="<?= base_url('assets/img/no_data.gif') ?>" alt="" height="128">
                                    </div>
                                    <p class="empty-title text-warning">Aplikasi belum disetting!<br>Lengkapi data setting.</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div> <!-- col-12 -->
            </div> <!-- row -->

        </div>
    </div>
</div>