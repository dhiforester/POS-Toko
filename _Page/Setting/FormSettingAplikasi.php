<?php
    //koneksi
    include "../../_Config/Connection.php";
    //Buka data Setting Aplikasi
    $Qry = mysqli_query($conn, "SELECT * FROM setting_aplikasi")or die(mysqli_error($conn));
    $DataSetting = mysqli_fetch_array($Qry);
    //Nama Perusahaan
    if(!empty($DataSetting['nama_perusahaan'])){
        $nama_perusahaan = $DataSetting['nama_perusahaan'];
    }else{
        $nama_perusahaan = "Business Today";
    }
    //Alamat
    if(!empty($DataSetting['alamat'])){
        $alamat = $DataSetting['alamat'];
    }else{
        $alamat ="";
    }
    //kontak
    if(!empty($DataSetting['kontak'])){
        $kontak = $DataSetting['kontak'];
    }else{
        $kontak ="";
    }
    //logo
    if(!empty($DataSetting['logo'])){
        $logo = $DataSetting['logo'];
    }else{
        $logo ="";
    }
    //logo
    if(!empty($DataSetting['aktif_promo'])){
        $aktif_promo = $DataSetting['aktif_promo'];
    }else{
        $aktif_promo ="Tidak";
    }
    //jumlah_point
    if(!empty($DataSetting['jumlah_point'])){
        $jumlah_point = $DataSetting['jumlah_point'];
    }else{
        $jumlah_point ="0";
    }
    //kelipatan_belanja
    if(!empty($DataSetting['kelipatan_belanja'])){
        $kelipatan_belanja = $DataSetting['kelipatan_belanja'];
    }else{
        $kelipatan_belanja ="0";
    }
    //host_printer
    if(!empty($DataSetting['host_printer'])){
        $host_printer = $DataSetting['host_printer'];
    }else{
        $host_printer ="localhost";
    }
    //nama_printer
    if(!empty($DataSetting['nama_printer'])){
        $nama_printer = $DataSetting['nama_printer'];
    }else{
        $nama_printer ="POS";
    }
?>
<script>
    $(document).ready(function(){
        $('#ProsesSettingAplikasi').submit(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            var ProsesSettingAplikasi = new FormData($(this)[0]);
            $('#NotifikasiSettingAplikasi').html(Loading);
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/Setting/ProsesSettingAplikasi.php',
                data 	:  ProsesSettingAplikasi,
                processData : false,
                contentType : false,
                success : function(data){
                    $('#NotifikasiSettingAplikasi').html(data);
                }
            });
        });
    });
</script>
<div class="row">
    <div class="col-lg-12 grid-margin">
        <div class="card">
            <form action="javascript:void(0);" id="ProsesSettingAplikasi">
                <div class="card-header">
                    <div class="row">
                        <div class="col col-md-12">
                            <h4>Pengaturan Aplikasi</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="height: 350px; overflow-y: scroll;">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"><b>Identitas Perusahaan</b></label>
                                <div class="col-sm-3">
                                    <input type="text" autocomplete="false" required name="nama_perusahaan" class="form-control border-dark" value="<?php echo $nama_perusahaan;?>">
                                    <small>Nama Perusahaan</small>
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" autocomplete="false" required name="alamat" class="form-control border-dark" value="<?php echo $alamat;?>">
                                    <small>Alamat</small>
                                </div>
                                <div class="col-sm-3">
                                <input type="text" autocomplete="false" required name="kontak" class="form-control border-dark" value="<?php echo $kontak;?>">
                                    <small>Telepon</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"><b>Mode Promosi</b></label>
                                <div class="col-sm-3">
                                    <select name="aktif_promo" class="form-control border-dark">
                                        <option value="Tidak" <?php if($aktif_promo=="Tidak"){echo "selected";} ?>>Tidak Aktif</option>
                                        <option value="Aktif" <?php if($aktif_promo=="Aktif"){echo "selected";} ?>>Aktif</option>
                                    </select>
                                    <small>Aktifkan Promo</small>
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" autocomplete="false" name="jumlah_point" class="form-control border-dark" value="<?php echo $jumlah_point;?>">
                                    <small>Point</small>
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" autocomplete="false" name="kelipatan_belanja" class="form-control border-dark" value="<?php echo $kelipatan_belanja;?>">
                                    <small>Kelipatan</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"><b>Printer Setting</b></label>
                                <div class="col-sm-3">
                                    <input type="text" autocomplete="false" required name="host_printer" class="form-control border-dark" value="<?php echo $host_printer;?>">
                                    <small>Host</small>
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" autocomplete="false" required name="nama_printer" class="form-control border-dark" value="<?php echo $nama_printer;?>">
                                    <small>Nama Printer</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"><b>Logo Perusahaan</b></label>
                                <div class="col-sm-6">
                                    <input type="file" name="logo" class="form-control border-dark" value="<?php echo $logo;?>">
                                </div>
                                <div class="col-sm-3">
                                    <img src="images/<?php if(!empty($logo)){echo "$logo";}else{echo "no_image.jpg";}?>" width="50px">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="form-group col-md col-6">
                            <button type="submit" class="btn btn-primary">
                                <i class="menu-icon mdi mdi-check"></i> Simpan
                            </button>
                            <button type="reset" class="btn btn-warning">
                                <i class="menu-icon mdi mdi-reload"></i> Reset
                            </button>
                        </div>
                        <div class="col-md col-6" id="NotifikasiSettingAplikasi">
                            <div class="alert alert-primary" role="alert">
                                Pastikan pengaturan yang anda gunakan sudah sesuai!
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>