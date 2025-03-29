<?php
    if(!empty($_POST['id_obat'])){
        $id_obat=$_POST['id_obat'];
        if(!empty($_POST['id_multi'])){
            $id_multi=$_POST['id_multi'];
        }else{
            $id_multi="";
        }   
    }else{
        $id_obat="";
    }    
?>
<form action="javascript:void(0);" id="ProsesDeleteMultiHarga">
    <input type="hidden" name="id_obat" value="<?php echo $id_obat;?>">
    <input type="hidden" name="id_multi" value="<?php echo $id_multi;?>">
    <div class="modal-body bg-danger">
        <h4>Konfirmasi Hapus Data</h4>
    </div>
    <div class="modal-body bg-dark">
        <div class="row">
            <div class="form-group col-md-12 text-center">
                <img src="images/delete.png" width="70%">
                <p class="text-white" id="NotifikasiDeleteMultiHarga">Apakah anda yakin akan menghapus data ini?</p>
            </div>
        </div>
    </div>
    <div class="modal-body bg-danger">
        <div class="row">
            <div class="form-group col-md-12 text-center">
                <button type="submit" class="btn btn-rounded btn-outline-light">
                    Hapus
                </button>
                <button class="btn btn-rounded btn-outline-light" data-dismiss="modal">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</form>