<?php 
defined('BASEPATH') or exit('No direct script access allowed');
$quotes = [
    0 => '"Hal terpenting untuk sukses dan bahagia bukanah bakat, namun kekuatan passion dan kegigihan." - Angela Duckworth',
    1 => '"Banyak orang bisa berhasil bukan karena pintar tapi karena mampu bertahan lebih lama saat badai datang dan ia terus merangkak sedikit demi sedikit meski ada kesakitan."',
    2 => '"Mereka yang mencari akan menemukan, mereka yang mengetuk pintu akan dibukakan."',
    3 => '"Orang yang paling sulit dikalahkan adalah orang yang paling gigih."',
    4 => '"Kejujuran adalah bab pertama dalam buku kebijaksanaan." - Thomas Jefferson',
    5 => '"Kebaikan yang saya miliki adalah kebenaran dan kejujuran saya." - William Shakespeare',
    6 => '"Menjadi jujur mungkin tidak membuat Anda memiliki banyak teman, tetapi itu akan selalu membuat Anda menjadi teman yang tepat." - John Lennon',
    7 => '"Tidak ada warisan yang sekaya kejujuran. " - William Shakespeare',
    8 => '"Dibutuhkan kekuatan dan keberanian untuk mengakui kebenaran." - Rick Riordan',
    9 => '"Kejujuran itu seperti cermin. Sekali dia retak, pecah, maka jangan harap dia akan pulih seperti sedia kala. Jangan coba-coba bermain dengan cermin." - Tere Liye',
];
?>

<div>
    <div class="text-center">
        <img src="<?= base_url('assets/img/exam_paper.png') ?>" alt="welcome" height="256" onclick="window.location.replace('<?= site_url('auth/pengawas'); ?>')">
        <p class="lead my-3">
            <?= $quotes[random_int(0,9)]; ?>
        </p>
        <a href="<?= site_url('auth/mahasiswa'); ?>" class="btn btn-primary mt-3 w-100">Mulai Sekarang ..</a>
    </div>
</div>