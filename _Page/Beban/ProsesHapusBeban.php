<?php
    //error display
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    //Menangkap data akses menjadi variabel
    $id_beban=$_POST['id_beban'];
    $query = mysqli_query($conn, "DELETE FROM beban WHERE id_beban='$id_beban'") or die(mysqli_error($conn));    
    if($query){
        echo '<div id="NotifikasiHapusBebanBerhasil">Berhasil</div>';
    }else{
        echo '<div id="NotifikasiHapusBebanBerhasil">Hapus Data Gagal</div>';
    }
?>