<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="empty">
    <div class="empty-img"><img src="<?= base_url('assets/img/no_data.gif')?>" height="128" alt="No_DATA">
    </div>
    <p class="empty-title">Tidak Ada Data</p>
    <p class="empty-subtitle text-muted">
        Data kosong atau data yang Anda cari tidak ditemukan.
    </p>
    <div class="empty-action">
        <a href="javascript:void(0)" onclick="window.history.back()" class="btn btn-primary">
            <i class="icon ti ti-arrow-back"></i>
            kembali
        </a>
    </div>
</div>