<?php
    //error display
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    //Menangkap data akses menjadi variabel
    $kode_transaksi=$_POST['kode_transaksi'];
    $query = mysqli_query($conn, "DELETE FROM transaksi WHERE kode_transaksi='$kode_transaksi'") or die(mysqli_error($conn));    
    if($query){
        $query2 = mysqli_query($conn, "DELETE FROM rincian_transaksi WHERE kode_transaksi='$kode_transaksi'") or die(mysqli_error($conn)); 
        if($query2){
            $query3 = mysqli_query($conn, "DELETE FROM pemberian_point WHERE kode_transaksi='$kode_transaksi'") or die(mysqli_error($conn));
            if($query3){
                echo '<b id="NotifikasiHapus">Berhasil</b>';
            }else{
                echo '<b id="NotifikasiHapus">Gagal</b>';
            }
        }else{
            echo '<b id="NotifikasiHapus">Gagal</b>';
        }
    }else{
        echo '<b id="NotifikasiHapus">Gagal</b>';
    }
?>