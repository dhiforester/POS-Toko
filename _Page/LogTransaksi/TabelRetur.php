<?php
    //koneksi dan error
    ini_set("display_errors","off");
    include "../../_Config/Connection.php";
    //Atur Batas
    $batas="50";
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
        $jml_data = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM retur"));
    }else{
        $jml_data = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM retur WHERE kode like '%$keyword%' OR tanggal like '%$keyword%'"));
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
            var valueNext = $('#NextPage').val();
            var mode = valueNext.split(',');
            var page = mode[0];
            var BatasData = mode[1];
            $.ajax({
                url 	: '_Page/LogTransaksi/TabelRetur.php',
                method  : "POST",
                data    : { page: page, BatasData: BatasData },
                success: function (data) {
                    $('#TabelLogTransaksi').html(data);

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
                url 	: '_Page/LogTransaksi/TabelRetur.php',
                method  : "POST",
                data    : { page: page, BatasData: BatasData },
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
                var PageNumber = $('#PageNumber<?php echo $i;?>').val();
                var mode = PageNumber.split(',');
                var page = mode[0];
                var BatasData = mode[1];
                $.ajax({
                    url 	: '_Page/LogTransaksi/TabelRetur.php',
                    method  : "POST",
                    data    : { page: page, BatasData: BatasData },
                    success: function (data) {
                        $('#TabelLogTransaksi').html(data);
                    }
                })
            });
        <?php } ?>
        $('#ModalDetailFakturReturTransaksi').on('show.bs.modal', function (e) {
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#DetailFakturReturTransaksi').html(Loading);
            var kode = $(e.relatedTarget).data('id');
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/Retur/DetailFakturReturTransaksi.php',
                data 	:  { kode: kode },
                success : function(data){
                    $('#DetailFakturReturTransaksi').html(data);
                }
            });
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
                    <th>Kode Retur</th>
                    <th>Kode Trans</th>
                    <th>Kategori</th>
                    <th>Tagihan</th>
                    <th>Option</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $no = 1+$posisi;
                    //KONDISI PENGATURAN MASING FILTER
                    if(empty($keyword)){
                        $query = mysqli_query($conn, "SELECT*FROM retur ORDER BY id_retur DESC LIMIT $posisi, $batas");
                    }else{
                        $query = mysqli_query($conn, "SELECT*FROM retur WHERE kode like '%$keyword%' OR tanggal like '%$keyword%' ORDER BY id_retur DESC LIMIT $posisi, $batas");
                    }
                    while ($data = mysqli_fetch_array($query)) {
                        $id_retur = $data['id_retur'];
                        $id_transaksi = $data['id_transaksi'];
                        $kode = $data['kode'];
                        $tanggal = $data['tanggal'];
                        $tagihan= $data['tagihan'];
                        //Buka transaksi
                        $QryTransaksi = mysqli_query($conn, "SELECT * FROM transaksi WHERE id_transaksi='$id_transaksi'")or die(mysqli_error($conn));
                        $DataTransaksi = mysqli_fetch_array($QryTransaksi);
                        $kode_transaksi=$DataTransaksi['kode_transaksi'];
                        $trans=$DataTransaksi['jenis_transaksi'];
                        if($trans=="penjualan"){
                            $jenis_transaksi="PNJ";
                        }else{
                            $jenis_transaksi="PMB";
                        }
                ?>
                <tr>
                    <td><?php echo "$no";?></td>
                    <td><?php echo "$tanggal";?></td>
                    <td><?php echo "$kode";?></td>
                    <td><?php echo "$kode_transaksi";?></td>
                    <td><?php echo "$jenis_transaksi";?></td>
                    <td align="right"><?php echo "Rp " . number_format($tagihan,0,',','.');?></td>
                    <td>
                        <div class="btn-group">
                            <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#ModalDetailFakturReturTransaksi" data-id="<?php echo "$kode";?>">
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