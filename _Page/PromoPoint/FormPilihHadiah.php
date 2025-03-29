<script type="text/javascript">
    $(document).on("keyup", function(event) {
        if (event.keyCode === 112) {
            document.getElementById("KeywordHadiah").focus();
        }
        if (event.keyCode === 27) {
            $("#ModalTambahKlaim").modal('hide');
        }
    });
</script>
<script>
        $(document).ready(function(){
            //KeywordHadiah
            $('#KeywordHadiah').focus(function(){
                $('#KeywordHadiah').removeClass('border-dark');
                $('#KeywordHadiah').addClass('border-primary');
            });
            $('#KeywordHadiah').focusout(function(){
                $('#KeywordHadiah').removeClass('border-primary');
                $('#KeywordHadiah').addClass('border-dark');
            });
            //TombolKeywordHadiah
            $('#TombolKeywordHadiah').focus(function(){
                $('#TombolKeywordHadiah').removeClass('btn-outline-dark');
                $('#TombolKeywordHadiah').addClass('btn-dark');
            });
            $('#TombolKeywordHadiah').focusout(function(){
                $('#TombolKeywordHadiah').removeClass('btn-dark');
                $('#TombolKeywordHadiah').addClass('btn-outline-dark');
            });
            //TombolNextKlaim
            $('#TombolNextKlaim').focus(function(){
                $('#TombolNextKlaim').removeClass('btn-outline-primary');
                $('#TombolNextKlaim').addClass('btn-primary');
            });
            $('#TombolNextKlaim').focusout(function(){
                $('#TombolNextKlaim').removeClass('btn-primary');
                $('#TombolNextKlaim').addClass('btn-outline-primary');
            });
             //TombolBatalKlaim
             $('#TombolBatalKlaim').focus(function(){
                $('#TombolBatalKlaim').removeClass('btn-outline-danger');
                $('#TombolBatalKlaim').addClass('btn-danger');
            });
            $('#TombolBatalKlaim').focusout(function(){
                $('#TombolBatalKlaim').removeClass('btn-danger');
                $('#TombolBatalKlaim').addClass('btn-outline-danger');
            });
            //MulaiCariHadiah
            $('#MulaiCariHadiah').submit(function(){
                var keyword = $('#KeywordHadiah').val();
                $.ajax({
                    type 	: 'POST',
                    url 	: '_Page/PromoPoint/TabelDataHadiah.php',
                    data 	:  'keyword='+ keyword,
                    success : function(data){
                        $('#TabelDataHadiah').html(data);
                    }
                });
            });
            $('#ProsesPilihHadiah').submit(function(){
                var ProsesPilihHadiah = $('#ProsesPilihHadiah').serialize();
                $.ajax({
                    type 	: 'POST',
                    url 	: '_Page/PromoPoint/FormPilihMember.php',
                    data 	:  ProsesPilihHadiah,
                    success : function(data){
                        $('#FormTambahKlaim').html(data);
                    }
                });
            });
        });
    </script>
    <div class="modal-body bg-primary">
        <div class="row">
            <div class="col-md-12 text-center">
                <h4 class="text-white">
                    <i class="menu-icon mdi mdi-star"></i> Klaim Hadiah
                </h4>
            </div>
        </div>
    </div>
    <div class="modal-body bg-white">
        <form action="javascript:void(0);" id="MulaiCariHadiah">
            <div class="row">
                <div class="form-group col-md-12">
                    <label for="margin_atas"><b>1. Pilih Hadiah (F1)</b></label>
                    <div class="input-group">
                        <input type="text" id="KeywordHadiah" class="form-control border-dark" placeholder="Cari.." value="">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-rounded btn-outline-dark" id="TombolKeywordHadiah">
                                <i class="menu-icon mdi mdi-search-web"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <form action="javascript:void(0);" id="ProsesPilihHadiah">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group row">
                        <div class="col-sm-12" id="TabelDataHadiah">
                            <!---- Tabel Data Hadiah Disini ----->
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12" id="">
                    <div class="form-group col-md-12 text-center">
                        <button type="submit" class="btn btn-rounded btn-outline-primary" id="TombolNextKlaim">
                            Next <i class="menu-icon mdi mdi-arrow-right-bold"></i>
                        </button>
                        <button class="btn btn-rounded btn-outline-danger" data-dismiss="modal" id="TombolBatalKlaim">
                            Batal (ESC)
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</form>