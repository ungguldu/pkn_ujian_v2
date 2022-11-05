<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="navbar-expand-md">
    <div class="collapse navbar-collapse" id="navbar-menu">
        <div class="navbar navbar-light">
            <div class="container-xl">
                <?php
                if (!empty(user())) :
                    switch (user('role')) {
                        case 'akademik':
                            echo $this->load->view('components/menu_akademik', $data ?? null, true);
                            break;
                        case 'pengawas':
                            echo $this->load->view('components/menu_pengawas', $data ?? null, true);
                            break;
                        case 'si_super':
                            echo $this->load->view('components/menu_super', $data ?? null, true);
                            break;
                        default:
                            echo $this->load->view('components/menu_mahasiswa', $data ?? null, true);
                            break;
                    }; ?>
                <?php else : ?>
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="<?= site_url('welcome'); ?>">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <i class="icon ti ti-home"></i>
                                </span>
                                <span class="nav-link-title">
                                    Apps
                                </span>
                            </a>
                        </li>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>