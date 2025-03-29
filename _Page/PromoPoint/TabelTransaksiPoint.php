<?php
    //koneksi dan error
    ini_set("display_errors","off");
    include "../../_Config/Connection.php";
    //Atur Batas
    $batas="50";
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
    //hitung jumlah data
    if(empty($keyword)){
        $jml_data = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM pemberian_point"));
    }else{
        $jml_data = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM pemberian_point WHERE tanggal like '%$keyword%' OR kode_transaksi like '%$keyword%'"));
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
        $('#ReloadTransaksiPoint').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#TabelTransaksiPoint').html(Loading);
            $('#TabelTransaksiPoint').load('_Page/PromoPoint/TabelTransaksiPoint.php');
        });
        $('#ModalDetailLogTransaksi').on('show.bs.modal', function (e) {
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#DetailLogTransaksi').html(Loading);
            var kode_transaksi = $(e.relatedTarget).data('id');
            var JenisTransaksi ="penjualan";
            var page ="";
            var NewOrEdit="Edit";
            $.ajax({
                url     : "_Page/Transaksi/DetailTransaksi.php",
                method  : "POST",
                data    : { NewOrEdit: NewOrEdit, kode_transaksi: kode_transaksi, JenisLaporan: JenisTransaksi },
                success: function (data) {
                    $('#DetailLogTransaksi').html(data);
                    $('#EditTransaksi').click(function() {
                        $('#ModalDetailLogTransaksi').modal('hide');
                        $('#Halaman').html(Loading);
                        var Detail = $('#EditTransaksi').val();
                        var mode = Detail.split(',');
                        var NewOrEdit = mode[0];
                        var kode_transaksi = mode[1];
                        $.ajax({
                            url     : "_Page/Kasir/Kasir.php",
                            method  : "POST",
                            data    : { NewOrEdit: NewOrEdit, kode_transaksi: kode_transaksi, },
                            success: function (data) {
                                $('#Halaman').html(data);
                            }
                        })
                    });
                    $('#DeleteTransaksi').click(function() {
                        $('#Notifikasi').html(Loading);
                        $.ajax({
                            url     : "_Page/PromoPoint/ProsesDeletePemberian_point.php",
                            method  : "POST",
                            data    : { kode_transaksi: kode_transaksi },
                            success: function (data) {
                                $('#Notifikasi').html(data);
                                var NotifikasiBerhasil = $('#NotifikasiHapus').html();
                                if(NotifikasiBerhasil=="Berhasil"){
                                    $('#ModalDetailLogTransaksi').modal('hide');
                                    $('#TabelTransaksiPoint').html(Loading);
                                    $('#TabelTransaksiPoint').load('_Page/PromoPoint/TabelTransaksiPoint.php');
                                }
                            }
                        })
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
                url     : "_Page/PromoPoint/TabelTransaksiPoint.php",
                method  : "POST",
                data    : { page: page, BatasData: BatasData },
                success: function (data) {
                    $('#TabelTransaksiPoint').html(data);

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
                url     : "_Page/PromoPoint/TabelTransaksiPoint.php",
                method  : "POST",
                data    : { page: page, BatasData: BatasData },
                success: function (data) {
                    $('#TabelTransaksiPoint').html(data);

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
                    url     : "_Page/PromoPoint/TabelTransaksiPoint.php",
                    method  : "POST",
                    data    : { page: page, BatasData: BatasData },
                    success: function (data) {
                        $('#TabelTransaksiPoint').html(data);

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
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Transaksi</th>
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
                        $query = mysqli_query($conn, "SELECT*FROM pemberian_point ORDER BY id_pemberian_point DESC LIMIT $posisi, $batas");
                    }else{
                        $query = mysqli_query($conn, "SELECT*FROM pemberian_point WHERE tanggal like '%$keyword%' OR kode_transaksi like '%$keyword%' ORDER BY id_pemberian_point DESC LIMIT $posisi, $batas");
                    }
                    while ($data = mysqli_fetch_array($query)) {
                        $tanggal = $data['tanggal'];
                        $kode_transaksi = $data['kode_transaksi'];
                        $id_member= $data['id_member'];
                        $point = $data['point'];
                        //Buka data Member
                        $QryMember = mysqli_query($conn, "SELECT * FROM member WHERE id_member='$id_member'")or die(mysqli_error($conn));
                        $DataMember = mysqli_fetch_array($QryMember);
                        $NamaMember = $DataMember['nama'];
                ?>
                <tr>
                    <td><?php echo "$no";?></td>
                    <td><?php echo "$tanggal";?></td>
                    <td><?php echo "$kode_transaksi";?></td>
                    <td><?php echo "$NamaMember";?></td>
                    <td><?php echo "" . number_format($point,0,',','.');?></td>
                    <td>
                        <div class="btn-group">
                            <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#ModalDetailLogTransaksi" data-id="<?php echo "$kode_transaksi";?>">
                                Detail
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