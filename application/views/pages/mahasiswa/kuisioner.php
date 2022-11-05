<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="card">
    <div class="card-body">
        <h3 class="card-title">Kuisioner Evaluasi System Usability Scale (SUS)</h3>
        <p class="text-muted">Yang tersayang rekan-rekan Mahasiswa, mohon bantuan isi kuisioner sebentar dan sekali saja. <br>
            Dibawah ini akan disajikan beberapa pertanyaan tentang Evaluasi System Usability Scale (SUS) terhadap Portal Ujian. SUS ini perlu dilakukan untuk pengujian apakah aplikasi memenuhi unsur seperti usability atau mungkin user experience.<br>
            Mohon bantuannya ya. 😁
        </p>
        <?= form_open('', 'name="KuisionerSUS"') ?>
        <div class="row mb-3">
            <div class="col-12 col-md-12 mb-3">
                <div class="row">
                    <div class="col-12 col-md-4">
                        <div class="mb-3 form-fieldset">
                            <label class="form-label">NIM</label>
                            <input type="text" class="form-control" name="nim" placeholder="NIM" value="<?= user()->nim; ?>">
                            <?= form_error('nim'); ?>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="mb-3 form-fieldset">
                            <label class="form-label">Program Studi</label>
                            <input type="text" class="form-control" name="program_studi" placeholder="Program Studi" value="<?= user()->program_studi; ?>">
                            <?= form_error('program_studi'); ?>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="mb-3 form-fieldset">
                            <div class="form-label">Tahun Masuk/Angkatan</div>
                            <select class="form-select" name="angkatan">
                                <option value="">pilih angkatan</option>
                                <option value="2018" <?= (!empty(set_value('angkatan')) and set_value('angkatan') == 2018) ? 'selected' : ''; ?>>2018</option>
                                <option value="2019" <?= (!empty(set_value('angkatan')) and set_value('angkatan') == 2019) ? 'selected' : ''; ?>>2019</option>
                                <option value="2021" <?= (!empty(set_value('angkatan')) and set_value('angkatan') == 2021) ? 'selected' : ''; ?>>2021</option>
                            </select>
                            <?= form_error('angkatan'); ?>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="mb-3 form-fieldset">
                            <div class="form-label">Jenis Kelamin</div>
                            <div>
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" value="pria" <?= (!empty(set_value('gender')) and set_value('gender') == 'pria') ? 'checked' : '';  ?>>
                                    <span class="form-check-label">Laki-laki</span>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" value="wanita" <?= (!empty(set_value('gender')) and set_value('gender') == 'wanita') ? 'checked' : '';  ?>>
                                    <span class="form-check-label">Perempuan</span>
                                </label>
                            </div>
                            <?= form_error('gender'); ?>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="mb-3 form-fieldset">
                            <div class="form-label">Formasi</div>
                            <div>
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="formasi" value="reguler" <?= (set_value('formasi', true) == 'reguler') ? 'checked' : '';  ?>>
                                    <span class="form-check-label">Reguler</span>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="formasi" value="alih_program" <?= (set_value('formasi', true) == 'alih_program') ? 'checked' : '';  ?>>
                                    <span class="form-check-label">Alih Program/Tugas Belajar</span>
                                </label>
                            </div>
                            <?= form_error('formasi'); ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end col -->
            <div class="col-12 col-md-6 mb-3">
                <p class="text-muted">
                    Panduan: <br>
                    Pilihan angka 1 (Sangat Tidak Setuju) bertingkat sampai dengan pilihan angka 5 (Sangat Setuju).
                </p>
                <div class="row my-3">
                    <div class="col">
                        <ul class="list-group list-group-horizontal-md">
                            <li class="list-group-item">1. Sangat Tidak Setuju</li>
                            <li class="list-group-item">2. Tidak Setuju</li>
                            <li class="list-group-item">3. Biasa</li>
                            <li class="list-group-item">4. Setuju</li>
                            <li class="list-group-item">5. Sangat Setuju</li>
                        </ul>
                    </div>
                </div>
                <div class="mb-3 form-fieldset">
                    <div class="form-label required">1. Saya berpikir akan menggunakan sistem ini lagi</div>
                    <div class="row g-2">
                        <div class="col-auto">
                            <span>Sangat Tidak Setuju</span>
                        </div>
                        <div class="col-auto">
                            <div>
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="isian_1" value="1" <?= (set_value('isian_1') == 1) ? 'checked' : '';  ?>>
                                    <span class="form-check-label">1</span>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="isian_1" value="2" <?= (set_value('isian_1') == 2) ? 'checked' : '';  ?>>
                                    <span class="form-check-label">2</span>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="isian_1" value="3" <?= (set_value('isian_1') == 3) ? 'checked' : '';  ?>>
                                    <span class="form-check-label">3</span>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="isian_1" value="4" <?= (set_value('isian_1') == 4) ? 'checked' : '';  ?>>
                                    <span class="form-check-label">4</span>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="isian_1" value="5" <?= (set_value('isian_1') == 5) ? 'checked' : '';  ?>>
                                    <span class="form-check-label">5</span>
                                </label>
                            </div>
                            <?= form_error('isian_1'); ?>
                        </div>
                        <div class="col-auto">
                            <span>Sangat Setuju</span>
                        </div>
                    </div>
                </div>
                <div class="mb-3 form-fieldset">
                    <div class="form-label required">2. Saya merasa sistem ini rumit untuk digunakan</div>
                    <div class="row g-2">
                        <div class="col-auto">
                            <span>Sangat Tidak Setuju</span>
                        </div>
                        <div class="col-auto">
                            <div>
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="isian_2" value="1" <?= (set_value('isian_2') == 1) ? 'checked' : '';  ?>>
                                    <span class="form-check-label">1</span>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="isian_2" value="2" <?= (set_value('isian_2') == 2) ? 'checked' : '';  ?>>
                                    <span class="form-check-label">2</span>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="isian_2" value="3" <?= (set_value('isian_2') == 3) ? 'checked' : '';  ?>>
                                    <span class="form-check-label">3</span>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="isian_2" value="4" <?= (set_value('isian_2') == 4) ? 'checked' : '';  ?>>
                                    <span class="form-check-label">4</span>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="isian_2" value="5" <?= (set_value('isian_2') == 5) ? 'checked' : '';  ?>>
                                    <span class="form-check-label">5</span>
                                </label>
                            </div>
                            <?= form_error('isian_2'); ?>
                        </div>
                        <div class="col-auto">
                            <span>Sangat Setuju</span>
                        </div>
                    </div>
                </div>
                <div class="mb-3 form-fieldset">
                    <div class="form-label required">3. Saya merasa sistem ini mudah untuk digunakan</div>
                    <div class="row g-2">
                        <div class="col-auto">
                            <span>Sangat Tidak Setuju</span>
                        </div>
                        <div class="col-auto">
                            <div>
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="isian_3" value="1" <?= (set_value('isian_3') == 1) ? 'checked' : '';  ?>>
                                    <span class="form-check-label">1</span>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="isian_3" value="2" <?= (set_value('isian_3') == 2) ? 'checked' : '';  ?>>
                                    <span class="form-check-label">2</span>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="isian_3" value="3" <?= (set_value('isian_3') == 3) ? 'checked' : '';  ?>>
                                    <span class="form-check-label">3</span>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="isian_3" value="4" <?= (set_value('isian_3') == 4) ? 'checked' : '';  ?>>
                                    <span class="form-check-label">4</span>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="isian_3" value="5" <?= (set_value('isian_3') == 5) ? 'checked' : '';  ?>>
                                    <span class="form-check-label">5</span>
                                </label>
                            </div>
                            <?= form_error('isian_3'); ?>
                        </div>
                        <div class="col-auto">
                            <span>Sangat Setuju</span>
                        </div>
                    </div>
                </div>
                <div class="mb-3 form-fieldset">
                    <div class="form-label required">4. Saya membutuhkan bantuan dari orang lain atau teknisi dalam menggunakan sistem ini</div>
                    <div class="row g-2">
                        <div class="col-auto">
                            <span>Sangat Tidak Setuju</span>
                        </div>
                        <div class="col-auto">
                            <div>
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="isian_4" value="1" <?= (set_value('isian_4') == 1) ? 'checked' : '';  ?>>
                                    <span class="form-check-label">1</span>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="isian_4" value="2" <?= (set_value('isian_4') == 2) ? 'checked' : '';  ?>>
                                    <span class="form-check-label">2</span>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="isian_4" value="3" <?= (set_value('isian_4') == 3) ? 'checked' : '';  ?>>
                                    <span class="form-check-label">3</span>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="isian_4" value="4" <?= (set_value('isian_4') == 4) ? 'checked' : '';  ?>>
                                    <span class="form-check-label">4</span>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="isian_4" value="5" <?= (set_value('isian_4') == 5) ? 'checked' : '';  ?>>
                                    <span class="form-check-label">5</span>
                                </label>
                            </div>
                            <?= form_error('isian_4'); ?>
                        </div>
                        <div class="col-auto">
                            <span>Sangat Setuju</span>
                        </div>
                    </div>
                </div>
                <div class="mb-3 form-fieldset">
                    <div class="form-label required">5. Saya merasa fitur-fitur sistem ini berjalan dengan semestinya</div>
                    <div class="row g-2">
                        <div class="col-auto">
                            <span>Sangat Tidak Setuju</span>
                        </div>
                        <div class="col-auto">
                            <div>
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="isian_5" value="1" <?= (set_value('isian_5') == 1) ? 'checked' : '';  ?>>
                                    <span class="form-check-label">1</span>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="isian_5" value="2" <?= (set_value('isian_5') == 2) ? 'checked' : '';  ?>>
                                    <span class="form-check-label">2</span>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="isian_5" value="3" <?= (set_value('isian_5') == 3) ? 'checked' : '';  ?>>
                                    <span class="form-check-label">3</span>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="isian_5" value="4" <?= (set_value('isian_5') == 4) ? 'checked' : '';  ?>>
                                    <span class="form-check-label">4</span>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="isian_5" value="5" <?= (set_value('isian_5') == 5) ? 'checked' : '';  ?>>
                                    <span class="form-check-label">5</span>
                                </label>
                            </div>
                            <?= form_error('isian_5'); ?>
                        </div>
                        <div class="col-auto">
                            <span>Sangat Setuju</span>
                        </div>
                    </div>
                </div>
                <div class="mb-3 form-fieldset">
                    <div class="form-label required">6. Saya merasa ada banyak hal yang tidak konsisten (tidak serasi) pada sistem ini
                    </div>
                    <div class="row g-2">
                        <div class="col-auto">
                            <span>Sangat Tidak Setuju</span>
                        </div>
                        <div class="col-auto">
                            <div>
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="isian_6" value="1" <?= (set_value('isian_6') == 1) ? 'checked' : '';  ?>>
                                    <span class="form-check-label">1</span>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="isian_6" value="2" <?= (set_value('isian_6') == 2) ? 'checked' : '';  ?>>
                                    <span class="form-check-label">2</span>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="isian_6" value="3" <?= (set_value('isian_6') == 3) ? 'checked' : '';  ?>>
                                    <span class="form-check-label">3</span>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="isian_6" value="4" <?= (set_value('isian_6') == 4) ? 'checked' : '';  ?>>
                                    <span class="form-check-label">4</span>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="isian_6" value="5" <?= (set_value('isian_6') == 5) ? 'checked' : '';  ?>>
                                    <span class="form-check-label">5</span>
                                </label>
                            </div>
                            <?= form_error('isian_6'); ?>
                        </div>
                        <div class="col-auto">
                            <span>Sangat Setuju</span>
                        </div>
                    </div>
                </div>
                <div class="mb-3 form-fieldset">
                    <div class="form-label required">7. Saya merasa orang lain akan memahami cara menggunakan sistem ini dengan cepat</div>
                    <div class="row g-2">
                        <div class="col-auto">
                            <span>Sangat Tidak Setuju</span>
                        </div>
                        <div class="col-auto">
                            <div>
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="isian_7" value="1" <?= (set_value('isian_7') == 1) ? 'checked' : '';  ?>>
                                    <span class="form-check-label">1</span>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="isian_7" value="2" <?= (set_value('isian_7') == 2) ? 'checked' : '';  ?>>
                                    <span class="form-check-label">2</span>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="isian_7" value="3" <?= (set_value('isian_7') == 3) ? 'checked' : '';  ?>>
                                    <span class="form-check-label">3</span>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="isian_7" value="4" <?= (set_value('isian_7') == 4) ? 'checked' : '';  ?>>
                                    <span class="form-check-label">4</span>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="isian_7" value="5" <?= (set_value('isian_7') == 5) ? 'checked' : '';  ?>>
                                    <span class="form-check-label">5</span>
                                </label>
                            </div>
                            <?= form_error('isian_7'); ?>
                        </div>
                        <div class="col-auto">
                            <span>Sangat Setuju</span>
                        </div>
                    </div>
                </div>
                <div class="mb-3 form-fieldset">
                    <div class="form-label required">8. Saya merasa sistem ini membingungkan</div>
                    <div class="row g-2">
                        <div class="col-auto">
                            <span>Sangat Tidak Setuju</span>
                        </div>
                        <div class="col-auto">
                            <div>
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="isian_8" value="1" <?= (set_value('isian_8') == 1) ? 'checked' : '';  ?>>
                                    <span class="form-check-label">1</span>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="isian_8" value="2" <?= (set_value('isian_8') == 2) ? 'checked' : '';  ?>>
                                    <span class="form-check-label">2</span>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="isian_8" value="3" <?= (set_value('isian_8') == 3) ? 'checked' : '';  ?>>
                                    <span class="form-check-label">3</span>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="isian_8" value="4" <?= (set_value('isian_8') == 4) ? 'checked' : '';  ?>>
                                    <span class="form-check-label">4</span>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="isian_8" value="5" <?= (set_value('isian_8') == 5) ? 'checked' : '';  ?>>
                                    <span class="form-check-label">5</span>
                                </label>
                            </div>
                            <?= form_error('isian_8'); ?>
                        </div>
                        <div class="col-auto">
                            <span>Sangat Setuju</span>
                        </div>
                    </div>
                </div>
                <div class="mb-3 form-fieldset">
                    <div class="form-label required">9. Saya merasa tidak ada hambatan dalam menggunakan sistem ini
                    </div>
                    <div class="row g-2">
                        <div class="col-auto">
                            <span>Sangat Tidak Setuju</span>
                        </div>
                        <div class="col-auto">
                            <div>
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="isian_9" value="1" <?= (set_value('isian_9') == 1) ? 'checked' : '';  ?>>
                                    <span class="form-check-label">1</span>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="isian_9" value="2" <?= (set_value('isian_9') == 2) ? 'checked' : '';  ?>>
                                    <span class="form-check-label">2</span>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="isian_9" value="3" <?= (set_value('isian_9') == 3) ? 'checked' : '';  ?>>
                                    <span class="form-check-label">3</span>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="isian_9" value="4" <?= (set_value('isian_9') == 4) ? 'checked' : '';  ?>>
                                    <span class="form-check-label">4</span>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="isian_9" value="5" <?= (set_value('isian_9') == 5) ? 'checked' : '';  ?>>
                                    <span class="form-check-label">5</span>
                                </label>
                            </div>
                            <?= form_error('isian_9'); ?>
                        </div>
                        <div class="col-auto">
                            <span>Sangat Setuju</span>
                        </div>
                    </div>
                </div>
                <div class="mb-3 form-fieldset">
                    <div class="form-label required">10. Saya perlu membiasakan diri terlebih dahulu sebelum menggunakan sistem ini
                    </div>
                    <div class="row g-2">
                        <div class="col-auto">
                            <span>Sangat Tidak Setuju</span>
                        </div>
                        <div class="col-auto">
                            <div>
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="isian_10" value="1" <?= (set_value('isian_10') == 1) ? 'checked' : '';  ?>>
                                    <span class="form-check-label">1</span>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="isian_10" value="2" <?= (set_value('isian_10') == 2) ? 'checked' : '';  ?>>
                                    <span class="form-check-label">2</span>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="isian_10" value="3" <?= (set_value('isian_10') == 3) ? 'checked' : '';  ?>>
                                    <span class="form-check-label">3</span>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="isian_10" value="4" <?= (set_value('isian_10') == 4) ? 'checked' : '';  ?>>
                                    <span class="form-check-label">4</span>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="isian_10" value="5" <?= (set_value('isian_10') == 5) ? 'checked' : '';  ?>>
                                    <span class="form-check-label">5</span>
                                </label>
                            </div>
                            <?= form_error('isian_10'); ?>
                        </div>
                        <div class="col-auto">
                            <span>Sangat Setuju</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 mb-3">
                <p class="text-muted">
                    Panduan: <br>
                    Isikan pendapatmu ya. Masukanmu sangat bernilai untuk pengembangan aplikasi-aplikasi lainnya juga lho. 😁
                </p>
                <div class="row">
                    <!-- end col -->
                    <div class="col-12">
                        <div class="mb-3 form-fieldset">
                            <label class="form-label required">11. Bagaimana pendapat Anda mengenai keseluruhan Portal Ujian ini?</label>
                            <textarea class="form-control" name="masukan_1" rows="3" placeholder="uraian ..." minlength="3"><?= set_value('masukan_1'); ?></textarea>
                            <?= form_error('masukan_1'); ?>
                        </div>
                    </div>
                    <!-- end col -->
                    <div class="col-12">
                        <div class="mb-3 form-fieldset">
                            <label class="form-label required">12. Apa yang Anda suka dari Portal Ujian ini?</label>
                            <textarea class="form-control" name="masukan_2" rows="3" placeholder="uraian ..." minlength="3"><?= set_value('masukan_2'); ?></textarea>
                            <?= form_error('masukan_2'); ?>
                        </div>
                    </div>
                    <!-- end col -->
                    <div class="col-12">
                        <div class="mb-3 form-fieldset">
                            <label class="form-label required">13. Apa yang Anda kurang sukai dari Portal Ujian ini?</label>
                            <textarea class="form-control" name="masukan_3" rows="3" placeholder="uraian ..." minlength="3"><?= set_value('masukan_3'); ?></textarea>
                            <?= form_error('masukan_3'); ?>
                        </div>
                    </div>
                    <!-- end col -->
                    <div class="col-12">
                        <div class="mb-3 form-fieldset">
                            <label class="form-label required">14. Apa improvement / saran terhadap Portal Ujian ini?</label>
                            <textarea class="form-control" name="masukan_4" rows="3" placeholder="uraian ..." minlength="3"><?= set_value('masukan_4'); ?></textarea>
                            <?= form_error('masukan_4'); ?>
                        </div>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Simpan kuisioner dan Logout</button>
                        <button type="reset" class="btn">Reset</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- endrow -->
        <?= form_close(); ?>
    </div>
</div>