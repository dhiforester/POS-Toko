<?php
    //koneksi dan error
    ini_set("display_errors","off");
    include "../../_Config/Connection.php";
    //Atur Batas
    if(!empty($_POST['batas'])){
        $batas=$_POST['batas'];
    }else{
        $batas="10";
    }
    //Atur Page
    if(!empty($_POST['page'])){
        $page=$_POST['page'];
        $posisi = ( $page - 1 ) * $batas;
    }else{
        $page="1";
        $posisi = 0;
    }
    //Atur Kategori
    if(!empty($_POST['Kategori'])){
        $Kategori=$_POST['Kategori'];
    }else{
        $Kategori="";
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
        $OrderBy="id_member";
    }
    //Atur ShortBy
    if(isset($_POST['ShortBy'])){
        $ShortBy=$_POST['ShortBy'];
    }else{
        $ShortBy="DESC";
    }
    //hitung jumlah data
    if(empty($Kategori)){
        if(empty($keyword)){
            $jml_data = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM member"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM member WHERE nama like '%$keyword%' OR nik like '%$keyword%' OR kategori like '%$keyword%'"));
        }
    }else{
        if(empty($keyword)){
            $jml_data = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM member WHERE kategori='$Kategori'"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM member WHERE kategori='$Kategori' AND nama like '%$keyword%' OR nik like '%$keyword%' OR kategori like '%$keyword%'"));
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
        //ReloadMember
        $('#ReloadMember').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#TabelMember').html(Loading);
            $('#TabelMember').load('_Page/Member/TabelMember.php');
        });
        //BatasData
        $('#BatasData10').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#TabelMember').html(Loading);
            var Kategori ="<?php echo $kategori;?>";
            var keyword ="<?php echo $keyword;?>";
            var OrderBy ="<?php echo $OrderBy;?>";
            var ShortBy ="<?php echo $ShortBy;?>";
            var batas ="10";
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/Member/TabelMember.php',
                data 	:  {Kategori: Kategori, keyword: keyword, OrderBy: OrderBy, ShortBy: ShortBy, batas: batas},
                success : function(data){
                    $('#TabelMember').html(data);
                }
            });
        });
        $('#BatasData25').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#TabelMember').html(Loading);
            var Kategori ="<?php echo $kategori;?>";
            var keyword ="<?php echo $keyword;?>";
            var OrderBy ="<?php echo $OrderBy;?>";
            var ShortBy ="<?php echo $ShortBy;?>";
            var batas ="25";
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/Member/TabelMember.php',
                data 	:  {Kategori: Kategori, keyword: keyword, OrderBy: OrderBy, ShortBy: ShortBy, batas: batas},
                success : function(data){
                    $('#TabelMember').html(data);
                }
            });
        });
        $('#BatasData50').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#TabelMember').html(Loading);
            var Kategori ="<?php echo $kategori;?>";
            var keyword ="<?php echo $keyword;?>";
            var OrderBy ="<?php echo $OrderBy;?>";
            var ShortBy ="<?php echo $ShortBy;?>";
            var batas ="50";
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/Member/TabelMember.php',
                data 	:  {Kategori: Kategori, keyword: keyword, OrderBy: OrderBy, ShortBy: ShortBy, batas: batas},
                success : function(data){
                    $('#TabelMember').html(data);
                }
            });
        });
        $('#BatasData100').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#TabelMember').html(Loading);
            var Kategori ="<?php echo $kategori;?>";
            var keyword ="<?php echo $keyword;?>";
            var OrderBy ="<?php echo $OrderBy;?>";
            var ShortBy ="<?php echo $ShortBy;?>";
            var batas ="100";
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/Member/TabelMember.php',
                data 	:  {Kategori: Kategori, keyword: keyword, OrderBy: OrderBy, ShortBy: ShortBy, batas: batas},
                success : function(data){
                    $('#TabelMember').html(data);
                }
            });
        });
        //NamaMemberAtoZ
        $('#NamaMemberAtoZ').click(function() {
            var Kategori ="<?php echo $kategori;?>";
            var keyword ="<?php echo $keyword;?>";
            var OrderBy ="nama";
            var ShortBy ="ASC";
            var batas ="<?php echo $batas;?>";
            $.ajax({
                url     : "_Page/Member/TabelMember.php",
                method  : "POST",
                data 	:  {Kategori: Kategori, keyword: keyword, OrderBy: OrderBy, ShortBy: ShortBy, batas: batas},
                success: function (data) {
                    $('#TabelMember').html(data);
                }
            })
        });
        //NamaMemberZtoA
        $('#NamaMemberZtoA').click(function() {
            var Kategori ="<?php echo $kategori;?>";
            var keyword ="<?php echo $keyword;?>";
            var OrderBy ="nama";
            var ShortBy ="DESC";
            var batas ="<?php echo $batas;?>";
            $.ajax({
                url     : "_Page/Member/TabelMember.php",
                method  : "POST",
                data 	:  {Kategori: Kategori, keyword: keyword, OrderBy: OrderBy, ShortBy: ShortBy, batas: batas},
                success: function (data) {
                    $('#TabelMember').html(data);
                }
            })
        });
        //PointMemberAtoZ
        $('#PointMemberAtoZ').click(function() {
            var Kategori ="<?php echo $kategori;?>";
            var keyword ="<?php echo $keyword;?>";
            var OrderBy ="point";
            var ShortBy ="ASC";
            var batas ="<?php echo $batas;?>";
            $.ajax({
                url     : "_Page/Member/TabelMember.php",
                method  : "POST",
                data 	:  {Kategori: Kategori, keyword: keyword, OrderBy: OrderBy, ShortBy: ShortBy, batas: batas},
                success: function (data) {
                    $('#TabelMember').html(data);
                }
            })
        });
        //PointMemberZtoA
        $('#PointMemberZtoA').click(function() {
            var Kategori ="<?php echo $kategori;?>";
            var keyword ="<?php echo $keyword;?>";
            var OrderBy ="point";
            var ShortBy ="DESC";
            var batas ="<?php echo $batas;?>";
            $.ajax({
                url     : "_Page/Member/TabelMember.php",
                method  : "POST",
                data 	:  {Kategori: Kategori, keyword: keyword, OrderBy: OrderBy, ShortBy: ShortBy, batas: batas},
                success: function (data) {
                    $('#TabelMember').html(data);
                }
            })
        });
        //PilihSemua
        $('#PilihSemua').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#TabelMember').html(Loading);
            var Kategori ="";
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/Member/TabelMember.php',
                data 	:  'Kategori='+ Kategori,
                success : function(data){
                    $('#TabelMember').html(data);
                }
            });
        });
        //PilihKonsumen
        $('#PilihKonsumen').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#TabelMember').html(Loading);
            var keyword ="Konsumen";
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/Member/TabelMember.php',
                data 	:  'Kategori='+ keyword,
                success : function(data){
                    $('#TabelMember').html(data);
                }
            });
        });
        //PilihSupplier
        $('#PilihSupplier').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#TabelMember').html(Loading);
            var keyword ="Supplier";
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/Member/TabelMember.php',
                data 	:  'Kategori='+ keyword,
                success : function(data){
                    $('#TabelMember').html(data);
                }
            });
        });
        //ketika Modal Delete muncul
        $('#ModalDeleteMember').on('show.bs.modal', function (e) {
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#FormDeleteMember').html(Loading);
            var IdMember = $(e.relatedTarget).data('id');
            $.ajax({
                url     : "_Page/Member/FormDeleteMember.php",
                method  : "POST",
                data    : { IdMember: IdMember },
                success: function (data) {
                    $('#FormDeleteMember').html(data);
                    //Ketika disetujui delete
                    $('#ProsesDeleteMember').submit(function(){
                        var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
                        $('#NotifikasiDeleteMember').html(Loading);
                        var ProsesDeleteMember = $('#ProsesDeleteMember').serialize();
                        $.ajax({
                            type 	: 'POST',
                            url 	: '_Page/Member/ProsesDeleteMember.php',
                            data 	:  ProsesDeleteMember,
                            success : function(data){
                                $('#NotifikasiDeleteMember').html(data);
                                //menangkap keterangan notifikasi
                                var Notifikasi=$('#NotifikasiDeleteMemberBerhasil').html();
                                if(Notifikasi=="Berhasil"){
                                    $('#Halaman').load('_Page/Member/Member.php');
                                    $('#ModalDeleteMember').modal('hide');
                                    $('#ModalDeleteMemberBerhasil').modal('show');
                                }
                            }
                        });
                    });
                }
            })
        });
        $('#ModalDetailMember').on('show.bs.modal', function (e) {
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#DetailMember').html(Loading);
            var IdMember = $(e.relatedTarget).data('id');
            $.ajax({
                url     : "_Page/Member/DetailMember.php",
                method  : "POST",
                data    : { IdMember: IdMember },
                success: function (data) {
                    $('#DetailMember').html(data);
                }
            })
        });
        <?php 
            $a=1;
            $b=$jml_data;
            for ( $i =$a; $i<=$b; $i++ ){
        ?>
            $('#EditMember<?php echo "$i";?>').click(function() {
                var EditMember = $('#EditMember<?php echo $i;?>').val();
                var mode = EditMember.split(',');
                var IdMember = mode[0];
                var page = mode[1];
                var BatasData = mode[2];
                $.ajax({
                    url     : "_Page/Member/EditMember.php",
                    method  : "POST",
                    data    : { page: page, IdMember: IdMember, BatasData: BatasData, },
                    success: function (data) {
                        $('#Halaman').html(data);

                    }
                })
            });
        <?php } ?>
        //ketika klik next
        $('#NextPage').click(function() {
            var valueNext = $('#NextPage').val();
            var mode = valueNext.split(',');
            var page = mode[0];
            var BatasData = mode[1];
            $.ajax({
                url     : "_Page/Member/TabelMember.php",
                method  : "POST",
                data    : { page: page, BatasData: BatasData },
                success: function (data) {
                    $('#TabelMember').html(data);

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
                url     : "_Page/Member/TabelMember.php",
                method  : "POST",
                data    : { page: page, BatasData: BatasData },
                success : function (data) {
                    $('#TabelMember').html(data);
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
                    url     : "_Page/Member/TabelMember.php",
                    method  : "POST",
                    data    : { page: page, BatasData: BatasData },
                    success: function (data) {
                        $('#TabelMember').html(data);
                    }
                })
            });
        <?php } ?>
        
    });
</script>
<div class="card-body" style="height: 350px; overflow-y: scroll;">
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
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
                    <th>ID Member</th>
                    <th>
                        <div class="dropdown" onmousemove="this.style.cursor='pointer'">
                            <div class="" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Nama <i class="menu-icon mdi mdi-filter" aria-hidden="true"></i>
                            </div>
                            <div class="dropdown-menu border-primary" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="javascript:void(0);" id="NamaMemberAtoZ">A to Z</a>
                                <a class="dropdown-item" href="javascript:void(0);" id="NamaMemberZtoA">Z to A</a>
                            </div>
                        </div>
                    </th>
                    <th>
                        <div class="dropdown" onmousemove="this.style.cursor='pointer'">
                            <div class="" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Point <i class="menu-icon mdi mdi-filter" aria-hidden="true"></i>
                            </div>
                            <div class="dropdown-menu border-primary" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="javascript:void(0);" id="PointMemberAtoZ">0 to 9</a>
                                <a class="dropdown-item" href="javascript:void(0);" id="PointMemberZtoA">9 to 0</a>
                            </div>
                        </div>
                    </th>
                    <th>
                        <div class="dropdown" onmousemove="this.style.cursor='pointer'">
                            <div class="" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Kategori <i class="menu-icon mdi mdi-filter" aria-hidden="true"></i>
                            </div>
                            <div class="dropdown-menu border-primary" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="javascript:void(0);" id="PilihSemua">Semua</a>
                                <a class="dropdown-item" href="javascript:void(0);" id="PilihKonsumen">Konsumen</a>
                                <a class="dropdown-item" href="javascript:void(0);" id="PilihSupplier">Supplier</a>
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
                    if(empty($Kategori)){
                        if(empty($keyword)){
                            $query = mysqli_query($conn, "SELECT*FROM member ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                        }else{
                            $query = mysqli_query($conn, "SELECT*FROM member WHERE nama like '%$keyword%' OR nik like '%$keyword%' OR kategori like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                        }
                    }else{
                        if(empty($keyword)){
                            $query = mysqli_query($conn, "SELECT*FROM member WHERE kategori='$Kategori' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                        }else{
                            $query = mysqli_query($conn, "SELECT*FROM member WHERE kategori='$Kategori' AND nama like '%$keyword%' OR nik like '%$keyword%' OR kategori like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                        }   
                    }
                    while ($data = mysqli_fetch_array($query)) {
                        $id_member = $data['id_member'];
                        $nama= $data['nama'];
                        $nik = $data['nik'];
                        $point = $data['point'];
                        $kategori = $data['kategori'];
                ?>
                <tr>
                    <td><?php echo "$no";?></td>
                    <td><?php echo "$nik";?></td>
                    <td><?php echo "$nama";?></td>
                    <td><?php echo "$point";?></td>
                    <td><?php echo "$kategori";?></td>
                    <td align="center" width="10%">
                        <div class="btn-group">
                            <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#ModalDetailMember" data-id="<?php echo $id_member;?>">
                                <i class="menu-icon mdi mdi-account-outline" aria-hidden="true"></i>
                            </button>
                            <button class="btn btn-sm btn-warning" id="EditMember<?php echo "$no";?>" <?php echo "value='".$id_member.",".$page.",".$batas."'"; ?>>
                                <i class="menu-icon mdi mdi-pencil" aria-hidden="true"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#ModalDeleteMember" data-id="<?php echo $id_member;?>">
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