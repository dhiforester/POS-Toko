<script>
    $(document).ready(function(){
        $('#NavbarLoginLogout').load('_Partial/NavbarLoginLogout.php');
        $('#NavbarProfil').load('_Partial/NavbarProfil.php');
        $('#NavbarNotifikasi').load('_Partial/NavbarNotifikasi.php');
    });
    $(document).ready(function(){
        $('#NavbarBeranda').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#Halaman').html(Loading);
            $('#Halaman').load('_Page/Beranda/Beranda.php');
        });
        $('#NavbarAboutUs').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#Halaman').html(Loading);
            $('#Halaman').load('_Page/AboutUs/AboutUs.php');
        });
        $('#NavbarBantuan').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#Halaman').html(Loading);
            $('#Halaman').load('_Page/Bantuan/Bantuan.php');
        });
        $('#ProfilUser').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#Halaman').html(Loading);
            $('#Halaman').load('_Page/ProfilUser/ProfilUser.php');
        });
    });
</script>
<nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
        <a class="navbar-brand brand-logo" href="index.php">
            <img src="images/<?php echo $logo;?>" alt="logo" />
        </a>
        <a class="navbar-brand brand-logo-mini" href="index.php">
            <img src="images/<?php echo $logo;?>" alt="logo" />
        </a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center">
        <ul class="navbar-nav navbar-nav-left header-links d-none d-md-flex">
            <li class="nav-item">
                <a href="javascript:void(0);" class="nav-link" id="NavbarBeranda">
                    <i class="mdi mdi-home"></i> Beranda
                </a>
            </li>
            <li class="nav-item">
                <a href="javascript:void(0);" class="nav-link" id="NavbarBantuan">
                    <i class="mdi mdi-information"></i> Bantuan
                </a>
            </li>
        </ul>
        <ul class="navbar-nav navbar-nav-right">
            <div id="NavbarNotifikasi"></div>
            <div id="NavbarProfil"></div>
            <div id="NavbarLoginLogout"></div>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
        </button>
    </div>
</nav>
