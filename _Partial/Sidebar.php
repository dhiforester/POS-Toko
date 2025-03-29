<script>
    $(document).ready(function(){
        $('#SidebarBeranda').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('.nav-item').removeClass("bg-inverse-info");
            $('#IdSidebarBeranda').addClass("bg-inverse-info");
            $('#Halaman').html(Loading);
            $('#Halaman').load('_Page/Beranda/Beranda.php');
        });
        $('#SidebarBantuan').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('.nav-item').removeClass("bg-inverse-info");
            $('#IdSidebarBantuan').addClass("bg-inverse-info");
            $('#Halaman').html(Loading);
            $('#Halaman').load('_Page/Bantuan/Bantuan.php');
        });
        $('#Setting').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('.nav-item').removeClass("bg-inverse-info");
            $('#MenuListSetting').addClass("bg-inverse-info");
            $('#Halaman').html(Loading);
            $('#Halaman').load('_Page/Setting/Setting.php');
        });
        $('#Akses').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            var data="1";
            $('.nav-item').removeClass("bg-inverse-info");
            $('#MenuListAkses').addClass("bg-inverse-info");
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
        $('#Member').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#Halaman').html(Loading);
            $('.nav-item').removeClass("bg-inverse-info");
            $('#MenuListMember').addClass("bg-inverse-info");
            $('#Halaman').load('_Page/Member/Member.php');
        });
        $('#DataObat').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            var batas="25";
            $('.nav-item').removeClass("bg-inverse-info");
            $('#MenuListDataObat').addClass("bg-inverse-info");
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
        
        $('#Kasir').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            var NewOrEdit="New";
            $('.nav-item').removeClass("bg-inverse-info");
            $('#MenuListKasir').addClass("bg-inverse-info");
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
            $('.nav-item').removeClass("bg-inverse-info");
            $('#MenuListTransaksi').addClass("bg-inverse-info");
            $('#Halaman').html(Loading);
            $('#Halaman').load('_Page/Transaksi/Transaksi.php');
        });
        $('#LogTransaksi').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('.nav-item').removeClass("bg-inverse-info");
            $('#MenuListLogTransaksi').addClass("bg-inverse-info");
            $('#Halaman').html(Loading);
            $('#Halaman').load('_Page/LogTransaksi/LogTransaksi.php');
        });
        $('#PromoPoint').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('.nav-item').removeClass("bg-inverse-info");
            $('#MenuListPromoPoint').addClass("bg-inverse-info");
            $('#Halaman').html(Loading);
            $('#Halaman').load('_Page/PromoPoint/PromoPoint.php');
        });
        $('#BackupRestore').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('.nav-item').removeClass("bg-inverse-info");
            $('#MenuListBackupRestore').addClass("bg-inverse-info");
            $('#Halaman').html(Loading);
            $('#Halaman').load('_Page/BackupRestore/BackupRestore.php');
        });
        $('#Laporan').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('.nav-item').removeClass("bg-inverse-info");
            $('#MenuListLaporan').addClass("bg-inverse-info");
            $('#Halaman').html(Loading);
            $('#Halaman').load('_Page/Laporan/Laporan.php');
        });
        $('#ModalLogout').on('show.bs.modal', function (e) {
            $('#NotifikasiLogout').html('<img src="images/pertanyaan.png" width="50%">');
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
                            $('#MenuKanan').load('_Partial/Sidebar.php');
                            $('#NavbarNotifikasi').load('_Partial/NavbarNotifikasi.php');
                            $('#NavbarLoginLogout').load('_Partial/NavbarLoginLogout.php');
                            $('#NavbarProfil').load('_Partial/NavbarProfil.php');
                            $('#Halaman').load('_Page/Beranda/Beranda.php');
                            $(document).on("keyup", function(event) {
                                if (event.keyCode === 27) {
                                    document.getElementById("TutupLogoutBerhasil").click();
                                }
                            });
                            $('#NotifikasiLogout').html('<img src="images/pertanyaan.png" width="50%">');
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
                                    $('#MenuKanan').load('_Partial/Sidebar.php');
                                    $('#NavbarNotifikasi').load('_Partial/NavbarNotifikasi.php');
                                    $('#NavbarLoginLogout').load('_Partial/NavbarLoginLogout.php');
                                    $('#NavbarProfil').load('_Partial/NavbarProfil.php');
                                    $('#Halaman').load('_Page/Beranda/Beranda.php');
                                    $(document).on("keyup", function(event) {
                                        if (event.keyCode === 27) {
                                            document.getElementById("TutupLoginBerhasil").click();
                                        }
                                    });
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
    <ul class="nav" id="">
        <li class="nav-item bg-inverse-info" id="IdSidebarBeranda">
            <a class="nav-link" href="javascript:void(0);" id="SidebarBeranda">
                <i class="menu-icon mdi mdi-television"></i>
                <span class="menu-title">Beranda</span>
            </a>
        </li>
        <li class="nav-item" id="IdSidebarBantuan">
            <a class="nav-link" href="javascript:void(0);" id="SidebarBantuan">
                <i class="menu-icon mdi mdi-account-edit"></i>
                <span class="menu-title">Bantuan</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="javascript:void(0);" data-toggle="modal" data-target="#ModalLogin">
                <i class="menu-icon mdi mdi-login"></i>
                <span class="menu-title">Login</span>
            </a>
        </li>
    </ul>
<?php }else{ ?>
    <ul class="nav" id="">
        <li class="nav-item bg-inverse-info" id="IdSidebarBeranda">
            <a class="nav-link" href="javascript:void(0);" id="SidebarBeranda">
                <i class="menu-icon mdi mdi-television"></i>
                <span class="menu-title">Beranda</span>
            </a>
        </li>
        <?php if($SessionLevel=="Admin"){ ?>
            <li class="nav-item" id="MenuListSetting">
                <a class="nav-link" href="javascript:void(0);" id="Setting">
                    <i class="menu-icon mdi mdi-settings"></i>
                    <span class="menu-title">Setting</span>
                </a>
            </li>
            <li class="nav-item" id="MenuListAkses">
                <a class="nav-link" href="javascript:void(0);" id="Akses">
                    <i class="menu-icon mdi mdi-account-box"></i>
                    <span class="menu-title">Akses</span>
                </a>
            </li>
            <li class="nav-item" id="MenuListMember">
                <a class="nav-link" href="javascript:void(0);" id="Member">
                    <i class="menu-icon mdi mdi-account-multiple"></i>
                    <span class="menu-title">Member & Supplier</span>
                </a>
            </li>
            <li class="nav-item" id="MenuListDataObat">
                <a class="nav-link" href="javascript:void(0);" id="DataObat">
                    <i class="menu-icon mdi mdi-receipt"></i>
                    <span class="menu-title">Data Barang</span>
                </a>
            </li>
            <li class="nav-item" id="MenuListKasir">
                <a class="nav-link" href="javascript:void(0);" id="Kasir">
                    <i class="menu-icon mdi mdi-play-circle-outline"></i>
                    <span class="menu-title">Kasir</span>
                </a>
            </li>
            <li class="nav-item" id="MenuListLogTransaksi">
                <a class="nav-link" href="javascript:void(0);" id="LogTransaksi">
                    <i class="menu-icon mdi mdi-table"></i>
                    <span class="menu-title">Transaksi</span>
                </a>
            </li>
            <li class="nav-item" id="MenuListPromoPoint">
                <a class="nav-link" href="javascript:void(0);" id="PromoPoint">
                    <i class="menu-icon mdi mdi-coins"></i>
                    <span class="menu-title">Promo Point</span>
                </a>
            </li>
            <li class="nav-item" id="MenuListLaporan">
                <a class="nav-link" href="javascript:void(0);" id="Laporan">
                    <i class="menu-icon mdi mdi-playlist-check"></i>
                    <span class="menu-title">Laporan</span>
                </a>
            </li>
            <li class="nav-item" id="MenuListBackupRestore">
                <a class="nav-link" href="javascript:void(0);" id="BackupRestore">
                    <i class="menu-icon mdi mdi-database"></i>
                    <span class="menu-title">Backup & Restore</span>
                </a>
            </li>
        <?php }if($SessionLevel=="Kasir"){ ?>
            <li class="nav-item" id="MenuListDataObat">
                <a class="nav-link" href="javascript:void(0);" id="DataObat">
                    <i class="menu-icon mdi mdi-receipt"></i>
                    <span class="menu-title">Data Barang</span>
                </a>
            </li>
            <li class="nav-item" id="MenuListMember">
                <a class="nav-link" href="javascript:void(0);" id="Member">
                    <i class="menu-icon mdi mdi-account-multiple"></i>
                    <span class="menu-title">Member & Supplier</span>
                </a>
            </li>
            <li class="nav-item" id="MenuListKasir">
                <a class="nav-link" href="javascript:void(0);" id="Kasir">
                    <i class="menu-icon mdi mdi-play-circle-outline"></i>
                    <span class="menu-title">Kasir</span>
                </a>
            </li>
            <li class="nav-item" id="MenuListLogTransaksi">
                <a class="nav-link" href="javascript:void(0);" id="LogTransaksi">
                    <i class="menu-icon mdi mdi-table"></i>
                    <span class="menu-title">Transaksi</span>
                </a>
            </li>
            <li class="nav-item" id="MenuListPromoPoint">
                <a class="nav-link" href="javascript:void(0);" id="PromoPoint">
                    <i class="menu-icon mdi mdi-coins"></i>
                    <span class="menu-title">Promo Point</span>
                </a>
            </li>
        <?php } ?>
        <li class="nav-item">
            <a class="nav-link" href="javascript:void(0);" data-toggle="modal" data-target="#ModalLogout">
                <i class="menu-icon mdi mdi-logout"></i>
                <span class="menu-title">Logout</span>
            </a>
        </li>
    </ul>
<?php } ?>