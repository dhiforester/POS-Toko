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
    $Data .= "\n";
    $Data .= "\n";
    $Data .= "$nama_perusahaan \n";
    $Data .= "$alamat \n";
    $Data .= "----------------------------\n";
    $Data .= "----------------------------\n";
    $Data .= "----------------------------\n";
    $Data .= "----------------------------\n";
    $Data .= $Elite2;
    $Data .= "---- TEST PAGE BERHASIL ----\n";
    $Data .= "---- TEST PAGE BERHASIL ----\n";
    $Data .= "---- TEST PAGE BERHASIL ----\n";
    $Data .= "\n";
    $Data .= "\n";
    $Data .= $potong;

    fwrite($handle, $Data);
    fclose($handle);
    copy($file, "//$host_printer/$nama_printer");
    unlink($file);
?>
