<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="description" content="Portal Ujian PKN STAN">
    <meta name="author" content="farisz">
    <title>Portal Ujian - PKN STAN</title>
    <link rel="shortcut icon" href="<?= base_url('assets/favicon.ico'); ?>" type="image/x-icon">
    <!-- CSS files -->
    <link href="<?= base_url('assets/css/tabler.min.css'); ?>" rel="stylesheet" />
    <link href="<?= base_url('assets/tabler-icons.min.css'); ?>" rel="stylesheet">
</head>

<body class="d-flex flex-column">
    <div class="row g-0 flex-fill">
        <div class="col-12 col-lg-6 col-xl-5 border-top-wide border-primary d-flex flex-column justify-content-center">
            <div class="container container-tight my-3 px-lg-3">
                <div class="text-center mb-4">
                    <a href="." class="navbar-brand navbar-brand-autodark">
                        <img src="<?= base_url('assets/img/logo_exam.svg') ?>" alt="logo" height="42">
                    </a>
                </div>
                <?php
                    $page = $page ?? 'pages/auth/index';
                    $this->load->view($page, null, FALSE);
                ?>
                <div class="text-center text-muted mt-3">
                    <small>Subbagian Akademik PKN STAN &copy; <?= date('Y'); ?></small>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 col-xl-7 d-none d-lg-block">
            <div class="bg-cover h-100 min-vh-100" style="background-image: url('<?= base_url('assets/img/world_map.svg') ?>')"></div>
        </div>
    </div>
    <!-- Libs JS -->
    <!-- Tabler Core -->
    <script src="<?= base_url('assets/js/tabler.min.js') ?>" defer=""></script>
</body>

</html>