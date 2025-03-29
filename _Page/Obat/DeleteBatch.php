<?php
    //error display
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    //Menangkap data akses menjadi variabel
    $id_batch=$_POST['id_batch'];
    $query = mysqli_query($conn, "DELETE FROM batch WHERE id_batch='$id_batch'") or die(mysqli_error($conn));    
    if($query){
        echo '<div id="notifikasi">Berhasil</div>';
    }else{
        echo '<div id="notifikasi">Gagal</div>';
    }
?>