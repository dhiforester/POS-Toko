<script>
    $(document).ready(function(){
        $('#ProfilUser').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#Halaman').html(Loading);
            $('#Halaman').load('_Page/ProfilUser/ProfilUser.php');
        });
    });
</script>
<?php
    //KONEKSI KE DATABASE SQL
    include "../_Config/Connection.php";
    include "../_Config/SessionLogin.php";
    if(empty($SessionIdUser)){
?>
    <?php
        }else{
            echo '  <li class="nav-item dropdown">';
            echo '      <a class="nav-link count-indicator dropdown-toggle" id="ProfilUser" href="javascript:void(0);">';
            echo '          <i class="mdi mdi-account-circle"></i>';
            echo '      </a>';
            echo '  </li>';
        }
    ?>