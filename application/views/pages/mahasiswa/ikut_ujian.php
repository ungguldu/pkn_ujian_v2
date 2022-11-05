<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php if ($mode == 'nebeng') : ?>
    <div class="alert alert-warning" role="alert">
        <h4 class="alert-title">Anda Ikut Ujian Nebeng 😎</h4>
        <div class="text-muted">Pastikan Anda sudah memilih jadwal nebeng ujian dengan benar!</div>
    </div>
<?php endif; ?>

<div class="alert alert-info mb-3" role="alert">
    <h4 class="alert-title">Sesi Ujian</h4>
    <div class="text-muted mb-3">Anda hanya dapat mengakses soal ujian selama sesi soal belum berakhir. Sisa sesi soal Anda: <strong id="sisa_sesi"></strong></div>
    <div class="progress mb-2">
        <div class="progress-bar" id="sesi_soal" style="width: 100%" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" aria-label="10800 detik">
            <span class="visually-hidden">sisa sesi soal</span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 col-md-6 mb-3">
        <div class="card">
            <div class="card-body">
                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <span class="avatar avatar-lg">
                            <i class="icon ti ti-file-text fs-1 text-primary"></i>
                        </span>
                    </div>
                    <div class="col-8">
                        <div class="mt-1">
                            <i class="icon ti ti-book me-1"></i>
                            <strong><?= $jadwal->mata_kuliah; ?></strong>
                        </div>
                        <div class="text-muted mt-1">
                            <i class="icon ti ti-briefcase me-1"></i>
                            <?= $jadwal->program_studi; ?>
                        </div>
                        <div class="mt-1">
                            <i class="icon ti ti-clock text-warning"></i>
                            <span class="text-muted">
                                akhir sesi soal: <?= tanggal_sedang(date('Y-m-d H:i:s', strtotime($jadwal->tanggal . ' ' . $jadwal->waktu_mulai . ' + 3 hours')), true); ?>
                            </span>
                        </div>
                    </div>
                    <div class="col-12">
                        <a href="<?= $soal_utama; ?>" class="btn btn-primary w-100" target="_blank">
                            Buka Lembar Soal
                        </a>
                    </div>
                </div>
                <?php if ($soal->ada_attachment) : ?>
                    <div class="row my-3">
                        <div class="col-12">
                            <h4 class="text-warning">Perhatian!</h4>
                            <p class="text-muted mb-2">Soal ini mempunyai attachment yang merupakan bagian utuh dari soal. Lihat atau unduh attachment soal pada tautan dibawah ini.</p>
                            <div class="mb-1">
                                <i class="icon ti ti-paperclip text-primary"></i>
                                <strong>attachment 1 soal: </strong> <a href="<?= site_url('mahasiswa/file/' . $soal->attachment1_type . '/' . $jadwal->id . '?tipe=masalah&file=' . urlencode(base64_encode(samarkan($soal->attachment1_path)))); ?>" class="btn-link" target="_blank" rel="noopener noreferrer"> file attachment 1</a>
                            </div>
                            <?php if (!empty($soal->attachment2_type) and !empty($soal->attachment2_path)) : ?>
                                <div>
                                    <i class="icon ti ti-paperclip text-primary"></i>
                                    <strong>attachment 2 soal: </strong> <a href="<?= site_url('mahasiswa/file/' . $soal->attachment2_type . '/' . $jadwal->id . '?tipe=masalah&file=' . urlencode(base64_encode(samarkan($soal->attachment2_path)))); ?>" class="btn-link" target="_blank" rel="noopener noreferrer"> file attachment 2</a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!-- first-col -->
    <div class="col-12 col-md-6 mb-3">
        <div class="card">
            <div class="card-body">
                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <span class="avatar avatar-lg">
                            <i class="icon ti ti-upload fs-1 text-success"></i>
                        </span>
                    </div>
                    <div class="col-8">
                        <h4 class="card-title m-0">
                            <div>Nama: <?= user()->nama_lengkap; ?></div>
                        </h4>
                        <div class="text-muted">
                            <?= $jadwal->mata_kuliah; ?>
                        </div>
                        <div class="small mt-1">
                            <span class="badge bg-success"></span>
                            <span class="text-muted">kelas <?= user()->kelas; ?></span>
                        </div>
                    </div>
                    <div class="col-12">
                        <button type="button" class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#modal_upl_jawaban">
                            Upload file Jawaban
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end-col -->
</div>

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

<script>
    var progres_bar = document.getElementById('sesi_soal');
    var sisa_menit = document.getElementById('sisa_sesi');
    var sisa_sesi = <?= $sisa_sesi; ?>;
    var timer = setInterval(function() {
        if (sisa_sesi <= 0) {
            clearInterval(timer);
        }
        //progres_bar.style.width = sisa_sesi + "%";
        progres_bar.style.width = ((sisa_sesi / 10800) * 100) + "%";
        sisa_menit.textContent = militominute(sisa_sesi * 1000);
        progres_bar.setAttribute('aria-valuenow', sisa_sesi);
        progres_bar.setAttribute('aria-label', sisa_sesi + " detik");
        sisa_sesi -= 1;
    }, 1000);

    function militominute(millis) {
        var minutes = Math.floor(millis / 60000);
        var seconds = ((millis % 60000) / 1000).toFixed(0);
        return minutes + " menit " + (seconds < 10 ? '0' : '') + seconds + ' detik';
    }
</script>