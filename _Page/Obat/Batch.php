<?php
    //koneksi dan error
    ini_set("display_errors","off");
    include "../../_Config/Connection.php";
    if(!empty($_POST['id_obat'])){
        $id_obat=$_POST['id_obat'];
    }else{
        $id_obat="";
    }
    //Buka data obat
    $QryObat = mysqli_query($conn, "SELECT * FROM obat WHERE id_obat='$id_obat'")or die(mysqli_error($conn));
    $DataObat = mysqli_fetch_array($QryObat);
    $nama= $DataObat['nama'];
    $kode = $DataObat['kode'];
    $kategori = $DataObat['kategori'];
    $satuan = $DataObat['satuan'];
    $stok= $DataObat['stok'];
    $harga_1= $DataObat['harga_1'];
    $harga_2= $DataObat['harga_2'];
    $harga_3= $DataObat['harga_3'];
    $harga_4= $DataObat['harga_4'];
    $jml_data = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM batch WHERE id_obat='$id_obat'"));
?>
<script>
    $(document).ready(function(){
        $('#NoBatch').focus();
        $('#ShowBatch').click(function(){
            var ButtonBatch=$('#ShowBatch').html();
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/Obat/DetailObat.php',
                data    : { id_obat: <?php echo $id_obat;?> },
                success : function(data){
                    $('#DetailObat').html(data);
                }
            });
        });
        $('#ProsesTambahBatch').submit(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            var ProsesTambahBatch = $('#ProsesTambahBatch').serialize();
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/Obat/ProsesTambahBatch.php',
                data 	:  ProsesTambahBatch,
                success : function(data){
                    $('#NotifikasiTambahBatch').html(data);
                    var Notifikasi=$('#NotifikasiTambahBatchBerhasil').html();
                    if(Notifikasi=="Berhasil"){
                        $.ajax({
                            type 	: 'POST',
                            url 	: '_Page/Obat/Batch.php',
                            data    : { id_obat: <?php echo $id_obat;?> },
                            success : function(data){
                                $('#DetailObat').html(data);
                            }
                        });
                    }
                }
            });
        });
    });
    <?php 
        $a=1;
        $b=$jml_data;
        for ( $i =$a; $i<=$b; $i++ ){
    ?>
        $('#DeleteBatch<?php echo "$i";?>').click(function() {
            var id_batch = $('#DeleteBatch<?php echo $i;?>').val();
            $.ajax({
                url     : "_Page/Obat/DeleteBatch.php",
                method  : "POST",
                data    : { id_batch: id_batch, },
                success: function (data) {
                    $.ajax({
                        type 	: 'POST',
                        url 	: '_Page/Obat/Batch.php',
                        data    : { id_obat: <?php echo $id_obat;?> },
                        success : function(data){
                            $('#DetailObat').html(data);
                        }
                    });
                }
            })
        });
    <?php } ?>
</script>
<div class="modal-body bg-primary">
    <form action="javascript:void(0);" id="ProsesTambahBatch">
        <input type="hidden" name="id_obat" value="<?php echo $id_obat;?>">
        <div class="row">
            <div class="col-md-12">
                <small id="NotifikasiTambahBatch">Kode Batch & Expired</small>
                <div class="input-group">
                    <input type="text" name="no_batch" id="NoBatch" class="form-control border-warning" placeholder="kode batch" value="">
                    <input type="date" name="exp" class="form-control border-warning" placeholder="Exp" value="">
                    <div class="input-group-append border-primary">
                        <button type="submit" class="btn btn-danger">
                            Add
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="modal-body bg-white">
    <div class="row">
        <div class="col-md-12">
        <div class="table-responsive" style="height: 350px; overflow-y: scroll;">
            <table class="table table-bordered table-hover">
                <tbody>
                    <tr class="bg-dark">
                        <td colspan="4" align="center" class="text-white">
                            <b>Data Batch for <?php echo $nama;?></b>
                        </td>
                    </tr>
                    <tr>
                        <td align="center"><b>NO</b></td>
                        <td align="center"><b>Batch</b></td>
                        <td align="center"><b>Exp</b></td>
                        <td align="center"><b>OPTION</b></td>
                    </tr>

                    <?php
                        $no = 1;
                        //KONDISI PENGATURAN MASING FILTER
                        $QryBatch = mysqli_query($conn, "SELECT*FROM batch WHERE id_obat='$id_obat' ORDER BY id_batch DESC");
                        while ($DataBatch = mysqli_fetch_array($QryBatch)) {
                            $id_batch = $DataBatch['id_batch'];
                            $no_batch = $DataBatch['no_batch'];
                            $exp = $DataBatch['exp'];
                            echo '<tr>';
                            echo '  <td align="center">'.$no.'</td>';
                            echo '  <td align="center">'.$no_batch.'</td>';
                            echo '  <td align="center">'.$exp.'</td>';
                            echo '  <td align="center">';
                            echo '      <div class="btn-group">';
                            echo '          <button class="btn btn-sm btn-danger" id="DeleteBatch'.$no.'" value="'.$id_batch.'">';
                            echo '              <i class="menu-icon mdi mdi-delete" aria-hidden="true"></i>';
                            echo '          </button>';
                            echo '      </div>';
                            echo '  </td>';
                            echo '</tr>';
                        $no++;}
                    ?>
                </tbody>
            </table>
        </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <div class="row">
        <div class="form-group col-md-12 text-center">
            <button class="btn btn-rounded btn-outline-info" id="ShowBatch">Hide Batch</button>
            <button class="btn btn-rounded btn-outline-danger" data-dismiss="modal">
                <i class="mdi mdi-close"></i> Tutup
            </button>
        </div>
    </div>
</div>