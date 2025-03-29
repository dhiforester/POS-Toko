<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    //Menangkap data akses menjadi variabel
    $tanggal=date('Y-m-d H:i:s');
    //Data id_hadiah
    if(empty($_POST['id_hadiah'])){
        $id_hadiah="";
    }else{
        $id_hadiah=$_POST['id_hadiah'];
    }
    //Data id_member
    if(empty($_POST['id_member'])){
        $id_member="";
    }else{
        $id_member=$_POST['id_member'];
    }
    //Data hadiah
    if(empty($_POST['hadiah'])){
        $hadiah="";
    }else{
        $hadiah=$_POST['hadiah'];
    }
    //Data member
    if(empty($_POST['member'])){
        $member="";
    }else{
        $member=$_POST['member'];
    }
    //Data qty
    if(empty($_POST['qty'])){
        $qty="";
    }else{
        $qty=$_POST['qty'];
    }
    //Data PointHadiah
    if(empty($_POST['PointHadiah'])){
        $PointHadiah="";
    }else{
        $PointHadiah=$_POST['PointHadiah'];
    }
    //Data PointMember
    if(empty($_POST['PointMember'])){
        $PointMember="";
    }else{
        $PointMember=$_POST['PointMember'];
    }
    //Data point
    $point=$PointHadiah*$qty;
    //Point Member Baru
    $PointBaruMember=$PointMember-$point;
    //Apabila QTY Kosong
    if(empty($qty)){
        echo '<div class="alert alert-warning" role="alert">';
        echo '  <small>KETERANGAN :</strong><br> Jumlah Hadiah Tidak Boleh Kosong.</small><strong>';
        echo '</div>';
    }else{
        //apabila point member kurang
        if ($PointMember<$point) { 
            echo '<div class="alert alert-warning" role="alert">';
            echo '  <small>KETERANGAN :</strong><br> Maaf! Point tidak cukup.</small><strong>';
            echo '</div>';
        }else{
            //Input ke data klaim
            $entry="INSERT INTO klaim (
                id_member,
                id_hadiah,
                nama_hadiah,
                nama_member,
                tanggal,
                qty,
                point
            ) VALUES (
                '$id_member',
                '$id_hadiah',
                '$hadiah',
                '$member',
                '$tanggal',
                '$qty',
                '$point'
            )";
            $hasil=mysqli_query($conn, $entry);
            if($hasil){
                //Update point member
                $UpdatePointMember = mysqli_query($conn, "UPDATE member SET 
                    point='$PointBaruMember'
                WHERE id_member='$id_member'") or die(mysqli_error($conn)); 
                if($UpdatePointMember){
                    echo '<div class="alert alert-success" role="alert">';
                    echo '  <strong>KETERANGAN INPUT DATA:</strong><div id="NotifikasiSimpanKlaimBerhasil">Berhasil</div>.';
                    echo '</div>';
                }else{
                    echo '<div class="alert alert-warning" role="alert">';
                    echo '  <strong>KETERANGAN :</strong><br> Input data klaim gagal, periksa koneksi database anda.<br>';
                    echo '</div>';
                }
            }else{
                echo '<div class="alert alert-warning" role="alert">';
                echo '  <strong>KETERANGAN :</strong><br> Input data klaim gagal, periksa koneksi database anda.<br>';
                echo '</div>';
            }
        }
    }
?>