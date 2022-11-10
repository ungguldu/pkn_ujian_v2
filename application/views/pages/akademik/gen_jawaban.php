<div class="card">
    <div class="card-body">
        <h3 class="card-title">Generate Zip Jawaban</h3>
        <p class="text-muted">
            Periksa kelengkapan data file yang akan di generate.
        </p>
        <ul>
            <li>
                <div class="d-flex">
                    <div class="p-2 flex-fill">Jadwal</div>
                    <div class="p-2 flex-fill text-muted">
                        <pre><code class="language-json" data-lang="json"><?= !(empty($jadwal)) ? json_encode($jadwal, JSON_PRETTY_PRINT) : json_encode([]); ?></code></pre>
                    </div>
                </div>
            </li>
            <li>
                <div class="d-flex">
                    <div class="p-2 flex-fill">Dosen</div>
                    <div class="p-2 flex-fill text-muted"><?= $matkul->nama_dosen; ?></div>
                </div>
            </li>
            <li>
                <div class="d-flex">
                    <div class="p-2 flex-fill">Program Studi</div>
                    <div class="p-2 flex-fill text-muted"><?= $matkul->program_studi; ?></div>
                </div>
            </li>
            <li>
                <div class="d-flex">
                    <div class="p-2 flex-fill">Mata Kuliah</div>
                    <div class="p-2 flex-fill text-muted"><?= $matkul->mata_kuliah; ?></div>
                </div>
            </li>
            <li>
                <div class="d-flex">
                    <div class="p-2 flex-fill">Kelas</div>
                    <div class="p-2 flex-fill text-muted"><?= $matkul->kelas; ?></div>
                </div>
            </li>
            <li>
                <div class="d-flex">
                    <div class="p-2 flex-fill">Soal</div>
                    <?php $file_soal = !empty($soal) ? $soal->path_file : 'Soal tidak ditemukan!'; ?>
                    <div class="p-2 flex-fill text-primary"><?= $file_soal; ?></div>
                </div>
            </li>
            <li>
                <div class="d-flex">
                    <div class="p-2 flex-fill">Berita Acara Pengawas</div>
                    <div class="p-2 flex-fill <?= !empty($ba) ? 'text-success' : 'text-danger'; ?>">
                        <?php $file_ba = !empty($ba) ? explode(DIRECTORY_SEPARATOR, $ba->file_path) : ['File BA pengawas kosong!'] ?>
                        <?= end($file_ba); ?>
                    </div>
                </div>
            </li>
            <li>
                <div class="d-flex">
                    <div class="p-2 flex-fill">Jawaban</div>
                    <div class="p-2 flex-fill text-dark fs-1 text-left"><?= !empty($jawaban) ? count($jawaban) : 0; ?></div>
                </div>
            </li>
        </ul>
        <div class="w-100">
            <a href="<?= site_url('kelola_jawaban/gen_jawaban/' . $id . '/true?ref=' . $ref); ?>" class="btn btn-primary">Buat Zip</a>
            <a onclick="window.history.back();" href="javascript:void(0);" class="btn">Batal</a>
        </div>
    </div>
</div>