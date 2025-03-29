<script>
     $(document).ready(function(){
        $('#satuanBaru').focus()
    });
</script>
<?php
    include "../../_Config/Connection.php";
    if(empty($_POST['id_multi'])){
        $id_multi="";
        if(empty($_POST['id_obat'])){
            if(!empty($_POST['kode'])){
                $KodeBarang=$_POST['kode'];
                $NamaBarang=$_POST['nama'];
                //Buka data obat
                $QryObat = mysqli_query($conn, "SELECT * FROM obat WHERE kode='$KodeBarang'")or die(mysqli_error($conn));
                $DataObat = mysqli_fetch_array($QryObat);
                $id_obat= $DataObat['id_obat'];
                $nama= $DataObat['nama'];
                $kode = $DataObat['kode'];
                $kategori = $DataObat['kategori'];
                $satuan = $DataObat['satuan'];
                $konversi = $DataObat['konversi'];
                $stok= $DataObat['stok'];
                $harga_1= $DataObat['harga_1'];
                $harga_2= $DataObat['harga_2'];
                $harga_3= $DataObat['harga_3'];
                $harga_4= $DataObat['harga_4'];
            }else{
                $KodeBarang="";
                $NamaBarang="";
                $NamaBarang="";
                $id_obat="";
                $nama="";
                $kode ="";
                $kategori ="";
                $satuan ="";
                $konversi = "";
                $stok="";
                $harga_1="";
                $harga_2="";
                $harga_3="";
                $harga_4="";
            }
        }else{
            $id_obat=$_POST['id_obat'];
            //Buka data obat
            $QryObat = mysqli_query($conn, "SELECT * FROM obat WHERE id_obat='$id_obat'")or die(mysqli_error($conn));
            $DataObat = mysqli_fetch_array($QryObat);
            $id_obat= $DataObat['id_obat'];
            $nama= $DataObat['nama'];
            $kode = $DataObat['kode'];
            $kategori = $DataObat['kategori'];
            $satuan = $DataObat['satuan'];
            $konversi = $DataObat['konversi'];
            $stok= $DataObat['stok'];
            $harga_1= $DataObat['harga_1'];
            $harga_2= $DataObat['harga_2'];
            $harga_3= $DataObat['harga_3'];
            $harga_4= $DataObat['harga_4'];
        }
        if(!empty($konversi)){
            $harga_1_baru=$harga_1/$konversi;
            $harga_1_baru=round($harga_1_baru,2);
            $harga_2_baru=$harga_2/$konversi;
            $harga_2_baru=round($harga_2_baru,2);
            $harga_3_baru=$harga_3/$konversi;
            $harga_3_baru=round($harga_3_baru,2);
            $harga_4_baru=$harga_4/$konversi;
            $harga_4_baru=round($harga_4_baru,2);
        }else{
            $harga_1_baru="0";
            $harga_2_baru="0";
            $harga_3_baru="0";
            $harga_4_baru="0";
        }
    }else{
        $id_multi=$_POST['id_multi'];
        //Buka multi harga
        $QryMulti = mysqli_query($conn, "SELECT * FROM muti_harga WHERE id_multi='$id_multi'")or die(mysqli_error($conn));
        $DataMulti = mysqli_fetch_array($QryMulti);
        $id_obat= $DataMulti['id_barang'];
        $harga_1_baru=$DataMulti['harga1'];
        $harga_2_baru=$DataMulti['harga2'];
        $harga_3_baru=$DataMulti['harga3'];
        $harga_4_baru=$DataMulti['harga4'];
        $SatuanMulti=$DataMulti['satuan'];
        $konversiMulti=$DataMulti['konversi'];
        $stokMulti=$DataMulti['stok'];
        //Buka data Barang
        $QryObat = mysqli_query($conn, "SELECT * FROM obat WHERE id_obat='$id_obat'")or die(mysqli_error($conn));
        $DataObat = mysqli_fetch_array($QryObat);
        $id_obat= $DataObat['id_obat'];
        $nama= $DataObat['nama'];
        $kode = $DataObat['kode'];
        $kategori = $DataObat['kategori'];
        $satuan = $DataObat['satuan'];
        $konversi = $DataObat['konversi'];
        $stok= $DataObat['stok'];
        $harga_1= $DataObat['harga_1'];
        $harga_2= $DataObat['harga_2'];
        $harga_3= $DataObat['harga_3'];
        $harga_4= $DataObat['harga_4'];
    }
?>
<script type="text/javascript">
    $(document).on("keyup", function(event) {
        if (event.keyCode === 27) {
            document.getElementById("TutupMultiHarga").click();
        }
    });
</script>
<script>
    $('#satuanBaru').keyup(function(){  
        var query = $(this).val();  
        if(query != '')  
        {  
            $.ajax({  
                    url:"_Page/obat/cek_satuan.php",  
                    method:"POST",  
                    data:{query:query},  
                    success:function(data)  
                    {  
                        $('#SatuanList').fadeIn();  
                        $('#SatuanList').html(data);  
                        $(".list-group-item").css("cursor","pointer");
                    }  
            });  
        }  
    });
    $(document).on('click', '#ListSatuan', function(){  
        $('#satuanBaru').val($(this).text());  
        $('#SatuanList').fadeOut();  
    }); 
    $(document).on('keyup', '#ListSatuan', function(event){  
        if(event.keyCode==13){
            $('#satuanBaru').val($(this).text());  
            $('#SatuanList').fadeOut();  
        }
    });
    //Element Fokus
    //satuanBaru
    $('#satuanBaru').focus(function(){
        $('#satuanBaru').removeClass("border-dark");
        $('#satuanBaru').addClass("border-primary");
    });
    $('#satuanBaru').focusout(function(){
        $('#satuanBaru').removeClass("border-primary");
        $('#satuanBaru').addClass("border-dark");
    });
    //isiBaru
    $('#isiBaru').focus(function(){
        $('#isiBaru').removeClass("border-dark");
        $('#isiBaru').addClass("border-primary");
        $('#SatuanList').fadeOut();
    });
    $('#isiBaru').focusout(function(){
        $('#isiBaru').removeClass("border-primary");
        $('#isiBaru').addClass("border-dark");
    });
    //harga1Baru
    $('#harga1Baru').focus(function(){
        $('#harga1Baru').removeClass("border-dark");
        $('#harga1Baru').addClass("border-primary");
        $('#SatuanList').fadeOut();
    });
    $('#harga1Baru').focusout(function(){
        $('#harga1Baru').removeClass("border-primary");
        $('#harga1Baru').addClass("border-dark");
    });
    //harga2Baru
    $('#harga2Baru').focus(function(){
        $('#harga2Baru').removeClass("border-dark");
        $('#harga2Baru').addClass("border-primary");
        $('#SatuanList').fadeOut();
    });
    $('#harga2Baru').focusout(function(){
        $('#harga2Baru').removeClass("border-primary");
        $('#harga2Baru').addClass("border-dark");
    });
    //harga3Baru
    $('#harga3Baru').focus(function(){
        $('#harga3Baru').removeClass("border-dark");
        $('#harga3Baru').addClass("border-primary");
        $('#SatuanList').fadeOut();
    });
    $('#harga3Baru').focusout(function(){
        $('#harga3Baru').removeClass("border-primary");
        $('#harga3Baru').addClass("border-dark");
    });
    //harga3Baru
    $('#harga4Baru').focus(function(){
        $('#harga4Baru').removeClass("border-dark");
        $('#harga4Baru').addClass("border-primary");
        $('#SatuanList').fadeOut();
    });
    $('#harga4Baru').focusout(function(){
        $('#harga4Baru').removeClass("border-primary");
        $('#harga4Baru').addClass("border-dark");
    });
    $('#isiBaru').keyup(function(){  
        var isiLama = $('#isiLama').val();
        var isiBaru = $('#isiBaru').val();
        var harga1Awal = $('#harga1Awal').val();
        var harga2Awal = $('#harga2Awal').val();
        var harga3Awal = $('#harga3Awal').val();
        var harga4Awal = $('#harga4Awal').val();
        var FaktorKonversi=isiBaru/isiLama;
        var harga1Baru=harga1Awal*FaktorKonversi;
        var harga2Baru=harga2Awal*FaktorKonversi;
        var harga3Baru=harga3Awal*FaktorKonversi;
        var harga4Baru=harga4Awal*FaktorKonversi;
        $('#harga1Baru').val(harga1Baru.toFixed(2));
        $('#harga2Baru').val(harga2Baru.toFixed(2));
        $('#harga3Baru').val(harga3Baru.toFixed(2));
        $('#harga4Baru').val(harga4Baru.toFixed(2));
    });
    $('#ProsesInputMultiHarga').submit(function(){
        var Loading='<div class="text-danger">Loading..</div>';
        var ProsesInputMultiHarga = $('#ProsesInputMultiHarga').serialize();
        $('#NotifikasiInputMultiHarga').html(Loading);
        $.ajax({
            type 	: 'POST',
            url 	: '_Page/Obat/ProsesInputMultiHarga.php',
            data 	:  ProsesInputMultiHarga,
            success : function(data){
                $('#NotifikasiInputMultiHarga').html(data);
                //menangkap keterangan notifikasi
                var Notifikasi=$('#NotifikasiInputMultiHargaBerhasil').html();
                if(Notifikasi=="Berhasil"){
                    var id_obat="<?php echo $id_obat;?>";
                    $.ajax({
                        url     : "_Page/Obat/FormMultiHarga.php",
                        method  : "POST",
                        data    : { id_obat: id_obat },
                        success: function (data) {
                            $('#FormMultiHarga').html(data);
                        }
                    })
                }
            }
        });
    });
    //ketika Modal Edit Multi Harga
    $('#ModalEditMultiHarga').on('show.bs.modal', function (e) {
        var DataDetail = $(e.relatedTarget).data('id');
        var mode = DataDetail.split(',');
        var id_obat = mode[0];
        var id_multi = mode[1];
        $.ajax({
            url     : "_Page/Obat/FormMultiHarga.php",
            method  : "POST",
            data    : { id_obat: id_obat, id_multi: id_multi },
            success: function (data) {
                $('#FormMultiHarga').html(data);
                $('#NilaiIdMultiHarga').load('_Page/Obat/FormEditMultiHarga.php');
            }
        })
    });
    //ketika Modal Delete Multi Harga
    $('#ModalDeleteMultiHarga').on('show.bs.modal', function (e) {
        var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
        $('#FormDeleteMultiHarga').html(Loading);
        var DataDetail = $(e.relatedTarget).data('id');
        var mode = DataDetail.split(',');
        var id_obat = mode[0];
        var id_multi = mode[1];
        $.ajax({
            url     : "_Page/Obat/FormDeleteMultiHarga.php",
            method  : "POST",
            data    : { id_obat: id_obat, id_multi: id_multi },
            success: function (data) {
                $('#FormDeleteMultiHarga').html(data);
                //Ketika disetujui delete
                $('#ProsesDeleteMultiHarga').submit(function(){
                    var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
                    $('#NotifikasiDeleteMultiHarga').html(Loading);
                    var ProsesDeleteMultiHarga = $('#ProsesDeleteMultiHarga').serialize();
                    $.ajax({
                        type 	: 'POST',
                        url 	: '_Page/Obat/ProsesDeleteMultiHarga.php',
                        data 	:  ProsesDeleteMultiHarga,
                        success : function(data){
                            $('#NotifikasiDeleteMultiHarga').html(data);
                            //menangkap keterangan notifikasi
                            var Notifikasi=$('#NotifikasiDeleteMultiHargaBerhasil').html();
                            if(Notifikasi=="Berhasil"){
                                $('#ModalDeleteMultiHarga').modal('hide');
                                $.ajax({
                                    url     : "_Page/Obat/FormMultiHarga.php",
                                    method  : "POST",
                                    data    : { id_obat: id_obat },
                                    success: function (data) {
                                        $('#FormMultiHarga').html(data);
                                    }
                                })
                            }
                        }
                    });
                });
            }
        })
    });
</script>
<div class="modal-header bg-primary">
    <div class="row">
        <div class="col col-md-12">
            <h3 class="text-white">
                <i class="mdi mdi-tag-multiple"></i>Multi Satuan & Harga
            </h3>
        </div>
    </div>
    <div class="row" >
        <div class="col col-md-12 text-white">
            <?php echo "<b>$nama</b>"; ?><br>
            <?php echo "<b>Stok :</b>$stok"; ?>
        </div>
    </div>
</div>
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-1">
            <label>Satuan</label>
            <input type="text" readonly class="form-control border-dark" id="satuanAwal" value="<?php echo "$satuan"; ?>">
        </div>
        <div class="form-group col-md-1">
            <label>Isi</label>
            <input type="text" readonly class="form-control border-dark" id="isiLama" value="<?php echo "$konversi";?>">
        </div>
        <div class="form-group col-md-2">
            <label>Harga Beli</label>
            <input type="text" readonly class="form-control border-dark" id="harga1Awal" value="<?php echo "$harga_1"; ?>">
        </div>
        <div class="form-group col-md-2">
            <label>Harga Grosir</label>
            <input type="text" readonly class="form-control border-dark" id="harga2Awal" value="<?php echo "$harga_2"; ?>">
        </div>
        <div class="form-group col-md-2">
            <label>Harga Toko</label>
            <input type="text" readonly class="form-control border-dark" id="harga3Awal" value="<?php echo "$harga_3"; ?>">
        </div>
        <div class="form-group col-md-2">
            <label>Harga Eceran</label>
            <input type="text" readonly class="form-control border-dark" id="harga4Awal" value="<?php echo "$harga_4"; ?>">
        </div>
        <div class="form-group col-md-2">
            <small class="text-primary">
                <b>Keterangan :</b>
                <div id="NotifikasiInputMultiHarga">Belum Ada Proses</div>
            </small>
        </div>
    </div>
    <form action="javascript:void(0);" id="ProsesInputMultiHarga">
        <input type="hidden" name="id_obat" id="id_obat" value="<?php echo "$id_obat";?>">
        <input type="hidden" name="id_multi" id="id_multi" value="<?php echo "$id_multi";?>">
        <div class="row">
            <div class="form-group col-md-1">
                <input type="text" require class="form-control border-dark" name="satuan" id="satuanBaru" value="<?php if(empty($id_multi)){echo "";}else{echo "$SatuanMulti";} ?>">
                <div id="SatuanList"></div>
            </div>
            <div class="form-group col-md-1">
                <input type="number" min="0" step="0.001" class="form-control border-dark" name="konversi" id="isiBaru" value="<?php if(empty($id_multi)){echo "1";}else{echo "$konversiMulti";} ?>">
            </div>
            <div class="form-group col-md-2">
                <input type="number" min="0" step="0.001" class="form-control border-dark" name="harga1" id="harga1Baru" value="<?php echo "$harga_1_baru"; ?>">
            </div>
            <div class="form-group col-md-2">
                <input type="number" min="0" step="0.001" class="form-control border-dark" name="harga2" id="harga2Baru" value="<?php echo "$harga_2_baru"; ?>">
            </div>
            <div class="form-group col-md-2">
                <input type="number" min="0" step="0.001" class="form-control border-dark" name="harga3" id="harga3Baru" value="<?php echo "$harga_3_baru"; ?>">
            </div>
            <div class="form-group col-md-2">
                <input type="number" min="0" step="0.001" class="form-control border-dark" name="harga4" id="harga4Baru" value="<?php echo "$harga_4_baru"; ?>">
            </div>
            <div class="form-group col-md-2">
                <button type="submit" class="btn btn-md btn-primary">
                    <?php
                        if(empty($id_multi)){
                            echo '<i class="mdi mdi-plus"></i> Add (Enter/F4)';
                        }else{
                            echo '<i class="mdi mdi-plus"></i> Update (Enter/F4)';
                        }
                    ?>
                </button>
            </div>
        </div>
    </form>
    <div class="row bg-white">
        <div class="col-md-12" style="height: 300px; overflow-y: scroll;">
            <div class="table-responsive" id="TabelMultiHarga">
                <table class="table table-bordered table-hover table-md scroll-container">
                    <thead class="thead-dark">
                        <tr>
                            <th>No</th>
                            <th>Satuan</th>
                            <th>Isi</th>
                            <th>Stok</th>
                            <th>H.Beli</th>
                            <th>H.Grosir</th>
                            <th>H.Toko</th>
                            <th>H.Eceran</th>
                            <th>Opt</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $no = 1;
                            //KONDISI PENGATURAN MASING FILTER
                            $query = mysqli_query($conn, "SELECT*FROM muti_harga WHERE id_barang='$id_obat'");
                            while ($data = mysqli_fetch_array($query)) {
                                $id_multi = $data['id_multi'];
                                $konversi = $data['konversi'];
                                $satuan = $data['satuan'];
                                $stok= $data['stok'];
                                $harga_1= $data['harga1'];
                                $harga_2= $data['harga2'];
                                $harga_3= $data['harga3'];
                                $harga_4= $data['harga4'];
                        ?>
                        <tr>
                            <td><?php echo "$no";?></td>
                            <td><?php echo "$satuan";?></td>
                            <td><?php echo "$konversi";?></td>
                            <td><?php echo "$stok";?></td>
                            <td><?php echo "Rp " . number_format($harga_1,0,',','.');?></td>
                            <td><?php echo "Rp " . number_format($harga_2,0,',','.');?></td>
                            <td><?php echo "Rp " . number_format($harga_3,0,',','.');?></td>
                            <td><?php echo "Rp " . number_format($harga_4,0,',','.');?></td>
                            <td>
                                <button class="btn btn-inverse-warning btn-rounded btn-fw" data-toggle="modal" data-target="#ModalEditMultiHarga" data-id="<?php echo "$id_obat,$id_multi";?>">
                                    <i class="menu-icon mdi mdi-pencil" aria-hidden="true"></i> Edit
                                </button>
                                <button class="btn btn-inverse-danger btn-rounded btn-fw" data-toggle="modal" data-target="#ModalDeleteMultiHarga" data-id="<?php echo "$id_obat,$id_multi";?>">
                                    <i class="menu-icon mdi mdi-delete" aria-hidden="true"></i> Hapus
                                </button>
                            </td>
                        </tr>
                        <?php $no++;} ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer bg-primary">
    <div class="row">
        <div class="form-group col-md-12 text-center">
            <button type="button" class="btn btn-rounded btn-danger" id="TutupMultiHarga" data-dismiss="modal">
                <i class="mdi mdi-close"></i> Tutup (Esc)
            </button>
        </div>
    </div>
</div>