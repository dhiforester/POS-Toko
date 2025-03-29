<?php
    //Tanggal dan koneksi
    date_default_timezone_set('Asia/Jakarta');
    //Buat Timestamp
    include "../../_Config/Connection.php";
    //Tangkap variabel
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
            $DuplikatKode = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM beban WHERE kode='$kode'"));
                //Kode tidak boleh duplikat
                if(empty($DuplikatKode)){
                    //Apabila baru maka lakukan input
                    $InnputData="INSERT INTO beban (
                        kode,
                        tanggal,
                        kategori,
                        uang,
                        keterangan,
                        milliseconds
                    ) VALUES (
                        '$kode',
                        '$tanggal',
                        '$kategori',
                        '$uang',
                        '$keterangan',
                        '$milliseconds'
                    )";
                    $HasilInputData=mysqli_query($conn, $InnputData);
                    if($HasilInputData){
                        echo "<small class='text-danger' id='NotifikasiTambahBebanBerhasil'>Berhasil</small>";
                        echo "<small class='text-danger' id='kodebeban'>$kode</small>";
                    }else{
                        echo "<small class='text-danger' id='NotifikasiTambahBebanBerhasil'>Gagal Input Data, Periksa Kembali Form Yang Anda Isi</small>";
                    }
                }else{
                    echo "<small class='text-danger' id='NotifikasiTambahBebanBerhasil'>Kode Tidak boleh duplikat.<br> Kode: $kode</small>";
                }
        }else{
            echo "<small class='text-danger' id='NotifikasiTambahBebanBerhasil'>Tidak Bisa Input Data Duplikat.</small>";   
        }
    }else{
        echo "<small class='text-danger' id='NotifikasiTambahBebanBerhasil'>Data Nilai Uang Kosong/Tidak Bisa Di input.</small>";
    }
?>