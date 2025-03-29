<?php
    include "../../_Config/Connection.php";
    if(!empty($_POST['KeywordRetur'])){
        $KeywordRetur=$_POST['KeywordRetur'];
        $jml_data = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM transaksi WHERE kode_transaksi like '%$KeywordRetur%' LIMIT 100"));
    }else{
        $KeywordRetur="";
        $jml_data ="0";
    }
?>
<script>
    $(document).ready(function(){
        $('#KeywordPencarianTransaksiRetur').focus();
        $('#MulaiPencarianTransaskiRetur').submit(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            var KeywordRetur = $('#KeywordPencarianTransaksiRetur').val();
            $('#KontentTableTransaksiRetur').html(Loading);
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/Kasir/KontentTableTransaksiRetur.php',
                data 	:  { KeywordRetur: KeywordRetur },
                success : function(data){
                    $('#KontentTableTransaksiRetur').html(data);
                }
            });
        });
    });
    //TombolMulaiCariRetur
    $("#TombolMulaiCariRetur").focus(function () {
        $("#TombolMulaiCariRetur").removeClass("btn-outline-primary");
        $("#TombolMulaiCariRetur").addClass("btn-primary");
    });
    $("#TombolMulaiCariRetur").focusout(function () {
        $("#TombolMulaiCariRetur").removeClass("btn-primary");
        $("#TombolMulaiCariRetur").addClass("btn-outline-primary");
    });
    //TombolTutupCariTransaksiRetur
    $("#TombolTutupCariTransaksiRetur").focus(function () {
        $("#TombolTutupCariTransaksiRetur").removeClass("btn-outline-danger");
        $("#TombolTutupCariTransaksiRetur").addClass("btn-danger");
    });
    $("#TombolTutupCariTransaksiRetur").focusout(function () {
        $("#TombolTutupCariTransaksiRetur").removeClass("btn-danger");
        $("#TombolTutupCariTransaksiRetur").addClass("btn-outline-danger");
    });
</script>

<div class="modal-header bg-dark">
    <div class="row">
        <div class="col col-md-12">
            <h3 class="text-white">Pilih Transaksi</h3>
            <small class="text-white">Cari Kemudian Pilih Transaksi yang akan diretur.</small>
        </div>
    </div>
</div>
<div class="modal-body bg-white">
    <div class="row">
        <form action="javascript:void(0);" id="MulaiPencarianTransaskiRetur">
            <div class="form-group col col-md-12">
                <div class="input-group">
                    <input type="text" class="form-control" id="KeywordPencarianTransaksiRetur" placeholder="Cari.." value="<?php echo $KeywordRetur;?>">
                    <div class="input-group-append border-primary">
                        <button type="submit" class="btn btn-outline-primary" id="TombolMulaiCariRetur">
                            <i class="mdi mdi-menu mdi-search-web"></i> Cari (Enter)
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="row">
        <div class="col col-md-12 text-center">
            <div id="KontentTableTransaksiRetur">
                <h4 class="text-danger">Belum ada data yang ditampilkan</h4>
                <p class="text-danger">Silahkan lakukan pencarian dengan kode transaksi</p>
                <!----- Disini Diletakan KontentTabelTransaksiRetur--->
            </div>
        </div>
    </div>
</div>
<div class="modal-footer bg-dark">
    <div class="row">
        <div class="col col-md-12">
            <button class="btn btn-rounded btn-outline-danger" data-dismiss="modal" id="TombolTutupCariTransaksiRetur">
                <i class="mdi mdi-close"></i> Tutup
            </button>
        </div>
    </div>
</div>