<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="row row-cards row-deck">
    <div class="col-12 col-md-4">
        <div class="card">
            <div class="card-stamp">
                <div class="card-stamp-icon bg-yellow">
                    <i class="ti ti-users text-white h-50 m-auto"></i>
                </div>
            </div>
            <div class="card-body">
                <h3 class="card-title">Upload Data Mahasiswa</h3>
                <div class="text-muted">Gunakan form dibawah ini untuk upload data mahasiswa.</div>
                <?php if (empty($mahasiswa) and $mahasiswa < 1) : ?>
                    <?= form_open_multipart('akademik/upload/mahasiswa', 'name="Uploadmahasiswa"'); ?>
                    <div class="mb-3">
                        <div class="form-label">Upload data mata kuliah</div>
                        <input type="file" name="upload_mahasiswa" class="form-control" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
                    </div>
                    <div class="mt-2">
                        <button type="submit" class="btn btn-primary">Upload</button>
                        <button type="reset" class="btn btn-light">Reset</button>
                    </div>
                    <?= form_close(); ?>
                <?php else : ?>
                    <div class="alert alert-info mt-3" role="alert">
                        <div class="d-flex">
                            <div>
                                <h4 class="alert-title">Data mahasiswa sudah diupload.</h4>
                                <div class="text-muted">
                                    Data mahasiswa tersimpan di database sebanyak <strong><?= $mahasiswa; ?></strong>. <br>
                                    Jika Anda ingin mengubah data mahasiswa klik tombol reset dibawah ini. Upload ulang data mahasiswa yang baru.
                                </div>
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <?= form_open('akademik/reset_data', 'name="resetDbJadwal"', ['table' => 'mahasiswa']); ?>
                                        <button type="submit" class="btn btn-light">reset data mahasiswa</button>
                                        <?= form_close(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="card">
            <div class="card-stamp">
                <div class="card-stamp-icon bg-pink">
                    <i class="ti ti-books text-white h-50 m-auto"></i>
                </div>
            </div>
            <div class="card-body">
                <h3 class="card-title">Upload Data Mata Kuliah</h3>
                <div class="text-muted">Gunakan form berikut untuk upload data mata kuliah.</div>
                <?php if (empty($mata_kuliah) and $mata_kuliah < 1) : ?>
                    <?= form_open_multipart('akademik/upload/matkul', 'name="UploadMatkul"'); ?>
                    <div class="mb-3">
                        <div class="form-label">Upload data mata kuliah</div>
                        <input type="file" name="upload_matkul" class="form-control" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
                    </div>
                    <div class="mt-2">
                        <button type="submit" class="btn btn-primary">Upload</button>
                        <button type="reset" class="btn btn-light">Reset</button>
                    </div>
                    <?= form_close(); ?>
                <?php else : ?>
                    <div class="alert alert-info mt-3" role="alert">
                        <div class="d-flex">
                            <div>
                                <h4 class="alert-title">Data mata kuliah sudah diupload.</h4>
                                <div class="text-muted">
                                    Data mata kuliah tersimpan di database sebanyak <strong><?= $mata_kuliah; ?></strong>. <br>
                                    Jika Anda ingin mengubah data mata kuliah klik tombol reset dibawah ini. Upload ulang data mata kuliah yang baru.
                                </div>
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <?= form_open('akademik/reset_data', 'name="resetDbJadwal"', ['table' => 'mata_kuliah']); ?>
                                        <button type="submit" class="btn btn-light">reset data mata kuliah</button>
                                        <?= form_close(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="card">
            <div class="card-stamp">
                <div class="card-stamp-icon bg-blue">
                    <i class="ti ti-calendar text-white h-50 m-auto"></i>
                </div>
            </div>
            <div class="card-body">
                <h3 class="card-title">Upload Data Jadwal Ujian</h3>
                <div class="text-muted">Gunakan form berikut untuk upload data jadwal ujian</div>
                <?php if (empty($jadwal_ujian) and $jadwal_ujian < 1) : ?>
                    <?= form_open_multipart('akademik/upload/jadwal', 'name="UploadJadwal"'); ?>
                    <div class="mb-3">
                        <div class="form-label">Upload data jadwal ujian</div>
                        <input type="file" name="upload_jadwal" class="form-control" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
                    </div>
                    <div class="mt-2">
                        <button type="submit" class="btn btn-primary">Upload</button>
                        <button type="reset" class="btn btn-light">Reset</button>
                    </div>
                    <?= form_close(); ?>
                <?php else : ?>
                    <div class="alert alert-info mt-3" role="alert">
                        <div class="d-flex">
                            <div>
                                <h4 class="alert-title">Data jadwal ujian sudah diupload.</h4>
                                <div class="text-muted">
                                    Data jadwal ujian tersimpan di database sebanyak <strong><?= $jadwal_ujian; ?></strong>. <br>
                                    Jika Anda ingin mengubah jadwal klik tombol reset dibawah ini. Upload ulang data jadwal ujian yang baru.
                                </div>
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <?= form_open('akademik/reset_data', 'name="resetDbJadwal"', ['table' => 'jadwal_ujian']); ?>
                                        <button type="submit" class="btn btn-light">reset data jadwal</button>
                                        <?= form_close(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title">Daftar File Data yang Telah Diupload</div>
                <div class="divide-y m-3">
                    <div>
                        <?php if (!empty($files) and count($files) > 0) :
                            foreach ($files as $file) :
                        ?>
                                <div class="row mb-3">
                                    <div class="col-auto">
                                        <span class="avatar bg-green-lt">
                                            <i class="icon ti ti-file"></i>
                                        </span>
                                    </div>
                                    <div class="col">
                                        <div class="text-truncate">
                                            <strong><?= $file ?></strong>
                                        </div>
                                        <div class="text-muted">
                                            <?php
                                            $time = explode('_', $file);
                                            echo tanggal_panjang(date('Y-m-d H:i:s', $time[0]), true);
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-auto align-self-center">
                                        <a href="<?= site_url('akademik/hapus_file?file=' . $file); ?>" class="badge bg-danger">
                                            <i class="icon ti ti-trash"></i>
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <div class="row">
                                <div class="col-auto">
                                    <span class="avatar bg-red-lt">
                                        <i class="icon ti ti-file-off"></i>
                                    </span>
                                </div>
                                <div class="col">
                                    <div class="text-truncate">
                                        no data!
                                    </div>
                                    <div class="text-muted"><span class="text-muted">Tidak data file data yang diupload</span></div>
                                </div>
                                <div class="col-auto align-self-center"></div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>