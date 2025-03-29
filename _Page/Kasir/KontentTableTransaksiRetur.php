<?php
    include "../../_Config/Connection.php";
    if(!empty($_POST['KeywordRetur'])){
        $KeywordRetur=$_POST['KeywordRetur'];
        $jml_data = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM transaksi WHERE kode_transaksi like '%$KeywordRetur%' LIMIT 100"));
    }else{
        $KeywordRetur="";
        $jml_data ="0";
    }
?>
<script>
    <?php 
        $a=1;
        $b=$jml_data;
        for ( $i =$a; $i<=$b; $i++ ){
    ?>
        $("#BarisListRetur<?php echo $i;?>").focus(function () {
            $("#BarisListRetur<?php echo "$i";?>").addClass("table-active");
        });
        $("#BarisListRetur<?php echo $i;?>").focusout(function () {
            $("#BarisListRetur<?php echo "$i";?>").removeClass("table-active");
        });
        $('#BarisListRetur<?php echo "$i";?>').keyup(function(event) {
            if(event.keyCode==13){
                $('#BarisListRetur<?php echo "$i";?>').click();
                $('#BarisListRetur<?php echo "$i";?>').focusout();
            }
        });
    <?php } ?>
    $('#ModalPilihListRetur').on('show.bs.modal', function (e) {
        var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
        $('#KonfirmasiPilihListReturTransaksi').html(Loading);
        var DetailTransaksi = $(e.relatedTarget).data('id');
        $.ajax({
            type 	: 'POST',
            url 	: '_Page/Kasir/KonfirmasiPilihListRetur.php',
            data 	:  { id_transaksi: DetailTransaksi },
            success : function(data){
                $('#KonfirmasiPilihListReturTransaksi').html(data);
                $('SetujuiKonfirmasiRetur').focus();
                $('SetujuiKonfirmasiRetur').focusin();
            }
        });
    });   
</script>

<div class="table-responsive" style="height: 350px; overflow-y: scroll;">
    <table class="table table-sm table-bordered table-hover">
        <thead class="thead-dark">
            <tr>
                <th>No</th>
                <th>Tgl</th>
                <th>Kode</th>
                <th>Transaksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $no = 1;
                //KONDISI PENGATURAN MASING FILTER
                $query = mysqli_query($conn, "SELECT*FROM transaksi WHERE kode_transaksi like '%$KeywordRetur%' ORDER BY id_transaksi DESC LIMIT 100");
                while ($data = mysqli_fetch_array($query)) {
                    $id_transaksi = $data['id_transaksi'];
                    $kode_transaksi = $data['kode_transaksi'];
                    $tanggal = $data['tanggal'];
                    $jenis_transaksi= $data['jenis_transaksi'];
                    $total_tagihan= $data['total_tagihan'];
                    $pembayaran= $data['pembayaran'];
                    $selisih= $data['selisih'];
                    $keterangan= $data['keterangan'];
                    if($jenis_transaksi=="penjualan"){
                        $jenis_transaksi="PNJ";
                    }else{
                        $jenis_transaksi="PMB";
                    }
            ?>
            <tr tabindex="0" id="BarisListRetur<?php echo $no;?>" onmousemove="this.style.cursor='pointer'" data-toggle="modal" data-target="#ModalPilihListRetur" data-id="<?php echo $id_transaksi;?>">
                <td><?php echo "$no";?></td>
                <td><?php echo "$tanggal";?></td>
                <td><?php echo "$kode_transaksi";?></td>
                <td><?php echo "$jenis_transaksi";?></td>
            </tr>
            <?php $no++;} ?>
        </tbody>
    </table>
</div>