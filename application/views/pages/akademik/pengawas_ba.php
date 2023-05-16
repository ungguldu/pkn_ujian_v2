<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="card">
    <div class="card-body">
        <div class="card-title">Berita Acara Pengawas</div>
        <p class="text-muted">Gunakan pilihan tanggal dan sesi untuk membatasi data yang akan ditampilkan. Jika Anda ingin mencari data yang lebih spesifik gunakan fitur pencarian.</p>
        <div class="row mb-2">
            <div class="col-auto col-md-6">
                <?php if (!empty($ba) and count($ba) > 0) : ?>
                    <button class="btn btn-success" id="donloadBA">Download BA</button>
                <?php endif; ?>
            </div>
            <div class="col-auto col-md-6">
                <?= form_open('', 'method="GET" name="cariBA"'); ?>
                <div class="row g-2 justify-content-end">
                    <div class="col-4 mb-3">
                        <?php
                        echo form_dropdown('tanggal', $hari_ujian,  $selected_hari, 'class="form-select" id="sel_tanggal"') . PHP_EOL;
                        ?>
                    </div>
                    <div class="col-3 mb-3">
                        <?php
                        $av_group_sesi = $group_sesi[$selected_hari];
                        $av_opt_sesi = array_combine($av_group_sesi, $av_group_sesi);
                        echo form_dropdown('sesi', $av_opt_sesi, $selected_sesi, 'class="form-select" id="sel_sesi"') . PHP_EOL;
                        ?>
                    </div>
                    <div class="col-auto mb-3">
                        <button type="submit" class="btn btn-primary me-1">Tampilkan</button>
                        <?php if ($selected_hari !== 'all') : ?>
                            <a href="<?= site_url('akademik/ba_pengawas'); ?>" class="btn">Reset</a>
                        <?php endif; ?>
                    </div>
                </div>
                <?= form_close(); ?>
            </div>
            <!-- end col-6 -->
        </div>
        <div class="table-responsive">
            <table class="table table-vcenter">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pengawas</th>
                        <th>Id Pengawas</th>
                        <th>Program Studi</th>
                        <th>Kelas</th>
                        <th>Mata Kuliah</th>
                        <th>Total Peserta</th>
                        <th>Hadir</th>
                        <th>Tidak Hadir</th>
                        <th>BA Pengawas</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $a = 0;
                    if (!empty($ba) and count($ba) > 0) : foreach ($ba as $b) : ?>
                            <tr>
                                <td><?= ++$a; ?></td>
                                <td><?= $b->nama_lengkap; ?></td>
                                <td><?= $b->id_pengawas; ?></td>
                                <td><?= $b->program_studi; ?></td>
                                <td><?= $b->kelas; ?></td>
                                <td><?= $b->mata_kuliah; ?></td>
                                <td><b><?= $b->peserta_total; ?></b></td>
                                <td><?= $b->peserta_hadir; ?></td>
                                <td><b class="text-warning"><?= $b->peserta_absen; ?></b></td>
                                <td>
                                    <?php if (!empty($b->file_path)) : ?>
                                        <span class="badge bg-green" data-bs-trigger="hover" data-bs-toggle="popover" title="File BA" data-bs-content="<?= $b->file_path; ?>">
                                            <i class="ti ti-file"></i>&nbsp;BA tercetak
                                        </span>
                                    <?php else : ?>
                                        <span class="badge bg-red">Ba kosong!</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach;
                    else : ?>
                        <tr>
                            <td colspan="7" class="h4 text-warning text-center">Data kosong atau gunakan filter untuk menampilkan data</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {

        var sesi = <?= json_encode($group_sesi, JSON_PRETTY_PRINT); ?>;

        document.getElementById('sel_tanggal').addEventListener('change', function() {
            var val = this.value;
            var opt_sesi = sesi[val];
            var el_sesi = document.getElementById('sel_sesi');
            var sesi_selected = '<?= $selected_sesi; ?>';
            el_sesi.innerHTML = '';
            console.log(val, opt_sesi);

            if (val === 'all') {
                el_sesi.innerHTML = '<option value="all">Pilih sesi </option>';
            } else {
                for (var i = 0; i < opt_sesi.length; i++) {
                    var optn = opt_sesi[i];
                    var sel_sesi = document.createElement("option");
                    sel_sesi.textContent = optn;
                    sel_sesi.value = optn;
                    if (sesi_selected !== null && sesi_selected === optn) sel_sesi.selected = true;
                    el_sesi.appendChild(sel_sesi);
                }
            }
        });
        var downBA = document.getElementById('donloadBA');
        if (downBA !== null) {
            downBA.addEventListener('click', function() {
                var sesi = document.getElementById('sel_sesi').value;
                var conf = confirm('Apakah Anda yakin Berita Acara sesi: ' + sesi + ' sudah lengkap?');
                if (conf) {

                    window.location.replace('<?= site_url('akademik/ba_download'); ?>' + '/' + sesi);
                } else {
                    return;
                }
            });
        };
    });
</script>