<?php
    //koneksi
    ini_set("display_errors","off");
    include "../../_Config/Connection.php";
    //tangkap variabel
    $IdUser=$_POST['IdUser'];
    //Tangkap page
    $page=$_POST['page'];
    $BatasData=$_POST['BatasData'];
    //Buka data pelanggan berdasarkan IdPelanggan
    $QryUser = mysqli_query($conn, "SELECT * FROM user WHERE id_user='$IdUser'")or die(mysqli_error($conn));
    $DataUser = mysqli_fetch_array($QryUser);
    $username = $DataUser['username'];
    $password = $DataUser['password'];
    $level_akses = $DataUser['level_akses'];
    $status = $DataUser['status'];
?>
<script>
    $(document).ready(function(){
        $('#KembaliUser').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#Halaman').html(Loading);
            $('#Halaman').load("_Page/User/User.php");
        });
        $('#ProsesEditUser').submit(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            var ProsesEditUser = $('#ProsesEditUser').serialize();
            $('#NotifikasiEditUser').html(Loading);
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/User/ProsesEditUser.php',
                data 	:  ProsesEditUser,
                success : function(data){
                    $('#NotifikasiEditUser').html(data);
                    //menangkap keterangan notifikasi
                    var Notifikasi=$('#NotifikasiProsesEditUser').html();
                    var page=$('#page').html();
                    var BatasData=$('#BatasData').html();
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
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 grid-margin stretch-card">
        <div class="card card-statistics">
            <div class="card-body">
                <h3>Edit Data User</h3>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <form action="javascript:void(0);" id="ProsesEditUser">
                    <input type="hidden" name="IdUser" value="<?php echo $IdUser;?>">
                    <input type="hidden" name="UsernameLama" value="<?php echo $username;?>">
                    <input type="hidden" name="page" value="<?php echo $page;?>">
                    <input type="hidden" name="BatasData" value="<?php echo $BatasData;?>">
                    <div class="row">
                        <div class="form-group col-md col-6">
                        </div>
                        <div class="form-group col-md col-6 text-right">
                            <button class="btn btn-rounded btn-outline-primary" id="KembaliUser">
                                <i class="menu-icon mdi mdi-arrow-top-left"></i> Back
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Username</label>
                                <div class="col-sm-8">
                                    <input type="text" required name="username" class="form-control" value="<?php echo $username;?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Level Akses</label>
                                <div class="col-sm-8">
                                    <select class="form-control" required name="level">
                                        <option <?php if(empty($level_akses)){echo "selected";} ?> value="">--Pilih Level--</option>
                                        <option <?php if($level_akses=="Kasir"){echo "selected";} ?> value="Kasir">Kasir</option>
                                        <option <?php if($level_akses=="Admin"){echo "selected";} ?> value="Admin">Admin</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Password</label>
                                <div class="col-sm-8">
                                    <input type="password" required name="password1" class="form-control" value="<?php echo $password;?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Ulangi Password</label>
                                <div class="col-sm-8">
                                    <input type="password" required name="password2" class="form-control" value="<?php echo $password;?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md col-12" id="NotifikasiEditUser">
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