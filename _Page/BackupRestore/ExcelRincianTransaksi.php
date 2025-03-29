<?php 
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=rincian_transaksi.xls");
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
                    <td align="center"><strong>Id Barang</strong></td>
                    <td align="center"><strong>Nama</strong></td>
                    <td align="center"><strong>QTY</strong></td>
                    <td align="center"><strong>Harga</strong></td>
                    <td align="center"><strong>Jumlah</strong></td>
                </tr>
            </tr>
            <?php
                $query = mysqli_query($conn, "SELECT*FROM rincian_transaksi");
                while ($data = mysqli_fetch_array($query)) {
                $id_rincian = $data['id_rincian'];
                $kode_transaksi = $data['kode_transaksi'];
                $id_obat = $data['id_obat'];
                $nama = $data['nama'];
                $qty = $data['qty'];
                $harga = $data['harga'];
                $jumlah = $data['jumlah'];
            ?>
            <tr>
                <td width="3%" align="center"><?php echo $id_rincian;?></td>
                <td align="left"><?php echo $kode_transaksi;?></td>
                <td align="left"><?php echo $id_obat;?></td>
                <td align="left"><?php echo $nama;?></td>
                <td align="center"><?php echo $qty;?></td>
                <td align="left"><?php echo "$harga";?></td>
                <td align="center"><?php echo $jumlah;?></td>
            </tr>
            <?php }?>
        </table>
    </body>
</html>