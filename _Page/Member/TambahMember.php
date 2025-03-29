<script>
    $(document).ready(function(){
        $('#FormNik').focus();
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
        $('#ProsesTambahmember').submit(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            var ProsesTambahmember = $('#ProsesTambahmember').serialize();
            $('#NotifikasiTambahMember').html(Loading);
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/Member/ProsesTambahMember.php',
                data 	:  ProsesTambahmember,
                success : function(data){
                    $('#NotifikasiTambahMember').html(data);
                    //menangkap keterangan notifikasi
                    var Notifikasi=$('#NotifikasiTambahMemberBerhasil').html();
                    if(Notifikasi=="Berhasil"){
                        $('#Halaman').load('_Page/Member/Member.php');
                        $('#ModalTambahMemberBerhasil').modal('show');
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
                <h3 class="text-primary"><i class="menu-icon mdi mdi-account-multiple-plus"></i> Tambah Member</h3>
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
                <form action="javascript:void(0);" autocomplete="off" id="ProsesTambahmember">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><b>NIK / ID Member</b></label>
                                <div class="col-sm-8">
                                    <input type="text" autocomplete="false" required id="FormNik" name="nik" class="form-control border-primary">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><b>Nama Member</b></label>
                                <div class="col-sm-8">
                                    <input type="text" autocomplete="false" required name="nama" class="form-control border-primary">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><b>Nomor Kontak (Hp)</b></label>
                                <div class="col-sm-8">
                                    <input type="text" autocomplete="false" required name="kontak" class="form-control border-primary">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><b>Alamat Lengkap</b></label>
                                <div class="col-sm-8">
                                <textarea class="form-control border-primary" rows="10" name="alamat"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><b>Kategori</b></label>
                                <div class="col-sm-8">
                                    <select class="form-control border-primary" name="kategori" id="KategoriMember">
                                        <option value="Konsumen">Konsumen</option>
                                        <option value="Supplier">Supplier</option>
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
                                    <input type="number" step="1" min="0" autocomplete="false" required name="point" id="FormPoint" class="form-control border-primary" value="0">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md col-12" id="NotifikasiTambahMember">
                            <div class="alert alert-primary" role="alert">
                                Pastikan data yang anda input sudah benar dan lengkap!
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