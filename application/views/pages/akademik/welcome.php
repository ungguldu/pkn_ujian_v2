<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="card">
    <div class="card-body">
        <div>
            <h3 class="mb-3">Panduan Aplikasi</h3>
            <div id="faq-1" class="accordion" role="tablist" aria-multiselectable="true">
                <div class="accordion-item">
                    <div class="accordion-header" role="tab">
                        <button class="accordion-button" data-bs-toggle="collapse" data-bs-target="#faq-1-1" aria-expanded="true">Upload Data</button>
                    </div>
                    <div id="faq-1-1" class="accordion-collapse collapse show" role="tabpanel" data-bs-parent="#faq-1">
                        <div class="accordion-body pt-0">
                            <div>
                                <p>Klik pada menu upload data. Formulir upload akan ditampilkan jika data mahasiswa, mata kuliah, dan jadwal ujian kosong.</p>
                                <p>Pastikan Anda mengupload data sesuai formulirnya. Kesalahan upload data dilain formulir menyebabkan aplikasi <span class="text-danger">error!</span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <div class="accordion-header" role="tab">
                        <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#faq-1-2" aria-expanded="false">Kelola Data</button>
                    </div>
                    <div id="faq-1-2" class="accordion-collapse collapse" role="tabpanel" data-bs-parent="#faq-1">
                        <div class="accordion-body pt-0">
                            <div>
                                <p>Adalah halaman untuk memantau data yang tersimpan di database. Gunakan pilihan radio untuk menampilkan masing-masing data. Gunakan fitur cari untuk mencari data spesifik atau mengelompokkan data.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <div class="accordion-header" role="tab">
                        <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#faq-1-3" aria-expanded="false">Pengawas</button>
                    </div>
                    <div id="faq-1-3" class="accordion-collapse collapse" role="tabpanel" data-bs-parent="#faq-1">
                        <div class="accordion-body pt-0">
                            <div>
                                <p>Klik menu pengawas untuk melakukan pengelolaan pengawas.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <div class="accordion-header" role="tab">
                        <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#faq-1-4" aria-expanded="false">Kelola jawaban</button>
                    </div>
                    <div id="faq-1-4" class="accordion-collapse collapse" role="tabpanel" data-bs-parent="#faq-1">
                        <div class="accordion-body pt-0">
                            <div>
                                <p>Klik menu kelola jawaban untuk melakukan pengelolaan jawaban. Submenu setting email digunakan untuk mengatur email yang akan dipakai untuk mengirimkan jawaban ke dosen. Kontak Admin jika anda mengalami kesulitan mengatur konfigurasi.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>