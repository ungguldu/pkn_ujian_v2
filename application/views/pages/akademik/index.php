<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="row row-cards row-deck">
    <div class="col-12 col-md-8">
        <div class="card">
            <div class="card-stamp">
                <div class="card-stamp-icon bg-blue">
                    <i class="ti ti-upload text-white h-75 m-auto"></i>
                </div>
            </div>
            <div class="card-body">
                <h3 class="card-title">Upload Data</h3>
                <p>Lengkapi opsi kategori data dan pilih file pada formulir berikut.</p>
                <?= form_open_multipart('akademik/upload', 'name="UploadData"'); ?>
                <div class="row row-cards">
                    <div class="mb-3 col-sm-6 col-md-4">
                        <label class="form-label required">Kategori Data</label>
                        <select class="form-select" name="kategori_data" id="kategori_data">
                            <option value="" selected="">pilih kategori ..</option>
                            <?= empty($krs_mahasiswa) ? '<option value="krs_mahasiswa">KRS Mahasiswa</option>' : ''; ?>
                            <option value="jadwal">Jadwal</option>
                        </select>
                    </div>
                    <div class="mb-3 col-sm-6 col-md-8">
                        <div class="form-label">Pilih file</div>
                        <input type="file" class="form-control" id="upload_data">
                    </div>
                    <div class="col-sm-12 col-md-12">
                        <button type="submit" class="btn btn-primary">Upload</button>
                        <button type="reset" class="btn">Reset</button>
                    </div>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="card">
            <div class="card-stamp">
                <div class="card-stamp-icon bg-green">
                    <i class="ti ti-table text-white h-50 m-auto"></i>
                </div>
            </div>
            <div class="card-body">
                <h3 class="card-title">Data telah diupload</h3>
                <p>Berikut rincian data yang telah diupload:</p>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Data</th>
                                <th>Total data</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="<?= empty($krs_mahasiswa) ? 'bg-red-lt' : 'bg-green-lt' ?>">
                                <td>KRS Mahasiswa</td>
                                <?php if (!empty($krs_mahasiswa)) : ?>
                                    <td><?= $krs_mahasiswa; ?></td>
                                    <td>
                                        <?= form_open('akademik/reset_data', 'name="resKrs"', ['table' => 'krs_mahasiswa']); ?>
                                        <button type="sumbit" class="btn btn-sm btn-warning btn-icon" data-bs-toggle="tooltip" data-bs-placement="bottom" aria-label="Reset tabel?" data-bs-original-title="Reset tabel KRS?">
                                            <i class="ti ti-refresh"></i>
                                        </button>
                                        <?= form_close(); ?>
                                    </td>
                                <?php else : ?>
                                    <td><?= $krs_mahasiswa; ?></td>
                                    <td></td>
                                <?php endif; ?>
                            </tr>
                            <tr class="<?= empty($jadwal_ujian) ? 'bg-red-lt' : 'bg-green-lt' ?>">
                                <td>Jadwal Ujian</td>
                                <?php if (!empty($jadwal_ujian)) : ?>
                                    <td><?= $jadwal_ujian; ?></td>
                                    <td><?= form_open('akademik/reset_data', 'name="resJadwal"', ['table' => 'jadwal_ujian']); ?>
                                        <button type="submit" class="btn btn-sm btn-warning btn-icon" data-bs-toggle="tooltip" data-bs-placement="bottom" aria-label="Reset tabel?" data-bs-original-title="Reset tabel jadwal?">
                                            <i class="ti ti-refresh"></i>
                                        </button>
                                        <?= form_close(); ?>
                                    </td>
                                <?php else : ?>
                                    <td><?= $jadwal_ujian; ?></td>
                                    <td></td>
                                <?php endif; ?>
                            </tr>
                            <tr class="<?= empty($mata_kuliah) ? 'bg-red-lt' : 'bg-green-lt' ?>">
                                <td>Mata Kuliah</td>
                                <?php if (!empty($mata_kuliah)) : ?>
                                    <td><?= $mata_kuliah; ?></td>
                                    <td><?= form_open('akademik/reset_data', 'name="resJadwal"', ['table' => 'mata_kuliah']); ?>
                                        <button type="submit" class="btn btn-sm btn-warning btn-icon" data-bs-toggle="tooltip" data-bs-placement="bottom" aria-label="Reset tabel?" data-bs-original-title="Reset Tabel Mata Kuliah?">
                                            <i class="ti ti-refresh"></i>
                                        </button>
                                        <?= form_close(); ?>
                                    </td>
                                <?php else : ?>
                                    <td><?= $mata_kuliah; ?></td>
                                    <td>
                                        <?php if (!empty($krs_mahasiswa)) : ?>
                                            <a href="<?= site_url('akademik/generate_data/mata_kuliah'); ?>" class="btn btn-sm btn-success btn-icon" data-bs-toggle="tooltip" data-bs-placement="bottom" aria-label="Generate data?" data-bs-original-title="Do magic generate data tabel Mata Kuliah?">
                                                <i class="ti ti-wand"></i>
                                            </a>
                                        <?php endif ?>
                                    </td>
                                <?php endif; ?>
                            </tr>
                            <tr class="<?= empty($mahasiswa) ? 'bg-red-lt' : 'bg-green-lt' ?>">
                                <td>Mahasiwa</td>
                                <?php if (!empty($mahasiswa)) : ?>
                                    <td><?= $mahasiswa; ?></td>
                                    <td><?= form_open('akademik/reset_data', 'name="resJadwal"', ['table' => 'mahasiswa']); ?>
                                        <button type="submit" class="btn btn-sm btn-warning btn-icon" data-bs-toggle="tooltip" data-bs-placement="bottom" aria-label="Reset tabel?" data-bs-original-title="Reset tabel Mahasiswa?">
                                            <i class="ti ti-refresh"></i>
                                        </button>
                                        <?= form_close(); ?>
                                    </td>
                                <?php else : ?>
                                    <td><?= $mahasiswa; ?></td>
                                    <td>
                                        <?php if (!empty($krs_mahasiswa)) : ?>
                                            <a href="<?= site_url('akademik/generate_data/mahasiswa'); ?>" class="btn btn-sm btn-success btn-icon" data-bs-toggle="tooltip" data-bs-placement="bottom" aria-label="Generate data?" data-bs-original-title="Do magic generate data tabel mahasiswa?">
                                                <i class="ti ti-wand"></i>
                                            </a>
                                        <?php endif ?>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        </tbody>
                    </table>
                </div>
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
</div>

<script>
    let opt_kategori = document.getElementById('kategori_data');
    let upl_data = document.getElementById('upload_data');

    opt_kategori.addEventListener('change', function() {
        let val = this.value;
        upl_data.setAttribute('name', 'upload_' + val);
    })
</script>