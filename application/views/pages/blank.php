<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<div class="row row-cards">
    <div class="col col-md-12">
        <div class="card">
            <div class="card-stamp">
                <div class="card-stamp-icon bg-white text-primary">
                    <!-- Download SVG icon from http://tabler-icons.io/i/star -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z"></path>
                    </svg>
                </div>
            </div>
            <div class="card-body">
                <h3 class="card-title">Halaman Kosong</h3>
                <p class="text-muted">Ini adalah halaman kosong sebagai sampel.</p>
                <div class="hr-text">halaman sampel</div>
                <pre><code><?= json_encode($this->session, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES); ?></code></pre>
            </div>
        </div>
    </div>
</div>