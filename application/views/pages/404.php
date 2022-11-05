<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<div class="empty">
    <div class="empty-img">
        <img src="<?= base_url('assets/img/empty.svg'); ?>" height="254" alt="Not Found">
    </div>
    <p class="empty-title">Halaman Tidak Ditemukan</p>
    <p class="empty-subtitle text-muted">
        Anda mungkin mengakses alamat URL yang salah!
    </p>
    <div class="empty-action">
        <a href="javascript:void(0)" onclick="window.history.back()" class="btn btn-primary">
            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
            <i class="icon ti ti-arrow-back"></i> Kembali
        </a>
    </div>
</div>