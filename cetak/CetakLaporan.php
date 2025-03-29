<?php
    //koneksi dan error
    ini_set("display_errors","off");
    include "../_Config/Connection.php";
    include "../_Config/SessionLogin.php";
    //Tangkap Parameter
    $kategori=$_GET['kategori'];
    $tanggal1=$_GET['tanggal1'];
    $tanggal2=$_GET['tanggal2'];
    //Pengaturan file PDF
    $FileName= "Laporan- $kategori";
    //Config Plugin MPDF
    define('_MPDF_PATH','../vendors/mpdf60/');
    include(_MPDF_PATH . "mpdf.php");
    $mpdf=new mPDF('utf-8', 'A4');
    $html='<style>@page *{margin-top: 0px;}</style>'; 
    //Beginning Buffer to save PHP variables and HTML tags
    ob_start(); 
?>

<html>
    <head>
        <title><?php echo $FileName;?> </title>
        <style type="text/css">
            @page {
                margin-top: 2cm;
                margin-bottom: 2cm;
                margin-left: 2cm;
                margin-right: 2cm;
            }
            body {
                background-color: #FFF;
                font-family: arial;
            }
            table{
                border-collapse: collapse;
                margin-top:10px;
            }
            table.data tr td {
                border: 0.5px solid #666;
                color:#333;
                border-spacing: 0px;
                padding: 10px;
                border-collapse: collapse;
            }
            b.NamaToko{
                font-size: 24px;
            }
        </style>
    </head>
    <body>
        <table class="title" width="100%">
            <tr>
                <td align="center">
                    <b class="NamaTOko">Toko Putra Cimahi</b><br>
                    Jalan Raya Ciniru Desa Cirukem Blok Manis Dusun Gamping
                    <br><br>
                </td>
            </tr>
        </table>
        
        <table class="data" width="100%" celspacing="0">
            <tr>
                <td align="center" colspan="6">
                   <b>Laporan Transaksi</b>
                </td>
            </tr>
            <tr>
                <td align="center" colspan="6">
                   <b>Periode <?php echo "$tanggal1 s/d $tanggal2"; ?></b>
                </td>
            </tr>
            <tr>
                <td align="center"><b>No</b></td>
                <td align="center"><b>No.Faktur</b></td>
                <td align="center"><b>Tanggal</b></td>
                <td align="center"><b>Supplier</b></td>
                <td align="center"><b>Jumlah</b></td>
                <td align="center"><b>Status</b></td>
            </tr>
            <?php
                $no = 1;
                $query = mysql_query("SELECT*FROM transaksi WHERE kategori='$kategori' AND tanggal>='$tanggal1' AND tanggal<='$tanggal2'");
                while ($data = mysql_fetch_array($query)) {
                    $JumlahTotal="0";
                    $id_transaksi = $data['id_transaksi'];
                    $kode_faktur = $data['kode_faktur'];
                    $id_akses = $data['id_akses'];
                    $tanggal= $data['tanggal'];
                    $status = $data['status'];
                    //Buka nama supplier
                    $QueryNamaPembeli = mysql_query("SELECT * FROM akses WHERE id_akses='$id_akses'")or die(mysql_error());
                    $DataNamaPembeli = mysql_fetch_array($QueryNamaPembeli);
                    $NamaPembeli = $DataNamaPembeli['nama'];
                    //Menghitung jumlah penjualan
                    $QryRincian = mysql_query("SELECT*FROM rincian WHERE kode_faktur='$kode_faktur'");
                    while ($DataRincian = mysql_fetch_array($QryRincian)) {
                        $HargaRincian = $DataRincian['harga'];
                        $QtyRincian = $DataRincian['qty'];
                        $Jumlah=$HargaRincian*$QtyRincian;
                        $JumlahTotal=$Jumlah+$JumlahTotal;
                    }
            ?>
            <tr>
                <td><?php echo "$no";?></td>
                <td><?php echo "$kode_faktur";?></td>
                <td><?php echo "$tanggal";?></td>
                <td><?php echo "$NamaPembeli";?></td>
                <td align="right"><?php echo "Rp " . number_format($JumlahTotal,0,',','.');?></td>
                <td>
                    <?php 
                        if($status=="Masuk"){
                            echo "<b class='text-danger'>$status</b>";
                        }
                        if($status=="Ditolak"){
                            echo "<b class='text-warning'>$status</b>";
                        }
                        if($status=="Diterima"){
                            echo "<b class='text-primary'>$status</b>";
                        }
                        if($status=="Dikirim"){
                            echo "<b class='text-info'>$status</b>";
                        }
                        if($status=="Retur"){
                            echo "<b class='text-danger'>$status</b>";
                        }
                        if($status=="Selesai"){
                            echo "<b class='text-primary'>$status</b>";
                        }
                    ?>
                </td>
            </tr>
            <?php $no++;} ?>
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
 