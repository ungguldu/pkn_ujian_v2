<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-12 <?= (!empty($mode)) ? 'col-md-12' : 'col-md-7'; ?> order-1 mb-3">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">Kirim Jawaban</h3>
                <?php if (empty($mode)) : ?>
                    <p class="text-muted">Pilih data pada opsi.</p>
                <?php endif; ?>
                <?php if (!empty($mode)) : ?>
                    <p class="text-muted">
                        Periksa kembali kelengkapan jawaban yang akan dikirim.
                        <br>Pastikan alamat email dosen valid. Atau gunakan tombol ubah untuk mengganti dengan alamat email yang lain.
                    </p>

                    <div class="row">
                        <div class="col-12 col-md-12">
                            <h4>Data Dosen</h4>
                            <?php if (!empty($dosen)) : ?>
                                <ul class="list-unstyled">
                                    <li>Nama Dosen: <?= $dosen->nama_dosen; ?></li>
                                    <li>Program Studi: <?= $dosen->program_studi; ?></li>
                                    <li>Mata Kuliah: <?= $dosen->mata_kuliah; ?></li>
                                    <li>Kelas: <?= $dosen->kelas; ?></li>
                                </ul>
                            <?php else : ?>
                                <p class="text-muted">Perhatian! Data Dosen <span class="text-warning">tidak ditemukan</span>. Silakan input manual data alamat email dosen yang dituju.</p>
                            <?php endif; ?>
                            <div class="mb-3">
                                <?= form_open('kelola_jawaban/kirim_email/dosen', 'name="kirimJawaban"', ['files' => '', 'matkul' => $mata_kuliah, 'kelas' => $kelas, 'prodi' => $program_studi]); ?>
                                <label class="form-label">Email Dosen</label>
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" placeholder="email dosen" value="<?= !empty($dosen) ? $dosen->email_dosen : ''; ?>" <?= !empty($dosen) ? 'readonly' : '' ?> name="email_dosen" id="email_dosen">
                                    <button class="btn" type="button" id="btn_ubah">Ubah</button>
                                    <button class="btn btn-primary" type="button" id="btn_kirim">Kirim</button>
                                </div>
                                <?= form_close(); ?>
                            </div>
                        </div>
                        <div class="col-12 col-md-12">
                            <div class="table-responsive">
                                <table class="table table-vcenter card-table">
                                    <thead>
                                        <tr>
                                            <th class="w-1">Pilih</th>
                                            <th>Mahasiswa</th>
                                            <th>Prodi</th>
                                            <th>Mata Kuliah</th>
                                            <th class="w-1">kelas</th>
                                            <th>File</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($jawaban) and count($jawaban) > 0) :
                                            foreach ($jawaban as $jaw) : ?>
                                                <tr class="text-muted">
                                                    <?php $file_ada = is_file(realpath($basedir . $jaw->file_path)); ?>
                                                    <td class="w-1"><input class="form-check-input m-0 align-middle file-jawab" type="checkbox" aria-label="pilih file" checked data-file="<?= $file_ada ? $jaw->file_path : '' ?>"></td>
                                                    <td><?= $jaw->nim; ?></td>
                                                    <td><?= humanize($jaw->program_studi); ?></td>
                                                    <td><?= humanize($jaw->mata_kuliah); ?></td>
                                                    <td class="w-1"><?= $jaw->kelas; ?></td>
                                                    <td>
                                                        <i class="icon ti ti-file text-primary"></i>
                                                        <span>
                                                            <?php
                                                            $file = explode('/', $jaw->file_path);
                                                            echo $file_ada ? end($file) : 'file tidak ditemukan!';
                                                            ?>
                                                        </span>
                                                    </td>
                                                </tr>
                                            <?php endforeach;
                                        else : ?>
                                            <tr>
                                                <td colspan="5" class="text-center text-warning">
                                                    <h4>tidak ada file jawaban</h4>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <script>
                            document.getElementById('btn_ubah').addEventListener('click', function() {
                                document.getElementById('email_dosen').removeAttribute('readonly');
                            });

                            document.getElementById('btn_kirim').addEventListener('click', function(event) {
                                event.preventDefault();
                                var form = document.querySelector('[name="kirimJawaban"]');
                                var form_files = document.querySelector('[name="files"]');
                                var email_dosen = document.querySelector('[name="email_dosen"]');
                                var files = document.querySelectorAll('.file-jawab');
                                let arr_file = [];
                                files.forEach(file => {
                                    arr_file.push(file.getAttribute('data-file'));
                                });
                                form_files.value = arr_file;
                                if (email_dosen.value === '') {
                                    alert(data);
                                } else {
                                    form.submit();
                                }
                            })
                        </script>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php if (empty($mode)) : ?>
        <div class="col-12 col-md-5 order-0 mb-3">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Pilih Data</h3>
                    <p class="card-subtitle">Sortir data jawaban sesuai kriteria berikut:</p>
                    <?= form_open(); ?>
                    <div class="mb-3">
                        <div class="form-label">Mode Ujian</div>
                        <div>
                            <label class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="mode" value="reguler" <?= (empty(set_value('mode')) or set_value('mode') == 'reguler') ? 'checked' : ''; ?>>
                                <span class="form-check-label">Reguler</span>
                            </label>
                            <label class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="mode" value="nebeng" <?= (!empty(set_value('mode')) and set_value('mode') == 'nebeng') ? 'checked' : ''; ?>>
                                <span class="form-check-label">Nebeng</span>
                            </label>
                            <?= form_error('mode') ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Program Studi</label>
                        <?php
                        if (!empty($prodi) and count($prodi) > 0) {
                            foreach ($prodi as $p => $pr) {
                                $opt[$pr] = $pr;
                            }
                        }
                        $opt[''] = 'pilih prodi';
                        echo form_dropdown('prodi', $opt, set_value('prodi'), 'class="form-select" placeholder="pilih program studi" id="select-tags"');
                        echo form_error('prodi');
                        ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mata Kuliah</label>
                        <select class="form-select" name="matkul" id="sel_matkul"></select>
                        <?= form_error('matkul') ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kelas</label>
                        <select class="form-select" name="kelas" id="sel_kelas"></select>
                        <?= form_error('kelas') ?>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary ms-auto">Tampilkan Data</button>
                        <button type="reset" class="btn">Reset</button>
                    </div>
                    <?= form_close(); ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php if (empty($mode)) : ?>
    <script src="<?= base_url('assets/libs/tom-select/dist/js/tom-select.base.min.js'); ?>" defer></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var el;
            window.TomSelect && (new TomSelect(el = document.getElementById('select-tags'), {
                copyClassesToDropdown: false,
                dropdownClass: 'dropdown-menu',
                optionClass: 'dropdown-item',
                controlInput: '<input>',
                render: {
                    item: function(data, escape) {
                        if (data.customProperties) {
                            return '<div><span class="dropdown-item-indicator">' + data.customProperties + '</span>' + escape(data.text) + '</div>';
                        }
                        return '<div>' + escape(data.text) + '</div>';
                    },
                    option: function(data, escape) {
                        if (data.customProperties) {
                            return '<div><span class="dropdown-item-indicator">' + data.customProperties + '</span>' + escape(data.text) + '</div>';
                        }
                        return '<div>' + escape(data.text) + '</div>';
                    },
                },
            }));
        });

        var jadwal = <?= $jadwal; ?>;
        var matkul = <?= $matkul; ?>;

        document.getElementById('select-tags').addEventListener('change', function() {
            let val = this.value;
            let optj = jadwal[val];
            let selj = <?= set_value('matkul') ?: 'null'; ?>;
            let optm = matkul[val];
            let selm = <?= set_value('kelas') ?: 'null'; ?>;
            let sel_matkul = document.getElementById('sel_matkul');
            let sel_kelas = document.getElementById('sel_kelas');
            sel_matkul.innerHTML = '';
            sel_kelas.innerHTML = '';
            for (var i = 0; i < optj.length; i++) {
                var optn = optj[i];
                var el = document.createElement("option");
                el.textContent = optn;
                el.value = optn;
                if (selj !== null && selj === optn) el.selected = true;
                sel_matkul.appendChild(el);
            }

            for (var i = 0; i < optm.length; i++) {
                var optn = optm[i];
                var el = document.createElement("option");
                el.textContent = optn;
                el.value = optn;
                if (selm !== null && selm === optn) el.selected = true;
                sel_kelas.appendChild(el);
            }
        });
    </script>
<?php endif; ?>