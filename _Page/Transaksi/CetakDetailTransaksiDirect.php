<?php
    //koneksi dan error
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
    //kode_transaksi
    if(!empty($_POST['kode_transaksi'])){
        $kode_transaksi=$_POST['kode_transaksi'];
    }else{
        $kode_transaksi="";
    }
    //Buka rincian transaksi
    $QryTransaksi = mysqli_query($conn, "SELECT * FROM transaksi WHERE kode_transaksi='$kode_transaksi'")or die(mysqli_error($conn));
    $DataTransaksi = mysqli_fetch_array($QryTransaksi);
    $tanggal=$DataTransaksi['tanggal'];
    $trans=$DataTransaksi['jenis_transaksi'];
    $subtotal = $DataTransaksi['subtotal'];
    $RpPpn = $DataTransaksi['ppn'];
    $RpBiaya = $DataTransaksi['biaya'];
    $RpDiskon = $DataTransaksi['diskon'];
    $total_tagihan = $DataTransaksi['total_tagihan'];
    if(empty($DataTransaksi['pembayaran'])){
        $pembayaran="0";
    }else{
        $pembayaran = $DataTransaksi['pembayaran'];
    }
    $selisih = $DataTransaksi['selisih'];
    $keterangan = $DataTransaksi['keterangan'];
    $petugas = $DataTransaksi['petugas'];
    //Menghiutng persen ppn dan diskon
    $ppn=($RpPpn/$subtotal)*100;
    $diskon=($RpDiskon/$subtotal)*100;
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
$potong= Chr(29) . "V" . 0;
    $initialized = chr(27).chr(64);
    $condensed1 = chr(15);
    $condensed0 = chr(18);
    $Data = $initialized;
    $Data .= $condensed1;
    $Data .= "                $nama_perusahaan \n";
    $Data .= "           $alamat \n";
    $Data .= "Kode   : $kode_transaksi \n";
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
    $Data .= "Point  : $point \n";
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
    $Data .= "------------------------------------------\n";
    $Data .= "BARANG             HARGA          JMLH\n";
    $query = mysqli_query($conn, "SELECT*FROM rincian_transaksi WHERE kode_transaksi='$kode_transaksi' ORDER BY id_rincian DESC");
    while ($data = mysqli_fetch_array($query)) {
        $id_rincian = $data['id_rincian'];
        $id_obat = $data['id_obat'];
        $nama = $data['nama'];
        $qty= $data['qty'];
        $harga = $data['harga'];
        $jumlah= $data['jumlah'];
        $id_multi= $data['id_multi'];
        //Buka data Obat
        if(empty($id_multi)){
            $QryObat = mysqli_query($conn, "SELECT * FROM obat WHERE id_obat='$id_obat'")or die(mysqli_error($conn));
            $DataObat = mysqli_fetch_array($QryObat);
            $satuan = $DataObat['satuan'];
        }else{
            $QryObat = mysqli_query($conn, "SELECT * FROM muti_harga WHERE id_multi='$id_multi'")or die(mysqli_error($conn));
            $DataObat = mysqli_fetch_array($QryObat);
            $satuan = $DataObat['satuan'];
        }
    $Data .= "$nama                 $qty   $harga   $jumlah\n"; 
    }
    $Data .= "--------------------------------------------\n";
    $Data .= "Subtotal  : $subtotal \n";
    if(!empty($RpPpn)){
    $Data .= "PPN($ppn) : $RpPpn \n";
    }
    if(!empty($RpDiskon)){
    $Data .= "DISKON    : $RpDiskon \n";
    }
    $Data .= "TOTAL     : $total_tagihan \n";
    $Data .= "KETERANGAN: $keterangan \n";
    $Data .= "--------------------------------------------\n";
    $Data .= $Elite2;
    $Data .= "--Terima Kasih-- \n";
    $Data .= "\n";
    $Data .= "\n";
    $Data .= "\n";
$Data .= "\n";
$Data .= "\n";
$Data .= "\n";
$Data .= $potong;
    fwrite($handle, $Data);
    fclose($handle);
    copy($file, "//$host_printer/$nama_printer");
    unlink($file);
?>
