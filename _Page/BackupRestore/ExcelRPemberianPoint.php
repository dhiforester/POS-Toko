<?php 
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=log_pemberian_point.xls");
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
                    <td align="center"><strong>Tanggal</strong></td>
                    <td align="center"><strong>Kode Transaksi</strong></td>
                    <td align="center"><strong>Member</strong></td>
                    <td align="center"><strong>Point</strong></td>
                </tr>
            </tr>
            <?php
                $query = mysqli_query($conn, "SELECT*FROM pemberian_point");
                while ($data = mysqli_fetch_array($query)) {
                $id_pemberian_point = $data['id_pemberian_point'];
                $tanggal = $data['tanggal'];
                $kode_transaksi = $data['kode_transaksi'];
                $id_member = $data['id_member'];
                $point = $data['point'];
            ?>
            <tr>
                <td width="3%" align="center"><?php echo $id_pemberian_point;?></td>
                <td align="left"><?php echo $tanggal;?></td>
                <td align="left"><?php echo $kode_transaksi;?></td>
                <td align="left"><?php echo $id_member;?></td>
                <td align="center"><?php echo $point;?></td>
            </tr>
            <?php }?>
        </table>
    </body>
</html>