<?php
    //koneksi dan error
    
    include "../../_Config/Connection.php";
    
    if(!empty($_POST['NewOrEdit'])){
        $NewOrEdit=$_POST['NewOrEdit'];
    }else{
        $NewOrEdit="";
    }
    if(!empty($_POST['trans'])){
        $trans=$_POST['trans'];
    }else{
        $trans="";
    }
    if(!empty($_POST['kode_transaksi'])){
        $kode_transaksi=$_POST['kode_transaksi'];
    }else{
        $kode_transaksi="";
    }
     $QrySetting = mysqli_query($conn, "SELECT * FROM transaksi_setting WHERE trans='$trans'")or die(mysqli_error($conn));
    $DataSetting = mysqli_fetch_array($QrySetting);
    $standar_harga=$DataSetting['standar_harga'];
?>
<form action="javascript:void(0);" id="ProsesScanKasir">
    <script>
        $('#ModalScan').on('shown.bs.modal', function() {
            $('#ScanBarcode').focus();
        });
        $('#StandarHargaScan').focus(function(){
            $('#StandarHargaScan').addClass("border-danger");
        });
        $('#StandarHargaScan').focusout(function(){
            $('#StandarHargaScan').removeClass("border-danger");
        });
        $('#quantitas').focus(function(){
            $('#quantitas').addClass("border-danger");
        });
        $('#quantitas').focusout(function(){
            $('#quantitas').removeClass("border-danger");
        });

        $('#ScanBarcode').focus(function(){
            $('#ScanBarcode').addClass("border-danger");
        });
        $('#ScanBarcode').focusout(function(){
            $('#ScanBarcode').removeClass("border-danger");
        });
    </script>
    <div class="modal-header bg-primary">
        <div class="row">
            <div class="col-md-8 text-center">
                <h3 class="text-white"><i class="mdi mdi-barcode-scan"> </i>Scan Barcode</h3>
            </div>
            <div class="col-md-6 text-small">
                <b class="text-white">Notic:</b> <div class="text-white" id="ScanTitle">Belum ada Proses</div>
            </div>
        </div>
    </div>
    <div class="modal-body bg-primary">
        <div class="form-group  row">
            <div class="col col-md-6">
                <label class="text-white">Kategori</label><br>
                <select name="StandarHargaScan" id="StandarHargaScan" class="form-control">
                    <option value="harga_1" <?php if($standar_harga=="harga_1"){echo "selected";}else{ echo "";} ?>>Harga Beli</option>
                    <option value="harga_2" <?php if($standar_harga=="harga_2"){echo "selected";}else{ echo "";} ?>>Harga Grosir</option>
                    <option value="harga_3" <?php if($standar_harga=="harga_3"){echo "selected";}else{ echo "";} ?>>Harga Toko</option>
                    <option value="harga_4" <?php if($standar_harga=="harga_4"){echo "selected";}else{ echo "";} ?>>Harga Eceran</option>
                </select>
            </div>
            <div class="col col-md-6">
                <label class="text-white">Qty/Jumlah</label>
                <input type="number" min="0" class="form-control" id="quantitas" name="quantitas" value="1">
            </div>
        </div>
        <div class="form-group  row">
            <div class="col col-md-12">
                <label class="text-white">Scan Barcode</label>
                <input type="text" class="form-control" id="ScanBarcode" name="ScanBarcode" placeholder="Kode Barang..">
            </div>
        </div>
        <div class="form-group  row" id="ScanLanjutan">
           
        </div>
    </div>
    <div class="modal-footer bg-primary">
        <div class="row">
            <div class="form-group col-md-12 text-center">
                <button type="submit" class="btn btn-lg btn-warning">
                    Add
                </button>
                <button class="btn btn-lg btn-danger" data-dismiss="modal">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</form>
