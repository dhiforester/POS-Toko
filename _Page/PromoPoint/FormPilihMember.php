<script type="text/javascript">
    $(document).on("keyup", function(event) {
        if (event.keyCode === 113) {
            document.getElementById("KeywordMember").focus();
        }
        if (event.keyCode === 27) {
            $("#ModalTambahKlaim").modal('hide');
        }
    });
</script>
    <script>
        $(document).ready(function(){
            //Event Focus KeywordMember
            $('#KeywordMember').focus(function(){
                $('#KeywordMember').removeClass('border-dark');
                $('#KeywordMember').addClass('border-primary');
            });
            $('#KeywordMember').focusout(function(){
                $('#KeywordMember').removeClass('border-primary');
                $('#KeywordMember').addClass('border-dark');
            });
            //Event Focus ButtonSearchMember
            $('#ButtonSearchMember').focus(function(){
                $('#ButtonSearchMember').removeClass('btn-outline-dark');
                $('#ButtonSearchMember').addClass('btn-dark');
            });
            $('#ButtonSearchMember').focusout(function(){
                $('#ButtonSearchMember').removeClass('btn-dark');
                $('#ButtonSearchMember').addClass('btn-outline-dark');
            });
            //Event Focus KembaliPilihHadiah
            $('#KembaliPilihHadiah').focus(function(){
                $('#KembaliPilihHadiah').removeClass('btn-outline-primary');
                $('#KembaliPilihHadiah').addClass('btn-primary');
            });
            $('#KembaliPilihHadiah').focusout(function(){
                $('#KembaliPilihHadiah').removeClass('btn-primary');
                $('#KembaliPilihHadiah').addClass('btn-outline-primary');
            });
            //Event Focus NextPilihHadiah
            $('#NextPilihHadiah').focus(function(){
                $('#NextPilihHadiah').removeClass('btn-outline-primary');
                $('#NextPilihHadiah').addClass('btn-primary');
            });
            $('#NextPilihHadiah').focusout(function(){
                $('#NextPilihHadiah').removeClass('btn-primary');
                $('#NextPilihHadiah').addClass('btn-outline-primary');
            });
            //Event Focus BatalKlaimPilihMember
            $('#BatalKlaimPilihMember').focus(function(){
                $('#BatalKlaimPilihMember').removeClass('btn-outline-danger');
                $('#BatalKlaimPilihMember').addClass('btn-danger');
            });
            $('#BatalKlaimPilihMember').focusout(function(){
                $('#BatalKlaimPilihMember').removeClass('btn-danger');
                $('#BatalKlaimPilihMember').addClass('btn-outline-danger');
            });
            //MulaiCariMember
            $('#MulaiCariMmeber').submit(function(){
                var keyword = $('#KeywordMember').val();
                $.ajax({
                    type 	: 'POST',
                    url 	: '_Page/PromoPoint/TabelDataMember.php',
                    data 	:  'keyword='+ keyword,
                    success : function(data){
                        $('#TabelDataMmeber').html(data);
                    }
                });
            });
            $('#ProsesPilihMember').submit(function(){
                var ProsesPilihMember = $('#ProsesPilihMember').serialize();
                $.ajax({
                    type 	: 'POST',
                    url 	: '_Page/PromoPoint/FormIsiQty.php',
                    data 	:  ProsesPilihMember,
                    success : function(data){
                        $('#FormTambahKlaim').html(data);
                    }
                });
            });
            $('#KembaliPilihHadiah').click(function(){
                $('#FormTambahKlaim').load("_Page/PromoPoint/FormPilihHadiah.php");
            });
        });
    </script>
    <?php
        if(!empty($_POST['id_hadiah'])){
            $id_hadiah=$_POST['id_hadiah'];
        }else{
            $id_hadiah="";
        }
    ?>
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
        <form action="javascript:void(0);" id="MulaiCariMmeber">
            <div class="row">
                <div class="form-group col-md-12">
                    <label for="margin_atas"><b>2. Pilih Member (F2)</b></label>
                    <div class="input-group">
                        <input type="text" id="KeywordMember" class="form-control border-dark" placeholder="Cari.." value="">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-rounded btn-outline-dark" id="ButtonSearchMember">
                                <i class="menu-icon mdi mdi-search-web"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <form action="javascript:void(0);" id="ProsesPilihMember">
            <input type="hidden" name="id_hadiah" value="<?php echo "$id_hadiah"; ?>">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group row">
                        <div class="col-sm-12" id="TabelDataMmeber">
                            <!---- Tabel Data Member Disini ----->
                        </div>
                    </div>
                </div>
            </div>
            <?php if(empty($id_hadiah)){ ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <div class="alert alert-danger" role="alert">
                                    <small>Anda Belum Memilih Data Hadiah, Silahkan kembali!!</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="row">
                <div class="col-md-12" id="">
                    <div class="form-group col-md-12 text-center">
                        <button type="button" class="btn btn-rounded btn-outline-primary" id="KembaliPilihHadiah">
                            <i class="menu-icon mdi mdi-arrow-left-bold"></i> Back 
                        </button>
                        <?php if(!empty($id_hadiah)){ ?>
                            <button type="submit" class="btn btn-rounded btn-outline-primary" id="NextPilihHadiah">
                                Next <i class="menu-icon mdi mdi-arrow-right-bold"></i>
                            </button>
                        <?php } ?>
                        <button class="btn btn-rounded btn-outline-danger" data-dismiss="modal" id="BatalKlaimPilihMember">
                            Batal (ESC)
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</form>