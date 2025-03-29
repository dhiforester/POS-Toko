<?php
    //koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    //Tangkap variabel
    $nama=$_POST['nama'];
    //Apabila kosong
    if(empty($nama)){
        echo '<i class="text-danger">';
        echo '  (Tidak Boleh Kosong!!)';
        echo '</i>';
    }else{
        //Cek apakah kode sudah ada
        $CekNamaObat = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM obat WHERE nama='$nama'"));
        if(empty($CekNamaObat)){
            echo '<i class="text-success">';
            echo '  <i class="menu-icon mdi mdi-check"></i>';
            echo '</i>';
        }else{
            echo '<i class="text-danger">';
            echo '  (Sudah Ada!!)';
            echo '</i>';
        }
    }
?>