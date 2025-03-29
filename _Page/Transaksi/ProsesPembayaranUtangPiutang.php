<?php
    //Tanggal dan koneksi
    date_default_timezone_set('Asia/Jakarta');
    //Buat Timestamp
    $milliseconds =$_POST['milliseconds'];
    include "../../_Config/Connection.php";
    include "../../_Config/SessionLogin.php";
    //Apakah data sudah ada?
    $DuplikatTime = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM utang_piutang WHERE milliseconds='$milliseconds'"));
    if(!empty($_POST['uang'])){
        if(empty($DuplikatTime)){
            //Tangkap variabel id_utang_piutang
            if(!empty($_POST['id_utang_piutang'])){
                $id_utang_piutang=$_POST['id_utang_piutang'];
            }else{
                $id_utang_piutang="";
            }
            //Tangkap variabel id_transaksi
            if(!empty($_POST['id_transaksi'])){
                $id_transaksi=$_POST['id_transaksi'];
            }else{
                $id_transaksi="";
            }
            //Tangkap variabel NewOrEdit
            if(!empty($_POST['NewOrEdit'])){
                $NewOrEdit=$_POST['NewOrEdit'];
            }else{
                $NewOrEdit="";
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
            //Tangkap variabel kode_transaksi
            if(!empty($_POST['kode_transaksi'])){
                $kode_transaksi=$_POST['kode_transaksi'];
            }else{
                $kode_transaksi="";
            }
            //Tangkap variabel kode_transaksi
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
            //Lakukan Input Data
            if($NewOrEdit=="New"){
                $DuplikatKode = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM utang_piutang WHERE kode='$kode'"));
                //Kode tidak boleh duplikat
                if(empty($DuplikatKode)){
                    //Apabila baru maka lakukan input
                    $InnputData="INSERT INTO utang_piutang (
                        kode,
                        tanggal,
                        milliseconds,
                        id_transaksi,
                        uang,
                        keterangan
                    ) VALUES (
                        '$kode',
                        '$tanggal',
                        '$milliseconds',
                        '$id_transaksi',
                        '$uang',
                        '$keterangan'
                    )";
                    $HasilInputData=mysqli_query($conn, $InnputData);
                    if($HasilInputData){
                        //Buka data transaksi untuk melihat data selisih
                        $QryTransaksi = mysqli_query($conn, "SELECT * FROM transaksi WHERE id_transaksi='$id_transaksi'")or die(mysqli_error($conn));
                        $DataTransaksi = mysqli_fetch_array($QryTransaksi);
                        $trans=$DataTransaksi['jenis_transaksi'];
                        $total_tagihan=$DataTransaksi['total_tagihan'];
                        $pembayaran=$DataTransaksi['pembayaran'];
                        if($pembayaran==$total_tagihan){
                            $PembayaranBaru=$pembayaran;
                            $SelisihBaru=$total_tagihan-$PembayaranBaru;
                        }else{
                            if($pembayaran>$total_tagihan){
                                $PembayaranBaru=$pembayaran-$uang;
                                $SelisihBaru=$total_tagihan-$PembayaranBaru;
                            }else{
                                $PembayaranBaru=$pembayaran+$uang;
                                $SelisihBaru=$total_tagihan-$PembayaranBaru;
                            }
                        }
                        
                        //Buat keetrangan baru berdasarkan jenis transaksi
                        if($trans=="penjualan"){
                            if($SelisihBaru=="0"){
                                $KeteranganBaru="Lunas";
                            }else{
                                if($SelisihBaru>0){
                                    $KeteranganBaru="Piutang";
                                }else{
                                    $KeteranganBaru="Utang";
                                    $SelisihBaru=$SelisihBaru*-1;
                                }
                            }
                        }else{
                            if($SelisihBaru=="0"){
                                $KeteranganBaru="Lunas";
                            }else{
                                if($SelisihBaru>0){
                                    $KeteranganBaru="Utang";
                                }else{
                                    $KeteranganBaru="Piutang";
                                    $SelisihBaru=$SelisihBaru*-1;
                                }
                            }
                        }
                        //Update pada data transaksi
                        $UpdateTransaksi = mysqli_query($conn, "UPDATE transaksi SET 
                            pembayaran='$PembayaranBaru',
                            selisih='$SelisihBaru',
                            keterangan='$KeteranganBaru'
                        WHERE id_transaksi='$id_transaksi'") or die(mysqli_error($conn));
                        if($UpdateTransaksi){
                            echo "<small class='text-danger' id='NotifikasiBerhasil'>Berhasil</small>";
                        }else{
                            echo "<small class='text-danger' id='NotifikasiBerhasil'>Update data transaksi gagal, periksa kembali data yang diinput.</small>";
                        }
                    }else{
                        echo "<small class='text-danger' id='NotifikasiBerhasil'>Input data pembayaran gagal, periksa kembali data yang diinput.<br> time: $milliseconds</small>";
                    }
                }else{
                    echo "<small class='text-danger' id='NotifikasiBerhasil'>Kode Tidak boleh duplikat.<br> time: $kode</small>";
                }
            }else{
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
                //Apabila data lama maka lakukan edit
                $UpdatePembayaranUtangPiutang = mysqli_query($conn, "UPDATE utang_piutang SET 
                    kode='$kode',
                    tanggal='$tanggal',
                    id_transaksi='$id_transaksi',
                    uang='$uang',
                    keterangan='$keterangan'
                WHERE id_utang_piutang='$id_utang_piutang'") or die(mysqli_error($conn));
                //Apabila update berhasil
                if($UpdatePembayaranUtangPiutang){
                    //Buka data transaksi untuk melihat data selisih
                    $QryTransaksi = mysqli_query($conn, "SELECT * FROM transaksi WHERE id_transaksi='$id_transaksi'")or die(mysqli_error($conn));
                    $DataTransaksi = mysqli_fetch_array($QryTransaksi);
                    $trans=$DataTransaksi['jenis_transaksi'];
                    $total_tagihan=$DataTransaksi['total_tagihan'];
                    $pembayaran=$DataTransaksi['pembayaran'];
                    if($pembayaran==$total_tagihan){
                        $PembayaranBaru=$pembayaran;
                        $SelisihBaru=$total_tagihan-$PembayaranBaru;
                    }else{
                        if($pembayaran>$total_tagihan){
                            $PembayaranBaru=$pembayaran-$uang;
                            $SelisihBaru=$total_tagihan-$PembayaranBaru;
                        }else{
                            $PembayaranBaru=$pembayaran+$uang;
                            $SelisihBaru=$total_tagihan-$PembayaranBaru;
                        }
                    }
                    
                    //Buat keetrangan baru berdasarkan jenis transaksi
                    if($trans=="penjualan"){
                        if($SelisihBaru=="0"){
                            $KeteranganBaru="Lunas";
                        }else{
                            if($SelisihBaru>0){
                                $KeteranganBaru="Piutang";
                            }else{
                                $KeteranganBaru="Utang";
                                $SelisihBaru=$SelisihBaru*-1;
                            }
                        }
                    }else{
                        if($SelisihBaru=="0"){
                            $KeteranganBaru="Lunas";
                        }else{
                            if($SelisihBaru>0){
                                $KeteranganBaru="Utang";
                            }else{
                                $KeteranganBaru="Piutang";
                                $SelisihBaru=$SelisihBaru*-1;
                            }
                        }
                    }
                    //Update pada data transaksi
                    $UpdateTransaksi = mysqli_query($conn, "UPDATE transaksi SET 
                        pembayaran='$PembayaranBaru',
                        selisih='$SelisihBaru',
                        keterangan='$KeteranganBaru'
                    WHERE id_transaksi='$id_transaksi'") or die(mysqli_error($conn));
                    if($UpdateTransaksi){
                        echo "<small class='text-danger' id='NotifikasiBerhasil'>Berhasil</small>";
                    }else{
                        echo "<small class='text-danger' id='NotifikasiBerhasil'>Update data transaksi gagal, periksa kembali data yang diinput.</small>";
                    }
                //Apabila update gagal
                }else{
                    echo "<small class='text-danger' id='NotifikasiBerhasil'>Update data pembayaran gagal, periksa kembali data yang diinput.</small>";
                }
            }
        }
    }
?>