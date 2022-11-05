<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="card">
    <div class="card-body">
        <div class="mb-3">
            <h4 class="card-title">Daftar Peserta Ujian</h4>
            <p>
                Berikut data peserta ujian program studi <strong><?= user()->program_studi; ?></strong> kelas: <strong><?= user()->kelas; ?></strong>.
            </p>
            <div class="row my-3 g-1">
                <div class="col"></div>
                <div class="col-3">
                    <a href="<?= $soal_utama; ?>" target="_blank" class="btn w-100" rel="noreferrer noopener">Soal Ujian</a>
                </div>
                <div class="col-auto">
                    <a href="<?= site_url('pengawas/laporan'); ?>" class="btn btn-primary w-100" id="btn_BA">Buat Berita Acara Pengawas Ujian</a>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table card-table table-vcenter">
                <thead>
                    <tr>
                        <th class="w-1">No.</th>
                        <th>Nim.</th>
                        <th>Nama mahasiswa</th>
                        <th>Kelas</th>
                        <th>Jawaban</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($mhs) and count($mhs) > 0) : $a = 1;
                        foreach ($mhs as $mh) : ?>
                            <tr>
                                <td><?= $a++; ?></td>
                                <td><?= $mh->nim; ?></td>
                                <td><?= $mh->nama_lengkap; ?></td>
                                <td><?= $mh->kelas; ?></td>
                                <?php $sudah = $jawaban[$mh->nim] ?? false; ?>
                                <td>
                                    <?php if ($sudah) : $file = explode('/', $sudah[0]['file_path']); ?>
                                        <i class="icon ti ti-file text-primary me-1"></i>
                                        <?= end($file); ?>
                                    <?php else : ?>
                                        -
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($sudah and $sudah[0]['kunci_jawaban'] == 1) : ?>
                                        <span class="badge bg-success me-1"></span> selesai
                                    <?php else : ?>
                                        <span class="badge bg-danger me-1"></span> belum
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach;
                    else : ?>
                        <tr>
                            <td colspan="6" class="h5 text-center text-warning">Data kelas dan mahasiswa kosong ... </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal modal-blur fade" id="modal-success" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-status bg-success"></div>
            <div class="modal-body text-center py-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-green icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <circle cx="12" cy="12" r="9" />
                    <path d="M9 12l2 2l4 -4" />
                </svg>
                <h3 class="my-3">Selamat Datang Pengawas</h3>
                <div class="text-muted">
                    Hari ini Anda bertugas untuk menjadi pengawas pada program studi <strong><?= user()->program_studi; ?></strong> kelas <strong><?= user()->kelas; ?></strong>.<br>
                    Selamat bertugas <strong><?= user()->nama_lengkap; ?></strong>.
                </div>
            </div>
            <div class="modal-footer">
                <div class="w-100">
                    <div class="row">
                        <div class="col">
                            <a href="javascript:void(0)" class="btn btn-success w-100" data-bs-dismiss="modal">
                                Awasi kelas
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const myModal = new bootstrap.Modal('#modal-success', {
            keyboard: false
        })
        //myModal.toggle();

        const myModalEl = document.getElementById('modal-success')
        myModalEl.addEventListener('hidden.bs.modal', event => {
            let url = new URL(window.location.href);
            var search_params = url.searchParams;
            search_params.set('awasi', true);
            // change the search property of the main url
            url.search = search_params.toString();
            // the new url string
            var new_url = url.toString();
            window.location.replace(new_url);
        });

        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        const awasi = urlParams.has('awasi');

        if (awasi) {
            setTimeout(function() {
                window.location.reload();
            }, 30000);
        } else {
            myModal.toggle();
        }
    })
</script>