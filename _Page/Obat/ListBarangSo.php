<?php
    //koneksi dan error
    ini_set("display_errors","off");
    include "../../_Config/Connection.php";
    if(!empty($_POST['keyword'])){
        $keyword=$_POST['keyword'];
    }else{
        $keyword="";
    }
    if(!empty($_POST['posisi'])){
        $posisi=$_POST['posisi'];
    }else{
        $posisi="1";
    }
    if(!empty($_POST['batas'])){
        $batas=$_POST['batas'];
    }else{
        $batas="20";
    }
?>
<script>
    $(document).ready(function(){
        $('#FormPencarian').focus();
        $('#ProsesCariBarang').submit(function() {
            var ProsesCariBarang = $('#ProsesCariBarang').serialize();
            $.ajax({
                url     : "_Page/Obat/ListBarangSo.php",
                method  : "POST",
                data    : ProsesCariBarang,
                success: function (data) {
                    $('#ListBarangSo').html(data);
                }
            })
        });
    });
    <?php 
        $a=1;
        $b=20;
        for ( $i =$a; $i<=$b; $i++ ){
    ?>
        $('#baris<?php echo "$i";?>').click(function() {
            var id_obat = $('#PilihSo<?php echo $i;?>').html();
            $.ajax({
                url     : "_Page/Obat/FormStokOpename.php",
                method  : "POST",
                data    : { id_obat: id_obat },
                success: function (data) {
                    $('#FormStokOpename').html(data);
                    $('#ModalPilihBarangSO').modal('hide');
                    $('#stok_nyata').focus();
                }
            })
        });
        $('#baris<?php echo "$i";?>').keyup(function(event) {
                if(event.keyCode==13){
                    $('#baris<?php echo "$i";?>').click();
                }
            });
        $("#baris<?php echo $i;?>").focus(function () {
            $("#baris<?php echo "$i";?>").addClass("table-active");
        });
        $("#baris<?php echo $i;?>").focusout(function () {
            $("#baris<?php echo "$i";?>").removeClass("table-active");
        });
    <?php } ?>
</script>
<div class="modal-header bg-dark">
    <form action="javascript:void(0);" id="ProsesCariBarang">
        <input type="hidden" name="id_obat" value="<?php echo $id_obat;?>">
        <div class="row">
            <div class="col-md-12">
                <small id="NotifikasiTambahBatch">Kode/Nama</small>
                <div class="input-group">
                    <input type="text" id="FormPencarian" name="keyword" class="form-control border-warning" placeholder="Cari.." value="<?php echo $keyword;?>">
                    <div class="input-group-append border-primary">
                        <button type="submit" class="btn btn-danger">
                            Cari
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="modal-body bg-dark">
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive bg-white" style="height: 350px; overflow-y: scroll;">
                <table class="table table-bordered table-hover table-sm scroll-container">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Kode</th>
                            <th>Nama/Merek</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $no = 1;
                            //KONDISI PENGATURAN MASING FILTER
                            if(empty($keyword)){
                                $query = mysqli_query($conn, "SELECT*FROM obat LIMIT $posisi, $batas");
                            }else{
                                $query = mysqli_query($conn, "SELECT*FROM obat WHERE nama like '%$keyword%' OR kode like '%$keyword%'");
                            }
                            while ($data = mysqli_fetch_array($query)) {
                                $id_obat = $data['id_obat'];
                                $nama= $data['nama'];
                                $kode = $data['kode'];
                                $kategori = $data['kategori'];
                                $satuan = $data['satuan'];
                                $stok= $data['stok'];
                        ?>
                        <tr id="baris<?php echo $no;?>" tabindex="0" onmousemove="this.style.cursor='pointer'">
                            <td>
                                <b id="PilihSo<?php echo $no;?>"><?php echo "$id_obat";?></b>
                            </td>
                            <td id="kode<?php echo $no;?>"><?php echo "$kode";?></td>
                            <td id="nama<?php echo $no;?>"><?php echo "$nama";?></td>
                        </tr>
                        <?php $no++;} ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer bg-dark">
    <div class="row">
        <div class="form-group col-md-12 text-center">
            <button class="btn btn-rounded btn-warning" data-dismiss="modal">
                <i class="mdi mdi-close"></i> Tutup
            </button>
        </div>
    </div>
</div>