<?php
    //koneksi dan error
    ini_set("display_errors","off");
    include "../../_Config/Connection.php";
    
    if(!empty($_POST['NewOrEdit'])){
        $NewOrEdit=$_POST['NewOrEdit'];
    }else{
        $NewOrEdit="";
    }

    if(!empty($_POST['kode_transaksi'])){
        $kode_transaksi=$_POST['kode_transaksi'];
    }else{
        $kode_transaksi="";
    }
    //Buka transaksi
    //Buka rincian transaksi
    $QryTransaksi = mysqli_query($conn, "SELECT * FROM transaksi WHERE kode_transaksi='$kode_transaksi'")or die(mysqli_error($conn));
    $DataTransaksi = mysqli_fetch_array($QryTransaksi);
    $id_transaksi=$DataTransaksi['id_transaksi'];
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
    //Deteksi apakah ada data utang piutang?
    $AdaDataUtangPiutang = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM utang_piutang WHERE id_transaksi='$id_transaksi'"));
?>
<script>
    $('#EditTransaksiBaru').click(function() {
        $('#ModalDetailLogTransaksi').modal('hide');
        $('#Halaman').html('Loading..');
        var Detail = $('#EditTransaksiBaru').val();
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
    //ModalPilihListRetur
    $('#ModalPilihListRetur').on('show.bs.modal', function (e) {
        var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
        $('#KonfirmasiPilihListReturTransaksi').html(Loading);
        var DetailTransaksi = $(e.relatedTarget).data('id');
        $.ajax({
            type 	: 'POST',
            url 	: '_Page/Kasir/KonfirmasiPilihListRetur.php',
            data 	:  { id_transaksi: DetailTransaksi },
            success : function(data){
                $('#KonfirmasiPilihListReturTransaksi').html(data);
                $('SetujuiKonfirmasiRetur').focus();
                $('SetujuiKonfirmasiRetur').focusin();
            }
        });
    }); 
    //ModalBayarUtang
    $('#ModalBayarUtang').on('show.bs.modal', function (e) {
        var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
        $('#FormBayarUtang').html(Loading);
        var id_transaksi = $(e.relatedTarget).data('id');
        $.ajax({
            type 	: 'POST',
            url 	: '_Page/Transaksi/FormBayarUtang.php',
            data 	:  { id_transaksi: id_transaksi },
            success : function(data){
                $('#FormBayarUtang').html(data);
                $('#KeywordTransaksi').focusout();
                $('#uang').focus();
                
            }
        });
    });  
    //ModalBayarUtangEdit
    $('#ModalBayarUtangEdit').on('show.bs.modal', function (e) {
        var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
        $('#FormBayarUtangEdit').html(Loading);
        var id_utang_piutang = $(e.relatedTarget).data('id');
        var NewOrEdit="Edit";
        $.ajax({
            type 	: 'POST',
            url 	: '_Page/Transaksi/FormBayarUtang.php',
            data 	:  { NewOrEdit: NewOrEdit, id_utang_piutang: id_utang_piutang },
            success : function(data){
                $('#FormBayarUtangEdit').html(data);
                $('#KeywordTransaksi').focusout();
                $('#uang').focus();
                
            }
        });
    });    
</script>
<div class="modal-header bg-primary">
    <h4 class="text-white">
        <i class="mdi mdi-file-document-box"></i> Detail Transaksi
    </h4>
</div>
<div class="modal-body bg-white">
    <div class="row">
        <div class="col-md-6">
            <div class="table-responsive" style="height: 350px; overflow-y: scroll;">
                <table class="table table-sm table-bordered table-hover scroll-container">
                    <thead class="thead-dark">
                        <tr>
                            <th colspan="4"><b>Info Transaksi</b></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><b>Kode</b></td>
                            <td><?php echo "$kode_transaksi";?></td>
                            <td><b>Petugas</b></td>
                            <td><?php echo "$petugas";?></td>
                        </tr>
                        <tr>
                            <td><b>Tanggal</b></td>
                            <td><?php echo "$tanggal";?></td>
                            <td><b>Transaksi</b></td>
                            <td><?php echo "$trans";?></td>
                        </tr>
                        <tr>
                            
                        </tr>
                        <?php
                            if($trans=="penjualan"){
                                echo '<tr>';
                                echo '  <td><b>Member</b></td>';
                                echo "  <td>$NamaMember</td>";
                                if(!empty($point)){
                                    echo '  <td><b>Point</b></td>';
                                    echo "  <td>$point</td>";
                                }else{
                                    echo '  <td><b></b></td>';
                                    echo "  <td></td>";
                                }
                                
                                echo '</tr>';
                            }if($trans=="pembelian"){
                                echo '<tr>';
                                echo '  <td><b>Supplier</b></td>';
                                echo "  <td>$NamaMember</td>";
                                echo '</tr>';
                            }
                            echo '<tr>';
                            echo '  <td><b>Keterangan</b></td>';
                            echo "  <td>$keterangan</td>";
                            echo '  <td><b></b></td>';
                            echo "  <td></td>";
                            echo '</tr>';
                        ?>
                    </tbody>
                </table>
                <?php if(!empty($AdaDataUtangPiutang)){ ?>
                    <table class="table table-sm table-bordered table-hover scroll-container">
                        <thead class="thead-dark">
                            <tr>
                                <th colspan="5"><b>Histori Pembayaran U/P</b></th>
                            </tr>
                        </thead>
                        <thead>
                            <tr>
                                <th><b>No</b></th>
                                <th><b>Kode</b></th>
                                <th><b>Tanggal</b></th>
                                <th><b>(RP)</b></th>
                                <th><b>Ket</b></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $no = 1;
                                //KONDISI PENGATURAN MASING FILTER
                                $QryHistoriPembayaran = mysqli_query($conn, "SELECT*FROM utang_piutang WHERE id_transaksi='$id_transaksi' ORDER BY id_utang_piutang DESC");
                                while ($DataHistoriPembayaran = mysqli_fetch_array($QryHistoriPembayaran)) {
                                    $id_utang_piutang = $DataHistoriPembayaran['id_utang_piutang'];
                                    $kodePembayaran = $DataHistoriPembayaran['kode'];
                                    $tanggalPembayaran = $DataHistoriPembayaran['tanggal'];
                                    //uang
                                    if(!empty($DataHistoriPembayaran['uang'])){
                                        $uangPembayaran = $DataHistoriPembayaran['uang'];
                                    }else{
                                        $uangPembayaran ="0";
                                    }
                                    //keterangan
                                    if(!empty($DataHistoriPembayaran['keterangan'])){
                                        $keteranganPembayaran = $DataHistoriPembayaran['keterangan'];
                                    }else{
                                        $keteranganPembayaran ="None";
                                    }
                            ?>
                                <tr onmousemove="this.style.cursor='pointer'" data-toggle="modal" data-target="#ModalBayarUtangEdit" data-id="<?php echo $id_utang_piutang;?>">
                                    <td><?php echo "$no";?></td>
                                    <td><?php echo "$kodePembayaran";?></td>
                                    <td><?php echo "$tanggalPembayaran";?></td>
                                    <td align="right"><?php echo "Rp " . number_format($uangPembayaran,0,',','.');?></td>
                                    <td><?php echo "$keteranganPembayaran";?></td>
                                </tr>
                            <?php $no++;} ?>
                        </tbody>
                    </table>
                <?php } ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="table-responsive" style="height: 350px; overflow-y: scroll;">
                <table class="table table-sm table-bordered table-hover scroll-container">
                    <thead class="thead-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama/Merek Barang</th>
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
                        <tr>
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
    </div>
</div>
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-12 text-center">
            <small id="Notifikasi"></small>
        </div>
    </div>
</div>
<div class="modal-footer bg-primary">
    <div class="row">
        <div class="form-group col-md-12 text-center">
            <?php
                if($keterangan!=="Lunas"){
                    echo '<button class="btn btn-dark" data-toggle="modal" data-toggle="modal" data-target="#ModalBayarUtang" data-id="'.$id_transaksi.'">';
                    echo '  <i class="mdi mdi-plus"></i> Bayar '.$keterangan.'';
                    echo '</button>';
                }
            ?>
            <button class="btn btn-dark" id="EditTransaksiBaru" value="<?php echo "Edit,$kode_transaksi";?>">
                <i class="mdi mdi-pencil"></i> Edit
            </button>
            <a class="btn btn-dark" href="_Page/Transaksi/CetakDetailTransaksi.php?kode_transaksi=<?php echo "$kode_transaksi";?>" target="_blank">
                <i class="mdi mdi-printer"></i> Cetak
            </a>
            <button class="btn btn-dark" data-toggle="modal" data-toggle="modal" data-target="#ModalPilihListRetur" data-id="<?php echo $id_transaksi;?>">
                <i class="mdi mdi-undo"></i> Retur
            </button>
            <button class="btn btn-warning" id="DeleteTransaksi" value="<?php echo "$kode_transaksi";?>">
                <i class="mdi mdi-delete"></i> Hapus
            </button>
            <button class="btn btn-danger" data-dismiss="modal">
                <i class="mdi mdi-close"></i> Tutup
            </button>
        </div>
    </div>
</div>
