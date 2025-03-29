<?php
if(!empty($_POST['id_klaim'])){
    $id_klaim=$_POST['id_klaim'];
}else{
    $id_klaim="";
}
?>
<script>
    $('#MulaiHapus').click(function(){
        var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
        $('#NotifikasiHapusHadiah').html(Loading);
        var id_hadiah = <?php echo "$id_hadiah"; ?>;
        $.ajax({
            type 	: 'POST',
            url 	: '_Page/PromoPoint/ProsesHapusHadiah.php',
            data    : { id_hadiah: id_hadiah },
            success : function(data){
                $('#NotifikasiHapusHadiah').html(data);
                //menangkap keterangan notifikasi
                var Notifikasi=$('#NotifikasiHapusHadiahBerhasil').html();
                if(Notifikasi=="Berhasil"){
                    $('#TabelHadiah').load('_Page/PromoPoint/TabelHadiah.php');
                    $('#ModalDeleteHadiah').modal('hide');
                    $('#ModalDeleteHadiahBerhasil').modal('show');
                }
            }
        });
    });
</script>
<form action="javascript:void(0);" id="ProsesDeleteKlaim">
    <input type="hidden" name="id_klaim" value="<?php echo $id_klaim;?>">
    <div class="modal-body">
        <div class="row">
            <div class="form-group col-md-12 text-center">
                <img src="images/tanya.gif" width="70%">
                <p class="text-danger" id="NotifikasiDeleteKlaim">Apakah anda yakin akan menghapus data ini?</p>
            </div>
        </div>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="form-group col-md-12 text-center">
                <button type="submit" class="btn btn-rounded btn-outline-primary">
                    Hapus
                </button>
                <button class="btn btn-rounded btn-outline-danger" data-dismiss="modal">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</form>