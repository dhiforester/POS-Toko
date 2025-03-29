<script>
    $(document).ready(function(){
       
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
    <!----<li class="nav-item dropdown">
        <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
            <i class="mdi mdi-email-outline mx-0"></i>
            <?php
                //ini adalah baris kode untuk menampilkan notifikasi
                //apabila ada notifikasi maka akan ada tanda
                //misalnya jumlah notifikasi adalah 4
                $JumlahNotifikasi="4";
                echo "<span class='count'>$JumlahNotifikasi</span>";
            ?>
        </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
            <a class="dropdown-item">
                <p class="mb-0 font-weight-normal float-left">
                    <?php
                        //ini adalah baris kode untuk pesan notifikasi dari sistem
                        //Bisa disertai dengan jumlah notifikasi
                        echo "Anda memiliki $JumlahNotifikasi pemberitahuan";
                    ?>
                </p>
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                    <div class="preview-icon bg-success">
                        <i class="mdi mdi-alert-circle-outline mx-0"></i>
                    </div>
                </div>
                <div class="preview-item-content">
                    <h6 class="preview-subject font-weight-medium text-dark">Pesanan Baru</h6>
                    <p class="font-weight-light small-text"> Just now</p>
                </div>
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                    <div class="preview-icon bg-warning">
                        <i class="mdi mdi-comment-text-outline mx-0"></i>
                    </div>
                </div>
                <div class="preview-item-content">
                    <h6 class="preview-subject font-weight-medium text-dark">Settings</h6>
                    <p class="font-weight-light small-text">Private message</p>
                </div>
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                    <div class="preview-icon bg-info">
                    <i class="mdi mdi-email-outline mx-0"></i>
                    </div>
                </div>
                <div class="preview-item-content">
                    <h6 class="preview-subject font-weight-medium text-dark">New user registration</h6>
                    <p class="font-weight-light small-text">
                    2 days ago
                    </p>
                </div>
            </a>
        </div>
    </li>-->
<?php } ?>

            