<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    //Menangkap data akses menjadi variabel
    $id_member=$_POST['IdMember'];
    $nik=$_POST['nik'];
    $NikLama=$_POST['NikLama'];
    $nama=$_POST['nama'];
    $kontak=$_POST['kontak'];
    $kategori=$_POST['kategori'];
    $point=$_POST['point'];
    $alamat=$_POST['alamat'];
    $page=$_POST['page'];
    $BatasData=$_POST['BatasData'];
    //Validasi jumlah nik yang sama
    if($nik==$NikLama){
        $JumlahNik ="0";
    }else{
        $JumlahNik = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM member WHERE nik='$nik'"));
    }
    //Apabila nik sudah ada
    if(!empty($JumlahNik)){
        echo '<div class="alert alert-warning" role="alert">';
        echo '  <strong>KETERANGAN :</strong><br> ID Member yang anda input sudah terdaftar, member ini mungkin orang yang sama.';
        echo '</div>';
    }else{
        //apabila format Kontak Tidak Sesuai
        if (!preg_match("/^[0-9]*$/",$kontak)) { 
            echo '<div class="alert alert-warning" role="alert">';
            echo '  <strong>KETERANGAN :</strong><br> Sistem hanya menerima format angka untuk form kontak.';
            echo '</div>';
        }else{
            //apabila syarat terpenuhi lakukan input
            $hasil = mysqli_query($conn, "UPDATE member SET 
                nik='$nik',
                nama='$nama',
                kontak='$kontak',
                kategori='$kategori',
                alamat='$alamat',
                point='$point'
            WHERE id_member='$id_member'") or die(mysqli_error($conn)); 
            if($hasil){
                echo '<div class="alert alert-success" role="alert">';
                echo '  <strong>KETERANGAN INPUT DATA:</strong><div id="NotifikasiEditMemberBerhasil">Berhasil</div>.';
                echo '  <div id="page">'.$page.'</div>.';
                echo '  <div id="BatasData">'.$BatasData.'</div>.';
                echo '</div>';
            }else{
                echo '<div class="alert alert-warning" role="alert">';
                echo '  <strong>KETERANGAN :</strong><br> Input data member gagal, periksa koneksi database anda.<br>';
                echo '</div>';
            }
        }
    }
?>