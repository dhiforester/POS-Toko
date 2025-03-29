<?php
    ini_set("display_errors","off");
    include "../../_Config/Connection.php";
    if(!empty($_POST['keyword'])){
        $keyword=$_POST['keyword'];
    }else{
        $keyword="";
    }
?>
<table class="table table-bordered scroll-container">
    <thead>
        <tr>
            <th>Ck</th>
            <th>Point</th>
        </tr>
    </thead>
    <tbody>
        <?php
            //KONDISI PENGATURAN MASING FILTER
            $query = mysqli_query($conn, "SELECT*FROM hadiah WHERE nama like '%$keyword%' OR kode like '%$keyword%'");
            while ($data = mysqli_fetch_array($query)) {
                $id_hadiah = $data['id_hadiah'];
                $nama= $data['nama'];
                $kode = $data['kode'];
                $point = $data['point'];
        ?>
        <tr>
            <td>
                <input type="radio" name="id_hadiah" id="id_hadiah" value="<?php echo "$id_hadiah";?>" checked> 
                <?php echo "$kode - $nama";?>
            </td>
            <td><?php echo "$point";?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>