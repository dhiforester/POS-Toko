<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    //Menangkap data akses menjadi variabel
    $nik=$_POST['nik'];
    $nama=$_POST['nama'];
    $kontak=$_POST['kontak'];
    $alamat=$_POST['alamat'];
    $kategori=$_POST['kategori'];
    
    if(empty($_POST['point'])){
        $point="0";
    }else{
        $point=$_POST['point'];
    }
    //Validasi jumlah nik yang sama
    $JumlahNik = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM member WHERE nik='$nik'"));
    //Apabila nik sudah ada
    if(!empty($JumlahNik)){
        echo '<div class="alert alert-warning" role="alert">';
        echo '  <strong>KETERANGAN :</strong><br> ID Member yang anda input sudah terdaftar, member ini mungkin orang yang sama.';
        echo '</div>';
    }else{
        //apabila nik formatnya salah
        if (!preg_match("/^[0-9]*$/",$kontak)) { 
            echo '<div class="alert alert-warning" role="alert">';
            echo '  <strong>KETERANGAN :</strong><br> Sistem hanya menerima format angka untuk form kontak.';
            echo '</div>';
        }else{
            //apabila syarat terpenuhi lakukan input
            $entry="INSERT INTO member (
                nik,
                nama,
                alamat,
                kontak,
                kategori,
                point
            ) VALUES (
                '$nik',
                '$nama',
                '$alamat',
                '$kontak',
                '$kategori',
                '$point'
            )";
            $hasil=mysqli_query($conn, $entry);
            if($hasil){
                echo '<div class="alert alert-success" role="alert">';
                echo '  <strong>KETERANGAN INPUT DATA:</strong><div id="NotifikasiTambahMemberBerhasil">Berhasil</div>.';
                echo '</div>';
            }else{
                echo '<div class="alert alert-warning" role="alert">';
                echo '  <strong>KETERANGAN :</strong><br> Input data member gagal, periksa koneksi database anda.<br>';
                echo '</div>';
            }
        }
    }
?>