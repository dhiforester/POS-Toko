<?php
    ini_set("display_errors","off");
    include "../../_Config/Connection.php";
    //NewOrEdit
    if(!empty($_POST['NewOrEdit'])){
        $NewOrEdit=$_POST['NewOrEdit'];
    }else{
        $NewOrEdit="";
    }
    //id_rincian
    if(!empty($_POST['id_rincian'])){
        $id_rincian=$_POST['id_rincian'];
    }else{
        $id_rincian="";
    }
    //Buka data rincian
    $QryRincian = mysqli_query($conn, "SELECT * FROM rincian_transaksi WHERE id_rincian='$id_rincian'")or die(mysqli_error($conn));
    $DataRincian = mysqli_fetch_array($QryRincian);
    if(!empty($DataRincian['id_rincian'])){
        $kode_transaksi= $DataRincian['kode_transaksi'];
        $id_obat = $DataRincian['id_obat'];
        $id_multi= $DataRincian['id_multi'];
        $standar_harga= $DataRincian['standar_harga'];
        $nama= $DataRincian['nama'];
        $qty= $DataRincian['qty'];
        $harga= $DataRincian['harga'];
        $jumlah= $DataRincian['jumlah'];
        //Data barang
        $QryBarang = mysqli_query($conn, "SELECT * FROM obat WHERE id_obat='$id_obat'")or die(mysqli_error($conn));
        $DataBarang = mysqli_fetch_array($QryBarang);
        $kode= $DataBarang['kode'];
        $nama= $DataBarang['nama'];
        $satuan= $DataBarang['satuan'];
        $harga_1= $DataBarang['harga_1'];
        $harga_2= $DataBarang['harga_2'];
        $harga_3= $DataBarang['harga_3'];
        $harga_4= $DataBarang['harga_4'];
        //Data Transaksi
        $QryTransaksi = mysqli_query($conn, "SELECT * FROM transaksi WHERE kode_transaksi='$kode_transaksi'")or die(mysqli_error($conn));
        $DataTransaksi = mysqli_fetch_array($QryTransaksi);
        $id_transaksi= $DataTransaksi['id_transaksi'];
        $trans= $DataTransaksi['jenis_transaksi'];
    }else{
        $kode_transaksi="";
        $id_obat ="";
        $id_multi="";
        $standar_harga="";
        $nama="";
        $qty="";
        $harga="";
        $jumlah="0";
        $kode="";
        $nama="";
        $satuan="";
        $harga_1="";
        $harga_2="";
        $harga_3="";
        $harga_4="";
    }
?>
<script>
    $('#qty').focus();
    //Ketika qty diketik
    $('#qty').keyup(function(){
        var JumlahQty = $('#qty').val();
        if(JumlahQty.match(/^\d+/)){
            var harga =$('#harga').val();
            if(harga.match(/^\d+/)){
                var harga = parseInt(harga);
                var JumlahQtyPar = parseInt(JumlahQty);
                if(JumlahQty==""){
                    $('#NilaiJumlah').val("Rp 0");
                }else{
                    var Subtotal=JumlahQtyPar*harga;
                    var	number_string = Subtotal.toString(),
                        split	= number_string.split(','),
                        sisa 	= split[0].length % 3,
                        rupiah 	= split[0].substr(0, sisa),
                        ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
                            
                    if (ribuan) {
                        separator = sisa ? '.' : '';
                        rupiah += separator + ribuan.join('.');
                    }
                    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                    $('#NilaiJumlah').html(rupiah);
                }
                $('#LabelQty').html("");
                $('#LabelHarga').html("");
            }else{
                $('#LabelHarga').html("<small class='text-danger'>Error!! Hanya Boleh Angka</small>");
            }
        }else{
            $('#LabelQty').html("<small class='text-danger'>Error!! Hanya Boleh Angka</small>");
        }
    });
    //Ketika harga diketik
    $('#harga').keyup(function(){
        var JumlahQty = $('#qty').val();
        if(JumlahQty.match(/^\d+/)){
            var harga =$('#harga').val();
            if(harga.match(/^\d+/)){
                var harga = parseInt(harga);
                var JumlahQtyPar = parseInt(JumlahQty);
                if(JumlahQty==""){
                    $('#NilaiJumlah').val("Rp 0");
                }else{
                    var Subtotal=JumlahQtyPar*harga;
                    var	number_string = Subtotal.toString(),
                        split	= number_string.split(','),
                        sisa 	= split[0].length % 3,
                        rupiah 	= split[0].substr(0, sisa),
                        ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
                            
                    if (ribuan) {
                        separator = sisa ? '.' : '';
                        rupiah += separator + ribuan.join('.');
                    }
                    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                    $('#NilaiJumlah').html(rupiah);
                }
                $('#LabelQty').html("");
                $('#LabelHarga').html("");
            }else{
                $('#LabelHarga').html("<small class='text-danger'>Error!! Hanya Boleh Angka</small>");
            }
        }else{
            $('#LabelQty').html("<small class='text-danger'>Error!! Hanya Boleh Angka</small>");
        }
    });
    //Ketika kategori di pilih
    $('#StandarHarga').change(function(){
        var StandarHarga = $('#StandarHarga').val();
        var IdBarang ="<?php echo $id_obat;?>";
        var id_multi =$('#id_multi').val();
        var JumlahQty = $('#qty').val();
        if(JumlahQty.match(/^\d+/)){
            if(id_multi==""){
                if(StandarHarga=="harga_1"){
                    var harga="<?php echo $harga_1;?>";
                    var harga = parseInt(harga);
                    var JumlahQtyPar = parseInt(JumlahQty);
                    var Subtotal=JumlahQtyPar*harga;
                    var	number_string = Subtotal.toString(),
                        split	= number_string.split(','),
                        sisa 	= split[0].length % 3,
                        rupiah 	= split[0].substr(0, sisa),
                        ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
                            
                    if (ribuan) {
                        separator = sisa ? '.' : '';
                        rupiah += separator + ribuan.join('.');
                    }
                    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                    $('#NilaiJumlah').html(rupiah);
                    $('#harga').val(harga);
                }
                if(StandarHarga=="harga_2"){
                    var harga="<?php echo $harga_2;?>";
                    var harga = parseInt(harga);
                    var JumlahQtyPar = parseInt(JumlahQty);
                    var Subtotal=JumlahQtyPar*harga;
                    var	number_string = Subtotal.toString(),
                        split	= number_string.split(','),
                        sisa 	= split[0].length % 3,
                        rupiah 	= split[0].substr(0, sisa),
                        ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
                            
                    if (ribuan) {
                        separator = sisa ? '.' : '';
                        rupiah += separator + ribuan.join('.');
                    }
                    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                    $('#NilaiJumlah').html(rupiah);
                    $('#harga').val(harga);
                }
                if(StandarHarga=="harga_3"){
                    var harga="<?php echo $harga_3;?>";
                    var harga = parseInt(harga);
                    var JumlahQtyPar = parseInt(JumlahQty);
                    var Subtotal=JumlahQtyPar*harga;
                    var	number_string = Subtotal.toString(),
                        split	= number_string.split(','),
                        sisa 	= split[0].length % 3,
                        rupiah 	= split[0].substr(0, sisa),
                        ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
                            
                    if (ribuan) {
                        separator = sisa ? '.' : '';
                        rupiah += separator + ribuan.join('.');
                    }
                    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                    $('#NilaiJumlah').html(rupiah);
                    $('#harga').val(harga);
                }
                if(StandarHarga=="harga_4"){
                    var harga="<?php echo $harga_4;?>";
                    var harga = parseInt(harga);
                    var JumlahQtyPar = parseInt(JumlahQty);
                    var Subtotal=JumlahQtyPar*harga;
                    var	number_string = Subtotal.toString(),
                        split	= number_string.split(','),
                        sisa 	= split[0].length % 3,
                        rupiah 	= split[0].substr(0, sisa),
                        ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
                            
                    if (ribuan) {
                        separator = sisa ? '.' : '';
                        rupiah += separator + ribuan.join('.');
                    }
                    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                    $('#NilaiJumlah').html(rupiah);
                    $('#harga').val(harga);
                }
                if(StandarHarga==""){
                    var harga="0";
                    var	number_string = Subtotal.toString(),
                        split	= number_string.split(','),
                        sisa 	= split[0].length % 3,
                        rupiah 	= split[0].substr(0, sisa),
                        ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
                            
                    if (ribuan) {
                        separator = sisa ? '.' : '';
                        rupiah += separator + ribuan.join('.');
                    }
                    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                    $('#NilaiJumlah').html(rupiah);
                    $('#harga').html("0");
                }
            }else{
                $.ajax({
                    type 	: 'POST',
                    url 	: '_Page/Kasir/CariMultiHarga.php',
                    data 	: {StandarHarga: StandarHarga, IdBarang: IdBarang, id_multi: id_multi},
                    success : function(data){
                        //Hilangkan spasi dengan trim coy....
                        var hargaJadi=data.trim();
                        $('#harga').val(hargaJadi);
                        var hargaJadiPar=parseInt(hargaJadi);
                        if(JumlahQty!==""){
                            var Subtotal=JumlahQty*hargaJadiPar;
                            var	number_string = Subtotal.toString(),
                                split	= number_string.split(','),
                                sisa 	= split[0].length % 3,
                                rupiah 	= split[0].substr(0, sisa),
                                ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
                                    
                            if (ribuan) {
                                separator = sisa ? '.' : '';
                                rupiah += separator + ribuan.join('.');
                            }
                            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                            $('#NilaiJumlah').html(rupiah);
                        }else{
                            $('#NilaiJumlah').html("0");
                        }
                    }
                });
            }
            $('#LabelQty').html("");
        }else{
            $('#LabelQty').html("<small class='text-danger'>Error!! Hanya Boleh Angka</small>");
        }
    });
    $('#id_multi').change(function(){
        var StandarHarga = $('#StandarHarga').val();
        var IdBarang ="<?php echo $id_obat;?>";
        var id_multi =$('#id_multi').val();
        var JumlahQty = $('#qty').val();
        if(JumlahQty.match(/^\d+/)){
            if(id_multi==""){
                if(StandarHarga=="harga_1"){
                    var harga="<?php echo $harga_1;?>";
                    var harga = parseInt(harga);
                    var JumlahQtyPar = parseInt(JumlahQty);
                    var Subtotal=JumlahQtyPar*harga;
                    var	number_string = Subtotal.toString(),
                        split	= number_string.split(','),
                        sisa 	= split[0].length % 3,
                        rupiah 	= split[0].substr(0, sisa),
                        ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
                            
                    if (ribuan) {
                        separator = sisa ? '.' : '';
                        rupiah += separator + ribuan.join('.');
                    }
                    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                    $('#NilaiJumlah').html(rupiah);
                    $('#harga').val(harga);
                }
                if(StandarHarga=="harga_2"){
                    var harga="<?php echo $harga_2;?>";
                    var harga = parseInt(harga);
                    var JumlahQtyPar = parseInt(JumlahQty);
                    var Subtotal=JumlahQtyPar*harga;
                    var	number_string = Subtotal.toString(),
                        split	= number_string.split(','),
                        sisa 	= split[0].length % 3,
                        rupiah 	= split[0].substr(0, sisa),
                        ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
                            
                    if (ribuan) {
                        separator = sisa ? '.' : '';
                        rupiah += separator + ribuan.join('.');
                    }
                    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                    $('#NilaiJumlah').html(rupiah);
                    $('#harga').val(harga);
                }
                if(StandarHarga=="harga_3"){
                    var harga="<?php echo $harga_3;?>";
                    var harga = parseInt(harga);
                    var JumlahQtyPar = parseInt(JumlahQty);
                    var Subtotal=JumlahQtyPar*harga;
                    var	number_string = Subtotal.toString(),
                        split	= number_string.split(','),
                        sisa 	= split[0].length % 3,
                        rupiah 	= split[0].substr(0, sisa),
                        ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
                            
                    if (ribuan) {
                        separator = sisa ? '.' : '';
                        rupiah += separator + ribuan.join('.');
                    }
                    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                    $('#NilaiJumlah').html(rupiah);
                    $('#harga').val(harga);
                }
                if(StandarHarga=="harga_4"){
                    var harga="<?php echo $harga_4;?>";
                    var harga = parseInt(harga);
                    var JumlahQtyPar = parseInt(JumlahQty);
                    var Subtotal=JumlahQtyPar*harga;
                    var	number_string = Subtotal.toString(),
                        split	= number_string.split(','),
                        sisa 	= split[0].length % 3,
                        rupiah 	= split[0].substr(0, sisa),
                        ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
                            
                    if (ribuan) {
                        separator = sisa ? '.' : '';
                        rupiah += separator + ribuan.join('.');
                    }
                    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                    $('#NilaiJumlah').html(rupiah);
                    $('#harga').val(harga);
                }
                if(StandarHarga==""){
                    var harga="0";
                    var	number_string = Subtotal.toString(),
                        split	= number_string.split(','),
                        sisa 	= split[0].length % 3,
                        rupiah 	= split[0].substr(0, sisa),
                        ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
                            
                    if (ribuan) {
                        separator = sisa ? '.' : '';
                        rupiah += separator + ribuan.join('.');
                    }
                    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                    $('#NilaiJumlah').html(rupiah);
                    $('#harga').html("0");
                }
            }else{
                $.ajax({
                    type 	: 'POST',
                    url 	: '_Page/Kasir/CariMultiHarga.php',
                    data 	: {StandarHarga: StandarHarga, IdBarang: IdBarang, id_multi: id_multi},
                    success : function(data){
                        //Hilangkan spasi dengan trim coy....
                        var hargaJadi=data.trim();
                        $('#harga').val(hargaJadi);
                        var hargaJadiPar=parseInt(hargaJadi);
                        if(JumlahQty!==""){
                            var Subtotal=JumlahQty*hargaJadiPar;
                            var	number_string = Subtotal.toString(),
                                split	= number_string.split(','),
                                sisa 	= split[0].length % 3,
                                rupiah 	= split[0].substr(0, sisa),
                                ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
                                    
                            if (ribuan) {
                                separator = sisa ? '.' : '';
                                rupiah += separator + ribuan.join('.');
                            }
                            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                            $('#NilaiJumlah').html(rupiah);
                        }else{
                            $('#NilaiJumlah').html("0");
                        }
                    }
                });
            }
            $('#LabelQty').html("");
        }else{
            $('#LabelQty').html("<small class='text-danger'>Error!! Hanya Boleh Angka</small>");
        }
    });
    //Tambah ProsesAddRetur
    $('#ProsesAddRetur').submit(function(){
        $('#NotifikasiAddRetur').html('<b class="text-primary">Ket:</b> Loadng..');
        var ProsesAddRetur = $('#ProsesAddRetur').serialize();
        var id_transaksi = "<?php echo $id_transaksi;?>";
        var NewOrEdit = "<?php echo $NewOrEdit;?>";
        $.ajax({
            url     : "_Page/Retur/ProsesAddRetur.php",
            method  : "POST",
            data    : ProsesAddRetur,
            success: function (data) {
                $('#NotifikasiAddRetur').html(data);
                $.ajax({
                    type 	: 'POST',
                    url 	: '_Page/Retur/Retur.php',
                    data 	:  { id_transaksi: id_transaksi },
                    success : function(data){
                        $('#Halaman').html(data);
                    }
                });
                $('#ModalAddRetur').modal('hide');
            }
        })
    });
</script>
<form action="javascript:void(0);" autocomplete="off" id="ProsesAddRetur">
    <input type="hidden" name="id_obat" value="<?php echo "$id_obat"; ?>">
    <input type="hidden" name="id_rincian" value="<?php echo "$id_rincian"; ?>">
    <input type="hidden" name="id_transaksi" value="<?php echo "$id_transaksi"; ?>">
    <input type="hidden" name="NewOrEdit" value="<?php echo "$NewOrEdit"; ?>">
    <div class="modal-header bg-primary">
        <div class="row">
            <div class="col col-md-12">
                <h3 class="text-white">
                    <i class="mdi mdi-check-all"></i>Retur Barang Ini?
                </h3>
            </div>
        </div>
    </div>
    <div class="modal-body bg-white">
        <div class="form-group row">
            <div class="col col-md-6">
                <label>Kode Barang</label>
                <input type="text" readonly required name="kode" class="form-control" value="<?php echo $kode;?>">
            </div>
            <div class="col col-md-6">
                <label>Nama/Merek</label>
                <input type="text" readonly required name="nama" class="form-control" value="<?php echo $nama;?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col col-md-6">
                <label>Kategori</label>
                <select name="StandarHarga" id="StandarHarga" class="form-control">
                    <option value="harga_1" <?php if($standar_harga=="harga_1"){echo "selected";}else{ echo "";} ?>>Harga Beli</option>
                    <option value="harga_2" <?php if($standar_harga=="harga_2"){echo "selected";}else{ echo "";} ?>>Harga Grosir</option>
                    <option value="harga_3" <?php if($standar_harga=="harga_3"){echo "selected";}else{ echo "";} ?>>Harga Toko</option>
                    <option value="harga_4" <?php if($standar_harga=="harga_4"){echo "selected";}else{ echo "";} ?>>Harga Eceran</option>
                </select>
            </div>
            <div class="col col-md-6">
                <label>Satuan/Multi</label>
                <select name="id_multi" id="id_multi" class="form-control">
                    <option value="" <?php if(empty($id_multi)){echo "selected";} ?>>Satuan Utama (<?php echo $satuan;?>)</option>
                    <?php
                            $QryMulti = mysqli_query($conn, "SELECT*FROM muti_harga WHERE id_barang='$id_obat'");
                            while ($DataMulti = mysqli_fetch_array($QryMulti)) {
                                $id_multi2 = $DataMulti['id_multi'];
                                $harga1 = $DataMulti['harga1'];
                                $harga2 = $DataMulti['harga2'];
                                $harga3 = $DataMulti['harga3'];
                                $harga4 = $DataMulti['harga4'];
                                $SatuanMulti = $DataMulti['satuan'];
                                $konversiMulti = $DataMulti['konversi'];
                                $stokMulti = $DataMulti['stok'];
                                if($id_multi2==$id_multi){
                                    echo '<option value="'.$id_multi2.'" selected>'.$SatuanMulti.'</option>';
                                }else{
                                    echo '<option value="'.$id_multi2.'">'.$SatuanMulti.'</option>';
                                }
                                
                            }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="col col-md-6">
                <label>Qty/Jumlah</label>
                <input type="text" required name="qty" id="qty" class="form-control" value="">
                <small id="LabelQty"></small>
            </div>
            <div class="col col-md-6">
                <label>Harga</label>
                <input type="text" required name="harga" id="harga" class="form-control" value="<?php echo $harga;?>">
                <small id="LabelHarga"></small>
            </div>
        </div>
        <div class="form-group row">
            <div class="col col-md-12 text-center">
                <label>Jumlah</label>
                <h4><b>Rp</b> <b id="NilaiJumlah"><?php echo "" . number_format($jumlah,0,',','.');?></b></h4>
                <small id="NotifikasiAddRetur">
                    <b class="text-primary">Ket:</b> Belum ada proses, silahkan lakukan retur.
                </small>
            </div>
        </div>
    </div>
    <div class="modal-footer bg-primary">
        <button type="submit" class="btn btn-sm btn-light"><i class="mdi mdi-plus"></i> Retur</button>
        <button type="reset" class="btn btn-sm btn-warning"><i class="mdi mdi-undo"></i> Reset</button>
        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal"><i class="mdi mdi-close"></i> Tutup</button>
    </div>
</form>