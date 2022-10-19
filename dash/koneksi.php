<?php 
$koneksi = new mysqli('localhost', 'root', '', 'dpmptgar_dtinvestasi');
if ($koneksi->connect_errno) {
    die("gagal konek nih bos ".$koneksi->connect_error);
}
?>