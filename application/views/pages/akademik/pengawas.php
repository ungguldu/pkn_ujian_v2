<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="row mb-3">
    <div class="col-md-12 col-lg-12">
        <!-- Cards with tabs component -->
        <div class="card-tabs ">
            <!-- Cards navigation -->
            <ul class="nav nav-tabs">
                <li class="nav-item"><a href="#tab-top-1" class="nav-link active" data-bs-toggle="tab">Data Pengawas</a></li>
                <li class="nav-item"><a href="#tab-top-4" class="nav-link" data-bs-toggle="tab">Upload Data Pengawas</a></li>
            </ul>
            <div class="tab-content">
                <!-- Content of card #1 -->
                <div id="tab-top-1" class="card tab-pane active">
                    <div class="card-body">
                        <div class="card-title">Kelola Pengawas</div>
                        <p class="text-muted mb-3">
                            Berikut data pengawas yang disimpan di database. Gunaka tombol "tambah data" untuk menambah data pengawas.
                        </p>
                        <div class="row">
                            <div class="col-12 col-md-6 mb-3">
                                <a href="<?= site_url('akademik/pengawas/tambah') ?>" class="btn btn-primary w-50">
                                    Tambah data
                                </a>
                            </div>
                            <div class="col-12 col-md-6">
                                <div>
                                    <?= form_open(current_url(), 'name="cariData" method="get"'); ?>
                                    <div class="row g-1">
                                        <div class="col">
                                            <input type="text" name="cari" class="form-control" placeholder="cari data ..." value="<?= $q ?? ''; ?>">
                                        </div>
                                        <div class="col-auto">
                                            <button type="submit" class="btn btn-primary btn-icon" aria-label="Button">
                                                <i class="icon ti ti-search"></i>
                                            </button>
                                            <?php if (!empty($q)) : ?>
                                                <a href="<?= current_url(); ?>" class="btn btn-white btn-icon">
                                                    <i class="icon ti ti-refresh"></i>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <?= form_close(); ?>
                                </div>
                            </div>
                        </div> <!-- end row -->
                        <div class="table-responsive mb-3">
                            <?php if (!$pengawas) :  echo $this->load->view('components/no_data', null, true); ?>
                            <?php else : ?>
                                <table class="table table-vcenter card-table">
                                    <thead>
                                        <tr>
                                            <th>Nama Lengkap</th>
                                            <th class="w-1">Kode Pengawas</th>
                                            <th>NIK</th>
                                            <th>Program Studi</th>
                                            <th class="w-1">Kelas</th>
                                            <th>Jadwal</th>
                                            <th>Sesi</th>
                                            <th>Mata kuliah</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($pengawas as $was) : ?>
                                            <tr>
                                                <td class="text-muted"><?= $was->nama_lengkap; ?></td>
                                                <td class="text-muted"><?= $was->kode_pengawas; ?></td>
                                                <td class="text-muted">
                                                    <?= $was->nik; ?>
                                                </td>
                                                <td class="text-muted">
                                                    <span class="text-reset"><?= $was->program_studi; ?></span>
                                                </td>
                                                <td class="text-muted">
                                                    <?= $was->kelas; ?>
                                                </td>
                                                <td class="text-muted">
                                                    <?= tanggal_panjang($was->tanggal . ' ' . $was->waktu_mulai, true); ?>
                                                </td>
                                                <td class="text-muted">
                                                    <?= $was->sesi; ?>
                                                </td>
                                                <td class="text-muted">
                                                    <?= $was->mata_kuliah; ?>
                                                </td>
                                                <td class="text-muted">
                                                    <?= ($was->status) ? '<span class="badge bg-success me-1"></span> aktif' : '<span class="badge bg-warning me-1"></span> nonaktif'; ?>
                                                </td>
                                                <td>
                                                    <div class="d-flex">
                                                        <a href="<?= site_url('akademik/pengawas/edit/' . $was->id) ?>" class="btn btn-sm text-info me-1">edit</a>
                                                        <a href="<?= site_url('akademik/pengawas/delete/' . $was->id) ?>" class="btn btn-sm text-danger btn_hapus">hapus</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php endif; ?>
                        </div> <!-- table-resp -->
                        <?= $halaman; ?>
                    </div>
                </div>
                <!-- Content of card #4 -->
                <div id="tab-top-4" class="card tab-pane">
                    <div class="card-body">
                        <div class="card-title">Upload data pengawas</div>
                        <p class="text-muted">
                            Gunakan formulir berikut untuk menambah data pengawas secara kolektif.
                        </p>
                        <div class="my-3">
                            <div class="alert alert-info" role="alert">
                                <h4 class="alert-title">Panduan</h4>
                                <div class="text-muted">Gunakan file template berikut ini untuk menghindari kesalahan format data. Download <a href="<?= site_url('welcome/download?file=00000000000_template_pengawas.xlsx'); ?>" class="btn-link">disini</a>.</div>
                            </div>
                            <?= form_open_multipart('akademik/upload/pengawas', 'name="Upl_pengawas"'); ?>
                            <div class="mb-3">
                                <div class="form-label">Upload Data</div>
                                <input type="file" class="form-control" name="upload_pengawas" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Upload</button>
                                <button type="reset" class="btn">Reset</button>
                            </div>
                            <?= form_close(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    btn_hapus = document.querySelectorAll('.btn_hapus');
    btn_hapus.forEach(btn => {
        btn.addEventListener('click', function(event) {
            event.preventDefault();
            var a = confirm('Apakah anda yakin menghapus data pengawas?');
            if (a) window.location.replace(btn.href);
            return;
        })
    });
</script>