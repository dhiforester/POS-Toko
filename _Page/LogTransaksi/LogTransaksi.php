<?php
    if(empty($_POST['retur'])){
        $retur="0";
    }else{
        $retur="1";
    }
    if(empty($_POST['PembayaranUtangPiutang'])){
        $PembayaranUtangPiutang="0";
    }else{
        $PembayaranUtangPiutang="1";
    }
?>
<script type="text/javascript">
    $(document).on("keyup", function(event) {
        if (event.keyCode === 112) {
            document.getElementById("TambahPembayaranBeban").click();
        }
        if (event.keyCode === 113) {
            document.getElementById("DataPembayaranBeban").click();
        }
        if (event.keyCode === 115) {
            document.getElementById("MenuDataPembayaranUtangPiutang").click();
        }
        //F9
        if (event.keyCode === 120) {
            document.getElementById("KodeTransaksi").focus();
        }
    });
</script>
<script>
    $(document).ready(function(){
        $('#KeywordTransaksi').focus();
        //Focus SemuaTransaksi
        $('#SemuaTransaksi').focus(function(){
            $('#SemuaTransaksi').removeClass('btn-outline-primary');
            $('#SemuaTransaksi').addClass('btn-primary');
        });
        $('#SemuaTransaksi').focusout(function(){
            $('#SemuaTransaksi').removeClass('btn-primary');
            $('#SemuaTransaksi').addClass('btn-outline-primary');
        });
        //Focus Penjualan
        $('#Penjualan').focus(function(){
            $('#Penjualan').removeClass('btn-outline-info');
            $('#Penjualan').addClass('btn-info');
        });
        $('#Penjualan').focusout(function(){
            $('#Penjualan').removeClass('btn-info');
            $('#Penjualan').addClass('btn-outline-info');
        });
        //Focus Pembelian
        $('#Pembelian').focus(function(){
            $('#Pembelian').removeClass('btn-outline-info');
            $('#Pembelian').addClass('btn-info');
        });
        $('#Pembelian').focusout(function(){
            $('#Pembelian').removeClass('btn-info');
            $('#Pembelian').addClass('btn-outline-info');
        });
        //Focus TransaksiRetur
        $('#TransaksiRetur').focus(function(){
            $('#TransaksiRetur').removeClass('btn-outline-warning');
            $('#TransaksiRetur').addClass('btn-warning');
        });
        $('#TransaksiRetur').focusout(function(){
            $('#TransaksiRetur').removeClass('btn-warning');
            $('#TransaksiRetur').addClass('btn-outline-warning');
        });
        //Focus Lainnya
        $('#Lainnya').focus(function(){
            $('#Lainnya').removeClass('btn-outline-danger');
            $('#Lainnya').addClass('btn-danger');
        });
        $('#Lainnya').focusout(function(){
            $('#Lainnya').removeClass('btn-danger');
            $('#Lainnya').addClass('btn-outline-danger');
        });
        //Focus KeywordTransaksi
        $('#KeywordTransaksi').focus(function(){
            $('#KeywordTransaksi').removeClass('border-primary');
            $('#KeywordTransaksi').addClass('border-danger');
        });
        $('#KeywordTransaksi').focusout(function(){
            $('#KeywordTransaksi').removeClass('border-danger');
            $('#KeywordTransaksi').addClass('border-primary');
        });
        //Focus TombolCari
        $('#TombolCari').focus(function(){
            $('#TombolCari').removeClass('btn-primary');
            $('#TombolCari').addClass('btn-dark');
        });
        $('#TombolCari').focusout(function(){
            $('#TombolCari').removeClass('btn-dark');
            $('#TombolCari').addClass('btn-primary');
        });
        //Focus UtangPiutang
        $('#UtangPiutang').focus(function(){
            $('#UtangPiutang').removeClass('btn-outline-info');
            $('#UtangPiutang').addClass('btn-info');
        });
        $('#UtangPiutang').focusout(function(){
            $('#UtangPiutang').removeClass('btn-info');
            $('#UtangPiutang').addClass('btn-outline-info');
        });
        //Click SemuaTransaksi
        $('#SemuaTransaksi').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#TabelLogTransaksi').html(Loading);
            $('#TabelLogTransaksi').load('_Page/LogTransaksi/TabelTransaksi.php');
        });
        $('#Penjualan').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#TabelLogTransaksi').html(Loading);
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/LogTransaksi/TabelTransaksi.php',
                data    : { JenisTransaksi: "penjualan" },
                success : function(data){
                    $('#TabelLogTransaksi').html(data);
                }
            });
        });
        $('#Pembelian').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#TabelLogTransaksi').html(Loading);
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/LogTransaksi/TabelTransaksi.php',
                data    : { JenisTransaksi: "pembelian" },
                success : function(data){
                    $('#TabelLogTransaksi').html(data);
                }
            });
        });
        $('#UtangPiutang').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#TabelLogTransaksi').html(Loading);
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/LogTransaksi/TabelUtangPiutang.php',
                data    : { JenisTransaksi: "" },
                success : function(data){
                    $('#TabelLogTransaksi').html(data);
                    $('#KategoriPencarian').val('UtangPiutang');
                }
            });
        });
        //LihatTabelRetur
        $('#LihatTabelRetur').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#TabelLogTransaksi').html(Loading);
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/LogTransaksi/TabelRetur.php',
                data    : { retur: "1" },
                success : function(data){
                    $('#TabelLogTransaksi').html(data);
                    $('#KategoriPencarian').val('Retur');
                }
            });
        });
        //MenuDataPembayaranUtangPiutang
        $('#MenuDataPembayaranUtangPiutang').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#TabelLogTransaksi').html(Loading);
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/LogTransaksi/TabelPembayaranUtangPiutang.php',
                data    : { PembayaranUtangPiutang: "1" },
                success : function(data){
                    $('#TabelLogTransaksi').html(data);
                    $('#KategoriPencarian').val('PembayaranUtangPiutang');
                }
            });
        });
        //PencarianTransaksi
        <?php if($retur=="0"){ ?>
            //Pertama kali muncul
            $('#TabelLogTransaksi').load('_Page/LogTransaksi/TabelTransaksi.php');
            //Ketika melakukan pencarian
            $('#PencarianTransaksi').submit(function(){
                var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
                var keyword=$('#KeywordTransaksi').val();
                var KategoriPencarian=$('#KategoriPencarian').val();
                $('#TabelLogTransaksi').html(Loading);
                if(KategoriPencarian=="Retur"){
                    $.ajax({
                        type 	: 'POST',
                        url 	: '_Page/LogTransaksi/TabelRetur.php',
                        data    : { keyword: keyword },
                        success : function(data){
                            $('#TabelLogTransaksi').html(data);
                        }
                    });
                }else{
                    if(KategoriPencarian=="PembayaranUtangPiutang"){
                        $.ajax({
                            type 	: 'POST',
                            url 	: '_Page/LogTransaksi/TabelPembayaranUtangPiutang.php',
                            data    : { keyword: keyword },
                            success : function(data){
                                $('#TabelLogTransaksi').html(data);
                            }
                        });
                    }else{
                        if(KategoriPencarian=="PembayaranBeban"){
                            $.ajax({
                                type 	: 'POST',
                                url 	: '_Page/Beban/TabelBeban.php',
                                data    : { keyword: keyword },
                                success : function(data){
                                    $('#TabelLogTransaksi').html(data);
                                }
                            });
                        }else{
                            $.ajax({
                                type 	: 'POST',
                                url 	: '_Page/LogTransaksi/TabelTransaksi.php',
                                data    : { keyword: keyword },
                                success : function(data){
                                    $('#TabelLogTransaksi').html(data);
                                }
                            });
                        }
                    }
                }
                
            });
        <?php }else{ ?>
            //Pertama kali muncul
            $('#TabelLogTransaksi').load('_Page/LogTransaksi/TabelRetur.php');
            $('#PencarianTransaksi').submit(function(){
                var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
                var keyword=$('#KeywordTransaksi').val();
                $('#TabelLogTransaksi').html(Loading);
                $.ajax({
                    type 	: 'POST',
                    url 	: '_Page/LogTransaksi/TabelRetur.php',
                    data    : { keyword: keyword },
                    success : function(data){
                        $('#TabelLogTransaksi').html(data);
                    }
                });
            });
        <?php } ?>
        $('#ModalPilihTransaksiRetur').on('show.bs.modal', function (e) {
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#TablePilihTransaksiRetur').html(Loading);
            $('#TablePilihTransaksiRetur').load('_Page/Kasir/TablePilihTransaksiRetur.php');
        }); 
        //Modal ModalPembayaranBeban
        $('#ModalPembayaranBeban').on('show.bs.modal', function (e) {
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            var id_beban = $(e.relatedTarget).data('id');
            var NewOrEdit="New";
            $('#FormPembayaranBeban').html(Loading);
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/Beban/FormPembayaranBeban.php',
                data    : { id_beban: id_beban, NewOrEdit: NewOrEdit },
                success : function(data){
                    $('#FormPembayaranBeban').html(data);
                    $('#kode').focus();
                }
            });
        }); 
        //Data Pembayaran Beban
        $('#DataPembayaranBeban').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#TabelLogTransaksi').html(Loading);
            var keyword="";
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/Beban/TabelBeban.php',
                data    : { keyword: keyword },
                success : function(data){
                    $('#TabelLogTransaksi').html(data);
                    $('#KategoriPencarian').val('PembayaranBeban');
                }
            });
        });
    });
</script>
<div class="row">
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 grid-margin stretch-card">
        <div class="card card-statistics">
            <div class="card-body">
                <h3 class="text-primary"><i class="menu-icon mdi mdi-table"></i> Transaksi</h3>
                <b id="TitleHalaman"></b>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 grid-margin stretch-card">
        <div class="card card-statistics">
            <div class="card-body">
                <form action="javascript:void(0);" autocomplete="off" id="PencarianTransaksi">
                    <input type="hidden" name="KategoriPencarian" id="KategoriPencarian">
                    <div class="input-group">
                        <input type="text" class="form-control border-primary" id="KeywordTransaksi" placeholder="Kode/Tanggal" value="">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary" id="TombolCari">
                                <i class="menu-icon mdi mdi-search-web"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 grid-margin stretch-card text-right">
        <div class="card card-statistics">
            <div class="card-body">
                <button type="button" class="btn btn-sm btn-outline-primary" id="SemuaTransaksi">
                    <i class="mdi mdi-check-all"></i> All
                </button>
                <button type="button" class="btn btn-sm btn-outline-info" id="Penjualan">
                    <i class="mdi mdi-coins"></i> Jual
                </button>
                <button type="button" class="btn btn-sm btn-outline-info" id="Pembelian">
                    <i class="mdi mdi-shopping"></i> Beli
                </button>
                <button type="button" class="btn btn-sm btn-outline-info" id="UtangPiutang">
                    <i class="mdi mdi-book-multiple"></i> U/P
                </button>
                <small class="dropdown">
                    <button type="button" class="btn btn-sm btn-outline-warning" id="TransaksiRetur" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="mdi mdi-menu-down"></i> Retur
                    </button>
                    <div class="dropdown-menu border-primary" aria-labelledby="TransaksiRetur">
                        <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#ModalPilihTransaksiRetur">Buat Faktur Retur</a>
                        <a class="dropdown-item" href="javascript:void(0);" id="LihatTabelRetur">Lihat Data Retur</a>
                    </div>
                </small>
                <small class="dropdown">
                    <button type="button" class="btn btn-sm btn-outline-danger" id="Lainnya" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="mdi mdi-menu-down"></i> More
                    </button>
                    <div class="dropdown-menu border-primary" aria-labelledby="UtangPiutang">
                        <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#ModalPembayaranBeban" id="TambahPembayaranBeban">Pembayaran Beban (F1)</a>
                        <a class="dropdown-item" href="javascript:void(0);" id="DataPembayaranBeban">Data Pembayaran (F2)</a>
                        <a class="dropdown-item" href="javascript:void(0);" id="MenuDataPembayaranUtangPiutang">Data Pembayaran Utang/Piutng (F4)</a>
                    </div>
                </small>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 grid-margin stretch-card">
        <div class="card card-statistics">
            <div id="TabelLogTransaksi">

            </div>
        </div>
    </div>
</div>