<script>
    $('#KategoriLaporan').change(function(){
        var KategoriLaporan=$('#KategoriLaporan').val();
        if(KategoriLaporan=="Harian"){
            $('#FormTanggal').load("_Page/Laporan/FormHarian.php");
        }
        if(KategoriLaporan=="Bulanan"){
            $('#FormTanggal').load("_Page/Laporan/FormBulanan.php");
        }
        if(KategoriLaporan=="Tahunan"){
            $('#FormTanggal').load("_Page/Laporan/FormTahunan.php");
        }
        if(KategoriLaporan=="Periode"){
            $('#FormTanggal').load("_Page/Laporan/FormPeriode.php");
        }
    });
    $('#ProsesTampilkanLaporanUtangPiutang').submit(function(){ 
        var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
        var ProsesTampilkanLaporanUtangPiutang=$('#ProsesTampilkanLaporanUtangPiutang').serialize();
        $('#KontenLaporan').html(Loading);
        $.ajax({
            type 	: 'POST',
            url 	: '_Page/Laporan/TabelLaporanUtangPiutang.php',
            data 	:  ProsesTampilkanLaporanUtangPiutang,
            success : function(data){
                $('#KontenLaporan').html(data);
            }
        });
    });
</script>
<form action="javascript:void(0);" id="ProsesTampilkanLaporanUtangPiutang">
    <div class="form-group row">
        <div class="col col-md-2">
            <label>Kategori Laporan</label>
            <select name="kategori" id="KategoriLaporan" class="form-control border-dark">
                <option value="Harian">Harian</option>
                <option value="Bulanan">Bulanan</option>
                <option value="Tahunan">Tahunan</option>
                <option value="Periode">Periode</option>
            </select>
        </div>
        <div class="col col-md-2">
            <label>Order By</label>
            <select name="OrderBy" id="OrderBy" class="form-control border-dark">
                <option value="kode_transaksi">Kode</option>
                <option value="tanggal">Tanggal</option>
                <option value="total_tagihan">Total</option>
                <option value="pembayaran">Pembayaran</option>
            </select>
        </div>
        <div class="col col-md-2">
            <label>Short By</label>
            <select name="ShortBy" id="ShortBy" class="form-control border-dark">
                <option value="ASC">A to Z / 0-9</option>
                <option value="DESC">Z to A / 9-0</option>
            </select>
        </div>
        <div class="col col-md-4" id="FormTanggal">
            <div class="col col-md-12" id="FormTanggal">
                <label>Tanggal</label>
                <input type="date" class="form-control border-dark" name="tanggal" id="tanggal" value="<?php echo date('Y-m-d');?>">
            </div>  
        </div>
        <div class="col col-md-2">
            <label>Tampilkan</label>
            <button type="submit" class="btn btn-md btn-primary">
                <i class="mdi mdi-check-all"></i> Tampilkan
            </button>
        </div>
    </div>
</form>
