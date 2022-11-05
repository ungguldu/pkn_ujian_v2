<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div>
    <div class="text-center">
        <img src="<?= base_url('assets/img/exam_paper.png') ?>" alt="welcome" height="256" onclick="window.location.replace('<?= site_url('auth/pengawas'); ?>')">
        <a href="<?= site_url('auth/mahasiswa'); ?>" class="btn btn-primary mt-3 w-100">Mulai Sekarang ..</a>
    </div>
</div>