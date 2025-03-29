<?php
    //koneksi dan error
    ini_set("display_errors","off");
    include "../../_Config/Connection.php";
    $Qry = mysqli_query($conn, "SELECT * FROM setting_aplikasi")or die(mysqli_error($conn));
    $DataSetting = mysqli_fetch_array($Qry);
    //Nama Perusahaan
    if(!empty($DataSetting['nama_perusahaan'])){
        $nama_perusahaan = $DataSetting['nama_perusahaan'];
    }else{
        $nama_perusahaan = "Business Today";
    }
    //Alamat
    if(!empty($DataSetting['alamat'])){
        $alamat = $DataSetting['alamat'];
    }else{
        $alamat ="";
    }
    //kontak
    if(!empty($DataSetting['kontak'])){
        $kontak = $DataSetting['kontak'];
    }else{
        $kontak ="";
    }
    //logo
    if(!empty($DataSetting['logo'])){
        $logo = $DataSetting['logo'];
    }else{
        $logo ="";
    }
    //logo
    if(!empty($DataSetting['aktif_promo'])){
        $aktif_promo = $DataSetting['aktif_promo'];
    }else{
        $aktif_promo ="Tidak";
    }
    //jumlah_point
    if(!empty($DataSetting['jumlah_point'])){
        $jumlah_point = $DataSetting['jumlah_point'];
    }else{
        $jumlah_point ="0";
    }
    //kelipatan_belanja
    if(!empty($DataSetting['kelipatan_belanja'])){
        $kelipatan_belanja = $DataSetting['kelipatan_belanja'];
    }else{
        $kelipatan_belanja ="0";
    }
    //nama_printer
    if(!empty($DataSetting['nama_printer'])){
        $nama_printer = $DataSetting['nama_printer'];
    }else{
        $nama_printer ="POS";
    }
    //host_printer 
    if(!empty($DataSetting['host_printer '])){
        $host_printer = $DataSetting['host_printer'];
    }else{
        $host_printer="localhost";
    }
    if(empty($_POST['kode'])){
        $tmpdir = sys_get_temp_dir();
        $file = tempnam($tmpdir, 'ctk');
        $handle = fopen($file, 'w');
        $condensed = Chr(27) . Chr(33) . Chr(4);
        $bold1 = Chr(27) . Chr(69);
        $bold0 = Chr(27) . Chr(70);
        $Large = Chr(14);
        $Strike = Chr(27) . Chr(87) . Chr(49);
        $Elite1 = Chr(29) . Chr(33) . Chr(0) . Chr(0);
        $Elite2 = Chr(29) . Chr(33) . Chr(1) . Chr(19);
        $subscript= Chr(27) . Chr(83) . Chr(49);
        $initialized = chr(27).chr(64);
        $condensed1 = chr(15);
        $condensed0 = chr(18);
        $Data = $initialized;
        $Data .= $condensed1;
        $Data .= "\n";
        $Data .= "\n";
        $Data .= "KODE TRANSAKSI TIDAK TERBACA \n";
        $Data .= "\n";
        $Data .= "\n";
        $Data .= "\n";
        fwrite($handle, $Data);
        fclose($handle);
        copy($file, "//localhost/POSBARU");
        unlink($file);
    }else{
        $kode=$_POST['kode'];
        //Buka Retur
        $QryRetur = mysqli_query($conn, "SELECT * FROM retur WHERE kode='$kode'")or die(mysqli_error($conn));
        $DataRetur = mysqli_fetch_array($QryRetur);
        $id_retur=$DataRetur['id_retur'];
        $id_transaksi=$DataRetur['id_transaksi'];
        $tanggal=$DataRetur['tanggal'];
        $subtotal=$DataRetur['subtotal'];
        $ppn=$DataRetur['ppn'];
        $diskon=$DataRetur['diskon'];
        $tagihan=$DataRetur['tagihan'];
        $pembayaran=$DataRetur['pembayaran'];
        $selisih=$DataRetur['selisih'];
        $keterangan=$DataRetur['keterangan'];
        //Buka transaksi
        $QryTransaksi = mysqli_query($conn, "SELECT * FROM transaksi WHERE id_transaksi='$id_transaksi'")or die(mysqli_error($conn));
        $DataTransaksi = mysqli_fetch_array($QryTransaksi);
        $kode_transaksi=$DataTransaksi['kode_transaksi'];
        $trans=$DataTransaksi['jenis_transaksi'];
        if(!empty($DataTransaksi['petugas'])){
            $petugas = $DataTransaksi['petugas'];
        }else{
            $petugas ="";
        }
        
        if($trans=="penjualan"){
            //Buka data pemberian point
            $QryPemberianPoint = mysqli_query($conn, "SELECT * FROM pemberian_point WHERE kode_transaksi='$kode_transaksi'")or die(mysqli_error($conn));
            $DataPemberianPoint = mysqli_fetch_array($QryPemberianPoint);
            $IdMember=$DataPemberianPoint['id_member'];
            $point=$DataPemberianPoint['point'];
            //Buka nama member
            $QryMember = mysqli_query($conn, "SELECT * FROM member WHERE id_member='$IdMember'")or die(mysqli_error($conn));
            $DataMember = mysqli_fetch_array($QryMember);
            $NamaMember=$DataMember['nama'];
            if(empty($DataMember['id_member'])){
                $NamaMember="Tidak Ada";
            }else{
                $NamaMember=$DataMember['nama'];
            }
        }
        if($trans=="pembelian"){
            //Buka data transaksi supplier
            $QryTransaksiSupplier = mysqli_query($conn, "SELECT * FROM transaksi_supplier WHERE kode_transaksi='$kode_transaksi'")or die(mysqli_error($conn));
            $DataTransaksiSupplier = mysqli_fetch_array($QryTransaksiSupplier);
            $IdMember=$DataTransaksiSupplier['tanggal'];
            //Buka nama member
            $QryMember = mysqli_query($conn, "SELECT * FROM member WHERE id_member='$IdMember'")or die(mysqli_error($conn));
            $DataMember = mysqli_fetch_array($QryMember);
            $NamaMember=$DataMember['id_member'];
            if(empty($DataMember['nama'])){
                $NamaMember="Tidak Ada";
            }else{
                $NamaMember=$DataMember['nama'];
            }
        }
        //Buka Setting percetakan
        $QrySetting = mysqli_query($conn, "SELECT * FROM setting_cetak WHERE kategori_setting='percetakan_nota'")or die(mysqli_error($conn));
        $DataSetting = mysqli_fetch_array($QrySetting);
        $kategori_setting = $DataSetting['kategori_setting'];
        $margin_atas = $DataSetting['margin_atas'];
        $margin_bawah = $DataSetting['margin_bawah'];
        $margin_kiri = $DataSetting['margin_kiri'];
        $margin_kanan = $DataSetting['margin_kanan'];
        $panjang_x = $DataSetting['panjang_x'];
        $lebar_y = $DataSetting['lebar_y'];
        $jenis_font = $DataSetting['jenis_font'];
        $ukuran_font = $DataSetting['ukuran_font'];
        $warna_font = $DataSetting['warna_font'];
?>
<?php
    $tmpdir = sys_get_temp_dir();
    $file = tempnam($tmpdir, 'ctk');
    $handle = fopen($file, 'w');
    $condensed = Chr(27) . Chr(33) . Chr(4);
    $bold1 = Chr(27) . Chr(69);
    $bold0 = Chr(27) . Chr(70);
    $Large = Chr(14);
    $Strike = Chr(27) . Chr(87) . Chr(49);
    $Elite1 = Chr(29) . Chr(33) . Chr(0) . Chr(0);
    $Elite2 = Chr(29) . Chr(33) . Chr(1) . Chr(19);
    $subscript= Chr(27) . Chr(83) . Chr(49);

    $initialized = chr(27).chr(64);
    $condensed1 = chr(15);
    $condensed0 = chr(18);
    $Data = $initialized;
    $Data .= $condensed1;
    $Data .= "\n";
    $Data .= "\n";
    $Data .= "$nama_perusahaan \n";
    $Data .= "$alamat \n";
    $Data .= "Kode   : $kode \n";
    $Data .= "Tgl    : $tanggal \n";
    if($trans=="penjualan"){
        $QryPemberianPoint = mysqli_query($conn, "SELECT * FROM pemberian_point WHERE kode_transaksi='$kode_transaksi'")or die(mysqli_error($conn));
        $DataPemberianPoint = mysqli_fetch_array($QryPemberianPoint);
        $IdMember=$DataPemberianPoint['id_member'];
        $point=$DataPemberianPoint['point'];
        //Buka nama member
        $QryMember = mysqli_query($conn, "SELECT * FROM member WHERE id_member='$IdMember'")or die(mysqli_error($conn));
        $DataMember = mysqli_fetch_array($QryMember);
        $NamaMember=$DataMember['nama'];
        if(!empty($DataMember['nama'])){
    $Data .= "Member : $NamaMember \n";
        }
    }else{
        $QryTransaksiSupplier = mysqli_query($conn, "SELECT * FROM transaksi_supplier WHERE kode_transaksi='$kode_transaksi'")or die(mysqli_error($conn));
        $DataTransaksiSupplier = mysqli_fetch_array($QryTransaksiSupplier);
        $IdMember=$DataTransaksiSupplier['tanggal'];
        //Buka nama member
        $QryMember = mysqli_query($conn, "SELECT * FROM member WHERE id_member='$IdMember'")or die(mysqli_error($conn));
        $DataMember = mysqli_fetch_array($QryMember);
        $NamaMember=$DataMember['id_member'];
        if(!empty($DataMember['id_member'])){
            $NamaMember=$DataMember['nama'];
    $Data .= "Supplier : $NamaMember \n";
        }
    }
    if(empty($DataTransaksi['petugas'])){
    $Data .= "Petugas  : $petugas \n";
    }
    $Data .= "----------------------------\n";
    $Data .= "BARANG       HARGA    JMLH\n";
    //KONDISI PENGATURAN MASING FILTER
    $query = mysqli_query($conn, "SELECT*FROM retur_rincian WHERE id_retur='$id_retur' ORDER BY id_rincian_retur DESC");
    while ($data = mysqli_fetch_array($query)) {
        $id_rincian_retur = $data['id_rincian_retur'];
        $nama_barang = $data['nama_barang'];
        $harga = $data['harga'];
        $qty = $data['qty'];
        $satuan = $data['satuan'];
        $jumlah = $data['jumlah'];
    $Data .= "$nama_barang $qty $harga \n $jumlah\n"; 
    }
    $Data .= "----------------------------\n";
    $Data .= "Subtotal  : $subtotal \n";
    if(!empty($RpPpn)){
    $Data .= "PPN($ppn) : $RpPpn \n";
    }
    $Data .= "TOTAL     : $tagihan \n";
    $Data .= "KETERANGAN: $keterangan \n";
    $Data .= "----------------------------\n";
    $Data .= $Elite2;
    $Data .= "--Terima Kasih-- \n";
    $Data .= "\n";
    $Data .= "\n";
    $Data .= "\n";
    fwrite($handle, $Data);
    fclose($handle);
    copy($file, "//$host_printer/$nama_printer");
    unlink($file);
}
?>
