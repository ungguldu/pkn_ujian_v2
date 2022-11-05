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
    <link href="<?= base_url('assets/'); ?>css/tabler.min.css" rel="stylesheet" />
    <link href="<?= base_url('assets/tabler-icons.min.css'); ?>" rel="stylesheet">
</head>

<body class=" border-top-wide border-primary d-flex flex-column">
    <div class="page page-center">
        <div class="container-tight py-3">
            <div class="text-center mb-5">
                <a href="<?= site_url('/'); ?>" class="navbar-brand navbar-brand-autodark"><img src="<?= base_url('assets/img/logo_exam.svg') ?>" height="72" alt="Logo Portal Ujian"></a>
            </div>
            <!-- form -->

            <?php $this->load->view(!empty($page) ? $page : 'pages/auth/index', false); ?>
            <!-- footer -->
            <div class="text-center text-muted mt-3">
                <small class="text-muted">Kolaborasi Unit Sistem Informasi dan Bagian Akademik PKN STAN</small>
            </div>
        </div>
    </div>
    <!-- Tabler Core -->
    <script src="<?= base_url('assets/'); ?>js/tabler.min.js" defer></script>
</body>

</html>