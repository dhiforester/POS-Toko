<?php
    //koneksi dan error
    include "../../_Config/Connection.php";
    include "../../_Config/SessionLogin.php";
?>
<script>
    $(document).ready(function(){
        $('#FormSetting').load("_Page/Setting/FormSetting.php");
        $('#MenuSetting').load("_Page/Setting/MenuSetting.php");
    });
</script>
<div class="row">
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 grid-margin stretch-card">
        <div class="card card-statistics">
            <div class="card-body">
                <h3 class="text-primary"><i class="menu-icon mdi mdi-settings"></i> Setting Sistem</h3>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 grid-margin stretch-card">
        <div class="card card-statistics">
            <div class="card-body">
                <div class="row">
                    <div class="col col-lg-12" id="MenuSetting">
                        <!----- Menu Disni ----->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 grid-margin">
        <div class="card">
            <div  id="FormSetting">
                <!----- Tabel disini ----->
            </div>
        </div>
    </div>
</div>