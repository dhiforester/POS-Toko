<?php
    //koneksi dan error
    include "../../_Config/Connection.php";
    if(!empty($_GET['stok'])){
        $StokMin=$_GET['stok'];
    }else{
        $StokMin="0";
    }
    //Tangkap Kategori
    if(!empty($_GET['kategori'])){
        $kategori=$_GET['kategori'];
    }else{
        $kategori="";
    }
    //Batas Data
    if(!empty($_GET['batas'])){
        $batas=$_GET['batas'];
    }else{
        $batas="10";
    }
?>
<html>
    <head>
        <title>Stok Habis/Sedikit</title>
        <style type="text/css">
           body{
                font-size: 12px;
                font-family: arial;
            }
            table tr td{
                border: 1px groove #999;
                padding: 5px;
                font-size: 12px;
                font-family: arial;
                color: black;
            }
        </style>
    </head>
    <body>
        <table width="90%" cellspacing="0">
            <tr>
                <td align="center"><b>No</b></td>
                <td align="center"><b>Kode</b></td>
                <td align="center"><b>Nama/Merek</b></td>
                <td align="center"><b>Kategori</b></td>
                <td align="center"><b>Stok</b></td>
                <td align="center"><b>Harga Eceran</b></td>
                <td align="center"><b>Harga Beli</b></td>
            </tr>
            <?php
                $no = 1;
                //KONDISI PENGATURAN MASING FILTER
                if(!empty($kategori)){
                    $query = mysqli_query($conn, "SELECT*FROM obat WHERE stok<'$StokMin' AND kategori='$kategori' ORDER BY nama ASC LIMIT $batas");
                }else{
                    $query = mysqli_query($conn, "SELECT*FROM obat WHERE stok<'$StokMin' ORDER BY nama ASC LIMIT $batas");
                }
                
                while ($data = mysqli_fetch_array($query)) {
                    $id_obat = $data['id_obat'];
                    $nama= $data['nama'];
                    $kode = $data['kode'];
                    $satuan = $data['satuan'];
                    $kategori= $data['kategori'];
                    $stok= $data['stok'];
                    if(!empty($data['harga_4'])){
                        $harga_4= $data['harga_4'];
                    }else{
                        $harga_4="0";
                    }
                    if(!empty($data['harga_1'])){
                        $harga_1= $data['harga_1'];
                    }else{
                        $harga_1="0";
                    }
            ?>
            <tr>
                <td><?php echo "$no";?></td>
                <td><?php echo "$kode";?></td>
                <td><?php echo "$nama";?></td>
                <td><?php echo "$kategori";?></td>
                <td><?php echo "$stok $satuan";?></td>
                <td><?php echo "Rp " . number_format($harga_4,0,',','.');?></td>
                <td><?php echo "Rp " . number_format($harga_1,0,',','.');?></td>
            </tr>
            <?php $no++;} ?>
        </table>
    </body>
</html>