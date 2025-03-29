<?php
    ini_set("display_errors","off");
    include "../../_Config/Connection.php";
    if(!empty($_POST['keyword'])){
        $keyword=$_POST['keyword'];
    }else{
        $keyword="";
    }
?>
<table class="table table-sm table-hover table-bordered scroll-container">
    <thead>
        <tr>
            <th>Ck</th>
            <th>Kode</th>
            <th>Barang</th>
        </tr>
    </thead>
    <tbody>
        <?php
            //KONDISI PENGATURAN MASING FILTER
            $query = mysqli_query($conn, "SELECT*FROM obat WHERE nama like '%$keyword%' OR kode like '%$keyword%'");
            while ($data = mysqli_fetch_array($query)) {
                $id_obat = $data['id_obat'];
                $nama= $data['nama'];
                $kode = $data['kode'];
                $satuan = $data['satuan'];
                $stok= $data['stok'];
                $harga_1= $data['harga_1'];
                $harga_2= $data['harga_2'];
                $harga_3= $data['harga_3'];
                $harga_4= $data['harga_4'];
                $Jumlahkalimat=20;
                $nama=substr($nama,0,20);
        ?>
        <tr>
            <td>
            <input type="radio" name="id_hadiah" id="id_hadiah" value="<?php echo "$id_obat";?>" checked>
            </td>
            <td><?php echo "$kode";?></td>
            <td><?php echo "$nama ..";?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>