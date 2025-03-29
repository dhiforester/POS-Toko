<script>
    $(document).ready(function(){
        $('#NotifikasiLogin').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#Halaman').html(Loading);
            $('#Halaman').load('_Page/Login/Login.php');
        });
        $('#NotifikasiPendaftaran').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#Halaman').html(Loading);
            $('#Halaman').load('_Page/Pendaftaran/Pendaftaran.php');
        });
    });
</script>
<div class="row purchace-popup">
    <div class="col-12">
        <span class="d-block d-md-flex align-items-center">
            <p>
                Dapatkan informasi lengkap dan pelayanan optimal dari PLN Kuningan dengan melakukan
                pendaftaran pada website ini.
            </p>
            <a class="btn ml-auto download-button d-none d-md-block" data-toggle="modal" data-target="#ModalLogin">
                Login
            </a>
            <button class="btn purchase-button mt-4 mt-md-0" id="NotifikasiPendaftaran">
                Daftar Sekarang
            </button>
            <i class="mdi mdi-close popup-dismiss d-none d-md-block"></i>
        </span>
    </div>
</div>