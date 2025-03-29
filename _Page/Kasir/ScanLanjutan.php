    <?php
    include "../../_Config/Connection.php";
    if(!empty($_POST['IdBarang'])){
        $IdBarang=$_POST['IdBarang'];
        $QryObat = mysqli_query($conn, "SELECT * FROM obat WHERE id_obat='$IdBarang'")or die(mysqli_error($conn));
        $DataObat = mysqli_fetch_array($QryObat);
        $nama= $DataObat['nama'];
        $kode = $DataObat['kode'];
        $kategori = $DataObat['kategori'];
        $satuan = $DataObat['satuan'];
        $stok= $DataObat['stok'];
        $harga_1= $DataObat['harga_1'];
        $harga_2= $DataObat['harga_2'];
        $harga_3= $DataObat['harga_3'];
        $harga_4= $DataObat['harga_4'];
        //Tangkap Juga Standar Harga
        $standar_harga=$_POST['StandarHarga'];
        if($standar_harga=="harga_1"){
            $harga=$harga_1;
        }else{
            if($standar_harga=="harga_2"){
                $harga=$harga_2;
            }else{
                if($standar_harga=="harga_3"){
                    $harga=$harga_3;
                }else{
                    if($standar_harga=="harga_4"){
                        $harga=$harga_4;
                    }else{
                        $harga=$harga_4;
                    }
                }
            }
        }
    ?>
    <div class="col col-md-6 text-left">
        <label class="text-white">Multi Satuan</label><br>
        <select name="id_multi" id="id_multi" class="form-control">
            <option value="Satuan Utama">Satuan Utama (<?php echo $satuan;?>)</option>
            <?php
                    $QryMulti = mysqli_query($conn, "SELECT*FROM muti_harga WHERE id_barang='$IdBarang'");
                    while ($DataMulti = mysqli_fetch_array($QryMulti)) {
                        $id_multi = $DataMulti['id_multi'];
                        $SatuanMulti = $DataMulti['satuan'];
                        $stokMulti = $DataMulti['stok'];
                        echo '<option value="'.$id_multi.'">'.$SatuanMulti.'</option>';
                    }
            ?>
        </select>
    </div>
    <div class="col col-md-6 text-left">
        <label class="text-white">Harga</label><br>
        <input type="text" required name="harga" id="IdHargaScan" autocomplete="false" class="form-control" value="<?php echo "$harga"; ?>">
    </div>
<?php
    }else{
        $IdBarang="";
?>
    <div class="col col-md-12 text-left">
        <p class="text-danger"><b>Notifikasi :</b> ID Barang Gagal Diinisiasi!!</p>
    </div>
<?php
    }
?>
<script>
    $('#id_multi').focus(function(){
        $('#id_multi').addClass("border-danger");
    });
    $('#id_multi').focusout(function(){
        $('#id_multi').removeClass("border-danger");
    });
    $('#IdHargaScan').focus(function(){
        $('#IdHargaScan').addClass("border-danger");
    });
    $('#IdHargaScan').focusout(function(){
        $('#IdHargaScan').removeClass("border-danger");
    });

    $('#id_multi').change(function(){
        var id_multi =$('#id_multi').val();
        var StandarHarga = $('#StandarHargaScan').val();
        var IdBarang ="<?php echo $IdBarang;?>";
        if(id_multi=="Satuan Utama"){
            if(StandarHarga=="harga_1"){
                var harga="<?php echo $harga_1;?>";
                $('#IdHargaScan').val(harga);
            }
            if(StandarHarga=="harga_2"){
                var harga="<?php echo $harga_2;?>";
                $('#IdHargaScan').val(harga);
            }
            if(StandarHarga=="harga_3"){
                var harga="<?php echo $harga_3;?>";
                $('#IdHargaScan').val(harga);
            }
            if(StandarHarga=="harga_4"){
                var harga="<?php echo $harga_4;?>";
                $('#IdHargaScan').val(harga);
            }
            if(StandarHarga==""){
                var harga="0";
                $('#IdHargaScan').val(harga);
            }
        }else{
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/Kasir/CariMultiHarga.php',
                data 	: {StandarHarga: StandarHarga, IdBarang: IdBarang, id_multi: id_multi},
                success : function(data){
                    //Hilangkan spasi dengan trim coy....
                    var hargaJadi=data.trim();
                    $('#IdHargaScan').val(hargaJadi);
                }
            });
        }
    });
    $('#StandarHargaScan').change(function(){
        var id_multi =$('#id_multi').val();
        var StandarHarga = $('#StandarHargaScan').val();
        var IdBarang ="<?php echo $IdBarang;?>";
        if(id_multi=="Satuan Utama"){
            if(StandarHarga=="harga_1"){
                var harga="<?php echo $harga_1;?>";
                $('#IdHargaScan').val(harga);
            }
            if(StandarHarga=="harga_2"){
                var harga="<?php echo $harga_2;?>";
                $('#IdHargaScan').val(harga);
            }
            if(StandarHarga=="harga_3"){
                var harga="<?php echo $harga_3;?>";
                $('#IdHargaScan').val(harga);
            }
            if(StandarHarga=="harga_4"){
                var harga="<?php echo $harga_4;?>";
                $('#IdHargaScan').val(harga);
            }
            if(StandarHarga==""){
                var harga="0";
                $('#IdHargaScan').val(harga);
            }
        }else{
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/Kasir/CariMultiHarga.php',
                data 	: {StandarHarga: StandarHarga, IdBarang: IdBarang, id_multi: id_multi},
                success : function(data){
                    //Hilangkan spasi dengan trim coy....
                    var hargaJadi=data.trim();
                    $('#IdHargaScan').val(hargaJadi);
                }
            });
        }
        });
</script>

