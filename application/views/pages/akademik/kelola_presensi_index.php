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
                <?= form_open('', 'name="filterData" method="get"'); ?>
                <div class="row g-1">
                    <div class="col">
                        <?php
                        $opt_sesi_new = ['' => 'Pilih sesi'] + array_combine($opt_sesi, $opt_sesi);
                        echo form_dropdown('sesi', $opt_sesi_new,  set_value('sesi'), 'class="form-select" id="sel_sesi"') . PHP_EOL;
                        ?>
                    </div>
                    <div class="col">
                        <?php
                        $opt_prodi_new = ['' => 'Pilih Prodi'];
                        echo form_dropdown('prodi', $opt_prodi_new,  set_value('prodi'), 'class="form-select" id="sel_prodi"') . PHP_EOL;
                        ?>
                    </div>
                    <div class="col">
                        <?php
                        $opt_prodi_new = ['' => 'Pilih Kelas'];
                        echo form_dropdown('kelas', $opt_prodi_new,  set_value('kelas'), 'class="form-select" id="sel_kelas"') . PHP_EOL;
                        ?>
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-info">Tampilkan</button>
                        <?php if($filter): ?><a href="<?= site_url('kelola_presensi'); ?>" class="btn">Reset</a><?php endif; ?>
                    </div>
                </div>
                <?= form_close(); ?>
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

<script>
    const sel_sesi = document.getElementById('sel_sesi');
    const sel_prodi = document.getElementById('sel_prodi');
    const sel_kelas = document.getElementById('sel_kelas');

    let ses_prodi = <?= $opt_sesi_prodi; ?>;
    let prodi_kelas = <?= $opt_prodi_kelas; ?>;

    sel_sesi.addEventListener('change', function(e) {
        let sesi = e.target.value;
        let prodi = ses_prodi[sesi];

        if (sesi !== '') {
            sel_prodi.innerHTML = '<option value="">Pilih Prodi</option>';
            for (var i = 0; i < prodi.length; i++) {
                var opt_prodi = document.createElement("option");
                opt_prodi.textContent = prodi[i];
                opt_prodi.value = prodi[i];

                sel_prodi.appendChild(opt_prodi);
            }
        } else {
            sel_prodi.innerHTML = '<option value="">Pilih Prodi</option>';
        }
    });

    sel_prodi.addEventListener('change', function(e) {
        let prodi = e.target.value;
        let kelas = prodi_kelas[prodi];

        if (prodi !== '') {
            sel_kelas.innerHTML = '<option value="">Pilih Kelas</option>';
            for (var i = 0; i < kelas.length; i++) {
                var opt_kelas = document.createElement("option");
                opt_kelas.textContent = kelas[i];
                opt_kelas.value = kelas[i];

                sel_kelas.appendChild(opt_kelas);
            }
        } else {
            sel_kelas.innerHTML = '<option value="">Pilih Kelas</option>';
        }
    });
</script>