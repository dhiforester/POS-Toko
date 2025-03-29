<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    //Tangkap Variabel
    if(empty($_POST['id_transaksi'])){
        echo '<b class="text-danger">Ket:</b> Tidak ada data transaksi yang dikirim';
    }else{
        if(empty($_POST['tanggal'])){
            echo '<b class="text-danger">Ket:</b> Tanggal tidak boleh kosong';
        }else{
            if(empty($_POST['kode'])){
                echo '<b class="text-danger">Ket:</b> Kode Faktur Tidak Boleh Kosong';
            }else{
                if(empty($_POST['subtotal'])){
                    echo '<b class="text-danger">Ket:</b> Jumlah Retur tidak boleh kosong';
                }else{
                    $id_transaksi=$_POST['id_transaksi'];
                    $tanggal=$_POST['tanggal'];
                    $kode=$_POST['kode'];
                    $subtotal=$_POST['subtotal'];
                    //ppn
                    if(!empty($_POST['ppn'])){
                        $ppn=$_POST['ppn'];
                    }else{
                        $ppn="0";
                    }
                    //diskon
                    if(!empty($_POST['diskon'])){
                        $diskon=$_POST['diskon'];
                    }else{
                        $diskon="0";
                    }
                    //total
                    if(empty($_POST['total'])){
                        $total="0";
                    }else{
                        $total=$_POST['total'];
                    }
                    //pembayaran
                    if(empty($_POST['pembayaran'])){
                        $pembayaran="0";
                    }else{
                        $pembayaran=$_POST['pembayaran'];
                    }
                    //selisih
                    if(empty($_POST['selisih'])){
                        $selisih="0";
                    }else{
                        $selisih=$_POST['selisih'];
                    }
                    //keterangan
                    if(empty($_POST['keterangan'])){
                        $keterangan="Lunas";
                    }else{
                        $keterangan=$_POST['keterangan'];
                    }
                    //Tambah data
                    $entry="INSERT INTO retur (
                        id_transaksi,
                        kode,
                        tanggal,
                        subtotal,
                        ppn,
                        diskon,
                        tagihan,
                        pembayaran,
                        selisih,
                        keterangan
                    ) VALUES (
                        '$id_transaksi',
                        '$kode',
                        '$tanggal',
                        '$subtotal',
                        '$ppn',
                        '$diskon',
                        '$total',
                        '$pembayaran',
                        '$selisih',
                        '$keterangan'
                    )";
                    $hasil=mysqli_query($conn, $entry);
                    if($hasil){
                        //Buka kembali data yang sudah di input tadi di atas
                        $QryRetur = mysqli_query($conn, "SELECT * FROM retur WHERE id_transaksi='$id_transaksi' AND kode='$kode'")or die(mysqli_error($conn));
                        $DataRetur = mysqli_fetch_array($QryRetur);
                        $IdRetur=$DataRetur['id_retur'];
                        //Arraykan data rincian
                        $QueryRincianRetur = mysqli_query($conn, "SELECT*FROM retur_rincian WHERE id_transaksi='$id_transaksi' AND id_retur='0'");
                        while ($DataRincianRetur = mysqli_fetch_array($QueryRincianRetur)) {
                            $id_rincian_retur = $DataRincianRetur['id_rincian_retur'];
                            $id_transaksi = $DataRincianRetur['id_transaksi'];
                            $id_rincian_transaksi = $DataRincianRetur['id_rincian_transaksi'];
                            $id_barang = $DataRincianRetur['id_barang'];
                            $kode_barang = $DataRincianRetur['kode_barang'];
                            $nama_barang = $DataRincianRetur['nama_barang'];
                            $harga = $DataRincianRetur['harga'];
                            $qty = $DataRincianRetur['qty'];
                            $satuan = $DataRincianRetur['satuan'];
                            $jumlah = $DataRincianRetur['jumlah'];
                            $standar_harga = $DataRincianRetur['standar_harga'];
                            $id_multi = $DataRincianRetur['id_multi'];
                            //Muka data muti_harga rincian retur
                            if(!empty($id_multi)){
                                $QryMultiHargaReturRincian = mysqli_query($conn, "SELECT * FROM muti_harga WHERE id_multi='$id_multi'")or die(mysqli_error($conn));
                                $DataMultiHargaRincianRetur = mysqli_fetch_array($QryMultiHargaReturRincian);
                                $KonversiMultiHargaRincianRetur=$DataMultiHargaRincianRetur['konversi'];
                            }else{
                                $QryObat = mysqli_query($conn, "SELECT * FROM obat WHERE id_obat='$id_barang'")or die(mysqli_error($conn));
                                $DataObat = mysqli_fetch_array($QryObat);
                                $KonversiMultiHargaRincianRetur= $DataObat['konversi'];
                            }
                            //RINCIAN TRANSAKSI
                            $QryRincianTransaksi = mysqli_query($conn, "SELECT * FROM rincian_transaksi WHERE id_rincian='$id_rincian_transaksi'")or die(mysqli_error($conn));
                            $DataRincianTransaksi = mysqli_fetch_array($QryRincianTransaksi);
                            $IdObatRincianTransaksi=$DataRincianTransaksi['id_obat'];
                            $IdMultiRincianTransaksi=$DataRincianTransaksi['id_multi'];
                            $QtyRincianTransaksi=$DataRincianTransaksi['qty'];
                            $HargaRincianTransaksi=$DataRincianTransaksi['harga'];
                            $JumlahRincianTransaksi=$DataRincianTransaksi['jumlah'];
                            //Buka data muti_harga rincian transaksi
                            if(!empty($IdMultiRincianTransaksi)){
                                //Apabila rincian transaksi memiliki muti haraga
                                $QryMultiHargaRincianTransaksi = mysqli_query($conn, "SELECT * FROM muti_harga WHERE id_multi='$IdMultiRincianTransaksi'")or die(mysqli_error($conn));
                                $DataMultiHargaRincianTransaksi = mysqli_fetch_array($QryMultiHargaRincianTransaksi);
                                $KonversiMultiHargaRincianTransaksi=$DataMultiHargaRincianTransaksi['konversi'];
                            }else{
                                //Apabila rincian transaksi tidak memiliki muti haraga
                                $QryObat = mysqli_query($conn, "SELECT * FROM obat WHERE id_obat='$IdObatRincianTransaksi'")or die(mysqli_error($conn));
                                $DataObat = mysqli_fetch_array($QryObat);
                                $stokBarang= $DataObat['stok'];
                                $KonversiMultiHargaRincianTransaksi= $DataObat['konversi'];
                            }
                            
                            //Lakukan konversi satuan
                            if($IdMultiRincianTransaksi==$id_multi){
                                $QtyRincianTransaksiBaru=$QtyRincianTransaksi-$qty;
                                $JumlahRincianTransaksiBaru=$QtyRincianTransaksiBaru*$HargaRincianTransaksi;
                            }else{
                                if(!empty($KonversiMultiHargaRincianTransaksi)){
                                    $QtyReturSatuanRincian=($KonversiMultiHargaRincianRetur/$KonversiMultiHargaRincianTransaksi)*$qty;
                                    $QtyRincianTransaksiBaru=$QtyRincianTransaksi-$QtyReturSatuanRincian;
                                    $JumlahRincianTransaksiBaru=$QtyRincianTransaksiBaru*$HargaRincianTransaksi;
                                }else{
                                    $QtyReturSatuanRincian="";
                                    $QtyRincianTransaksiBaru="";
                                    $JumlahRincianTransaksiBaru="";
                                }
                            }
                            //Lakukan Update pada masing-masing rincian transaksi berdasarkan id rincian pada retur rincian
                            $EditRincianTransaksi = mysqli_query($conn, "UPDATE rincian_transaksi SET 
                                qty='$QtyRincianTransaksiBaru',
                                jumlah='$JumlahRincianTransaksiBaru' 
                            WHERE id_rincian='$id_rincian_transaksi'") or die(mysqli_error($conn));
                            if($EditRincianTransaksi){
                                //Lakukan update masing-masing data
                                $EditRincianRetur = mysqli_query($conn, "UPDATE retur_rincian SET id_retur='$IdRetur' WHERE id_rincian_retur='$id_rincian_retur'") or die(mysqli_error($conn));
                                if($EditRincianRetur){
                                    //Buka data barang dan data transaksi
                                    $QryObat = mysqli_query($conn, "SELECT * FROM obat WHERE id_obat='$IdObatRincianTransaksi'")or die(mysqli_error($conn));
                                    $DataObat = mysqli_fetch_array($QryObat);
                                    $stokBarang= $DataObat['stok'];
                                    $konversiBarang= $DataObat['konversi'];
                                    //Buka data transaksi untuk mengetahui jenis transaksi
                                    $QryTransaksi = mysqli_query($conn, "SELECT * FROM transaksi WHERE id_transaksi='$id_transaksi'")or die(mysqli_error($conn));
                                    $DataTransaksi = mysqli_fetch_array($QryTransaksi);
                                    $trans=$DataTransaksi['jenis_transaksi'];
                                    //Apabila mengandung id multi
                                    if(empty($id_multi)){
                                        //Apabila transaksi penjualan di reutr
                                        if($trans=="penjualan"){
                                            $StokBaru=$stokBarang+$qty;  
                                        }else{
                                            $StokBaru=$stokBarang-$qty;  
                                        }
                                        //Update Stok Barang
                                        $EditBarang= mysqli_query($conn, "UPDATE obat SET stok='$StokBaru' WHERE id_obat='$id_barang'") or die(mysqli_error($conn));
                                        //Buka data barang lagi
                                        $QryObat = mysqli_query($conn, "SELECT * FROM obat WHERE id_obat='$IdObatRincianTransaksi'")or die(mysqli_error($conn));
                                        $DataObat = mysqli_fetch_array($QryObat);
                                        $stokBarang= $DataObat['stok'];
                                        $konversiBarang= $DataObat['konversi'];
                                        //Araykan data multi sesuai id barang
                                        $QryMutiList = mysqli_query($conn, "SELECT*FROM muti_harga WHERE id_barang='$id_barang'");
                                        while ($DataMutiList = mysqli_fetch_array($QryMutiList)) {
                                            $id_multiList = $DataMutiList['id_multi'];
                                            $KonversiList = $DataMutiList['konversi'];
                                            $StokList = $DataMutiList['stok'];
                                            $StokListBaru=($konversiBarang/$KonversiList)*$stokBarang;
                                            //lakukan Update pada setiap data muti harga
                                            $UpdateMutiHarga = mysqli_query($conn, "UPDATE muti_harga SET stok='$StokListBaru' WHERE id_multi='$id_multiList'") or die(mysqli_error($conn));
                                        }
                                    //Apabila tidak mengandung id multi
                                    }else{
                                        //konversikan qty rincian pada satuan utama
                                        $qty=($KonversiMultiHargaRincianRetur/$konversiBarang)*$qty;
                                        if($trans=="penjualan"){
                                            $StokBaru=$stokBarang+$qty;  
                                        }else{
                                            $StokBaru=$stokBarang-$qty;  
                                        }
                                        //Update Stok Barang
                                        $EditBarang= mysqli_query($conn, "UPDATE obat SET stok='$StokBaru' WHERE id_obat='$id_barang'") or die(mysqli_error($conn));
                                        //Buka data barang lagi
                                        $QryObat = mysqli_query($conn, "SELECT * FROM obat WHERE id_obat='$IdObatRincianTransaksi'")or die(mysqli_error($conn));
                                        $DataObat = mysqli_fetch_array($QryObat);
                                        $stokBarang= $DataObat['stok'];
                                        $konversiBarang= $DataObat['konversi'];
                                        //Araykan data multi sesuai id barang
                                        $QryMutiList = mysqli_query($conn, "SELECT*FROM muti_harga WHERE id_barang='$id_barang'");
                                        while ($DataMutiList = mysqli_fetch_array($QryMutiList)) {
                                            $id_multiList = $DataMutiList['id_multi'];
                                            $KonversiList = $DataMutiList['konversi'];
                                            $StokList = $DataMutiList['stok'];
                                            $StokListBaru=($konversiBarang/$KonversiList)*$stokBarang;
                                            //lakukan Update pada setiap data muti harga
                                            $UpdateMutiHarga = mysqli_query($conn, "UPDATE muti_harga SET stok='$StokListBaru' WHERE id_multi='$id_multiList'") or die(mysqli_error($conn));
                                        }
                                    }
                                }
                            } 
                        }
                        echo '<b class="text-danger">Ket:</b> Faktur Retur Berhasil Dibuat.<br>';
                        echo '<b class="text-danger">Kode Faktur:</b> <div id="KodeFaktur">'.$kode.'</div>';
                    }else{
                        echo '<b class="text-danger">Ket:</b> Terjadi kesalahan pada saat input data faktur retur.';
                    }

                } 
            }
        }
    }
?>