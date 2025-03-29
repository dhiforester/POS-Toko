<?php
    //koneksi
    ini_set("display_errors","off");
    include "../../_Config/Connection.php";
    include "../../_Config/SessionLogin.php";
?>
<script>
    $(document).ready(function(){
        $('#KembaliKeProfil').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#Halaman').html(Loading);
            $('#Halaman').load('_Page/ProfilUser/ProfilUser.php');
        });
    });
    $(document).ready(function(){
        $('#ProsesEditProfil').submit(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            var ProsesEditProfil = $('#ProsesEditProfil').serialize();
            $('#NotifikasiEditProfil').html(Loading);
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/ProfilUser/ProsesEditProfil.php',
                data 	:  ProsesEditProfil,
                success : function(data){
                    $('#NotifikasiEditProfil').html(data);
                    //menangkap keterangan notifikasi
                    var Notifikasi=$('#NotifikasiProsesEditProfil').html();
                    if(Notifikasi=="Berhasil"){
                        $('#Halaman').load("_Page/Beranda/Beranda.php");
                        $('#SidebarLoginLogout').load('_Partial/SidebarLoginLogout.php');
                        $('#NavbarLoginLogout').load('_Partial/NavbarLoginLogout.php');
                        $('#NavbarProfil').load('_Partial/NavbarProfil.php');
                        $('#NavbarNotifikasi').load('_Partial/NavbarNotifikasi.php');
                        $('#SidebarByUser').load('_Partial/SidebarByUser.php');
                        $('#ModalEditProfilBerhasil').modal('show');
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
                <div class="row">
                    <div class="col-md-6">
                        <h3>Edit Profil</h3>
                    </div>
                    <div class="col-md-6 text-right">
                        <button class="btn btn-rounded btn-outline-primary" id="KembaliKeProfil">
                            <i class="menu-icon mdi mdi-arrow-left"></i> Back
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <form action="javascript:void(0);" id="ProsesEditProfil">
                    <input type="hidden" name="IdUser" value="<?php echo $SessionIdUser;?>">
                    <input type="hidden" name="UsernameLama" value="<?php echo $SessionUsername;?>">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label class="form-label">Username</label>
                            <input type="text" required name="username" class="form-control" value="<?php echo $SessionUsername;?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Password</label>
                                <div class="col-sm-8">
                                    <input type="password" required name="password1" class="form-control" value="<?php echo $SessionPassword;?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Ulangi Password</label>
                                <div class="col-sm-8">
                                    <input type="password" required name="password2" class="form-control" value="<?php echo $SessionPassword;?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md col-12" id="NotifikasiEditProfil">
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