<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="card">
    <div class="card-body">
        <h3 class="card-title">Kelola Presensi</h3>
        <div class="row my-3">
            <div class="col-12 col-md-4 order-1">
                <?= form_open('', 'name="cari_data" method="get"'); ?>
                <div class="input-group">
                    <input type="text" name="cari" value="<?= $q; ?>" class="form-control">
                    <button type="submit" class="btn btn-primary">Cari</button>
                    <?php if (!empty($q)) : ?><a href="<?= site_url('kelola_presensi'); ?>" class="btn">Reset</a><?php endif; ?>
                </div>
                <?= form_close(); ?>
            </div>
            <div class="col-12 col-md-8">
                <div class="row g-1">
                    <div class="col">
                        <?php
                        $opt_sesi_new = ['' => 'Pilih sesi'] + array_combine($opt_sesi, $opt_sesi);
                        echo form_dropdown('sesi', $opt_sesi_new,  set_value('sesi'), 'class="form-select" id="sel_sesi"') . PHP_EOL;
                        ?>
                    </div>
                    <div class="col">
                        <select name="user[day]" class="form-select">
                            <option value="">Day</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                        </select>
                    </div>
                    <div class="col">
                        <select name="user[year]" class="form-select">
                            <option value="">Year</option>
                            <option value="2014">2014</option>
                            <option value="2013">2013</option>
                        </select>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-info">tampilkan</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Peserta</th>
                        <th>Program Studi</th>
                        <th>Kelas</th>
                        <th>Sesi</th>
                        <th>Mata Kuliah</th>
                        <th>Waktu Presensi</th>
                        <th>IP Address</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($presensi)) : foreach ($presensi as $pr) : ?>
                            <tr>
                                <td><?= ++$start; ?></td>
                                <td><b><?= $pr->nama_lengkap; ?></b><br><?= $pr->nim; ?></td>
                                <td><?= $pr->program_studi; ?></td>
                                <td><?= $pr->kelas; ?></td>
                                <td><?= $pr->sesi; ?></td>
                                <td><?= $pr->mata_kuliah; ?></td>
                                <td><?= $pr->presensi_pada; ?></td>
                                <td><?= $pr->ip_address; ?></td>
                            </tr>
                        <?php endforeach;
                    else : ?>
                        <tr>
                            <td colspan="8">
                                <h4 class="text-warning text-center">Data kosong!</h4>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?= $halaman; ?>
    </div>
</div>