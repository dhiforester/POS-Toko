<script>
    $(document).ready(function(){
        $('#IsiBantuan').load("_Page/Bantuan/IstalasiAplikasi.php");
    });
    $('#IstalasiAplikasi').click(function(){
        var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
        $('#IsiBantuan').html(Loading);
        $('#IsiBantuan').load('_Page/Bantuan/IstalasiAplikasi.php');
    });
    $('#MelakukanLogin').click(function(){
        var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
        $('#IsiBantuan').html(Loading);
        $('#IsiBantuan').load('_Page/Bantuan/MelakukanLogin.php');
    });
    $('#DashboardAplikasi').click(function(){
        var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
        $('#IsiBantuan').html(Loading);
        $('#IsiBantuan').load('_Page/Bantuan/DashboardAplikasi.php');
    });
    $('#KelolaDataObat').click(function(){
        var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
        $('#IsiBantuan').html(Loading);
        $('#IsiBantuan').load('_Page/Bantuan/KelolaDataObat.php');
    });
    $('#TransaksiKasir').click(function(){
        var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
        $('#IsiBantuan').html(Loading);
        $('#IsiBantuan').load('_Page/Bantuan/TransaksiKasir.php');
    });
</script>
<div class="row">
    <div class="col-lg-8 grid-margin">
        <div class="card">
            <div class="card-body" id="IsiBantuan">

            </div>
        </div>
    </div>
    <div class="col-lg-4 grid-margin">
        <div class="card">
            <div class="card-body">
                <b class="text-primary">List Bantuan</b>
                <p>
                    <a href="javascript:void(0);" id="IstalasiAplikasi">
                        1. Instalasi Aplikasi dan Webserver
                    </a>
                    <br>
                    <a href="javascript:void(0);" id="MelakukanLogin">
                        2. Data Akses Dan Login
                    </a>
                    <br>
                    <a href="javascript:void(0);" id="DashboardAplikasi">
                        3. Penjelasan Dashboard Aplikasi
                    </a>
                    <br>
                    <a href="javascript:void(0);" id="KelolaDataObat">
                        4. Kelola Data Barang
                    </a>
                    <br>
                    <a href="javascript:void(0);" id="TransaksiKasir">
                        5. Melakukan Transaksi Dengan Kasir
                    </a>
                    <br>
                    <a href="javascript:void(0);" id="KelolaDataTransaksi">
                        6. Kelola Data Transaksi
                    </a>
                    <br>
                    <a href="javascript:void(0);" id="PercetakanNoata">
                        7. Percetakan Nota Dan Barcode
                    </a>
                    <br>
                    <a href="javascript:void(0);" id="PencarianBatch">
                        8. Pencarian Kode Batch Untuk Retur  
                    </a>
                    <br>
                    <a href="javascript:void(0);" id="InformasiKesalahan">
                        9. Kesalahan Yang Mungkin Terjadi  
                    </a>
                    <br>
                </p>
            </div>
        </div>
    </div>
</div>