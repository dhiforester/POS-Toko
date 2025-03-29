<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SessionLogin.php";
    //NewOrEdit
    if(!empty($_POST['NewOrEdit'])){
        $NewOrEdit=$_POST['NewOrEdit'];
    }else{
        $NewOrEdit="New";
    }
    //id_transaksi
    if(!empty($_POST['id_transaksi'])){
        $id_transaksi=$_POST['id_transaksi'];
    }else{
        $id_transaksi="";
    }
    //Buka detail transaksi
    $QryTransaksi = mysqli_query($conn, "SELECT * FROM transaksi WHERE id_transaksi='$id_transaksi'")or die(mysqli_error($conn));
    $DataTransaksi = mysqli_fetch_array($QryTransaksi);
    $kode_transaksi=$DataTransaksi['kode_transaksi'];
    $tanggal=$DataTransaksi['tanggal'];
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
    $ppn=($RpPpn/$subtotal)*100;
    $diskon=($RpDiskon/$subtotal)*100;
    //Buka Member Taua Supplier
    if($trans=="penjualan"){
        //Buka data pemberian point
        $QryPemberianPoint = mysqli_query($conn, "SELECT * FROM pemberian_point WHERE kode_transaksi='$kode_transaksi'")or die(mysqli_error($conn));
        $DataPemberianPoint = mysqli_fetch_array($QryPemberianPoint);
        $IdMember=$DataPemberianPoint['id_member'];
        $point=$DataPemberianPoint['point'];
        //Buka nama member
        $QryMember = mysqli_query($conn, "SELECT * FROM member WHERE id_member='$IdMember'")or die(mysqli_error($conn));
        $DataMember = mysqli_fetch_array($QryMember);
        $NamaMember=$DataMember['nama'];
        if(empty($DataMember['id_member'])){
            $NamaMember="Tidak Ada";
        }else{
            $NamaMember=$DataMember['nama'];
        }
    }
    if($trans=="pembelian"){
        //Buka data transaksi supplier
        $QryTransaksiSupplier = mysqli_query($conn, "SELECT * FROM transaksi_supplier WHERE kode_transaksi='$kode_transaksi'")or die(mysqli_error($conn));
        $DataTransaksiSupplier = mysqli_fetch_array($QryTransaksiSupplier);
        $IdMember=$DataTransaksiSupplier['tanggal'];
        //Buka nama member
        $QryMember = mysqli_query($conn, "SELECT * FROM member WHERE id_member='$IdMember'")or die(mysqli_error($conn));
        $DataMember = mysqli_fetch_array($QryMember);
        $NamaMember=$DataMember['id_member'];
        if(empty($DataMember['nama'])){
            $NamaMember="Tidak Ada";
        }else{
            $NamaMember=$DataMember['nama'];
        }
    }
    //Apakah ada data retur dari id transaksi tersebut?
    $QryRetur = mysqli_query($conn, "SELECT * FROM retur WHERE id_transaksi='$id_transaksi'")or die(mysqli_error($conn));
    $DataRetur = mysqli_fetch_array($QryRetur);
    if(empty($DataRetur['id_retur'])){
        $id_retur="";
        //Buat kode transaksi
        $query_kode=mysqli_query($conn, "SELECT max(id_retur) as maksimal FROM retur")or die(mysqli_error($conn));
        while($hasil_kode=mysqli_fetch_array($query_kode)){
            $nilai=$hasil_kode['maksimal'];
        }
        $kode_dasar=$nilai+1;
        $kode_dasar1=sprintf("%07d", $kode_dasar);
        if($trans=='penjualan'){$kode_trans='PNJL';}
        if($trans=='pembelian'){$kode_trans='PMBL';}
        $KodeRetur="RET$kode_trans$SessionIdUser$kode_dasar1";
        $TanggalRetur="";
        $SubtotalRetur="";
        $ppnRetur="";
        $diskonRetur="";
        $tagihanRetur="";
        $pembayaranRetur="";
        $keteranganRetur="";
    }else{
        $id_retur=$DataRetur['id_retur'];
        $KodeRetur=$DataRetur['kode'];
        $TanggalRetur=$DataRetur['tanggal'];
        $SubtotalRetur=$DataRetur['subtotal'];
        $ppnRetur=$DataRetur['ppn'];
        $diskonRetur=$DataRetur['diskon'];
        $tagihanRetur=$DataRetur['tagihan'];
        $pembayaranRetur=$DataRetur['pembayaran'];
        $keteranganRetur=$DataRetur['keterangan'];
    }
    //Hitung subtotal
    $QrySubtotal = mysqli_query($conn, "SELECT SUM(jumlah) as jumlah from retur_rincian WHERE id_transaksi='$id_transaksi'");
    $DataSubtotal = mysqli_fetch_array($QrySubtotal);
    $subtotalFaktur=$DataSubtotal['jumlah'];
    //Cari nilai Rupiah PPN
    $RpPpnRetur = ($subtotalFaktur*$ppn/100);
    //Cari Nilai Rupiah Diskon
    $RpDiskonRetur = ($subtotalFaktur*$diskon/100);
    //Cari Nilai Rupiah Total tagihan
    $TotalTagihanRetur = $subtotalFaktur+$RpPpnRetur-$RpDiskonRetur;
    $pembayaranRetur = $TotalTagihanRetur;
    $SelisihRetur = $TotalTagihanRetur-$pembayaranRetur;
    //Menentukan Keterangan
    if($trans=="penjualan"){
        if($SelisihRetur=="0"){
            $keteranganRetur="Lunas";
        }else{
            if($SelisihRetur>0){
                $keteranganRetur="Utang";
            }else{
                $keteranganRetur="Piutang";
            }
        }
    }else{
        if($SelisihRetur=="0"){
            $keteranganRetur="Lunas";
        }else{
            if($SelisihRetur>0){
                $keteranganRetur="Piutang";
            }else{
                $keteranganRetur="Utang";
            }
        }
    }
?>
<script>
    //Reload halaman
    $('#ReloadHalamanRetur').click(function(){
        var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
        var id_transaksi= "<?php echo "$id_transaksi";?>";
        $('#Halaman').html(Loading);
        $.ajax({
            url     : "_Page/Retur/Retur.php",
            method  : "POST",
            data    : { id_transaksi: id_transaksi },
            success: function (data) {
                $('#Halaman').html(data);
            }
        })
    });
    //Kembali Ke Kasir
    $('#KembaliKeKasir').click(function(){
        var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
        $('#Halaman').html(Loading);
        var NewOrEdit="New";
        $.ajax({
            url     : "_Page/Kasir/Kasir.php",
            method  : "POST",
            data    : { NewOrEdit: NewOrEdit },
            success: function (data) {
                $('#Halaman').html(data);
            }
        })
    });
    $('#ModalAddRetur').on('show.bs.modal', function (e) {
        var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
        $('#FormAddRetur').html(Loading);
        var id_rincian = $(e.relatedTarget).data('id');
        var NewOrEdit ="<?php echo $NewOrEdit;?>";
        $.ajax({
            url     : "_Page/Retur/FormAddRetur.php",
            method  : "POST",
            data    : { id_rincian: id_rincian, NewOrEdit: NewOrEdit },
            success: function (data) {
                $('#FormAddRetur').html(data);
                $('#qty').focus();
            }
        })
    });
    var id_transaksi= "<?php echo "$id_transaksi";?>";
    $.ajax({
        type 	: 'POST',
        url 	: '_Page/Retur/TabelRincianRetur.php',
        data 	:  { id_transaksi: id_transaksi },
        success : function(data){
            $('#TabelRincianRetur').html(data);
        }
    });
    //Kembali Ke Kasir
    $('#ProsesBuatFakturRetur').submit(function(){
        var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
        $('#Halaman').html(Loading);
        var NewOrEdit="New";
        $.ajax({
            url     : "_Page/Kasir/Kasir.php",
            method  : "POST",
            data    : { NewOrEdit: NewOrEdit },
            success: function (data) {
                $('#Halaman').html(data);
            }
        })
    });
</script>
<div class="row">
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 grid-margin stretch-card">
        <div class="card card-statistics">
            <div class="card-header">
                    <?php
                        if($NewOrEdit=="New"){
                            echo '<b class="text-primary">';
                            echo '  <i class="mdi mdi-star"></i> Buat Faktur Retur Transaksi';
                            echo '</b>';
                        }else{
                            echo '<b class="text-danger">';
                            echo '  <i class="mdi mdi-pencil"></i> Edit Faktur Retur Transaksi';
                            echo '</b>';
                        }
                    ?>
            </div>
            <div class="card-body">
                <small>
                    <table>
                        <tr>
                            <td><b>Kode Transaksi</b></td>
                            <td><b>:</b></td>
                            <td><?php echo $kode_transaksi;?></td>
                        </tr>
                        <tr>
                            <td><b>Tanggal</b></td>
                            <td><b>:</b></td>
                            <td><?php echo $tanggal;?></td>
                        </tr>
                        <tr>
                            <td><b>Kategori</b></td>
                            <td><b>:</b></td>
                            <td><?php echo $trans;?></td>
                        </tr>
                        <?php
                            if($trans=="penjualan"){
                                if(empty($DataMember['id_member'])){
                                    $NamaMember="";
                                }else{
                                    $NamaMember=$DataMember['nama'];
                                    echo '<tr>';
                                    echo '  <td><b>Member</b></td>';
                                    echo '  <td><b>:</b></td>';
                                    echo '  <td>'.$NamaMember.'</td>';
                                    echo '</tr>';
                                    echo '<tr>';
                                    echo '  <td><b>Point</b></td>';
                                    echo '  <td><b>:</b></td>';
                                    echo '  <td>'.$point.'</td>';
                                    echo '</tr>';
                                }
                            }else{
                                if(empty($DataMember['nama'])){
                                    $NamaMember="Tidak Ada";
                                }else{
                                    $NamaMember=$DataMember['nama'];
                                    echo '<tr>';
                                    echo '  <td><b>Supplier</b></td>';
                                    echo '  <td><b>:</b></td>';
                                    echo '  <td>'.$NamaMember.'</td>';
                                    echo '</tr>';
                                }
                            }
                            echo '<tr>';
                            echo '  <td><b>Petugas</b></td>';
                            echo '  <td><b>:</b></td>';
                            echo '  <td>'.$petugas.'</td>';
                            echo '</tr>';
                        ?>
                    </table>
                </small>
            </div>
            <div class="card-body">
                <div class="table-responsive" style="height: 250px; overflow-y: scroll;">
                    <table class="table table-sm table-bordered table-hover scroll-container">
                        <thead class="thead-dark">
                            <tr>
                                <th>No</th>
                                <th>Nama/Merek</th>
                                <th>QTY</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $no = 1;
                                $query = mysqli_query($conn, "SELECT*FROM rincian_transaksi WHERE kode_transaksi='$kode_transaksi' ORDER BY id_rincian DESC");
                                while ($data = mysqli_fetch_array($query)) {
                                    $id_rincian = $data['id_rincian'];
                                    $id_obat = $data['id_obat'];
                                    $nama = $data['nama'];
                                    $qty= $data['qty'];
                                    $harga = $data['harga'];
                                    $jumlah= $data['jumlah'];
                                    $id_multi= $data['id_multi'];
                                    //Buka Satuan
                                   
                                    if(empty($id_multi)){
                                        $QryObat = mysqli_query($conn, "SELECT * FROM obat WHERE id_obat='$id_obat'")or die(mysqli_error($conn));
                                        $DataObat = mysqli_fetch_array($QryObat);
                                        $satuan = $DataObat['satuan'];
                                    }else{
                                        $QryObat = mysqli_query($conn, "SELECT * FROM muti_harga WHERE id_multi='$id_multi'")or die(mysqli_error($conn));
                                        $DataObat = mysqli_fetch_array($QryObat);
                                        $satuan = $DataObat['satuan'];
                                    }
                                    
                            ?>
                            <tr onmousemove="this.style.cursor='pointer'" data-toggle="modal" data-target="#ModalAddRetur" <?php echo "data-id='".$id_rincian."'"; ?>>
                                <td><?php echo "$no";?></td>
                                <td><?php echo "$nama";?></td>
                                <td><?php echo "$qty $satuan";?></td>
                                <td align="right"><?php echo "Rp " . number_format($harga,0,',','.');?></td>
                                <td align="right"><?php echo "Rp " . number_format($jumlah,0,',','.');?></td>
                            </tr>
                            <?php 
                                $no++;} 
                            ?>
                            <tr>
                                <td colspan="4" align="right">SUBTOTAL</td>
                                <td align="right"><?php echo "Rp " . number_format($subtotal,0,',','.');?></td>
                            </tr>
                            <?php if(!empty($RpPpn)){ ?>
                                <tr>
                                    <td colspan="4" align="right">PPN <?php echo "($ppn %)";?></td>
                                    <td align="right"><?php echo "Rp " . number_format($RpPpn,0,',','.');?></td>
                                </tr>
                            <?php }if(!empty($RpDiskon)){ ?>
                                <tr>
                                    <td colspan="4" align="right">DISKON <?php echo "($diskon %)";?></td>
                                    <td align="right"><?php echo "Rp " . number_format($RpDiskon,0,',','.');?></td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td colspan="4" align="right">TOTAL</td>
                                <td align="right"><?php echo "Rp " . number_format($total_tagihan,0,',','.');?></td>
                            </tr>
                            <tr>
                                <td colspan="4" align="right">PEMBAYARAN</td>
                                <td align="right"><?php echo "Rp " . number_format($pembayaran,0,',','.');?></td>
                            </tr>
                            <?php if(!empty($selisih)){ ?>
                                <tr>
                                    <td colspan="4" align="right">SELISIH</td>
                                    <td align="right"><?php echo "Rp " . number_format($selisih,0,',','.');?></td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td colspan="4" align="right">KETERANGAN</td>
                                <td align="right"><?php echo "$keterangan";?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer" id="NotifikasiSimpanFakturRetur">
                <b class="text-primary">Keterangan :</b> Faktur Belum Disimpan.
            </div>
        </div>
    </div>
<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 grid-margin stretch-card">
    <div class="card card-statistics">
            <form action="javascript:void(0);" id="ProsesBuatFakturRetur">
                <input type="hidden" name="id_transaksi" value="<?php echo $id_transaksi;?>">
                <div class="card-header">
                    <div class="col col-lg-12">
                    <button type="button" class="btn btn-sm btn-warning" id="ReloadHalamanRetur">
                        <i class="mdi mdi-reload"></i> Reload
                        </button>
                        <button type="button" class="btn btn-sm btn-primary" id="KembaliKeKasir">
                        <i class="mdi mdi-arrow-left"></i> Kasir
                        </button>
                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#ModalPilihTransaksiRetur">
                        <i class="mdi mdi-view-list"></i> Transaksi
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group row" id="TabelRincianRetur">
                                <!----------------- Isi Tabel------------>
                    </div>
                    <div class="form-group row">
                        <div class="col col-md-4">
                            <label>Tanggal</label>
                            <input type="date" class="form-control form-control-sm border-dark" name="tanggal" id="tanggal" value="<?php if(empty($DataRetur['tanggal'])){echo date('Y-m-d');}else{echo $TanggalRetur;} ?>">
                        </div>
                        <div class="col col-md-4">
                            <label>Kode</label>
                            <input type="text" readonly class="form-control form-control-sm border-dark" name="kode" id="kode" value="<?php echo $KodeRetur; ?>">
                        </div>
                        <div class="col col-md-4">
                            <label>Subtotal</label>
                            <input type="text" readonly class="form-control form-control-sm border-dark" name="subtotal" id="total" value="<?php echo $subtotalFaktur;?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col col-md-4">
                            <label>PPN (<?php echo $ppn; ?>%)</label>
                            <input type="text" class="form-control form-control-sm border-dark" name="ppn" id="ppn" value="<?php echo $RpPpnRetur;?>">
                        </div>
                        <div class="col col-md-4">
                            <label>Diskon (<?php echo $diskon; ?>%)</label>
                            <input type="text" class="form-control form-control-sm border-dark" name="diskon" id="diskon" value="<?php echo $RpDiskonRetur;?>">
                        </div>
                        <div class="col col-md-4">
                            <label>Total Retur</label>
                            <input type="text" readonly class="form-control form-control-sm border-dark" name="total" id="total" value="<?php echo $TotalTagihanRetur;?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col col-md-4">
                            <label>Pengembalian</label>
                            <input type="text" class="form-control form-control-sm border-dark" name="pembayaran" id="pembayaran" value="<?php echo $pembayaranRetur; ?>">
                        </div>
                        <div class="col col-md-4">
                            <label>Selisih</label>
                            <input type="text" readonly class="form-control form-control-sm border-dark" name="selisih" id="selisih" value="<?php echo $SelisihRetur; ?>">
                        </div>
                        <div class="col col-md-4">
                            <label>Keterangan</label>
                            <input type="text" readonly class="form-control form-control-sm border-dark" name="keterangan" id="keterangan" value="<?php echo $keteranganRetur; ?>">
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="reset" class="btn btn-sm btn-outline-warning">
                        <i class="mdi mdi-undo"></i> Reset
                    </button>
                    <button type="submit" class="btn btn-sm btn-outline-primary">
                        <i class="mdi mdi-floppy"></i> Buat Faktur
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>