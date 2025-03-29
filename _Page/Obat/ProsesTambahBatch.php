<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    //Apabila no_batch kosong
    if(empty($_POST['no_batch'])){
        echo '<i class="text-danger" id="NotifikasiTambahBatchBerhasil">No.Batch Kosong</i>';
    }else{
        //Apabila Nama Kosong
        if(empty($_POST['id_obat'])){
            echo '<i class="text-danger" id="NotifikasiTambahBatchBerhasil">id obat Kosong</i>';
        }else{
            $no_batch=$_POST['no_batch'];
            $id_obat=$_POST['id_obat'];
            $exp=$_POST['exp'];
            //Validasi kode yang sama
            $CekKode = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM batch WHERE no_batch='$no_batch'"));
            //Apabila kode sudah ada
            if(!empty($CekKode)){
                echo '<i class="text-danger" id="NotifikasiTambahBatchBerhasil">No.Batch Sudah Terdaftar</i>';
            }else{
                //apabila syarat terpenuhi lakukan input
                $entry="INSERT INTO batch (id_obat,no_batch,exp) VALUES ('$id_obat','$no_batch','$exp')";
                $hasil=mysqli_query($conn, $entry);
                if($hasil){
                    echo '<i id="NotifikasiTambahBatchBerhasil">Berhasil</i>';
                }else{
                    echo '<i id="NotifikasiTambahBatchBerhasil">Gagal</i>';
                }
            }
        }
    }
?>