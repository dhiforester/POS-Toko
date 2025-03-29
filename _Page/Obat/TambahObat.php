<script type="text/javascript">
    $(document).on("keyup", function(event) {
        if (event.keyCode === 27) {
            document.getElementById("KembaliDataObat").click();
        }
    });

</script>
<script>
    $(document).ready(function(){
        $('#kode').focus();
        $('#KembaliDataObat').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#Halaman').html(Loading);
            $('#Halaman').load("_Page/Obat/Obat.php");
        });
        $('#kode').keyup(function(){
            var kode = $('#kode').val();
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/obat/cek_kode_obat.php',
                data 	: 'kode='+kode,
                success : function(data){
                    $('#label_kode_obat').html(data);
                }
            });
        });
        $('#nama').keyup(function(){
            var nama = $('#nama').val();
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/obat/cek_nama_obat.php',
                data 	: 'nama='+nama,
                success : function(data){
                    $('#label_nama_obat').html(data);
                }
            });
        });
        $('#kategori').keyup(function(){  
           var query = $(this).val();  
           if(query != '')  
           {  
                $.ajax({  
                     url:"_Page/obat/cek_kategori.php",  
                     method:"POST",  
                     data:{query:query},  
                     success:function(data)  
                     {  
                          $('#kategorilist').fadeIn();  
                          $('#kategorilist').html(data);  
                          $(".list-group-item").css("cursor","pointer");
                     }  
                });  
           }  
        });   
        $(document).on('click', '#ListKategori', function(){  
           $('#kategori').val($(this).text());  
           $('#kategorilist').fadeOut();  
        }); 
        $(document).on('keyup', '#ListKategori', function(event){  
            if(event.keyCode==13){
                $('#kategori').val($(this).text());  
                $('#kategorilist').fadeOut(); 
            }
        });
        $('#satuan').keyup(function(){  
           var query = $(this).val();  
           if(query != '')  
           {  
                $.ajax({  
                     url:"_Page/obat/cek_satuan.php",  
                     method:"POST",  
                     data:{query:query},  
                     success:function(data)  
                     {  
                          $('#SatuanList').fadeIn();  
                          $('#SatuanList').html(data);  
                          $(".list-group-item").css("cursor","pointer");
                     }  
                });  
           }  
        });
        $(document).on('click', '#ListSatuan', function(){  
           $('#satuan').val($(this).text());  
           $('#SatuanList').fadeOut();  
        }); 
        $(document).on('keyup', '#ListSatuan', function(event){  
            if(event.keyCode==13){
                $('#satuan').val($(this).text());  
                $('#SatuanList').fadeOut();  
            }
        });
        $('#stok').keyup(function(){
            var stok = $('#stok').val();
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/obat/cek_stok.php',
                data 	: 'stok='+stok,
                success : function(data){
                    $('#label_stok').html(data);
                }
            });
        });
        $('#harga1').keyup(function(){
            var harga1 = $('#harga1').val();
            var harga2 = $('#harga2').val();
            var harga3 = $('#harga3').val();
            var harga4 = $('#harga4').val();
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/obat/cek_harga1.php',
                data 	: 'harga1='+harga1, 
                success : function(data){
                    $('#label_harga1').html(data);
                }
            });
            if(harga2!==""){
                $.ajax({
                    type 	: 'POST',
                    url 	: '_Page/obat/hitung_pelaba_harga.php',
                    data 	: { harga1: harga1, harga2: harga2 },
                    success : function(data){
                        $('#pelabaHarga2').val(data);
                        laba=harga2-harga1;
                        $('#laba_harga2').html(laba.toFixed(2));
                    }
                });
            }
            if(harga3!==""){
                $.ajax({
                    type 	: 'POST',
                    url 	: '_Page/obat/hitung_pelaba_harga.php',
                    data 	: { harga1: harga1, harga2: harga3 },
                    success : function(data){
                        $('#pelabaHarga3').val(data);
                        laba=harga2-harga1;
                        $('#laba_harga3').html(laba.toFixed(2));
                    }
                });
            }
            if(harga4!==""){
                $.ajax({
                    type 	: 'POST',
                    url 	: '_Page/obat/hitung_pelaba_harga.php',
                    data 	: { harga1: harga1, harga2: harga4 },
                    success : function(data){
                        $('#pelabaHarga4').val(data);
                        laba=harga2-harga1;
                        $('#laba_harga4').html(laba.toFixed(2));
                    }
                });
            }
        });
        $('#harga1').focus(function(){
            var satuan = $('#satuan').val();
            $('#SatuanHargaBeli').html(satuan);
        });
        $('#harga2').keyup(function(){
            var harga1 = $('#harga1').val();
            var harga2 = $('#harga2').val();
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/obat/cek_harga1.php',
                data 	: 'harga1='+harga2, 
                success : function(data){
                    $('#label_harga2').html(data);
                    if(harga2!==""){
                        if(harga1!==""){
                            laba=harga2-harga1;
                            pelaba=(laba/harga1)*100;
                            $('#laba_harga2').html(laba.toFixed(2));
                            $('#pelabaHarga2').val(pelaba.toFixed(2));
                        }
                    }
                }
            });
        });
        $('#harga3').keyup(function(){
            var harga1 = $('#harga1').val();
            var harga2 = $('#harga3').val();
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/obat/cek_harga1.php',
                data 	: 'harga1='+harga2, 
                success : function(data){
                    $('#label_harga3').html(data);
                    if(harga2!==""){
                        if(harga1!==""){
                            laba=harga2-harga1;
                            pelaba=(laba/harga1)*100;
                            $('#laba_harga3').html(laba.toFixed(2));
                            $('#pelabaHarga3').val(pelaba.toFixed(2));
                        }
                    }
                }
            });
        });
        $('#harga4').keyup(function(){
            var harga1 = $('#harga1').val();
            var harga2 = $('#harga4').val();
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/obat/cek_harga1.php',
                data 	: 'harga1='+harga2, 
                success : function(data){
                    $('#label_harga4').html(data);
                    if(harga2!==""){
                        if(harga1!==""){
                            laba=harga2-harga1;
                            pelaba=(laba/harga1)*100;
                            $('#laba_harga4').html(laba.toFixed(2));
                            $('#pelabaHarga4').val(pelaba.toFixed(2));
                        }
                    }
                }
            });
        });
        $('#pelabaHarga2').keyup(function(){
            var harga1 = $('#harga1').val();
            var pelabaHarga2 = $('#pelabaHarga2').val();
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/Obat/CekPelaba.php',
                data 	: { harga: harga1, pelaba: pelabaHarga2 }, 
                success : function(data){
                    $('#harga2').val(data);
                    if(data!==""){
                        var RpLaba=data-harga1;
                        $('#laba_harga2').html(RpLaba.toFixed(2));
                    }
                }
            });
        });
        $('#pelabaHarga3').keyup(function(){
            var harga1 = $('#harga1').val();
            var pelabaHarga3 = $('#pelabaHarga3').val();
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/Obat/CekPelaba.php',
                data 	: { harga: harga1, pelaba: pelabaHarga3 }, 
                success : function(data){
                    $('#harga3').val(data);
                    if(data!==""){
                        var RpLaba=data-harga1;
                        $('#laba_harga3').html(RpLaba.toFixed(2));
                    }
                }
            });
        });
        $('#pelabaHarga4').keyup(function(){
            var harga1 = $('#harga1').val();
            var pelabaHarga4 = $('#pelabaHarga4').val();
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/Obat/CekPelaba.php',
                data 	: { harga: harga1, pelaba: pelabaHarga4 }, 
                success : function(data){
                    $('#harga4').val(data);
                    if(data!==""){
                        var RpLaba=data-harga1;
                        $('#laba_harga4').html(RpLaba.toFixed(2));
                    }
                }
            });
        });
        //kode
        $('#kode').focus(function(){
            $('#kode').removeClass("border-dark");
            $('#kode').addClass("border-primary");
            $('#kategorilist').fadeOut(); 
            $('#SatuanList').fadeOut();
        });
        $('#kode').focusout(function(){
            $('#kode').removeClass("border-primary");
            $('#kode').addClass("border-dark");
        });
        //nama
        $('#nama').focus(function(){
            $('#nama').removeClass("border-dark");
            $('#nama').addClass("border-primary");
            $('#kategorilist').fadeOut(); 
            $('#SatuanList').fadeOut();
        });
        $('#nama').focusout(function(){
            $('#nama').removeClass("border-primary");
            $('#nama').addClass("border-dark");
        });
        //kategori
        $('#kategori').focus(function(){
            $('#kategori').removeClass("border-dark");
            $('#kategori').addClass("border-primary"); 
            $('#SatuanList').fadeOut();
        });
        $('#kategori').focusout(function(){
            $('#kategori').removeClass("border-primary");
            $('#kategori').addClass("border-dark");
        });
        //stok
        $('#stok').focus(function(){
            $('#stok').removeClass("border-dark");
            $('#stok').addClass("border-primary");
            $('#kategorilist').fadeOut(); 
            $('#SatuanList').fadeOut();
        });
        $('#stok').focusout(function(){
            $('#stok').removeClass("border-primary");
            $('#stok').addClass("border-dark");
        });
        //satuan
        $('#isi').focus(function(){
            $('#isi').removeClass("border-dark");
            $('#isi').addClass("border-primary"); 
            $('#kategorilist').fadeOut();
            $('#SatuanList').fadeOut();
        });
        $('#isi').focusout(function(){
            $('#isi').removeClass("border-primary");
            $('#isi').addClass("border-dark");
        });
        //satuan
        $('#satuan').focus(function(){
            $('#satuan').removeClass("border-dark");
            $('#satuan').addClass("border-primary"); 
            $('#kategorilist').fadeOut();
        });
        $('#satuan').focusout(function(){
            $('#satuan').removeClass("border-primary");
            $('#satuan').addClass("border-dark");
        });
        //harga1
        $('#harga1').focus(function(){
            $('#harga1').removeClass("border-dark");
            $('#harga1').addClass("border-primary");
            $('#kategorilist').fadeOut(); 
            $('#SatuanList').fadeOut();
        });
        $('#harga1').focusout(function(){
            $('#harga1').removeClass("border-primary");
            $('#harga1').addClass("border-dark");
        });
        //harga2
        $('#harga2').focus(function(){
            $('#harga2').removeClass("border-dark");
            $('#harga2').addClass("border-primary");
            $('#kategorilist').fadeOut(); 
            $('#SatuanList').fadeOut();
        });
        $('#harga2').focusout(function(){
            $('#harga2').removeClass("border-primary");
            $('#harga2').addClass("border-dark");
        });
        //harga3
        $('#harga3').focus(function(){
            $('#harga3').removeClass("border-dark");
            $('#harga3').addClass("border-primary");
            $('#kategorilist').fadeOut(); 
            $('#SatuanList').fadeOut();
        });
        $('#harga3').focusout(function(){
            $('#harga3').removeClass("border-primary");
            $('#harga3').addClass("border-dark");
        });
        //harga4
        $('#harga4').focus(function(){
            $('#harga4').removeClass("border-dark");
            $('#harga4').addClass("border-primary");
            $('#kategorilist').fadeOut(); 
            $('#SatuanList').fadeOut();
        });
        $('#harga4').focusout(function(){
            $('#harga4').removeClass("border-primary");
            $('#harga4').addClass("border-dark");
        });
        //pelabaHarga2
        $('#pelabaHarga2').focus(function(){
            $('#pelabaHarga2').removeClass("border-dark");
            $('#pelabaHarga2').addClass("border-primary");
            $('#kategorilist').fadeOut(); 
            $('#SatuanList').fadeOut();
        });
        $('#pelabaHarga2').focusout(function(){
            $('#pelabaHarga2').removeClass("border-primary");
            $('#pelabaHarga2').addClass("border-dark");
        });
        //pelabaHarga3
        $('#pelabaHarga3').focus(function(){
            $('#pelabaHarga3').removeClass("border-dark");
            $('#pelabaHarga3').addClass("border-primary");
            $('#kategorilist').fadeOut(); 
            $('#SatuanList').fadeOut();
        });
        $('#pelabaHarga3').focusout(function(){
            $('#pelabaHarga3').removeClass("border-primary");
            $('#pelabaHarga3').addClass("border-dark");
        });
        //pelabaHarga4
        $('#pelabaHarga4').focus(function(){
            $('#pelabaHarga4').removeClass("border-dark");
            $('#pelabaHarga4').addClass("border-primary");
            $('#kategorilist').fadeOut(); 
            $('#SatuanList').fadeOut();
        });
        $('#pelabaHarga4').focusout(function(){
            $('#pelabaHarga4').removeClass("border-primary");
            $('#pelabaHarga4').addClass("border-dark");
        });
        $('#ProsesTambahObat').submit(function(){
            
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            var KodeBarang=$('#kode').val();
            var NamaBarang=$('#nama').val();
            var ProsesTambahObat = $('#ProsesTambahObat').serialize();
            $('#NotifikasiTambahObat').html(Loading);
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/Obat/ProsesTambahObat.php',
                data 	:  ProsesTambahObat,
                success : function(data){
                    $('#NotifikasiTambahObat').html(data);
                    //menangkap keterangan notifikasi
                    var Notifikasi=$('#NotifikasiTambahObatBerhasil').html();
                    if(Notifikasi=="Berhasil"){
                        $('#ModalTambahObatBerhasil').modal('show');
                        $('#Halaman').html(Loading);
                        $('#Halaman').load("_Page/Obat/Obat.php");
                        $.ajax({
                            type 	: 'POST',
                            url 	: '_Page/Obat/Obat.php',
                            data 	:  { OrderBy: 'id_obat', ShortBy: 'DESC' },
                            success : function(data){
                                $('#Halaman').html(data);
                                $.ajax({
                                    type 	: 'POST',
                                    url 	: '_Page/Obat/TabelObat.php',
                                    data 	:  { OrderBy: 'id_obat', ShortBy: 'DESC' },
                                    success : function(data){
                                        $('#TabelObat').html(data);
                                    }
                                });
                            }
                        });
                    }
                }
            });
        });
    });
</script>
<div class="row">
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 grid-margin stretch-card">
        <div class="card card-statistics">
            <div class="card-body">
                <h3 class="text-primary"><i class="mdi mdi-menu mdi-plus-box-outline"></i> Tambah Data Barang</h3>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 grid-margin stretch-card">
        <div class="card card-statistics">
            <div class="card-body">
                <div class="form-group col-md col-6 text-right">
                    <button class="btn btn-rounded btn-outline-primary" id="KembaliDataObat">
                        <i class="menu-icon mdi mdi-arrow-top-left"></i> Kembali Ke Data Barang (Esc)
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 grid-margin">
        <div class="card">
            <form action="javascript:void(0);" id="ProsesTambahObat">
                <div class="card-body" style="height: 400px; overflow-y: scroll;">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">
                                    <b>Kode & Nama Barang</b>
                                </label>
                                <div class="col-sm-4">
                                    <input type="text" required name="kode" id="kode" class="form-control border-dark">
                                    <small>Kode (Barcode)</small><small id="label_kode_obat"></small>
                                </div>
                                <div class="col-sm-4">
                                    <input type="text" required name="nama" id="nama" class="form-control border-dark">
                                    <small>Nama/Merek</small><small id="label_nama_obat"></small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">
                                    <b>Kategori Barang</b> <i id="label_kategori_obat"></i>
                                </label>
                                <div class="col-sm-8">
                                    <input type="text" required name="kategori" id="kategori" class="form-control border-dark">
                                    <div id="kategorilist"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">
                                    <b>Stok & Satuan </b><i id="label_satuan"></i>
                                </label>
                                <div class="col-sm-2">
                                    <input type="number" require min="1" step="1" required name="isi" id="isi" class="form-control border-dark" value="1">
                                    <small>Isi per kemasan</small>
                                </div>
                                <div class="col-sm-2">
                                    <input type="text" name="stok" id="stok" class="form-control border-dark" value="0">
                                    <small>Stok Barang</small> <small id="label_stok"></small>
                                </div>
                                <div class="col-sm-4">
                                    <input type="text" required name="satuan" id="satuan" class="form-control border-dark">
                                    <small>Satuan</small>
                                    <div id="SatuanList"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">
                                    <b>Harga Beli </b> <i id="label_harga1"></i>
                                </label>
                                <div class="col col-md-8">
                                    <div class="input-group">
                                        <input type="text" required name="harga1" id="harga1" class="form-control border-dark">
                                        <div class="input-group-append border-primary">
                                            <span class="input-group-text bg-dark border-dark text-white">
                                               <i id=""> Rp / 1  </i>
                                               <i id="SatuanHargaBeli"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">
                                    <b>Harga Grosir</b> <i id="label_harga2"></i>
                                </label>
                                <div class="col-sm-4">
                                    <div class="input-group">
                                        <input type="text" required name="harga2" id="harga2" class="form-control border-dark">
                                        <div class="input-group-append border-primary">
                                            <span class="input-group-text bg-dark border-dark text-white">
                                                (Laba : <i id="laba_harga2">Rp</i>)
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="input-group">
                                        <input type="text" required name="pelabaHarga2" id="pelabaHarga2" class="form-control border-dark">
                                        <div class="input-group-append border-primary">
                                            <span class="input-group-text bg-dark border-dark text-white">
                                                (%)
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">
                                    <b>Harga Toko</b> <i id="label_harga3"></i>
                                </label>
                                <div class="col-sm-4">
                                    <div class="input-group">
                                        <input type="text" required name="harga3" id="harga3" class="form-control border-dark">
                                        <div class="input-group-append border-primary">
                                            <span class="input-group-text bg-dark border-dark text-white">
                                                (Laba : <i id="laba_harga3">Rp</i>)
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="input-group">
                                        <input type="text" required name="pelabaHarga3" id="pelabaHarga3" class="form-control border-dark">
                                        <div class="input-group-append border-primary">
                                            <span class="input-group-text bg-dark border-dark text-white">
                                                (%)
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">
                                    <b>Harga Eceran</b> <i id="label_harga4"></i>
                                </label>
                                <div class="col-sm-4">
                                    <div class="input-group">
                                        <input type="text" required name="harga4" id="harga4" class="form-control border-dark">
                                        <div class="input-group-append border-primary">
                                            <span class="input-group-text bg-dark border-dark text-white">
                                                (Laba : <i id="laba_harga4">Rp</i>)
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="input-group">
                                        <input type="text" required name="pelabaHarga4" id="pelabaHarga4" class="form-control border-dark">
                                        <div class="input-group-append border-primary">
                                            <span class="input-group-text bg-dark border-dark text-white">
                                                (%)
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md col-12" id="NotifikasiTambahObat">
                            <div class="alert alert-primary" role="alert">
                                Pastikan data yang anda input sudah lengkap!
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="form-group col-md col-12">
                            <button type="submit" class="btn btn-inverse-info btn-rounded btn-fw">
                                <i class="menu-icon mdi mdi-check"></i> Simpan
                            </button>
                            <button type="reset" class="btn btn-inverse-danger btn-rounded btn-fw">
                                <i class="menu-icon mdi mdi-reload"></i> Reset
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>