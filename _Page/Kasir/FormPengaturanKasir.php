<?php
    //Koneksi
    ini_set("display_errors","off");
    include "../../_Config/Connection.php";
    //Tangkap parameter NewOrEdit
    if(!empty($_POST['NewOrEdit'])){
        $NewOrEdit=$_POST['NewOrEdit'];
    }else{
        $NewOrEdit="New";
    }
    //Tangkap parameter trans
    if(!empty($_POST['trans'])){
        $trans=$_POST['trans'];
    }else{
        $trans="penjualan";
    }
    //Tangkap parameter kode_transaksi
    if(empty($_POST['kode_transaksi'])){
       echo'<div class="modal-body">';
       echo'    <div class="card card-statistics">';
       echo'        <div class="card-body">';
       echo'            <div class="row">';
       echo'                <div class="col-md-12 text-center">';
       echo'                    <b class="text-danger">Maaf Kode Transaksi Tidak Boleh Kosong!!</b>';
       echo'                </div>';
       echo'            </div>';
       echo'        </div>';
       echo'    </div>';
       echo'</div>';
    }else{
        $kode_transaksi=$_POST['kode_transaksi'];
        //Buka Data Setting Yang Sudah Ada Berdasarkan NewOrEdit
        //Apabila Data Kasir Baru Buka Setting Dari Database
        if($NewOrEdit=="New"){
            //Buka data setting
            $QrySetting = mysqli_query($conn, "SELECT * FROM transaksi_setting WHERE trans='$trans'")or die(mysqli_error($conn));
            $DataSetting = mysqli_fetch_array($QrySetting);
            $ppn=$DataSetting['ppn'];
            if(empty($DataSetting['ppn'])){
                $ppn="0";
            }else{
                $ppn=$DataSetting['ppn'];
            }
            if(empty($DataSetting['diskon'])){
                $diskon="0";
            }else{
                $diskon=$DataSetting['diskon'];
            }
            if(empty($DataSetting['biaya'])){
                $biaya="0";
            }else{
                $biaya=$DataSetting['biaya'];
            }
            if(empty($DataSetting['standar_harga'])){
                $standar_harga="0";
            }else{
                $standar_harga=$DataSetting['standar_harga'];
            }
        }else{
            //Apabila Edit maka buka dari transaksi berdasarkan kode transaksi
            $QryTransaksi = mysqli_query($conn, "SELECT * FROM transaksi WHERE kode_transaksi='$kode_transaksi'")or die(mysqli_error($conn));
            $DataTransaksi = mysqli_fetch_array($QryTransaksi);
            $tanggal=$DataTransaksi['tanggal'];
            $RpPPN=$DataTransaksi['ppn'];
            $RpDiskon=$DataTransaksi['diskon'];
            $RpBiaya=$DataTransaksi['biaya'];
            $subtotal=$DataTransaksi['subtotal'];
            $total_tagihan=$DataTransaksi['total_tagihan'];
            $pembayaran=$DataTransaksi['pembayaran'];
            $selisih=$DataTransaksi['selisih'];
            $keterangan=$DataTransaksi['keterangan'];
            //Hitung Persen PPN
            $ppn=($RpPPN/$subtotal)*100;
            $ppn=round($ppn, 2);
            //Hitung Persen Diskon
            $diskon=($RpDiskon/$subtotal)*100;
            $diskon=round($diskon ,2);
            //Hitung Persen Baiaya
            $biaya=($RpBiaya/$subtotal)*100;
            $biaya=round($biaya, 2);
            $standar_harga="harga_1";
        }
    }
?>
<form action="javascript:void(0);" id="ProsesPengaturanKasir">
    <input type="hidden" name="NewOrEdit" value="<?php echo $NewOrEdit;?>">
    <input type="hidden" name="trans" value="<?php echo $trans;?>">
    <input type="hidden" name="kode_transaksi" value="<?php echo $kode_transaksi;?>">
    <div class="modal-body">
        <div class="card card-statistics">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">
                                Standar Harga
                            </label>
                            <div class="col-sm-8">
                                <select class="form-control" name="standar_harga">
                                    <option value="harga_1" <?php if($standar_harga=="harga_1"){echo "selected";} ?>>Harga Beli</option>
                                    <option value="harga_2" <?php if($standar_harga=="harga_2"){echo "selected";} ?>>Harga Grosir</option>
                                    <option value="harga_3" <?php if($standar_harga=="harga_3"){echo "selected";} ?>>Harga Toko</option>
                                    <option value="harga_4" <?php if($standar_harga=="harga_4"){echo "selected";} ?>>Harga Eceran</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">
                                PPN (%)
                            </label>
                            <div class="col-sm-8">
                                <input type="text"  name="ppn" id="ppn" class="form-control" value="<?php echo $ppn;?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">
                                Diskon (%)
                            </label>
                            <div class="col-sm-8">
                                <input type="text" name="diskon" id="diskon" class="form-control" value="<?php echo $diskon;?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <small id="NotifikasiPengaturanKasir" class="text-primary">Pastikan Data Transaksi Sudah Benar</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="form-group col-md-12 text-center">
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