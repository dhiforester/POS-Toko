<?php
    //koneksi dan error
    ini_set("display_errors","off");
    include "../../_Config/Connection.php";
    if(!empty($_POST['Keyword'])){
        $Keyword=$_POST['Keyword'];
        $jml_data = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM obat WHERE nama like '%$Keyword%' OR kode like '%$Keyword%'"));
    }else{
        $Keyword="";
        $jml_data ="0";
    }
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
    
    if(!empty($_POST['JenisHarga'])){
        $JenisHarga=$_POST['JenisHarga'];
    }else{
        $JenisHarga="";
    }
    if($JenisHarga=="harga_1"){
        $NamaHarga="Harga Beli";
    }
    if($JenisHarga=="harga_2"){
        $NamaHarga="Harga Grosir";
    }
    if($JenisHarga=="harga_3"){
        $NamaHarga="Harga Toko";
    }
    if($JenisHarga=="harga_4"){
        $NamaHarga="Harga Eceran";
    }
    if($JenisHarga==""){
        $NamaHarga="Harga Eceran";
    }
?>
<script>
    //ketika Modal Delete muncul
    $('#ModalPilihBarang').on('show.bs.modal', function (e) {
        var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
        $('#FormPilihBarang').html(Loading);
        var id_obat = $(e.relatedTarget).data('id');
        var StandarHarga = "<?php echo "$JenisHarga";?>";
        var kode_transaksi = "<?php echo "$kode_transaksi";?>";
        var jenis_transaksi ="<?php echo "$trans";?>";
        var NewOrEdit ="<?php echo "$NewOrEdit";?>";
        $.ajax({
            url     : "_Page/Kasir/FormPilihBarang.php",
            method  : "POST",
            data    : { StandarHarga: StandarHarga, jenis_transaksi: jenis_transaksi, NewOrEdit: NewOrEdit, id_obat: id_obat, kode_transaksi: kode_transaksi },
            success: function (data) {
                $('#FormPilihBarang').html(data);
            }
        })
    });
    //ketika klik page number
    
    <?php 
        $a=1;
        $b=$jml_data;
        for ( $i =$a; $i<=$b; $i++ ){
    ?>
    $("#PilihBaris<?php echo $i;?>").focus(function () {
        $("#BarisTabel<?php echo "$i";?>").removeClass("table-active");
        $("#PilihBaris<?php echo "$i";?>").removeClass("btn btn-outline-primary");
        $("#PilihBaris<?php echo "$i";?>").addClass("btn btn-primary");
        $(".ClassBarisTabel").removeClass("table-active");
        $(".TombolTambah").addClass("btn btn-outline-primary");
        $("#BarisTabel<?php echo "$i";?>").addClass("table-active");
    });
    <?php } ?>
</script>
<?php if(empty($jml_data)){ ?>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-bordered scroll-container">
                        <tbody>
                            <tr>
                                <td align="center">Tidak ada data yang ditemukan, mungkin anda belum memasukan kata kunci</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php } else{ ?>
    <form action="javascript:void(0);" id="ProsesTambahRincian">
        <input type="hidden" name="NewOrEdit" value="<?php echo "$NewOrEdit"; ?>">
        <input type="hidden" name="trans" value="<?php echo "$trans"; ?>">
        <input type="hidden" name="kode_transaksi" value="<?php echo "$kode_transaksi"; ?>">
        <input type="hidden" name="JenisHarga" value="<?php echo "$JenisHarga"; ?>">
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="" style="height: 350px; overflow-y: scroll;">
                        <div class="table-responsive overflow-auto">
                            <table class="table table-bordered scroll-container table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>Kode</th>
                                        <th>Nama/Merek</th>
                                        <th>Stok</th>
                                        <th><?php echo "$NamaHarga";?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if(empty($Keyword)){
                                            echo '<tr>';
                                            echo '  <td colspan="7" align="center">';
                                            echo '      Masukan keyword pencarian terlebih dahulu!! '.$Keyword.'';
                                            echo '  </td>';
                                            echo '</tr>';
                                        }else{
                                        $no = 1;
                                        //KONDISI PENGATURAN MASING FILTER
                                        $query = mysqli_query($conn, "SELECT*FROM obat WHERE nama like '%$Keyword%' OR kode like '%$Keyword%' ORDER BY id_obat DESC LIMIT 15");
                                        while ($data = mysqli_fetch_array($query)) {
                                            $id_obat = $data['id_obat'];
                                            $nama= $data['nama'];
                                            $kode = $data['kode'];
                                            $satuan = $data['satuan'];
                                            $stok= $data['stok'];
                                            $harga_1= $data['harga_1'];
                                            $harga_2= $data['harga_2'];
                                            $harga_3= $data['harga_3'];
                                            $harga_4= $data['harga_4'];
                                            if($JenisHarga=="harga_1"){
                                                $harga=$data['harga_1'];
                                            }
                                            if($JenisHarga=="harga_2"){
                                                $harga=$data['harga_2'];
                                            }
                                            if($JenisHarga=="harga_3"){
                                                $harga=$data['harga_3'];
                                            }
                                            if($JenisHarga=="harga_4"){
                                                $harga=$data['harga_4'];
                                            }
                                            if($JenisHarga==""){
                                                $harga=$data['harga_4'];
                                            }
                                    ?>
                                        
                                        <tr id="BarisTabel<?php echo "$no";?>" class="table-light ClassBarisTabel">
                                            <td><button data-toggle="modal" data-target="#ModalPilihBarang" data-id="<?php echo $id_obat;?>" id="PilihBaris<?php echo "$no";?>" class="btn btn-outline-primary TombolTambah"><?php echo "$no";?></button></td>
                                            <td><?php echo "$kode";?></td>
                                            <td><?php echo "$nama";?></td>
                                            <td><?php echo "$stok $satuan";?></td>
                                            <td align="right">
                                                <?php echo "Rp " . number_format($harga,0,',','.');?>
                                            </td>
                                        </tr>
                                    <?php 
                                        $no++;} 
                                        }
                                    ?>
                                    <tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>   
    </form>
    <div class="modal-body">
        <div class="row">
            <div class="form-group col-md-12 text-center">
                <button class="btn btn-danger" data-dismiss="modal">
                    Tutup (ESC)
                </button>
            </div>
        </div>
    </div>
<?php } ?>