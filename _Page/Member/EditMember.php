<?php
    //koneksi
    ini_set("display_errors","off");
    include "../../_Config/Connection.php";
    //tangkap variabel
    $IdMember=$_POST['IdMember'];
    //Tangkap page
    $page=$_POST['page'];
    $BatasData=$_POST['BatasData'];
    //Buka data pelanggan berdasarkan IdPelanggan
    $QryUser = mysqli_query($conn, "SELECT * FROM member WHERE id_member='$IdMember'")or die(mysqli_error($conn));
    $DataUser = mysqli_fetch_array($QryUser);
    $nik = $DataUser['nik'];
    $nama = $DataUser['nama'];
    $alamat = $DataUser['alamat'];
    $kontak = $DataUser['kontak'];
    $kategori = $DataUser['kategori'];
    $point = $DataUser['point'];
    if(empty($DataUser['point'])){
        $point ="0";
    }else{
        $point = $DataUser['point'];
    }
?>
<script>
    $(document).ready(function(){
        $('#KembaliMember').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#Halaman').html(Loading);
            $('#Halaman').load("_Page/Member/Member.php");
        });
        $('#KategoriMember').change(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            var KategoriMember=$('#KategoriMember').val();
            var FormPoint=$('#FormPoint').val();
            if(KategoriMember=="Supplier"){
                document.getElementById("FormPoint").setAttribute("readonly",true);
                $('#FormPoint').val('0');
            }else{
                document.getElementById("FormPoint").removeAttribute("readonly",0);
                $('#FormPoint').val(FormPoint);
            }
        });
        $('#ProsesEditMember').submit(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            var ProsesEditMember = $('#ProsesEditMember').serialize();
            $('#NotifikasiEditMember').html(Loading);
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/Member/ProsesEditMember.php',
                data 	:  ProsesEditMember,
                success : function(data){
                    $('#NotifikasiEditMember').html(data);
                    //menangkap keterangan notifikasi
                    var Notifikasi=$('#NotifikasiEditMemberBerhasil').html();
                    var page=$('#page').html();
                    var BatasData=$('#BatasData').html();
                    if(Notifikasi=="Berhasil"){
                        $('#Halaman').load("_Page/Member/Member.php");
                        $.ajax({
                            url     : "_Page/Member/TabelMember.php",
                            method  : "POST",
                            data    : { page: page, BatasData: BatasData },
                            success: function (data) {
                                $('#TabelMember').html(data);
                            }
                        })
                        $('#ModalEditMemberBerhasil').modal('show');
                    }
                }
            });
        });
    });
</script>
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 grid-margin stretch-card">
        <div class="card card-statistics">
            <div class="card-body">
                <h3>Edit Data Member</h3>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 grid-margin">
        <div class="card">
            <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md col-6">
                        </div>
                        <div class="form-group col-md col-6 text-right">
                            <button class="btn btn-rounded btn-outline-primary" id="KembaliMember">
                                <i class="menu-icon mdi mdi-arrow-top-left"></i> Back
                            </button>
                        </div>
                    </div>
                <form action="javascript:void(0);" id="ProsesEditMember">
                    <input type="hidden" name="IdMember" value="<?php echo $IdMember;?>">
                    <input type="hidden" name="NikLama" value="<?php echo $nik;?>">
                    <input type="hidden" name="page" value="<?php echo $page;?>">
                    <input type="hidden" name="BatasData" value="<?php echo $BatasData;?>">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><b>NIK / ID Member</b></label>
                                <div class="col-sm-8">
                                    <input type="text" autocomplete="false" required name="nik" class="form-control border-primary" value="<?php echo "$nik";?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><b>Nama Member</b></label>
                                <div class="col-sm-8">
                                    <input type="text" autocomplete="false" required name="nama" class="form-control border-primary" value="<?php echo "$nama";?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><b>Nomor Kontak (Hp)</b></label>
                                <div class="col-sm-8">
                                    <input type="text" autocomplete="false" required name="kontak" class="form-control border-primary" value="<?php echo "$kontak";?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><b>Alamat Lengkap</b></label>
                                <div class="col-sm-8">
                                <textarea class="form-control border-primary" rows="10" name="alamat"><?php echo "$alamat";?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><b>Kategori</b></label>
                                <div class="col-sm-8">
                                    <select class="form-control" name="kategori" id="KategoriMember">
                                        <option value="Konsumen" <?php if($kategori=="Konsumen"){echo "selected";} ?> >Konsumen</option>
                                        <option value="Supplier" <?php if($kategori=="Supplier"){echo "selected";} ?> >Supplier</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><b>Point</b></label>
                                <div class="col-sm-8">
                                    <input type="number" <?php if($kategori=="Supplier"){echo "readonly";} ?> step="1" min="0" autocomplete="false" required name="point" id="FormPoint" class="form-control border-primary" value="<?php echo "$point";?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md col-12" id="NotifikasiEditMember">
                            <div class="alert alert-primary" role="alert">
                                Pastikan data yang anda input sudah lengkap!
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md col-12">
                            <button type="submit" class="btn btn-inverse-info btn-rounded btn-fw">
                                <i class="menu-icon mdi mdi-check"></i> Simpan
                            </button>
                            <button type="reset" class="btn btn-inverse-danger btn-rounded btn-fw">
                                <i class="menu-icon mdi mdi-reload"></i> Reset
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>