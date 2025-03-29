<?php
    
    include "../../_Config/Connection.php";
    if(empty($_POST['kode'])){
        $kode="0";
        echo "<b id='NotifikasiHapusReturBerhasil'>Hapus Gagal</b>";
    }else{
        $kode=$_POST['kode'];
        //Buka data retur
        $QryRetur = mysqli_query($conn, "SELECT * FROM retur WHERE kode='$kode'")or die(mysqli_error($conn));
        $DataRetur = mysqli_fetch_array($QryRetur);
        $id_retur=$DataRetur['id_retur'];
        $id_transaksi=$DataRetur['id_transaksi'];
        //Araykan rincian retur
        $query = mysqli_query($conn, "SELECT*FROM retur_rincian WHERE id_retur='$id_retur' ORDER BY id_rincian_retur DESC");
        while ($data = mysqli_fetch_array($query)) {
            $id_rincian_retur = $data['id_rincian_retur'];
            $id_rincian_transaksi = $data['id_rincian_transaksi'];
            $id_barang= $data['id_barang'];
            $nama_barang = $data['nama_barang'];
            $harga = $data['harga'];
            $qty = $data['qty'];
            $satuan = $data['satuan'];
            $jumlah = $data['jumlah'];
            $id_multi= $data['id_multi'];
            //Buka data multi rincian
            $QryMulti = mysqli_query($conn, "SELECT * FROM muti_harga WHERE id_multi='$id_multi'")or die(mysqli_error($conn));
            $DataMulti = mysqli_fetch_array($QryMulti);
            $KonversiRincian = $DataMulti['konversi'];
            //Buka data barang
            $QryObat = mysqli_query($conn, "SELECT * FROM obat WHERE id_obat='$id_barang'")or die(mysqli_error($conn));
            $DataObat = mysqli_fetch_array($QryObat);
            $stok = $DataObat['stok'];
            $konversi = $DataObat['konversi'];
            //Buka data transaksi
            $QryTransaksi = mysqli_query($conn, "SELECT * FROM transaksi WHERE id_transaksi='$id_transaksi'")or die(mysqli_error($conn));
            $DataTransaksi = mysqli_fetch_array($QryTransaksi);
            //Apabila penjualan
            if(empty($DataTransaksi['jenis_transaksi'])){
                echo "<b id='NotifikasiHapusReturBerhasil'>Jenis Transaksi Tidak Terbaca</b>";
            }else{
                $trans = $DataTransaksi['jenis_transaksi'];
                //UPDATE STOK BARANG BERDASARKAN JENIS TRANSAKSI
                if($trans=="penjualan"){
                    //Apabila tidak ada id multi
                    if($id_multi=="0"){
                        $StokBarangBaru=$stok-$qty;
                    }else{
                        $qty=($KonversiRincian/$konversi)*$qty;
                        $StokBarangBaru=$stok-$qty;
                    }
                    //Update Stok Barang baru
                    $EditBarang= mysqli_query($conn, "UPDATE obat SET stok='$StokBarangBaru' WHERE id_obat='$id_barang'") or die(mysqli_error($conn));
                    //Update Rincian Transaksi Agar Barang Balik Lagi jadi ditambahkan
                    //Buka data rincian transaksi
                    $QryRincianTransaksi = mysqli_query($conn, "SELECT * FROM rincian_transaksi WHERE id_rincian='$id_rincian_transaksi'")or die(mysqli_error($conn));
                    $DataRincianTransaksi = mysqli_fetch_array($QryRincianTransaksi);
                    $IdObatRincianTransaksi=$DataRincianTransaksi['id_obat'];
                    $IdMultiRincianTransaksi=$DataRincianTransaksi['id_multi'];
                    $QtyRincianTransaksi=$DataRincianTransaksi['qty'];
                    $HargaRincianTransaksi=$DataRincianTransaksi['harga'];
                    $JumlahRincianTransaksi=$DataRincianTransaksi['jumlah'];
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
                        $QtyRincianTransaksiBaru=$QtyRincianTransaksi+$qty;
                        $JumlahRincianTransaksiBaru=$QtyRincianTransaksiBaru*$HargaRincianTransaksi;
                    }else{
                        $QtyReturSatuanRincian=($KonversiRincian/$KonversiMultiHargaRincianTransaksi)*$qty;
                        $QtyRincianTransaksiBaru=$QtyRincianTransaksi+$QtyReturSatuanRincian;
                        $JumlahRincianTransaksiBaru=$QtyRincianTransaksiBaru*$HargaRincianTransaksi;
                    }
                    //Lakukan Update pada masing-masing rincian transaksi berdasarkan id rincian pada retur rincian
                    $EditRincianTransaksi = mysqli_query($conn, "UPDATE rincian_transaksi SET 
                        qty='$QtyRincianTransaksiBaru',
                        jumlah='$JumlahRincianTransaksiBaru' 
                    WHERE id_rincian='$id_rincian_transaksi'") or die(mysqli_error($conn));
                }else{
                    //Apabila tidak ada id multi
                    if($id_multi=="0"){
                        $StokBarangBaru=$stok+$qty;
                    }else{
                        $qty=($KonversiRincian/$konversi)*$qty;
                        $StokBarangBaru=$stok+$qty;
                    }
                    //Update Stok Barang baru
                    $EditBarang= mysqli_query($conn, "UPDATE obat SET stok='$StokBaru' WHERE id_obat='$id_barang'") or die(mysqli_error($conn));
                    //Update Rincian Transaksi Agar Barang Balik Lagi jadi ditambahkan
                    //Buka data rincian transaksi
                    $QryRincianTransaksi = mysqli_query($conn, "SELECT * FROM rincian_transaksi WHERE id_rincian='$id_rincian_transaksi'")or die(mysqli_error($conn));
                    $DataRincianTransaksi = mysqli_fetch_array($QryRincianTransaksi);
                    $IdObatRincianTransaksi=$DataRincianTransaksi['id_obat'];
                    $IdMultiRincianTransaksi=$DataRincianTransaksi['id_multi'];
                    $QtyRincianTransaksi=$DataRincianTransaksi['qty'];
                    $HargaRincianTransaksi=$DataRincianTransaksi['harga'];
                    $JumlahRincianTransaksi=$DataRincianTransaksi['jumlah'];
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
                        $QtyRincianTransaksiBaru=$QtyRincianTransaksi+$qty;
                        $JumlahRincianTransaksiBaru=$QtyRincianTransaksiBaru*$HargaRincianTransaksi;
                    }else{
                        $QtyReturSatuanRincian=($KonversiRincian/$KonversiMultiHargaRincianTransaksi)*$qty;
                        $QtyRincianTransaksiBaru=$QtyRincianTransaksi+$QtyReturSatuanRincian;
                        $JumlahRincianTransaksiBaru=$QtyRincianTransaksiBaru*$HargaRincianTransaksi;
                    }
                    //Lakukan Update pada masing-masing rincian transaksi berdasarkan id rincian pada retur rincian
                    $EditRincianTransaksi = mysqli_query($conn, "UPDATE rincian_transaksi SET 
                        qty='$QtyRincianTransaksiBaru',
                        jumlah='$JumlahRincianTransaksiBaru' 
                    WHERE id_rincian='$id_rincian_transaksi'") or die(mysqli_error($conn));
                }
                //Lakukan Hapus Data
            }
            //Hapus Data rincian Faktur
            $HapusRincianRetur = mysqli_query($conn, "DELETE FROM retur_rincian WHERE id_rincian_retur='$id_rincian_retur'") or die(mysqli_error($conn));
        }
        //Hapus Retur
        $HapusRetur = mysqli_query($conn, "DELETE FROM retur WHERE id_retur='$id_retur'") or die(mysqli_error($conn));
        if($HapusRetur){
            echo "<b class='NotifikasiHapusReturBerhasil'>Berhasil</b>";
        }else{
            echo "<b class='NotifikasiHapusReturBerhasil'>Gagal</b>";
        }
    }
?>