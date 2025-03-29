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
    //Buka data setting
    $QrySetting = mysqli_query($conn, "SELECT * FROM setting_cetak WHERE kategori_setting='percetakan_laporan'")or die(mysqli_error($conn));
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
    //KategoriLaporan
    if(!empty($_GET['kategori'])){
        $KategoriLaporan=$_GET['kategori'];
    }else{
        $KategoriLaporan="Harian";
    }
    //OrderBy
    if(!empty($_GET['OrderBy'])){
        $OrderBy=$_GET['OrderBy'];
    }else{
        $OrderBy="id_transaksi";
    }
    //ShortBy
    if(!empty($_GET['ShortBy'])){
        $ShortBy=$_GET['ShortBy'];
    }else{
        $ShortBy="ASC";
    }
    //tanggal
    if(!empty($_GET['tanggal'])){
        $tanggal=$_GET['tanggal'];
    }else{
        $tanggal="";
    }
    //tahun
    if(!empty($_GET['tahun'])){
        $tahun=$_GET['tahun'];
    }else{
        $tahun="";
    }
    //bulan
    if(!empty($_GET['bulan'])){
        $bulan=$_GET['bulan'];
    }else{
        $bulan="";
    }
    //periode1
    if(!empty($_GET['periode1'])){
        $periode1=$_GET['periode1'];
    }else{
        $periode1="";
    }
    //periode2
    if(!empty($_GET['periode2'])){
        $periode2=$_GET['periode2'];
    }else{
        $periode2="";
    }
    $bulanan="$tahun-$bulan";
    //Menghitung jumlah Penjualan
    if($KategoriLaporan=="Harian"){
        $QryJumlahTotalPenjualan = mysqli_query($conn, "SELECT SUM(total_tagihan) as total_tagihan FROM transaksi WHERE jenis_transaksi='penjualan' AND tanggal like '%$tanggal%'");
    }
    if($KategoriLaporan=="Bulanan"){
        $QryJumlahTotalPenjualan = mysqli_query($conn, "SELECT SUM(total_tagihan) as total_tagihan FROM transaksi WHERE jenis_transaksi='penjualan' AND tanggal like '%$bulanan%'");
    }
    if($KategoriLaporan=="Tahunan"){
        $QryJumlahTotalPenjualan = mysqli_query($conn, "SELECT SUM(total_tagihan) as total_tagihan FROM transaksi WHERE jenis_transaksi='penjualan' AND tanggal like '%$tahun%'");
    }
    if($KategoriLaporan=="Periode"){
        $QryJumlahTotalPenjualan = mysqli_query($conn, "SELECT SUM(total_tagihan) as total_tagihan FROM transaksi WHERE jenis_transaksi='penjualan' AND tanggal>='$periode1' AND tanggal<='$periode2'");
    }
    $DataJumlahTotalPenjualan = mysqli_fetch_array($QryJumlahTotalPenjualan);
    $JumlahPenjualan=$DataJumlahTotalPenjualan['total_tagihan'];
    
    //Menghitung jumlah pembelian
    if($KategoriLaporan=="Harian"){
        $QryJumlahTotalPembelian = mysqli_query($conn, "SELECT SUM(total_tagihan) as total_tagihan FROM transaksi WHERE jenis_transaksi='pembelian' AND tanggal like '%$tanggal%'");
    }
    if($KategoriLaporan=="Bulanan"){
        $QryJumlahTotalPembelian = mysqli_query($conn, "SELECT SUM(total_tagihan) as total_tagihan FROM transaksi WHERE jenis_transaksi='pembelian' AND tanggal like '%$bulanan%'");
    }
    if($KategoriLaporan=="Tahunan"){
        $QryJumlahTotalPembelian = mysqli_query($conn, "SELECT SUM(total_tagihan) as total_tagihan FROM transaksi WHERE jenis_transaksi='pembelian' AND tanggal like '%$tahun%'");
    }
    if($KategoriLaporan=="Periode"){
        $QryJumlahTotalPembelian = mysqli_query($conn, "SELECT SUM(total_tagihan) as total_tagihan FROM transaksi WHERE jenis_transaksi='pembelian' AND tanggal>='$periode1' AND tanggal<='$periode2'");
    }
    $DataJumlahTotalPembelian = mysqli_fetch_array($QryJumlahTotalPembelian);
    $JumlahPembelian=$DataJumlahTotalPembelian['total_tagihan'];
    ///Menghitung jumlah Total
    $Selisih=$JumlahPenjualan-$JumlahPembelian;

    $FileName= "LaporanJualBeli";
    //Config Plugin MPDF
    define('_MPDF_PATH','../../vendors/mpdf60/');
    include(_MPDF_PATH . "mpdf.php");
    $mpdf=new mPDF('utf-8', array($panjang_x,$lebar_y));
    $html='<style>@page *{margin-top: 0px;}</style>'; 
    //Beginning Buffer to save PHP variables and HTML tags
    ob_start(); 
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
                border: 1px groove #000000;
                padding: 2px;
                font-size: <?php echo "$ukuran_font";?>px;
                font-family: <?php echo "$jenis_font";?>;
                color: <?php echo "$warna_font";?>;
            }
            table.rincian tr td{
                border: 1px groove #000000;
                padding: 5px;
                font-size: <?php echo "$ukuran_font";?>px;
                font-family: <?php echo "$jenis_font";?>;
                color: <?php echo "$warna_font";?>;
            }
        </style>
    </head>
    <body>
        <table class="rincian" cellspacing="0">
            <tr>
                <td align="center" colspan="7">
                    <h2><?php echo "$nama_perusahaan";?></h2>
                    <?php echo "$alamat $kontak";?>
                </td>
            </tr>
            <tr>
                <td align="center"><b>No</b></td>
                <td align="center"><b>Tanggal</b></td>
                <td align="center"><b>Kode</b></td>
                <td align="center"><b>Penjualan</b></td>
                <td align="center"><b>Pembelian</b></td>
                <td align="center"><b>Pembayaran</b></td>
                <td align="center"><b>Keterangan</b></td>
            </tr>
            <?php
                $no = 1;
                //KONDISI PENGATURAN MASING FILTER
                if($KategoriLaporan=="Harian"){
                    $query = mysqli_query($conn, "SELECT*FROM transaksi WHERE tanggal like '%$tanggal%' ORDER BY $OrderBy $ShortBy");
                }
                if($KategoriLaporan=="Bulanan"){
                    $query = mysqli_query($conn, "SELECT*FROM transaksi WHERE tanggal like '%$bulanan%' ORDER BY $OrderBy $ShortBy");
                }
                if($KategoriLaporan=="Tahunan"){
                    $query = mysqli_query($conn, "SELECT*FROM transaksi WHERE tanggal like '%$tahun%' ORDER BY $OrderBy $ShortBy");
                }
                if($KategoriLaporan=="Periode"){
                    $query = mysqli_query($conn, "SELECT*FROM transaksi WHERE tanggal>='$periode1' AND tanggal<='$periode2' ORDER BY $OrderBy $ShortBy");
                }
                
                while ($data = mysqli_fetch_array($query)) {
                    $id_transaksi = $data['id_transaksi'];
                    $kode_transaksi = $data['kode_transaksi'];
                    $tanggal = $data['tanggal'];
                    $jenis_transaksi= $data['jenis_transaksi'];
                    $selisih= $data['selisih'];
                    $keterangan= $data['keterangan'];
                    if(!empty($data['pembayaran'])){
                        $pembayaran= $data['pembayaran'];
                    }else{
                        $pembayaran="0";
                    }
                    if(!empty($data['total_tagihan'])){
                        $total_tagihan= $data['total_tagihan'];
                    }else{
                        $total_tagihan="0";
                    }
            ?>
            <tr>
                <td align="center"><?php echo "$no";?></td>
                <td><?php echo "$tanggal";?></td>
                <td><?php echo "$kode_transaksi";?></td>
                <td align="right">
                    <?php 
                        if($jenis_transaksi=="penjualan"){
                            echo "$total_tagihan";
                        }else{
                            echo "-";
                        }
                    ?>
                </td>
                <td align="right">
                    <?php 
                        if($jenis_transaksi=="pembelian"){
                            echo "$total_tagihan";
                        }else{
                            echo "-";
                        }
                    ?>
                </td>
                <td align="right">
                    <?php 
                        echo "$total_tagihan";
                    ?>
                </td>
                <td><?php echo "$keterangan";?></td>
            </tr>
            <?php $no++;} ?>
            <tr class="text-white">
                <td colspan="3" align="right"><b>JUMLAH PEMBELIAN - PENJUALAN</b></td>
                <td align="right"> <?php echo "Rp " . number_format($JumlahPenjualan,0,',','.'); ?> </td>
                <td align="right"><?php echo "Rp " . number_format($JumlahPembelian,0,',','.'); ?></td>
                <td align="right">
                    <?php 
                        if($Selisih=="0"){
                            echo "Rp " . number_format($Selisih,0,',','.');
                        }else{
                            if($Selisih>"0"){
                                echo "<b class='text-success'>";
                                echo "Rp " . number_format($Selisih,0,',','.');
                                echo "</b>";
                            }else{
                                echo "<b class='text-danger'>";
                                echo "Rp " . number_format($Selisih,0,',','.');
                                echo "</b>";
                            }
                        }
                            
                    ?>
                </td>
                <td align="center">
                    <?php 
                        if($Selisih=="0"){
                            echo "None";
                        }else{
                            if($Selisih>"0"){
                                echo "<b class='text-success'>Profit/Laba</b>";
                            }else{
                                echo "<b class='text-danger'>Rugi</b>";
                            }
                        }
                    ?>
                </td>
            </tr>
        </table>
    </body>
</html>
<?php
    $html = ob_get_contents();
    ob_end_clean();
    $mpdf->WriteHTML(utf8_encode($html));
    $mpdf->Output($FileName.".pdf" ,'I');
    exit;
?>