<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no" />
    <style>
        body {
            margin: 0;
            padding: 0;
            min-width: 100%;
            width: 100% !important;
            height: 100% !important
        }

        body,
        table,
        td,
        div,
        p,
        a {
            -webkit-font-smoothing: antialiased;
            text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
            line-height: 1, 5rem;
        }

        table,
        td {
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
            border-collapse: collapse !important;
            border-spacing: 0
        }

        img {
            border: 0;
            line-height: 100%;
            outline: none;
            text-decoration: none;
            -ms-interpolation-mode: bicubic
        }

        ul {
            list-style: none;
        }

        dt {
            float: left;
            clear: left;
            width: 15rem;
            font-weight: bold;
            text-align: left;
        }

        dt::after {
            content: ":";
        }

        dd {
            margin: 0 0 0 5rem;
            padding: 0 0 0.25rem 0;
        }

        #outlook a {
            padding: 0
        }

        .ReadMsgBody {
            width: 100%
        }

        .ExternalClass {
            width: 100%
        }

        .ExternalClass,
        .ExternalClass p,
        .ExternalClass span,
        .ExternalClass font,
        .ExternalClass td,
        .ExternalClass div {
            line-height: 1.5rem;
        }

        @media all and (min-width: 560px) {
            .container {
                border-radius: 8px;
                -webkit-border-radius: 8px;
                -moz-border-radius: 8px;
                -khtml-border-radius: 8px
            }
        }

        a,
        a:hover {
            color: #1e1e1e
        }

        .footer a,
        .footer a:hover {
            color: #828999
        }

        button {
            margin: .5rem .25rem;
            padding: .5rem;
            color: #fff;
            background-color: #2fb344;
            border: #2fb344;
            cursor: pointer;
        }

        @media print {

            .no-print,
            .no-print * {
                display: none !important;
            }
        }
    </style>
    <title>Berita Acara Pengawas <?= user()->nama_lengkap . ' ' . user()->program_studi . ' ' . user()->kelas; ?> </title>
</head>

<body topmargin="0" rightmargin="0" bottommargin="0" leftmargin="0" marginwidth="0" marginheight="0" width="100%" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; width: 100%; height: 100%; -webkit-font-smoothing: antialiased; text-size-adjust: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; line-height: 100%;
background-color: #fefefe;
color: #1e1e1e;" bgcolor="#fefefe" text="#1e1e1e">
    <?php if (!empty($akhir)) : ?>
        <div style="display: flex; justify-content: end; align-content: end;">
            <button type="submit" class="no-print" onclick="window.location.replace('<?= site_url('auth/logout'); ?>')">Selesai dan Keluar</button>
        </div>
    <?php endif; ?>
    <div id="pdf">
        <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; width: 100%;" class="background">
            <tr>
                <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0;" bgcolor="#fefefe">
                    <table border="0" cellpadding="0" cellspacing="0" align="center" width="748" style="border-collapse: collapse; border-spacing: 0; padding: 0; width: inherit;max-width: 748px;" class="wrapper">
                        <tr>
                            <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%;
    padding-top: 0px;
    padding-bottom: 20px;">
                                <div style="display: none; visibility: hidden; overflow: hidden; opacity: 0; font-size: 1px; line-height: 1px; height: 0; max-height: 0; max-width: 0;
    color: #fefefe;" class="preheader">Berita Acara Pengawas Ujian PKN STAN</div><a target="_blank" style="text-decoration: none;" href="https://pknstan.ac.id"></a>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%; font-size: 14px; font-weight: 400; line-height: 130%; letter-spacing: 2px;padding-top: 0px;padding-bottom: 0;color: #1e1e1e;font-family: sans-serif;" class="supheader">
                                <h6 style="margin: 0;">KEMENTERIAN KEUANGAN REPUBLIK INDONESIA </h6>
                                <h5 style="margin: 0;">BADAN PENDIDIKAN DAN PELATIHAN KEUANGAN</h5>
                                <h3 style="margin-bottom: 0.3rem;">POLITEKNIK KEUANGAN NEGARA STAN</h3>
                                <span style="font-size: 8px;">JALAN BINTARO UTAMA SEKTOR V, BINTARO JAYA, TANGERANG SELATAN 15222 TELEPON (021) 7361654-58; FAKSIMILE (021) 7361653; SITUS www.pknstan.ac.id</span>
                                <hr>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%; font-size: 18px; font-weight: bold; line-height: 130%;padding-top: 5px;color: #1e1e1e;font-family: sans-serif;" class="header">BERITA ACARA PENYELENGGARAAN UJIAN</td>
                        </tr>

                        <tr>
                            <td align="justify" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%; font-size: 14px; font-weight: 400; line-height: 130%;padding-top: 15px;color: #1e1e1e;font-family: sans-serif;" class="paragraph">
                                <p>Yang bertanda tangan di bawah ini menerangkan bahwa di Kampus Politeknik Keuangan Negara STAN, Jalan Bintaro Utama Sektor V Bintaro Jaya, Tangerang Selatan pada:</p>
                                <dl>
                                    <dt>Hari/Tanggal</dt>
                                    <dd><?= tanggal_panjang($jadwal->tanggal); ?></dd>
                                    <dt>Pukul/Waktu</dt>
                                    <dd> <?= $jadwal->waktu_mulai; ?></dd>
                                    <dt>Gedung/Ruang</dt>
                                    <dd> <?= $post['ruang']; ?></dd>
                                    <dt>Telah Diselenggarakan Ujian</dt>
                                    <dd>Ujian Sertifikasi Kompetensi Akuntansi Pemerintah</dd>
                                    <dt>Program Studi</dt>
                                    <dd> <?= $post['program_studi']; ?></dd>
                                    <dt>Mata Kuliah</dt>
                                    <dd> <?= $post['mata_kuliah']; ?></dd>
                                    <dt>Semester / Kelas</dt>
                                    <dd> <?= $post['kelas']; ?></dd>
                                    <dt>Jumlah Peserta Ujian Seharusnya</dt>
                                    <dd> <?= $post['peserta_total']; ?></dd>
                                    <dt>Peserta Hadir</dt>
                                    <dd> <?= $post['peserta_hadir']; ?></dd>
                                    <dt>Peserta Tidak Hadir</dt>
                                    <dd> <?= $post['peserta_absen']; ?></dd>
                                    <dt>Catatan</dt>
                                    <dd> <?= $post['catatan']; ?></dd>
                                </dl>
                                <p>
                                    Demikian Berita Acara ini kami buat dengan sesungguhnya.
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td align="left" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%; font-size: 14px; font-weight: 400; line-height: 130%;padding-top: 15px;color: #1e1e1e;font-family: sans-serif;" class="paragraph">
                                <p>Pengawas Ujian,</p>
                                <div id="qrcode" style="max-height: 10rem; max-width: 10rem"><?= $qr ?></div>
                                <p><?= user()->nama_lengkap ?></p>
                            </td>
                        </tr>
                        <tr>
                            <td align="justify" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%; padding-top: 30px;" class="line">
                                <hr color="#565F73" align="center" width="100%" size="1" noshade style="margin: 0; padding: 0;" />
                            </td>
                        </tr>
                        <tr>
                            <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%; font-size: 10px; font-weight: 400; line-height: 100%;padding-top: 10px;padding-bottom: 20px;color: #828999;font-family: sans-serif;" class="footer">dokumen ini dicetak dari aplikasi portal ujian PKN STAN</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>