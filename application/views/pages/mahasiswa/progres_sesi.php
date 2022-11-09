<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="alert alert-info mb-3" role="alert">
    <h4 class="alert-title">Sesi Ujian</h4>
    <div class="text-muted mb-3">Anda hanya dapat mengakses soal ujian selama sesi soal belum berakhir. Sisa sesi soal Anda: <strong id="sisa_sesi"></strong></div>
    <div class="progress mb-2">
        <div class="progress-bar" id="sesi_soal" style="width: 100%" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" aria-label="10800 detik">
            <span class="visually-hidden">sisa sesi soal</span>
        </div>
    </div>
</div>

<script>
    var progres_bar = document.getElementById('sesi_soal');
    var sisa_menit = document.getElementById('sisa_sesi');
    var sisa_sesi = <?= $sisa_sesi; ?>;
    var durasi_ujian = <?= $durasi_ujian; ?> * 60;
    var timer = setInterval(function() {
        if (sisa_sesi <= 0) {
            clearInterval(timer);
        }
        //progres_bar.style.width = sisa_sesi + "%";
        progres_bar.style.width = ((sisa_sesi / durasi_ujian) * 100) + "%";
        sisa_menit.textContent = militominute(sisa_sesi * 1000);
        progres_bar.setAttribute('aria-valuenow', sisa_sesi);
        progres_bar.setAttribute('aria-label', sisa_sesi + " detik");
        sisa_sesi -= 1;
    }, 1000);

    function militominute(millis) {
        var minutes = Math.floor(millis / 60000);
        var seconds = ((millis % 60000) / 1000).toFixed(0);
        return minutes + " menit " + (seconds < 10 ? '0' : '') + seconds + ' detik';
    }
</script>