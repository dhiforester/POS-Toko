<?php
    include "../../_Config/Connection.php";
    //Tangkap Parameter Stok Minimal
    if(!empty($_POST['StokMin'])){
        $StokMin=$_POST['StokMin'];
    }else{
        $StokMin="0";
    }
    //Tangkap Kategori
    if(!empty($_POST['kategori'])){
        $kategori=$_POST['kategori'];
        $NamaKategori=$_POST['kategori'];
    }else{
        $kategori="";
        $NamaKategori="Semua";
    }
    //Batas Data
    if(!empty($_POST['batas'])){
        $batas=$_POST['batas'];
    }else{
        $batas="10";
    }
?>
<script>
     $(document).ready(function(){
        $('#StokMin').focus();
    });
    $('#TampilkanData').submit(function(){
        var StokMin=$('#StokMin').val();
        var kategori=$('#kategori').val();
        var batas=$('#batas').val();
        $('#DataObatHampirHabis').html('Loading..');
        $.ajax({
            url     : "_Page/Beranda/DataObatHampirHabis.php",
            method  : "POST",
            data    : { StokMin: StokMin, kategori: kategori, batas: batas },
            success: function (data) {
                $('#DataObatHampirHabis').html(data);
            }
        })
    });
</script>
<form action="javascript:void(0);" id="TampilkanData">
    <div class="modal-body bg-white">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-3">
                        <h4 class="text-primary">Barang Hampir Habis</h4>
                    </div>
                    <div class="form-group col-md-2">
                        <input type="number" min="0" class="form-control form-control-lg" id="batas" name="batas" placeholder="batas" value="<?php echo $batas;?>">
                        <small>Batas Data</small>
                    </div>
                    <div class="form-group col-md-2">
                        <select name="kategori" id="kategori" class="form-control">
                            <option value="">Semua</option>
                            <?php
                                $QryKategori = mysqli_query($conn, "SELECT DISTINCT kategori FROM obat");
                                while ($DataKategori = mysqli_fetch_array($QryKategori)) {
                                    $ListKategori = $DataKategori['kategori'];
                                    if($ListKategori==$kategori){
                                        if($ListKategori!==""){
                                            echo '<option selected value="'.$ListKategori.'">'.$ListKategori.'</option>';
                                        }
                                    }else{
                                        if($ListKategori!==""){
                                            echo '<option value="'.$ListKategori.'">'.$ListKategori.'</option>';
                                        }
                                    }
                                }
                            ?>
                        </select>
                        <small>Kategori</small>
                    </div>
                    <div class="form-group col-md-2">
                        <input type="number" min="0" class="form-control" id="StokMin" name="StokMin" class="form-control" placeholder="Stok Minimal" value="<?php echo $StokMin;?>">
                        <small>Stok Minimal</small>
                    </div>
                    <div class="form-group col-md-3 text-right">
                        <button type="submit" class="btn btn-danger">
                            Lihat
                        </button>
                        <a href="<?php echo"_Page/Beranda/HtmlHabis.php?batas=$batas&stok=$StokMin&kategori=$kategori";?>" class="btn btn-warning" target="_blank">
                            HTML
                        </a>
                        <a href="<?php echo"_Page/Beranda/ExcelHabis.php?batas=$batas&stok=$StokMin&kategori=$kategori";?>"class="btn btn-warning" target="_blank">
                            Excel
                        </a>
                    </div>
                </div>
                <div class="row bg-white">
                    <div class="col-md-12" id="TabelStokHampirHabis" style="height: 400px; overflow-y: scroll;">
                        <div class="table-responsive overflow-auto">
                            <table class="table table-bordered scroll-container table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>Kode</th>
                                        <th>Nama/Merek</th>
                                        <th>Kategori</th>
                                        <th>Stok</th>
                                        <th>Harga Eceran</th>
                                        <th>Harga Beli</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $no = 1;
                                        //KONDISI PENGATURAN MASING FILTER
                                        if(!empty($kategori)){
                                            $query = mysqli_query($conn, "SELECT*FROM obat WHERE stok<'$StokMin' AND kategori='$kategori' ORDER BY nama ASC LIMIT $batas");
                                        }else{
                                            $query = mysqli_query($conn, "SELECT*FROM obat WHERE stok<'$StokMin' ORDER BY nama ASC LIMIT $batas");
                                        }
                                        
                                        while ($data = mysqli_fetch_array($query)) {
                                            $id_obat = $data['id_obat'];
                                            $nama= $data['nama'];
                                            $kode = $data['kode'];
                                            $satuan = $data['satuan'];
                                            $kategori= $data['kategori'];
                                            $stok= $data['stok'];
                                            if(!empty($data['harga_4'])){
                                                $harga_4= $data['harga_4'];
                                            }else{
                                                $harga_4="0";
                                            }
                                            if(!empty($data['harga_1'])){
                                                $harga_1= $data['harga_1'];
                                            }else{
                                                $harga_1="0";
                                            }
                                    ?>
                                    <tr>
                                        <td><?php echo "$no";?></td>
                                        <td><?php echo "$kode";?></td>
                                        <td><?php echo "$nama";?></td>
                                        <td><?php echo "$kategori";?></td>
                                        <td><?php echo "$stok $satuan";?></td>
                                        <td><?php echo "Rp " . number_format($harga_4,0,',','.');?></td>
                                        <td><?php echo "Rp " . number_format($harga_1,0,',','.');?></td>
                                    </tr>
                                    <?php $no++;} ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<div class="modal-body">
    <div class="row bg-white">
        <div class="form-group col-md-12 text-center">
            <button type="button" class="btn btn-md btn-primary" data-dismiss="modal">
                <i class="menu-icon mdi mdi-close"></i> Tutup
            </button>
        </div>
    </div>
</div>

