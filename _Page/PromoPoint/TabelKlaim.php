<?php
    //koneksi dan error
    ini_set("display_errors","off");
    include "../../_Config/Connection.php";
    //Atur Batas
    if(isset($_POST['batas'])){
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
    if(isset($_POST['KeywordKlaim'])){
        $keyword=$_POST['KeywordKlaim'];
    }else{
        $keyword="";
    }
    //hitung jumlah data
    if(empty($keyword)){
        $jml_data = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM klaim"));
    }else{
        $jml_data = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM klaim WHERE tanggal like '%$keyword%' OR nama_member like '%$keyword%' OR nama_hadiah like '%$keyword%'"));
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
        $('#ReloadKlaim').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#TabelKlaim').html(Loading);
            $('#TabelKlaim').load('_Page/PromoPoint/TabelKlaim.php');
        });
        //ketika Modal Delete muncul
        $('#ModalDeleteKlaim').on('show.bs.modal', function (e) {
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#FormDeleteKlaim').html(Loading);
            var id_klaim = $(e.relatedTarget).data('id');
            $.ajax({
                url     : "_Page/PromoPoint/FormDeleteKlaim.php",
                method  : "POST",
                data    : { id_klaim: id_klaim },
                success: function (data) {
                    $('#FormDeleteKlaim').html(data);
                    //Ketika disetujui delete
                    $('#ProsesDeleteKlaim').submit(function(){
                        var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
                        $('#NotifikasiDeleteKlaim').html(Loading);
                        var ProsesDeleteKlaim = $('#ProsesDeleteKlaim').serialize();
                        $.ajax({
                            type 	: 'POST',
                            url 	: '_Page/PromoPoint/ProsesDeleteKlaim.php',
                            data 	:  ProsesDeleteKlaim,
                            success : function(data){
                                $('#NotifikasiDeleteKlaim').html(data);
                                //menangkap keterangan notifikasi
                                var Notifikasi=$('#NotifikasiDeleteKlaimBerhasil').html();
                                if(Notifikasi=="Berhasil"){
                                    $('#TabelKlaim').load('_Page/PromoPoint/TabelKlaim.php');
                                    $('#ModalDeleteKlaim').modal('hide');
                                    $('#ModalDeleteKlaimBerhasil').modal('show');
                                }
                            }
                        });
                    });
                }
            })
        });
        //ketika Modal Detail Klaim muncul
        $('#ModalDetailKlaim').on('show.bs.modal', function (e) {
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#DetailKlaim').html(Loading);
            var id_klaim = $(e.relatedTarget).data('id');
            $.ajax({
                url     : "_Page/PromoPoint/DetailKlaim.php",
                method  : "POST",
                data    : { id_klaim: id_klaim },
                success: function (data) {
                    $('#DetailKlaim').html(data);
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
                url     : "_Page/PromoPoint/TabelKlaim.php",
                method  : "POST",
                data    : { page: page, BatasData: BatasData },
                success: function (data) {
                    $('#TabelKlaim').html(data);

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
                url     : "_Page/PromoPoint/TabelKlaim.php",
                method  : "POST",
                data    : { page: page, BatasData: BatasData },
                success: function (data) {
                    $('#TabelKlaim').html(data);

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
                    url     : "_Page/PromoPoint/TabelKlaim.php",
                    method  : "POST",
                    data    : { page: page, BatasData: BatasData },
                    success: function (data) {
                        $('#TabelKlaim').html(data);

                    }
                })
            });
        <?php } ?>
    });
</script>
<div class="card-body">
    <div class="table-responsive" style="height: 350px; overflow-y: scroll;">
        <table class="table table-hover table-responsive table-bordered scroll-container">
            <thead class="thead-dark">
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Hadiah</th>
                    <th>Member</th>
                    <th>Point</th>
                    <th>Option</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $no = 1+$posisi;
                    //KONDISI PENGATURAN MASING FILTER
                    if(empty($keyword)){
                        $query = mysqli_query($conn, "SELECT*FROM klaim ORDER BY id_klaim DESC LIMIT $posisi, $batas");
                    }else{
                        $query = mysqli_query($conn, "SELECT*FROM klaim WHERE tanggal like '%$keyword%' OR nama_member like '%$keyword%' OR nama_hadiah like '%$keyword%' ORDER BY id_klaim DESC LIMIT $posisi, $batas");
                    }
                    while ($data = mysqli_fetch_array($query)) {
                        $id_klaim = $data['id_klaim'];
                        $id_hadiah = $data['id_hadiah'];
                        $id_member = $data['id_member'];
                        $nama_hadiah = $data['nama_hadiah'];
                        $nama_member = $data['nama_member'];
                        $tanggal = $data['tanggal'];
                        $qty= $data['qty'];
                        $point = $data['point'];
                        //Buka data hadiah
                        $QryHadiah = mysqli_query($conn, "SELECT * FROM hadiah WHERE id_hadiah='$id_hadiah'")or die(mysqli_error($conn));
                        $DataHadiah = mysqli_fetch_array($QryHadiah);
                        $KodeHadiah = $DataHadiah['kode'];
                        $NamaHadiah = $DataHadiah['nama'];
                        //Buka data member
                        $Qrymember = mysqli_query($conn, "SELECT * FROM member WHERE id_member='$id_member'")or die(mysqli_error($conn));
                        $DataMember = mysqli_fetch_array($Qrymember);
                        $NamaMember = $DataMember['nama'];
                ?>
                <tr>
                    <td><?php echo "$no";?></td>
                    <td><?php echo "$tanggal";?></td>
                    <td><?php echo "$NamaHadiah";?></td>
                    <td><?php echo "$NamaMember";?></td>
                    <td><?php echo "" . number_format($point,0,',','.');?></td>
                    <td align="center" width="10%">
                        <div class="btn-group">
                            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#ModalDetailKlaim" data-id="<?php echo $id_klaim;?>">
                                <i class="menu-icon mdi mdi-note" aria-hidden="true"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#ModalDeleteKlaim" data-id="<?php echo $id_klaim;?>">
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