<?php
    //KONEKSI KE DATABASE SQL
    ini_set("display_errors","off");
    date_default_timezone_set('Asia/Jakarta');
    include "../_Config/Connection.php";
    include "../_Config/SessionLogin.php";
    if(empty($SessionIdUser)){
?>
    <li class="nav-item">
        <a class="nav-link" href="javascript:void(0);" id="SidebarPendaftaran">
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
<?php }else{ ?>
    
    <li class="nav-item">
        <a class="nav-link" href="javascript:void(0);" data-toggle="modal" data-target="#ModalLogout">
            <i class="menu-icon mdi mdi-logout"></i>
            <span class="menu-title">Logout</span>
        </a>
    </li>
<?php } ?>