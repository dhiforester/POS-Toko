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
    $(document).on("keyup", function(event) {
        if (event.keyCode === 119) {
            document.getElementById("CetakNotaDirect").click();
        }
    });
    $('#CetakNotaDirect').click(function(){
        var kode_transaksi="<?php echo $kode_transaksi;?>";
        $.ajax({
            type 	: 'POST',
            url 	: '_Page/Transaksi/CetakDetailTransaksiDirect.php',
            data 	: { kode_transaksi: kode_transaksi },
            success : function(data){
                alert("Proses print sedang berlangsung");
            }
        });
    });
</script>
<div class="modal-header bg-dark">
    <h4 class="text-white">Detail Transaksi</h4>
</div>
<div class="modal-body bg-white">
    <div class="row">
        <div class="col-md-6">
            <small>
                <table width="100%">
                    <tr>
                        <td><b>Kode</b></td>
                        <td><b>:</b></td>
                        <td><?php echo "$kode_transaksi";?></td>
                        <td><b>Petugas</b></td>
                        <td><b>:</b></td>
                        <td><?php echo "$petugas";?></td>
                    </tr>
                    <tr>
                        <td><b>Tanggal</b></td>
                        <td><b>:</b></td>
                        <td><?php echo "$tanggal";?></td>
                        <td><b>Transaksi</b></td>
                        <td><b>:</b></td>
                        <td><?php echo "$trans";?></td>
                    </tr>
                    <?php
                        if($trans=="penjualan"){
                            echo '<tr>';
                            echo '  <td><b>Member</b></td>';
                            echo '  <td><b>:</b></td>';
                            echo "  <td>$NamaMember</td>";
                            echo '  <td><b>Point</b></td>';
                            echo '  <td><b>:</b></td>';
                            echo "  <td>$point</td>";
                            echo '</tr>';
                        }if($trans=="pembelian"){
                            echo '<tr>';
                            echo '  <td><b>Supplier</b></td>';
                            echo '  <td><b>:</b></td>';
                            echo "  <td>$NamaMember</td>";
                            echo '</tr>';
                        }
                    ?>

                </table>
            </small>
        </div>
        <div class="col-md-6 text-right">
            <h1 class="text-danger"> KEMBALIAN : <br><b id="TampilkanKembalianTransaksi"></br></h1>
        </div>
    </div>
</div>
<div class="modal-body bg-white">
    <div class="row">
        <div class="col-md-12" style="height: 350px; overflow-y: scroll;">
            <small>
                <div class="table-responsive">
                    <table class="table table-bordered scroll-container">
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
            </small>
        </div>
    </div>
</div>
<div class="modal-footer bg-dark">
    <div class="row">
        <div class="form-group col-md-12 text-center">
            <button type="button" id="CetakNotaDirect" class="btn btn-lg btn-rounded btn-warning" value="<?php echo "$kode_transaksi";?>">
                Cetak Direct(F8)
            </button>
            <a href="_Page/Transaksi/CetakDetailTransaksi.php?kode_transaksi=<?php echo "$kode_transaksi";?>" target="_blank" id="CetakNota" class="btn btn-lg btn-rounded btn-primary">
                Preview HTML
            </a>
            <a href="_Page/Transaksi/CetakDetailTransaksiPdf.php?kode_transaksi=<?php echo "$kode_transaksi";?>" target="_blank" id="CetakNota" class="btn btn-lg btn-rounded btn-primary">
                Print PDF
            </a>
        </div>
    </div>
</div>
