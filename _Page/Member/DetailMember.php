<?php
    //koneksi
    ini_set("display_errors","off");
    include "../../_Config/Connection.php";
    //tangkap variabel
    $IdMember=$_POST['IdMember'];
    //Tangkap page
    $page=$_POST['page'];
    $BatasData=$_POST['BatasData'];
    //Buka data pelanggan berdasarkan IdPelanggan
    $QryUser = mysqli_query($conn, "SELECT * FROM member WHERE id_member='$IdMember'")or die(mysqli_error($conn));
    $DataUser = mysqli_fetch_array($QryUser);
    $nik = $DataUser['nik'];
    $nama = $DataUser['nama'];
    $alamat = $DataUser['alamat'];
    $kontak = $DataUser['kontak'];
    $kategori = $DataUser['kategori'];
    $point = $DataUser['point'];
    if(empty($DataUser['point'])){
        $point ="0";
    }else{
        $point = $DataUser['point'];
    }
    $batas="10";
    //Atur Page
    if(!empty($_POST['page'])){
        $page=$_POST['page'];
        $posisi = ( $page - 1 ) * $batas;
    }else{
        $page="1";
        $posisi = 0;
    }
    //hitung jumlah data
    if($kategori=="Konsumen"){
        $jml_data = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM pemberian_point WHERE id_member='$IdMember'"));
    }else{
        $jml_data = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM transaksi_supplier WHERE id_member='$IdMember'"));
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
        $('#NextPageDetail').click(function() {
            var valueNext = $('#NextPageDetail').val();
            var mode = valueNext.split(',');
            var page = mode[0];
            var BatasData = mode[1];
            var IdMember = mode[2];
            $.ajax({
                url     : "_Page/Member/DetailMember.php",
                method  : "POST",
                data    : { page: page, BatasData: BatasData, IdMember: IdMember },
                success: function (data) {
                    $('#DetailMember').html(data);

                }
            })
        });
        //Ketika klik Previous
        $('#PrevPageDetail').click(function() {
            var ValuePrev = $('#PrevPageDetail').val();
            var mode = ValuePrev.split(',');
            var page = mode[0];
            var BatasData = mode[1];
            var IdMember = mode[2];
            $.ajax({
                url     : "_Page/Member/DetailMember.php",
                method  : "POST",
                data    : { page: page, BatasData: BatasData, IdMember: IdMember },
                success : function (data) {
                    $('#DetailMember').html(data);
                }
            })
        });
        <?php 
            $a=1;
            $b=$JmlHalaman;
            for ( $i =$a; $i<=$b; $i++ ){
        ?>
            //ketika klik page number
            $('#PageNumberDetail<?php echo $i;?>').click(function() {
                var PageNumber = $('#PageNumberDetail<?php echo $i;?>').val();
                var mode = PageNumber.split(',');
                var page = mode[0];
                var BatasData = mode[1];
                var IdMember = mode[2];
                $.ajax({
                    url     : "_Page/Member/DetailMember.php",
                    method  : "POST",
                    data    : { page: page, BatasData: BatasData, IdMember: IdMember },
                    success: function (data) {
                        $('#DetailMember').html(data);
                    }
                })
            });
        <?php } ?>
    });
</script>
<div class="card-body bg-primary">
    <div class="row">
        <div class="col-md-12 text-center">
            <b class="text-light">DETAIL MEMBER/SUPPLIER</b>
        </div>
    </div>
</div>
<div class="card-body">
    <div class="row">
        <div class="col-lg-12">
            <table width="100%">
                <tr>
                    <td><b>ID Member</b></td>
                    <td><b>:</b></td>
                    <td><?php echo "$IdMember"; ?></td>
                    <td width="10%"></td>
                    <td><b>Kontak (HP)</b></td>
                    <td><b>:</b></td>
                    <td><?php echo "$kontak"; ?></td>
                </tr>
                <tr>
                    <td><b>Nama Lengkap</b></td>
                    <td><b>:</b></td>
                    <td><?php echo "$nama"; ?></td>
                    <td width="10%"></td>
                    <td><b>Kategori</b></td>
                    <td><b>:</b></td>
                    <td><?php echo "$kategori"; ?></td>
                </tr>
                <tr>
                    <td><b>NIK/ID Card</b></td>
                    <td><b>:</b></td>
                    <td><?php echo "$nik"; ?></td>
                    <td width="10%"></td>
                    <td><b>Point</b></td>
                    <td><b>:</b></td>
                    <td><?php echo "$point"; ?></td>
                </tr>
                <tr>
                    <td><b>Alamat</b></td>
                    <td><b>:</b></td>
                    <td><?php echo "$alamat"; ?></td>
                    <td width="10%"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
        </div>
    </div>
</div>
<div class="card-body bg-white">
    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">
                <?php if($kategori=="Konsumen"){ ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Tanggal</th>
                                <th>Total</th>
                                <th>Point</th>
                                <th>Ket</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $no = 1+$posisi;
                                //KONDISI PENGATURAN MASING FILTER
                                $query = mysqli_query($conn, "SELECT*FROM pemberian_point WHERE id_member='$IdMember' ORDER BY id_pemberian_point DESC LIMIT $posisi, $batas");
                                while ($data = mysqli_fetch_array($query)) {
                                    $tanggal = $data['tanggal'];
                                    $kode_transaksi= $data['kode_transaksi'];
                                    $point = $data['point'];
                                    //Buka Detail Transaksi
                                    $QryTransaksi = mysqli_query($conn, "SELECT * FROM transaksi WHERE kode_transaksi='$kode_transaksi'")or die(mysqli_error($conn));
                                    $DataTransaksi = mysqli_fetch_array($QryTransaksi);
                                    $trans=$DataTransaksi['jenis_transaksi'];
                                    $subtotal = $DataTransaksi['subtotal'];
                                    $RpPpn = $DataTransaksi['ppn'];
                                    $RpBiaya = $DataTransaksi['biaya'];
                                    $RpDiskon = $DataTransaksi['diskon'];
                                    $total_tagihan = $DataTransaksi['total_tagihan'];
                                    $pembayaran = $DataTransaksi['pembayaran'];
                                    $selisih = $DataTransaksi['selisih'];
                                    $keterangan = $DataTransaksi['keterangan'];
                                    $petugas = $DataTransaksi['petugas'];
                            ?>
                            <tr>
                                <td><?php echo "$no";?></td>
                                <td><?php echo "$kode_transaksi";?></td>
                                <td><?php echo "$tanggal";?></td>
                                <td><?php echo "Rp " . number_format($total_tagihan,0,',','.');?></td>
                                <td><?php echo "$point";?></td>
                                <td><?php echo "$keterangan";?></td>
                            </tr>
                            <?php $no++;} ?>
                        </tbody>
                    </table>
                <?php }else{ ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Tanggal</th>
                                <th>Total</th>
                                <th>Ket</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $no = 1+$posisi;
                                //KONDISI PENGATURAN MASING FILTER
                                $query = mysqli_query($conn, "SELECT*FROM transaksi_supplier WHERE id_member='$IdMember' ORDER BY id_transaksi_supplier DESC LIMIT $posisi, $batas");
                                while ($data = mysqli_fetch_array($query)) {
                                    $tanggal = $data['tanggal'];
                                    $kode_transaksi= $data['kode_transaksi'];
                                    //Buka Detail Transaksi
                                    $QryTransaksi = mysqli_query($conn, "SELECT * FROM transaksi WHERE kode_transaksi='$kode_transaksi'")or die(mysqli_error($conn));
                                    $DataTransaksi = mysqli_fetch_array($QryTransaksi);
                                    $trans=$DataTransaksi['jenis_transaksi'];
                                    $subtotal = $DataTransaksi['subtotal'];
                                    $RpPpn = $DataTransaksi['ppn'];
                                    $RpBiaya = $DataTransaksi['biaya'];
                                    $RpDiskon = $DataTransaksi['diskon'];
                                    $total_tagihan = $DataTransaksi['total_tagihan'];
                                    $pembayaran = $DataTransaksi['pembayaran'];
                                    $selisih = $DataTransaksi['selisih'];
                                    $keterangan = $DataTransaksi['keterangan'];
                                    $petugas = $DataTransaksi['petugas'];
                            ?>
                            <tr>
                                <td><?php echo "$no";?></td>
                                <td><?php echo "$kode_transaksi";?></td>
                                <td><?php echo "$tanggal";?></td>
                                <td><?php echo "Rp " . number_format($total_tagihan,0,',','.');?></td>
                                <td><?php echo "$keterangan";?></td>
                            </tr>
                            <?php $no++;} ?>
                        </tbody>
                    </table>
                <?php } ?>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col col-lg-12">
            <form action="javascript:void(0);" id="Paging">
                <div class="btn-group" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-outline-secondary" id="PrevPageDetail" <?php echo "value='".$prev.",".$batas.",".$IdMember."'"; ?>>
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
                    <button type="button" class="<?php if($i==$page){echo "btn btn-primary";}else{echo "btn btn-grey";} ?>" id="PageNumberDetail<?php echo $i;?>" <?php echo "value='".$i.",".$batas.",".$IdMember."'"; ?>>
                        <?php echo $i;?>
                    </button>
                    <?php 
                        }
                    ?>
                    <button type="button" class="btn btn-outline-secondary" id="NextPageDetail" <?php echo "value='".$next.",".$batas.",".$IdMember."'"; ?>>
                        >>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="card-footer">
    <div class="row">
        <div class="form-group col-md-12 text-center">
            <button class="btn btn-rounded btn-outline-danger" data-dismiss="modal">
                Tutup
            </button>
        </div>
    </div>
</div>
