<?php 
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=hadiah.xls");
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
                    <td align="center"><strong>Barang</strong></td>
                    <td align="center"><strong>Kode</strong></td>
                    <td align="center"><strong>nama</strong></td>
                    <td align="center"><strong>Point</strong></td>
                </tr>
            </tr>
            <?php
                $query = mysqli_query($conn, "SELECT*FROM hadiah");
                while ($data = mysqli_fetch_array($query)) {
                $id_hadiah = $data['id_hadiah'];
                $id_barang = $data['id_barang'];
                $kode = $data['kode'];
                $nama = $data['nama'];
                $point = $data['point'];
            ?>
            <tr>
                <td width="3%" align="center"><?php echo $id_hadiah;?></td>
                <td align="left"><?php echo $id_barang;?></td>
                <td align="left"><?php echo $kode;?></td>
                <td align="left"><?php echo $nama;?></td>
                <td align="center"><?php echo $point;?></td>
            </tr>
            <?php }?>
        </table>
    </body>
</html>