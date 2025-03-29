<?php
    //KONEKSI KE DATABASE SQL
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    //TANGKAP VARIABEL DARI FORMULIR LOGIN.PHP
    $username=$_POST["username"];
    $password=$_POST["password"];
    //QUERY MEMANGGIL DATA DARI DATABASE PELANGGAN
    $QueryLogin = mysqli_query($conn, "SELECT * FROM user WHERE username='$username' AND password='$password'")or die(mysqli_error($conn));
    $DataLogin= mysqli_fetch_array($QueryLogin);
    $IdAkses=$DataLogin["id_user"];
    $MyUsername=$DataLogin["username"];
    $MyPassword=$DataLogin["password"];
    $MyLevel=$DataLogin["level_akses"];
    //CEK APAKAH USERNAME ADA DALAM DATABASE
    if(!empty($IdAkses)){
        //Jika valid-langsung masuk SESSION Siswa
        session_start();
        $_SESSION ["IdUser"]= $IdAkses;
        echo '<div id="notifikasi">Berhasil</div>';
    }else{
        echo '<div id="notifikasi">Proses Login Gagal, Cek Kembali username dan passwordnya ('.$IdAkses .':'.$username.':'.$password.')</div>';
    }	

?>