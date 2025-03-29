<?php
    //koneksi
    ini_set("display_errors","off");
    include "../../_Config/Connection.php";
    include "../../_Config/SessionLogin.php";
    
?>
<script>
    $('#EditProfil').click(function(){
        var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
        $('#Halaman').html(Loading);
        $('#Halaman').load('_Page/ProfilUser/EditProfil.php');
    });
    $(document).ready(function(){
        $('#ModalPembayaranPendaftaran').on('show.bs.modal', function (e) {
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#formPembayaranPendaftaran').html(Loading);
            var IdUser = $(e.relatedTarget).data('id');
            $.ajax({
                url     : "_Page/ProfilUser/formPembayaranPendaftaran.php",
                method  : "POST",
                data    : { IdUser: IdUser },
                success: function (data) {
                    $('#formPembayaranPendaftaran').html(data);
                    //Ketika disetujui submit
                    $('#ProsesPembayaranPendaftaran').submit(function(){
                        var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
                        $('#NotifikasiPembayaranPendaftaran').html(Loading);
                        var ProsesPembayaranPendaftaran = new FormData($(this)[0]);
                        $.ajax({
                            type 	    : 'POST',
                            url 	    : '_Page/ProfilUser/ProsesPembayaranPendaftaran.php',
                            data 	    :  ProsesPembayaranPendaftaran,
                            processData : false,
                            contentType : false,
                            success : function(data){
                                $('#NotifikasiPembayaranPendaftaran').html(data);
                                //menangkap keterangan notifikasi
                                var Notifikasi=$('#NotifikasiPembayaranPendaftaranBerhasil').html();
                                if(Notifikasi=="Berhasil"){
                                    $('#Halaman').load('_Page/ProfilUser/ProfilUser.php');
                                    $('#ModalPembayaranPendaftaran').modal('hide');
                                    $('#ModalPembayaranPendaftaranBerhasil').modal('show');
                                }
                            }
                        });
                    });
                }
            })
        });
        $('#ModalEditPembayaranPendaftaran').on('show.bs.modal', function (e) {
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#FormEditPembayaranPendaftaran').html(Loading);
            var IdUser = $(e.relatedTarget).data('id');
            $.ajax({
                url     : "_Page/ProfilUser/FormEditPembayaranPendaftaran.php",
                method  : "POST",
                data    : { IdUser: IdUser },
                success: function (data) {
                    $('#FormEditPembayaranPendaftaran').html(data);
                    //Ketika disetujui submit
                    $('#ProsesEditPembayaranPendaftaran').submit(function(){
                        var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
                        $('#NotifikasiEditPembayaranPendaftaran').html(Loading);
                        var ProsesEditPembayaranPendaftaran = new FormData($(this)[0]);
                        $.ajax({
                            type 	    : 'POST',
                            url 	    : '_Page/ProfilUser/ProsesEditPembayaranPendaftaran.php',
                            data 	    :  ProsesEditPembayaranPendaftaran,
                            processData : false,
                            contentType : false,
                            success : function(data){
                                $('#NotifikasiEditPembayaranPendaftaran').html(data);
                                //menangkap keterangan notifikasi
                                var Notifikasi=$('#NotifikasiEditPembayaranPendaftaranBerhasil').html();
                                if(Notifikasi=="Berhasil"){
                                    $('#Halaman').load('_Page/ProfilUser/ProfilUser.php');
                                    $('#ModalEditPembayaranPendaftaran').modal('hide');
                                    $('#ModalEditPembayaranPendaftaranBerhasil').modal('show');
                                }
                            }
                        });
                    });
                }
            })
        });
    });
</script>
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 grid-margin stretch-card">
        <div class="card card-statistics">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h3>Profil User</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if($SessionLevel=="Pelanggan"){ ?>
    <div class="row">
        <div class="col-lg-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <?php 
                                if(empty($SessionNoMeter)){
                                    echo '<div class="alert alert-primary" role="alert">';
                                    echo "<h4>Keterangan :</h4> <br>";
                                    echo "<p class='text-danger'>";
                                    echo "  Lakukan pembayaran biaya pemasangan,";
                                    echo "  biaya jaminan konsumen dan matrai untuk menyelesaikan persyaratan pemasangan.";
                                    echo "  Adapun rincian tersebut adalah sebagai berikut ini:";
                                    echo "  <ol class='text-danger'><b>RINCIAN BIAYA</b>";
                                    echo "      <li>Biaya pemasangan <b>$RpBiayaPemasangan</b></li>";
                                    echo "      <li>Biaya Jaminan Konsumen <b>$RpBiayaJaminan</b></li>";
                                    echo "      <li>Biaya Matrai <b>$RpBiayaMatrai</b></li>";
                                    echo "      <li>TOTAL BIAYA YANG HARUS DIBAYAR <b>$RpBiayaTotal</b></li>";
                                    echo "  </ol>";
                                    echo "</p>";
                                    if(empty($StatusPembayaranPendaftaran)){
                                        echo " <p class='text-danger'>";
                                        echo "      Pembayaran dapat dilakukan dengan metode transfer ke rekening <b>BRI Atas Nama PLN ULP Kuningan 511100081415.</b>";
                                        echo "      Apabila sudah melakukan pembayaran sesuai ketentuan lakukan konfirmasi pada tautan <a href='javascript:void(0)' data-toggle='modal' data-target='#ModalPembayaranPendaftaran'>berikut ini.</a>";
                                        echo "  </p>";
                                    }else{
                                        echo " <p class='text-danger'>";
                                        echo "      Anda sudah melakukan konfirmasi pembayaran, petugas kami sedang melakukan validasi pembayaran tersebut.</b>";
                                        echo "      Proses konfirmasi paling lambat 2 X 24 Jam setelah proses konfirmasi selesai dilakukan, lihat data pembayaran anda pada tautan <a href='javascript:void(0)' data-toggle='modal' data-target='#ModalEditPembayaranPendaftaran'>berikut ini.</a>";
                                        echo "  </p>";
                                    }
                                    echo '</div>';
                                }else{
                                    echo "<h4>Keterangan :</h4> <br>";
                                    echo "<p>Akun anda sudah aktif, anda dapat mempergunakan berbagai layanan pada aplikasi ini dengan mudah.</p>";
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<div class="row">
    <div class="col-lg-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td><b>ID Akses</b></td>
                                    <td><?php echo "$SessionIdUser";?></td>
                                </tr>
                                <tr>
                                    <td><b>Username</b></td>
                                    <td><?php echo "$SessionUsername";?></td>
                                </tr>
                                <tr>
                                    <td><b>Password</b></td>
                                    <td><?php echo "$SessionPassword";?></td>
                                </tr>
                                <tr>
                                    <td><b>Kategori Pengguna</b></td>
                                    <td><?php echo "$SessionLevel";?></td>
                                </tr>
                                <?php if($SessionLevel=="Pelanggan"){ ?>
                                    <tr>
                                        <td><b>NIK</b></td>
                                        <td><?php echo "$SessionNik";?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Nama</b></td>
                                        <td><?php echo "$SessionNama";?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Alamat</b></td>
                                        <td><?php echo "$SessionAlamat";?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Tepat,Tanggal Lahir</b></td>
                                        <td><?php echo "$SessionTtl";?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Email</b></td>
                                        <td><?php echo "$SessionEmail";?></td>
                                    </tr>
                                    <tr>
                                        <td><b>No.HP</b></td>
                                        <td><?php echo "$SessionNoHp";?></td>
                                    </tr>
                                    <tr>
                                        <td><b>No.Meter</b></td>
                                        <td>
                                            <?php 
                                                if(empty($SessionNoMeter)){
                                                    echo "<b class='text-danger'>Belum Dipasang</b>";
                                                }else{
                                                    echo "$SessionNoMeter";
                                                }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>Golongan Tarif</b></td>
                                        <td><?php echo "$SessionKategoriKonsumen-$SessionTegangan";?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Status Pengguna</b></td>
                                        <td><?php echo "$SessionStatus";?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

