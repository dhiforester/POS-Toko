<script>
    $(document).ready(function(){
        $('#KeywordPencarianTransaksi').focus();
        $('#TabelTransaksiPoint').load("_Page/PromoPoint/TabelTransaksiPoint.php");
        //Event Focus KeywordPencarianTransaksi
        $('#KeywordPencarianTransaksi').focus(function(){
            $('#KeywordPencarianTransaksi').removeClass('border-dark');
            $('#KeywordPencarianTransaksi').addClass('border-primary');
        });
        $('#KeywordPencarianTransaksi').focusout(function(){
            $('#KeywordPencarianTransaksi').removeClass('border-dark');
            $('#KeywordPencarianTransaksi').addClass('border-primary');
        });
        //Event Focus TombolMulaiPencarian
        $('#TombolMulaiPencarian').focus(function(){
            $('#TombolMulaiPencarian').removeClass('btn-outline-dark');
            $('#TombolMulaiPencarian').addClass('btn-dark');
        });
        $('#TombolMulaiPencarian').focusout(function(){
            $('#TombolMulaiPencarian').removeClass('btn-dark');
            $('#TombolMulaiPencarian').addClass('btn-outline-dark');
        });
        //Event Focus ReloadTransaksiPoint
        $('#ReloadTransaksiPoint').focus(function(){
            $('#ReloadTransaksiPoint').removeClass('btn-outline-warning');
            $('#ReloadTransaksiPoint').addClass('btn-warning');
        });
        $('#ReloadTransaksiPoint').focusout(function(){
            $('#ReloadTransaksiPoint').removeClass('btn-warning');
            $('#ReloadTransaksiPoint').addClass('btn-outline-warning');
        });
        //Pencarian
        $('#PencarianTransaksiPoint').submit(function(){
            var keyword = $('#KeywordPencarianTransaksi').val();
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/PromoPoint/TabelTransaksiPoint.php',
                data    : {keyword: keyword},
                success : function(data){
                    $('#TabelTransaksiPoint').html(data);
                }
            });
        });
    });
</script>
<div class="row">
    <div class="col-lg-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col col-lg-4">
                        <form action="javascript:void(0);" autocomplete="off" id="PencarianTransaksiPoint">
                            <small>Cari Data Transaksi Point</small>
                            <div class="input-group">
                                <input type="text" class="form-control border-dark" id="KeywordPencarianTransaksi" name="KeywordPencarianTransaksi" placeholder="Kode/Tanggal" value="">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-rounded btn-outline-dark" id="TombolMulaiPencarian">
                                        <i class="menu-icon mdi mdi-search-web"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col col-lg-8 text-right">
                        <button class="btn btn-rounded btn-outline-warning" id="ReloadTransaksiPoint">
                            <i class="menu-icon mdi mdi-reload"></i> Reload
                        </button>
                    </div>
                </div>
            </div>
            <div id="TabelTransaksiPoint">
                <!----- Tabel disini ----->
            </div>
        </div>
    </div>
</div>