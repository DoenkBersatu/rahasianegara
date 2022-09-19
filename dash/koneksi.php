<?php 
$koneksi = new mysqli('host', 'user', 'password', 'database');
if ($koneksi->connect_errno) {
    die("gagal konek nih bos ".$koneksi->connect_error);
}
?>