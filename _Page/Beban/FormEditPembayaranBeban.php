<?php
    include "../../_Config/Connection.php";
    include "../../_Config/SessionLogin.php";
    $milliseconds = round(microtime(true) * 1000);
    //id_beban
    if(!empty($_POST['id_beban'])){
        $id_beban=$_POST['id_beban'];
    }else{
        $id_beban="";
    }
    //Buka data beban
    $QryBeban = mysqli_query($conn, "SELECT * FROM beban WHERE id_beban='$id_beban'")or die(mysqli_error($conn));
    $DataBeban = mysqli_fetch_array($QryBeban);
    $kode= $DataBeban['kode'];
    //Data tanggal
    if(!empty($DataBeban['tanggal'])){
        $tanggal = $DataBeban['tanggal'];
    }else{
        $tanggal =date('Y-m-d');
    }
    //Data kategori
    if(!empty($DataBeban['kategori'])){
        $kategori = $DataBeban['kategori'];
    }else{
        $kategori ="";
    }
    //Data uang
    if(!empty($DataBeban['uang'])){
        $uang = $DataBeban['uang'];
    }else{
        $uang ="";
    }
    //Data keterangan
    if(!empty($DataBeban['keterangan'])){
        $keterangan = $DataBeban['keterangan'];
    }else{
        $keterangan ="";
    }
?>
<script>
    $(document).ready(function(){
        $('#kode').focus();
        //Pengetikan Kode
        $('#kode').focus(function(){
            $('#kode').removeClass('border-dark');
            $('#kode').addClass('border-primary');
        });
        $('#kode').focusout(function(){
            $('#kode').removeClass('border-primary');
            $('#kode').addClass('border-dark');
        });
        //Pengetikan tanggal
        $('#tanggal').focus(function(){
            $('#tanggal').removeClass('border-dark');
            $('#tanggal').addClass('border-primary');
        });
        $('#tanggal').focusout(function(){
            $('#tanggal').removeClass('border-primary');
            $('#tanggal').addClass('border-dark');
        });
        //Pengetikan kategori
        $('#kategori').focus(function(){
            $('#kategori').removeClass('border-dark');
            $('#kategori').addClass('border-primary');
        });
        $('#kategori').focusout(function(){
            $('#kategori').removeClass('border-primary');
            $('#kategori').addClass('border-dark');
        });
        //Pengetikan TombolDropdown
        $('#TombolDropdown').focus(function(){
            $('#TombolDropdown').removeClass('btn-outline-primary');
            $('#TombolDropdown').addClass('btn-primary');
        });
        $('#TombolDropdown').focusout(function(){
            $('#TombolDropdown').removeClass('btn-primary');
            $('#TombolDropdown').addClass('btn-outline-primary');
        });
        //Pengetikan uang
        $('#uang').focus(function(){
            $('#uang').removeClass('border-dark');
            $('#uang').addClass('border-primary');
        });
        $('#uang').focusout(function(){
            $('#uang').removeClass('border-primary');
            $('#uang').addClass('border-dark');
        });
        //Pengetikan keterangan
        $('#keterangan').focus(function(){
            $('#keterangan').removeClass('border-dark');
            $('#keterangan').addClass('border-primary');
        });
        $('#keterangan').focusout(function(){
            $('#keterangan').removeClass('border-primary');
            $('#keterangan').addClass('border-dark');
        });
        //Ketika pembayaran diketik
        $('#uang').keyup(function(){
            var uang = $('#uang').val();
            if(uang.match(/^\d+/)){
                $('#LabelUang').html("<small class='text-primary'>Format (Rp)</small>");
            }else{
                $('#LabelUang').html("<small class='text-danger'>Error!! Hanya Boleh Angka</small>");
            }
        });
        <?php
            //Arraykan data kategori
            $no=1;
            $query = mysqli_query($conn, "SELECT DISTINCT kategori FROM beban");
            while ($data = mysqli_fetch_array($query)) {
                $KategoriDataList=$data['kategori'];
        ?>
            $('#PilihKategori<?php echo "$no";?>').click(function(){
                var PilihKategori=$('#PilihKategori<?php echo $no;?>').html();
                $('#kategori').val(PilihKategori);
            });
        <?php $no++;} ?>
        //Proses Edit Data Beban
        $('#ProsesEditPembayaranBeban').submit(function(){
            $('#NotifikasiEditBeban').html('<b class="text-primary">Ket:</b> Loadng..');
            var ProsesEditPembayaranBeban = $('#ProsesEditPembayaranBeban').serialize();
            $.ajax({
                url     : "_Page/Beban/ProsesEditPembayaranBeban.php",
                method  : "POST",
                data    : ProsesEditPembayaranBeban,
                success: function (data) {
                    $('#NotifikasiEditBeban').html(data);
                    //Variabel Notifikasi
                    var NotifikasiEditBeban=$('#NotifikasiEditBebanBerhasil').html();
                    if(NotifikasiEditBeban=="Berhasil"){
                        document.getElementById("ProsesEditPembayaranBeban").reset();
                        var kode="<?php echo $kode;?>";
                        $.ajax({
                            type 	: 'POST',
                            url 	: '_Page/Beban/TabelBeban.php',
                            data    : { keyword: kode },
                            success : function(data){
                                $('#TabelLogTransaksi').html(data);
                            }
                        });
                        $('#ModalEditPembayaranBeban').modal('hide');
                    }
                }
            })
        });
        //Modal Hapus Beban
        $('#ModalHapusBeban').on('show.bs.modal', function (e) {
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            var id_beban = $(e.relatedTarget).data('id');
            $('#FormHapusBeban').html(Loading);
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/Beban/FormHapusBeban.php',
                data    : { id_beban: id_beban },
                success : function(data){
                    //Buka Form Hapus
                    $('#FormHapusBeban').html(data);
                    //Ketika Proses Hapus Disetujui
                    $('#ProsesHapusbeban').submit(function(){
                        $('#NotifikasiHapusBeban').html(Loading);
                        var ProsesHapusbeban = $('#ProsesHapusbeban').serialize();
                        $.ajax({
                            url     : "_Page/Beban/ProsesHapusBeban.php",
                            method  : "POST",
                            data    : ProsesHapusbeban,
                            success: function (data) {
                                $('#NotifikasiHapusBeban').html(data);
                                //Variabel Notifikasi
                                var NotifikasiHapusBebanberhasil=$('#NotifikasiHapusBebanBerhasil').html();
                                if(NotifikasiHapusBebanberhasil=="Berhasil"){
                                    var kode="";
                                    $.ajax({
                                        type 	: 'POST',
                                        url 	: '_Page/Beban/TabelBeban.php',
                                        data    : { keyword: kode },
                                        success : function(data){
                                            $('#TabelLogTransaksi').html(data);
                                            $('#ModalEditPembayaranBeban').modal('hide');
                                            $('#ModalHapusBeban').modal('hide');
                                            $('#ModalHapusBebanBerhasil').modal('show');
                                        }
                                    });
                                }
                            }
                        })
                    });
                }
            });
        });
    });
</script>
<form action="javascript:void(0);" autocomplete="off" id="ProsesEditPembayaranBeban">
    <input type="hidden" name="id_beban" value="<?php echo "$id_beban"; ?>">
    <input type="hidden" name="milliseconds" value="<?php echo "$milliseconds";?>">
    <div class="modal-header bg-primary">
        <div class="row">
            <div class="col col-md-12">
                <h4 class="text-white">
                    <i class="mdi mdi-check-all"></i>Edit Pembayaran Biaya/Beban
                </h4>
            </div>
        </div>
    </div>
    <div class="modal-body bg-white">
        <div class="form-group row">
            <div class="col col-md-6">
                <label>Kode</label>
                <input type="text" required name="kode" id="kode" class="form-control border-dark" value="<?php echo $kode;?>">
            </div>
            <div class="col col-md-6">
                <label>Tanggal</label>
                <input type="date" required name="tanggal" id="tanggal" class="form-control border-dark" value="<?php echo $tanggal;?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col col-md-6">
                <label>Kategori</label>
                <div class="input-group">
                    <input type="text" class="form-control border-dark" name="kategori" id="kategori" value="<?php echo $kategori;?>">
                    <div class="input-group-append">
                        <button type="button" class="btn btn-outline-primary" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="TombolDropdown">
                            <i class="menu-icon mdi mdi-menu-down"></i>
                        </button>
                        <div class="dropdown-menu border-primary" aria-labelledby="TombolDropdown" id="PilihKategori">
                            <?php
                                //Arraykan data kategori
                                $no=1;
                                $query = mysqli_query($conn, "SELECT DISTINCT kategori FROM beban");
                                while ($data = mysqli_fetch_array($query)) {
                                    $kategoriData = $data['kategori'];
                                    echo '<a class="dropdown-item" href="javascript:void(0);" id="PilihKategori'.$no.'">'.$kategoriData.'</a>';
                                    $no++;
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col col-md-6">
                <label>Pembayaran (Rp)</label>
                <input type="text" required name="uang" id="uang" class="form-control border-dark" value="<?php echo $uang;?>">
                <small id="LabelUang">Format (Rp)</small>
            </div>
        </div>
        <div class="form-group row">
            <div class="col col-md-12">
                <label>Keterangan</label>
                <input type="text" name="keterangan" id="keterangan" class="form-control border-dark" value="<?php echo $keterangan;?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col col-md-12">
                <small> <b>Notifikasi :</b> </small>
                <small id="NotifikasiEditBeban">Belum ada Proses </small>
            </div>
        </div>
    </div>
    <div class="modal-footer bg-primary">
        <button type="submit" class="btn btn-sm btn-light"><i class="mdi mdi-plus"></i> Simpan</button>
        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#ModalHapusBeban" data-id="<?php echo "$id_beban";?>"><i class="mdi mdi-delete"></i> Hapus</button>
    </div>
</form>