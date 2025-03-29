<?php
    //Tanggal dan koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SessionLogin.php";
    $milliseconds = round(microtime(true) * 1000);
    //Tangkap variabel NewOrEdit
    if(!empty($_POST['NewOrEdit'])){
        $NewOrEdit=$_POST['NewOrEdit'];
    }else{
        $NewOrEdit="New";
    }
    //Apabila PArameter Edit Diterima
    if($NewOrEdit=="Edit"){
        //Tangkap id_utang_piutang
        if(!empty($_POST['id_utang_piutang'])){
            $id_utang_piutang=$_POST['id_utang_piutang'];
            //Buka data utang_piutang dari database
            $QryUtangPiutang = mysqli_query($conn, "SELECT * FROM utang_piutang WHERE id_utang_piutang='$id_utang_piutang'")or die(mysqli_error($conn));
            $DataUtangPiutang = mysqli_fetch_array($QryUtangPiutang);
            $kode=$DataUtangPiutang['kode'];
            $tanggal=$DataUtangPiutang['tanggal'];
            $id_transaksi=$DataUtangPiutang['id_transaksi'];
            $uang=$DataUtangPiutang['uang'];
            $keterangan=$DataUtangPiutang['keterangan'];
        }else{
            $id_utang_piutang="";
            $tanggal=date('Y-m-d');
            //Buat kode pembayaran utang piutang
            $query_kode=mysqli_query($conn, "SELECT max(id_utang_piutang) as maksimal FROM utang_piutang")or die(mysqli_error($conn));
            while($hasil_kode=mysqli_fetch_array($query_kode)){
                $nilai=$hasil_kode['maksimal'];
            }
            $kode_dasar=$nilai+1;
            $kode_dasar1=sprintf("%07d", $kode_dasar);
            $kode="PMUP$SessionIdUser$kode_dasar1";
            $uang="";
            $keterangan="";
            $id_transaksi="";
        }
    }else{
    //Sebaliknya Apabila Parameter New Diterima
        //Tangkap variabel id_transaksi
        if(!empty($_POST['id_transaksi'])){
            $id_transaksi=$_POST['id_transaksi'];
        }else{
            $id_transaksi="";
        }
        //Tanggal default hari ini
        $id_utang_piutang="";
        $tanggal=date('Y-m-d');
        //Buat kode pembayaran utang piutang
        $query_kode=mysqli_query($conn, "SELECT max(id_utang_piutang) as maksimal FROM utang_piutang")or die(mysqli_error($conn));
        while($hasil_kode=mysqli_fetch_array($query_kode)){
            $nilai=$hasil_kode['maksimal'];
        }
        $kode_dasar=$nilai+1;
        $kode_dasar1=sprintf("%07d", $kode_dasar);
        $kode="PMUP$SessionIdUser$kode_dasar1";
        $uang="";
        //Buka Transaksi untuk membuat keterangan
        $QryTransaksiUntkKeterangan = mysqli_query($conn, "SELECT * FROM transaksi WHERE id_transaksi='$id_transaksi'")or die(mysqli_error($conn));
        $DataTransaksiUntkKeterangan = mysqli_fetch_array($QryTransaksiUntkKeterangan);
        $transUntkKeterangan=$DataTransaksiUntkKeterangan['jenis_transaksi'];
        $KeteranganUntkKeterangan=$DataTransaksiUntkKeterangan['keterangan'];
        if($transUntkKeterangan=="penjualan"){
            if($KeteranganUntkKeterangan=="Utang"){
                $keterangan="Pembayaran Utang";
            }
            if($KeteranganUntkKeterangan=="Piutang"){
                $keterangan="Pembayaran Piutang";
            }
        }else{
            if($KeteranganUntkKeterangan=="Utang"){
                $keterangan="Pembayaran Utang";
            }
            if($KeteranganUntkKeterangan=="Piutang"){
                $keterangan="Pembayaran Piutang";
            }
        }
    }
    //Buka kode transaksi dari database
    $QryTransaksi = mysqli_query($conn, "SELECT * FROM transaksi WHERE id_transaksi='$id_transaksi'")or die(mysqli_error($conn));
    $DataTransaksi = mysqli_fetch_array($QryTransaksi);
    $kode_transaksi=$DataTransaksi['kode_transaksi'];
?>
<script>
    $(document).ready(function(){
        //Focus kode
        $('#kode').focus(function(){
            $('#kode').removeClass('border-info');
            $('#kode').addClass('border-primary');
        });
        $('#kode').focusout(function(){
            $('#kode').removeClass('border-primary');
            $('#kode').addClass('border-info');
        });
        //Focus tanggal
        $('#tanggal').focus(function(){
            $('#tanggal').removeClass('border-info');
            $('#tanggal').addClass('border-primary');
        });
        $('#tanggal').focusout(function(){
            $('#tanggal').removeClass('border-primary');
            $('#tanggal').addClass('border-info');
        });
        //Focus kode_transaksi
        $('#kode_transaksi').focus(function(){
            $('#kode_transaksi').removeClass('border-info');
            $('#kode_transaksi').addClass('border-primary');
        });
        $('#kode_transaksi').focusout(function(){
            $('#kode_transaksi').removeClass('border-primary');
            $('#kode_transaksi').addClass('border-info');
        });
        //Focus uang
        $('#uang').focus(function(){
            $('#uang').removeClass('border-info');
            $('#uang').addClass('border-primary');
        });
        $('#uang').focusout(function(){
            $('#uang').removeClass('border-primary');
            $('#uang').addClass('border-info');
        });
        //Focus keterangan
        $('#keterangan').focus(function(){
            $('#keterangan').removeClass('border-info');
            $('#keterangan').addClass('border-primary');
        });
        $('#keterangan').focusout(function(){
            $('#keterangan').removeClass('border-primary');
            $('#keterangan').addClass('border-info');
        });
        //Validasi uang
        $('#uang').keyup(function(){
            var uang=$('#uang').val();
            var validasiAngka = /^[0-9]+$/;
            if(uang.match(validasiAngka)) {
                $('#LabelUang').html('<i class="text-primary">Format ANgka</i>');
                $('#uang').removeClass('border-danger');
                $('#uang').addClass('border-primary');
            }else{
                $('#LabelUang').html('<i class="text-danger">Hanya Boleh Format Angka</i>');
                $('#uang').removeClass('border-primary');
                $('#uang').addClass('border-danger');
            }
        });
        //ProsesPembayaranUtangPiutang
        $('#ProsesPembayaranUtangPiutang').submit(function(){
            var Loading='<img src="images/loading.gif" width="5px">';
            $('#NotifikasiBayarUtangPiutang').html(Loading);
            var ProsesPembayaranUtangPiutang = $('#ProsesPembayaranUtangPiutang').serialize();
            $.ajax({
                url     : "_Page/Transaksi/ProsesPembayaranUtangPiutang.php",
                method  : "POST",
                data    : ProsesPembayaranUtangPiutang,
                success: function (data) {
                    $('#NotifikasiBayarUtangPiutang').html(data);
                    document.getElementById("ProsesPembayaranUtangPiutang").reset();
                    var NotifikasiBerhasil=$('#NotifikasiBerhasil').html();
                    if(NotifikasiBerhasil=="Berhasil"){
                        $('#ModalBayarUtang').modal('hide');
                        $('#ModalBayarUtangEdit').modal('hide');
                        $('#DetailLogTransaksi').html('Loading...');
                        $.ajax({
                            url     : "_Page/Transaksi/DetailTransaksi.php",
                            method  : "POST",
                            data    : { kode_transaksi: "<?php echo $kode_transaksi;?>", NewOrEdit: "<?php echo $NewOrEdit;?>" },
                            success: function (data) {
                                $('#DetailLogTransaksi').html(data);
                            }
                        })
                    }
                }
            })
        });
        $('#HapusBayarUtang').click(function(){
            var id_utang_piutang=$('#HapusBayarUtang').val();
            $.ajax({
                url     : "_Page/Transaksi/HapusBayarUtang.php",
                method  : "POST",
                data    : { id_utang_piutang: id_utang_piutang },
                success: function (data) {
                    $('#NotifikasiBayarUtangPiutang').html(data);
                    var NotifikasiHutangPiutangBerhasil=$('#NotifikasiHutangPiutangBerhasil').html();
                    if(NotifikasiHutangPiutangBerhasil=="Berhasil"){
                        $('#ModalBayarUtangEdit').modal('hide');
                        var kode_transaksi="<?php echo $kode_transaksi;?>";
                        $('#DetailLogTransaksi').html('Loading...');
                        $.ajax({
                            url     : "_Page/Transaksi/DetailTransaksi.php",
                            method  : "POST",
                            data    : { kode_transaksi: kode_transaksi },
                            success: function (data) {
                                $('#DetailLogTransaksi').html(data);
                            }
                        })
                    }
                }
            })
        });
    });
</script>
<form action="javascript:void(0);" id="ProsesPembayaranUtangPiutang">
    <input type="hidden" name="milliseconds" value="<?php echo $milliseconds;?>">
    <input type="hidden" name="id_transaksi" value="<?php echo $id_transaksi;?>">
    <input type="hidden" name="NewOrEdit" value="<?php echo $NewOrEdit;?>">
    <input type="hidden" name="id_utang_piutang" value="<?php echo $id_utang_piutang;?>">
    <div class="modal-header bg-dark">
        <h4 class="text-white">
            Pembayaran Utang/Piutang
        </h4>
    </div>
    <div class="modal-body bg-inverse-secondary">
        <div class="row">
            <div class="form-group col-md-6">
                <label for="kode">Kode Pembayaran</label>
                <input type="text" required name="kode" id="kode" class="form-control border-info" value="<?php echo $kode;?>">
            </div>
            <div class="form-group col-md-6">
                <label for="tanggal">Tanggal</label>
                <input type="date" required name="tanggal" id="tanggal" class="form-control border-info" value="<?php echo $tanggal;?>">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6">
                <label for="kode_transaksi">Kode Transaksi</label>
                <input type="text" required name="kode_transaksi" id="kode_transaksi" class="form-control border-info" value="<?php echo $kode_transaksi;?>">
            </div>
            <div class="form-group col-md-6">
                <label for="uang">Pembayaran (Rp)</label>
                <input type="text" required name="uang" id="uang" class="form-control border-info" value="<?php echo $uang;?>">
                <small id="LabelUang">Format Angka</small>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-12">
                <label for="keterangan">Keterangan</label>
                <input type="text" readonly name="keterangan" id="keterangan" class="form-control border-info" value="<?php echo $keterangan;?>">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-12">
                <small id=""><b>Notifikasi :</b></small> 
                <small id="NotifikasiBayarUtangPiutang" class="text-primary">Belum ada proses</small>
            </div>
        </div>
    </div>
    <div class="modal-footer bg-dark">
        <div class="row">
            <div class="col col-md-12">
                <button type="submit" class="btn btn-sm btn-inverse-primary">
                    <i class="mdi mdi-floppy"></i> Simpan
                </button>
                <button type="reset" class="btn btn-sm btn-inverse-warning">
                    <i class="mdi mdi-undo"></i> Reset
                </button>
                <?php if($NewOrEdit=="Edit"){ ?>
                    <a href="_Page/Transaksi/CetakPembayaranUtang.php?id=<?php echo $id_utang_piutang; ?>" class="btn btn-sm btn-inverse-primary" id="CetakPembayaranUtangPiutang" target="_blank">
                        <i class="mdi mdi-printer"></i> Print
                    </a>
                    <button type="button" class="btn btn-sm btn-inverse-danger" id="HapusBayarUtang" value="<?php echo $id_utang_piutang; ?>">
                        <i class="mdi mdi-delete"></i> Hapus
                    </button>
                <?php } ?>
            </div>
        </div>
    </div>
</form>
