<script type="text/javascript">
    $(document).on("keyup", function(event) {
        if (event.keyCode === 112) {
            document.getElementById("KeywordPencarianHadiahTerlebihDahulu").focus();
        }
        if (event.keyCode === 27) {
            $('#ModalTambahHadiahBerhasil').modal('hide');
        }
    });
</script>
    <script>
        $(document).ready(function(){
            // Focus KeywordPencarianHadiahTerlebihDahulu
            $('#KeywordPencarianHadiahTerlebihDahulu').focus(function(){
                $('#KeywordPencarianHadiahTerlebihDahulu').removeClass('border-dark');
                $('#KeywordPencarianHadiahTerlebihDahulu').addClass('border-primary');
            });
            $('#KeywordPencarianHadiahTerlebihDahulu').focusout(function(){
                $('#KeywordPencarianHadiahTerlebihDahulu').removeClass('border-primary');
                $('#KeywordPencarianHadiahTerlebihDahulu').addClass('border-dark');
            });
            // Focus TombolMulaiMencariBarangHadiah
            $('#TombolMulaiMencariBarangHadiah').focus(function(){
                $('#TombolMulaiMencariBarangHadiah').removeClass('btn-outline-dark');
                $('#TombolMulaiMencariBarangHadiah').addClass('btn-dark');
            });
            $('#TombolMulaiMencariBarangHadiah').focusout(function(){
                $('#TombolMulaiMencariBarangHadiah').removeClass('btn-dark');
                $('#TombolMulaiMencariBarangHadiah').addClass('btn-outline-dark');
            });
            // Focus TabelDataBarang
            $('#TabelDataBarang').focus(function(){
                $('#TabelDataBarang').addClass('badge-outline-primary');
            });
            $('#TabelDataBarang').focusout(function(){
                $('#TabelDataBarang').removeClass('badge-outline-primary');
            });
            // Focus point
            $('#point').focus(function(){
                $('#point').removeClass('border-dark');
                $('#point').addClass('border-primary');
            });
            $('#point').focusout(function(){
                $('#point').removeClass('border-primary');
                $('#point').addClass('border-dark');
            });
             // Focus TombolMulaiTambahDataHadiah
             $('#TombolMulaiTambahDataHadiah').focus(function(){
                $('#TombolMulaiTambahDataHadiah').removeClass('btn-outline-light');
                $('#TombolMulaiTambahDataHadiah').addClass('btn-light');
            });
            $('#TombolMulaiTambahDataHadiah').focusout(function(){
                $('#TombolMulaiTambahDataHadiah').removeClass('btn-light');
                $('#TombolMulaiTambahDataHadiah').addClass('btn-outline-light');
            });
            // Focus TombolTutupTambahDataHadiah
            $('#TombolTutupTambahDataHadiah').focus(function(){
                $('#TombolTutupTambahDataHadiah').removeClass('btn-outline-danger');
                $('#TombolTutupTambahDataHadiah').addClass('btn-danger');
            });
            $('#TombolTutupTambahDataHadiah').focusout(function(){
                $('#TombolTutupTambahDataHadiah').removeClass('btn-danger');
                $('#TombolTutupTambahDataHadiah').addClass('btn-outline-danger');
            });
            //Mulai pencarian barang untuk ditambahkan ke hadiah
            $('#MulaiCariDataBarangUntukHadiah').submit(function(){
                var keyword = $('#KeywordPencarianHadiahTerlebihDahulu').val();
                $.ajax({
                    type 	: 'POST',
                    url 	: '_Page/PromoPoint/TabelDataBarang.php',
                    data 	:  'keyword='+ keyword,
                    success : function(data){
                        $('#TabelDataBarang').html(data);
                    }
                });
            });
            //Ketika disetujui delete
            $('#ProsesTambahkanHadiah').submit(function(){
                var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
                $('#NotifikasiTambahHadiah').html(Loading);
                var ProsesTambahkanHadiah = $('#ProsesTambahkanHadiah').serialize();
                $.ajax({
                    type 	: 'POST',
                    url 	: '_Page/PromoPoint/ProsesTambahHadiah.php',
                    data 	:  ProsesTambahkanHadiah,
                    success : function(data){
                        $('#NotifikasiTambahHadiah').html(data);
                        //menangkap keterangan notifikasi
                        var Notifikasi=$('#NotifikasiTambahHadiahBerhasil').html();
                        if(Notifikasi=="Berhasil"){
                            $('#TabelHadiah').load('_Page/PromoPoint/TabelHadiah.php');
                            $('#ModalTambahHadiah').modal('hide');
                            $('#ModalTambahHadiahBerhasil').modal('show');
                        }
                    }
                });
            });
        });
    </script>
    <div class="modal-header bg-primary">
        <h4 class="text-white">
            <i class="mdi mdi-plus"></i> Tambah Data Hadiah
        </h4>
    </div>
    <div class="modal-body bg-white">
        <form action="javascript:void(0);" id="MulaiCariDataBarangUntukHadiah">
            <div class="form-group row">
                <div class="col-sm-12">
                    <small>Cari Data Barang (F1)</small>
                    <div class="input-group">
                        <input type="text" class="form-control border-dark" id="KeywordPencarianHadiahTerlebihDahulu" placeholder="Nama/Kode..">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-rounded btn-outline-dark" id="TombolMulaiMencariBarangHadiah">
                                <i class="menu-icon mdi mdi-search-web"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
<form action="javascript:void(0);" id="ProsesTambahkanHadiah">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group row">
                    <div class="col-sm-12" id="TabelDataBarang" style="height: 150px; overflow-y: scroll;">
                        <div class="text-danger text-center">
                            Belum ada data hadiah yang ditampilkan
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group row">
                    <div class="col-sm-12">
                        <small>Jumlah Point</small>
                        <input type="text" required name="point" id="point" class="form-control border-dark">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" id="NotifikasiTambahHadiah">
                <div class="alert alert-primary" role="alert">
                    <small>Pastikan data yang anda input sudah lengkap dan benar!</small>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer bg-primary">
        <button type="submit" class="btn btn-rounded btn-outline-light" id="TombolMulaiTambahDataHadiah">
            Tambah
        </button>
        <button class="btn btn-rounded btn-outline-danger" data-dismiss="modal" id="TombolTutupTambahDataHadiah">
            Tutup
        </button>
    </div>
</form>