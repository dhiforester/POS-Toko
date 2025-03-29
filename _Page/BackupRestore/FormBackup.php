<form action="javascript:void(0);" id="ProsesScanKasir">
    <script>
        $('#ModalBackup').on('shown.bs.modal', function() {
            $('#ScanBarcode').focus();
        });
    </script>
    <div class="modal-header bg-primary">
        <div class="row">
            <div class="form-group col-md-12 text-center">
                <h4 class="text-white">Konfirmasi Backup</h4>
            </div>
        </div>
    </div>
    <div class="modal-body bg-white">
        <div class="row">
            <div class="form-group col-md-12">
                <div class="alert alert-primary" role="alert">
                    Apakah anda yakin akan melakukan backup sekarang?
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <div class="row">
            <div class="form-group col-md-12 text-center">
                <a href="_Page/BackupRestore/ProsesBackup.php" target="_blank" class="btn btn-rounded btn-outline-primary">
                    <i class="menu-icon mdi mdi-download"></i> Mulai Backup
                </a>
                <button class="btn btn-rounded btn-outline-danger" data-dismiss="modal">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</form>