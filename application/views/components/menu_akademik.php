<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<ul class="navbar-nav">
    <li class="nav-item">
        <a class="nav-link" href="<?= site_url('welcome'); ?>">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
                <i class="icon ti ti-home"></i>
            </span>
            <span class="nav-link-title">
                Home
            </span>
        </a>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#navbar-data" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
                <i class="icon ti ti-notes"></i>
            </span>
            <span class="nav-link-title">
                Upload Data
            </span>
        </a>
        <div id="#navbar-data" class="dropdown-menu" data-bs-popper="none">
            <a class="dropdown-item" href="<?= site_url('akademik'); ?>">
                Upload Data
            </a>
            <a class="dropdown-item" href="<?= site_url('akademik/soal'); ?>">
                Upload Soal
            </a>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?= site_url('akademik/kelola_data'); ?>">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
                <i class="icon ti ti-file-pencil"></i>
            </span>
            <span class="nav-link-title">
                Kelola Data
            </span>
        </a>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#navbar-pengawas" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
                <i class="icon ti ti-settings"></i>
            </span>
            <span class="nav-link-title">
                Pengawas
            </span>
        </a>
        <div id="#navbar-pengawas" class="dropdown-menu" data-bs-popper="none">
            <a class="dropdown-item" href="<?= site_url('akademik/pengawas'); ?>">
                Data Pengawas
            </a>
            <a class="dropdown-item" href="<?= site_url('akademik/ba_pengawas'); ?>">
                Berita Acara Pengawas
            </a>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="<?= site_url('kelola_jawaban/file_jawaban'); ?>">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
                <i class="icon ti ti-file-zip"></i>
            </span>
            <span class="nav-link-title">
                Kelola Jawaban
            </span>
        </a>
    </li>
</ul>