<?php
    include "../../_Config/Connection.php";
    //Tangkap data
    if(empty($_POST['id_obat'])){
       echo '<div class="alert alert-danger" role="alert">';
       echo '   <b id="NotifikasiEditRincianBerhasil">Id Obat Kosong!!</b>';
       echo '</div>';
    }else{
        $id_obat=$_POST['id_obat'];
        if(empty($_POST['id_rincian'])){
            echo '<div class="alert alert-danger" role="alert">';
            echo '   <b id="NotifikasiEditRincianBerhasil">Id Rincian Kosong!!</b>';
            echo '</div>';
        }else{
            $id_rincian=$_POST['id_rincian'];
            if(empty($_POST['qty'])){
                echo '<div class="alert alert-danger" role="alert">';
                echo '   <b id="NotifikasiEditRincianBerhasil">QTY Kosong!!</b>';
                echo '</div>';
            }else{
                $qty=$_POST['qty'];
                if(empty($_POST['harga'])){
                    echo '<div class="alert alert-danger" role="alert">';
                    echo '   <b id="NotifikasiEditRincianBerhasil">Harga Kosong!!</b>';
                    echo '</div>';
                }else{
                    $harga=$_POST['harga'];
                    if(empty($_POST['kode_transaksi'])){
                        echo '<div class="alert alert-danger" role="alert">';
                        echo '   <b id="NotifikasiEditRincianBerhasil">Kode Transaksi Kosong!!</b>';
                        echo '</div>';
                    }else{
                        $kode_transaksi=$_POST['kode_transaksi'];
                        //NewOrEdit
                        if(empty($_POST['NewOrEdit'])){
                            $NewOrEdit="New";
                        }else{
                            $NewOrEdit=$_POST['NewOrEdit'];
                        }
                        //id_multi
                        if(empty($_POST['id_multi'])){
                            $id_multi="";
                        }else{
                            $id_multi=$_POST['id_multi'];
                        }
                        //standar_harga
                        if(empty($_POST['standar_harga'])){
                            $standar_harga="";
                        }else{
                            $standar_harga=$_POST['standar_harga'];
                        }
                        if($NewOrEdit=="New"){
                            //Tinggal edit rincian saja
                            $jumlah=$qty*$harga;
                            $EditRincian = mysqli_query($conn, "UPDATE rincian_transaksi SET 
                                id_multi='$id_multi',
                                standar_harga='$standar_harga',
                                qty='$qty',
                                harga='$harga', 
                                jumlah='$jumlah' 
                            WHERE id_rincian='$id_rincian'") or die(mysqli_error($conn)); 
                            if($EditRincian){
                                echo '<div class="alert alert-danger" role="alert">';
                                echo '   <b id="NotifikasiEditRincianBerhasil">Berhasil</b>';
                                echo '</div>';
                            }else{
                                echo '<div class="alert alert-danger" role="alert">';
                                echo '   <b id="NotifikasiEditRincianBerhasil">Edit Rincian Gagal</b>';
                                echo '</div>';
                            }
                        }else{
                            $jumlah=$qty*$harga;
                            if(empty($_POST['jenis_transaksi'])){
                                echo '<div class="alert alert-danger" role="alert">';
                                echo '   <b id="NotifikasiEditRincianBerhasil">Jenis Transaksi Kosong!!</b>';
                                echo '</div>';
                            }else{
                                $jenis_transaksi=$_POST['jenis_transaksi'];
                                //Buka Qty Lama
                                $QryTransaksi = mysqli_query($conn, "SELECT * FROM rincian_transaksi WHERE id_rincian='$id_rincian'")or die(mysqli_error($conn));
                                $DataTransaksi = mysqli_fetch_array($QryTransaksi);
                                $QtyLama=$DataTransaksi['qty'];
                                $id_multiLama=$DataTransaksi['id_multi'];
                                //Buka Stok Obat
                                $QryObat = mysqli_query($conn, "SELECT * FROM obat WHERE id_obat='$id_obat'")or die(mysqli_error($conn));
                                $DataObat = mysqli_fetch_array($QryObat);
                                $StokObat=$DataObat['stok'];
                                //Stok Baru
                                if($jenis_transaksi=="penjualan"){
                                    //Apabila id multi lama kosong maka satuan menggunakan satuan utama
                                    if(empty($id_multiLama)){
                                        $id_multiLama="0";
                                        //Kembalikan lagi stok ke data barang
                                        $stokBaru=$StokObat+$QtyLama;
                                        $EditObat = mysqli_query($conn, "UPDATE obat SET stok='$stokBaru' WHERE id_obat='$id_obat'") or die(mysqli_error($conn));
                                        //Apakah data rincian yang baru mengandung id_multi
                                        if(empty($id_multi)){
                                            //buka data obat
                                            $QryBarang = mysqli_query($conn, "SELECT * FROM obat WHERE id_obat='$id_obat'")or die(mysqli_error($conn));
                                            $DataBarang = mysqli_fetch_array($QryBarang);
                                            $satuanBarang=$DataBarang['satuan'];
                                            $konversiBarang=$DataBarang['konversi'];
                                            $stokBarang=$DataBarang['stok'];
                                            //apabila tidak mengandung id multi maka qty baru tinggal di kurangkan saja
                                            $StokBaru=$stokBarang-$qty;
                                            //updatekan ke data obat
                                            $EditObat = mysqli_query($conn, "UPDATE obat SET stok='$StokBaru' WHERE id_obat='$id_obat'") or die(mysqli_error($conn));
                                            //buka data barang
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
                                            //buka data barang
                                            $QryBarang = mysqli_query($conn, "SELECT * FROM obat WHERE id_obat='$id_obat'")or die(mysqli_error($conn));
                                            $DataBarang = mysqli_fetch_array($QryBarang);
                                            $satuanBarang=$DataBarang['satuan'];
                                            $konversiBarang=$DataBarang['konversi'];
                                            $stokBarang=$DataBarang['stok'];
                                            //Buka data multi harga
                                            $QryMulti = mysqli_query($conn, "SELECT * FROM muti_harga WHERE id_multi='$id_multi'")or die(mysqli_error($conn));
                                            $DataMulti = mysqli_fetch_array($QryMulti);
                                            $satuanMulti=$DataMulti['satuan'];
                                            $konversiMulti=$DataMulti['konversi'];
                                            $stokMulti=$DataMulti['stok'];
                                            //Konversikan qty multi menjadi qty utama
                                            $qty=$konversiMulti/$konversiBarang*$qty;
                                            $StokBaru=$stokBarang-$qty;
                                            //Updatekan ke data obat
                                            $EditObat = mysqli_query($conn, "UPDATE obat SET stok='$StokBaru' WHERE id_obat='$id_obat'") or die(mysqli_error($conn));
                                            //buka data barang lagi
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
                                        }
                                    }else{
                                        //buka data barang
                                        $QryBarang = mysqli_query($conn, "SELECT * FROM obat WHERE id_obat='$id_obat'")or die(mysqli_error($conn));
                                        $DataBarang = mysqli_fetch_array($QryBarang);
                                        $satuanBarang=$DataBarang['satuan'];
                                        $konversiBarang=$DataBarang['konversi'];
                                        $stokBarang=$DataBarang['stok'];
                                        //Buka data multi harga
                                        $QryMulti = mysqli_query($conn, "SELECT * FROM muti_harga WHERE id_multi='$id_multiLama'")or die(mysqli_error($conn));
                                        $DataMulti = mysqli_fetch_array($QryMulti);
                                        $satuanMulti=$DataMulti['satuan'];
                                        $konversiMulti=$DataMulti['konversi'];
                                        $stokMulti=$DataMulti['stok'];
                                        //Konversikan qty multi menjadi qty utama
                                        $QtyLama=$konversiMulti/$konversiBarang*$QtyLama;
                                        $StokBaru=$stokBarang+$QtyLama;
                                        //Kembalikan lagi stok ke data barang
                                        $EditObat = mysqli_query($conn, "UPDATE obat SET stok='$StokBaru' WHERE id_obat='$id_obat'") or die(mysqli_error($conn));
                                        if(empty($id_multi)){
                                            //buka data obat
                                            $QryBarang = mysqli_query($conn, "SELECT * FROM obat WHERE id_obat='$id_obat'")or die(mysqli_error($conn));
                                            $DataBarang = mysqli_fetch_array($QryBarang);
                                            $satuanBarang=$DataBarang['satuan'];
                                            $konversiBarang=$DataBarang['konversi'];
                                            $stokBarang=$DataBarang['stok'];
                                            //apabila tidak mengandung id multi maka qty baru tinggal di kurangkan saja
                                            $stokBaru=$stokBarang-$qty;
                                            //updatekan ke data obat
                                            $EditObat = mysqli_query($conn, "UPDATE obat SET stok='$stokBaru' WHERE id_obat='$id_obat'") or die(mysqli_error($conn));
                                            //buka data barang
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
                                            //buka data barang
                                            $QryBarang = mysqli_query($conn, "SELECT * FROM obat WHERE id_obat='$id_obat'")or die(mysqli_error($conn));
                                            $DataBarang = mysqli_fetch_array($QryBarang);
                                            $satuanBarang=$DataBarang['satuan'];
                                            $konversiBarang=$DataBarang['konversi'];
                                            $stokBarang=$DataBarang['stok'];
                                            //Buka data multi harga
                                            $QryMulti = mysqli_query($conn, "SELECT * FROM muti_harga WHERE id_multi='$id_multi'")or die(mysqli_error($conn));
                                            $DataMulti = mysqli_fetch_array($QryMulti);
                                            $satuanMulti=$DataMulti['satuan'];
                                            $konversiMulti=$DataMulti['konversi'];
                                            $stokMulti=$DataMulti['stok'];
                                            //Konversikan qty multi menjadi qty utama
                                            $qty=$konversiMulti/$konversiBarang*$qty;
                                            $StokBaru=$stokBarang-$qty;
                                            //Updatekan ke data obat
                                            $EditObat = mysqli_query($conn, "UPDATE obat SET stok='$StokBaru' WHERE id_obat='$id_obat'") or die(mysqli_error($conn));
                                            //buka data barang lagi
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
                                        }
                                    }
                                }else{
                                    //Apabila id multi lama kosong maka satuan menggunakan satuan utama
                                    if(empty($id_multiLama)){
                                        $id_multiLama="0";
                                        //Kembalikan lagi stok ke data barang
                                        $stokBaru=$StokObat-$QtyLama;
                                        $EditObat = mysqli_query($conn, "UPDATE obat SET stok='$stokBaru' WHERE id_obat='$id_obat'") or die(mysqli_error($conn));
                                        //Apakah data rincian yang baru mengandung id_multi
                                        if(empty($id_multi)){
                                            //buka data obat
                                            $QryBarang = mysqli_query($conn, "SELECT * FROM obat WHERE id_obat='$id_obat'")or die(mysqli_error($conn));
                                            $DataBarang = mysqli_fetch_array($QryBarang);
                                            $satuanBarang=$DataBarang['satuan'];
                                            $konversiBarang=$DataBarang['konversi'];
                                            $stokBarang=$DataBarang['stok'];
                                            //apabila tidak mengandung id multi maka qty baru tinggal di tambahkan saja
                                            $stokBaru=$stokBarang+$qty;
                                            //updatekan ke data obat
                                            $EditObat = mysqli_query($conn, "UPDATE obat SET stok='$stokBaru' WHERE id_obat='$id_obat'") or die(mysqli_error($conn));
                                            //buka data barang
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
                                            //buka data barang
                                            $QryBarang = mysqli_query($conn, "SELECT * FROM obat WHERE id_obat='$id_obat'")or die(mysqli_error($conn));
                                            $DataBarang = mysqli_fetch_array($QryBarang);
                                            $satuanBarang=$DataBarang['satuan'];
                                            $konversiBarang=$DataBarang['konversi'];
                                            $stokBarang=$DataBarang['stok'];
                                            //Buka data multi harga
                                            $QryMulti = mysqli_query($conn, "SELECT * FROM muti_harga WHERE id_multi='$id_multi'")or die(mysqli_error($conn));
                                            $DataMulti = mysqli_fetch_array($QryMulti);
                                            $satuanMulti=$DataMulti['satuan'];
                                            $konversiMulti=$DataMulti['konversi'];
                                            $stokMulti=$DataMulti['stok'];
                                            //Konversikan qty multi menjadi qty utama
                                            $qty=$konversiMulti/$konversiBarang*$qty;
                                            //Lakukan pembelian dengan menambahkan stok
                                            $StokBaru=$stokBarang+$qty;
                                            //Updatekan ke data obat
                                            $EditObat = mysqli_query($conn, "UPDATE obat SET stok='$StokBaru' WHERE id_obat='$id_obat'") or die(mysqli_error($conn));
                                            //buka data barang lagi
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
                                        }
                                    }else{
                                        //buka data barang
                                        $QryBarang = mysqli_query($conn, "SELECT * FROM obat WHERE id_obat='$id_obat'")or die(mysqli_error($conn));
                                        $DataBarang = mysqli_fetch_array($QryBarang);
                                        $satuanBarang=$DataBarang['satuan'];
                                        $konversiBarang=$DataBarang['konversi'];
                                        $stokBarang=$DataBarang['stok'];
                                        //Buka data multi harga
                                        $QryMulti = mysqli_query($conn, "SELECT * FROM muti_harga WHERE id_multi='$id_multiLama'")or die(mysqli_error($conn));
                                        $DataMulti = mysqli_fetch_array($QryMulti);
                                        $satuanMulti=$DataMulti['satuan'];
                                        $konversiMulti=$DataMulti['konversi'];
                                        $stokMulti=$DataMulti['stok'];
                                        //Konversikan qty multi menjadi qty utama
                                        $QtyLama=$konversiMulti/$konversiBarang*$QtyLama;
                                        $StokBaru=$stokBarang-$QtyLama;
                                        //Kembalikan lagi stok ke data barang
                                        $EditObat = mysqli_query($conn, "UPDATE obat SET stok='$StokBaru' WHERE id_obat='$id_obat'") or die(mysqli_error($conn));
                                        if(empty($id_multi)){
                                            //buka data obat
                                            $QryBarang = mysqli_query($conn, "SELECT * FROM obat WHERE id_obat='$id_obat'")or die(mysqli_error($conn));
                                            $DataBarang = mysqli_fetch_array($QryBarang);
                                            $satuanBarang=$DataBarang['satuan'];
                                            $konversiBarang=$DataBarang['konversi'];
                                            $stokBarang=$DataBarang['stok'];
                                            //apabila tidak mengandung id multi maka qty baru tinggal di kurangkan saja
                                            $stokBaru=$stokBarang+$qty;
                                            //updatekan ke data obat
                                            $EditObat = mysqli_query($conn, "UPDATE obat SET stok='$stokBaru' WHERE id_obat='$id_obat'") or die(mysqli_error($conn));
                                            //buka data barang
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
                                            //buka data barang
                                            $QryBarang = mysqli_query($conn, "SELECT * FROM obat WHERE id_obat='$id_obat'")or die(mysqli_error($conn));
                                            $DataBarang = mysqli_fetch_array($QryBarang);
                                            $satuanBarang=$DataBarang['satuan'];
                                            $konversiBarang=$DataBarang['konversi'];
                                            $stokBarang=$DataBarang['stok'];
                                            //Buka data multi harga
                                            $QryMulti = mysqli_query($conn, "SELECT * FROM muti_harga WHERE id_multi='$id_multi'")or die(mysqli_error($conn));
                                            $DataMulti = mysqli_fetch_array($QryMulti);
                                            $satuanMulti=$DataMulti['satuan'];
                                            $konversiMulti=$DataMulti['konversi'];
                                            $stokMulti=$DataMulti['stok'];
                                            //Konversikan qty multi menjadi qty utama
                                            $qty=$konversiMulti/$konversiBarang*$qty;
                                            $StokBaru=$stokBarang+$qty;
                                            //Updatekan ke data obat
                                            $EditObat = mysqli_query($conn, "UPDATE obat SET stok='$StokBaru' WHERE id_obat='$id_obat'") or die(mysqli_error($conn));
                                            //buka data barang lagi
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
                                        }
                                    }
                                }
                                //Updatekan Rincian
                                $EditRincian = mysqli_query($conn, "UPDATE rincian_transaksi SET 
                                    id_multi='$id_multi',
                                    standar_harga='$standar_harga',
                                    qty='$qty',
                                    harga='$harga', 
                                    jumlah='$jumlah' 
                                WHERE id_rincian='$id_rincian'") or die(mysqli_error($conn)); 
                                if($EditRincian){
                                    //Hitung ulang subtotal
                                    $QrySubtotal = mysqli_query($conn, "SELECT SUM(jumlah) as jumlah from rincian_transaksi WHERE kode_transaksi='$kode_transaksi'");
                                    $DataSubtotal = mysqli_fetch_array($QrySubtotal);
                                    $subtotal=$DataSubtotal['jumlah'];
                                    //Update subtotal ke transaksi
                                    $EditTransaksi = mysqli_query($conn, "UPDATE transaksi SET subtotal='$subtotal' WHERE kode_transaksi='$kode_transaksi'") or die(mysqli_error($conn));
                                    if($EditTransaksi){
                                        //Edit Subtotal Pada Transaksi Berhasil
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
                                            echo '   <b id="NotifikasiEditRincianBerhasil">Berhasil</b>';
                                            echo '</div>';
                                        }else{
                                            echo '<div class="alert alert-danger" role="alert">';
                                            echo '   <b id="NotifikasiEditRincianBerhasil">Edit total tagihan dan keterangan Gagal</b>';
                                            echo '</div>';
                                        }
                                        
                                    }else{
                                        //Edit Subtotal Pada Transaksi Gagal
                                        echo '<div class="alert alert-danger" role="alert">';
                                        echo '   <b id="NotifikasiEditRincianBerhasil">Edit Subtotal Gagal</b>';
                                        echo '</div>';
                                    }
                                }else{
                                    //Edit Subtotal Pada Transaksi Gagal
                                    echo '<div class="alert alert-danger" role="alert">';
                                    echo '   <b id="NotifikasiEditRincianBerhasil">Edit rincian Gagal</b>';
                                    echo '</div>';
                                }
                            }
                        }
                    }
                }
            }
        }
    }
?>