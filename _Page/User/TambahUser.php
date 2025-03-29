<script>
    $(document).ready(function(){
        $('#KembaliUser').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#Halaman').html(Loading);
            $('#Halaman').load("_Page/User/User.php");
        });
        $('#ProsesTambahUser').submit(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            var ProsesTambahUser = $('#ProsesTambahUser').serialize();
            $('#NotifikasiTambahUser').html(Loading);
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/User/ProsesTambahUser.php',
                data 	:  ProsesTambahUser,
                success : function(data){
                    $('#NotifikasiTambahUser').html(data);
                    //menangkap keterangan notifikasi
                    var Notifikasi=$('#NotifikasiProsesTambahUser').html();
                    if(Notifikasi=="Berhasil"){
                        $('#Halaman').load('_Page/User/User.php');
                        $('#ModalTambahUserBerhasil').modal('show');
                    }
                }
            });
        });
    });
</script>
<div class="row">
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 grid-margin stretch-card">
        <div class="card card-statistics">
            <div class="card-body">
                <h3>Tambah Data User</h3>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 grid-margin stretch-card">
        <div class="card card-statistics">
            <div class="card-body text-right">
                <button class="btn btn-rounded btn-outline-primary" id="KembaliUser">
                    <i class="menu-icon mdi mdi-arrow-top-left"></i> Back
                </button>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <form action="javascript:void(0);" autocomplete="off" id="ProsesTambahUser">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Username</label>
                                <div class="col-sm-8">
                                    <input type="text" autocomplete="false" required name="username" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Level Akses</label>
                                <div class="col-sm-8">
                                    <select class="form-control" required name="level">
                                        <option value="">--Pilih Level--</option>
                                        <option value="Kasir">Kasir</option>
                                        <option value="Admin">Admin</option>
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
                                    <input type="password" autocomplete="false" required name="password1" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Ulangi Password</label>
                                <div class="col-sm-8">
                                    <input type="password" autocomplete="false" required name="password2" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md col-12" id="NotifikasiTambahUser">
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