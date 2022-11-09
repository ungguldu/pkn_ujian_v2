<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="card">
    <div class="card-body">
        <h2 class="card-title">Upload Lembar Soal Ujian</h2>
        <p class="text-muted mb-3">Klik pada radio input masing-masing baris mata kuliah untuk mengupload soal ujian. Gunakan fitur cari untuk memudahkan pengelompokan data atau menampilkan data yang spesifik.</p>
        <?php if ($ujian == 0) : $this->load->view('components/no_data', null, true);
        else : ?>
            <div class="row mb-3">
                <div class="col-12 col-md-6"></div>
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
            </div>
            <div class="table-responsive">
                <table class="table card-table table-vcenter text-nowrap datatable">
                    <thead>
                        <tr>
                            <th class="w-1">Pilih</th>
                            <th class="w-1">No.</th>
                            <th>Program Studi</th>
                            <th>Mata Kuliah</th>
                            <th>Semester</th>
                            <th>Tanggal Ujian</th>
                            <th>Mulai Ujian</th>
                            <th>Sesi</th>
                            <th>Durasi</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($jadwal as $jd) : ?>
                            <tr>
                                <td>
                                    <?php
                                    $soal_diupload = soal_diupload($jd->id);
                                    if (empty($soal_diupload) or $soal_diupload === false) :
                                    ?>
                                        <input class="form-check-input m-0 align-middle" type="radio" name="matkul" value="<?= underscore(strtolower($jd->mata_kuliah)); ?>" aria-label="<?= underscore(strtolower($jd->mata_kuliah)); ?>" data-bs-toggle="modal" data-bs-target="#modal_form_soal" data-id="<?= $jd->id; ?>">
                                    <?php else : ?>
                                        <span class="text-success"><i class="icon ti ti-checkbox"></i></span>
                                    <?php endif; ?>
                                </td>
                                <td><span class="text-muted"><?= ++$start; ?></span></td>
                                <td><?= $jd->program_studi; ?></td>
                                <td><?= $jd->mata_kuliah; ?></td>
                                <td><?= $jd->semester; ?></td>
                                <td><?= $jd->tanggal; ?></td>
                                <td><?= $jd->waktu_mulai; ?></td>
                                <td><?= $jd->sesi; ?></td>
                                <td>
                                    <?= $jd->durasi_pengerjaan; ?>
                                    <span class="badge bg-blue-lt btn-edit-durasi fs-6" data-bs-toggle="modal" data-bs-target="#edit_durasi" id="btn-edit-durasi" data-durasi="<?= $jd->durasi_pengerjaan ?? 0; ?>" data-id="<?= $jd->id; ?>">edit durasi</span>
                                </td>
                                <?php if (!empty($soal_diupload)) :  ?>
                                    <td class="text-muted">
                                        <span class="badge bg-success me-1"></span> ok
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <div class="dropdown me-2">
                                                <button class="btn btn-sm dropdown-toggle align-text-top" data-bs-toggle="dropdown" aria-expanded="false">
                                                    detail
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item view_soal" href="javascript:void(0)" data-uri="<?= site_url('akademik/view_soal?file=' . $soal_diupload->path_file); ?>" data-bs-toggle="modal" data-bs-target="#view_soal">
                                                        <i class="ti ti-zoom-check me-2"></i>
                                                        lihat soal
                                                    </a>
                                                    <?php if ($soal_diupload->ada_attachment and !empty($soal_diupload->attachment1_path)) : ?>
                                                        <?php
                                                        $type = ['zip', 'excel', 'powerpoint'];
                                                        if (!in_array($soal_diupload->attachment1_type, $type)) :
                                                        ?>
                                                            <a class="dropdown-item view_soal" href="javascript:void(0)" data-uri="<?= site_url('akademik/view_soal/' . $soal_diupload->attachment1_type . '?file=' . $soal_diupload->attachment1_path); ?>" data-bs-toggle="modal" data-bs-target="#view_soal" data-file="<?= $soal_diupload->attachment1_type; ?>">
                                                                <i class="ti ti-paperclip me-2 text-blue"></i>
                                                                <?= $soal_diupload->attachment1_path; ?>
                                                            </a>
                                                        <?php else : ?>
                                                            <a href="<?= site_url('akademik/view_soal/' . $soal_diupload->attachment1_type . '?file=' . $soal_diupload->attachment1_path); ?>" class="dropdown-item">
                                                                <i class="ti ti-paperclip me-2 text-blue"></i>
                                                                <?= $soal_diupload->attachment1_path; ?>
                                                            </a>
                                                        <?php endif; ?>
                                                    <?php endif;
                                                    if (($soal_diupload->ada_attachment and !empty($soal_diupload->attachment2_path))) : ?>
                                                        <?php
                                                        $type = ['zip', 'excel', 'powerpoint'];
                                                        if (!in_array($soal_diupload->attachment2_type, $type)) :
                                                        ?>
                                                            <a class="dropdown-item view_soal" href="javascript:void(0)" data-uri="<?= site_url('akademik/view_soal/' . $soal_diupload->attachment2_type . '?file=' . $soal_diupload->attachment2_path); ?>" data-file="<?= $soal_diupload->attachment1_type; ?>" data-bs-toggle="modal" data-bs-target="#view_soal">
                                                                <i class="ti ti-paperclip me-2 text-blue"></i>
                                                                <?= $soal_diupload->attachment2_path; ?>
                                                            </a>
                                                        <?php else : ?>
                                                            <a href="<?= site_url('akademik/view_soal/' . $soal_diupload->attachment2_type . '?file=' . $soal_diupload->attachment2_path); ?>" class="dropdown-item">
                                                                <i class="ti ti-paperclip me-2 text-blue"></i>
                                                                <?= $soal_diupload->attachment2_path; ?>
                                                            </a>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                    <?php if (!$soal_diupload->ada_attachment and empty($soal_diupload->attachment1_path)) : ?>
                                                        <a href="javascript:void(0)" class="dropdown-item add-attach text-info" data-uri="<?= site_url('akademik/soal_upload/attach1/' . $soal_diupload->id); ?>" data-att="attach1" data-bs-toggle="modal" data-bs-target="#modal_form_attachment">
                                                            <i class="ti ti-file-plus me-2"></i>
                                                            attacment 1
                                                        </a>
                                                    <?php endif;
                                                    if ($soal_diupload->ada_attachment and empty($soal_diupload->attachment2_path)) : ?>
                                                        <a href="javascript:void(0)" class="dropdown-item add-attach text-info" data-uri="<?= site_url('akademik/soal_upload/attach2/' . $soal_diupload->id); ?>" data-att="attach2" data-bs-toggle="modal" data-bs-target="#modal_form_attachment">
                                                            <i class="ti ti-file-plus me-2"></i>
                                                            attacment 2
                                                        </a>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <a href="javascript:void(0)" class="btn btn-sm text-danger hapus_soal" data-uri="<?= site_url('akademik/hapus_file/soal?file=' . $soal_diupload->path_file); ?>">hapus</a>
                                        </div>
                                    </td>

                                <?php else : ?>
                                    <td>
                                        <span class="badge bg-danger me-1"></span> kosong
                                    </td>
                                    <td>
                                        -
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>
                </table>
            </div>
            <?= $halaman ?>
        <?php endif; ?>
    </div>
</div>

<div class="modal modal-blur fade" id="modal_form_soal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Formulir Upload Soal Ujian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Anda akan mengupload soal untuk mata kuliah <strong id="matkul_title"></strong>. <br>Pastikan Anda memilih file yang benar.</p>
                <div class="mb-3">
                    <?= form_open_multipart('akademik/soal_upload', 'name="UplSsoal"', ['id_jadwal' => '']); ?>
                    <label class="form-label">Pilih file</label>
                    <div class="input-group">
                        <input type="file" class="form-control" name="soal" accept="application/pdf" required>
                        <button type="submit" class="btn btn-primary">Upload</button>
                        <button type="reset" class="btn">Reset</button>
                    </div>
                    <?= form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-blur fade" id="modal_form_attachment" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Formulir Upload Attachment Soal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Anda akan mengupload attachment soal untuk mata kuliah <strong id="matkul_title_att"></strong>. <br>Pastikan Anda memilih file yang benar.</p>
                <div class="mb-3">
                    <?= form_open_multipart('', 'name="UplSoalAtt"'); ?>
                    <div class="mb-3">
                        <div class="form-label">Pilih Tipe Attachment</div>
                        <div>
                            <?php foreach ($file_type as $item) : ?>
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="file_type" value="<?= $item; ?>">
                                    <span class="form-check-label"><?= ucfirst($item); ?></span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Pilih file</label>
                        <div class="input-group">
                            <input type="file" class="form-control" id="attachment" name="" accept="<?= implode(',', $mimes) ?>" required>
                            <button type="submit" class="btn btn-primary">Upload</button>
                            <button type="reset" class="btn">Reset</button>
                        </div>
                    </div>
                    <?= form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-blur fade" id="view_soal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-full-width modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">View Soal <strong id="judul_v_matkul"></strong></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body m-0 p-0" style="height: 85vh;" id="box"></div>
        </div>
    </div>
</div>

<div class="modal modal-blur fade" id="edit_durasi" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <?= form_open('akademik/update_data/jadwal_ujian', 'name="UpdDurasi"', ['id' => '']); ?>
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Durasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Update durasi</label>
                    <input type="number" min="0" class="form-control" name="durasi_pengerjaan" id="durasi_pengerjaan" placeholder="100" value="">
                    <small class="form-hint">
                        Durasi dalam satuan menit. Isikan 0 untuk menggambil nilai default dari sks.
                    </small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </div>
        <?= form_close(); ?>
    </div>
</div>