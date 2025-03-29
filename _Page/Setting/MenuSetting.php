<?php
    //Tangkap Subhalaman
    if(!empty($_POST['SubHalaman'])){
        $SubHalaman=$_POST['SubHalaman'];
    }else{
        $SubHalaman="LembarNota";
    }
?>
<script>
    $(document).ready(function(){
        var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
        //LembarNota
        $('#LembarNota').click(function(){
            var SubHalaman = "LembarNota";
            $('#FormSetting').html(Loading);
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/Setting/FormSetting.php',
                data 	:  'SubHalaman='+ SubHalaman,
                success : function(data){
                    $('#FormSetting').html(data);
                }
            });
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/Setting/MenuSetting.php',
                data 	:  'SubHalaman='+ SubHalaman,
                success : function(data){
                    $('#MenuSetting').html(data);
                }
            });
        });
        //LembarBarcode
        $('#LembarBarcode').click(function(){
            var SubHalaman = "LembarBarcode";
            $('#FormSetting').html(Loading);
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/Setting/FormSetting.php',
                data 	:  'SubHalaman='+ SubHalaman,
                success : function(data){
                    $('#FormSetting').html(data);
                }
            });
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/Setting/MenuSetting.php',
                data 	:  'SubHalaman='+ SubHalaman,
                success : function(data){
                    $('#MenuSetting').html(data);
                }
            });
        });
        //LembarLaporan
        $('#LembarLaporan').click(function(){
            var SubHalaman = "LembarLaporan";
            $('#FormSetting').html(Loading);
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/Setting/FormSetting.php',
                data 	:  'SubHalaman='+ SubHalaman,
                success : function(data){
                    $('#FormSetting').html(data);
                }
            });
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/Setting/MenuSetting.php',
                data 	:  'SubHalaman='+ SubHalaman,
                success : function(data){
                    $('#MenuSetting').html(data);
                }
            });
        });
        //LembarLabel
        $('#LembarLabel').click(function(){
            var SubHalaman = "LembarLabel";
            $('#FormSetting').html(Loading);
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/Setting/FormSetting.php',
                data 	:  'SubHalaman='+ SubHalaman,
                success : function(data){
                    $('#FormSetting').html(data);
                }
            });
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/Setting/MenuSetting.php',
                data 	:  'SubHalaman='+ SubHalaman,
                success : function(data){
                    $('#MenuSetting').html(data);
                }
            });
        });
        //Setting Aplikasi
        $('#SettingAplikasi').click(function(){
            var SubHalaman = "SettingAplikasi";
            $('#FormSetting').html(Loading);
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/Setting/FormSettingAplikasi.php',
                data 	:  'SubHalaman='+ SubHalaman,
                success : function(data){
                    $('#FormSetting').html(data);
                }
            });
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/Setting/MenuSetting.php',
                data 	:  'SubHalaman='+ SubHalaman,
                success : function(data){
                    $('#MenuSetting').html(data);
                }
            });
        });
    });
</script>
<button class="btn btn-rounded <?php if($SubHalaman=="LembarNota"){echo "btn-primary";}else{echo "btn-outline-primary";} ?>" id="LembarNota">
    Lembar Nota
</button>
<!--<button class="btn btn-rounded <?php if($SubHalaman=="LembarBarcode"){echo "btn-primary";}else{echo "btn-outline-primary";} ?>" id="LembarBarcode">
    Barcode
</button>-->
<button class="btn btn-rounded <?php if($SubHalaman=="LembarLaporan"){echo "btn-primary";}else{echo "btn-outline-primary";} ?>" id="LembarLaporan">
    Laporan
</button>
<!---<button class="btn btn-rounded <?php if($SubHalaman=="LembarLabel"){echo "btn-primary";}else{echo "btn-outline-primary";} ?>" id="LembarLabel">
    Label
</button>-->
<button class="btn btn-rounded <?php if($SubHalaman=="SettingAplikasi"){echo "btn-primary";}else{echo "btn-outline-primary";} ?>" id="SettingAplikasi">
    Setting Aplikasi
</button>