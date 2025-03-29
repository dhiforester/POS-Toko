<?php
    ini_set("display_errors","off");
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    //Variable yang akan di entry
    $id_pelanggan= $_POST ["id_pelanggan"];
    $tanggal= $_POST ["tanggal"];
    $tujuan_pembayaran= $_POST ["tujuan_pembayaran"];
    $rekening= $_POST ["rekening"];
    $nominal= $_POST ["nominal"];
    $no_resi= $_POST ["no_resi"];
    $BuktiLama= $_POST ["BuktiLama"];
    //Tangkap File
    $tmp = $_FILES['ForoBukti']['tmp_name'];
    $type = $_FILES['ForoBukti']['type'];
    $size = $_FILES['ForoBukti']['size'];
    $filename = $_FILES['ForoBukti']['name'];
    $path = "../../images/pembayaran/".$filename;
    //Periksa apakah file ada yang sama
    if($BuktiLama!=="$filename"){
        $query_cek = mysql_query("SELECT * FROM pembayaran WHERE bukti_pembayaran='$filename'") or die(mysql_error());
        $data_cek = mysql_fetch_array($query_cek);
        $TersediaFile=$data_cek['bukti_pembayaran'];
    }else{
        $TersediaFile="0";
    }
    //Apabila tidak ada file yang di upload
    if(!empty($filename)){
        //Apabila File Belum Ada
        if(empty($TersediaFile)){
            //Apabila file terlalu besar
            if($size<"100000"){
                //Apabila format file gambar
                if($type=="image/jpeg"||$type=="image/jpg"||$type=="image/gif"||$type=="image/x-png"){
                    //Apabila upload berhasil
                    if(move_uploaded_file($tmp, $path)){
                        $hasil = mysql_query("UPDATE pembayaran SET 
                        tanggal='$tanggal',
                        no_rek='$rekening',
                        no_bukti='$no_resi',
                        bukti_pembayaran='$filename'
                        WHERE id_pelanggan='$id_pelanggan' AND tujuan_pembayaran='Pembayaran Biaya Pemasangan'") or die(mysql_error()); 
                        if($hasil){
                            echo "<b id='NotifikasiEditPembayaranPendaftaranBerhasil'>Berhasil</b>";
                        }else{
                            echo "<b class=text-danger>Proses menyimpan data pada database gagal!</b>";
                            echo "id pelanggan : $id_pelanggan <br>";
                            echo "size: $size <br>";
                            echo "type : $type <br>";
                            echo "file name : $filename <br>";
                        }
                    }else{
                        echo "<b class=text-danger>Proses upload gagal, coba lagi!</b>";
                    }
                }else{
                    echo "<b class=text-danger>Tipe file $type tidak didukung oleh sistem!!</b>";
                }
            }else{
                echo "<b class=text-danger>Kapasitas file terlalu besar ($size)!!</b>";
            }
        }else{
            echo "<b class=text-danger>File ($filename) tersebut sudah ada pada database!!</b>";
        }
    }else{
        $hasil = mysql_query("UPDATE pembayaran SET 
            tanggal='$tanggal',
            no_rek='$rekening',
            no_bukti='$no_resi'
        WHERE id_pelanggan='$id_pelanggan' AND tujuan_pembayaran='Pembayaran Biaya Pemasangan'") or die(mysql_error()); 
        if($hasil){
            echo "<b id='NotifikasiEditPembayaranPendaftaranBerhasil'>Berhasil</b>";
        }else{
            echo "<b class=text-danger>Proses menyimpan data pada database gagal!</b>";
        }
    }
?>