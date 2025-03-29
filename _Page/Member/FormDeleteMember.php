<?php
if(!empty($_POST['IdMember'])){
    $IdMember=$_POST['IdMember'];
}else{
    $IdMember="";
}
    
?>
<form action="javascript:void(0);" id="ProsesDeleteMember">
    <input type="hidden" name="IdMember" value="<?php echo $IdMember;?>">
    <div class="modal-body">
        <div class="row">
            <div class="form-group col-md-12 text-center">
                <img src="images/tanya.gif" width="70%">
                <p class="text-danger" id="NotifikasiDeleteMember">Apakah anda yakin akan menghapus data ini?</p>
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