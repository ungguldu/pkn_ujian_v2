## Aplikasi Portal Ujian BAK PKN STAN

adalah sistem aplikasi sederhana sebagai manajemen ujian closed LAN pada PKN STAN

### Installasi

Untuk melakukan instalasi pada server development pastikan anda mempunyai web server dengan bahasa pemrograman PHP dan database Mysql.
Aplikasi ini membutuhkan `composer` sebagai packet manajernya dan git untuk pengelolaan sourcecodenya.

pastikan composer sudah terinstall dengan perintah:
```bash
composer --version
```

untuk melakukan deploy aplikasi lakukan perintah pada terminal sebagai berikut:
```bash
git clone http://10.40.4.5:8080/farisz/pkn_ujian.git

cd pkn_ujian
composer Install
```

kemudian sesuaikan config database pada `application/config/database.php` sesuai pengaturan pada server Anda.

tambahkan perintah pada terminal

```bash
php public\index.php dev do_migration
```
perintah diatas akan melakukan instalasi database yang diperlukan. Coba akses aplikasi pada browser untuk memastikan.