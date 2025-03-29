<div class="modal-header bg-primary">
    <div class="row">
        <div class="col col-md-12">
            <h3 class="text-white">
                <i class="mdi mdi-tag-text-outline"></i> Detail Faktur Retur Transaksi
            </h3>
        </div>
    </div>
</div>
<?php
    //koneksi
    ini_set("display_errors","off");
    include "../../_Config/Connection.php";
    //Tangkap variabel
    if(empty($_POST['kode'])){
        echo '<div class="modal-body bg-white">';
        echo '  <div class="row">';
        echo '      <div class="col col-md-12">';
        echo '          <h4 class="text-danger">Tidak ada kode retur</h4>';
        echo '          <small class="text-danger">Pastikan Data yang diinput sudah benar</small>';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        $kode=$_POST['kode'];
        //Buka Retur
        $QryRetur = mysqli_query($conn, "SELECT * FROM retur WHERE kode='$kode'")or die(mysqli_error($conn));
        $DataRetur = mysqli_fetch_array($QryRetur);
        $id_retur=$DataRetur['id_retur'];
        $id_transaksi=$DataRetur['id_transaksi'];
        $tanggal=$DataRetur['tanggal'];
        $subtotal=$DataRetur['subtotal'];
        $ppn=$DataRetur['ppn'];
        $diskon=$DataRetur['diskon'];
        $tagihan=$DataRetur['tagihan'];
        $pembayaran=$DataRetur['pembayaran'];
        $selisih=$DataRetur['selisih'];
        $keterangan=$DataRetur['keterangan'];
        //Buka transaksi
        $QryTransaksi = mysqli_query($conn, "SELECT * FROM transaksi WHERE id_transaksi='$id_transaksi'")or die(mysqli_error($conn));
        $DataTransaksi = mysqli_fetch_array($QryTransaksi);
        $kode_transaksi=$DataTransaksi['kode_transaksi'];
        $trans=$DataTransaksi['jenis_transaksi'];
        if(!empty($DataTransaksi['petugas'])){
            $petugas = $DataTransaksi['petugas'];
        }else{
            $petugas ="";
        }
        
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
    $('#CetakReturDirect').click(function(){
        $('#CetakReturDirect').html('....');
        var kode = "<?php echo $kode;?>";
        $.ajax({
            type 	: 'POST',
            url 	: '_Page/Retur/CetakReturDirect.php',
            data 	: { kode: kode },
            success : function(data){
                alert("Proses print sedang berlangsung..");
                $('#CetakReturDirect').html('Print Direct');
            }
        });
    });
    $('#HapusFakturRetur').click(function(){
        $('#NotifikasiHapusReturTransaksi').html('....');
        var kode = $('#HapusFakturRetur').val();
        $.ajax({
            type 	: 'POST',
            url 	: '_Page/Retur/HapusFaktur.php',
            data 	: { kode: kode },
            success : function(data){
                $('#NotifikasiHapusReturTransaksi').html(data);
                $('#ModalDetailFakturReturTransaksi').modal('hide');
                var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
                $('#TabelLogTransaksi').html(Loading);
                $.ajax({
                    type 	: 'POST',
                    url 	: '_Page/LogTransaksi/TabelRetur.php',
                    data    : { retur: "1" },
                    success : function(data){
                        $('#TabelLogTransaksi').html(data);
                        $('#KategoriPencarian').val('Retur');
                    }
                });
            }
        });
    });
</script>
<div class="modal-body bg-white">
    <div class="row">
        <div class="col col-md-12">
            <small>
                <table>
                    <tr>
                        <td><b>Kode Retur</b></td>
                        <td><b>:</b></td>
                        <td><?php echo $kode;?></td>
                    </tr>
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
                        <td><?php echo "Retur $trans";?></td>
                    </tr>
                    <?php
                        if($trans=="penjualan"){
                            echo '<tr>';
                            echo '  <td><b>Member</b></td>';
                            echo '  <td><b>:</b></td>';
                            echo '  <td>'.$NamaMember.'</td>';
                            echo '</tr>';
                        }else{
                            echo '<tr>';
                            echo '  <td><b>Supplier</b></td>';
                            echo '  <td><b>:</b></td>';
                            echo '  <td>'.$NamaMember.'</td>';
                            echo '</tr>';
                        }
                        if($petugas!==""){
                            echo '<tr>';
                            echo '  <td><b>Petugas</b></td>';
                            echo '  <td><b>:</b></td>';
                            echo '  <td>'.$petugas.'</td>';
                            echo '</tr>';
                        }
                    ?>
                </table>
            </small>
            <div class="table-responsive" style="height: 350px; overflow-y: scroll;">
                <table class="table table-sm table-bordered table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>No</th>
                            <th>Barang</th>
                            <th>Qty</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $no = 1;
                            //KONDISI PENGATURAN MASING FILTER
                            $query = mysqli_query($conn, "SELECT*FROM retur_rincian WHERE id_retur='$id_retur' ORDER BY id_rincian_retur DESC");
                            while ($data = mysqli_fetch_array($query)) {
                                $id_rincian_retur = $data['id_rincian_retur'];
                                $nama_barang = $data['nama_barang'];
                                $harga = $data['harga'];
                                $qty = $data['qty'];
                                $satuan = $data['satuan'];
                                $jumlah = $data['jumlah'];
                        ?>
                        <tr>
                            <td><?php echo "$no";?></td>
                            <td><?php echo "$nama_barang";?></td>
                            <td><?php echo "$qty $satuan";?></td>
                            <td><?php echo "" . number_format($harga,0,',','.');?></>
                            <td><?php echo "" . number_format($jumlah,0,',','.');?></td>
                        </tr>
                        <?php $no++;} ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer bg-primary">
    <div id="NotifikasiHapusReturTransaksi">
        <!--Notifikasi---->
    </div>
    <button type="button" id="CetakReturDirect" class="btn btn-sm btn-rounded btn-dark" value="<?php echo "$kode";?>">
        Print Direct
    </button>
    <a href="_Page/Retur/CetakReturHtml.php?kode=<?php echo "$kode";?>" target="_blank" class="btn  btn-sm btn-rounded btn-dark">
        HTML
    </a>
    <button type="button" class="btn  btn-sm btn-rounded btn-warning" data-dismiss="modal">
        <i class="mdi mdi-close"></i> Tutup
    </button>
    <button type="button" class="btn  btn-sm btn-rounded btn-danger" id="HapusFakturRetur" value="<?php echo "$kode";?>">
        <i class="mdi mdi-delete"></i> Hapus
    </button>
</div>
<?php } ?>