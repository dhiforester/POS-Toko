<?php
    //koneksi dan error
    ini_set("display_errors","off");
    include "../../_Config/Connection.php";
    
    if(!empty($_POST['NewOrEdit'])){
        $NewOrEdit=$_POST['NewOrEdit'];
    }else{
        $NewOrEdit="";
    }
    if(!empty($_POST['trans'])){
        $trans=$_POST['trans'];
    }else{
        $trans="";
    }
    if(!empty($_POST['kode_transaksi'])){
        $kode_transaksi=$_POST['kode_transaksi'];
    }else{
        $kode_transaksi="";
    }
    if(!empty($_POST['Keyword'])){
        $Keyword=$_POST['Keyword'];
    }else{
        $Keyword="";
    }
    if(!empty($_POST['JenisHarga'])){
        $JenisHarga=$_POST['JenisHarga'];
    }else{
        $JenisHarga="";
    }
    $jml_data = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM obat WHERE nama like '%$Keyword%' OR kode like '%$Keyword%'"));
?>
<script>
    $(document).ready(function(){
        $('#MulaiCariObat').submit(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#TabelTambahRincian').html(Loading);
            var JenisHarga=$('#JenisHarga').val();
            var Keyword=$('#PencarianObat').val();
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/Kasir/TabelTambahRincian.php',
                data    : { JenisHarga: JenisHarga, Keyword: Keyword, NewOrEdit: "<?php echo $NewOrEdit;?>",  trans: "<?php echo $trans;?>",  kode_transaksi: "<?php echo $kode_transaksi;?>" },
                success : function(data){
                    $('#TabelTambahRincian').html(data);
                }
            });
        });
        $('#JenisHarga').change(function(){
            var JenisHarga=$('#JenisHarga').val();
            var Keyword=$('#PencarianObat').val();
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/Kasir/TabelTambahRincian.php',
                data    : { JenisHarga: JenisHarga, Keyword: Keyword, NewOrEdit: "<?php echo $NewOrEdit;?>",  trans: "<?php echo $trans;?>",  kode_transaksi: "<?php echo $kode_transaksi;?>" },
                success : function(data){
                    $('#TabelTambahRincian').html(data);
                }
            });
        });
    });
</script>
<div class="modal-header bg-primary">
    <h3 class="text-white">Pilih Data Barang</h3>
</div>
<div class="modal-body">
    <form action="javascript:void(0);" id="MulaiCariObat">
        <script>
            $('#ModalTambahRincian').on('shown.bs.modal', function() {
                $('#PencarianObat').focus();
            });
        </script>
        <div class="row">
            <div class="col-md-6">
                <label>Kategori Harga</label>
                <select name="JenisHarga" class="form-control form" id="JenisHarga">
                    <option value="">--Pilih--</option>
                    <option value="harga_1" <?php if($trans=="pembelian"){echo "selected";} ?>>Harga Beli</option>
                    <option value="harga_2">Harga Grosir</option>
                    <option value="harga_3">Harga Toko</option>
                    <option value="harga_4" <?php if($trans=="penjualan"){echo "selected";} ?>>Harga Eceran</option>
                </select>
            </div>
            <div class="col-md-6">
                <label>Kata Kunci Pencarian</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="PencarianObat" name="PencarianObat" class="form-control" placeholder="Cari.." value="">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-rounded btn-primary">
                            <i class="menu-icon mdi mdi-search-web"></i> Cari
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<div id="TabelTambahRincian">
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-bordered scroll-container">
                        <tbody>
                            <tr>
                                <td align="center"><b>Belum ada data yang ditampilkan</b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>