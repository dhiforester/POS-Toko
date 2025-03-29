<?php
    //error display
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    //Menangkap data akses menjadi variabel
    $id_hadiah=$_POST['id_hadiah'];
    $query = mysqli_query($conn, "DELETE FROM hadiah WHERE id_hadiah='$id_hadiah'") or die(mysqli_error($conn));    
    if($query){
        echo '<div id="NotifikasiHapusHadiahBerhasil">Berhasil</div>';
    }else{
        echo '<div id="NotifikasiHapusHadiahBerhasil">Gagal</div>';
    }
?>