<?php 
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=transaksi.xls");
    include "../../_Config/Connection.php";
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
        <table cellspacing="0px">
            <tr>
                <tr>
                    <td align="center"><strong>Id</strong></td>
                    <td align="center"><strong>Kode</strong></td>
                    <td align="center"><strong>Tanggal</strong></td>
                    <td align="center"><strong>Jenis</strong></td>
                    <td align="center"><strong>Subtotal</strong></td>
                    <td align="center"><strong>ppn</strong></td>
                    <td align="center"><strong>Biaya</strong></td>
                    <td align="center"><strong>Diskon</strong></td>
                    <td align="center"><strong>Tagihan</strong></td>
                    <td align="center"><strong>Pembayaran</strong></td>
                    <td align="center"><strong>Selisih</strong></td>
                    <td align="center"><strong>Keterangan</strong></td>
                    <td align="center"><strong>Petugas</strong></td>
                </tr>
            </tr>
            <?php
                $query = mysqli_query($conn, "SELECT*FROM transaksi");
                while ($data = mysqli_fetch_array($query)) {
                $id_transaksi = $data['id_transaksi'];
                $kode_transaksi = $data['kode_transaksi'];
                $tanggal = $data['tanggal'];
                $jenis_transaksi = $data['jenis_transaksi'];
                $subtotal = $data['subtotal'];
                $ppn = $data['ppn'];
                $biaya = $data['biaya'];
                $diskon = $data['diskon'];
                $total_tagihan = $data['total_tagihan'];
                $pembayaran = $data['pembayaran'];
                $selisih = $data['selisih'];
                $keterangan = $data['keterangan'];
                $petugas = $data['petugas'];
            ?>
            <tr>
                <td width="3%" align="center"><?php echo $id_transaksi;?></td>
                <td align="left"><?php echo $kode_transaksi;?></td>
                <td align="left"><?php echo $tanggal;?></td>
                <td align="left"><?php echo $jenis_transaksi;?></td>
                <td align="center"><?php echo $subtotal;?></td>
                <td align="left"><?php echo "$ppn";?></td>
                <td align="center"><?php echo $biaya;?></td>
                <td align="center"><?php echo $diskon;?></td>
                <td align="center"><?php echo $total_tagihan;?></td>
                <td align="center"><?php echo $pembayaran;?></td>
                <td align="center"><?php echo $selisih;?></td>
                <td align="center"><?php echo $keterangan;?></td>
                <td align="center"><?php echo $petugas;?></td>
            </tr>
            <?php }?>
        </table>
    </body>
</html>