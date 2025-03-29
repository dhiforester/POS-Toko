<?php
    //Tanggal dan koneksi
    date_default_timezone_set('Asia/Jakarta');
    //Buat Timestamp
    include "../../_Config/Connection.php";
    //Tangkap variabel id_utang_piutang
    if(!empty($_POST['id_utang_piutang'])){
        $id_utang_piutang=$_POST['id_utang_piutang'];
    }else{
        $id_utang_piutang="";
    }
    //Buka data pembayaran lama
    $QryUtangPiutang = mysqli_query($conn, "SELECT * FROM utang_piutang WHERE id_utang_piutang='$id_utang_piutang'")or die(mysqli_error($conn));
    $DataUtangPiutang = mysqli_fetch_array($QryUtangPiutang);
    $id_transaksiPembayaran=$DataUtangPiutang['id_transaksi'];
    $UangLama=$DataUtangPiutang['uang'];
    $KeteranganUtangPiutangLama=$DataUtangPiutang['keterangan'];
    //Buka data transaksi untuk melihat data selisih
    $QryTransaksi = mysqli_query($conn, "SELECT * FROM transaksi WHERE id_transaksi='$id_transaksiPembayaran'")or die(mysqli_error($conn));
    $DataTransaksi = mysqli_fetch_array($QryTransaksi);
    $trans=$DataTransaksi['jenis_transaksi'];
    $total_tagihan=$DataTransaksi['total_tagihan'];
    $pembayaran=$DataTransaksi['pembayaran'];
    $selisih=$DataTransaksi['selisih'];
    $keteranganTransaksi=$DataTransaksi['keterangan'];
    //Buat pembayaran,selsiih,keterangan baru dari informasi di atas
    if($trans=="penjualan"){
        if($KeteranganUtangPiutangLama=="Pembayaran Utang"){
            $pembayaranBaru=$pembayaran+$UangLama;
            $selisihBaru=$total_tagihan-$pembayaranBaru;
            if($selisihBaru=="0"){
                $keteranganBaru="Lunas";
            }else{
                if($selisihBaru=="0"){
                    $keteranganBaru="Lunas";
                }else{
                    if($selisihBaru>0){
                        $keteranganBaru="Piutang";
                    }else{
                        $keteranganBaru="Utang";
                        $selisihBaru=$selisihBaru*-1;
                    }
                }  
            }
        }else{
            $pembayaranBaru=$pembayaran-$UangLama;
            $selisihBaru=$total_tagihan-$pembayaranBaru;
            if($selisihBaru=="0"){
                $keteranganBaru="Lunas";
            }else{
                if($selisihBaru=="0"){
                    $keteranganBaru="Lunas";
                }else{
                    if($selisihBaru>0){
                        $keteranganBaru="Piutang";
                    }else{
                        $keteranganBaru="Utang";
                        $selisihBaru=$selisihBaru*-1;
                    }
                }  
            }
        }
    }else{
        if($KeteranganUtangPiutangLama=="Pembayaran Utang"){
            $pembayaranBaru=$pembayaran-$UangLama;
            $selisihBaru=$total_tagihan-$pembayaranBaru;
            if($selisihBaru=="0"){
                $keteranganBaru="Lunas";
            }else{
                if($selisihBaru=="0"){
                    $keteranganBaru="Lunas";
                }else{
                    if($selisihBaru>0){
                        $keteranganBaru="Utang";
                    }else{
                        $keteranganBaru="Piutang";
                        $selisihBaru=$selisihBaru*-1;
                    }
                }  
            }
        }else{
            $pembayaranBaru=$pembayaran+$UangLama;
            $selisihBaru=$total_tagihan-$pembayaranBaru;
            if($selisihBaru=="0"){
                $keteranganBaru="Lunas";
            }else{
                if($selisihBaru=="0"){
                    $keteranganBaru="Lunas";
                }else{
                    if($selisihBaru>0){
                        $keteranganBaru="Utang";
                    }else{
                        $keteranganBaru="Piutang";
                        $selisihBaru=$selisihBaru*-1;
                    }
                }  
            }
        }
    }
    //Update Pembayaran Transaksi
    $UpdateTransaksi = mysqli_query($conn, "UPDATE transaksi SET pembayaran='$pembayaranBaru', selisih='$selisihBaru', keterangan='$keteranganBaru' WHERE id_transaksi='$id_transaksiPembayaran'") or die(mysqli_error($conn));
    if($UpdateTransaksi){
        //Lakukan hapus utangpiutang
        $HapusUtangPiutang = mysqli_query($conn, "DELETE FROM utang_piutang WHERE id_utang_piutang='$id_utang_piutang'") or die(mysqli_error($conn));    
        //Apabila update berhasil
        if($HapusUtangPiutang){
            echo "<small class='text-danger' id='NotifikasiHutangPiutangBerhasil'>Berhasil</small>";
        //Apabila update gagal
        }else{
            echo "<small class='text-danger' id='NotifikasiHutangPiutangBerhasil'>Hapus Data gagal, periksa kembali data yang diinput sebelumnya.</small>";
        }
    }else{
        echo "<small class='text-danger' id='NotifikasiHutangPiutangBerhasil'>Update Transaksi Data gagal, lakukan perubahan manual pada data transaksi.</small>";  
    }
    
?>