<?php 
$mysqli = new mysqli('localhost', 'root', '', 'dpmptgar_dtinvestasi');
if ($mysqli->connect_errno) { // JIKA KONEKSI BERMASALAH
	die('kesalahan saat membuat koneksi ke database. <br>' . $mysqli->error);
}
?>

