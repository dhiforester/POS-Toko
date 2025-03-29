<?php
    ini_set("display_errors","off");
    include "../../_Config/Connection.php";
?>
<script>
    $(document).ready(function(){
        $('#TabelDataReturList').load('_Page/Retur/TabelTransaksiRetur.php');
        //Ketika melakukan pencarian
        $("#MulaiPencarianRetur").submit(function () {
            $('#TabelDataReturList').html('Loading..');
            var keyword=$('#PencarianRetur').val();
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/Retur/TabelTransaksiRetur.php',
                data 	:  { keyword: keyword },
                success : function(data){
                    $('#TabelDataReturList').html(data);
                }
            });
        });
    });
    //TombolMulaiCariRetur
    $("#PencarianRetur").focus(function () {
        $("#PencarianRetur").removeClass("border-dark");
        $("#PencarianRetur").addClass("border-danger");
    });
    $("#PencarianRetur").focusout(function () {
        $("#PencarianRetur").removeClass("border-danger");
        $("#PencarianRetur").addClass("border-dark");
    });
    //TombolPencarian
    $("#TombolPencarian").focus(function () {
        $("#TombolPencarian").removeClass("btn-outline-primary");
        $("#TombolPencarian").addClass("btn-primary");
    });
    $("#TombolPencarian").focusout(function () {
        $("#TombolPencarian").removeClass("btn-primary");
        $("#TombolPencarian").addClass("btn-outline-primary");
    });
    //TombolTutupCariTransaksiRetur
    $("#TombolTutup").focus(function () {
        $("#TombolTutup").removeClass("btn-outline-dark");
        $("#TombolTutup").addClass("btn-dark");
    });
    $("#TombolTutup").focusout(function () {
        $("#TombolTutup").removeClass("btn-dark");
        $("#TombolTutup").addClass("btn-outline-dark");
    });
</script>

<div class="modal-header bg-danger">
    <div class="row">
        <div class="col col-md-12">
            <h3 class="text-white">List Transaksi Retur</h3>
        </div>
    </div>
</div>
<div class="modal-body bg-white">
    <div class="row">
        <form action="javascript:void(0);" id="MulaiPencarianRetur">
            <div class="form-group col col-md-12">
                <div class="input-group">
                    <input type="text" class="form-control border-dark" id="PencarianRetur" class="form-control" placeholder="Cari.." value="">
                    <div class="input-group-append border-primary">
                        <button type="submit" class="btn btn-outline-primary" id="TombolPencarian">
                            <i class="mdi mdi-menu mdi-search-web"></i>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="row">
        <div class="col col-md-12">
            <div id="TabelDataReturList">
                <!----- Disini Diletakan KontentTabelTransaksiRetur--->
            </div>
        </div>
    </div>
</div>
<div class="modal-footer bg-danger">
    <div class="row">
        <div class="col col-md-12">
            <button class="btn btn-rounded btn-outline-dark" data-dismiss="modal" id="TombolTutup">
                <i class="mdi mdi-close"></i> Tutup
            </button>
        </div>
    </div>
</div>