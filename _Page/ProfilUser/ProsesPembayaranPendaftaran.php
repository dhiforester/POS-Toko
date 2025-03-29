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
    $tmp = $_FILES['ForoBukti']['tmp_name'];
    $type = $_FILES['ForoBukti']['type'];
    $size = $_FILES['ForoBukti']['size'];
    $filename = $_FILES['ForoBukti']['name'];
    $path = "../../images/pembayaran/".$filename;
    //Periksa apakah file ada yang sama
    $query_cek = mysql_query("SELECT * FROM pembayaran WHERE bukti_pembayaran='$filename'") or die(mysql_error());
    $data_cek = mysql_fetch_array($query_cek);
    $TersediaFile=$data_cek['bukti_pembayaran'];
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
                        $entry="INSERT INTO pembayaran (
                            id_pelanggan,
                            tanggal,
                            tujuan_pembayaran,
                            no_rek,
                            nominal_pembayaran,
                            no_bukti,
                            bukti_pembayaran,
                            status
                            )VALUES (
                            '$id_pelanggan', 
                            '$tanggal',
                            '$tujuan_pembayaran',
                            '$rekening',
                            '$nominal',
                            '$no_resi',
                            '$filename',
                            'Menunggu Konfirmasi'
                        )";
                        $hasil=mysql_query($entry);
                        if($hasil){
                            echo "<b id='NotifikasiPembayaranPendaftaranBerhasil'>Berhasil</b>";
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
       echo "<b class=text-danger>File masih kosong!! <br> filename : $filename <br> Id Pelanggan : $id_pelanggan <br> Size: $size</b>";
    }
?>