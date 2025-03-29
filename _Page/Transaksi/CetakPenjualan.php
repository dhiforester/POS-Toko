<?php
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
            body{
                font-size: <?php echo "$ukuran_font";?>px;
                font-family: <?php echo "$jenis_font";?>;
                color: <?php echo "$warna_font";?>;
            }
            table tr td{
                border: 1px groove #999;
                padding: 5px;
                font-size: <?php echo "$ukuran_font";?>px;
                font-family: <?php echo "$jenis_font";?>;
                color: <?php echo "$warna_font";?>;
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
            $query = mysqli_query($conn, "SELECT*FROM transaksi WHERE jenis_transaksi='penjualan' AND tanggal>='$Awal' AND tanggal<='$Akhir' ORDER BY id_transaksi DESC");
            while ($data = mysqli_fetch_array($query)) {
                $id_transaksi = $data['id_transaksi'];
                $kode_transaksi = $data['kode_transaksi'];
                $tanggal = $data['tanggal'];
                $jenis_transaksi= $data['jenis_transaksi'];
                $total_tagihan= $data['total_tagihan'];
                $pembayaran= $data['pembayaran'];
                $selisih= $data['selisih'];
                $keterangan= $data['keterangan'];
                if($jenis_transaksi=="penjualan"){
                    $jenis_transaksi="PNJ";
                }else{
                    $jenis_transaksi="PMB";
                }
        ?>
        <tr>
            <td align="center"><?php echo "$no";?></td>
            <td><?php echo "$tanggal";?></td>
            <td><?php echo "$jenis_transaksi";?></td>
            <td align="right"><?php echo "Rp " . number_format($total_tagihan,0,',','.');?></td>
            <td><?php echo "$keterangan";?></td>
        </tr>
        <?php $no++;} ?>
        <?php
            $QryJumlahTotal = mysqli_query($conn, "SELECT SUM(total_tagihan) as total_tagihan FROM transaksi WHERE jenis_transaksi='penjualan' AND tanggal>='$Awal' AND tanggal<='$Akhir'");
            $DataJumlahTotal = mysqli_fetch_array($QryJumlahTotal);
            $JumlahTotal=$DataJumlahTotal['total_tagihan'];
        ?>
        <tr>
            <td colspan="3" align="right">JUMLAH TOTAL</td>
            <td align="right"><?php echo "Rp " . number_format($JumlahTotal,0,',','.');?></td>
            <td></td>
        </tr>
    </table>
    </body>
</html>