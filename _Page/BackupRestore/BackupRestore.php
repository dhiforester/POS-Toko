<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    if(empty($_POST['SubHalaman'])){
        $SubHalaman="Backup";
    }else{
        $SubHalaman=$_POST['SubHalaman'];
    }
?>
<script>
    $(document).ready(function(){
        $("#Backup").removeClass();
        $("#Backup").addClass("btn btn-primary");
        $("#Restore").removeClass();
        $("#Restore").addClass("btn btn-outline-primary");
        var SubHalaman="";
        $.ajax({
            type 	: 'POST',
            url 	: '_Page/BackupRestore/Backup.php',
            data 	:  'SubHalaman='+ SubHalaman,
            success : function(data){
                $('#IsiBackupRestore').html(data);
            }
        });
    });
    $('#Backup').click(function(){
        $("#Backup").removeClass();
        $("#Backup").addClass("btn btn-primary");
        $("#Restore").removeClass();
        $("#Restore").addClass("btn btn-outline-primary");
        var SubHalaman="Backup";
        $.ajax({
            type 	: 'POST',
            url 	: '_Page/BackupRestore/Backup.php',
            data 	:  'SubHalaman='+ SubHalaman,
            success : function(data){
                $('#IsiBackupRestore').html(data);
            }
        });
    });
    $('#Restore').click(function(){
        $("#Backup").removeClass();
        $("#Backup").addClass("btn btn-outline-primary");
        $("#Restore").removeClass();
        $("#Restore").addClass("btn btn-primary");
        var SubHalaman="Restore";
        $.ajax({
            type 	: 'POST',
            url 	: '_Page/BackupRestore/Restore.php',
            data 	:  'SubHalaman='+ SubHalaman,
            success : function(data){
                $('#IsiBackupRestore').html(data);
            }
        });
    });
</script>
<div class="row">
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 grid-margin stretch-card">
        <div class="card card-statistics">
            <div class="card-body">
                <h3 class="text-primary">
                    <i class="menu-icon mdi mdi-database"></i> 
                    Backup & Restore
                </h3>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 grid-margin stretch-card">
        <div class="card card-statistics">
            <div class="card-body">
                <div class="col col-lg-12 text-right">
                    <button class="btn <?php if($SubHalaman=="Backup"){echo 'btn-info';}else{echo 'btn-outline-info';} ?>" id="Backup">
                        <i class="menu-icon mdi mdi-download"></i> Backup
                    </button>
                    <button class="btn <?php if($SubHalaman=="SubHalaman"){echo 'btn-info';}else{echo 'btn-outline-info';} ?>" id="Restore">
                        <i class="menu-icon mdi mdi-restore"></i> Restore
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 grid-margin">
        <div class="card">
            <div class="card-body" id="IsiBackupRestore">
                <!--- Isi Kontent BackupRestore---->
            </div>
        </div>
    </div>
</div>
