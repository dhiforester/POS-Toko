<?php 
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=Data_Member.xls");
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
                    <td align="center"><strong>NIK</strong></td>
                    <td align="center"><strong>Nama</strong></td>
                    <td align="center"><strong>Alamat</strong></td>
                    <td align="center"><strong>Kontak</strong></td>
                    <td align="center"><strong>Kategori</strong></td>
                    <td align="center"><strong>Point</strong></td>
                </tr>
            </tr>
            <?php
                $query = mysqli_query($conn, "SELECT*FROM member");
                while ($data = mysqli_fetch_array($query)) {
                $id_member = $data['id_member'];
                $nama = $data['nama'];
                $nik = $data['nik'];
                $alamat = $data['alamat'];
                $kontak = $data['kontak'];
                $kategori = $data['kategori'];
                $point = $data['point'];
            ?>
            <tr>
                <td width="3%" align="center"><?php echo $id_member;?></td>
                <td align="left"><?php echo $nik;?></td>
                <td align="left"><?php echo $nama;?></td>
                <td align="left"><?php echo $alamat;?></td>
                <td align="center"><?php echo $kontak;?></td>
                <td align="left"><?php echo "$kategori";?></td>
                <td align="center"><?php echo $point;?></td>
            </tr>
            <?php }?>
        </table>
    </body>
</html>