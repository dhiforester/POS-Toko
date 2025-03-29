<?php 
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=klaim_hadiah.xls");
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
                    <td align="center"><strong>Id Member</strong></td>
                    <td align="center"><strong>Id hadiah</strong></td>
                    <td align="center"><strong>Nama Hadiah</strong></td>
                    <td align="center"><strong>Nama Member</strong></td>
                    <td align="center"><strong>Tanggal</strong></td>
                    <td align="center"><strong>QTY</strong></td>
                    <td align="center"><strong>Point</strong></td>
                </tr>
            </tr>
            <?php
                $query = mysqli_query($conn, "SELECT*FROM klaim");
                while ($data = mysqli_fetch_array($query)) {
                $id_klaim = $data['id_klaim'];
                $id_member = $data['id_member'];
                $id_hadiah = $data['id_hadiah'];
                $nama_hadiah = $data['nama_hadiah'];
                $nama_member = $data['nama_member'];
                $tanggal = $data['tanggal'];
                $qty = $data['qty'];
                $point = $data['point'];
            ?>
            <tr>
                <td width="3%" align="center"><?php echo $id_klaim;?></td>
                <td align="left"><?php echo $id_member;?></td>
                <td align="left"><?php echo $id_hadiah;?></td>
                <td align="left"><?php echo $nama_hadiah;?></td>
                <td align="left"><?php echo $nama_member;?></td>
                <td align="left"><?php echo $tanggal;?></td>
                <td align="left"><?php echo $qty;?></td>
                <td align="center"><?php echo $point;?></td>
            </tr>
            <?php }?>
        </table>
    </body>
</html>