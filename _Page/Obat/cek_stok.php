<?php
    //koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    //Tangkap variabel
    $stok=$_POST['stok'];
    //Apabila kosong
    if(empty($stok)){
        echo '';
    }else{
        if (preg_match("/^[0-9.]*$/",$stok)) { 
            echo '<i class="text-success">';
            echo '  <i class="menu-icon mdi mdi-check"></i>';
            echo '</i>';
		}else{
            echo '<i class="text-danger">';
            echo '  (Hanya Boleh Angka!!)';
            echo '</i>';
        }
    }
    
?>