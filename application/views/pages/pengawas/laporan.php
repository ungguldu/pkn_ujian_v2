<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="card">
    <div class="card-body">
        <div class="card-title">Laporan Pengawas Ujian</div>
        <?= form_open('pengawas/simpan_laporan', 'name="BA_pengawas"', ['id_pengawas' => user()->id, 'id_jadwal' => user()->id_jadwal, 'program_studi' => $jadwal->program_studi, 'mata_kuliah' => $jadwal->mata_kuliah, 'kelas' => user()->kelas]); ?>
        <div class="row my-3" id="cetak">
            <div class="col-12 markdown">
                <h1 class="text-center">BERITA ACARA PENYELENGGARAAN UJIAN</h1>
                <p class="text-muted">Yang bertanda tangan di bawah ini menerangkan bahwa di Kampus Politeknik Keuangan Negara STAN, Jalan Bintaro Utama Sektor V Bintaro Jaya, Tangerang Selatan pada:</p>
                <p class="text-muted>">
                <div class="table-responsive">
                    <table class="table table-vcenter table-sm">
                        <tbody>
                            <tr>
                                <td>Hari/Tanggal</td>
                                <td><?= tanggal_panjang($jadwal->tanggal); ?></td>
                            </tr>
                            <tr>
                                <td>Pukul/Waktu</td>
                                <td><?= $jadwal->waktu_mulai; ?></td>
                            </tr>
                            <tr>
                                <td>Gedung/Ruang</td>
                                <td>
                                    <input type="text" class="form-control" name="ruang" placeholder="Gedung/ruang ujian" autofocus>
                                </td>
                            </tr>
                            <tr>
                                <td>Telah Diselenggarakan Ujian</td>
                                <td><?= $nama_ujian ?? 'Tes Ujian Portal Ujian '.date('Y'); ?></td>
                            </tr>
                            <tr>
                                <td>Program Studi</td>
                                <td><?= $jadwal->program_studi; ?></td>
                            </tr>
                            <tr>
                                <td>Mata Kuliah</td>
                                <td><?= $jadwal->mata_kuliah; ?></td>
                            </tr>
                            <tr>
                                <td>Semester / Kelas</td>
                                <td><?= user()->kelas; ?></td>
                            </tr>
                            <tr>
                                <td>Jumlah Peserta Ujian Seharusnya</td>
                                <td>
                                    <div class="d-flex">
                                        <div class="me-3"><input type="number" class="form-control" name="peserta_total" placeholder="peserta total" value="<?= $jum_mhs; ?>"></div>
                                        <div class="">orang</div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Peserta Hadir</td>
                                <td>
                                    <div class="d-flex">
                                        <div class="me-3"><input type="number" class="form-control" name="peserta_hadir" placeholder="peserta hadir" value="<?= $jum_jawaban; ?>"></div>
                                        <div class="">orang</div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Peserta Tidak Hadir</td>
                                <td>
                                    <div class="d-flex">
                                        <div class="me-3"><input type="number" class="form-control" name="peserta_absen" placeholder="peserta tidak hadir" value=""></div>
                                        <div class="">orang</div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Catatan</td>
                                <td>
                                    <textarea class="form-control" name="catatan" rows="3" placeholder="Catatan.."></textarea>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                </p>
                <p class="text-muted">
                    Demikian Berita Acara ini kami buat dengan sesungguhnya.
                </p>
                <div class="row">
                    <div class="col-6"></div>
                    <div class="col-6">
                        <div class="d-flex flex-column align-content-end">
                            <div class="mb-3">Pengawas Ujian,</div>
                            <div class="h-25 mb-3" id="qrcode"></div>
                            <div class="text-uppercase"><?= user()->nama_lengkap; ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-6"></div>
            <div class="col-6">
                <button id="simpan" class="btn btn-primary">Buat Berita Acara</button>
            </div>
        </div>
        <?= form_close(); ?>
    </div>
</div>

<script src="<?= base_url('assets/js/qrcode.min.js'); ?>"></script>

<script>
    var qrcode = new QRCode(document.getElementById("qrcode"), {
        text: "<?= user()->nik ?>",
        width: 128,
        height: 128,
        colorDark: "#000000",
        colorLight: "#ffffff",
        correctLevel: QRCode.CorrectLevel.H
    });
</script>