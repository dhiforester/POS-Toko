<?php
    //error display
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    if(empty($_POST['id_klaim'])){
        echo '<small><b>Keterangan: Id Data Tidak Ditemukan</b></small>';
    }else{
        //Menangkap data akses menjadi variabel
        $id_klaim=$_POST['id_klaim'];
        //Buka data Klaim
        $QryKlaim = mysqli_query($conn, "SELECT * FROM klaim WHERE id_klaim='$id_klaim'")or die(mysqli_error($conn));
        $DataKlaim = mysqli_fetch_array($QryKlaim);
        $id_member= $DataKlaim['id_member'];
        $id_hadiah = $DataKlaim['id_hadiah'];
        $point = $DataKlaim['point'];
        //Buka data member
        $QryMember = mysqli_query($conn, "SELECT * FROM member WHERE id_member='$id_member'")or die(mysqli_error($conn));
        $DataMember= mysqli_fetch_array($QryMember);
        $PointMemberLama= $DataMember['point'];
        //Buat Point Member Baru
        $PointMemberBaru=$PointMemberLama+$point;
        //Hapus Data Klaim
        $HapusKlaim = mysqli_query($conn, "DELETE FROM klaim WHERE id_klaim='$id_klaim'") or die(mysqli_error($conn));    
        if($HapusKlaim){
            //Update Point Member
            $UpdatePointMember = mysqli_query($conn, "UPDATE member SET 
                point='$PointMemberBaru'
            WHERE id_member='$id_member'") or die(mysqli_error($conn)); 
            if($UpdatePointMember){
                echo '<div id="NotifikasiDeleteKlaimBerhasil">Berhasil</div>';
            }else{
                echo '<b>Keterangan :</b> Terjadi Kegagalan Pada Saat Update Point Member';
            }
        }else{
            echo '<b>Keterangan :</b> Terjadi Kegagalan Pada Saat Hapus Data Klaim';
        }
    }
?>