<script type="text/javascript">
    $(document).on("keyup", function(event) {
        if (event.keyCode === 112) {
            $('#PencarianObat').focus();
        }
        if (event.keyCode === 113) {
            document.getElementById("TambahObat").click();
        }
    });
</script>
<?php
    include "../../_Config/Connection.php";
    $JumlahItem = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM obat"));
    //page
    if(!empty($_POST['page'])){
        $page=$_POST['page'];
    }else{
        $page="";
    }
    //batas
    if(!empty($_POST['batas'])){
        $batas=$_POST['batas'];
    }else{
        $batas="";
    }
    //keyword
    if(!empty($_POST['keyword'])){
        $keyword=$_POST['keyword'];
    }else{
        $keyword="";
    }
    if(empty($_POST['OrderBy'])){
?>
    <script>
        $(document).ready(function(){
            var AkseLoading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#TabelObat').html(AkseLoading);
            $('#PencarianObat').focus();
            var page="<?php echo $page;?>";
            var batas="<?php echo $batas;?>";
            var keyword="<?php echo $keyword;?>";
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/Obat/TabelObat.php',
                data 	:  { page: page, batas: batas, keyword: keyword },
                success : function(data){
                    $('#TabelObat').html(data);
                }
            });
        });
    </script>
    <?php 
        }else{ 
            $OrderBy=$_POST['OrderBy'];
            $ShortBy=$_POST['ShortBy'];
    ?>
    <script>
        $(document).ready(function(){
            var AkseLoading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#TabelObat').html(AkseLoading);
            var page="<?php echo $page;?>";
            var batas="<?php echo $batas;?>";
            var keyword="<?php echo $keyword;?>";
            var OrderBy="<?php echo $OrderBy;?>";
            var ShortBy="<?php echo $ShortBy;?>";
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/Obat/TabelObat.php',
                data 	:  { page: page, batas: batas, keyword: keyword, OrderBy: OrderBy, ShortBy: ShortBy },
                success : function(data){
                    $('#TabelObat').html(data);
                }
            });
        });
    </script>
<?php } ?>
<script>
    $('#TombolPencarian').focus(function(){
        $('#TombolPencarian').removeClass("btn-outline-primary");
        $('#TombolPencarian').addClass("btn-primary");
    });
    $('#TombolPencarian').focusout(function(){
        $('#TombolPencarian').removeClass("btn-primary");
        $('#TombolPencarian').addClass("btn-outline-primary");
    });
    $('#TambahObat').focus(function(){
        $('#TambahObat').removeClass("btn-outline-primary");
        $('#TambahObat').addClass("btn-primary");
    });
    $('#TambahObat').focusout(function(){
        $('#TambahObat').removeClass("btn-primary");
        $('#TambahObat').addClass("btn-outline-primary");
    });
    $('#TombolBatch').focus(function(){
        $('#TombolBatch').removeClass("btn-outline-primary");
        $('#TombolBatch').addClass("btn-primary");
    });
    $('#TombolBatch').focusout(function(){
        $('#TombolBatch').removeClass("btn-primary");
        $('#TombolBatch').addClass("btn-outline-primary");
    });
    $('#StokOpename').focus(function(){
        $('#StokOpename').removeClass("btn-outline-primary");
        $('#StokOpename').addClass("btn-primary");
    });
    $('#StokOpename').focusout(function(){
        $('#StokOpename').removeClass("btn-primary");
        $('#StokOpename').addClass("btn-outline-primary");
    });
    //Pencarian
    $('#MulaiPencarianBarang').submit(function(){
        var keyword = $('#PencarianObat').val();
        $.ajax({
            type 	: 'POST',
            url 	: '_Page/Obat/TabelObat.php',
            data 	:  'keyword='+ keyword,
            success : function(data){
                $('#TabelObat').html(data);
            }
        });
    });
    $('#TambahObat').click(function(){
        var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
        $('#Halaman').html(Loading);
        $('#Halaman').load('_Page/Obat/TambahObat.php');
        $('#kode').focus();
    });
    $('#GenerateBarang').click(function(){
        var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
        $('#TabelObat').html(Loading);
        $('#TabelObat').load("_Page/Obat/GenerateBarang.php");
    });
    //ketika Modal pencarian batch muncul
    $('#ModalPencarianBatc').on('show.bs.modal', function (e) {
        var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
        $('#FormPencarianBatch').html(Loading);
        var id_obat = $(e.relatedTarget).data('id');
        $.ajax({
            url     : "_Page/Obat/FormPencarianBatch.php",
            method  : "POST",
            data    : { id_obat: id_obat },
            success: function (data) {
                $('#FormPencarianBatch').html(data);
            }
        })
    });
    //ketika Modal pencarian batch muncul
    $('#ModalStokOpename').on('show.bs.modal', function (e) {
        var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
        $('#FormStokOpename').html(Loading);
        $('#FormStokOpename').load('_Page/Obat/FormStokOpename.php');
    });
</script>
<div class="row">
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 grid-margin stretch-card">
        <div class="card card-statistics">
            <div class="card-body">
                <h3 class="text-primary" id="ReloadObat" onmousemove="this.style.cursor='pointer'">
                    <i class="mdi mdi-menu mdi-search-web"></i> Data Barang
                </h3>
                <small><?php echo "" . number_format($JumlahItem,0,',','.');?> Item</small>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 grid-margin stretch-card">
        <div class="card card-statistics">
            <div class="card-body">
                <div class="row">
                    <form action="javascript:void(0);" id="MulaiPencarianBarang">
                        <div class="form-group col col-md-12">
                            <div class="input-group">
                                <input type="text" class="form-control form-control-sm" id="PencarianObat" class="form-control" placeholder="Cari (F1)" value="">
                                <div class="input-group-append border-primary">
                                    <button type="submit" class="btn btn-outline-primary" id="TombolPencarian">
                                        <i class="mdi mdi-menu mdi-search-web"></i>
                                    </button>
                                </div>
                            </div>
                            <small>
                                (F1) Cari Barang - (ENTER) Mulai Cari 
                            </small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 grid-margin stretch-card">
        <div class="card card-statistics">
            <div class="card-body">
                <div class="row">
                    <div class="col col-lg-12 text-right">
                        <button class="btn btn-sm btn-outline-primary" id="TambahObat">
                            <i class="menu-icon mdi mdi-plus"></i> Tambah (F2)
                        </button>
                        <button class="btn btn-sm btn-outline-primary" id="TombolBatch" data-toggle="modal" data-target="#ModalPencarianBatc">
                            <i class="menu-icon mdi mdi-account-search"></i> Batch
                        </button>
                        <!---
                        <button class="btn btn-sm btn-outline-primary" id="GenerateBarang">
                            <i class="menu-icon mdi mdi-file-excel"></i> Syn
                        </button>
                        Tombol Ini Digunakan untuk generate data barang
                        --->
                        <button class="btn btn-sm btn-outline-primary" id="StokOpename" data-toggle="modal" data-target="#ModalStokOpename">
                            <i class="menu-icon mdi mdi-square"></i> Stok Opename
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div  id="TabelObat">
    <!----- Tabel disini ----->
</div>