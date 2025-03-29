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
    //Atur generate
    if(!empty($_POST['generate'])){
        $generate=$_POST['generate'];
    }else{
        $generate="";
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
        $ShortBy="ASC";
    }
    //hitung jumlah data
    if(empty($keyword)){
        $jml_data = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM obat"));
    }else{
        $jml_data = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM obat WHERE nama like '%$keyword%' OR kode like '%$keyword%'"));
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
        $('#Tampilkan').click(function() {
            var batas = $('#IdBatas').val();
            var page = $('#IdPage').val();
            $('#TabelObat').html("Loading...");
            $.ajax({
                url     : "_Page/Obat/GenerateBarang.php",
                method  : "POST",
                data    : { page: page, batas: batas },
                success: function (data) {
                    $('#TabelObat').html(data);

                }
            })
        });
        $('#TombolGenerate').click(function() {
            var batas = $('#IdBatas').val();
            var page = $('#IdPage').val();
            $('#TabelObat').html("Loading...");
            $.ajax({
                url     : "_Page/Obat/ProsesGenerateBarang.php",
                method  : "POST",
                data    : { page: page, batas: batas },
                success : function (data) {
                    $('#TabelObat').html(data);
                    var NotifikasiGenerateBerhasil=$('#NotifikasiGenerateBerhasil').html();
                    var KelasBatas=$('#KelasBatas').html();
                    var KelasPage=$('#KelasPage').html();
                    if(NotifikasiGenerateBerhasil=="Berhasil"){
                        $.ajax({
                            url     : "_Page/Obat/GenerateBarang.php",
                            method  : "POST",
                            data    : { page: KelasPage, batas: KelasBatas },
                            success: function (data) {
                                $('#TabelObat').html(data);
                            }
                        })
                    }
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
                url     : "_Page/Obat/GenerateBarang.php",
                method  : "POST",
                data    : { page: page, BatasData: BatasData },
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
            var BatasData = mode[1];
            $.ajax({
                url     : "_Page/Obat/GenerateBarang.php",
                method  : "POST",
                data    : { page: page, BatasData: BatasData },
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
            //ketika klik page number
            $('#PageNumber<?php echo $i;?>').click(function() {
                var PageNumber = $('#PageNumber<?php echo $i;?>').val();
                var mode = PageNumber.split(',');
                var page = mode[0];
                var BatasData = mode[1];
                $.ajax({
                    url     : "_Page/Obat/GenerateBarang.php",
                    method  : "POST",
                    data    : { page: page, batas: BatasData },
                    success: function (data) {
                        $('#TabelObat').html(data);
                    }
                })
            });
        <?php } ?>
    });
</script>
<div class="card-body">
    <div class="form-group row">
        <div class="input-group col col-md-3">
            <input type="number" class="form-control" min="0" id="IdBatas" value="<?php echo $batas;?>">
        </div>
        <div class="input-group col col-md-3">
            <input type="number" class="form-control" min="1" id="IdPage" value="<?php echo $page;?>">
        </div>
        <div class="input-group col col-md-6">
            <button type="button" class="btn btn-md btn-primary" id="Tampilkan">Go</button>
            <button type="button" class="btn btn-md btn-danger" id="TombolGenerate">Generate</button>
        </div>
    </div>
    <div class="row">
        <div class="col col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered scroll-container">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Barcode</th>
                            <th>Nama/Merek</th>
                            <th>Stok</th>
                            <th>Harga Eceran</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $no = 1+$posisi;
                            //KONDISI PENGATURAN MASING FILTER
                            if(empty($keyword)){
                                $query = mysqli_query($conn, "SELECT*FROM obat ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }else{
                                $query = mysqli_query($conn, "SELECT*FROM obat WHERE nama like '%$keyword%' OR kode like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }
                            while ($data = mysqli_fetch_array($query)) {
                                $id_obat = $data['id_obat'];
                                $nama= $data['nama'];
                                $kode = $data['kode'];
                                $satuan = $data['satuan'];
                                $stok= $data['stok'];
                                $harga_1= $data['harga_1'];
                                $harga_2= $data['harga_2'];
                                $harga_3= $data['harga_3'];
                                $harga_4= $data['harga_4'];
                                //Membuka data barcode
                                //Menghitung Jumlah Yang sama
                                $jumlahYangSama = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM barcode WHERE kode='$kode'"));
                                if($jumlahYangSama=="1"){
                                    $QryBarcode = mysqli_query($conn, "SELECT * FROM barcode WHERE kode='$kode'")or die(mysqli_error($conn));
                                    $DataBarkode = mysqli_fetch_array($QryBarcode);
                                    $barcode= $DataBarkode['barcode'];
                                }else{
                                    if($jumlahYangSama>1){
                                        $QryBarcode = mysqli_query($conn, "SELECT * FROM barcode WHERE kode='$kode' AND harga='$harga_1'")or die(mysqli_error($conn));
                                        $DataBarkode = mysqli_fetch_array($QryBarcode);
                                        $barcode= $DataBarkode['barcode'];
                                    }else{
                                        $barcode="";
                                    }
                                }
                                if(empty($barcode)){
                                    //Cari Berdasarkan Kode Ke barkode
                                    $QryBarcode2 = mysqli_query($conn, "SELECT * FROM barcode WHERE barcode='$kode'")or die(mysqli_error($conn));
                                    $DataBarkode2= mysqli_fetch_array($QryBarcode2);
                                    
                                    if(!empty($DataBarkode2['barcode'])){
                                        $barcode2= $DataBarkode2['barcode'];
                                        $barcode="<b class='text-danger'>Pindahan</b>";
                                    }else{
                                        $barcode2="";
                                        $barcode="";
                                    }
                                }else{
                                    $barcode=$barcode;
                                }
                                if(!empty($generate)){
                                    if(!empty($barcode)){
                                        $hasil = mysqli_query($conn, "UPDATE obat SET kode='$barcode' WHERE id_obat='$id_obat'") or die(mysqli_error($conn)); 
                                    }
                                }
                        ?>
                        <tr>
                            <td><?php echo "$no";?></td>
                            <td><?php echo "$kode";?></td>
                            <td><?php echo "$barcode";?></td>
                            <td><?php echo "$nama";?></td>
                            <td><?php echo "$stok $satuan";?></td>
                            <td><?php echo "Rp " . number_format($harga_4,0,',','.');?></td>
                            <td align="center"><b class="text-info" id="<?php "NotifikasiProses$no"; ?>">None</b></td>
                        </tr>
                        <?php $no++;} ?>
                    </tbody>
                </table>
            </div>
        </div>
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