<?php
    //error display
    ini_set("display_errors","off");
    date_default_timezone_set('Asia/Jakarta');
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
    if(!empty($_GET['kode_transaksi'])){
        $kode_transaksi=$_GET['kode_transaksi'];
    }else{
        $kode_transaksi="";
    }
    //Buka data setting
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

    $FileName= "Nota  $kode_transaksi";
    //Config Plugin MPDF
    define('_MPDF_PATH','../../vendors/mpdf60/');
    include(_MPDF_PATH . "mpdf.php");
    $mpdf=new mPDF('utf-8', array($panjang_x,$lebar_y));
    $html='<style>@page *{margin-top: 0px;}</style>'; 
    //Beginning Buffer to save PHP variables and HTML tags
    ob_start(); 
    //koneksi dan error
   
   
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
    
?>
<html>
    <head>
        <title>Cetak Nota <?php echo "$kode_transaksi"; ?></title>
        <style type="text/css">
            @page {
                margin-top: <?php echo "$margin_atas"; ?>mm;
                margin-bottom: <?php echo "$margin_bawah"; ?>mm;
                margin-left: <?php echo "$margin_kiri"; ?>mm;
                margin-right: <?php echo "$margin_kanan"; ?>mm;
            }
            body{
                font-size: <?php echo "$ukuran_font";?>px;
                font-family: <?php echo "$jenis_font";?>;
                color: <?php echo "$warna_font";?>;
            }
            table tr td{
                border: none;
                padding: 2px;
                font-size: <?php echo "$ukuran_font";?>px;
                font-family: <?php echo "$jenis_font";?>;
                color: <?php echo "$warna_font";?>;
            }
            table.rincian tr td{
                border-bottom: 1px dotted #999;
                padding: 5px;
                font-size: <?php echo "$ukuran_font";?>px;
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
                <td><b>Kode Transaksi</b></td>
                <td><b>:</b></td>
                <td><?php echo "$kode_transaksi";?></td>
            </tr>
            <tr>
                <td><b>Tanggal</b></td>
                <td><b>:</b></td>
                <td><?php echo "$tanggal";?></td>
            </tr>
            <tr>
                <td><b>Transaksi</b></td>
                <td><b>:</b></td>
                <td><?php echo "$trans";?></td>
            </tr>
            <?php
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
                    if(!empty($DataMember['id_member'])){
                        $NamaMember=$DataMember['nama'];
                        echo '<tr>';
                        echo '  <td><b>Member</b></td>';
                        echo '  <td><b>:</b></td>';
                        echo '  <td>'.$NamaMember.'</td>';
                        echo '</tr>';
                        echo '<tr>';
                        echo '  <td><b>Point</b></td>';
                        echo '  <td><b>:</b></td>';
                        echo '  <td>'.$point.'</td>';
                        echo '</tr>';
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
                    if(!empty($DataMember['id_member'])){
                        $NamaMember=$DataMember['nama'];
                        echo '<tr>';
                        echo '  <td><b>Member</b></td>';
                        echo '  <td><b>:</b></td>';
                        echo '  <td>'.$NamaMember.'</td>';
                        echo '</tr>';
                    }
                }
            ?>
            <tr>
                <td><b>Petugas Kasir</b></td>
                <td><b>:</b></td>
                <td><?php echo "$petugas";?></td>
            </tr>
        </table>
        <table class="rincian" cellspacing="0">
            <tr>
                <td align="center"><b>No</b></td>
                <td align="center"><b>Nama/Merek Barang</b></td>
                <td align="center"><b>QTY</b></th>
                <td align="center"><b>Harga</b></td>
                <td align="center"><b>Jumlah</b></td>
            </tr>
            <?php
                $no = 1;
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
            ?>
            <tr>
                <td><?php echo "$no";?></td>
                <td><?php echo "$nama";?></td>
                <td><?php echo "$qty $satuan";?></td>
                <td align="right"><?php echo "Rp " . number_format($harga,0,',','.');?></td>
                <td align="right"><?php echo "Rp " . number_format($jumlah,0,',','.');?></td>
            </tr>
            <?php 
                $no++;} 
            ?>
            <tr>
                <td colspan="4" align="right">SUBTOTAL</td>
                <td align="right"><?php echo "Rp " . number_format($subtotal,0,',','.');?></td>
            </tr>
            <?php if(!empty($RpPpn)){ ?>
                <tr>
                    <td colspan="4" align="right">PPN <?php echo "($ppn %)";?></td>
                    <td align="right"><?php echo "Rp " . number_format($RpPpn,0,',','.');?></td>
                </tr>
            <?php }if(!empty($RpDiskon)){ ?>
                <tr>
                    <td colspan="4" align="right">DISKON <?php echo "($diskon %)";?></td>
                    <td align="right"><?php echo "Rp " . number_format($RpDiskon,0,',','.');?></td>
                </tr>
            <?php } ?>
            <tr>
                <td colspan="4" align="right">TOTAL</td>
                <td align="right"><?php echo "Rp " . number_format($total_tagihan,0,',','.');?></td>
            </tr>
            <tr>
                <td colspan="4" align="right">PEMBAYARAN</td>
                <td align="right"><?php echo "Rp " . number_format($pembayaran,0,',','.');?></td>
            </tr>
            <?php if(!empty($selisih)){ ?>
                <tr>
                    <td colspan="4" align="right">SELISIH</td>
                    <td align="right"><?php echo "Rp " . number_format($selisih,0,',','.');?></td>
                </tr>
            <?php } ?>
            <tr>
                <td colspan="4" align="right">KETERANGAN</td>
                <td align="right"><?php echo "$keterangan";?></td>
            </tr>
        </table>
        <br>
        TERIMA KASIH ATAS KUNJUNGAN ANDA
    </body>
</html>
<?php
    $html = ob_get_contents();
    ob_end_clean();
    $mpdf->WriteHTML(utf8_encode($html));
    $mpdf->Output($FileName.".pdf" ,'I');
    exit;
?>