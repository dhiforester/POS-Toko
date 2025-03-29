<?php
    //error display
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    //Menangkap data akses menjadi variabel
    $id_obat=$_POST['id_obat'];
    $id_multi=$_POST['id_multi'];
    $query = mysqli_query($conn, "DELETE FROM muti_harga WHERE id_multi='$id_multi'") or die(mysqli_error($conn));    
    if($query){
        echo '<div id="NotifikasiDeleteMultiHargaBerhasil">Berhasil</div>';
    }else{
        echo '<div id="NotifikasiDeleteMultiHargaBerhasil">Gagal</div>';
    }
?>