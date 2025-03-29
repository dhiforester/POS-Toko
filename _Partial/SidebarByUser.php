<script>
    $(document).ready(function(){
        $('#TagihanPembayaranPelanggan').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            var data="1";
            $('#Halaman').html(Loading);
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/Tagihan/TagihanPembayaranPelanggan.php',
                data 	: 'data='+ data,
                success : function(data){
                    $('#Halaman').html(data);
                }
            });
        });
        $('#Akses').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            var data="1";
            $('#Halaman').html(Loading);
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/User/User.php',
                data 	: 'data='+ data,
                success : function(data){
                    $('#Halaman').html(data);
                }
            });
        });
        $('#DataObat').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            var batas="25";
            $('#Halaman').html(Loading);
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/Obat/Obat.php',
                data 	: 'batas='+ batas,
                success : function(data){
                    $('#Halaman').html(data);
                }
            });
        });
        $('#Setting').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#Halaman').html(Loading);
            $('#Halaman').load('_Page/Setting/Setting.php');
        });
        $('#Kasir').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            var NewOrEdit="New";
            $('#Halaman').html(Loading);
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/Kasir/Kasir.php',
                data 	: 'NewOrEdit='+ NewOrEdit,
                success : function(data){
                    $('#Halaman').html(data);
                }
            });
        });
        $('#Transaksi').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#Halaman').html(Loading);
            $('#Halaman').load('_Page/Transaksi/Transaksi.php');
        });
        $('#SidebarPendaftaran').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#Halaman').html(Loading);
            $('#Halaman').load('_Page/Pendaftaran/Pendaftaran.php');
        });
        $('#KirimKeluhan').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#Halaman').html(Loading);
            $('#Halaman').load('_Page/KirimKeluhan/KirimKeluhan.php');
        });
        $('#PengajuanPerubahanDaya').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#Halaman').html(Loading);
            $('#Halaman').load('_Page/PerubahanDaya/PengajuanPerubahanDaya.php');
        });
        $('#KeluhanPelangganAdmin').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#Halaman').html(Loading);
            $('#Halaman').load('_Page/KirimKeluhan/KeluhanPelangganAdmin.php');
        });
        $('#PerubahanDayaAdmin').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#Halaman').html(Loading);
            $('#Halaman').load('_Page/PerubahanDaya/PerubahanDayaAdmin.php');
        });
        $('#PemasanganBaru').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#Halaman').html(Loading);
            $('#Halaman').load('_Page/PemasanganBaru/PemasanganBaru.php');
        });
        $('#LogTransaksi').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#Halaman').html(Loading);
            var JenisTransaksi="";
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/LogTransaksi/LogTransaksi.php',
                data 	:  { JenisTransaksi: JenisTransaksi },
                success : function(data){
                    $('#Halaman').html(data);
                    
                }
            });
        });
        $('#Member').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#Halaman').html(Loading);
            $('#Halaman').load('_Page/Member/Member.php');
        });
        $('#PromoPoint').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#Halaman').html(Loading);
            $('#Halaman').load('_Page/PromoPoint/PromoPoint.php');
        });
        $('#Laporan').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#Halaman').html(Loading);
            $('#Halaman').load('_Page/Laporan/Laporan.php');
        });
        $('#BackupRestore').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#Halaman').html(Loading);
            $('#Halaman').load('_Page/BackupRestore/BackupRestore.php');
        });
        $('#ModalLogout').on('show.bs.modal', function (e) {
            $('#KlikProsesLogout').click(function(){
                var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
                $('#NotifikasiLogout').html(Loading);
                var data="test";
                $.ajax({
                    type 	: 'POST',
                    url 	: '_Page/Logout/ProsesLogout.php',
                    data 	: 'data='+ data,
                    success : function(data){
                        $('#NotifikasiLogout').html(data);
                        var notifikasi= $('#notifikasi').html();
                        if(notifikasi=="Berhasil"){
                            $('#ModalLogout').modal('hide');
                            $('#ModalLogoutBerhasil').modal('show');
                            $('#SidebarLoginLogout').load('_Partial/SidebarLoginLogout.php');
                            $('#SidebarByUser').load('_Partial/SidebarByUser.php');
                            $('#NavbarNotifikasi').load('_Partial/NavbarNotifikasi.php');
                            $('#NavbarLoginLogout').load('_Partial/NavbarLoginLogout.php');
                            $('#NavbarProfil').load('_Partial/NavbarProfil.php');
                            $('#Halaman').load('_Page/Beranda/Beranda.php');
                        }
                    }
                });
            });
        });
        $('#ModalLogin').on('show.bs.modal', function (e) {
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#FormLogin').html(Loading);
            var DataLogin="None";
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/Login/FormLogin.php',
                data 	: {DataLogin: DataLogin},
                success : function(data){
                    $('#FormLogin').html(data);
                    $('#ProsesInputLogin').submit(function(){
                        var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
                        $('#NotifikasiInputLogin').html(Loading);
                        var ProsesInputLogin=$('#ProsesInputLogin').serialize();
                        $.ajax({
                            type 	: 'POST',
                            url 	: '_Page/Login/ProsesLogin.php',
                            data 	: ProsesInputLogin,
                            success : function(data){
                                $('#NotifikasiInputLogin').html(data);
                                var notifikasi= $('#notifikasi').html();
                                if(notifikasi=="Berhasil"){
                                    $('#ModalLogin').modal('hide');
                                    $('#ModalLoginBerhasil').modal('show');
                                    $('#SidebarLoginLogout').load('_Partial/SidebarLoginLogout.php');
                                    $('#SidebarByUser').load('_Partial/SidebarByUser.php');
                                    $('#NavbarNotifikasi').load('_Partial/NavbarNotifikasi.php');
                                    $('#NavbarLoginLogout').load('_Partial/NavbarLoginLogout.php');
                                    $('#NavbarProfil').load('_Partial/NavbarProfil.php');
                                    $('#Halaman').load('_Page/Beranda/Beranda.php');
                                }
                            }
                        });
                    });
                }
            });
        });
    });
</script>

<?php
    //KONEKSI KE DATABASE SQL
    ini_set("display_errors","off");
    date_default_timezone_set('Asia/Jakarta');
    include "../_Config/Connection.php";
    include "../_Config/SessionLogin.php";
    if(empty($SessionIdUser)){
?>
    
<?php }else{ ?>
    <?php if($SessionLevel=="Admin"){ ?>
        <li class="nav-item">
            <a class="nav-link" href="javascript:void(0);" id="Setting">
                <i class="menu-icon mdi mdi-settings"></i>
                <span class="menu-title">Setting</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="javascript:void(0);" id="Akses">
                <i class="menu-icon mdi mdi-account-box"></i>
                <span class="menu-title">Akses</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="javascript:void(0);" id="Member">
                <i class="menu-icon mdi mdi-account-multiple"></i>
                <span class="menu-title">Member & Supplier</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="javascript:void(0);" id="DataObat">
                <i class="menu-icon mdi mdi-receipt"></i>
                <span class="menu-title">Data Barang</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="javascript:void(0);" id="Kasir">
                <i class="menu-icon mdi mdi-play-circle-outline"></i>
                <span class="menu-title">Kasir</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="javascript:void(0);" id="LogTransaksi">
                <i class="menu-icon mdi mdi-table"></i>
                <span class="menu-title">Transaksi</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="javascript:void(0);" id="PromoPoint">
                <i class="menu-icon mdi mdi-coins"></i>
                <span class="menu-title">Promo Point</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="javascript:void(0);" id="PageLaporan">
                <i class="menu-icon mdi mdi-playlist-check"></i>
                <span class="menu-title">Laporan</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="javascript:void(0);" id="BackupRestore">
                <i class="menu-icon mdi mdi-database"></i>
                <span class="menu-title">Backup & Restore</span>
            </a>
        </li>
    <?php }if($SessionLevel=="Kasir"){ ?>
        <li class="nav-item">
            <a class="nav-link" href="javascript:void(0);" id="DataObat">
                <i class="menu-icon mdi mdi-receipt"></i>
                <span class="menu-title">Data Barang</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="javascript:void(0);" id="Member">
                <i class="menu-icon mdi mdi-account-multiple"></i>
                <span class="menu-title">Member & Supplier</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="javascript:void(0);" id="Kasir">
                <i class="menu-icon mdi mdi-play-circle-outline"></i>
                <span class="menu-title">Kasir</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="javascript:void(0);" id="LogTransaksi">
                <i class="menu-icon mdi mdi-table"></i>
                <span class="menu-title">Transaksi</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="javascript:void(0);" id="PromoPoint">
                <i class="menu-icon mdi mdi-coins"></i>
                <span class="menu-title">Promo Point</span>
            </a>
        </li>
    <?php } ?>
<?php } ?>

    