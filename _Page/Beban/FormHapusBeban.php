<?php
    if(!empty($_POST['id_beban'])){
        $id_beban=$_POST['id_beban'];
    }else{
        $id_beban="";
    }    
?>
<form action="javascript:void(0);" id="ProsesHapusbeban">
    <input type="hidden" name="id_beban" value="<?php echo $id_beban;?>">
    <div class="modal-body bg-danger">
        <h4> <i class="mdi mdi-delete"></i> Konfirmasi Hapus Data</h4>
    </div>
    <?php
        if(!empty($id_beban)){
            echo '<div class="modal-body bg-dark">';
            echo '  <div class="row">';
            echo '      <div class="form-group col-md-12 text-center">';
            echo '          <img src="images/delete.png" width="70%">';
            echo '          <p class="text-white" id="NotifikasiHapusBeban">Apakah anda yakin akan menghapus data ini?</p>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
            echo '<div class="modal-body bg-danger">';
            echo '  <div class="row">';
            echo '      <div class="form-group col-md-12 text-center">';
            echo '          <button type="submit" class="btn btn-rounded btn-outline-light" id="KonfirmasiHapusbeban">';
            echo '              <i class="mdi mdi-check-all"></i> Hapus';
            echo '          </button>';
            echo '          <button type="submit" class="btn btn-rounded btn-outline-light">';
            echo '              <i class="mdi mdi-close"></i> Tutup';
            echo '          </button>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            echo '<div class="modal-body bg-dark">';
            echo '  <div class="row">';
            echo '      <div class="form-group col-md-12 text-center">';
            echo '          <img src="images/delete.png" width="70%">';
            echo '          <p class="text-danger">Data ID tidak ditemukan, Anda tidak bisa melanjutkan proses</p>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
            echo '<div class="modal-body bg-danger">';
            echo '  <div class="row">';
            echo '      <div class="form-group col-md-12 text-center">';
            echo '          <button type="submit" class="btn btn-rounded btn-outline-light">';
            echo '              <i class="mdi mdi-close"></i> Tutup';
            echo '          </button>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }
    ?>
</form>