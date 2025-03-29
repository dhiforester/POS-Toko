    <script type="text/javascript">
        $(document).on("keyup", function(event) {
            if (event.keyCode === 112) {
                document.getElementById("KeywordPencarianDataBarangEdit").focus();
            }
            if (event.keyCode === 27) {
                $('#ModalEditHadiahBerhasil').modal('hide');
            }
        });
    </script>
    <script>
        $(document).ready(function(){
            //KeywordPencarianDataBarangEdit
            $('#KeywordPencarianDataBarangEdit').focus(function(){
                $('#KeywordPencarianDataBarangEdit').removeClass('border-dark');
                $('#KeywordPencarianDataBarangEdit').addClass('border-primary');
            });
            $('#KeywordPencarianDataBarangEdit').focusout(function(){
                $('#KeywordPencarianDataBarangEdit').removeClass('border-primary');
                $('#KeywordPencarianDataBarangEdit').addClass('border-dark');
            });
            // Focus TombolPencarianBarangEdit
            $('#TombolPencarianBarangEdit').focus(function(){
                $('#TombolPencarianBarangEdit').removeClass('btn-outline-dark');
                $('#TombolPencarianBarangEdit').addClass('btn-dark');
            });
            $('#TombolPencarianBarangEdit').focusout(function(){
                $('#TombolPencarianBarangEdit').removeClass('btn-dark');
                $('#TombolPencarianBarangEdit').addClass('btn-outline-dark');
            });
            // Focus TabelDataBarangEdit
            $('#TabelDataBarangEdit').focus(function(){
                $('#TabelDataBarangEdit').addClass('badge-outline-primary');
            });
            $('#TabelDataBarangEdit').focusout(function(){
                $('#TabelDataBarangEdit').removeClass('badge-outline-primary');
            });
            // Focus point
            $('#point').focus(function(){
                $('#point').removeClass('border-dark');
                $('#point').addClass('border-primary');
            });
            $('#point').focusout(function(){
                $('#point').removeClass('border-primary');
                $('#point').addClass('border-dark');
            });
             // Focus TombolMulaiEditHadiah
             $('#TombolMulaiEditHadiah').focus(function(){
                $('#TombolMulaiEditHadiah').removeClass('btn-outline-light');
                $('#TombolMulaiEditHadiah').addClass('btn-light');
            });
            $('#TombolMulaiEditHadiah').focusout(function(){
                $('#TombolMulaiEditHadiah').removeClass('btn-light');
                $('#TombolMulaiEditHadiah').addClass('btn-outline-light');
            });
            // Focus TombolTutupModalEditHadiah
            $('#TombolTutupModalEditHadiah').focus(function(){
                $('#TombolTutupModalEditHadiah').removeClass('btn-outline-danger');
                $('#TombolTutupModalEditHadiah').addClass('btn-danger');
            });
            $('#TombolTutupModalEditHadiah').focusout(function(){
                $('#TombolTutupModalEditHadiah').removeClass('btn-danger');
                $('#TombolTutupModalEditHadiah').addClass('btn-outline-danger');
            });
            //MulaiCariBarangEdit
            $('#MulaiCariBarangEdit').submit(function(){
                var keyword = $('#KeywordPencarianDataBarangEdit').val();
                $.ajax({
                    type 	: 'POST',
                    url 	: '_Page/PromoPoint/TabelDataBarang.php',
                    data 	:  'keyword='+ keyword,
                    success : function(data){
                        $('#TabelDataBarangEdit').html(data);
                    }
                });
            });
        });
    </script>
    <?php
        ini_set("display_errors","off");
        include "../../_Config/Connection.php";
        if(!empty($_POST['id_hadiah'])){
            $IdHadiah=$_POST['id_hadiah'];
        }else{
            $IdHadiah="";
        }
        //Buka data hadiah
        $QryHadiah = mysqli_query($conn, "SELECT * FROM hadiah WHERE id_hadiah='$IdHadiah'")or die(mysqli_error($conn));
        $DataHadiah = mysqli_fetch_array($QryHadiah);
        $id_barang= $DataHadiah['id_barang'];
        $kode = $DataHadiah['kode'];
        $nama = $DataHadiah['nama'];
        $point = $DataHadiah['point'];
        //Buka data barang
        $QryObat = mysqli_query($conn, "SELECT * FROM obat WHERE id_obat='$id_barang'")or die(mysqli_error($conn));
        $DataObat = mysqli_fetch_array($QryObat);
        $nama= $DataObat['nama'];
        $kode = $DataObat['kode'];
    ?>
    <div class="modal-body bg-primary">
        <div class="row">
            <div class="col-md-12 text-center">
                <h4 class="text-white">Edit Data Hadiah</h4>
            </div>
        </div>
    </div>
    <div class="modal-body bg-white">
        <form action="javascript:void(0);" id="MulaiCariBarangEdit">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <small>Cari Data Barang (F1)</small>
                            <div class="input-group">
                                <input type="text" id="KeywordPencarianDataBarangEdit" class="form-control border-dark" placeholder="Cari.." value="">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-rounded btn-outline-dark" id="TombolPencarianBarangEdit">
                                        <i class="menu-icon mdi mdi-search-web"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
<form action="javascript:void(0);" id="ProsesEditHadiah">
        <input type="hidden" name="IdHadiahEdit" value="<?php echo $IdHadiah; ?>">
        <input type="hidden" name="IdBarangLama" value="<?php echo "$id_barang"; ?>">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group row">
                    <div class="col-sm-12" id="TabelDataBarangEdit" style="height: 150px; overflow-y: scroll;">
                        <table class="table table-sm table-bordered scroll-container">
                            <thead>
                                <tr>
                                    <th>Ck</th>
                                    <th>Kode</th>
                                    <th>Barang</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                    <input type="radio" name="id_hadiah" value="<?php echo "$id_barang";?>" checked>
                                    </td>
                                    <td><?php echo "$kode";?></td>
                                    <td><?php echo "$nama";?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group row">
                    <div class="col-sm-12">
                        <small>Jumlah Point</small>
                        <input type="text" required name="point" id="point" class="form-control border-dark" value="<?php echo $point;?>">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" id="NotifikasiEditHadiah">
                <div class="alert alert-primary" role="alert">
                    <small>Pastikan data yang anda input sudah lengkap dan benar!</small>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer bg-primary">
        <button type="submit" class="btn btn-rounded btn-outline-light" id="TombolMulaiEditHadiah">
            <i class="mdi mdi-pencil"></i> Edit
        </button>
        <button class="btn btn-rounded btn-outline-danger" data-dismiss="modal" id="TombolTutupModalEditHadiah">
            <i class="mdi mdi-close"></i> Tutup
        </button>
    </div>
</form>