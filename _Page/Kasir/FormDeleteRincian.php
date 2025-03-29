<?php
    if(!empty($_POST['id_rincian'])){
        $id_rincian=$_POST['id_rincian'];
    }else{
        $id_rincian="";
    }
    
?>
<form action="javascript:void(0);" id="ProsesDeleteRincian">
    <script type="text/javascript">
        $(document).on("keyup", function(event) {
            if (event.keyCode === 13) {
                document.getElementById("TombolHapusRincian").click();
            }
            if (event.keyCode === 27) {
                document.getElementById("TombolTutupHapusRincian").click();
            }
        });
    </script>
    <input type="hidden" name="id_rincian" value="<?php echo $id_rincian;?>">
    <div class="modal-body">
        <div class="row">
            <div class="form-group col-md-12 text-center">
                <img src="images/delete.png" width="70%">
                <p class="text-danger" id="NotifikasiDeleteRincian">Apakah anda yakin akan menghapus data ini?</p>
            </div>
        </div>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="form-group col-md-12 text-center">
                <button type="submit" class="btn btn-rounded btn-outline-primary" id="TombolHapusRincian">
                    Hapus (Enter)
                </button>
                <button type="button" class="btn btn-rounded btn-outline-danger" data-dismiss="modal" id="TombolTutupHapusRincian">
                    Tutup (Esc)
                </button>
            </div>
        </div>
    </div>
</form>