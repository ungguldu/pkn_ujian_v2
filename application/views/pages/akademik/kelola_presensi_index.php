<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="card">
    <div class="card-body">
        <h3 class="card-title">Kelola Presensi</h3>
        <div class="row my-3">
            <div class="col-12 col-md-6"></div>
            <div class="col-12 col-md-6">
                <?= form_open('kelola_presensi', ['method' => 'GET', 'name' => 'cariData']); ?>
                <div class="row">
                    <div class="col">
                        <select class="form-select">
                            <option value="STATUS_CODE" selected="">Status code</option>
                            <option value="JSON_BODY">JSON body</option>
                            <option value="HEADERS">Headers</option>
                            <option value="TEXT_BODY">Text body</option>
                            <option value="RESPONSE_TIME">Response time</option>
                        </select>
                    </div>
                    <div class="col">
                        <select class="form-select">
                            <option value="STATUS_CODE" selected="">Status code</option>
                            <option value="JSON_BODY">JSON body</option>
                            <option value="HEADERS">Headers</option>
                            <option value="TEXT_BODY">Text body</option>
                            <option value="RESPONSE_TIME">Response time</option>
                        </select>
                    </div>
                    <div class="col">
                        <button type="submit" class="btn btn-primary">Tampilkan</button>
                        <a href="<?= site_url('kelola_presensi'); ?>" class="btn btn-icon btn-default"><i class="icon ti ti-refresh"></i></a>
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