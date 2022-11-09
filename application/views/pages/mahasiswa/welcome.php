<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php if ($jadwal_dipilih) $this->load->view('pages/mahasiswa/progres_sesi', null, FALSE); ?>

<div class="row mb-3">
    <div class="col-12 col-md-8 mb-3">
        <div class="card">
            <div class="card-body">
                <div>
                    <h2>Selamat Datang <?= user()->nama_lengkap; ?></h2>
                    <?php if ($jadwal_dipilih) : ?>
                        <p class="my-3 text-muted">Anda telah memilih jadwal pada sesi ini.</p>
                        <div class="table-responsive">
                            <table class="table table-vcenter">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Waktu Mulai</th>
                                        <th>Sesi</th>
                                        <th>Program Studi</th>
                                        <th>Mata Kuliah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($jadwal)) : ?>
                                        <tr>
                                            <td colspan="5" class="text-center text-danger h3">Jadwal tidak ditemukan!</td>
                                        </tr>
                                    <?php else : ?>
                                        <tr>
                                            <td><?= !empty($jadwal) ? tanggal_panjang($jadwal->tanggal) : ''; ?></td>
                                            <td><?= !empty($jadwal) ? $jadwal->waktu_mulai : ''; ?></td>
                                            <td><?= !empty($jadwal) ? $jadwal->sesi : ''; ?></td>
                                            <td><?= !empty($jadwal) ? $jadwal->program_studi : ''; ?></td>
                                            <td><?= !empty($jadwal) ? $jadwal->mata_kuliah : ''; ?></td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="row my-3">
                            <div class="col-auto">
                                <a href="<?= site_url('mahasiswa/ikut_ujian/' . $mode . '/' . $jadwal->id); ?>" class="btn btn-primary me-1">Lihat Soal</a>
                            </div>
                            <div class="col-auto">
                                <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#modal_upl_jawaban">
                                    Upload Jawaban
                                </button>
                            </div>
                        </div>
                        <!-- table -->
                        <div class="my-3">
                            <h3 class="text-warning mb-0">Perhatian</h3>
                            <p class="text-muted">
                                Anda dinyatakan <strong class="text-danger">selesai</strong> ujian jika telah mengunci jawaban.<br>
                                Jawaban dapat Anda upload ulang melalui tautan upload jawaban. Jawaban yang sudah dikunci tidak dapat diakses dan diupload ulang.<br>
                                Gunakan sesi ujian Anda sebaik-baiknya.
                            </p>
                        </div>
                    <?php else : ?>
                        <div id="faq-1" class="accordion" role="tablist" aria-multiselectable="true">
                            <div class="accordion-item ">
                                <div class="accordion-header" role="tab">
                                    <button class="accordion-button" data-bs-toggle="collapse" data-bs-target="#faq-1-2" aria-expanded="true">Pilih Jadwal</button>
                                </div>
                                <div id="faq-1-2" class="accordion-collapse collapse show" role="tabpanel" data-bs-parent="#faq-1">
                                    <div class="accordion-body pt-0">
                                        <p>Berikut jadwal ujian tersedia untukmu dihari : <strong><?= tanggal_panjang(date('Y-m-d')); ?></strong></p>
                                        <div class="table-responsive">
                                            <table class="table table-vcenter">
                                                <thead>
                                                    <tr>
                                                        <th>Tanggal</th>
                                                        <th>Waktu Mulai</th>
                                                        <th>Sesi</th>
                                                        <th>Program Studi</th>
                                                        <th>Mata Kuliah</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if (empty($jadwal)) : ?>
                                                        <tr>
                                                            <td colspan="5" class="text-center text-danger h3">Jadwal tidak ditemukan!</td>
                                                        </tr>
                                                    <?php else : ?>
                                                        <tr>
                                                            <td><?= !empty($jadwal) ? tanggal_panjang($jadwal->tanggal) : ''; ?></td>
                                                            <td><?= !empty($jadwal) ? $jadwal->waktu_mulai : ''; ?></td>
                                                            <td><?= !empty($jadwal) ? $jadwal->sesi : ''; ?></td>
                                                            <td><?= !empty($jadwal) ? $jadwal->program_studi : ''; ?></td>
                                                            <td><?= !empty($jadwal) ? $jadwal->mata_kuliah : ''; ?></td>
                                                        </tr>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- table -->
                                        <?php if (empty(!$jadwal)) : ?>
                                            <div class="my-3">
                                                <label class="form-label">Benar jadwal Anda?</label>
                                                <div class="row">
                                                    <div class="col-auto mb-2">
                                                        <a href="<?= site_url('mahasiswa/ikut_ujian/reguler/' . $jadwal->id); ?>" class="btn btn-primary w-100">Ya, ikuti ujian ini</a>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <!-- button -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="row">
            <div class="col-12 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">Data Pokok <strong><?= user()->nama_lengkap; ?></strong></div>
                        <div class="mb-2">
                            <i class="icon ti ti-calendar me-2 text-muted"></i>
                            Tanggal Lahir: <strong><?= tanggal_panjang(user()->tanggal_lahir); ?></strong>
                        </div>
                        <div class="mb-2">
                            <i class="icon ti ti-building me-2 text-muted"></i>
                            Program Studi: <strong><?= user()->program_studi; ?></strong>
                        </div>
                        <div class="mb-2">
                            <i class="icon ti ti-briefcase me-2 text-muted"></i>
                            Kelas: <strong><?= user()->kelas; ?></strong>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">Data Jawaban</div>
                        <?php if (!empty($jawaban)) :
                            $ext = pathinfo($jawaban->file_path, PATHINFO_EXTENSION);
                            $filename = urlencode(base64_encode(samarkan($jawaban->file_path)));
                        ?>
                            <div class="mb-2 text-muted d-flex">
                                <div><i class="icon ti ti-book me-2"></i></div>
                                <div>Mata Kuliah: <strong class="text-uppercase text-dark"><?= humanize($jawaban->mata_kuliah); ?></strong></div>

                            </div>

                            <div class="mb-2 text-muted d-flex">
                                <div><i class="icon ti ti-file me-2 text-muted"></i></div>
                                <div>
                                    File Jawaban:
                                    <a href="<?= site_url('mahasiswa/file/' . $ext . '/' . $jawaban->id_jadwal . '?tipe=jawaban&file=' . $filename); ?>" class="btn-link" target="_blank">
                                        <?php
                                        $path = explode('/', $jawaban->file_path);
                                        $file_jawaban = end($path);
                                        echo $file_jawaban;
                                        ?>
                                    </a>
                                    Klik untuk melihat/download.
                                </div>
                            </div>
                            <div class="mb-2 mt-3">
                                <button class="btn btn-success w-100" id="kunci_jawaban" data-uri="<?= site_url('mahasiswa/kunci_jawaban/' . $jawaban->id); ?>">Kunci Jawaban dan Logout</button>
                            </div>
                        <?php else : ?>
                            <div class="mb-2">
                                <i class="icon ti ti-file-off me-2 text-warning"></i>
                                jawaban belum diupload
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if ($jadwal_dipilih) : ?>
    <div class="modal modal-blur fade" id="modal_upl_jawaban" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Formulir Upload Jawaban Ujian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>
                        Anda akan mengupload jawaban untuk mata kuliah <strong id="matkul_title"><?= $jadwal->mata_kuliah; ?></strong>.
                        <br>Pastikan Anda memilih file yang benar.
                    </p>
                    <div class="mb-3">
                        <?php
                        // upload reguler
                        $hidden = [
                            'nim' => user()->nim,
                            'kelas' => underscore(user()->kelas),
                            'mata_kuliah' => underscore($jadwal->mata_kuliah),
                            'program_studi' => underscore($jadwal->program_studi),
                            'id_jadwal' => $jadwal->id,
                        ];
                        echo form_open_multipart('mahasiswa/upload_jawaban/' . $mode, 'name="UplJawab"', $hidden);
                        ?>
                        <label class="form-label required mb-1">Pilih file</label>
                        <div class="input-group">
                            <input type="file" class="form-control" name="jawaban" accept="application/pdf, application/zip, application/x-zip" required>
                            <button type="submit" class="btn btn-primary">Upload</button>
                            <button type="reset" class="btn">Reset</button>
                        </div>
                        <small class="form-hint mb-3">
                            ekstensi file yang diizinkan adalah <span class="text-warning">.zip</span> atau <span class="text-warning">.pdf</span>
                            <br />dan besar file yang dapat di upload maksimal <span class="text-danger">8 Mb</span>.
                        </small>
                        <?= form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php if (!empty($jawaban)) : ?>
    <script>
        var kunci_jawaban = document.getElementById('kunci_jawaban');
        kunci_jawaban.addEventListener('click', function() {
            var uri = kunci_jawaban.getAttribute('data-uri');
            var ok = confirm('Apakah Anda yakin untuk kunci jawaban dan logout?');
            if (ok) {
                window.location.replace(uri);
            } else {
                return;
            }
        })
    </script>
<?php endif; ?>