<?php
    //Tanggal dan koneksi
    date_default_timezone_set('Asia/Jakarta');
    //Buat Timestamp
    include "../../_Config/Connection.php";
    //Tangkap variabel
    //Tangkap variabel id_beban
    if(!empty($_POST['id_beban'])){
        $id_beban=$_POST['id_beban'];
    }else{
        $id_beban="";
    }
    //Tangkap variabel kode
    if(!empty($_POST['kode'])){
        $kode=$_POST['kode'];
    }else{
        $kode="";
    }
    //Tangkap variabel tanggal
    if(!empty($_POST['tanggal'])){
        $tanggal=$_POST['tanggal'];
    }else{
        $tanggal="";
    }
    //Tangkap variabel kategori
    if(!empty($_POST['kategori'])){
        $kategori=$_POST['kategori'];
    }else{
        $kategori="";
    }
    //Tangkap variabel uang
    if(!empty($_POST['uang'])){
        $uang=$_POST['uang'];
    }else{
        $uang="";
    }
    //Tangkap variabel keterangan
    if(!empty($_POST['keterangan'])){
        $keterangan=$_POST['keterangan'];
    }else{
        $keterangan="";
    }
    //Tangkap variabel milliseconds
    if(!empty($_POST['milliseconds'])){
        $milliseconds=$_POST['milliseconds'];
    }else{
        $milliseconds="";
    }
    //Bedakan mana 
    //Apakah data sudah ada?
    $DuplikatTime = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM beban WHERE milliseconds='$milliseconds'"));
    if(!empty($_POST['uang'])){
        if(empty($DuplikatTime)){
            //Lakukan Input Data
            $EditData = mysqli_query($conn, "UPDATE beban SET 
                kode='$kode',
                tanggal='$tanggal',
                kategori='$kategori',
                uang='$uang',
                keterangan='$keterangan',
                milliseconds='$milliseconds'
            WHERE id_beban='$id_beban'") or die(mysqli_error($conn));
            //Apabila update berhasil
            if($EditData){
                echo "<small class='text-danger' id='NotifikasiEditBebanBerhasil'>Berhasil</small>";
                echo "<small class='text-danger' id='kodebeban'>$kode</small>";
            //Apabila update gagal
            }else{
                echo "<small class='text-danger' id='NotifikasiEditBebanBerhasil'>Update data gagal, periksa kembali data yang diinput.</small>";
            }
        }else{
            echo "<small class='text-danger' id='NotifikasiEditBebanBerhasil'>Tidak Bisa Input Data Duplikat.</small>";   
        }
    }else{
        echo "<small class='text-danger' id='NotifikasiEditBebanBerhasil'>Data Nilai Uang Kosong/Tidak Bisa Di input.</small>";
    }
?>