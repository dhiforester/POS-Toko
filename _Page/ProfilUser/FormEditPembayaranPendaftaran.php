<?php
    ini_set("display_errors","off");
    include "../../_Config/Connection.php";
    include "../../_Config/SessionLogin.php";
?>
<form action="javascript:void(0)" id="ProsesEditPembayaranPendaftaran" enctype="multipart/form-data">
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12 text-center">
                <blockquote class="blockquote">
                    <h5>Form Edit Pembayaran Biaya Pemasangan</h5>
                </blockquote>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6">
                <label for="">Id.Pelanggan</label>
                <input type="text" readonly class="form-control" name="id_pelanggan" value="<?php echo "$SessionIdPelanggan"; ?>">
            </div>
            <div class="form-group col-md-6">
                <label for="">Tanggal</label>
                <input type="date" <?php if($StatusPembayaranPendaftaran!=="Menunggu Konfirmasi"){echo "readonly";} ?> class="form-control" name="tanggal" value="<?php echo "$TanggalPembayaranPendaftaran"; ?>">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-12">
                <label for="">Tujuan Pembayaran</label>
                <input type="text" readonly class="form-control" name="tujuan_pembayaran" value="<?php echo "$TujuanPembayaranPendaftaran"; ?>">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-12">
                <label for="">No Rekening Pengirim</label>
                <input type="number" min="1" <?php if($StatusPembayaranPendaftaran!=="Menunggu Konfirmasi"){echo "readonly";} ?> class="form-control" name="rekening" value="<?php echo "$No_rekPembayaranPendaftaran"; ?>">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-12">
                <label for="">Nominal Pembayaran</label>
                <input type="number" readonly min="1" class="form-control" name="nominal" value="<?php echo "$Nominal_pembayaranPembayaranPendaftaran";?>">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-12">
                <label for="">No.Resi/Bukti Transfer</label>
                <input type="text" min="1" <?php if($StatusPembayaranPendaftaran!=="Menunggu Konfirmasi"){echo "readonly";} ?> class="form-control" name="no_resi" value="<?php echo "$No_buktiPembayaranPendaftaran";?>">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-12">
                <label for="">Bukti Transfer</label>
                <input type="hidden" name="BuktiLama" value="<?php echo "$Bukti_pembayaranPembayaranPendaftaran"; ?>">
                <input type="file" <?php if($StatusPembayaranPendaftaran!=="Menunggu Konfirmasi"){echo "readonly";} ?> class="form-control" name="ForoBukti">
                <br>
                <img src="images/pembayaran/<?php echo "$Bukti_pembayaranPembayaranPendaftaran"; ?>" width="100px">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" id="NotifikasiEditPembayaranPendaftaran">
                <div class="alert alert-primary" role="alert">
                    <p class="text-primary">
                        Apabila terjadi kesalahan nominal pengiriman uang, 
                        petugas kami akan memberikan konfirmasi pengembalian melalui telepon pada kontak yang anda gunakan 
                        pada saat ProsesPembayaranPendaftaran, atau nda bisa menghubungi petugas kami melalui nomor (0232) 871930.
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="form-group col-md-12 text-center">
                <?php if($StatusPembayaranPendaftaran=="Menunggu Konfirmasi"){ ?>
                    <button type="submit" class="btn btn-rounded btn-outline-primary">
                        Simpan
                    </button>
                <?php } ?>
                <button class="btn btn-rounded btn-outline-danger" data-dismiss="modal">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</form>