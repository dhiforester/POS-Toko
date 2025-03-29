<?php
    //koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    //tangkap parameter
    $Keyword=$_POST['Keyword'];
    $jml_data = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM batch WHERE no_batch like '%$Keyword%'"));
    
?>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered scroll-container">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama/Merek</th>
                        <th>No.Batch</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if(empty($jml_data)){
                            echo "<tr><td colspan='3' align='center'>Data Tidak Ditemukan!!</td></tr>";
                        }else{
                            if(empty($Keyword)){
                                echo "<tr><td colspan='3' align='center'>Keyword Pencarian Kosong!!</td></tr>";
                            }else{
                            $no = 1;
                            //KONDISI PENGATURAN MASING FILTER
                            $query = mysqli_query($conn, "SELECT*FROM batch WHERE no_batch like '%$Keyword%'");
                            while ($data = mysqli_fetch_array($query)) {
                                $id_obat = $data['id_obat'];
                                $id_batch= $data['id_batch'];
                                $no_batch = $data['no_batch'];
                                //Buka data obat
                                $QryObat = mysqli_query($conn, "SELECT * FROM obat WHERE id_obat='$id_obat'")or die(mysqli_error($conn));
                                $DataObat = mysqli_fetch_array($QryObat);
                                $nama = $DataObat['nama'];
                    ?>
                    <tr>
                        <td><?php echo "$no";?></td>
                        <td><?php echo "$nama";?></td>
                        <td><?php echo "$no_batch";?></td>
                    </tr>
                    <?php 
                            $no++;}
                        } }
                        echo '<tr>';
                        echo "  <td colspan='3' align='center'><b>Keyword :</b> $Keyword</td>";
                        echo '</tr>';
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>