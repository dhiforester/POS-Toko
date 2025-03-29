    <?php
        //koneksi dan error
        include "../../_Config/Connection.php";
         //Id hadiah
         if(!empty($_POST['id_hadiah'])){
            $id_hadiah=$_POST['id_hadiah'];
            $QryHadiah = mysqli_query($conn, "SELECT * FROM hadiah WHERE id_hadiah='$id_hadiah'")or die(mysqli_error($conn));
            $DataHadiah = mysqli_fetch_array($QryHadiah);
            $id_barang= $DataHadiah['id_barang'];
            $KodeHadiah = $DataHadiah['kode'];
            $NamaHadiah = $DataHadiah['nama'];
            $PointHadiah = $DataHadiah['point'];
        }else{
            $id_hadiah="";
            $id_barang="";
            $KodeHadiah ="";
            $NamaHadiah ="";
            $PointHadiah ="";
        }
    ?>
    <script type="text/javascript">
        $(document).on("keyup", function(event) {
            if (event.keyCode === 115) {
                document.getElementById("QtyKalim").focus();
            }
            if (event.keyCode === 27) {
                $("#ModalTambahKlaim").modal('hide');
            }
        });
    </script>
    <script>
        $(document).ready(function(){
            //FOCUS EVENT KembaliPilihMember
            $('#KembaliPilihMember').focus(function(){
                $('#KembaliPilihMember').removeClass('btn-outline-primary');
                $('#KembaliPilihMember').addClass('btn-primary');
            });
            $('#KembaliPilihMember').focusout(function(){
                $('#KembaliPilihMember').removeClass('btn-primary');
                $('#KembaliPilihMember').addClass('btn-outline-primary');
            });
            //FOCUS EVENT SelesaikanKlaim
            $('#SelesaikanKlaim').focus(function(){
                $('#SelesaikanKlaim').removeClass('btn-outline-primary');
                $('#SelesaikanKlaim').addClass('btn-primary');
            });
            $('#SelesaikanKlaim').focusout(function(){
                $('#SelesaikanKlaim').removeClass('btn-primary');
                $('#SelesaikanKlaim').addClass('btn-outline-primary');
            });
            //FOCUS EVENT BatalkanKlaim
            $('#BatalkanKlaim').focus(function(){
                $('#BatalkanKlaim').removeClass('btn-outline-danger');
                $('#BatalkanKlaim').addClass('btn-danger');
            });
            $('#BatalkanKlaim').focusout(function(){
                $('#BatalkanKlaim').removeClass('btn-danger');
                $('#BatalkanKlaim').addClass('btn-outline-danger');
            });
            //Event Kembali Pilih Member
            $('#KembaliPilihMember').click(function(){
                var id_hadiah = <?php echo "$id_hadiah";?>;
                $.ajax({
                    type 	: 'POST',
                    url 	: '_Page/PromoPoint/FormPilihMember.php',
                    data 	:  {id_hadiah: id_hadiah},
                    success : function(data){
                        $('#FormTambahKlaim').html(data);
                    }
                });
            });
        });
    </script>
    <?php
        //Id member
        if(!empty($_POST['id_member'])){
            $id_member=$_POST['id_member'];
            $Qrymember = mysqli_query($conn, "SELECT * FROM member WHERE id_member='$id_member'")or die(mysqli_error($conn));
            $DataMember = mysqli_fetch_array($Qrymember);
            $NamaMember= $DataMember['nama'];
            $NikMember= $DataMember['nik'];
            $PointMember= $DataMember['point'];
        }else{
            $id_member="";
            $NamaMember="";
            $NikMember="";
            $PointMember="";
        }
    ?>
    <script>
        $(document).ready(function(){
            $('#QtyKalim').keyup(function(){
                var QtyKalim= $('#QtyKalim').val();
                var PointHadiah= $('#PointHadiah').val();
                var PointMember= $('#PointMember').val();
                var PointMemberNum= parseInt(PointMember);
                var JumlahKlaim=QtyKalim*PointHadiah;
                var SisaPoint=PointMember-JumlahKlaim;
                var JumlahKlaimNum= parseInt(JumlahKlaim);
                $('#pointklaim').val(JumlahKlaim);
                if(SisaPoint<0){
                    $('#NotifikasiSimpanKlaim').html('<div class="alert alert-danger" role="alert">Maaf Point Tidak Cukup</div>');
                }
            });
            $('#ProsesSimpanKlaim').submit(function(){
                var ProsesSimpanKlaim = $('#ProsesSimpanKlaim').serialize();
                $.ajax({
                    type 	: 'POST',
                    url 	: '_Page/PromoPoint/ProsesSimpanKlaim.php',
                    data 	:  ProsesSimpanKlaim,
                    success : function(data){
                        $('#NotifikasiSimpanKlaim').html(data);
                        //menangkap keterangan notifikasi
                        var Notifikasi=$('#NotifikasiSimpanKlaimBerhasil').html();
                        if(Notifikasi=="Berhasil"){
                            $('#TabelKlaim').load('_Page/PromoPoint/TabelKlaim.php');
                            $('#ModalTambahKlaim').modal('hide');
                            $('#ModalTambahKlaimBerhasil').modal('show');
                        }
                    }
                });
            });
        });
       
    </script>
    <div class="modal-body bg-primary">
        <div class="row">
            <div class="col-md-12 text-center">
                <h4 class="text-white">
                    <i class="menu-icon mdi mdi-star"></i> Klaim Hadiah
                </h4>
            </div>
        </div>
    </div>
    <div class="modal-body bg-white">
        <form action="javascript:void(0);" id="ProsesSimpanKlaim">
            <input type="hidden" name="id_hadiah" value="<?php echo "$id_hadiah"; ?>">
            <input type="hidden" name="id_member" value="<?php echo "$id_member"; ?>">
            <div class="row">
                <div class="form-group col-md-12">
                    <label for="margin_atas"><b>3. Jumlah Hadiah (F4)</b></label>
                    <input type="number" min="0" name="qty" id="QtyKalim" class="form-control" id="qty" value="1">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="margin_atas">Hadiah</label>
                    <input type="text" readonly name="hadiah" class="form-control" value="<?php echo "$NamaHadiah";?>">
                </div>
                <div class="form-group col-md-6">
                    <label for="margin_atas">Point Hadiah</label>
                    <input type="text" readonly name="PointHadiah" id="PointHadiah" class="form-control" value="<?php echo "$PointHadiah";?>">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="margin_atas">Member</label>
                    <input type="text" readonly name="member" class="form-control" value="<?php echo "$NamaMember";?>">
                </div>
                <div class="form-group col-md-6">
                    <label for="margin_atas">Point Member</label>
                    <input type="text" readonly name="PointMember" id="PointMember" class="form-control" value="<?php echo "$PointMember";?>">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-12">
                    <label for="margin_atas">Jumlah Point Klaim</label>
                    <input type="text" readonly name="point" id="pointklaim" class="form-control" value="<?php echo "$PointHadiah";?>">
                </div>
            </div>
            <?php if(empty($id_member)){ ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <div class="alert alert-danger" role="alert">
                                    <small>Anda Belum Memilih Member, Silahkan kembali!!</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php }else{ ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group row">
                            <div class="col-sm-12" id="NotifikasiSimpanKlaim">
                                <div class="alert alert-primary" role="alert">
                                    <small>Isi jumlah hadiah yang diberikan, kemudian simpan proses ini.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="row">
                <div class="col-md-12" id="">
                    <div class="form-group col-md-12 text-center">
                        <button type="button" class="btn btn-rounded btn-outline-primary" id="KembaliPilihMember">
                            <i class="menu-icon mdi mdi-arrow-left-bold"></i> Back 
                        </button>
                        <?php if(!empty($id_member)){ ?>
                            <button type="submit" class="btn btn-rounded btn-outline-primary" id="SelesaikanKlaim">
                                <i class="menu-icon mdi mdi-floppy"></i> Selesai
                            </button>
                        <?php } ?>
                        <button class="btn btn-rounded btn-outline-danger" data-dismiss="modal" id="BatalkanKlaim">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</form>