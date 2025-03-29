<?php
    include "../../_Config/Connection.php";
    //StandarHarga
    if(!empty($_POST['StandarHarga'])){
        $StandarHarga= $_POST['StandarHarga'];
    }else{
        $StandarHarga="";
    }
    //IdBarang
    if(!empty($_POST['IdBarang'])){
        $IdBarang= $_POST['IdBarang'];
    }else{
        $IdBarang="";
    }
    //id_multi
    if(!empty($_POST['id_multi'])){
        $id_multi= $_POST['id_multi'];
    }else{
        $id_multi="";
    }
    //Data muti_harga
    $QryMulti = mysqli_query($conn, "SELECT * FROM muti_harga WHERE id_multi='$id_multi'")or die(mysqli_error($conn));
    $DataMulti = mysqli_fetch_array($QryMulti);
    $harga1=$DataMulti['harga1'];
    $harga2=$DataMulti['harga2'];
    $harga3=$DataMulti['harga3'];
    $harga4=$DataMulti['harga4'];
    if($StandarHarga=="harga_1"){
        $harga=$harga1;
    }else{
        if($StandarHarga=="harga_2"){
            $harga=$harga2;
        }else{
            if($StandarHarga=="harga_3"){
                $harga=$harga3;
            }else{
                if($StandarHarga=="harga_4"){
                    $harga=$harga4;
                }
            }
        }
    }
    echo"$harga";
?>