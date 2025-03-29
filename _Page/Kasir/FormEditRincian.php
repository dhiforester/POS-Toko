<?php
    //koneksi dan error
    ini_set("display_errors","off");
    include "../../_Config/Connection.php";
    
    if(!empty($_POST['NewOrEdit'])){
        $NewOrEdit=$_POST['NewOrEdit'];
    }else{
        $NewOrEdit="";
    }

    if(!empty($_POST['id_rincian'])){
        $id_rincian=$_POST['id_rincian'];
    }else{
        $id_rincian="";
    }

    if(!empty($_POST['kode_transaksi'])){
        $kode_transaksi=$_POST['kode_transaksi'];
    }else{
        $kode_transaksi="";
    }

    if(!empty($_POST['jenis_transaksi'])){
        $jenis_transaksi=$_POST['jenis_transaksi'];
    }else{
        $jenis_transaksi="";
    }

    //Buka data rincian
    //Buka rincian transaksi
    $QryTransaksi = mysqli_query($conn, "SELECT * FROM rincian_transaksi WHERE id_rincian='$id_rincian'")or die(mysqli_error($conn));
    $DataTransaksi = mysqli_fetch_array($QryTransaksi);
    $id_obat=$DataTransaksi['id_obat'];
    $nama=$DataTransaksi['nama'];
    $qty = $DataTransaksi['qty'];
    $harga = $DataTransaksi['harga'];
    $jumlah = $DataTransaksi['jumlah'];
    $id_multi = $DataTransaksi['id_multi'];
    $standar_harga = $DataTransaksi['standar_harga'];
    //Buka data barang
    $QryObat = mysqli_query($conn, "SELECT * FROM obat WHERE id_obat='$id_obat'")or die(mysqli_error($conn));
    $DataObat = mysqli_fetch_array($QryObat);
    $nama= $DataObat['nama'];
    $kode = $DataObat['kode'];
    $kategori = $DataObat['kategori'];
    $satuan = $DataObat['satuan'];
    $SatuanUtamaBarang = $DataObat['satuan'];
    $stok= $DataObat['stok'];
    $harga_1= $DataObat['harga_1'];
    $harga_2= $DataObat['harga_2'];
    $harga_3= $DataObat['harga_3'];
    $harga_4= $DataObat['harga_4'];
    if($standar_harga=="harga_1"){
        $NamaHarga="Harga Beli";
        $harga= $DataObat['harga_1'];
    }else{
        if($standar_harga=="harga_2"){
            $NamaHarga="Harga Grosir";
            $harga= $DataObat['harga_2'];
        }else{
            if($standar_harga=="harga_3"){
                $NamaHarga="Harga Toko";
                $harga= $DataObat['harga_3'];
            }else{
                if($standar_harga=="harga_4"){
                    $NamaHarga="Harga Eceran";
                    $harga= $DataObat['harga_4'];
                }else{
                    if($standar_harga==""){
                        $NamaHarga="Harga Eceran";
                        $harga= $DataTransaksi['harga'];
                    }
                }
            }
        }
    }
    //Buka satuan
    if(empty($id_multi)){
        $QryBarang = mysqli_query($conn, "SELECT * FROM obat WHERE id_obat='$id_obat'")or die(mysqli_error($conn));
        $DataBarang = mysqli_fetch_array($QryBarang);
        $satuan=$DataBarang['satuan'];
    }else{
        $QryBarang = mysqli_query($conn, "SELECT * FROM muti_harga WHERE id_multi='$id_multi'")or die(mysqli_error($conn));
        $DataBarang = mysqli_fetch_array($QryBarang);
        $satuan=$DataBarang['satuan'];
    }
?>
    <script>
        $('#StandarHarga2').change(function(){
            var StandarHarga2 = $('#StandarHarga2').val();
            var IdBarang =$('#IdBarang2').val();
            var IdMulti =$('#IdMulti').val();
            var JumlahQty2 = $('#JumlahQty2').val();
            if(IdMulti==""){
                if(StandarHarga2=="harga_1"){
                    var harga="<?php echo $harga_1;?>";
                    var harga = parseInt(harga);
                    var JumlahQty2Par = parseInt(JumlahQty2);
                    var Subtotal=JumlahQty2Par*harga;
                    $('#NilaiSubtotal2').html(Subtotal);
                    $('#IdHargaSekarang2').val(harga);
                }
                if(StandarHarga2=="harga_2"){
                    var harga="<?php echo $harga_2;?>";
                    var harga = parseInt(harga);
                    var JumlahQty2Par = parseInt(JumlahQty2);
                    var Subtotal=JumlahQty2Par*harga;
                    $('#NilaiSubtotal2').html(Subtotal);
                    $('#IdHargaSekarang2').val(harga);
                }
                if(StandarHarga2=="harga_3"){
                    var harga="<?php echo $harga_3;?>";
                    var harga = parseInt(harga);
                    var JumlahQty2Par = parseInt(JumlahQty2);
                    var Subtotal=JumlahQty2Par*harga;
                    $('#NilaiSubtotal2').html(Subtotal);
                    $('#IdHargaSekarang2').val(harga);
                }
                if(StandarHarga2=="harga_4"){
                    var harga="<?php echo $harga_4;?>";
                    var harga = parseInt(harga);
                    var JumlahQty2Par = parseInt(JumlahQty2);
                    var Subtotal=JumlahQty2Par*harga;
                    $('#NilaiSubtotal2').html(Subtotal);
                    $('#IdHargaSekarang2').val(harga);
                }
                if(StandarHarga2==""){
                    var harga="0";
                    $('#IdHargaSekarang2').val(harga);
                    $('#NilaiSubtotal2').html("0");
                }
            }else{
                $.ajax({
                    type 	: 'POST',
                    url 	: '_Page/Kasir/CariMultiHarga.php',
                    data 	: {StandarHarga: StandarHarga2, IdBarang: IdBarang, id_multi: IdMulti},
                    success : function(data){
                        //Hilangkan spasi dengan trim coy....
                        var hargaJadi=data.trim();
                        $('#IdHargaSekarang2').val(hargaJadi);
                        var hargaJadiPar=parseInt(hargaJadi);
                        if(JumlahQty2!==""){
                            var Subtotal=JumlahQty2*hargaJadiPar;
                            $('#NilaiSubtotal2').html(Subtotal);
                        }else{
                            $('#NilaiSubtotal2').html("0");
                        }
                    }
                });
            }
        });
        $('#IdMulti').change(function(){
            var StandarHarga2 = $('#StandarHarga2').val();
            var IdBarang =$('#IdBarang2').val();
            var IdMulti =$('#IdMulti').val();
            var JumlahQty2 = $('#JumlahQty2').val();
            if(IdMulti==""){
                if(StandarHarga2=="harga_1"){
                    var harga="<?php echo $harga_1;?>";
                    var harga = parseInt(harga);
                    var JumlahQty2Par = parseInt(JumlahQty2);
                    var Subtotal=JumlahQty2Par*harga;
                    $('#NilaiSubtotal2').html(Subtotal);
                    $('#IdHargaSekarang2').val(harga);
                }
                if(StandarHarga2=="harga_2"){
                    var harga="<?php echo $harga_2;?>";
                    var harga = parseInt(harga);
                    var JumlahQty2Par = parseInt(JumlahQty2);
                    var Subtotal=JumlahQty2Par*harga;
                    $('#NilaiSubtotal2').html(Subtotal);
                    $('#IdHargaSekarang2').val(harga);
                }
                if(StandarHarga2=="harga_3"){
                    var harga="<?php echo $harga_3;?>";
                    var harga = parseInt(harga);
                    var JumlahQty2Par = parseInt(JumlahQty2);
                    var Subtotal=JumlahQty2Par*harga;
                    $('#NilaiSubtotal2').html(Subtotal);
                    $('#IdHargaSekarang2').val(harga);
                }
                if(StandarHarga2=="harga_4"){
                    var harga="<?php echo $harga_4;?>";
                    var harga = parseInt(harga);
                    var JumlahQty2Par = parseInt(JumlahQty2);
                    var Subtotal=JumlahQty2Par*harga;
                    $('#NilaiSubtotal2').html(Subtotal);
                    $('#IdHargaSekarang2').val(harga);
                }
                if(StandarHarga2==""){
                    var harga="0";
                    $('#IdHargaSekarang2').val(harga);
                    $('#NilaiSubtotal2').html("0");
                }
            }else{
                $.ajax({
                    type 	: 'POST',
                    url 	: '_Page/Kasir/CariMultiHarga.php',
                    data 	: {StandarHarga: StandarHarga2, IdBarang: IdBarang, id_multi: IdMulti},
                    success : function(data){
                        //Hilangkan spasi dengan trim coy....
                        var hargaJadi=data.trim();
                        $('#IdHargaSekarang2').val(hargaJadi);
                        var hargaJadiPar=parseInt(hargaJadi);
                        if(JumlahQty2!==""){
                            var Subtotal=JumlahQty2*hargaJadiPar;
                            $('#NilaiSubtotal2').html(Subtotal);
                        }else{
                            $('#NilaiSubtotal2').html("0");
                        }
                    }
                });
            }
        });
        $('#JumlahQty2').keyup(function(){
            var JumlahQty2 = $('#JumlahQty2').val();
            var harga =$('#IdHargaSekarang2').val();
            var harga = parseInt(harga);
            var JumlahQty2Par = parseInt(JumlahQty2);
            if(JumlahQty2==""){
                $('#NilaiSubtotal2').val("Rp 0");
            }else{
                if(JumlahQty2.match(/^\d+/)){
                    var Subtotal=JumlahQty2Par*harga;
                    $('#NilaiSubtotal2').html(Subtotal);
                }else{
                    $('#NilaiSubtotal2').html("<i class='text-danger'>Maaf! Hanya Boleh Angka</i>");
                }
                
            }
        });
        $('#IdHargaSekarang2').keyup(function(){
            var JumlahQty2 = $('#JumlahQty2').val();
            var harga =$('#IdHargaSekarang2').val();
            var hargaPar = parseInt(harga);
            var JumlahQty2Par = parseInt(JumlahQty2);
            if(JumlahQty2==""){
                $('#NilaiSubtotal2').val("Rp 0");
            }else{
                if(harga.match(/^\d+/)){
                    var Subtotal=JumlahQty2Par*hargaPar;
                    $('#NilaiSubtotal2').html(Subtotal);
                }else{
                    $('#NilaiSubtotal2').html("<i class='text-danger'>Maaf! Hanya Boleh Angka</i>");
                }
            }
        });
    </script>
<div class="modal-header bg-dark">
    <h4 class="text-white"><i class="mdi mdi-pencil"></i> <?php echo $nama;?></h4>
</div>
<form action="javascript:void(0);" id="ProsesEditRincian">
    <input type="hidden" id="IdBarang2" name="id_obat" value="<?php echo "$id_obat"; ?>">
    <input type="hidden" name="id_rincian" value="<?php echo $id_rincian;?>">
    <input type="hidden" name="kode_transaksi" value="<?php echo $kode_transaksi;?>">
    <input type="hidden" name="NewOrEdit" value="<?php echo $NewOrEdit;?>">
    <input type="hidden" name="jenis_transaksi" value="<?php echo $jenis_transaksi;?>">
    <div class="modal-body bg-white">
        <div class="form-group row">
            <div class="form-input col-md-6">
                <label>Kategori Harga</label>
                <select name="StandarHarga" id="StandarHarga2" class="form-control form">
                    <option value="harga_1" <?php if($standar_harga=="harga_1"){echo "selected";} ?>>Harga Beli</option>
                    <option value="harga_2" <?php if($standar_harga=="harga_2"){echo "selected";} ?>>Harga Grosir</option>
                    <option value="harga_3" <?php if($standar_harga=="harga_3"){echo "selected";} ?>>Harga Toko</option>
                    <option value="harga_4" <?php if($standar_harga=="harga_4"){echo "selected";} ?>>Harga Eceran</option>
                </select>
            </div>
            <div class="form-input col-md-6">
                <label>Multi Satuan</label>
                <select name="id_multi" id="IdMulti" class="form-control">
                    <option value="" <?php if(empty($id_multi)){echo "selected";} ?>>Satuan Utama (<?php echo $SatuanUtamaBarang;?>)</option>
                    <?php
                         $QryMulti = mysqli_query($conn, "SELECT*FROM muti_harga WHERE id_barang='$id_obat'");
                         while ($DataMulti = mysqli_fetch_array($QryMulti)) {
                             $id_multiData = $DataMulti['id_multi'];
                             $SatuanMulti = $DataMulti['satuan'];
                             $konversiMulti = $DataMulti['konversi'];
                             $stokMulti = $DataMulti['stok'];
                             if($id_multiData=="$id_multi"){
                                echo '<option value="'.$id_multiData.'" selected>'.$SatuanMulti.'</option>';
                             }else{
                                echo '<option value="'.$id_multiData.'">'.$SatuanMulti.'</option>';
                             }
                             
                         }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="form-input col-md-6">
                <label>Qty</label>
                <input type="text" min="0" name="qty" id="JumlahQty2" class="form-control border-warning" value="<?php echo $qty;?>">
            </div>
            <div class="form-input col-md-6">
                <label>Harga Satuan (Rp)</label>
                <input type="text" min="0" name="harga" id="IdHargaSekarang2" class="form-control border-warning" value="<?php echo $harga;?>">
            </div>
        </div>
        <div class="row">
            <div class="col col-md-12 text-center">
                <small class="text-primary">Stok Barang :<?php echo "" . number_format($stok,0,',','.');?> <?php echo $satuan;?></small>
            </div>
        </div>
        <div class="row">
            <div class="col col-md-12 text-center">
                <b class="text-primary">Sub Total : </b><br>
                <h3 class="text-primary" id="NilaiSubtotal2"><?php echo "$jumlah";?></h3>
            </div>
        </div>
        <div class="row">
            <div class="form-input col-md-12" id="NotifikasiEditRincian">
                <div class="alert alert-primary" role="alert">
                    <small>Pastikan data yang anda input sudah benar</small>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer bg-dark">
        <div class="row">
            <div class="form-group col-md-12 text-center">
                <button type="reset" class="btn btn-rounded btn-outline-warning">
                    <i class="mdi mdi-undo"></i>
                </button>
                <button type="submit" class="btn btn-rounded btn-outline-primary">
                    Simpan
                </button>
                <button class="btn btn-rounded btn-outline-danger" data-dismiss="modal">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</form>