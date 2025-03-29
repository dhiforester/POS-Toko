<?php
    include "../../_Config/Connection.php";
    include "../../_Config/SessionLogin.php";
    $milliseconds = round(microtime(true) * 1000);
    //Kode
    $query_kode=mysqli_query($conn, "SELECT max(id_beban) as maksimal FROM beban")or die(mysqli_error($conn));
    while($hasil_kode=mysqli_fetch_array($query_kode)){
        $nilai=$hasil_kode['maksimal'];
    }
    $kode_dasar=$nilai+1;
    $kode_dasar1=sprintf("%07d", $kode_dasar);
    $kode="BBN$SessionIdUser$kode_dasar1";
    //Data tanggal
    $tanggal =date('Y-m-d');
    //Data kategori
    $kategori ="";
    //Data uang
    $uang ="";
    //Data keterangan
    $keterangan ="";
?>
<script>
    $(document).ready(function(){
        $('#KodeTransaksi').focus();
        //Pengetikan KodeTransaksi
        $('#KodeTransaksi').focus(function(){
            $('#KodeTransaksi').removeClass('border-dark');
            $('#KodeTransaksi').addClass('border-primary');
        });
        $('#KodeTransaksi').focusout(function(){
            $('#KodeTransaksi').removeClass('border-primary');
            $('#KodeTransaksi').addClass('border-dark');
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
        //Tambah ProsesAddRetur
        $('#ProsesPembayaranBeban').submit(function(){
            $('#NotifikasiProsesTambahBeban').html('<b class="text-primary">Ket:</b> Loadng..');
            var ProsesPembayaranBeban = $('#ProsesPembayaranBeban').serialize();
            $.ajax({
                url     : "_Page/Beban/ProsesPembayaranBeban.php",
                method  : "POST",
                data    : ProsesPembayaranBeban,
                success: function (data) {
                    $('#NotifikasiProsesTambahBeban').html(data);
                    //Variabel Notifikasi
                    var NotifikasiTambahBebanBerhasil=$('#NotifikasiTambahBebanBerhasil').html();
                    var GetKode = $('#kodebeban').html();
                    if(NotifikasiTambahBebanBerhasil=="Berhasil"){
                        $.ajax({
                            type 	: 'POST',
                            url 	: '_Page/Beban/TabelBeban.php',
                            data    : { keyword: GetKode },
                            success : function(data){
                                $('#TabelLogTransaksi').html(data);
                                $('#ModalPembayaranBeban').modal('hide');
                            }
                        });
                    }
                }
            })
        });
    });
</script>
<form action="javascript:void(0);" autocomplete="off" id="ProsesPembayaranBeban">
    <input type="hidden" name="milliseconds" value="<?php echo "$milliseconds";?>">
    <div class="modal-header bg-primary">
        <div class="row">
            <div class="col col-md-12">
                <h3 class="text-white">
                    <i class="mdi mdi-check-all"></i>Pembayaran Biaya/Beban
                </h3>
            </div>
        </div>
    </div>
    <div class="modal-body bg-white">
        <div class="form-group row">
            <div class="col col-md-6">
                <label>Kode (F9)</label>
                <input type="text" required name="kode" id="KodeTransaksi" class="form-control border-dark" value="<?php echo $kode;?>">
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
                    <input type="text" class="form-control border-dark" name="kategori" id="kategori" value="">
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
                <input type="text" required name="uang" id="uang" class="form-control border-dark" value="">
                <small id="LabelUang">Format (Rp)</small>
            </div>
        </div>
        <div class="form-group row">
            <div class="col col-md-12">
                <label>Keterangan</label>
                <input type="text" name="keterangan" id="keterangan" class="form-control border-dark" value="">
            </div>
        </div>
        <div class="form-group row">
            <div class="col col-md-12">
                <small> <b>Notifikasi :</b> </small>
                <small id="NotifikasiProsesTambahBeban">Belum ada Proses </small>
            </div>
        </div>
    </div>
    <div class="modal-footer bg-primary">
        <button type="submit" class="btn btn-sm btn-light"><i class="mdi mdi-plus"></i> Simpan</button>
        <button type="reset" class="btn btn-sm btn-warning"><i class="mdi mdi-undo"></i> Reset</button>
        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal"><i class="mdi mdi-close"></i> Tutup</button>
    </div>
</form>