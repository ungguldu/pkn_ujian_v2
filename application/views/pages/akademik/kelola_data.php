<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="card">
    <div class="card-body">
        <h2 class="card-title">Kelola Data <?= !empty($this->uri->segment(3)) ? humanize($this->uri->segment(3)) : humanize($tabel) ?></h2>
        <div class="row mb-3">
            <div class="col-12 col-md-6">
                <div>
                    <div class="form-label">Pilih data yang ditampilkan</div>
                    <div>
                        <form action="#!" name="pilih_data" id="pilih_data">
                            <?php if (!empty($list_table)) :
                                foreach ($list_table as $ls) : ?>
                                    <label class="form-check form-check-inline">
                                        <input class="form-check-input" name="mydata" id="<?= $ls; ?>" type="radio" value="<?= $ls; ?>" <?= $tabel == $ls ? 'checked' : ''; ?>>
                                        <span class="form-check-label"><?= humanize($ls); ?></span>
                                    </label>
                            <?php endforeach;
                            endif;
                            ?>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div>
                    <?= form_open(current_url(), 'name="cariData" method="get"'); ?>
                    <label class="form-label">Cari data</label>
                    <div class="row g-1">
                        <div class="col">
                            <input type="text" name="cari" class="form-control" placeholder="cari data ..." value="<?= $q ?? ''; ?>">
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary btn-icon" aria-label="Button">
                                <i class="icon ti ti-search"></i>
                            </button>
                            <?php if (!empty($q)) : ?>
                                <a href="<?= current_url(); ?>" class="btn btn-white btn-icon">
                                    <i class="icon ti ti-refresh"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?= form_close(); ?>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12 col-md-12">
                <p class="text-muted">Gunakan pilihan radio diatas untuk menampilkan masing-masing tabel. Gunakan fitur cari untuk memudahkan Anda <em>sorting</em> atau mencari data yang spesifik.</p>
                <div class="table-responsive">
                    <?php if ($mydata) : ?>
                        <?= $mydata; ?>
                    <?php else : ?>
                        <?= $this->load->view('components/no_data', null, true);
                        ?>
                    <?php endif; ?>
                </div>
                <?= $halaman; ?>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var radios = document.querySelectorAll('input[type=radio][name="mydata"]');
    radios.forEach(radio => radio.addEventListener('change', function() {
        let url = "<?= site_url('akademik/kelola_data') ?>";
        if (radio.value !== 'mahasiswa') {
            url = url + '/' + radio.value;
        }
        window.location.replace(url);
    }));
</script>