<script type="text/javascript">
        $(document).on("keyup", function(event) {
            if (event.keyCode === 27) {
                $("#ModalTambahKlaim").modal('hide');
                $("#ModalTambahKlaimBerhasil").modal('hide');
            }
        });
    </script>
<script>
    $(document).ready(function(){
        $('#KeywordKlaim').focus();
        $('#TabelKlaim').load("_Page/PromoPoint/TabelKlaim.php");
        //FOCUS EVENT
    });
    //KeywordKlaim
    $('#KeywordKlaim').focus(function(){
        $('#KeywordKlaim').removeClass('border-dark');
        $('#KeywordKlaim').addClass('border-primary');
    });
    $('#KeywordKlaim').focusout(function(){
        $('#KeywordKlaim').removeClass('border-primary');
        $('#KeywordKlaim').addClass('border-dark');
    });
    //ButtonKeywordKlaim
    $('#ButtonKeywordKlaim').focus(function(){
        $('#ButtonKeywordKlaim').removeClass('btn-outline-dark');
        $('#ButtonKeywordKlaim').addClass('btn-dark');
    });
    $('#ButtonKeywordKlaim').focusout(function(){
        $('#ButtonKeywordKlaim').removeClass('btn-dark');
        $('#ButtonKeywordKlaim').addClass('btn-outline-dark');
    });
    //TambahKlaim
    $('#TambahKlaim').focus(function(){
        $('#TambahKlaim').removeClass('btn-outline-primary');
        $('#TambahKlaim').addClass('btn-primary');
    });
    $('#TambahKlaim').focusout(function(){
        $('#TambahKlaim').removeClass('btn-primary');
        $('#TambahKlaim').addClass('btn-outline-primary');
    });
    //ReloadKlaim
    $('#ReloadKlaim').focus(function(){
        $('#ReloadKlaim').removeClass('btn-outline-warning');
        $('#ReloadKlaim').addClass('btn-warning');
    });
    $('#ReloadKlaim').focusout(function(){
        $('#ReloadKlaim').removeClass('btn-warning');
        $('#ReloadKlaim').addClass('btn-outline-warning');
    });
    //Pencarian
    $('#PencarianKlaim').submit(function(){
        var PencarianKlaim = $('#PencarianKlaim').serialize();
        var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
        $('#TabelKlaim').html(Loading);
        $.ajax({
            type 	: 'POST',
            url 	: '_Page/PromoPoint/TabelKlaim.php',
            data    : PencarianKlaim,
            success : function(data){
                $('#TabelKlaim').html(data);
            }
        });
    });
    //ketika Modal Tambah muncul
    $('#ModalTambahKlaim').on('show.bs.modal', function (e) {
        var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
        $('#FormTambahKlaim').html(Loading);
        var id_klaim="0";
        $.ajax({
            url     : "_Page/PromoPoint/FormPilihHadiah.php",
            method  : "POST",
            data    : { id_klaim: id_klaim },
            success: function (data) {
                $('#FormTambahKlaim').html(data);
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
                        <form action="javascript:void(0);" autocomplete="off" id="PencarianKlaim">
                            <small>Cari Data Klaim</small>
                            <div class="input-group">
                                <input type="text" class="form-control border-dark" name="KeywordKlaim" id="KeywordKlaim" placeholder="Cari" value="">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-rounded btn-outline-dark" id="ButtonKeywordKlaim">
                                        <i class="menu-icon mdi mdi-search-web"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col col-lg-8 text-right">
                        <button class="btn btn-rounded btn-outline-primary" id="TambahKlaim" data-toggle="modal" data-target="#ModalTambahKlaim">
                            <i class="menu-icon mdi mdi-star"></i> Klaim
                        </button>
                        <button class="btn btn-rounded btn-outline-warning" id="ReloadKlaim">
                            <i class="menu-icon mdi mdi-reload"></i> Reload
                        </button>
                    </div>
                </div>
            </div>
            <div id="TabelKlaim">
                <!----- Tabel disini ----->
            </div>
        </div>
    </div>
</div>