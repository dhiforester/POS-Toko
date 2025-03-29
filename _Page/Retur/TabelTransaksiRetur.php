<?php
    ini_set("display_errors","off");
    include "../../_Config/Connection.php";
    if(!empty($_POST['keyword'])){
        $keyword=$_POST['keyword'];
        $jml_data = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM retur WHERE kode like '%$keyword%' LIMIT 100"));
    }else{
        $keyword="";
       $jml_data = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM retur LIMIT 100"));
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
    $('#ModalDetailFakturRetur').on('show.bs.modal', function (e) {
        var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
        $('#DetailFakturRetur').html(Loading);
        var kode = $(e.relatedTarget).data('id');
        $.ajax({
            type 	: 'POST',
            url 	: '_Page/Retur/DetailFakturRetur.php',
            data 	:  { kode: kode },
            success : function(data){
                $('#DetailFakturRetur').html(data);
            }
        });
    });   
</script>
<?php echo $keyword;?>
<div class="table-responsive" style="height: 350px; overflow-y: scroll;">
    <table class="table table-sm table-bordered table-hover">
        <thead class="thead-dark">
            <tr>
                <th>No</th>
                <th>Tgl</th>
                <th>Kode</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $no = 1;
                //KONDISI PENGATURAN MASING FILTER
                if(!empty($keyword)){
                    $query = mysqli_query($conn, "SELECT*FROM retur WHERE kode like '%$keyword%' ORDER BY id_retur DESC LIMIT 100");
                }else{
                    $query = mysqli_query($conn, "SELECT*FROM retur ORDER BY id_retur DESC LIMIT 100");
                }
                
                while ($data = mysqli_fetch_array($query)) {
                    $id_retur = $data['id_retur'];
                    $id_transaksi = $data['id_transaksi'];
                    $kode = $data['kode'];
                    $tanggal = $data['tanggal'];
                    $tagihan = $data['tagihan'];
            ?>
            <tr tabindex="0" id="BarisListRetur<?php echo $no;?>" onmousemove="this.style.cursor='pointer'" data-toggle="modal" data-target="#ModalDetailFakturRetur" data-id="<?php echo $kode;?>">
                <td><?php echo "$no";?></td>
                <td><?php echo "$tanggal";?></td>
                <td><?php echo "$kode";?></td>
                <td><?php echo "" . number_format($tagihan,0,',','.');?></td>
            </tr>
            <?php $no++;} ?>
        </tbody>
    </table>
</div>