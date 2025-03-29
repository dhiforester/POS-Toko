<?php
    //koneksi dan error
    ini_set("display_errors","off");
    include "../../_Config/Connection.php";
    //Atur Batas
    if(empty($_POST['batas'])){
        $batas="10";
    }else{
        $batas=$_POST['batas'];
    }
    //Atur Kategori
    if(!empty($_POST['Kategori'])){
        $Kategori=$_POST['Kategori'];
    }else{
        $Kategori="";
    }
    //Atur Page
    if(!empty($_POST['page'])){
        $page=$_POST['page'];
        $posisi = ( $page - 1 ) * $batas;
    }else{
        $page="1";
        $posisi = 0;
    }
    //Atur Keyword
    if(isset($_POST['keyword'])){
        $keyword=$_POST['keyword'];
    }else{
        $keyword="";
    }
    //Atur OrderBy
    if(isset($_POST['OrderBy'])){
        $OrderBy=$_POST['OrderBy'];
    }else{
        $OrderBy="nama";
    }
    //Atur ShortBy
    if(isset($_POST['ShortBy'])){
        $ShortBy=$_POST['ShortBy'];
    }else{
        $ShortBy="ASC";
    }
    //hitung jumlah data
    if(empty($Kategori)){
        if(empty($keyword)){
            $jml_data = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM obat"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM obat WHERE nama like '%$keyword%' OR kode like '%$keyword%'"));
        }
    }else{
        if(empty($keyword)){
            $jml_data = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM obat WHERE kategori='$Kategori'"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM obat WHERE kategori='$Kategori' AND nama like '%$keyword%' OR kode like '%$keyword%'"));
        }
    }
    
    //Jumlah halaman
    $JmlHalaman = ceil($jml_data/$batas); 
    $JmlHalaman_real = ceil($jml_data/$batas); 
    $prev=$page-1;
    $next=$page+1;
    if($next>$JmlHalaman){
        $next=$page;
    }else{
        $next=$page+1;
    }
    if($prev<"1"){
        $prev="1";
    }else{
        $prev=$page-1;
    }
?>
<script>
    $(document).ready(function(){
        $('#ReloadObat').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#TabelObat').html(Loading);
            $('#TabelObat').load('_Page/Obat/TabelObat.php');
        });
        //ketika Modal Delete muncul
        $('#ModalDeleteObat').on('show.bs.modal', function (e) {
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#FormDeleteObat').html(Loading);
            var DataDetail = $(e.relatedTarget).data('id');
            var mode = DataDetail.split(',');
            var id_obat = mode[0];
            var page = mode[1];
            var batas = mode[2];
            var keyword = mode[3];
            $.ajax({
                url     : "_Page/Obat/FormDeleteObat.php",
                method  : "POST",
                data    : { id_obat: id_obat },
                success: function (data) {
                    $('#FormDeleteObat').html(data);
                    //Ketika disetujui delete
                    $('#ProsesDeleteObat').submit(function(){
                        var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
                        $('#NotifikasiDeleteObat').html(Loading);
                        var ProsesDeleteObat = $('#ProsesDeleteObat').serialize();
                        $.ajax({
                            type 	: 'POST',
                            url 	: '_Page/Obat/ProsesDeleteObat.php',
                            data 	:  ProsesDeleteObat,
                            success : function(data){
                                $('#NotifikasiDeleteObat').html(data);
                                //menangkap keterangan notifikasi
                                var Notifikasi=$('#NotifikasiDeleteObatBerhasil').html();
                                if(Notifikasi=="Berhasil"){
                                    $.ajax({
                                        url     : "_Page/Obat/TabelObat.php",
                                        method  : "POST",
                                        data    : { page: page, batas: batas, keyword: keyword },
                                        success: function (data) {
                                            $('#TabelObat').html(data);
                                        }
                                    })
                                    $('#ModalDeleteObat').modal('hide');
                                    $('#ModalDetailObat').modal('hide');
                                    $('#ModalDeleteObatBerhasil').modal('show');
                                }
                            }
                        });
                    });
                }
            })
        });
        //ketika Modal Delete muncul
        $('#ModalDetailObat').on('show.bs.modal', function (e) {
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#DetailObat').html(Loading);
            var DataDetail = $(e.relatedTarget).data('id');
            var mode = DataDetail.split(',');
            var id_obat = mode[0];
            var page = mode[1];
            var batas = mode[2];
            var keyword = mode[3];
            $.ajax({
                url     : "_Page/Obat/DetailObat.php",
                method  : "POST",
                data    : { id_obat: id_obat, page: page, batas: batas, keyword: keyword },
                success: function (data) {
                    $('#DetailObat').html(data);
                    $('#EditObat').click(function() {
                        var id_obat = mode[0];
                        var page = mode[1];
                        var batas = mode[2];
                        var keyword = mode[3];
                        $.ajax({
                            url     : "_Page/Obat/EditObat.php",
                            method  : "POST",
                            data    : { page: page, id_obat: id_obat, batas: batas, keyword: keyword },
                            success: function (data) {
                                $('#Halaman').html(data);
                            }
                        })
                    });
                }
            })
        });
        //ketika Modal Multi Harga muncul
        $('#ModalTambahMultiHarga').on('show.bs.modal', function (e) {
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#FormMultiHarga').html(Loading);
            var id_obat = $(e.relatedTarget).data('id');
            $.ajax({
                url     : "_Page/Obat/FormMultiHarga.php",
                method  : "POST",
                data    : { id_obat: id_obat },
                success: function (data) {
                    $('#FormMultiHarga').html(data);
                    $('#satuanBaru').focus(); 
                }
            })
        });
        $('#NextPage').focus(function(){
            $('#NextPage').removeClass("btn-outline-secondary");
            $('#NextPage').addClass("btn-warning");
        });
        $('#NextPage').focusout(function(){
            $('#NextPage').removeClass("btn-warning");
            $('#NextPage').addClass("btn-outline-secondary");
        });
        $('#PrevPage').focus(function(){
            $('#PrevPage').removeClass("btn-outline-secondary");
            $('#PrevPage').addClass("btn-warning");
        });
        $('#PrevPage').focusout(function(){
            $('#PrevPage').removeClass("btn-warning");
            $('#PrevPage').addClass("btn-outline-secondary");
        });
        //ketika klik next
        $('#NextPage').click(function() {
            var valueNext = $('#NextPage').val();
            var mode = valueNext.split(',');
            var page = mode[0];
            var batas = mode[1];
            var keyword = mode[2];
            var Kategori ="<?php echo $Kategori;?>";
            var OrderBy ="<?php echo $OrderBy;?>";
            var ShortBy ="<?php echo $ShortBy;?>";
            $.ajax({
                url     : "_Page/Obat/TabelObat.php",
                method  : "POST",
                data 	:  { page: page, Kategori: Kategori, keyword: keyword, OrderBy: OrderBy, ShortBy: ShortBy, batas: batas },
                success: function (data) {
                    $('#TabelObat').html(data);

                }
            })
        });
        //Ketika klik Previous
        $('#PrevPage').click(function() {
            var ValuePrev = $('#PrevPage').val();
            var mode = ValuePrev.split(',');
            var page = mode[0];
            var batas = mode[1];
            var keyword = mode[2];
            var Kategori ="<?php echo $Kategori;?>";
            var OrderBy ="<?php echo $OrderBy;?>";
            var ShortBy ="<?php echo $ShortBy;?>";
            $.ajax({
                url     : "_Page/Obat/TabelObat.php",
                method  : "POST",
                data 	:  { page: page, Kategori: Kategori, keyword: keyword, OrderBy: OrderBy, ShortBy: ShortBy, batas: batas },
                success : function (data) {
                    $('#TabelObat').html(data);
                }
            })
        });
        <?php 
            $a=1;
            $b=$JmlHalaman;
            for ( $i =$a; $i<=$b; $i++ ){
        ?>
            $('#BarisDataBarang<?php echo "$i";?>').keyup(function(event) {
                if(event.keyCode==13){
                    $('#BarisDataBarang<?php echo "$i";?>').click();
                }
            });
            $("#BarisDataBarang<?php echo $i;?>").focus(function () {
                $("#BarisDataBarang<?php echo "$i";?>").addClass("table-active");
            });
            $("#BarisDataBarang<?php echo $i;?>").focusout(function () {
                $("#BarisDataBarang<?php echo "$i";?>").removeClass("table-active");
            });
            //ketika klik page number
            $('#PageNumber<?php echo $i;?>').click(function() {
                var PageNumber = $('#PageNumber<?php echo $i;?>').val();
                var mode = PageNumber.split(',');
                var page = mode[0];
                var batas = mode[1];
                var keyword = mode[2];
                var Kategori ="<?php echo $Kategori;?>";
                var OrderBy ="<?php echo $OrderBy;?>";
                var ShortBy ="<?php echo $ShortBy;?>";
                $.ajax({
                    url     : "_Page/Obat/TabelObat.php",
                    method  : "POST",
                    data 	:  { page: page, Kategori: Kategori, keyword: keyword, OrderBy: OrderBy, ShortBy: ShortBy, batas: batas },
                    success: function (data) {
                        $('#TabelObat').html(data);
                    }
                })
            });
        $('#PageNumber<?php echo $i;?>').focus(function(){
            $('#PageNumber<?php echo $i;?>').removeClass("btn-grey");
            $('#PageNumber<?php echo $i;?>').addClass("btn-warning");
        });
        $('#PageNumber<?php echo $i;?>').focusout(function(){
            $('#PageNumber<?php echo $i;?>').removeClass("btn-warning");
            $('#PageNumber<?php echo $i;?>').addClass("btn-grey");
        });
        <?php } ?>
        //BatasData
        $('#BatasData10').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#TabelObat').html(Loading);
            var Kategori ="<?php echo $Kategori;?>";
            var keyword ="<?php echo $keyword;?>";
            var OrderBy ="<?php echo $OrderBy;?>";
            var ShortBy ="<?php echo $ShortBy;?>";
            var batas ="10";
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/Obat/TabelObat.php',
                data 	:  { Kategori: Kategori, keyword: keyword, OrderBy: OrderBy, ShortBy: ShortBy, batas: batas },
                success : function(data){
                    $('#TabelObat').html(data);
                }
            });
        });
        $('#BatasData25').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#TabelObat').html(Loading);
            var Kategori ="<?php echo $Kategori;?>";
            var keyword ="<?php echo $keyword;?>";
            var OrderBy ="<?php echo $OrderBy;?>";
            var ShortBy ="<?php echo $ShortBy;?>";
            var batas ="25";
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/Obat/TabelObat.php',
                data 	:  { Kategori: Kategori, keyword: keyword, OrderBy: OrderBy, ShortBy: ShortBy, batas: batas },
                success : function(data){
                    $('#TabelObat').html(data);
                }
            });
        });
        $('#BatasData50').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#TabelObat').html(Loading);
            var Kategori ="<?php echo $Kategori;?>";
            var keyword ="<?php echo $keyword;?>";
            var OrderBy ="<?php echo $OrderBy;?>";
            var ShortBy ="<?php echo $ShortBy;?>";
            var batas ="50";
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/Obat/TabelObat.php',
                data 	:  { Kategori: Kategori, keyword: keyword, OrderBy: OrderBy, ShortBy: ShortBy, batas: batas },
                success : function(data){
                    $('#TabelObat').html(data);
                }
            });
        });
        $('#BatasData100').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#TabelObat').html(Loading);
            var Kategori ="<?php echo $Kategori;?>";
            var keyword ="<?php echo $keyword;?>";
            var OrderBy ="<?php echo $OrderBy;?>";
            var ShortBy ="<?php echo $ShortBy;?>";
            var batas ="100";
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/Obat/TabelObat.php',
                data 	:  { Kategori: Kategori, keyword: keyword, OrderBy: OrderBy, ShortBy: ShortBy, batas: batas },
                success : function(data){
                    $('#TabelObat').html(data);
                }
            });
        });
        //KodeObatAtoZ
        $('#KodeObatAtoZ').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#TabelObat').html(Loading);
            var Kategori ="<?php echo $Kategori;?>";
            var keyword ="<?php echo $keyword;?>";
            var OrderBy ="kode";
            var ShortBy ="ASC";
            var batas ="<?php echo $batas;?>";
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/Obat/TabelObat.php',
                data 	:  { Kategori: Kategori, keyword: keyword, OrderBy: OrderBy, ShortBy: ShortBy, batas: batas },
                success : function(data){
                    $('#TabelObat').html(data);
                }
            });
        });
        //KodeObatZtoA
        $('#KodeObatZtoA').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#TabelObat').html(Loading);
            var Kategori ="<?php echo $Kategori;?>";
            var keyword ="<?php echo $keyword;?>";
            var OrderBy ="kode";
            var ShortBy ="DESC";
            var batas ="<?php echo $batas;?>";
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/Obat/TabelObat.php',
                data 	:  { Kategori: Kategori, keyword: keyword, OrderBy: OrderBy, ShortBy: ShortBy, batas: batas },
                success : function(data){
                    $('#TabelObat').html(data);
                }
            });
        });
        //NamaAtoZ
        $('#NamaAtoZ').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#TabelObat').html(Loading);
            var Kategori ="<?php echo $Kategori;?>";
            var keyword ="<?php echo $keyword;?>";
            var OrderBy ="nama";
            var ShortBy ="ASC";
            var batas ="<?php echo $batas;?>";
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/Obat/TabelObat.php',
                data 	:  { Kategori: Kategori, keyword: keyword, OrderBy: OrderBy, ShortBy: ShortBy, batas: batas },
                success : function(data){
                    $('#TabelObat').html(data);
                }
            });
        });
        //NamaZtoA
        $('#NamaZtoA').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#TabelObat').html(Loading);
            var Kategori ="<?php echo $Kategori;?>";
            var keyword ="<?php echo $keyword;?>";
            var OrderBy ="nama";
            var ShortBy ="DESC";
            var batas ="<?php echo $batas;?>";
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/Obat/TabelObat.php',
                data 	:  { Kategori: Kategori, keyword: keyword, OrderBy: OrderBy, ShortBy: ShortBy, batas: batas },
                success : function(data){
                    $('#TabelObat').html(data);
                }
            });
        });
        //KategoriObat
        $('#KategoriObat').change(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            var Kategori = $('#KategoriObat').val();
            var keyword ="<?php echo $keyword;?>";
            var OrderBy ="<?php echo $OrderBy;?>";
            var ShortBy ="<?php echo $ShortBy;?>";
            var batas ="<?php echo $batas;?>";
            $('#TabelObat').html(Loading);
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/Obat/TabelObat.php',
                data 	:  { Kategori: Kategori, keyword: keyword, OrderBy: OrderBy, ShortBy: ShortBy, batas: batas },
                success : function(data){
                    $('#TabelObat').html(data);
                }
            });
        });
        //StokAtoZ
        $('#StokAtoZ').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#TabelObat').html(Loading);
            var Kategori ="<?php echo $Kategori;?>";
            var keyword ="<?php echo $keyword;?>";
            var OrderBy ="stok";
            var ShortBy ="ASC";
            var batas ="<?php echo $batas;?>";
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/Obat/TabelObat.php',
                data 	:  { Kategori: Kategori, keyword: keyword, OrderBy: OrderBy, ShortBy: ShortBy, batas: batas },
                success : function(data){
                    $('#TabelObat').html(data);
                }
            });
        });
        //StokZtoA
        $('#StokZtoA').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#TabelObat').html(Loading);
            var Kategori ="<?php echo $Kategori;?>";
            var keyword ="<?php echo $keyword;?>";
            var OrderBy ="stok";
            var ShortBy ="DESC";
            var batas ="<?php echo $batas;?>";
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/Obat/TabelObat.php',
                data 	:  { Kategori: Kategori, keyword: keyword, OrderBy: OrderBy, ShortBy: ShortBy, batas: batas },
                success : function(data){
                    $('#TabelObat').html(data);
                }
            });
        });
        //HargaAtoZ
        $('#HargaAtoZ').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#TabelObat').html(Loading);
            var Kategori ="<?php echo $Kategori;?>";
            var keyword ="<?php echo $keyword;?>";
            var OrderBy ="harga_4";
            var ShortBy ="ASC";
            var batas ="<?php echo $batas;?>";
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/Obat/TabelObat.php',
                data 	:  { Kategori: Kategori, keyword: keyword, OrderBy: OrderBy, ShortBy: ShortBy, batas: batas },
                success : function(data){
                    $('#TabelObat').html(data);
                }
            });
        });
        //HargaZtoA
        $('#HargaZtoA').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#TabelObat').html(Loading);
            var Kategori ="<?php echo $Kategori;?>";
            var keyword ="<?php echo $keyword;?>";
            var OrderBy ="harga_4";
            var ShortBy ="DESC";
            var batas ="<?php echo $batas;?>";
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/Obat/TabelObat.php',
                data 	:  { Kategori: Kategori, keyword: keyword, OrderBy: OrderBy, ShortBy: ShortBy, batas: batas },
                success : function(data){
                    $('#TabelObat').html(data);
                }
            });
        });
    });
</script>
<div class="row">
    <div class="col-lg-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col col-md-12">
                        <div class="table-responsive" id="TabelDataBarang" style="height: 350px; overflow-y: scroll;">
                            <table class="table table-bordered table-hover table-md scroll-container">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>
                                            <div class="dropdown" onmousemove="this.style.cursor='pointer'">
                                                <div class="" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    No <i class="menu-icon mdi mdi-filter" aria-hidden="true"></i>
                                                </div>
                                                <div class="dropdown-menu border-primary" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="javascript:void(0);" id="BatasData10">10 Data</a>
                                                    <a class="dropdown-item" href="javascript:void(0);" id="BatasData25">25 Data</a>
                                                    <a class="dropdown-item" href="javascript:void(0);" id="BatasData50">50 Data</a>
                                                    <a class="dropdown-item" href="javascript:void(0);" id="BatasData100">100 Data</a>
                                                </div>
                                            </div>
                                        </th>
                                        <th>
                                            <div class="dropdown" onmousemove="this.style.cursor='pointer'">
                                                <div class="" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Kode <i class="menu-icon mdi mdi-filter" aria-hidden="true"></i>
                                                </div>
                                                <div class="dropdown-menu border-primary" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="javascript:void(0);" id="KodeObatAtoZ">0 to 9</a>
                                                    <a class="dropdown-item" href="javascript:void(0);" id="KodeObatZtoA">9 to 0</a>
                                                </div>
                                            </div>
                                        </th>
                                        <th>
                                            <div class="dropdown" onmousemove="this.style.cursor='pointer'">
                                                <div class="" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Nama/Merek <i class="menu-icon mdi mdi-filter" aria-hidden="true"></i>
                                                </div>
                                                <div class="dropdown-menu border-primary" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="javascript:void(0);" id="NamaAtoZ">A to Z</a>
                                                    <a class="dropdown-item" href="javascript:void(0);" id="NamaZtoA">Z to A</a>
                                                </div>
                                            </div>
                                        </th>
                                        <th>
                                            <select name="Kategori" id="KategoriObat" class="bg-transparent text-white border">
                                                <?php
                                                    if(empty($Kategori)){
                                                        echo '<option value="">Semua</option>';
                                                        $QueryKategori = mysqli_query($conn, "SELECT DISTINCT kategori FROM obat ORDER BY kategori ASC");
                                                        while ($DataKategori = mysqli_fetch_array($QueryKategori)) {
                                                            $NamaKategoriList = $DataKategori['kategori'];
                                                            echo '<option value="'.$NamaKategoriList.'">'.$NamaKategoriList.'</option>';
                                                        }
                                                    }else{
                                                        $QueryKategori = mysqli_query($conn, "SELECT DISTINCT kategori FROM obat ORDER BY kategori ASC");
                                                        while ($DataKategori = mysqli_fetch_array($QueryKategori)) {
                                                            $NamaKategoriList = $DataKategori['kategori'];
                                                            if($NamaKategoriList=="$Kategori"){
                                                                echo '<option value="'.$NamaKategoriList.'" selected>'.$NamaKategoriList.'</option>';
                                                            }else{
                                                                echo '<option value="'.$NamaKategoriList.'">'.$NamaKategoriList.'</option>';
                                                            }
                                                        }
                                                    }
                                                ?>
                                            </select>
                                        </th>
                                        <th>
                                            <div class="dropdown" onmousemove="this.style.cursor='pointer'">
                                                <div class="" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Stok <i class="menu-icon mdi mdi-filter" aria-hidden="true"></i>
                                                </div>
                                                <div class="dropdown-menu border-primary" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="javascript:void(0);" id="StokAtoZ">0 to 9</a>
                                                    <a class="dropdown-item" href="javascript:void(0);" id="StokZtoA">9 to 0</a>
                                                </div>
                                            </div>
                                        </th>
                                        <th>
                                            <div class="dropdown" onmousemove="this.style.cursor='pointer'">
                                                <div class="" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Harga <i class="menu-icon mdi mdi-filter" aria-hidden="true"></i>
                                                </div>
                                                <div class="dropdown-menu border-primary" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="javascript:void(0);" id="HargaAtoZ">0 to 9</a>
                                                    <a class="dropdown-item" href="javascript:void(0);" id="HargaZtoA">9 to 0</a>
                                                </div>
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $no = 1+$posisi;
                                        //KONDISI PENGATURAN MASING FILTER
                                        if(empty($Kategori)){
                                            if(empty($keyword)){
                                                $query = mysqli_query($conn, "SELECT*FROM obat ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                                            }else{
                                                $query = mysqli_query($conn, "SELECT*FROM obat WHERE nama like '%$keyword%' OR kode like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                                            }
                                        }else{
                                            if(empty($keyword)){
                                                $query = mysqli_query($conn, "SELECT*FROM obat WHERE kategori='$Kategori' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                                            }else{
                                                $query = mysqli_query($conn, "SELECT*FROM obat WHERE kategori='$Kategori' AND nama like '%$keyword%' OR kode like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                                            }
                                        }
                                        
                                        while ($data = mysqli_fetch_array($query)) {
                                            $id_obat = $data['id_obat'];
                                            $nama= $data['nama'];
                                            $kode = $data['kode'];
                                            $NamaKategori = $data['kategori'];
                                            $satuan = $data['satuan'];
                                            $stok= $data['stok'];
                                            $harga_1= $data['harga_1'];
                                            $harga_2= $data['harga_2'];
                                            $harga_3= $data['harga_3'];
                                            $harga_4= $data['harga_4'];
                                    ?>
                                    <tr tabindex="0" id="BarisDataBarang<?php echo "$no";?>" onmousemove="this.style.cursor='pointer'" data-toggle="modal" data-target="#ModalDetailObat" <?php echo "data-id='".$id_obat.",".$page.",".$batas.",".$keyword."'"; ?>>
                                        <td><?php echo "$no";?></td>
                                        <td><?php echo "$kode";?></td>
                                        <td><?php echo "$nama";?></td>
                                        <td><?php echo "$NamaKategori";?></td>
                                        <td><?php echo "$stok $satuan";?></td>
                                        <td><?php echo "Rp " . number_format($harga_4,0,',','.');?></td>
                                    </tr>
                                    <?php $no++;} ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col col-md-12">
                        <form action="javascript:void(0);" id="Paging">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-outline-secondary" id="PrevPage" <?php echo "value='".$prev.",".$batas.",".$keyword."'"; ?>>
                                    <<
                                </button>
                                <?php 
                                    //Navigasi nomor
                                    $nmr = '';
                                    if($JmlHalaman>5){
                                        if($page>=3){
                                            $a=$page-2;
                                            $b=$page+2;
                                            if($JmlHalaman<=$b){
                                                $a=$page-2;
                                                $b=$JmlHalaman;
                                            }
                                        }else{
                                            $a=1;
                                            $b=$page+2;
                                            if($JmlHalaman<=$b){
                                                $a=1;
                                                $b=$JmlHalaman;
                                            }
                                        }
                                    }else{
                                        $a=1;
                                        $b=$JmlHalaman;
                                    }
                                    for ( $i =$a; $i<=$b; $i++ ){
                                ?>
                                <button type="button" class="<?php if($i==$page){echo "btn btn-primary";}else{echo "btn btn-grey";} ?>" id="PageNumber<?php echo $i;?>" <?php echo "value='".$i.",".$batas.",".$keyword."'"; ?>>
                                    <?php echo $i;?>
                                </button>
                                <?php 
                                    }
                                ?>
                                <button type="button" class="btn btn-outline-secondary" id="NextPage" <?php echo "value='".$next.",".$batas.",".$keyword."'"; ?>>
                                    >>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
