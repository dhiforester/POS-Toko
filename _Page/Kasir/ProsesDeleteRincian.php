<?php
    //koneksi dan error
    ini_set("display_errors","off");
    include "../../_Config/Connection.php";

    if(empty($_POST['id_rincian'])){
        echo '<div class="alert alert-danger" role="alert">';
        echo '   <b id="NotifikasiDeleteRincianBerhasil">Id Rincian Kosong!!</b>';
        echo '</div>';
    }else{
        $id_rincian=$_POST['id_rincian'];
        if(empty($_POST['NewOrEdit'])){
            $NewOrEdit="New";
        }else{
            $NewOrEdit=$_POST['NewOrEdit'];
        }
        if($NewOrEdit=="New"){
            $query = mysqli_query($conn, "DELETE FROM rincian_transaksi WHERE id_rincian='$id_rincian'") or die(mysqli_error($conn));    
            if($query){
                echo '<div class="alert alert-danger" role="alert">';
                echo '   <b id="NotifikasiDeleteRincianBerhasil">Berhasil</b>';
                echo '</div>';
            }else{
                echo '<div class="alert alert-danger" role="alert">';
                echo '   <b id="NotifikasiDeleteRincianBerhasil">Hapus Rincian Gagal</b>';
                echo '</div>';
            }
        }else{
            //Buka rincian transaksi
            $QryTransaksi = mysqli_query($conn, "SELECT * FROM rincian_transaksi WHERE id_rincian='$id_rincian'")or die(mysqli_error($conn));
            $DataTransaksi = mysqli_fetch_array($QryTransaksi);
            $kode_transaksi=$DataTransaksi['kode_transaksi'];
            $id_obat=$DataTransaksi['id_obat'];
            $nama=$DataTransaksi['nama'];
            $qty = $DataTransaksi['qty'];
            $harga = $DataTransaksi['harga'];
            $jumlah = $DataTransaksi['jumlah'];
            $id_multi = $DataTransaksi['id_multi'];
            //Buka Stok Obat
            $QryObat = mysqli_query($conn, "SELECT * FROM obat WHERE id_obat='$id_obat'")or die(mysqli_error($conn));
            $DataObat = mysqli_fetch_array($QryObat);
            $StokObat=$DataObat['stok'];
            $konversiBarang=$DataObat['konversi'];
            //Buka transaksi
            $QryTransaksi = mysqli_query($conn, "SELECT * FROM transaksi WHERE kode_transaksi='$kode_transaksi'")or die(mysqli_error($conn));
            $DataTransaksi = mysqli_fetch_array($QryTransaksi);
            $jenis_transaksi=$DataTransaksi['jenis_transaksi'];
            $keterangan=$DataTransaksi['keterangan'];
            $pembayaran=$DataTransaksi['pembayaran'];
            $ppn=$DataTransaksi['ppn'];
            $biaya=$DataTransaksi['biaya'];
            $diskon=$DataTransaksi['diskon'];
            //Buka setting transaksi
            $QrySetting = mysqli_query($conn, "SELECT * FROM transaksi_setting WHERE trans='$jenis_transaksi'")or die(mysqli_error($conn));
            $DataSetting = mysqli_fetch_array($QrySetting);
            $ppn = $DataSetting['ppn'];
            $diskon = $DataSetting['diskon'];
            $biaya = $DataSetting['biaya'];
            //Menghitung Nilai RP
            $RpPpn=($subtotal*$ppn)/100;
            $RpDiskon=($subtotal*$diskon)/100;
            $RpBiaya=($subtotal*$biaya)/100;

            if($jenis_transaksi=="penjualan"){
                //Apabila Satuan Utama atau tidak menggunakan satuan multi
                if(empty($id_multi)){
                    $StokBaru=$StokObat+$qty;
                    //Edit Stok obat baru
                    $EditObat = mysqli_query($conn, "UPDATE obat SET stok='$StokBaru' WHERE id_obat='$id_obat'") or die(mysqli_error($conn));
                    //buka data barang lagi
                    $QryObat = mysqli_query($conn, "SELECT * FROM obat WHERE id_obat='$id_obat'")or die(mysqli_error($conn));
                    $DataObat = mysqli_fetch_array($QryObat);
                    $StokObat=$DataObat['stok'];
                    $konversiBarang=$DataObat['konversi'];
                    //araykan data multi
                    //Lakukan Perulangan untuk melakukan edit pada stok multi satuan
                    $QryListMulti = mysqli_query($conn, "SELECT*FROM muti_harga WHERE id_barang='$id_obat'");
                    while ($DataListMulti = mysqli_fetch_array($QryListMulti)) {
                        $id_multiList = $DataListMulti['id_multi'];
                        $konversiList = $DataListMulti['konversi'];
                        $satuanList = $DataListMulti['satuan'];
                        $stokList= $DataListMulti['stok'];
                        $harga_1List= $DataListMulti['harga1'];
                        $harga_2List= $DataListMulti['harga2'];
                        $harga_3List= $DataListMulti['harga3'];
                        $harga_4List= $DataListMulti['harga4'];
                        //Hitung mencari stok baru masing-masing list
                        $stokBaruList=($konversiBarang/$konversiList)*$StokObat;
                        //Lakukan update data stok masing-masing list
                        $EditMultiSatuan = mysqli_query($conn, "UPDATE muti_harga SET stok='$stokBaruList' WHERE id_multi='$id_multiList'") or die(mysqli_error($conn)); 
                    }
                }else{
                    //Apabila Bukan Satuan Utama atau menggunakan satuan multi
                    //Buka data multi
                    $QryMulti = mysqli_query($conn, "SELECT * FROM muti_harga WHERE id_multi='$id_multi'")or die(mysqli_error($conn));
                    $DataMulti = mysqli_fetch_array($QryMulti);
                    $satuanMulti=$DataMulti['satuan'];
                    $konversiMulti=$DataMulti['konversi'];
                    $stokMulti=$DataMulti['stok'];
                    //Konversikan qty multi menjadi qty utama
                    $qty=$konversiMulti/$konversiBarang*$qty;
                    $StokBaru=$StokObat+$qty;
                    //Edit Stok obat baru
                    $EditObat = mysqli_query($conn, "UPDATE obat SET stok='$StokBaru' WHERE id_obat='$id_obat'") or die(mysqli_error($conn));
                    //buka data barang lagi
                    $QryObat = mysqli_query($conn, "SELECT * FROM obat WHERE id_obat='$id_obat'")or die(mysqli_error($conn));
                    $DataObat = mysqli_fetch_array($QryObat);
                    $StokObat=$DataObat['stok'];
                    $konversiBarang=$DataObat['konversi'];
                    //araykan data multi
                    //Lakukan Perulangan untuk melakukan edit pada stok multi satuan
                    $QryListMulti = mysqli_query($conn, "SELECT*FROM muti_harga WHERE id_barang='$id_obat'");
                    while ($DataListMulti = mysqli_fetch_array($QryListMulti)) {
                        $id_multiList = $DataListMulti['id_multi'];
                        $konversiList = $DataListMulti['konversi'];
                        $satuanList = $DataListMulti['satuan'];
                        $stokList= $DataListMulti['stok'];
                        $harga_1List= $DataListMulti['harga1'];
                        $harga_2List= $DataListMulti['harga2'];
                        $harga_3List= $DataListMulti['harga3'];
                        $harga_4List= $DataListMulti['harga4'];
                        //Hitung mencari stok baru masing-masing list
                        $stokBaruList=($konversiBarang/$konversiList)*$StokObat;
                        //Lakukan update data stok masing-masing list
                        $EditMultiSatuan = mysqli_query($conn, "UPDATE muti_harga SET stok='$stokBaruList' WHERE id_multi='$id_multiList'") or die(mysqli_error($conn)); 
                    }
                }
            }else{
               //Apabila Satuan Utama atau tidak menggunakan satuan multi
                if(empty($id_multi)){
                    $StokBaru=$StokObat-$qty;
                    //Edit Stok obat baru
                    $EditObat = mysqli_query($conn, "UPDATE obat SET stok='$StokBaru' WHERE id_obat='$id_obat'") or die(mysqli_error($conn));
                    //buka data barang lagi
                    $QryObat = mysqli_query($conn, "SELECT * FROM obat WHERE id_obat='$id_obat'")or die(mysqli_error($conn));
                    $DataObat = mysqli_fetch_array($QryObat);
                    $StokObat=$DataObat['stok'];
                    $konversiBarang=$DataObat['konversi'];
                    //araykan data multi
                    //Lakukan Perulangan untuk melakukan edit pada stok multi satuan
                    $QryListMulti = mysqli_query($conn, "SELECT*FROM muti_harga WHERE id_barang='$id_obat'");
                    while ($DataListMulti = mysqli_fetch_array($QryListMulti)) {
                        $id_multiList = $DataListMulti['id_multi'];
                        $konversiList = $DataListMulti['konversi'];
                        $satuanList = $DataListMulti['satuan'];
                        $stokList= $DataListMulti['stok'];
                        $harga_1List= $DataListMulti['harga1'];
                        $harga_2List= $DataListMulti['harga2'];
                        $harga_3List= $DataListMulti['harga3'];
                        $harga_4List= $DataListMulti['harga4'];
                        //Hitung mencari stok baru masing-masing list
                        $stokBaruList=($konversiBarang/$konversiList)*$StokObat;
                        //Lakukan update data stok masing-masing list
                        $EditMultiSatuan = mysqli_query($conn, "UPDATE muti_harga SET stok='$stokBaruList' WHERE id_multi='$id_multiList'") or die(mysqli_error($conn)); 
                    }
                }else{
                    //Apabila Bukan Satuan Utama atau menggunakan satuan multi
                    //Buka data multi
                    $QryMulti = mysqli_query($conn, "SELECT * FROM muti_harga WHERE id_multi='$id_multi'")or die(mysqli_error($conn));
                    $DataMulti = mysqli_fetch_array($QryMulti);
                    $satuanMulti=$DataMulti['satuan'];
                    $konversiMulti=$DataMulti['konversi'];
                    $stokMulti=$DataMulti['stok'];
                    //Konversikan qty multi menjadi qty utama
                    $qty=$konversiMulti/$konversiBarang*$qty;
                    $StokBaru=$StokObat-$qty;
                    //Edit Stok obat baru
                    $EditObat = mysqli_query($conn, "UPDATE obat SET stok='$StokBaru' WHERE id_obat='$id_obat'") or die(mysqli_error($conn));
                    //buka data barang lagi
                    $QryObat = mysqli_query($conn, "SELECT * FROM obat WHERE id_obat='$id_obat'")or die(mysqli_error($conn));
                    $DataObat = mysqli_fetch_array($QryObat);
                    $StokObat=$DataObat['stok'];
                    $konversiBarang=$DataObat['konversi'];
                    //araykan data multi
                    //Lakukan Perulangan untuk melakukan edit pada stok multi satuan
                    $QryListMulti = mysqli_query($conn, "SELECT*FROM muti_harga WHERE id_barang='$id_obat'");
                    while ($DataListMulti = mysqli_fetch_array($QryListMulti)) {
                        $id_multiList = $DataListMulti['id_multi'];
                        $konversiList = $DataListMulti['konversi'];
                        $satuanList = $DataListMulti['satuan'];
                        $stokList= $DataListMulti['stok'];
                        $harga_1List= $DataListMulti['harga1'];
                        $harga_2List= $DataListMulti['harga2'];
                        $harga_3List= $DataListMulti['harga3'];
                        $harga_4List= $DataListMulti['harga4'];
                        //Hitung mencari stok baru masing-masing list
                        $stokBaruList=($konversiBarang/$konversiList)*$StokObat;
                        //Lakukan update data stok masing-masing list
                        $EditMultiSatuan = mysqli_query($conn, "UPDATE muti_harga SET stok='$stokBaruList' WHERE id_multi='$id_multiList'") or die(mysqli_error($conn)); 
                    }
                }
            }
            $query = mysqli_query($conn, "DELETE FROM rincian_transaksi WHERE id_rincian='$id_rincian'") or die(mysqli_error($conn));    
            if($query){
                //Hitung ulang subtotal
                $QrySubtotal = mysqli_query($conn, "SELECT SUM(jumlah) as jumlah from rincian_transaksi WHERE kode_transaksi='$kode_transaksi'");
                $DataSubtotal = mysqli_fetch_array($QrySubtotal);
                $subtotal=$DataSubtotal['jumlah'];
                //Update subtotal ke transaksi
                $EditTransaksi = mysqli_query($conn, "UPDATE transaksi SET subtotal='$subtotal' WHERE kode_transaksi='$kode_transaksi'") or die(mysqli_error($conn));
                if($EditTransaksi){
                    //Buka Transaksi untuk update total
                    $QryDetailTransaksi = mysqli_query($conn, "SELECT * FROM transaksi WHERE kode_transaksi='$kode_transaksi'")or die(mysqli_error($conn));
                    $DataDetailTransaksi = mysqli_fetch_array($QryDetailTransaksi);
                    $DetailPPN=$DataDetailTransaksi['ppn'];
                    $DetailDiskon=$DataDetailTransaksi['diskon'];
                    $DetailPembayaran=$DataDetailTransaksi['pembayaran'];
                    //Buat Total Tagihan
                    $TotalTagihanBaru=($subtotal+$DetailPPN)-$DetailDiskon;
                    //Buat Selisih dan keterangan
                    $SelisihBaru=$TotalTagihanBaru-$DetailPembayaran;
                    if($jenis_transaksi=="penjualan"){
                        if($SelisihBaru=="0"){
                            $KeteranganBaru="Lunas";
                        }else{
                            if($SelisihBaru<0){
                                $KeteranganBaru="Utang";
                                $SelisihBaru=$SelisihBaru*-1;
                            }else{
                                $KeteranganBaru="Piutang";
                            }
                        }
                    }else{
                        if($SelisihBaru=="0"){
                            $KeteranganBaru="Lunas";
                        }else{
                            if($SelisihBaru<0){
                                $KeteranganBaru="Piutang";
                                $SelisihBaru=$SelisihBaru*-1;
                            }else{
                                $KeteranganBaru="Utang";
                            }
                        }
                    }
                    //Update Transaksi
                    $EditTransaksi2 = mysqli_query($conn, "UPDATE transaksi SET 
                        total_tagihan='$TotalTagihanBaru', 
                        selisih='$SelisihBaru', 
                        keterangan='$KeteranganBaru'
                    WHERE kode_transaksi='$kode_transaksi'") or die(mysqli_error($conn));
                    if($EditTransaksi2){
                        echo '<div class="alert alert-danger" role="alert">';
                        echo '   <b id="NotifikasiDeleteRincianBerhasil">Berhasil</b>';
                        echo '</div>';
                    }else{
                        echo '<div class="alert alert-danger" role="alert">';
                        echo '   <b id="NotifikasiDeleteRincianBerhasil">Edit total tagihan dan keterangan Gagal</b>';
                        echo '</div>';
                    }
                }else{
                    echo '<div class="alert alert-danger" role="alert">';
                    echo '   <b id="NotifikasiDeleteRincianBerhasil">Edit Subtotal Transaksi Gagal</b>';
                    echo '</div>';
                }
                
            }else{
                echo '<div class="alert alert-danger" role="alert">';
                echo '   <b id="NotifikasiDeleteRincianBerhasil">Hapus Rincian Gagal</b>';
                echo '</div>';
            }
        }
    }
?>