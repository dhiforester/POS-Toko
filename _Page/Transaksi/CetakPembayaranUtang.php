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
    if(!empty($_GET['id'])){
        $id_utang_piutang=$_GET['id'];
    }else{
        $id_utang_piutang="";
    }
    //Buka rincian transaksi
    $QryUtangPiutang = mysqli_query($conn, "SELECT * FROM utang_piutang WHERE id_utang_piutang='$id_utang_piutang'")or die(mysqli_error($conn));
    $DataUtangPiutang = mysqli_fetch_array($QryUtangPiutang);
    $kode=$DataUtangPiutang['kode'];
    $tanggal=$DataUtangPiutang['tanggal'];
    $id_transaksi=$DataUtangPiutang['id_transaksi'];
    $uang=$DataUtangPiutang['uang'];
    $keterangan=$DataUtangPiutang['keterangan'];
    //Buka data transaksi
    $QryTransaksi = mysqli_query($conn, "SELECT * FROM transaksi WHERE id_transaksi='$id_transaksi'")or die(mysqli_error($conn));
    $DataTransaksi = mysqli_fetch_array($QryTransaksi);
    $kode_transaksi=$DataTransaksi['kode_transaksi'];
    //Buka seting cetak
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
<html>
    <head>
        <title>Cetak Nota <?php echo "$kode_transaksi"; ?></title>
        <style type="text/css">
            body{
                font-size: <?php echo "$ukuran_font";?>px;
                font-family: <?php echo "$jenis_font";?>;
                color: <?php echo "$warna_font";?>;
            }
            table tr td{
                border: none;
                padding: 0px;
                font-size: <?php echo "$ukuran_font";?>px;
                font-family: <?php echo "$jenis_font";?>;
                color: <?php echo "$warna_font";?>;
            }
            table.rincian tr td{
                padding: 0px;
                font-size: <?php echo "$ukuran_font";?>px;
                font-family: <?php echo "$jenis_font";?>;
                color: <?php echo "$warna_font";?>;
            }
            td.title{
                padding: 0px;
                font-size: 20px;
                font-family: <?php echo "$jenis_font";?>;
                color: <?php echo "$warna_font";?>;
            }
        </style>
    </head>
    <body>
        <table>
            <tr>
                <td colspan="3" class="title">
                    <?php 
                        if(!empty($nama_perusahaan)){
                            echo "<b>$nama_perusahaan</b>";
                        }
                    ?>
                </td>
            </tr>
            <tr>
                <td colspan="3" class="">
                    <?php 
                        if(!empty($alamat)){
                            echo "$alamat";
                        }
                    ?>
                </td>
            </tr>
            <tr>
                <td colspan="3" class="">
                    Tanda bukti <?php echo "$keterangan";?>
                </td>
            </tr>
            <tr>
                <td colspan="3" class="">
                    TANGGAL : <?php echo "$tanggal";?>
                </td>
            </tr>
            <tr>
                <td colspan="3" class="">
                    NOTA/TANDA BUKTI : <?php echo "$kode";?>
                </td>
            </tr>
            <tr>
                <td colspan="3" class="">
                    FAKTUR TRANSAKSI : <?php echo "$kode_transaksi";?>
                </td>
            </tr>
            <tr>
                <td colspan="3" class="">
                    <b>JUMLAH PEMBAYARAN: <?php echo "Rp $uang";?></b>
                </td>
            </tr>
           
        </table>
        <br>
        TERIMA KASIH ATAS KUNJUNGAN ANDA
    </body>
</html>
