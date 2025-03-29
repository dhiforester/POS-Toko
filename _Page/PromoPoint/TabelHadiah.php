<?php
    //koneksi dan error
    ini_set("display_errors","off");
    include "../../_Config/Connection.php";
    //Atur Batas
    if(!empty($_POST['batas'])){
        $batas=$_POST['batas'];
    }else{
        $batas="50";
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
    //Atur Keyword
    if(isset($_POST['OrderBy'])){
        $OrderBy=$_POST['OrderBy'];
    }else{
        $OrderBy="nama";
    }
    //Atur Keyword
    if(isset($_POST['ShortBy'])){
        $ShortBy=$_POST['ShortBy'];
    }else{
        $ShortBy="DESC";
    }
    //hitung jumlah data
    if(empty($keyword)){
        $jml_data = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM hadiah"));
    }else{
        $jml_data = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM hadiah WHERE nama like '%$keyword%' OR kode like '%$keyword%'"));
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
        $('#ReloadHadiah').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#TabelHadiah').html(Loading);
            $('#TabelHadiah').load('_Page/PromoPoint/TabelHadiah.php');
        });
        //Pencarian
        $('#PencarianHadiah').submit(function(){
            var PencarianHadiah = $('#PencarianHadiah').serialize();
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/PromoPoint/TabelHadiah.php',
                data    : PencarianHadiah,
                success : function(data){
                    $('#TabelHadiah').html(data);
                }
            });
        });
        //FILTER AND SHORTING
        //BatasData
        $('#BatasData10').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#TabelHadiah').html(Loading);
            var keyword ="<?php echo $keyword;?>";
            var OrderBy ="<?php echo $OrderBy;?>";
            var ShortBy ="<?php echo $ShortBy;?>";
            var batas ="10";
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/PromoPoint/TabelHadiah.php',
                data 	:  { keyword: keyword, OrderBy: OrderBy, ShortBy: ShortBy, batas: batas },
                success : function(data){
                    $('#TabelHadiah').html(data);
                }
            });
        });
        $('#BatasData25').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#TabelHadiah').html(Loading);
            var keyword ="<?php echo $keyword;?>";
            var OrderBy ="<?php echo $OrderBy;?>";
            var ShortBy ="<?php echo $ShortBy;?>";
            var batas ="25";
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/PromoPoint/TabelHadiah.php',
                data 	:  { keyword: keyword, OrderBy: OrderBy, ShortBy: ShortBy, batas: batas },
                success : function(data){
                    $('#TabelHadiah').html(data);
                }
            });
        });
        $('#BatasData50').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#TabelHadiah').html(Loading);
            var keyword ="<?php echo $keyword;?>";
            var OrderBy ="<?php echo $OrderBy;?>";
            var ShortBy ="<?php echo $ShortBy;?>";
            var batas ="50";
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/PromoPoint/TabelHadiah.php',
                data 	:  { keyword: keyword, OrderBy: OrderBy, ShortBy: ShortBy, batas: batas },
                success : function(data){
                    $('#TabelHadiah').html(data);
                }
            });
        });
        $('#BatasData100').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#TabelHadiah').html(Loading);
            var keyword ="<?php echo $keyword;?>";
            var OrderBy ="<?php echo $OrderBy;?>";
            var ShortBy ="<?php echo $ShortBy;?>";
            var batas ="100";
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/PromoPoint/TabelHadiah.php',
                data 	:  { keyword: keyword, OrderBy: OrderBy, ShortBy: ShortBy, batas: batas },
                success : function(data){
                    $('#TabelHadiah').html(data);
                }
            });
        });
        //KodeAtoZ
        $('#KodeAtoZ').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#TabelHadiah').html(Loading);
            var keyword ="<?php echo $keyword;?>";
            var OrderBy ="kode";
            var ShortBy ="ASC";
            var batas ="<?php echo $batas;?>";
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/PromoPoint/TabelHadiah.php',
                data 	:  { keyword: keyword, OrderBy: OrderBy, ShortBy: ShortBy, batas: batas },
                success : function(data){
                    $('#TabelHadiah').html(data);
                }
            });
        });
        //KodeZtoA
        $('#KodeZtoA').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#TabelHadiah').html(Loading);
            var keyword ="<?php echo $keyword;?>";
            var OrderBy ="kode";
            var ShortBy ="DESC";
            var batas ="<?php echo $batas;?>";
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/PromoPoint/TabelHadiah.php',
                data 	:  { keyword: keyword, OrderBy: OrderBy, ShortBy: ShortBy, batas: batas },
                success : function(data){
                    $('#TabelHadiah').html(data);
                }
            });
        });
        //NamaAtoZ
        $('#NamaAtoZ').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#TabelHadiah').html(Loading);
            var keyword ="<?php echo $keyword;?>";
            var OrderBy ="nama";
            var ShortBy ="ASC";
            var batas ="<?php echo $batas;?>";
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/PromoPoint/TabelHadiah.php',
                data 	:  { keyword: keyword, OrderBy: OrderBy, ShortBy: ShortBy, batas: batas },
                success : function(data){
                    $('#TabelHadiah').html(data);
                }
            });
        });
        //NamaZtoA
        $('#NamaZtoA').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#TabelHadiah').html(Loading);
            var keyword ="<?php echo $keyword;?>";
            var OrderBy ="nama";
            var ShortBy ="DESC";
            var batas ="<?php echo $batas;?>";
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/PromoPoint/TabelHadiah.php',
                data 	:  { keyword: keyword, OrderBy: OrderBy, ShortBy: ShortBy, batas: batas },
                success : function(data){
                    $('#TabelHadiah').html(data);
                }
            });
        });
        //PointAtoZ
        $('#PointAtoZ').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#TabelHadiah').html(Loading);
            var keyword ="<?php echo $keyword;?>";
            var OrderBy ="point";
            var ShortBy ="ASC";
            var batas ="<?php echo $batas;?>";
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/PromoPoint/TabelHadiah.php',
                data 	:  { keyword: keyword, OrderBy: OrderBy, ShortBy: ShortBy, batas: batas },
                success : function(data){
                    $('#TabelHadiah').html(data);
                }
            });
        });
        //PointZtoA
        $('#PointZtoA').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#TabelHadiah').html(Loading);
            var keyword ="<?php echo $keyword;?>";
            var OrderBy ="point";
            var ShortBy ="DESC";
            var batas ="<?php echo $batas;?>";
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/PromoPoint/TabelHadiah.php',
                data 	:  { keyword: keyword, OrderBy: OrderBy, ShortBy: ShortBy, batas: batas },
                success : function(data){
                    $('#TabelHadiah').html(data);
                }
            });
        });
        //ketika Modal Delete muncul
        $('#ModalDeleteHadiah').on('show.bs.modal', function (e) {
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#FormDeleteHadiah').html(Loading);
            var id_hadiah = $(e.relatedTarget).data('id');
            $.ajax({
                url     : "_Page/PromoPoint/FormDeleteHadiah.php",
                method  : "POST",
                data    : { id_hadiah: id_hadiah },
                success: function (data) {
                    $('#FormDeleteHadiah').html(data);
                    //Ketika disetujui delete
                    $('#ProsesDeleteHadiah').submit(function(){
                        var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
                        $('#NotifikasiDeleteHadiah').html(Loading);
                        var ProsesDeleteHadiah = $('#ProsesDeleteHadiah').serialize();
                        $.ajax({
                            type 	: 'POST',
                            url 	: '_Page/PromoPoint/ProsesDeleteHadiah.php',
                            data 	:  ProsesDeleteHadiah,
                            success : function(data){
                                $('#NotifikasiDeleteHadiah').html(data);
                                //menangkap keterangan notifikasi
                                var Notifikasi=$('#NotifikasiDeleteHadiahBerhasil').html();
                                if(Notifikasi=="Berhasil"){
                                    $('#TabelHadiah').load('_Page/PromoPoint/TabelHadiah.php');
                                    $('#ModalDeleteHadiah').modal('hide');
                                    $('#ModalDeleteHadiahBerhasil').modal('show');
                                }
                            }
                        });
                    });
                }
            })
        });
        //ketika klik next
        $('#NextPage').click(function() {
            var valueNext = $('#NextPage').val();
            var mode = valueNext.split(',');
            var page = mode[0];
            var BatasData = mode[1];
            $.ajax({
                url     : "_Page/PromoPoint/TabelHadiah.php",
                method  : "POST",
                data    : { page: page, BatasData: BatasData },
                success: function (data) {
                    $('#TabelHadiah').html(data);

                }
            })
        });
        //Ketika klik Previous
        $('#PrevPage').click(function() {
            var ValuePrev = $('#PrevPage').val();
            var mode = ValuePrev.split(',');
            var page = mode[0];
            var BatasData = mode[1];
            $.ajax({
                url     : "_Page/PromoPoint/TabelHadiah.php",
                method  : "POST",
                data    : { page: page, BatasData: BatasData },
                success: function (data) {
                    $('#TabelHadiah').html(data);

                }
            })
        });
        <?php 
            $a=1;
            $b=$JmlHalaman;
            for ( $i =$a; $i<=$b; $i++ ){
        ?>
            //ketika klik page number
            $('#PageNumber<?php echo $i;?>').click(function() {
                var PageNumber = $('#PageNumber<?php echo $i;?>').val();
                var mode = PageNumber.split(',');
                var page = mode[0];
                var BatasData = mode[1];
                $.ajax({
                    url     : "_Page/PromoPoint/TabelHadiah.php",
                    method  : "POST",
                    data    : { page: page, BatasData: BatasData },
                    success: function (data) {
                        $('#TabelHadiah').html(data);

                    }
                })
            });
        <?php } ?>
    });
</script>
<div class="card-body">
    <div class="table-responsive" style="height: 350px; overflow-y: scroll;">
        <table class="table table-hover table-bordered scroll-container">
            <thead class="thead-dark">
                <tr>
                    <th>
                        <div class="dropdown" onmousemove="this.style.cursor='pointer'">
                            <div class="" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                No <i class="menu-icon mdi mdi-menu-down" aria-hidden="true"></i>
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
                                Kode <i class="menu-icon mdi mdi-menu-down" aria-hidden="true"></i>
                            </div>
                            <div class="dropdown-menu border-primary" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="javascript:void(0);" id="KodeAtoZ">0 to 9</a>
                                <a class="dropdown-item" href="javascript:void(0);" id="KodeZtoA">9 to 0</a>
                            </div>
                        </div>
                    </th>
                    <th>
                        <div class="dropdown" onmousemove="this.style.cursor='pointer'">
                            <div class="" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Nama/Merek <i class="menu-icon mdi mdi-menu-down" aria-hidden="true"></i>
                            </div>
                            <div class="dropdown-menu border-primary" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="javascript:void(0);" id="NamaAtoZ">A to Z</a>
                                <a class="dropdown-item" href="javascript:void(0);" id="NamaZtoA">Z to A</a>
                            </div>
                        </div>
                    </th>
                    <th>Stok</th>
                    <th>
                        <div class="dropdown" onmousemove="this.style.cursor='pointer'">
                            <div class="" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Point <i class="menu-icon mdi mdi-menu-down" aria-hidden="true"></i>
                            </div>
                            <div class="dropdown-menu border-primary" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="javascript:void(0);" id="PointAtoZ">0 to 9</a>
                                <a class="dropdown-item" href="javascript:void(0);" id="PointZtoA">9 to 0</a>
                            </div>
                        </div>
                    </th>
                    <th>Option</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $no = 1+$posisi;
                    //KONDISI PENGATURAN MASING FILTER
                    if(empty($keyword)){
                        $query = mysqli_query($conn, "SELECT*FROM hadiah ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                    }else{
                        $query = mysqli_query($conn, "SELECT*FROM hadiah WHERE nama like '%$keyword%' OR kode like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                    }
                    while ($data = mysqli_fetch_array($query)) {
                        $id_hadiah = $data['id_hadiah'];
                        $id_barang = $data['id_barang'];
                        $nama= $data['nama'];
                        $kode = $data['kode'];
                        $point = $data['point'];
                        //Buka data barang
                        $QryObat = mysqli_query($conn, "SELECT * FROM obat WHERE id_obat='$id_barang'")or die(mysqli_error($conn));
                        $DataObat = mysqli_fetch_array($QryObat);
                        $satuan = $DataObat['satuan'];
                        $stok= $DataObat['stok'];
                ?>
                <tr>
                    <td><?php echo "$no";?></td>
                    <td><?php echo "$kode";?></td>
                    <td><?php echo "$nama";?></td>
                    <td><?php echo "$stok $satuan";?></td>
                    <td><?php echo "" . number_format($point,0,',','.');?></td>
                    <td align="center" width="10%">
                        <div class="btn-group">
                            <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#ModalEditHadiah" <?php echo "data-id='".$id_hadiah.",".$page.",".$batas."'"; ?>>
                                <i class="menu-icon mdi mdi-pencil" aria-hidden="true"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#ModalDeleteHadiah" data-id="<?php echo $id_hadiah;?>">
                                <i class="menu-icon mdi mdi-delete" aria-hidden="true"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php $no++;} ?>
            </tbody>
        </table>
    </div>
</div>
<div class="card-body">
    <div class="row">
        <div class="col col-lg-12">
            <form action="javascript:void(0);" id="Paging">
                <div class="btn-group" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-outline-secondary" id="PrevPage" <?php echo "value='".$prev.",".$batas."'"; ?>>
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
                    <button type="button" class="<?php if($i==$page){echo "btn btn-primary";}else{echo "btn btn-grey";} ?>" id="PageNumber<?php echo $i;?>" <?php echo "value='".$i.",".$batas."'"; ?>>
                        <?php echo $i;?>
                    </button>
                    <?php 
                        }
                    ?>
                    <button type="button" class="btn btn-outline-secondary" id="NextPage" <?php echo "value='".$next.",".$batas."'"; ?>>
                        >>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>