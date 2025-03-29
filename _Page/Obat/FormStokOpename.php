<?php
    include "../../_Config/Connection.php";
    if(empty($_POST['id_so'])){
        $id_so="";
        if(!empty($_POST['id_obat'])){
            $id_obat=$_POST['id_obat'];
            //Buka data obat
            $QryObat = mysqli_query($conn, "SELECT * FROM obat WHERE id_obat='$id_obat'")or die(mysqli_error($conn));
            $DataObat = mysqli_fetch_array($QryObat);
            $id_obat= $DataObat['id_obat'];
            $nama= $DataObat['nama'];
            $kode = $DataObat['kode'];
            $kategori = $DataObat['kategori'];
            $satuan = $DataObat['satuan'];
            $konversi = $DataObat['konversi'];
            $stok= $DataObat['stok'];
            $harga_1= $DataObat['harga_1'];
            $harga_2= $DataObat['harga_2'];
            $harga_3= $DataObat['harga_3'];
            $harga_4= $DataObat['harga_4'];   
        }else{
            $id_obat="";
            $nama="";
            $kode="";
            $kategori ="";
            $satuan="";
            $konversi="";
            $stok="";
            $harga_1="";
            $harga_2="";
            $harga_3="";
            $harga_4="";
        }
        if(!empty($_POST['periode'])){
            $periode=$_POST['periode'];
        }else{
            $periode=date('Y-m-d');
        }
        $stok_nyata ="";
        $selisih="";
        $keterangan="";
    }else{
        $id_so=$_POST['id_so'];
        //Buka data stok opename
        $QrySo = mysqli_query($conn, "SELECT * FROM stok_opename WHERE id_so='$id_so'")or die(mysqli_error($conn));
        $DataSo = mysqli_fetch_array($QrySo);
        $id_obat= $DataSo['id_barang'];
        $periode= $DataSo['tanggal'];
        $stok = $DataSo['stok_data'];
        $stok_nyata = $DataSo['stok_nyata'];
        $selisih= $DataSo['selisih'];
        $keterangan= $DataSo['keterangan'];
        //Buka Data Obat
        $QryObat = mysqli_query($conn, "SELECT * FROM obat WHERE id_obat='$id_obat'")or die(mysqli_error($conn));
        $DataObat = mysqli_fetch_array($QryObat);
        $nama= $DataObat['nama'];
        $kode = $DataObat['kode'];
        $satuan = $DataObat['satuan'];
    }
?>
<script type="text/javascript">
    $(document).on("keyup", function(event) {
        if (event.keyCode === 27) {
            document.getElementById("TutupMultiHarga").click();
        }
    });
</script>
<script>
    $('#ModalPilihBarangSO').on('show.bs.modal', function (e) {
        var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
        $('#ListBarangSo').html(Loading);
        $('#ListBarangSo').load('_Page/Obat/ListBarangSo.php');
    });
    $('#KirimTanggal').submit(function() {
        var periode = $('#periode').val();
        $.ajax({
            url     : "_Page/Obat/FormStokOpename.php",
            method  : "POST",
            data    : { periode: periode },
            success: function (data) {
                $('#FormStokOpename').html(data);
            }
        })
    });
    $('#stok_nyata').keyup(function() {
        var stok_nyata = $('#stok_nyata').val();
        var stok_nyata = parseInt(stok_nyata);
        var stok_data = $('#stok_data').val();
        var stok_data = parseInt(stok_data);
        var selisih=stok_nyata-stok_data;
        $('#selisih').val(selisih);
    });
    $('#ProsesInputStokopename').submit(function() {
        $('#TombolInputSo').html('Loading..');
        var ProsesInputStokopename = $('#ProsesInputStokopename').serialize();
        $.ajax({
            url     : "_Page/Obat/ProsesInputStokopename.php",
            method  : "POST",
            data    : ProsesInputStokopename,
            success: function (data) {
                $('#TombolInputSo').html(data);
                var periode="<?php echo $periode;?>";
                $.ajax({
                    url     : "_Page/Obat/FormStokOpename.php",
                    method  : "POST",
                    data    : { periode: periode },
                    success: function (data) {
                        $('#FormStokOpename').html(data);
                    }
                })
            }
        })
    });
</script>
<?php
    //hitung jumlah data
    if(!empty($id_obat)){
        $jml_data = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM stok_opename WHERE id_barang='$id_obat'"));
    }else{
        $jml_data = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM stok_opename WHERE tanggal='$periode'"));
    } 
    $a=1;
    $b=$jml_data;
    for ( $i =$a; $i<=$b; $i++ ){
?>
    <script>
        $('#EditSo<?php echo $i;?>').click(function() {
            var EditSo = $('#EditSo<?php echo $i;?>').val();
            var mode = EditSo.split(',');
            var id_so = mode[0];
            var periode = mode[1];
            $('#FormStokOpename').html('Loading..');
            $.ajax({
                url     : "_Page/Obat/FormStokOpename.php",
                method  : "POST",
                data    : { id_so: id_so, periode: periode },
                success: function (data) {
                    $('#FormStokOpename').html(data);
                }
            })
        });
        $('#DeleteSo<?php echo $i;?>').click(function() {
            var DeleteSo = $('#DeleteSo<?php echo $i;?>').val();
            var mode = DeleteSo.split(',');
            var id_so = mode[0];
            var periode = mode[1];
            $('#FormStokOpename').html('Loading..');
            $.ajax({
                url     : "_Page/Obat/ProsesDeleteSo.php",
                method  : "POST",
                data    : { id_so: id_so, periode: periode },
                success: function (data) {
                    $.ajax({
                        url     : "_Page/Obat/FormStokOpename.php",
                        method  : "POST",
                        data    : { periode: periode },
                        success: function (data) {
                            $('#FormStokOpename').html(data);
                        }
                    })
                }
            })
        });
    </script>
<?php } ?>
<div class="modal-header bg-primary">
    <div class="row">
        <div class="col col-md-12">
            <h3 class="text-white">
                <i class="mdi mdi-check-all"></i>Stok Opename <?php echo $periode;?>
            </h3>
        </div>
    </div>
    <div class="row">
        <div class="col col-md-12 text-white">
            <form action="javascript:void(0);" id="KirimTanggal">
                <div class="input-group">
                    <input type="date" id="periode" class="form-control border-warning" value="<?php echo date('Y-m-d');?>">
                    <div class="input-group-append border-primary">
                        <button type="submit" class="btn btn-danger">
                            Tampilkan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal-body">
    <form action="javascript:void(0);" id="ProsesInputStokopename">
        <input type="hidden" name="id_so" value="<?php echo $id_so;?>">
        <input type="hidden" name="id_obat" value="<?php echo $id_obat;?>">
        <div class="row">
            <div class="form-group col-md-2">
                <input type="date" require class="form-control border-warning" name="periode" value="<?php echo $periode;?>">
                <small>Tanggal</small>
            </div>
            <div class="form-group col-md-2">
                <input readonly type="text" require class="form-control border-warning" name="kode" id="kode" placeholder="Click" value="<?php echo $kode;?>" data-toggle="modal" data-target="#ModalPilihBarangSO">
                <small>Kode</small>
            </div>
            <div class="form-group col-md-2">
                <input readonly type="text" require class="form-control border-dark" name="nama" id="nama" value="<?php echo $nama;?>">
                <small>Nama</small>
            </div>
            <div class="form-group col-md-1">
                <input readonly type="text" require class="form-control border-dark" name="stok_data" id="stok_data" value="<?php echo $stok;?>">
                <small>Stok</small>
            </div>
            <div class="form-group col-md-1">
                <input readonly type="text" require class="form-control border-dark" name="satuan" id="satuan" value="<?php echo $satuan;?>">
                <small>Satuan</small>
            </div>
            <div class="form-group col-md-1">
                <input type="text" require class="form-control border-dark" name="stok_nyata" id="stok_nyata" value="<?php echo $stok_nyata;?>">
                <small>Stok Nyata</small>
            </div>
            <div class="form-group col-md-1">
                <input type="text" require class="form-control border-dark" name="selisih" id="selisih" value="<?php echo $selisih;?>">
                <small>Selisih</small>
            </div>
            <div class="form-group col-md-2">
                <input type="text" require class="form-control border-dark" name="keterangan" id="keterangan" value="<?php echo $keterangan;?>">
                <small>Keterangan</small>
            </div>
            <div class="form-group col-md-2">
                <button type="submit" class="btn btn-md btn-primary" id="TombolInputSo">
                    <?php
                        if(empty($id_so)){
                            echo '<i class="mdi mdi-plus"></i> Add (Enter)';
                        }else{
                            echo '<i class="mdi mdi-plus"></i> Update (Enter)';
                        }
                    ?>
                </button>
            </div>
        </div>
    </form>
    <div class="row bg-white">
        <div class="col-md-12" >
            <div class="table-responsive" id="TabelMultiHarga" style="height: 300px; overflow-y: scroll;">
                <table class="table table-bordered table-hover table-md scroll-container">
                    <thead class="thead-dark">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Satuan</th>
                            <th>Stok</th>
                            <th>Stok Nyata</th>
                            <th>Selisih</th>
                            <th>Keterangan</th>
                            <th>Opt</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $no = 1;
                            //KONDISI PENGATURAN MASING FILTER
                            if(!empty($id_obat)){
                                $query = mysqli_query($conn, "SELECT*FROM stok_opename WHERE id_barang='$id_obat'");
                            }else{
                                $query = mysqli_query($conn, "SELECT*FROM stok_opename WHERE tanggal='$periode'");
                            }
                            while ($data = mysqli_fetch_array($query)) {
                                $id_so = $data['id_so'];
                                $id_barang = $data['id_barang'];
                                $tanggal = $data['tanggal'];
                                $stok_data= $data['stok_data'];
                                $stok_nyata= $data['stok_nyata'];
                                $selisih= $data['selisih'];
                                $keterangan= $data['keterangan'];
                                //Buka Barang
                                $QryObat = mysqli_query($conn, "SELECT * FROM obat WHERE id_obat='$id_barang'")or die(mysqli_error($conn));
                                $DataObat = mysqli_fetch_array($QryObat);
                                $namaBarang= $DataObat['nama'];
                                $kodeBarang = $DataObat['kode'];
                                $satuanBarang = $DataObat['satuan'];
                        ?>
                        <tr>
                            <td><?php echo "$no";?></td>
                            <td><?php echo "$tanggal";?></td>
                            <td><?php echo "$kodeBarang";?></td>
                            <td><?php echo "$namaBarang";?></td>
                            <td><?php echo "$satuanBarang";?></td>
                            <td><?php echo "" . number_format($stok_data,0,',','.');?></td>
                            <td><?php echo "" . number_format($stok_nyata,0,',','.');?></td>
                            <td><?php echo "" . number_format($selisih,0,',','.');?></td>
                            <td><?php echo "$keterangan";?></td>
                            <td>
                                <button class="btn btn-sm btn-warning" id="EditSo<?php echo "$no";?>" <?php echo "value='".$id_so.",".$periode."'"; ?>>
                                    <i class="menu-icon mdi mdi-pencil" aria-hidden="true"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" id="DeleteSo<?php echo "$no";?>" <?php echo "value='".$id_so.",".$periode."'"; ?>>
                                    <i class="menu-icon mdi mdi-delete" aria-hidden="true"></i>
                                </button>
                            </td>
                        </tr>
                        <?php $no++;} ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer bg-primary">
    <div class="row">
        <div class="form-group col-md-12 text-center">
            <button type="button" class="btn btn-rounded btn-danger" id="TutupMultiHarga" data-dismiss="modal">
                <i class="mdi mdi-close"></i> Tutup (Esc)
            </button>
        </div>
    </div>
</div>