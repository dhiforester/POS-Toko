<?php 
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=Data_Batch.xls");
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
                    <td align="center"><strong>Id_obat</strong></td>
                    <td align="center"><strong>No_Batch</strong></td>
                </tr>
            </tr>
            <?php
                $query = mysqli_query($conn, "SELECT*FROM batch");
                while ($data = mysqli_fetch_array($query)) {
                $id_batch = $data['id_batch'];
                $id_obat = $data['id_obat'];
                $no_batch = $data['no_batch'];
            ?>
            <tr>
                <td width="3%" align="center"><?php echo $id_batch;?></td>
                <td align="left"><?php echo $id_obat;?></td>
                <td align="left"><?php echo $no_batch;?></td>
            </tr>
            <?php }?>
        </table>
    </body>
</html>