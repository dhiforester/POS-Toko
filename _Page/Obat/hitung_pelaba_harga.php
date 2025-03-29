<?php
    //koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    //Tangkap variabel
    $harga1=$_POST['harga1'];
    $harga2=$_POST['harga2'];
    //Apabila kosong
    if(empty($harga1)){
        echo '';
    }else{
        if (preg_match("/^[0-9.]*$/",$harga1)) { 
            $laba=$harga2-$harga1;
            $pelaba=($laba/$harga1)*100;
            echo round($pelaba,2);
		}else{
            echo '';
        }
    }
    
?>