<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<header class="navbar navbar-expand-md navbar-light d-print-none">
    <div class="container-xl">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
            <a href=".">
                <img src="<?= base_url('assets/img/logo_exam.svg'); ?>" width="120" height="48" alt="EXAM" class="navbar-brand-image">
            </a>
        </h1>
        <div class="navbar-nav flex-row order-md-last">
            <div class="d-none d-md-flex">
                <a href="?theme=dark" class="nav-link px-1 hide-theme-dark" title="Enable dark mode" data-bs-toggle="tooltip" data-bs-placement="bottom">
                    <i class="icon ti ti-moon"></i>
                </a>
                <a href="?theme=light" class="nav-link px-1 hide-theme-light" title="Enable light mode" data-bs-toggle="tooltip" data-bs-placement="bottom">
                    <i class="icon ti ti-sun"></i>
                </a>
            </div>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                    <span class="avatar avatar-sm" style="background-image: url(<?= base_url('assets/img/avatar.png'); ?>)"></span>
                    <div class="d-none d-xl-block ps-2">
                        <div><?= (!empty(user()) and !empty(user()->nama_lengkap)) ? user()->nama_lengkap : user()->email; ?></div>
                        <div class="mt-1 small text-muted">
                            <?= (!empty(user('role')) and user('role') == 'mahasiswa') ? user('role') : ''; ?>
                        </div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <a href="#" class="dropdown-item">Set status</a>
                    <div class="dropdown-divider"></div>
                    <a href="<?= site_url('auth/logout'); ?>" class="dropdown-item">Logout</a>
                </div>
            </div>
        </div>
    </div>
</header>