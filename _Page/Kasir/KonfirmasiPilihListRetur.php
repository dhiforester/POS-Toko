<?php
    include "../../_Config/Connection.php";
    if(!empty($_POST['id_transaksi'])){
        $id_transaksi=$_POST['id_transaksi'];
    }else{
        $id_transaksi="";
    }
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
?>
<script>
    $('#SetujuiKonfirmasiRetur').click(function(){
        var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
        var id_transaksi ="<?php echo $id_transaksi;?>";
        $('#ModalPilihTransaksiRetur').modal('hide');
        $('#ModalPilihListRetur').modal('hide');
        $('#Halaman').html(Loading);
        $.ajax({
            type 	: 'POST',
            url 	: '_Page/Retur/Retur.php',
            data 	:  { id_transaksi: id_transaksi },
            success : function(data){
                $('#Halaman').html(data);
            }
        });
    });
</script>

<div class="modal-header bg-danger">
    <div class="row">
        <div class="col col-md-12">
            <h3 class="text-white">Konfirmasi Retur</h3>
            <small class="text-white">Anda akan diarahkan pada halaman retur.</small>
        </div>
    </div>
</div>
<div class="modal-body bg-danger">
    <div class="row">
        <div class="col col-md-12">
            <small class="text-white">
                <table width="100%">
                    <tr>
                        <td><b>Kode</b></td>
                        <td><b>:</b></td>
                        <td><?php echo $kode_transaksi;?></td>
                    </tr>
                    <tr>
                        <td><b>Tanggal</b></td>
                        <td><b>:</b></td>
                        <td><?php echo $tanggal;?></td>
                    </tr>
                    <tr>
                        <td><b>Jenis</b></td>
                        <td><b>:</b></td>
                        <td><?php echo $trans;?></td>
                    </tr>
                    <tr>
                        <td><b>Tagihan</b></td>
                        <td><b>:</b></td>
                        <td><?php echo "Rp " . number_format($total_tagihan,0,',','.');?></td>
                    </tr>
                    <tr>
                        <td><b>Pembayaran</b></td>
                        <td><b>:</b></td>
                        <td><?php echo "Rp " . number_format($pembayaran,0,',','.');?></td>
                    </tr>
                    <tr>
                        <td><b>Keterangan</b></td>
                        <td><b>:</b></td>
                        <td><?php echo $keterangan;?></td>
                    </tr>
                    <tr>
                        <td><b>Member/Supplier</b></td>
                        <td><b>:</b></td>
                        <td><?php echo $NamaMember;?></td>
                    </tr>
                </table>
            </small>
        </div>
    </div>
</div>
<div class="modal-footer bg-danger">
    <div class="row">
        <div class="col col-md-12">
            <button class="btn btn-rounded btn-primary" id="SetujuiKonfirmasiRetur">
                <i class="mdi mdi-check-circle"></i> Ya
            </button>
            <button class="btn btn-rounded btn-light" data-dismiss="modal">
                <i class="mdi mdi-close"></i> Tidak
            </button>
        </div>
    </div>
</div>