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
            <th>Member</th>
            <th>Point</th>
        </tr>
    </thead>
    <tbody>
        <?php
            //KONDISI PENGATURAN MASING FILTER
            $query = mysqli_query($conn, "SELECT*FROM member WHERE nama like '%$keyword%' OR nik like '%$keyword%'");
            while ($data = mysqli_fetch_array($query)) {
                $id_member = $data['id_member'];
                $nama= $data['nama'];
                $nik = $data['nik'];
                $point = $data['point'];
        ?>
        <tr>
            <td>
                <input type="radio" name="id_member" id="id_member" value="<?php echo "$id_member";?>" checked> 
                <?php echo "$nik - $nama";?>
            </td>
            <td><?php echo "$point";?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>