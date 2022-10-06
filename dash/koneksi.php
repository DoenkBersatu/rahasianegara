<?php 
$koneksi = new mysqli('localhost', 'dpmptgar_peron', 'Dodolgarut123_', 'dpmptgar_dtinvestasi');
if ($koneksi->connect_errno) {
    die("gagal konek nih bos ".$koneksi->connect_error);
}
?>