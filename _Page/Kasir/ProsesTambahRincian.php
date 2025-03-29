<?php
    //koneksi dan error
    ini_set("display_errors","off");
    include "../../_Config/Connection.php";
    //NewOrEdit
    if(!empty($_POST['NewOrEdit'])){
        $NewOrEdit=$_POST['NewOrEdit'];
    }else{
        $NewOrEdit="New";
    }
    //StandarHarga
    if(!empty($_POST['StandarHarga'])){
        $StandarHarga=$_POST['StandarHarga'];
    }else{
        $StandarHarga="harga_4";
    }
    //id_multi
    if(!empty($_POST['id_multi'])){
        $id_multi=$_POST['id_multi'];
    }else{
        $id_multi="";
    }
    //jenis_transaksi
    if(!empty($_POST['jenis_transaksi'])){
        $jenis_transaksi=$_POST['jenis_transaksi'];
    }else{
        $jenis_transaksi="penjualan";
    }
    //id_obat
    if(!empty($_POST['id_obat'])){
        $id_obat=$_POST['id_obat'];
    }else{
        $id_obat="";
    }
    //nama
    if(!empty($_POST['nama'])){
        $nama=$_POST['nama'];
    }else{
        $nama="";
    }
    //kode_transaksi
    if(!empty($_POST['kode_transaksi'])){
        $kode_transaksi=$_POST['kode_transaksi'];
    }else{
        $kode_transaksi="";
    }
    //qty
    if(!empty($_POST['qty'])){
        $qty=$_POST['qty'];
    }else{
        $qty="";
    }
    //harga
    if(!empty($_POST['harga'])){
        $harga=$_POST['harga'];
    }else{
        $harga="";
    }
    //stok
    if(!empty($_POST['stok'])){
        $stok=$_POST['stok'];
    }else{
        $stok="";
    }
    $jumlah=$qty*$harga;
    //Buka data Barang
    $QryBarang = mysqli_query($conn, "SELECT * FROM obat WHERE id_obat='$id_obat'")or die(mysqli_error($conn));
    $DataBarang = mysqli_fetch_array($QryBarang);
    $satuanBarang=$DataBarang['satuan'];
    $konversiBarang=$DataBarang['konversi'];
    $stokBarang=$DataBarang['stok'];
    //Proses
        //Tambah Rincian
        $entry="INSERT INTO rincian_transaksi (
            kode_transaksi,
            id_obat,
            id_multi,
            standar_harga,
            nama,
            qty,
            harga,
            jumlah
        ) VALUES (
            '$kode_transaksi',
            '$id_obat',
            '$id_multi',
            '$StandarHarga',
            '$nama',
            '$qty',
            '$harga',
            '$jumlah'
        )";
        $hasil=mysqli_query($conn, $entry);
        if($hasil){
            if($NewOrEdit=="New"){
                echo "<b id='NotifikasiTambahRincianBerhasil'>Ok</b>";
            }else{
                if($jenis_transaksi=="penjualan"){
                    //Kurangi stok barang langsung disini sesuai dengan multi harga
                    if(empty($id_multi)){
                        $StokBaru=$stok-$qty;
                        //Edit Ke data Barang
                        $EditObat = mysqli_query($conn, "UPDATE obat SET 
                        stok='$StokBaru' WHERE id_obat='$id_obat'") or die(mysqli_error($conn)); 
                        //Lakukan Perulangan untuk melakukan edit pada stok multi satuan
                        //KONDISI PENGATURAN MASING FILTER
                        //Buka data Barang
                        $QryBarang = mysqli_query($conn, "SELECT * FROM obat WHERE id_obat='$id_obat'")or die(mysqli_error($conn));
                        $DataBarang = mysqli_fetch_array($QryBarang);
                        $satuanBarang=$DataBarang['satuan'];
                        $konversiBarang=$DataBarang['konversi'];
                        $stokBarang=$DataBarang['stok'];
                        //Arraykan data muti harga
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
                            $stokBaruList=($konversiBarang/$konversiList)*$stokBarang;
                            //Lakukan update data stok masing-masing list
                            $EditMultiSatuan = mysqli_query($conn, "UPDATE muti_harga SET stok='$stokBaruList' WHERE id_multi='$id_multiList'") or die(mysqli_error($conn)); 
                        }
                    }else{
                        //Buka data multi harga
                        $QryMulti = mysqli_query($conn, "SELECT * FROM muti_harga WHERE id_multi='$id_multi'")or die(mysqli_error($conn));
                        $DataMulti = mysqli_fetch_array($QryMulti);
                        $satuanMulti=$DataMulti['satuan'];
                        $konversiMulti=$DataMulti['konversi'];
                        $stokMulti=$DataMulti['stok'];
                        //Konversikan qty multi menjadi qty utama
                        $qty=$konversiMulti/$konversiBarang*$qty;
                        $StokBaru=$stok-$qty;
                        //Edit Ke data Barang
                        $EditObat = mysqli_query($conn, "UPDATE obat SET 
                        stok='$StokBaru' WHERE id_obat='$id_obat'") or die(mysqli_error($conn)); 
                        //Buka data Barang
                        $QryBarang = mysqli_query($conn, "SELECT * FROM obat WHERE id_obat='$id_obat'")or die(mysqli_error($conn));
                        $DataBarang = mysqli_fetch_array($QryBarang);
                        $satuanBarang=$DataBarang['satuan'];
                        $konversiBarang=$DataBarang['konversi'];
                        $stokBarang=$DataBarang['stok'];
                        //Lakukan Perulangan untuk melakukan edit pada stok multi satuan
                        //KONDISI PENGATURAN MASING FILTER
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
                            $stokBaruList=($konversiBarang/$konversiList)*$stokBarang;
                            //Lakukan update data stok masing-masing list
                            $EditMultiSatuan = mysqli_query($conn, "UPDATE muti_harga SET stok='$stokBaruList' WHERE id_multi='$id_multiList'") or die(mysqli_error($conn)); 
                        }
                    }
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
                            echo "<b id='NotifikasiTambahRincianBerhasil'>Ok</b>";
                        }else{
                            echo'Error';
                        }
                    }else{
                        echo'Error';
                    }
                }else{
                    if(empty($id_multi)){
                        $StokBaru=$stok+$qty;
                        //Edit Ke data Barang
                        $EditObat = mysqli_query($conn, "UPDATE obat SET 
                        stok='$StokBaru' WHERE id_obat='$id_obat'") or die(mysqli_error($conn)); 
                        //Buka data Barang
                        $QryBarang = mysqli_query($conn, "SELECT * FROM obat WHERE id_obat='$id_obat'")or die(mysqli_error($conn));
                        $DataBarang = mysqli_fetch_array($QryBarang);
                        $satuanBarang=$DataBarang['satuan'];
                        $konversiBarang=$DataBarang['konversi'];
                        $stokBarang=$DataBarang['stok'];
                        //Lakukan Perulangan untuk melakukan edit pada stok multi satuan
                        //KONDISI PENGATURAN MASING FILTER
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
                            $stokBaruList=($konversiBarang/$konversiList)*$stokBarang;
                            //Lakukan update data stok masing-masing list
                            $EditMultiSatuan = mysqli_query($conn, "UPDATE muti_harga SET stok='$stokBaruList' WHERE id_multi='$id_multiList'") or die(mysqli_error($conn)); 
                        }
                    }else{
                        //Buka data multi harga
                        $QryMulti = mysqli_query($conn, "SELECT * FROM muti_harga WHERE id_multi='$id_multi'")or die(mysqli_error($conn));
                        $DataMulti = mysqli_fetch_array($QryMulti);
                        $satuanMulti=$DataMulti['satuan'];
                        $konversiMulti=$DataMulti['konversi'];
                        $stokMulti=$DataMulti['stok'];
                        //Konversikan qty multi menjadi qty utama
                        $qty=$konversiMulti/$konversiBarang*$qty;
                        $StokBaru=$stok+$qty;
                        //Edit Ke data Barang
                        $EditObat = mysqli_query($conn, "UPDATE obat SET 
                        stok='$StokBaru' WHERE id_obat='$id_obat'") or die(mysqli_error($conn)); 
                        //Buka data Barang
                        $QryBarang = mysqli_query($conn, "SELECT * FROM obat WHERE id_obat='$id_obat'")or die(mysqli_error($conn));
                        $DataBarang = mysqli_fetch_array($QryBarang);
                        $satuanBarang=$DataBarang['satuan'];
                        $konversiBarang=$DataBarang['konversi'];
                        $stokBarang=$DataBarang['stok'];
                        //Lakukan Perulangan untuk melakukan edit pada stok multi satuan
                        //KONDISI PENGATURAN MASING FILTER
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
                            $stokBaruList=($konversiBarang/$konversiList)*$stokBarang;
                            //Lakukan update data stok masing-masing list
                            $EditMultiSatuan = mysqli_query($conn, "UPDATE muti_harga SET stok='$stokBaruList' WHERE id_multi='$id_multiList'") or die(mysqli_error($conn)); 
                        }
                    }
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
                            echo "<b id='NotifikasiTambahRincianBerhasil'>Ok</b>";
                        }else{
                            echo'Error';
                        }
                    }else{
                        echo'Error';
                    }
                }
            }
        }else{
            echo'Error 001';
        }
?>