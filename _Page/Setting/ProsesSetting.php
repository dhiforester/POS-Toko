<?php
//tangkap parameter
include "../../_Config/Connection.php";
$kategori=$_POST['kategori'];
$margin_atas=$_POST['margin_atas'];
$margin_bawah=$_POST['margin_bawah'];
$margin_kiri=$_POST['margin_kiri'];
$margin_kanan=$_POST['margin_kanan'];
$panjang_x=$_POST['panjang_x'];
$lebar_y=$_POST['lebar_y'];
$jenis_font=$_POST['jenis_font'];
$ukuran_font=$_POST['ukuran_font'];
$warna_font=$_POST['warna_font'];
//proses
$hasil = mysqli_query($conn, "UPDATE setting_cetak SET 
margin_atas='$margin_atas',
margin_bawah='$margin_bawah',
margin_kiri='$margin_kiri',
margin_kanan='$margin_kanan',
panjang_x='$panjang_x',
lebar_y='$lebar_y',
jenis_font='$jenis_font',
ukuran_font='$ukuran_font',
warna_font='$warna_font'
WHERE kategori_setting='$kategori'") or die(mysqli_error($conn));
if($hasil){ 
	echo '<div class="alert alert-success" role="alert">';
	echo '  Perubahan Setting Percetakan Berhasil Dilakukan, Silahkan periksa perubahan tersebut pada modul cetak.';
	echo '</div>';
}else{
	echo '<div class="alert alert-danger" role="alert">';
	echo '  <b>Maaf!!</b> terjadi kesalahan pada saat proses update pengaturan.';
	echo '</div>';
}

?>