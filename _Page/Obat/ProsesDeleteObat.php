<?php
    //error display
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    //Menangkap data akses menjadi variabel
    $id_obat=$_POST['id_obat'];
    $query = mysqli_query($conn, "DELETE FROM obat WHERE id_obat='$id_obat'") or die(mysqli_error($conn));    
    if($query){
        $HapusMultiHarga = mysqli_query($conn, "DELETE FROM muti_harga WHERE id_barang='$id_obat'") or die(mysqli_error($conn));    
        if($HapusMultiHarga){
            echo '<div id="NotifikasiDeleteObatBerhasil">Berhasil</div>';
        }else{
            echo '<div id="NotifikasiDeleteObatBerhasil">Gagal</div>';
        }
    }else{
        echo '<div id="NotifikasiDeleteObatBerhasil">Gagal</div>';
    }
?>