<?php
    //error display
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    //Menangkap data akses menjadi variabel
    $IdUser=$_POST['IdUser'];
    $query = mysqli_query($conn, "DELETE FROM user WHERE id_user='$IdUser'") or die(mysqli_error($conn));    
    if($query){
        echo '<div id="NotifikasiDeleteUserBerhasil">Berhasil</div>';
    }else{
        echo '<div id="NotifikasiDeleteUserBerhasil">Gagal</div>';
    }
?>