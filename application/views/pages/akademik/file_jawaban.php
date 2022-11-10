<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="card">
    <div class="card-body">
        <h3 class="card-title">Generate File Jawaban</h3>
        <p class="text-muted my-3">
            Pilih data pada tabel dan klik tombol generate jawaban untuk masing-masing mata kuliah dan dosen.
        </p>
        <div class="row mb-3">
            <div class="col-12 col-md-6"></div>
            <div class="col-12 col-md-6">
                <div>
                    <?= form_open('', 'method="GET" name="FormCari"'); ?>
                    <div class="row g-1">
                        <div class="col">
                            <input type="text" name="cari" class="form-control" placeholder="cari data ..." value="<?= $q; ?>">
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary btn-icon" aria-label="Button">
                                <i class="icon ti ti-search"></i>
                            </button>
                            <?php if (!empty($q)) : ?>
                                <a href="<?= site_url('kelola_jawaban/file_jawaban'); ?>" class="btn btn-icon" aria-label="Button">
                                    <i class="icon ti ti-refresh"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Mata Kuliah</th>
                        <th>Program Studi</th>
                        <th>Kelas</th>
                        <th>Nama Dosen</th>
                        <th>Email</th>
                        <th>File Jawaban</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($mata_kuliah)) : foreach ($mata_kuliah as $item) : ?>
                            <tr>
                                <td><?= $item->id; ?></td>
                                <td><?= $item->mata_kuliah; ?></td>
                                <td><?= $item->program_studi; ?></td>
                                <td><?= $item->kelas; ?></td>
                                <td><?= $item->nama_dosen; ?></td>
                                <td><?= $item->email_dosen; ?></td>
                                <td>
                                    <?php $valid = (!empty($item->file_zip) & is_file(realpath(WRITEPATH . $item->file_zip))); ?>
                                    <?= ($valid) ? $item->file_zip : 'file kosong ⚠️'; ?>
                                </td>
                                <td>
                                    <?php if (empty($item->file_zip)) : ?>
                                        <a href="<?= site_url('kelola_jawaban/gen_jawaban/' . $item->id); ?>" class="btn btn-sm btn-primary">Gen File</a>
                                    <?php else : ?>
                                        <span class="text-success">
                                            <i class="icon icon-filled ti ti-star"></i>
                                        </span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php
                        endforeach;
                    else :
                        ?>
                        <tr>
                            <td colspan="8" class="h3 text-warning text-center">Tidak ada data ...</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <?= $halaman; ?>
        </div>
    </div>
</div>