<?php
    //koneksi dan error
    ini_set("display_errors","off");
    include "../../_Config/Connection.php";
    //Atur Batas
    $batas="50";
    //Tangkap Jenis Transaksi
    if(!empty($_POST['JenisTransaksi'])){
        $JenisTransaksi=$_POST['JenisTransaksi'];
    }else{
        $JenisTransaksi="";
    }
    //Atur Keyword
    if(isset($_POST['keyword'])){
        $keyword=$_POST['keyword'];
    }else{
        $keyword="";
    }
    //Atur Page
    if(!empty($_POST['page'])){
        $page=$_POST['page'];
        $posisi = ( $page - 1 ) * $batas;
    }else{
        $page="1";
        $posisi = 0;
    }
    //hitung jumlah data
    if(empty($keyword)){
        if(empty($JenisTransaksi)){
            $jml_data = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM transaksi"));
        }else{
            if($JenisTransaksi=="Utang"){
                $jml_data = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM transaksi WHERE keterangan='Utang'"));
            }else{
                if($JenisTransaksi=="Piutang"){
                    $jml_data = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM transaksi WHERE keterangan='Piutang'"));
                }else{
                    $jml_data = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM transaksi WHERE jenis_transaksi='$JenisTransaksi'"));
                }
            }
        }
    }else{
        if(empty($JenisTransaksi)){
            $jml_data = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM transaksi WHERE kode_transaksi like '%$keyword%' OR tanggal like '%$keyword%'"));
        }else{
            if($JenisTransaksi=="Utang"){
                $jml_data = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM transaksi WHERE keterangan='Utang' AND kode_transaksi like '%$keyword%' OR tanggal like '%$keyword%'"));
            }else{
                if($JenisTransaksi=="Piutang"){
                    $jml_data = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM transaksi WHERE keterangan='Piutang' AND kode_transaksi like '%$keyword%' OR tanggal like '%$keyword%'"));
                }else{
                    $jml_data = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM transaksi WHERE jenis_transaksi='$JenisTransaksi' AND kode_transaksi like '%$keyword%' OR tanggal like '%$keyword%'"));
                }
            }
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
        //ketika klik next
        $('#NextPage').click(function() {
            var JenisTransaksi="<?php echo "$JenisTransaksi"; ?>";
            var valueNext = $('#NextPage').val();
            var mode = valueNext.split(',');
            var page = mode[0];
            var BatasData = mode[1];
            $.ajax({
                url 	: '_Page/LogTransaksi/TabelTransaksi.php',
                method  : "POST",
                data    : { page: page, BatasData: BatasData, JenisTransaksi: JenisTransaksi },
                success: function (data) {
                    $('#TabelLogTransaksi').html(data);

                }
            })
        });
        //Ketika klik Previous
        $('#PrevPage').click(function() {
            var JenisTransaksi="<?php echo "$JenisTransaksi"; ?>";
            var ValuePrev = $('#PrevPage').val();
            var mode = ValuePrev.split(',');
            var page = mode[0];
            var BatasData = mode[1];
            $.ajax({
                url 	: '_Page/LogTransaksi/TabelTransaksi.php',
                method  : "POST",
                data    : { page: page, BatasData: BatasData, JenisTransaksi: JenisTransaksi },
                success : function (data) {
                    $('#TabelLogTransaksi').html(data);
                }
            })
        });
        <?php 
            $a=1;
            $b=$batas;
            for ( $i =$a; $i<=$b; $i++ ){
        ?>
            //ketika klik page number
            $('#PageNumber<?php echo $i;?>').click(function() {
                var JenisTransaksi="<?php echo "$JenisTransaksi"; ?>";
                var PageNumber = $('#PageNumber<?php echo $i;?>').val();
                var mode = PageNumber.split(',');
                var page = mode[0];
                var BatasData = mode[1];
                $.ajax({
                    url 	: '_Page/LogTransaksi/TabelTransaksi.php',
                    method  : "POST",
                    data    : { page: page, BatasData: BatasData, JenisTransaksi: JenisTransaksi },
                    success: function (data) {
                        $('#TabelLogTransaksi').html(data);
                    }
                })
            });
        <?php } ?>
        $('#ModalDetailLogTransaksi').on('show.bs.modal', function (e) {
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#DetailLogTransaksi').html(Loading);
            var DetailTransaksi = $(e.relatedTarget).data('id');
            var mode = DetailTransaksi.split(',');
            var kode_transaksi = mode[0];
            var JenisTransaksi = mode[1];
            var page = mode[2];
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
                            url     : "_Page/Transaksi/ProsesDeleteTransaksi.php",
                            method  : "POST",
                            data    : { kode_transaksi: kode_transaksi },
                            success: function (data) {
                                $('#Notifikasi').html(data);
                                var NotifikasiBerhasil = $('#NotifikasiHapus').html();
                                if(NotifikasiBerhasil=="Berhasil"){
                                    $('#ModalDetailLogTransaksi').modal('hide');
                                    $('#Halaman').html(Loading);
                                    $.ajax({
                                        url     : "_Page/LogTransaksi/LogTransaksi.php",
                                        method  : "POST",
                                        data    : {JenisTransaksi: JenisTransaksi, page: page },
                                        success: function (data) {
                                            $('#Halaman').html(data);
                                        }
                                    })
                                }
                            }
                        })
                    });
                }
            })
        });
    });
</script>
<div class="card-body">
    <div class="table-responsive" style="height: 350px; overflow-y: scroll;">
        <table class="table table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Kode</th>
                    <th>Trans</th>
                    <th>Tagihan</th>
                    <th>Keterangan</th>
                    <th>Option</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $no = 1+$posisi;
                    //KONDISI PENGATURAN MASING FILTER
                    if(empty($keyword)){
                        if(empty($JenisTransaksi)){
                            $query = mysqli_query($conn, "SELECT*FROM transaksi ORDER BY id_transaksi DESC LIMIT $posisi, $batas");
                        }else{
                            if($JenisTransaksi=="Utang"){
                                $query = mysqli_query($conn, "SELECT*FROM transaksi WHERE keterangan='Utang' ORDER BY id_transaksi DESC LIMIT $posisi, $batas");
                            }else{
                                if($JenisTransaksi=="Piutang"){
                                    $query = mysqli_query($conn, "SELECT*FROM transaksi WHERE keterangan='Piutang' ORDER BY id_transaksi DESC LIMIT $posisi, $batas");
                                }else{
                                    $query = mysqli_query($conn, "SELECT*FROM transaksi WHERE jenis_transaksi='$JenisTransaksi' ORDER BY id_transaksi DESC LIMIT $posisi, $batas");
                                }
                            }
                        }
                        
                    }else{
                        if(empty($JenisTransaksi)){
                            $query = mysqli_query($conn, "SELECT*FROM transaksi WHERE  kode_transaksi like '%$keyword%' OR tanggal like '%$keyword%' ORDER BY id_transaksi DESC LIMIT $posisi, $batas");
                        }else{
                            if($JenisTransaksi=="Utang"){
                                $query = mysqli_query($conn, "SELECT*FROM transaksi WHERE keterangan='Utang' AND kode_transaksi like '%$keyword%' OR tanggal like '%$keyword%' ORDER BY id_transaksi DESC LIMIT $posisi, $batas");
                            }else{
                                if($JenisTransaksi=="Piutang"){
                                    $query = mysqli_query($conn, "SELECT*FROM transaksi WHERE keterangan='Piutang' AND kode_transaksi like '%$keyword%' OR tanggal like '%$keyword%' ORDER BY id_transaksi DESC LIMIT $posisi, $batas");
                                }else{
                                    $query = mysqli_query($conn, "SELECT*FROM transaksi WHERE jenis_transaksi='$JenisTransaksi' AND kode_transaksi like '%$keyword%' OR tanggal like '%$keyword%' ORDER BY id_transaksi DESC LIMIT $posisi, $batas");
                                }
                            }
                        }
                    }
                    while ($data = mysqli_fetch_array($query)) {
                        $id_transaksi = $data['id_transaksi'];
                        $kode_transaksi = $data['kode_transaksi'];
                        $tanggal = $data['tanggal'];
                        $jenis_transaksi= $data['jenis_transaksi'];
                        $total_tagihan= $data['total_tagihan'];
                        $pembayaran= $data['pembayaran'];
                        $selisih= $data['selisih'];
                        $keterangan= $data['keterangan'];
                        if($jenis_transaksi=="penjualan"){
                            $jenis_transaksi="PNJ";
                        }else{
                            $jenis_transaksi="PMB";
                        }
                ?>
                <tr>
                    <td><?php echo "$no";?></td>
                    <td><?php echo "$tanggal";?></td>
                    <td><?php echo "$kode_transaksi";?></td>
                    <td><?php echo "$jenis_transaksi";?></td>
                    <td align="right"><?php echo "Rp " . number_format($total_tagihan,0,',','.');?></td>
                    <td><?php echo "$keterangan";?></td>
                    <td>
                        <div class="btn-group">
                            <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#ModalDetailLogTransaksi" data-id="<?php echo "$kode_transaksi,$JenisTransaksi,$page";?>">
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