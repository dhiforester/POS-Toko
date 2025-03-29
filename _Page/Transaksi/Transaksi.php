<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
?>
<script>
    $(document).ready(function(){
        $('#LaporanJualBeli').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#KontenSubMenu').html(Loading);
            $('#KontenSubMenu').load('_Page/Laporan/SubmenuLaporanJualBeli.php');
        });
    });
</script>
<div class="row">
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 grid-margin stretch-card">
        <div class="card card-statistics">
            <div class="card-body">
                <h3 class="text-primary" onmousemove="this.style.cursor='pointer'" id="HalamanUtamaLaporan">
                    <i class="mdi mdi-file-document-box"></i> Laporan
                </h3>
            </div>
        </div>
    </div>
    <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 grid-margin stretch-card">
        <div class="card card-statistics">
            <div class="card-body">
                <div class="row">
                    <div class="col col-md-12">
                        <button type="button" title="Laporan Penjualan dan Pembelian" class="btn btn-sm btn-outline-primary" id="LaporanJualBeli">
                            Jual-Beli
                        </button>
                        <button type="button" title="Laporan Utang Piutang" class="btn btn-sm btn-outline-primary" id="LaporanUtangPiutang">
                            Utang/Piutang
                        </button>
                        <button type="button" title="Laporan Laba Rugi" class="btn btn-sm btn-outline-info" id="LaporanLabaRugi">
                            Laba/Rugi
                        </button>
                        <button type="button" title="Laporan Konsumen" class="btn btn-sm btn-outline-info" id="Laporanbeban">
                            Beban/Biaya
                        </button>
                        <button type="button" title="Laporan Konsumen" class="btn btn-sm btn-outline-info" id="LaporanKonsumen">
                            Member
                        </button>
                        <button type="button" title="Laporan Barang Masuk/Keluar" class="btn btn-sm btn-outline-warning" id="LaporanBarangMasukKeluar">
                            Barang
                        </button>
                        <button type="button" title="Rekomendasi Rencana Belanja" class="btn btn-sm btn-outline-warning" id="LaporanRencanaBelanja">
                            Promosi
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-danger" id="Lainnya" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Lainnya <i class="mdi mdi-menu-down"></i>
                        </button>
                        <div class="dropdown-menu border-primary" aria-labelledby="UtangPiutang">
                            <a class="dropdown-item" href="javascript:void(0);" id="ReturBarang">Retur Barang</a>
                            <a class="dropdown-item" href="javascript:void(0);" id="PembayaranUtangPiutang">Pembayaran Utang-Piutang</a>
                            <a class="dropdown-item" href="javascript:void(0);" id="LaporanStokOpename">Stok Opename</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 grid-margin">
        <div class="card">
            <div class="card-body" id="KontenSubMenu">
                <p class="text-primary">Belum ada data yang bisa ditampilkan, pilih salah satu jenis laporan pada tombol di atas.</p>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 grid-margin">
        <div class="card">
            <div class="card-body" id="KontenLaporan">
                <div class="row">
                    <div class="col col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-md scroll-container">
                                <tbody>
                                    <tr>
                                        <td colspan="3" align="center">
                                            <h3>DAFTAR ISI</h3>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center">
                                            <b>No</b>
                                        </td>
                                        <td align="center">
                                            <b>Nama Laporan</b>
                                        </td>
                                        <td align="center">
                                            <b>Keterangan</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center">
                                            1
                                        </td>
                                        <td align="left">
                                            Jual Beli
                                        </td>
                                        <td align="left">
                                            Laporan kinerja antara penjualan dan pembelian
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center">
                                            2
                                        </td>
                                        <td align="left">
                                            Utang-Piutang
                                        </td>
                                        <td align="left">
                                            Laporan kinerja perbandingan antara transaksi utang dengan piutang
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
