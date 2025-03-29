<div id="ModalLogout" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-12 text-center">
                        <h4>Logout Form</h4>
                    </div>
                    <div class="form-group col-md-12 text-center" id="NotifikasiLogout">
                       <img src="images/pertanyaan.png" width="50%">
                    </div>
                    <div class="form-group col-md-12">
                        <div class="alert alert-danger" role="alert">
                            <p>Apakah anda yakin akan keluar dari akun akses anda?</p>
                        </div>
                    </div>
                    <div class="form-group col-md-12 text-right">
                        <button type="button" class="btn btn-sm btn-rounded btn-primary" id="KlikProsesLogout">
                            <i class="menu-icon mdi mdi-check"></i>Ya, Logout
                        </button>
                        <button type="button" class="btn btn-sm btn-rounded btn-danger" data-dismiss="modal">
                            <i class="menu-icon mdi mdi-close"></i> Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="ModalLogoutBerhasil" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-12 text-center">
                        <h4>Logout Berhasil</h4>
                    </div>
                    <div class="form-group col-md-12 text-center" id="NotifikasiLogout">
                       <img src="images/berhasil.gif" width="50%">
                    </div>
                    <div class="form-group col-md-12">
                        <div class="alert alert-danger" role="alert">
                            <p>Proses Logout berhasil.</p>
                        </div>
                    </div>
                    <div class="form-group col-md-12 text-right">
                        <button type="button" class="btn btn-sm btn-rounded btn-danger" data-dismiss="modal" id="TutupLogoutBerhasil">
                            <i class="menu-icon mdi mdi-close"></i> Tutup (Esc)
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>