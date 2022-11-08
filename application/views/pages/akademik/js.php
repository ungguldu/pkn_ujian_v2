<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<script type="text/javascript">
    var radios = document.querySelectorAll('input[type=radio][name="matkul"]');
    radios.forEach(radio => radio.addEventListener('change', function() {
        //alert(radio.value);
        var tr = radio.closest('tr');
        var mat_kul = tr.cells.item(3).textContent;
        document.getElementById('matkul_title').textContent = mat_kul;
        document.querySelector('input[name="id_jadwal"]').value = radio.getAttribute('data-id');
        //modal.show()matkul_title
    }));

    var attach = document.querySelectorAll('.add-attach');
    attach.forEach(att => att.addEventListener('click', function() {
        var tr = att.closest('tr');
        var mat_kul = tr.cells.item(3).textContent;
        document.getElementById('matkul_title_att').textContent = mat_kul;
        document.getElementById('attachment').setAttribute('name', att.getAttribute('data-att'));
        document.querySelector('form[name="UplSoalAtt"]').setAttribute('action', att.getAttribute('data-uri'));
        //modal.show()matkul_title
    }));

    var hapus_soal = document.querySelectorAll('.hapus_soal');
    hapus_soal.forEach(hapus => hapus.addEventListener('click', function() {
        var tr = hapus.closest('tr');
        var mat_kul = tr.cells.item(3).textContent;
        var uri = hapus.getAttribute('data-uri');

        if (confirm("Apakah Anda yakin menghapus file soal: " + mat_kul + "?") == true) {
            window.location.replace(uri);
        } else {
            return;
        }
    }));

    var view_soal = document.querySelectorAll('.view_soal');
    view_soal.forEach(view => view.addEventListener('click', function() {
        var tr = view.closest('tr');
        document.getElementById('judul_v_matkul').textContent = tr.cells.item(3).textContent;
        var uri = view.getAttribute('data-uri');
        var file = view.getAttribute('data-file');
        const frame = document.getElementById('frame_pdf');
        const my_video = document.getElementById('my_video');

        if (file === null) {
            if (frame === null) {
                const f = document.createElement('iframe');
                f.setAttribute('width', '100%');
                f.setAttribute('id', 'frame_pdf');
                f.height = "748";
                f.src = uri + "#toolbar=0";
                const box = document.getElementById('box');
                box.appendChild(f);
            } else {
                frame.src = uri + "#toolbar=0";
            }
        } else {
            if (my_video === null) {
                const video = document.createElement('video');
                var sourceMP4 = document.createElement("source");
                sourceMP4.type = "video/mp4";
                sourceMP4.src = uri;
                video.appendChild(sourceMP4);
                video.setAttribute('width', '100%');
                video.setAttribute('id', 'my_video');
                video.src = uri;
                video.autoplay = true;
                video.controls = true;
                video.muted = false;
                const box = document.getElementById('box');
                box.appendChild(video);
            } else {
                my_video.src = uri;
            }
        }

    }));

    const myModalEl = document.getElementById('view_soal')
    myModalEl.addEventListener('hidden.bs.modal', event => {
        const video = document.getElementById('my_video');
        const frame = document.getElementById('frame_pdf');

        if (video !== null) {
            video.pause();
            video.remove();
        }
        if (frame !== null) {
            frame.remove();
        } else {
            const f = document.createElement('iframe');
            f.setAttribute('id', 'frame_pdf');
            f.setAttribute('width', '100%');
            f.height = "748";
        }
    })

    const edit_durasi = document.querySelectorAll('.btn-edit-durasi');
    const durasi_pengerjaaan = document.getElementById('durasi_pengerjaan');
    const input_id = document.querySelector('input[name=id]');

    edit_durasi.forEach(edit => {
        edit.addEventListener('click', function() {
            let durasi = edit.dataset.durasi;
            let id_val = edit.dataset.id;
            durasi_pengerjaaan.value = durasi;
            input_id.value = id_val;
        })
    })
</script>