<?php 
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=Data_Barang.xls");
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
                    <td align="center"><strong>Nama</strong></td>
                    <td align="center"><strong>Kategori</strong></td>
                    <td align="center"><strong>Satuan</strong></td>
                    <td align="center"><strong>Stok</strong></td>
                    <td align="center"><strong>Harga Beli</strong></td>
                    <td align="center"><strong>Harga Grosir</strong></td>
                    <td align="center"><strong>Harga Toko</strong></td>
                    <td align="center"><strong>Harga Eceran</strong></td>
                </tr>
            </tr>
            <?php
                $query = mysqli_query($conn, "SELECT*FROM obat");
                while ($data = mysqli_fetch_array($query)) {
                $id_obat = $data['id_obat'];
                $kode = $data['kode'];
                $nama = $data['nama'];
                $kategori = $data['kategori'];
                $satuan = $data['satuan'];
                $stok = $data['stok'];
                $harga_1 = $data['harga_1'];
                $harga_2 = $data['harga_2'];
                $harga_3 = $data['harga_3'];
                $harga_4 = $data['harga_4'];
            ?>
            <tr>
                <td width="3%" align="center"><?php echo $id_obat;?></td>
                <td align="left"><?php echo $kode;?></td>
                <td align="left"><?php echo $nama;?></td>
                <td align="left"><?php echo $kategori;?></td>
                <td align="center"><?php echo $satuan;?></td>
                <td align="left"><?php echo "$stok";?></td>
                <td align="center"><?php echo $harga_1;?></td>
                <td align="center"><?php echo $harga_2;?></td>
                <td align="center"><?php echo $harga_3;?></td>
                <td align="center"><?php echo $harga_4;?></td>
            </tr>
            <?php }?>
        </table>
    </body>
</html>