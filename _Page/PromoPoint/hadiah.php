<script>
    $(document).ready(function(){
        $('#KeywordPencarianHadiah').focus();
        $('#TabelHadiah').load("_Page/PromoPoint/TabelHadiah.php");
        //KeywordPencarianHadiah Focus
        $('#KeywordPencarianHadiah').focus(function(){
            $("#KeywordPencarianHadiah").removeClass('border-dark');
            $("#KeywordPencarianHadiah").addClass("border-primary");
        });
        $('#KeywordPencarianHadiah').focusout(function(){
            $("#KeywordPencarianHadiah").removeClass('border-primary');
            $("#KeywordPencarianHadiah").addClass("border-dark");
        });
        //TombolCariHadiah Focus
        $('#TombolCariHadiah').focus(function(){
            $("#TombolCariHadiah").removeClass('btn-outline-dark');
            $("#TombolCariHadiah").addClass("btn-dark");
        });
        $('#TombolCariHadiah').focusout(function(){
            $("#TombolCariHadiah").removeClass('btn-dark');
            $("#TombolCariHadiah").addClass("btn-outline-dark");
        });
        //TombolTambahHadiah Focus
        $('#TombolTambahHadiah').focus(function(){
            $("#TombolTambahHadiah").removeClass('btn btn-rounded btn-outline-primary');
            $("#TombolTambahHadiah").addClass("btn btn-rounded btn-primary");
        });
        $('#TombolTambahHadiah').focusout(function(){
            $("#TombolTambahHadiah").removeClass('btn btn-rounded btn-primary');
            $("#TombolTambahHadiah").addClass("btn btn-rounded btn-outline-primary");
        });
        //ReloadHadiah Focus
        $('#ReloadHadiah').focus(function(){
            $("#ReloadHadiah").removeClass('btn btn-rounded btn-outline-warning');
            $("#ReloadHadiah").addClass("btn btn-rounded btn-warning");
        });
        $('#ReloadHadiah').focusout(function(){
            $("#ReloadHadiah").removeClass('btn btn-rounded btn-warning');
            $("#ReloadHadiah").addClass("btn btn-rounded btn-outline-warning");
        });
    });
    //ketika Modal Tambah muncul
    $('#ModalTambahHadiah').on('show.bs.modal', function (e) {
        var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
        $('#FormTambahHadiah').html(Loading);
        var id_hadiah="0";
        $.ajax({
            url     : "_Page/PromoPoint/FormTambahHadiah.php",
            method  : "POST",
            data    : { id_hadiah: id_hadiah },
            success: function (data) {
                $('#FormTambahHadiah').html(data);
            }
        })
    });
    //ketika Modal Tambah muncul
    $('#ModalEditHadiah').on('show.bs.modal', function (e) {
        var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
        $('#FormEditHadiah').html(Loading);
        var id_hadiah = $(e.relatedTarget).data('id');
        $.ajax({
            url     : "_Page/PromoPoint/FormEditHadiah.php",
            method  : "POST",
            data    : { id_hadiah: id_hadiah },
            success: function (data) {
                $('#FormEditHadiah').html(data);
                //Ketika disetujui delete
                $('#ProsesEditHadiah').submit(function(){
                    var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
                    $('#NotifikasiEditHadiah').html(Loading);
                    var ProsesEditHadiah = $('#ProsesEditHadiah').serialize();
                    $.ajax({
                        type 	: 'POST',
                        url 	: '_Page/PromoPoint/ProsesEditHadiah.php',
                        data 	:  ProsesEditHadiah,
                        success : function(data){
                            $('#NotifikasiEditHadiah').html(data);
                            //menangkap keterangan notifikasi
                            var Notifikasi=$('#NotifikasiEditHadiahBerhasil').html();
                            if(Notifikasi=="Berhasil"){
                                $('#TabelHadiah').load('_Page/PromoPoint/TabelHadiah.php');
                                $('#ModalEditHadiah').modal('hide');
                                $('#ModalEditHadiahBerhasil').modal('show');
                            }
                        }
                    });
                });
            }
        })
    });
    //ketika Modal Tambah muncul
    $('#ModalDeleteHadiah').on('show.bs.modal', function (e) {
        var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
        $('#FormDeleteHadiah').html(Loading);
        var id_hadiah = $(e.relatedTarget).data('id');
        $.ajax({
            url     : "_Page/PromoPoint/FormDeleteHadiah.php",
            method  : "POST",
            data    : { id_hadiah: id_hadiah },
            success: function (data) {
                $('#FormDeleteHadiah').html(data);
            }
        })
    });
</script>
<div class="row">
    <div class="col-lg-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col col-lg-4">
                        <form action="javascript:void(0);" autocomplete="off" id="PencarianHadiah">
                            <small>Cari Data Hadiah</small>
                            <div class="input-group">
                                <input type="text" class="form-control border-dark" name="keyword" id="KeywordPencarianHadiah" class="form-control" placeholder="Cari Kode/Nama Hadiah" value="">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-rounded btn-outline-dark" id="TombolCariHadiah">
                                        <i class="menu-icon mdi mdi-search-web"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col col-lg-8 text-right">
                        <button class="btn btn-rounded btn-outline-primary" data-toggle="modal" data-target="#ModalTambahHadiah" id="TombolTambahHadiah">
                            <i class="menu-icon mdi mdi-plus"></i> Tambah
                        </button>
                        <button class="btn btn-rounded btn-outline-warning" id="ReloadHadiah">
                            <i class="menu-icon mdi mdi-reload"></i> Reload
                        </button>
                    </div>
                </div>
            </div>
            <div id="TabelHadiah">
                <!----- Tabel disini ----->
            </div>
        </div>
    </div>
</div>