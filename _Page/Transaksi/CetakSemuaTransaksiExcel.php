<?php 
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=transaksi.xls");
    //koneksi dan error
    include "../../_Config/Connection.php";
    if(!empty($_GET['Awal'])){
        $Awal=$_GET['Awal'];
    }else{
        $Awal="";
    }
    if(!empty($_GET['Akhir'])){
        $Akhir=$_GET['Akhir'];
    }else{
        $Akhir="";
    }
     //Buka Setting percetakan
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
?> 
<html>
    <head>
            <style type="text/css">
                table tr td {
                    border: 0.5px solid #666;
                    font-size:11px;
                    color:#333;
                    border-spacing: 0px;
                    padding: 4px;
                }
            </style>
    </head>
    <body>
        <table width="90%" cellspacing="0">
            <tr>
                <td align="center">No</td>
                <td align="center">Tanggal</td>
                <td align="center">Transaksi</td>
                <td align="center">Tagihan</td>
                <td align="center"> Keterangan</td>
            </tr>
            <?php
                $no = 1;
                //KONDISI PENGATURAN MASING FILTER
                $query = mysqli_query($conn, "SELECT*FROM transaksi WHERE tanggal>='$Awal' AND tanggal<='$Akhir' ORDER BY id_transaksi DESC");
                while ($data = mysqli_fetch_array($query)) {
                    $id_transaksi = $data['id_transaksi'];
                    $kode_transaksi = $data['kode_transaksi'];
                    $tanggal = $data['tanggal'];
                    $jenis_transaksi= $data['jenis_transaksi'];
                    $total_tagihan= $data['total_tagihan'];
                    $pembayaran= $data['pembayaran'];
                    $selisih= $data['selisih'];
                    $keterangan= $data['keterangan'];
            ?>
            <tr>
                <td align="center"><?php echo "$no";?></td>
                <td><?php echo "$tanggal";?></td>
                <td><?php echo "$jenis_transaksi";?></td>
                <td align="right"><?php echo "$total_tagihan";?></td>
                <td><?php echo "$keterangan";?></td>
            </tr>
            <?php $no++;} ?>
            <?php
                $QryJumlahTotal = mysqli_query($conn, "SELECT SUM(total_tagihan) as total_tagihan FROM transaksi WHERE tanggal>='$Awal' AND tanggal<='$Akhir'");
                $DataJumlahTotal = mysqli_fetch_array($QryJumlahTotal);
                $JumlahTotal=$DataJumlahTotal['total_tagihan'];
            ?>
            <tr>
                <td colspan="3" align="right">JUMLAH TOTAL</td>
                <td align="right"><?php echo "$JumlahTotal";?></td>
                <td></td>
            </tr>
        </table>
    </body>
</html>