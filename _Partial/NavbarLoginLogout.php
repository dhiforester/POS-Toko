<?php
    //KONEKSI KE DATABASE SQL
    ini_set("display_errors","off");
    date_default_timezone_set('Asia/Jakarta');
    include "../_Config/Connection.php";
    include "../_Config/SessionLogin.php";
    if(empty($SessionIdUser)){
?>
    <li class="nav-item dropdown d-none d-xl-inline-block">
        <a class="nav-link count-indicator dropdown-toggle" href="javascript:void(0);" data-toggle="modal" data-target="#ModalLogin">
            <i class="mdi mdi-login"></i> Login
        </a>
    </li>
<?php }else{ ?>
    <li class="nav-item dropdown d-none d-xl-inline-block">
        <a class="nav-link count-indicator dropdown-toggle" href="javascript:void(0);" data-toggle="modal" data-target="#ModalLogout">
            <i class="mdi mdi-logout"></i> Logout
        </a>
    </li>
<?php } ?>