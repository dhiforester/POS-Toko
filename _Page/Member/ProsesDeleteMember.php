<?php
    //error display
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    //Menangkap data akses menjadi variabel
    $IdMember=$_POST['IdMember'];
    $query = mysqli_query($conn, "DELETE FROM member WHERE id_member='$IdMember'") or die(mysqli_error($conn));    
    if($query){
        echo '<div id="NotifikasiDeleteMemberBerhasil">Berhasil</div>';
    }else{
        echo '<div id="NotifikasiDeleteMemberBerhasil">Gagal</div>';
    }
?>