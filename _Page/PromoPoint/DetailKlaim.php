    <?php
        //koneksi dan error
        include "../../_Config/Connection.php";
        //Tangkap id_klaim
        if(empty($_POST['id_klaim'])){
            $id_klaim="";
            $id_member="";
            $id_hadiah ="";
            $nama_member ="";
            $nama_hadiah ="";
            $tanggal ="";
            $qty ="";
            $point ="";
        }else{
            $id_klaim=$_POST['id_klaim'];
            //Buka Database
            $QryKlaim = mysqli_query($conn, "SELECT * FROM klaim WHERE id_klaim='$id_klaim'")or die(mysqli_error($conn));
            $DataKlaim = mysqli_fetch_array($QryKlaim);
            $id_member= $DataKlaim['id_member'];
            $id_hadiah = $DataKlaim['id_hadiah'];
            $nama_member = $DataKlaim['nama_member'];
            $nama_hadiah = $DataKlaim['nama_hadiah'];
            $tanggal = $DataKlaim['tanggal'];
            $qty = $DataKlaim['qty'];
            $point = $DataKlaim['point'];
            //Buka Data hadiah
            $QryHadiah = mysqli_query($conn, "SELECT * FROM hadiah WHERE id_hadiah='$id_hadiah'")or die(mysqli_error($conn));
            $DataHadiah= mysqli_fetch_array($QryHadiah);
            $PointHadiah= $DataHadiah['point'];
            //Buka Point Member 
            $QryMember = mysqli_query($conn, "SELECT * FROM hadiah WHERE id_hadiah='$id_hadiah'")or die(mysqli_error($conn));
            $DataMember= mysqli_fetch_array($QryMember);
            $PointMember= $DataMember['point'];
        }
    ?>
    <div class="modal-body bg-primary">
        <div class="row">
            <div class="col-md-12 text-center">
                <h4 class="text-white">
                    <i class="menu-icon mdi mdi-star"></i> Detail Klaim
                </h4>
            </div>
        </div>
    </div>
    <div class="modal-body bg-white">
        <div class="row">
            <div class="form-group col-md-12">
                <label for="margin_atas"><b>Tanggal</b></label>
                <input type="text" readonly min="0" class="form-control" value="<?php echo "$tanggal";?>">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6">
                <label for="margin_atas">Hadiah</label>
                <input type="text" readonly name="hadiah" class="form-control" value="<?php echo "$nama_hadiah";?>">
            </div>
            <div class="form-group col-md-6">
                <label for="margin_atas">Point Hadiah</label>
                <input type="text" readonly name="PointHadiah" class="form-control" value="<?php echo "$PointHadiah";?>">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6">
                <label for="margin_atas">Member</label>
                <input type="text" readonly name="member" class="form-control" value="<?php echo "$nama_member";?>">
            </div>
            <div class="form-group col-md-6">
                <label for="margin_atas">Point Member</label>
                <input type="text" readonly name="PointMember" class="form-control" value="<?php echo "$PointMember";?>">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-12">
                <label for="margin_atas"><b>Jumlah Hadiah</b></label>
                <input type="number" readonly min="0" name="qty" id="qty" class="form-control" value="<?php echo "$qty";?>">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-12">
                <label for="margin_atas">Jumlah Point Klaim</label>
                <input type="text" readonly name="point" id="point" class="form-control" value="<?php echo "$point";?>">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" id="">
                <div class="form-group col-md-12 text-center">
                    <button class="btn btn-rounded btn-outline-danger" data-dismiss="modal">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>