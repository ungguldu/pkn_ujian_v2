<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="card">
    <div class="empty">
        <div class="empty-img mb-0" style="min-height: 256px;">
            <img src="<?= base_url('assets/img/exam_welcome.png'); ?>" class="h-100" height="360" alt="Welcome to Exam">
        </div>
        <p class="empty-title">Selamat Datang Peserta Ujian</p>
        <p class="empty-subtitle text-muted">
            Kesungguhan, kejujuran tidak akan menghianati hasil. <br>
            Do your best bro .. 👍
        </p>
        <div class="empty-action mb-4">
            <a href="<?= site_url('auth/mahasiswa'); ?>" class="btn btn-primary">
                <i class="icon ti ti-login"></i>
                Login Sekarang
            </a>
        </div>
    </div>
</div>