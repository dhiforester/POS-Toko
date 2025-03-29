
<form action="javascript:void(0);" id="ProsesInputLogin" method="POST">
    <script>
        $('#ModalLogin').on('shown.bs.modal', function() {
            $('#FormUsername').focus()
        });
    </script>
    <div class="row">
        <div class="form-group col-md-12 text-center">
            <h3>Login Form</h3>
        </div>
        <div class="form-group col-md-12">
            <label for="">Username</label>
            <input type="text" required name="username" id="FormUsername" class="form-control" placeholder="Username" autofocus>
        </div>
        <div class="form-group col-md-12">
            <label for="">Password</label>
            <input type="password" required name="password" class="form-control" placeholder="Password">
        </div>
        <div class="form-group col-md-12">
            <div class="alert alert-primary" role="alert" id="NotifikasiInputLogin">
                <p>
                    Pastikan username dan password yang anda masukan benar
                </p>
            </div>
        </div>
        <div class="form-group col-md-12 text-right">
            <button type="submit" class="btn btn-sm btn-block btn-primary">
                <i class="menu-icon mdi mdi-check"></i> Login
            </button>
            <button type="button" class="btn btn-sm btn-block btn-danger" data-dismiss="modal">
                <i class="menu-icon mdi mdi-close"></i> Tutup (Esc)
            </button>
        </div>
    </div>
</form>