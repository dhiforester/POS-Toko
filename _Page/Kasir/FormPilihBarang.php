<?php
    //koneksi dan error
    ini_set("display_errors","off");
    include "../../_Config/Connection.php";
    //jenis_transaksi
    if(!empty($_POST['jenis_transaksi'])){
        $jenis_transaksi=$_POST['jenis_transaksi'];
    }else{
        $jenis_transaksi="";
    }
    //StandarHarga
    if(!empty($_POST['StandarHarga'])){
        $StandarHarga=$_POST['StandarHarga'];
    }else{
        $StandarHarga="";
    }
    //NewOrEdit
    if(!empty($_POST['NewOrEdit'])){
        $NewOrEdit=$_POST['NewOrEdit'];
    }else{
        $NewOrEdit="";
    }
    //id_obat
    if(!empty($_POST['id_obat'])){
        $id_obat=$_POST['id_obat'];
    }else{
        $id_obat="";
    }
    //kode_transaksi
    if(!empty($_POST['kode_transaksi'])){
        $kode_transaksi=$_POST['kode_transaksi'];
    }else{
        $kode_transaksi="";
    }
    //Detail Obat
    if(!empty($id_obat)){
        //Buka data obat
        $QryObat = mysqli_query($conn, "SELECT * FROM obat WHERE id_obat='$id_obat'")or die(mysqli_error($conn));
        $DataObat = mysqli_fetch_array($QryObat);
        $nama= $DataObat['nama'];
        $kode = $DataObat['kode'];
        $kategori = $DataObat['kategori'];
        $satuan = $DataObat['satuan'];
        $stok= $DataObat['stok'];
        $harga_1= $DataObat['harga_1'];
        $harga_2= $DataObat['harga_2'];
        $harga_3= $DataObat['harga_3'];
        $harga_4= $DataObat['harga_4'];
        
        if($StandarHarga=="harga_1"){
            $NamaHarga="Harga Beli";
            $harga= $DataObat['harga_1'];
        }else{
            if($StandarHarga=="harga_2"){
                $NamaHarga="Harga Grosir";
                $harga= $DataObat['harga_2'];
            }else{
                if($StandarHarga=="harga_3"){
                    $NamaHarga="Harga Toko";
                    $harga= $DataObat['harga_3'];
                }else{
                    if($StandarHarga=="harga_4"){
                        $NamaHarga="Harga Eceran";
                        $harga= $DataObat['harga_4'];
                    }else{
                        if($StandarHarga==""){
                            $NamaHarga="Harga Eceran";
                            $harga= $DataObat['harga_4'];
                        }
                    }
                }
            }
        }
    }else{
        $nama="ERROR ID BARANG";
    }
?>
    <script>
        $('#StandarHarga').change(function(){
            var StandarHarga = $('#StandarHarga').val();
            var IdBarang =$('#IdBarang').val();
            var id_multi =$('#id_multi').val();
            var JumlahQty = $('#JumlahQty').val();
            if(id_multi==""){
                if(StandarHarga=="harga_1"){
                    var harga="<?php echo $harga_1;?>";
                    var harga = parseInt(harga);
                    var JumlahQtyPar = parseInt(JumlahQty);
                    var Subtotal=JumlahQtyPar*harga;
                    $('#NilaiSubtotal').html(Subtotal);
                    $('#IdHargaSekarang').val(harga);
                }
                if(StandarHarga=="harga_2"){
                    var harga="<?php echo $harga_2;?>";
                    var harga = parseInt(harga);
                    var JumlahQtyPar = parseInt(JumlahQty);
                    var Subtotal=JumlahQtyPar*harga;
                    $('#NilaiSubtotal').html(Subtotal);
                    $('#IdHargaSekarang').val(harga);
                }
                if(StandarHarga=="harga_3"){
                    var harga="<?php echo $harga_3;?>";
                    var harga = parseInt(harga);
                    var JumlahQtyPar = parseInt(JumlahQty);
                    var Subtotal=JumlahQtyPar*harga;
                    $('#NilaiSubtotal').html(Subtotal);
                    $('#IdHargaSekarang').val(harga);
                }
                if(StandarHarga=="harga_4"){
                    var harga="<?php echo $harga_4;?>";
                    var harga = parseInt(harga);
                    var JumlahQtyPar = parseInt(JumlahQty);
                    var Subtotal=JumlahQtyPar*harga;
                    $('#NilaiSubtotal').html(Subtotal);
                    $('#IdHargaSekarang').val(harga);
                }
                if(StandarHarga==""){
                    var harga="0";
                    $('#IdHargaSekarang').val(harga);
                    $('#NilaiSubtotal').html("0");
                }
            }else{
                $.ajax({
                    type 	: 'POST',
                    url 	: '_Page/Kasir/CariMultiHarga.php',
                    data 	: {StandarHarga: StandarHarga, IdBarang: IdBarang, id_multi: id_multi},
                    success : function(data){
                        //Hilangkan spasi dengan trim coy....
                        var hargaJadi=data.trim();
                        $('#IdHargaSekarang').val(hargaJadi);
                        var hargaJadiPar=parseInt(hargaJadi);
                        if(JumlahQty!==""){
                            var Subtotal=JumlahQty*hargaJadiPar;
                            $('#NilaiSubtotal').html(Subtotal);
                        }else{
                            $('#NilaiSubtotal').html("0");
                        }
                    }
                });
            }
        });
        $('#id_multi').change(function(){
            var StandarHarga = $('#StandarHarga').val();
            var IdBarang =$('#IdBarang').val();
            var id_multi =$('#id_multi').val();
            var JumlahQty = $('#JumlahQty').val();
            if(id_multi==""){
                if(StandarHarga=="harga_1"){
                    var harga="<?php echo $harga_1;?>";
                    var harga = parseInt(harga);
                    var JumlahQtyPar = parseInt(JumlahQty);
                    var Subtotal=JumlahQtyPar*harga;
                    $('#NilaiSubtotal').html(Subtotal);
                    $('#IdHargaSekarang').val(harga);
                }
                if(StandarHarga=="harga_2"){
                    var harga="<?php echo $harga_2;?>";
                    var harga = parseInt(harga);
                    var JumlahQtyPar = parseInt(JumlahQty);
                    var Subtotal=JumlahQtyPar*harga;
                    $('#NilaiSubtotal').html(Subtotal);
                    $('#IdHargaSekarang').val(harga);
                }
                if(StandarHarga=="harga_3"){
                    var harga="<?php echo $harga_3;?>";
                    var harga = parseInt(harga);
                    var JumlahQtyPar = parseInt(JumlahQty);
                    var Subtotal=JumlahQtyPar*harga;
                    $('#NilaiSubtotal').html(Subtotal);
                    $('#IdHargaSekarang').val(harga);
                }
                if(StandarHarga=="harga_4"){
                    var harga="<?php echo $harga_4;?>";
                    var harga = parseInt(harga);
                    var JumlahQtyPar = parseInt(JumlahQty);
                    var Subtotal=JumlahQtyPar*harga;
                    $('#NilaiSubtotal').html(Subtotal);
                    $('#IdHargaSekarang').val(harga);
                }
                if(StandarHarga==""){
                    var harga="0";
                    $('#IdHargaSekarang').val(harga);
                    $('#NilaiSubtotal').html("0");
                }
            }else{
                $.ajax({
                    type 	: 'POST',
                    url 	: '_Page/Kasir/CariMultiHarga.php',
                    data 	: {StandarHarga: StandarHarga, IdBarang: IdBarang, id_multi: id_multi},
                    success : function(data){
                        //Hilangkan spasi dengan trim coy....
                        var hargaJadi=data.trim();
                        $('#IdHargaSekarang').val(hargaJadi);
                        var hargaJadiPar=parseInt(hargaJadi);
                        if(JumlahQty!==""){
                            var Subtotal=JumlahQty*hargaJadiPar;
                            $('#NilaiSubtotal').html(Subtotal);
                        }else{
                            $('#NilaiSubtotal').html("0");
                        }
                    }
                });
            }
        });
        $('#ModalPilihBarang').on('shown.bs.modal', function() {
            $('#JumlahQty').keyup(function(){
                var JumlahQty = $('#JumlahQty').val();
                var harga =$('#IdHargaSekarang').val();
                var harga = parseInt(harga);
                var JumlahQtyPar = parseInt(JumlahQty);
                if(JumlahQty==""){
                    $('#NilaiSubtotal').val("Rp 0");
                }else{
                    if(JumlahQty.match(/^\d+/)){
                        var Subtotal=JumlahQtyPar*harga;
                        $('#NilaiSubtotal').html(Subtotal);
                    }else{
                        $('#NilaiSubtotal').html("<i class='text-danger'>Maaf! Hanya Boleh Angka</i>");
                    }
                    
                }
            });
            $('#IdHargaSekarang').keyup(function(){
                var JumlahQty = $('#JumlahQty').val();
                var harga =$('#IdHargaSekarang').val();
                var hargaPar = parseInt(harga);
                var JumlahQtyPar = parseInt(JumlahQty);
                if(JumlahQty==""){
                    $('#NilaiSubtotal').val("Rp 0");
                }else{
                    if(harga.match(/^\d+/)){
                        var Subtotal=JumlahQtyPar*hargaPar;
                        $('#NilaiSubtotal').html(Subtotal);
                    }else{
                        $('#NilaiSubtotal').html("<i class='text-danger'>Maaf! Hanya Boleh Angka</i>");
                    }
                }
            });
        });
        //Tambah Rincian
        $('#ProsesPilihBarang').submit(function(){
            var ProsesPilihBarang = $('#ProsesPilihBarang').serialize();
            $('#TombolTambahkan').html('Loading..');
            $.ajax({
                url     : "_Page/Kasir/ProsesTambahRincian.php",
                method  : "POST",
                data    : ProsesPilihBarang,
                success: function (data) {
                    $('#NotifikasiTambahRincian').html(data);
                    var NotifikasiTambahRincianBerhasil=$('#NotifikasiTambahRincianBerhasil').html();
                    if(NotifikasiTambahRincianBerhasil=="Ok"){
                        $('#ModalPilihBarang').modal('hide');
                        $('#ModalTambahRincian').modal('hide');
                        $.ajax({
                            type 	: 'POST',
                            url 	: '_Page/Kasir/Kasir.php',
                            data 	:  ProsesPilihBarang,
                            success : function(data){
                                $('#Halaman').html(data);
                            }
                        });
                    }
                }
            })
        });
    </script>
<form action="javascript:void(0);" autocomplete="off" id="ProsesPilihBarang">
    <input type="hidden" name="jenis_transaksi" value="<?php echo "$jenis_transaksi"; ?>">
    <input type="hidden" name="NewOrEdit" value="<?php echo "$NewOrEdit"; ?>">
    <input type="hidden" id="IdBarang" name="id_obat" value="<?php echo "$id_obat"; ?>">
    <input type="hidden" name="kode_transaksi" value="<?php echo "$kode_transaksi"; ?>">
    <input type="hidden" name="nama" value="<?php echo "$nama"; ?>">
    <input type="hidden" name="stok" value="<?php echo "$stok"; ?>">
    <script>
        $('#ModalPilihBarang').on('shown.bs.modal', function() {
            $('#JumlahQty').focus();
        });
    </script>
    <div class="modal-header">
        <div class="row">
            <div class="col col-md-12">
                <h3 class="text-white"><?php echo $nama;?></h3>
            </div>
        </div>
    </div>
    <div class="modal-body">
        <div class="form-group row">
            <div class="col col-md-6 text-left">
                <label class="text-white">Kategori</label><br>
                <select name="StandarHarga" id="StandarHarga" class="form-control">
                    <option value="harga_1" <?php if($StandarHarga=="harga_1"){echo "selected";}else{ echo "";} ?>>Harga Beli</option>
                    <option value="harga_2" <?php if($StandarHarga=="harga_2"){echo "selected";}else{ echo "";} ?>>Harga Grosir</option>
                    <option value="harga_3" <?php if($StandarHarga=="harga_3"){echo "selected";}else{ echo "";} ?>>Harga Toko</option>
                    <option value="harga_4" <?php if($StandarHarga=="harga_4"){echo "selected";}else{ echo "";} ?>>Harga Eceran</option>
                </select>
            </div>
            <div class="col col-md-6 text-left">
                <label class="text-white">Multi Satuan</label><br>
                <select name="id_multi" id="id_multi" class="form-control">
                    <option value="">Satuan Utama (<?php echo $satuan;?>)</option>
                    <?php
                         $QryMulti = mysqli_query($conn, "SELECT*FROM muti_harga WHERE id_barang='$id_obat'");
                         while ($DataMulti = mysqli_fetch_array($QryMulti)) {
                             $id_multi = $DataMulti['id_multi'];
                             $harga1 = $DataMulti['harga1'];
                             $harga2 = $DataMulti['harga2'];
                             $harga3 = $DataMulti['harga3'];
                             $harga4 = $DataMulti['harga4'];
                             $SatuanMulti = $DataMulti['satuan'];
                             $konversiMulti = $DataMulti['konversi'];
                             $stokMulti = $DataMulti['stok'];
                             echo '<option value="'.$id_multi.'">'.$SatuanMulti.'</option>';
                         }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="col col-md-6 text-left">
                <label class="text-white">Harga</label><br>
                <input type="text" required name="harga" id="IdHargaSekarang" autocomplete="false" class="form-control" value="<?php echo "$harga"; ?>">
            </div>
            <div class="col col-md-6 text-left">
                <label class="text-white">Jumlah/Kuantitas</label><br>
                <input type="text" required name="qty" id="JumlahQty" autocomplete="false" class="form-control" value="">
            </div>
        </div>
        <div class="row">
            <div class="col col-md-12 text-center">
                <small class="text-white">Stok Barang :<?php echo "" . number_format($stok,0,',','.');?> <?php echo $satuan;?></small>
            </div>
        </div>
        <div class="row">
            <div class="col col-md-12 text-center">
                <b class="text-white">Sub Total : </b><br>
                <h3 class="text-white" id="NilaiSubtotal">0</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md col-12">
                <div class="alert alert-primary" role="alert">
                    <small><b>Notifikasi :</b><i id="NotifikasiTambahRincian">Pastikan data yang anda input sudah lengkap!</i></small>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-body text-center">
        <div class="row">
            <div class="form-group col-md-12 text-center">
                <button type="reset" class="btn btn-lg btn-rounded btn-outline-warning" id="TombolReset">
                    <i class="mdi mdi-undo"></i>
                </button>
                <button type="submit" class="btn btn-lg btn-rounded btn-outline-primary" id="TombolTambahkan">
                    Tambahkan
                </button>
                <button class="btn btn-lg btn-rounded btn-outline-danger" data-dismiss="modal">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</form>
