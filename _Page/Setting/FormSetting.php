<?php
    //koneksi
    include "../../_Config/Connection.php";
    //tangkap variabel
    if(!empty($_POST['SubHalaman'])){
        $SubHalaman=$_POST['SubHalaman'];
    }else{
        $SubHalaman="LembarNota";
    }
    //Buat Variabel title dan nama setting
    if($SubHalaman=="LembarNota"){
        $title="Lembar Nota";
        $kategori_setting="percetakan_nota";
    }
     if($SubHalaman=="LembarBarcode"){
        $title="Lembar Barcode";
        $kategori_setting="percetakan_barcode";
    }
    if($SubHalaman=="LembarLaporan"){
        $title="Lembar Laporan";
        $kategori_setting="percetakan_laporan";
    }
    if($SubHalaman=="LembarLabel"){
        $title="Lembar Label";
        $kategori_setting="percetakan_label";
    }
    //Buka data Setting
    $Qry = mysqli_query($conn, "SELECT * FROM setting_cetak WHERE kategori_setting='$kategori_setting'")or die(mysqli_error($conn));
    $DataSetting = mysqli_fetch_array($Qry);
    $kategori_setting = $DataSetting['kategori_setting'];
	$margin_atas = $DataSetting['margin_atas'];
	$margin_bawah = $DataSetting['margin_bawah'];
	$margin_kiri = $DataSetting['margin_kiri'];
	$margin_kanan = $DataSetting['margin_kanan'];
	$panjang_x = $DataSetting['panjang_x'];
	$lebar_y = $DataSetting['lebar_y'];
	$jenis_font = $DataSetting['jenis_font'];
	$ukuran_font = $DataSetting['ukuran_font'];
    $warna_font = $DataSetting['warna_font'];
?>
<script>
    $(document).ready(function(){
        $('#KembaliUser').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#Halaman').html(Loading);
            $('#Halaman').load("_Page/User/User.php");
        });
        $('#ProsesSetting').submit(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            var ProsesSetting = $('#ProsesSetting').serialize();
            $('#NotifikasiSetting').html(Loading);
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/Setting/ProsesSetting.php',
                data 	:  ProsesSetting,
                success : function(data){
                    $('#NotifikasiSetting').html(data);
                    //menangkap keterangan notifikasi
                    var Notifikasi=$('#NotifikasiProsesSetting').html();
                    if(Notifikasi=="Berhasil"){
                        $('#Halaman').load("_Page/User/User.php");
                        $.ajax({
                            url     : "_Page/User/TabelUser.php",
                            method  : "POST",
                            data    : { page: page, BatasData: BatasData },
                            success: function (data) {
                                $('#TabelUser').html(data);
                            }
                        })
                        $('#ModalEditUserBerhasil').modal('show');
                    }
                }
            });
        });
    });
</script>
<div class="row">
    <div class="col-lg-12 grid-margin">
        <div class="card">
            <form action="javascript:void(0);" id="ProsesSetting">
                <div class="card-header">
                    <div class="row">
                        <div class="col col-md-12">
                            <h4 class="">
                                <?php
                                    if($kategori_setting=="percetakan_nota"){
                                        echo "Pengaturan Lembar Nota";
                                    }
                                    if($kategori_setting=="percetakan_laporan"){
                                        echo "Pengaturan Lembar Laporan";
                                    }
                                ?>
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="height: 350px; overflow-y: scroll;">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="margin_atas">Kategori Setting</label>
                            <input type="text" readonly name="kategori" class="form-control border-dark" id="kategori" value="<?php echo $kategori_setting;?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="margin_atas">Margin Atas (mm)</label>
                            <input type="text" name="margin_atas" class="form-control border-dark" id="margin_atas" value="<?php echo $margin_atas;?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="margin_bawah">Margin Bawah (mm)</label>
                            <input type="text" name="margin_bawah" class="form-control border-dark" id="margin_bawah" value="<?php echo $margin_bawah;?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="margin_kiri">Margin Kiri (mm)</label>
                            <input type="text" name="margin_kiri" class="form-control border-dark" id="margin_kiri" value="<?php echo $margin_kiri;?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="margin_kanan">Margin Kanan (mm)</label>
                            <input type="text" name="margin_kanan" class="form-control border-dark" id="margin_kanan" value="<?php echo $margin_kanan;?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="panjang_x">Panjang X (mm)</label>
                            <input type="text" name="panjang_x" class="form-control border-dark" id="panjang_x" value="<?php echo $panjang_x;?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="lebar_y">Lebar Y (mm)</label>
                            <input type="text" name="lebar_y" class="form-control border-dark" id="lebar_y" value="<?php echo $lebar_y;?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="jenis_font">Jenis Font</label>
                            <select name="jenis_font" class="form-control border-dark">
                                <option value="">-Jenis Font-</option>
                                <option value="Arial" <?php if($jenis_font=="Arial"){echo "selected";} ?>>
                                    Arial
                                </option>
                                <option value="Arial Black" <?php if($jenis_font=="Arial Black"){echo "selected";} ?>>
                                    Arial Black
                                </option>
                                <option value="DotumChe" <?php if($jenis_font=="DotumChe"){echo "selected";} ?>>
                                    DotumChe
                                </option>
                                <option value="sans-serif" <?php if($jenis_font=="sans-serif"){echo "selected";} ?>>
                                    sans-serif
                                </option>
                                <option value="Helvetica" <?php if($jenis_font=="Helvetica"){echo "selected";} ?>>
                                    Helvetica
                                </option>
                                <option value="Andale Mono" <?php if($jenis_font=="Andale Mono"){echo "selected";} ?>>
                                    Andale Mono
                                </option>
                                <option value="serif" <?php if($jenis_font=="serif"){echo "selected";} ?>>
                                    serif
                                </option>
                                <option value="Comic Sans MS" <?php if($jenis_font=="Comic Sans MS"){echo "selected";} ?>>
                                    Comic Sans MS
                                </option>
                                <option value="cursive" <?php if($jenis_font=="cursive"){echo "selected";} ?>>
                                    cursive
                                </option>
                                <option value="Times New Roman" <?php if($jenis_font=="Times New Roman"){echo "selected";} ?>>
                                    Times New Roman
                                </option>
                                <option value="MS Serif" <?php if($jenis_font=="MS Serif"){echo "selected";} ?>>
                                    MS Serif
                                </option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">Warna Font</label>
                            <input type="color" class="form-control border-dark" name="warna_font" value="<?php echo $warna_font; ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="jenis_font">Ukuran Font (Px)</label>
                            <input type="text" class="form-control border-dark" name="ukuran_font" value="<?php echo $ukuran_font; ?>">
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-md col-6" id="">
                            <button type="submit" class="btn btn-primary">
                                <i class="menu-icon mdi mdi-check"></i> Simpan
                            </button>
                            <button type="reset" class="btn btn-warning">
                                <i class="menu-icon mdi mdi-reload"></i> Reset
                            </button>
                        </div>
                        <div class="col-md col-6" id="NotifikasiSetting">
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