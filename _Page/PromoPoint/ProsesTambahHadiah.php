<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    //Menangkap data akses menjadi variabel
    //Data Point
    if(empty($_POST['point'])){
        $point="0";
    }else{
        $point=$_POST['point'];
    }
    //Data ID Barang
    if(empty($_POST['id_hadiah'])){
        $id_hadiah="";
    }else{
        $id_hadiah=$_POST['id_hadiah'];
    }
    //Validasi jumlah nik yang sama
    $JumlahData = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM hadiah WHERE id_barang='$id_hadiah'"));
    //Apabila JumlahData sudah ada
    if(!empty($JumlahData)){
        echo '<div class="alert alert-warning" role="alert">';
        echo '  <strong>KETERANGAN :</strong><br> Data hadiah yang anda input sudah terdaftar.';
        echo '</div>';
    }else{
        //apabila point formatnya salah
        if (!preg_match("/^[0-9]*$/",$point)) { 
            echo '<div class="alert alert-warning" role="alert">';
            echo '  <strong>KETERANGAN :</strong><br> Sistem hanya menerima format angka untuk form point.';
            echo '</div>';
        }else{
            //Buka data barang
            $QryObat = mysqli_query($conn, "SELECT * FROM obat WHERE id_obat='$id_hadiah'")or die(mysqli_error($conn));
            $DataObat = mysqli_fetch_array($QryObat);
            $nama= $DataObat['nama'];
            $kode = $DataObat['kode'];
            //apabila syarat terpenuhi lakukan input
            $entry="INSERT INTO hadiah (
                id_barang,
                kode,
                nama,
                point
            ) VALUES (
                '$id_hadiah',
                '$kode',
                '$nama',
                '$point'
            )";
            $hasil=mysqli_query($conn, $entry);
            if($hasil){
                echo '<div class="alert alert-success" role="alert">';
                echo '  <strong>KETERANGAN INPUT DATA:</strong><div id="NotifikasiTambahHadiahBerhasil">Berhasil</div>.';
                echo '</div>';
            }else{
                echo '<div class="alert alert-warning" role="alert">';
                echo '  <strong>KETERANGAN :</strong><br> Input data hadiah gagal, periksa koneksi database anda.<br>';
                echo '</div>';
            }
        }
    }
?>