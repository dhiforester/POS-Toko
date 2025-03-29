<?php
    include "../../_Config/Connection.php";
    include "../../_Config/SessionLogin.php";
    //inisiasi hari ini
    $BulaniIni=date('Y-m');
    //Menghitung transaksi penjualan
    $QryPenjualan = mysqli_query($conn, "SELECT*FROM transaksi WHERE tanggal like '%$BulaniIni%' AND jenis_transaksi='penjualan'");
    while ($DataPenjualan = mysqli_fetch_array($QryPenjualan)) {
        if(!empty($DataPenjualan['total_tagihan'])){
            $TotalPenjualan[] = $DataPenjualan['total_tagihan'];
        }else{
            $TotalPenjualan[] ="0";
        }
    }
    if(!empty($TotalPenjualan)){
        $TotalPenjualanRp=array_sum($TotalPenjualan);
    }else{
        $TotalPenjualanRp="0";
    }
    
    $JumlahPenjualan = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM transaksi WHERE tanggal like '%$BulaniIni%' AND jenis_transaksi='penjualan'"));
    //Menghitung transaksi pembelian
    $QryPembelian = mysqli_query($conn, "SELECT*FROM transaksi WHERE tanggal like '%$BulaniIni%' AND jenis_transaksi='pembelian'");
    while ($DataPembelian = mysqli_fetch_array($QryPembelian)) {
        if(!empty($DataPembelian['total_tagihan'])){
            $TotalPembelian[] = $DataPembelian['total_tagihan'];
        }else{
            $TotalPembelian[] = "0";
        }
    }
    if(!empty($TotalPembelian)){
        $TotalPembelianRp=array_sum($TotalPembelian);
    }else{
        $TotalPembelianRp="0";
    }
    $JumlahPembelian = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM transaksi WHERE tanggal like '%$BulaniIni%' AND jenis_transaksi='pembelian'"));
    $ItemObat = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM obat"));
    $Petugas = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM user"));
    //Menghitung transaksi Utang
    $QryUtang = mysqli_query($conn, "SELECT*FROM transaksi WHERE tanggal like '%$BulaniIni%' AND keterangan='Utang'");
    while ($DataUtang = mysqli_fetch_array($QryUtang)) {
        if(!empty($DataUtang['selisih'])){
            $selisih[] = $DataUtang['selisih'];
        }else{
            $selisih[] ="0";
        }
    }
    if(!empty($selisih)){
        $SelisihUtang=array_sum($selisih);
    }else{
        $SelisihUtang="0";
    }
    //JUMLAH HADIAH, KLAIM, PEMBERIAN POINT DAN SUPPLIER
    $JumlahHadiah = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM hadiah"));
    $JumlahKlaim = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM klaim"));
    $PemberianPoint = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM pemberian_point"));
    $JumlahMember = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM member WHERE kategori='Konsumen'"));

?>
<script>
    //ketika Modal obat hampir habis muncul
    $('#ModalObatHampirHabis').on('show.bs.modal', function (e) {
        $('#DataObatHampirHabis').html('Loading..');
        var StokMin = $(e.relatedTarget).data('id');
        $.ajax({
            url     : "_Page/Beranda/DataObatHampirHabis.php",
            method  : "POST",
            data    : { StokMin: StokMin },
            success: function (data) {
                $('#DataObatHampirHabis').html(data);
            }
        })
    });
    //ketika Modal grafik muncul muncul
    $('#ModalgrafikPenjualan').on('show.bs.modal', function (e) {
        $('#DataGrafikPenjualan').html('Loading..');
        var tahun ="";
        $.ajax({
            url     : "_Page/Beranda/DataGrafikPenjualan.php",
            method  : "POST",
            data    : { tahun: tahun },
            success: function (data) {
                $('#DataGrafikPenjualan').html(data);
            }
        })
    });
</script>
<div class="row">
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 grid-margin stretch-card">
        <div class="card card-statistics">
            <div class="card-body">
                <h3 class="text-primary">
                    <i class="mdi mdi-home text-primary icon-lg"></i> BERANDA
                </h3>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 grid-margin stretch-card text-right">
        <div class="card card-statistics">
            <div class="card-body">
                <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#ModalgrafikPenjualan">
                    <i class="mdi  mdi-chart-bar"></i> Grafik
                </button>
                <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#ModalObatHampirHabis" data-id="100">
                   Lihat Barang Hampir Habis
                </button>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
        <div class="card card-statistics">
            <div class="card-body">
                <div class="clearfix">
                    <div class="float-left">
                        <i class="mdi mdi-star-circle text-warning icon-lg"></i>
                    </div>
                    <div class="float-right">
                        <p class="mb-0 text-right">Penjualan Bulan Ini</p>
                        <div class="fluid-container">
                            <h5 class="font-weight-medium text-right mb-0"><?php echo "$JumlahPenjualan Kali";?></h5>
                        </div>
                    </div>
                </div>
                <p class="text-muted mt-3 mb-0">
                </p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
        <div class="card card-statistics">
        <div class="card-body">
            <div class="clearfix">
            <div class="float-left">
                <i class="mdi mdi-receipt text-danger icon-lg"></i>
            </div>
            <div class="float-right">
                <p class="mb-0 text-right">Pembelian Bulan Ini</p>
                <div class="fluid-container">
                <h5 class="font-weight-medium text-right mb-0"><?php echo "$JumlahPembelian Kali";?></h5>
                </div>
            </div>
            </div>
            <p class="text-muted mt-3 mb-0">
            </p>
        </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
        <div class="card card-statistics">
        <div class="card-body">
            <div class="clearfix">
            <div class="float-left">
                <i class="mdi mdi-plus-box-outline text-success icon-lg"></i>
            </div>
            <div class="float-right">
                <p class="mb-0 text-right">Pendapatan</p>
                <div class="fluid-container">
                <h5 class="font-weight-medium text-right mb-0"><?php echo "Rp " . number_format($TotalPenjualanRp,0,',','.');?></h5>
                </div>
            </div>
            </div>
            <p class="text-muted mt-3 mb-0">
            
            </p>
        </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
        <div class="card card-statistics">
        <div class="card-body">
            <div class="clearfix">
            <div class="float-left">
                <i class="mdi mdi-minus-box-outline text-danger icon-lg"></i>
            </div>
            <div class="float-right">
                <p class="mb-0 text-right">Pengeluaran</p>
                <div class="fluid-container">
                <h5 class="font-weight-medium text-right mb-0"><?php echo "Rp " . number_format($TotalPembelianRp,0,',','.');?></h5>
                </div>
            </div>
            </div>
            <p class="text-muted mt-3 mb-0">
            </p>
        </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
        <div class="card card-statistics">
            <div class="card-body">
                <div class="clearfix">
                    <div class="float-left">
                        <i class="mdi mdi-box-shadow text-danger icon-lg"></i>
                    </div>
                    <div class="float-right">
                        <p class="mb-0 text-right">Item Barang</p>
                        <div class="fluid-container">
                            <h5 class="font-weight-medium text-right mb-0"><?php echo "" . number_format($ItemObat,0,',','.');?> <?php echo "Item";?></h5>
                        </div>
                    </div>
                </div>
                <p class="text-muted mt-3 mb-0">
                </p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
        <div class="card card-statistics">
        <div class="card-body">
            <div class="clearfix">
            <div class="float-left">
                <i class="mdi mdi-account-settings-variant text-info icon-lg"></i>
            </div>
            <div class="float-right">
                <p class="mb-0 text-right">Petugas/Kasir</p>
                <div class="fluid-container">
                <h5 class="font-weight-medium text-right mb-0"><?php echo "$Petugas Orang";?></h5>
                </div>
            </div>
            </div>
            <p class="text-muted mt-3 mb-0">
            </p>
        </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
        <div class="card card-statistics">
        <div class="card-body">
            <div class="clearfix">
            <div class="float-left">
                <i class="mdi mdi-traffic-light text-warning icon-lg"></i>
            </div>
            <div class="float-right">
                <p class="mb-0 text-right">Utang Usaha</p>
                <div class="fluid-container">
                <h5 class="font-weight-medium text-right mb-0"><?php echo "Rp " . number_format($SelisihUtang,0,',','.');?></h5>
                </div>
            </div>
            </div>
            <p class="text-muted mt-3 mb-0">
            
            </p>
        </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
        <div class="card card-statistics">
        <div class="card-body">
            <div class="clearfix">
            <div class="float-left">
                <i class="mdi mdi-transfer text-info icon-lg"></i>
            </div>
            <div class="float-right">
                <p class="mb-0 text-right">Piutang Usaha</p>
                <div class="fluid-container">
                <h5 class="font-weight-medium text-right mb-0"><?php echo "Rp " . number_format($TotalPembelianRp,0,',','.');?></h5>
                </div>
            </div>
            </div>
            <p class="text-muted mt-3 mb-0">
            </p>
        </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
        <div class="card card-statistics">
            <div class="card-body">
                <div class="clearfix">
                    <div class="float-left">
                        <i class="mdi mdi-account-multiple text-info icon-lg"></i>
                    </div>
                    <div class="float-right">
                        <p class="mb-0 text-right">Member</p>
                        <div class="fluid-container">
                            <h5 class="font-weight-medium text-right mb-0"><?php echo "$JumlahMember Orang";?></h5>
                        </div>
                    </div>
                </div>
                <p class="text-muted mt-3 mb-0">
                </p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
        <div class="card card-statistics">
            <div class="card-body">
                <div class="clearfix">
                    <div class="float-left">
                        <i class="mdi mdi-cake text-warning icon-lg"></i>
                    </div>
                    <div class="float-right">
                        <p class="mb-0 text-right">Item Hadiah</p>
                        <div class="fluid-container">
                            <h5 class="font-weight-medium text-right mb-0"><?php echo "$JumlahHadiah Item";?></h5>
                        </div>
                    </div>
                </div>
                <p class="text-muted mt-3 mb-0">
                </p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
        <div class="card card-statistics">
            <div class="card-body">
                <div class="clearfix">
                    <div class="float-left">
                        <i class="mdi mdi-coins text-primary icon-lg"></i>
                    </div>
                    <div class="float-right">
                        <p class="mb-0 text-right">Pemberian Point</p>
                        <div class="fluid-container">
                            <h5 class="font-weight-medium text-right mb-0"><?php echo "$PemberianPoint Kali";?></h5>
                        </div>
                    </div>
                </div>
                <p class="text-muted mt-3 mb-0">
                </p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
        <div class="card card-statistics">
            <div class="card-body">
                <div class="clearfix">
                    <div class="float-left">
                        <i class="mdi mdi-send text-danger icon-lg"></i>
                    </div>
                    <div class="float-right">
                        <p class="mb-0 text-right">Klaim</p>
                        <div class="fluid-container">
                            <h5 class="font-weight-medium text-right mb-0"><?php echo "$JumlahKlaim Kali";?></h5>
                        </div>
                    </div>
                </div>
                <p class="text-muted mt-3 mb-0">
                </p>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 grid-margin stretch-card">
        <div class="card card-statistics">
            <div class="card-body">
                <div class="alert alert-primary text-justify" role="alert">
                    <b>Kontak Bantuan</b><br>
                    <small>
                        Aplikasi ini dikembangkan untuk mempermudah manajemen toko melakukan pengelolaan data barang dan transaksi 
                        yang dilakukan. Setiap fitur yang dibangun merupakan hasil kajian dan analisa kebutuhan sistem pada beberapa bisnis, 
                        sehingga masih memungkinkan adanya perubahan versi dan perbedaan komposisi modul yang ada pada aplikasi tersebut. 
                        Apabila anda mengalami kendala berupa gangguan atau adanya temuan error maka anda dapat menghubungi 
                        nomor kontak 089601154726 (An: Solihul Hadi) atau via <i>Whatsapp</i> 089660757177.
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 grid-margin stretch-card">
        <div class="card">
            
        </div>
    </div>
</div>