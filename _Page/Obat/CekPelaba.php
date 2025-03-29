<?php
    //Tangkap variabel
    if(empty($_POST['harga'])){
        echo "";
    }else{
        if(empty($_POST['pelaba'])){
            echo "";
        }else{
            $harga=$_POST['harga'];
            $pelaba=$_POST['pelaba'];
            if (preg_match("/^[0-9.]*$/",$harga)) { 
                if(preg_match("/^[0-9.]*$/",$pelaba)) { 
                   $RpHarga=($pelaba* $harga)/100;
                   $RpHarga=round($RpHarga, 2);
                   $HargaTarget=$harga+$RpHarga;
                   $HargaTarget=round($HargaTarget,2);
                   echo "$HargaTarget";
                }else{
                    echo "";
                }
            }else{
                echo "";
            }
        }
    }
?>