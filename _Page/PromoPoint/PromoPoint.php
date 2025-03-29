<script>
    $(document).ready(function(){
        $("#Hadiah").removeClass();
        $("#Hadiah").addClass("btn btn-primary");
        $("#Klaim").removeClass();
        $("#Klaim").addClass("btn btn-outline-primary");
        $("#TransaksiPoint").removeClass();
        $("#TransaksiPoint").addClass("btn btn-outline-primary");
        var TampilanHalaman="";
        $.ajax({
            type 	: 'POST',
            url 	: '_Page/PromoPoint/hadiah.php',
            data 	:  'TampilanHalaman='+ TampilanHalaman,
            success : function(data){
                $('#SubHalaman').html(data);
            }
        });
    });
    $('#Hadiah').click(function(){
        $("#Hadiah").removeClass();
        $("#Hadiah").addClass("btn btn-primary");
        $("#Klaim").removeClass();
        $("#Klaim").addClass("btn btn-outline-primary");
        $("#TransaksiPoint").removeClass();
        $("#TransaksiPoint").addClass("btn btn-outline-primary");
        var TampilanHalaman="";
        $.ajax({
            type 	: 'POST',
            url 	: '_Page/PromoPoint/hadiah.php',
            data 	:  'TampilanHalaman='+ TampilanHalaman,
            success : function(data){
                $('#SubHalaman').html(data);
            }
        });
    });
    $('#Klaim').click(function(){
        $("#Hadiah").removeClass();
        $("#Hadiah").addClass("btn btn-outline-primary");
        $("#Klaim").removeClass();
        $("#Klaim").addClass("btn btn-primary");
        $("#TransaksiPoint").removeClass();
        $("#TransaksiPoint").addClass("btn btn-outline-primary");
        var TampilanHalaman="";
        $.ajax({
            type 	: 'POST',
            url 	: '_Page/PromoPoint/Klaim.php',
            data 	:  'TampilanHalaman='+ TampilanHalaman,
            success : function(data){
                $('#SubHalaman').html(data);
            }
        });
    });
    $('#TransaksiPoint').click(function(){
        $("#Hadiah").removeClass();
        $("#Hadiah").addClass("btn btn-outline-primary");
        $("#Klaim").removeClass();
        $("#Klaim").addClass("btn btn-outline-primary");
        $("#TransaksiPoint").removeClass();
        $("#TransaksiPoint").addClass("btn btn-primary");
        var TampilanHalaman="";
        $.ajax({
            type 	: 'POST',
            url 	: '_Page/PromoPoint/TransaksiPoint.php',
            data 	:  'TampilanHalaman='+ TampilanHalaman,
            success : function(data){
                $('#SubHalaman').html(data);
            }
        });
    });
</script>
<div class="row">
    <div class="col-xl-4 col-lg-4 col-md-4col-sm-4 grid-margin stretch-card">
        <div class="card card-statistics">
            <div class="card-body">
                <h3 class="text-primary"><i class="menu-icon mdi mdi-coin"></i> Promo Point</h3>
            </div>
        </div>
    </div>
    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 grid-margin stretch-card text-right">
        <div class="card card-statistics">
            <div class="card-body">
                <button class="btn btn-outline-primary" id="Hadiah">
                   <i class="mdi mdi-star"></i> Hadiah
                </button>
                <button class="btn btn-outline-primary" id="Klaim">
                   <i class="mdi mdi-gift"></i> Klaim
                </button>
                <button class="btn btn-outline-primary" id="TransaksiPoint">
                <i class="mdi mdi-view-list"></i> Log Point
                </button>
            </div>
        </div>
    </div>
</div>
<div id="SubHalaman">

</div>
