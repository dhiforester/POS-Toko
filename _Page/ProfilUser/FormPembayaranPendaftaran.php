<?php
    ini_set("display_errors","off");
    include "../../_Config/Connection.php";
    include "../../_Config/SessionLogin.php";
?>
<form action="javascript:void(0)" id="ProsesPembayaranPendaftaran" enctype="multipart/form-data">
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12 text-center">
                <blockquote class="blockquote">
                    <h5>Form Pembayaran Biaya Pemasangan</h5>
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
                <input type="date" class="form-control" name="tanggal" value="<?php echo date('Y-m-d'); ?>">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-12">
                <label for="">Tujuan Pembayaran</label>
                <input type="text" readonly class="form-control" name="tujuan_pembayaran" value="Pembayaran Biaya Pemasangan">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-12">
                <label for="">No Rekening Pengirim</label>
                <input type="number" min="1" class="form-control" name="rekening">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-12">
                <label for="">Nominal Pembayaran</label>
                <input type="number" readonly min="1" class="form-control" name="nominal" value="<?php echo "$BiayaTotal";?>">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-12">
                <label for="">No.Resi/Bukti Transfer</label>
                <input type="text" min="1" class="form-control" name="no_resi">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-12">
                <label for="">Bukti Transfer</label>
                <input type="file" class="form-control" name="ForoBukti">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" id="NotifikasiPembayaranPendaftaran">
                <div class="alert alert-primary" role="alert">
                    <p class="text-primary">
                        Apabila terjadi kesalahan nominal pengiriman uang, 
                        petugas kami akan memberikan konfirmasi pengembalian melalui telepon pada kontak yang anda gunakan 
                        pada saat ProsesPembayaranPendaftaran, atau anda bisa menghubungi petugas kami melalui nomor (0232) 871930.
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="form-group col-md-12 text-center">
                <button type="submit" class="btn btn-rounded btn-outline-primary">
                    Simpan
                </button>
                <button class="btn btn-rounded btn-outline-danger" data-dismiss="modal">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</form>