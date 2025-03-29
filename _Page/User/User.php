<script>
    $(document).ready(function(){
        $('#TabelUser').load("_Page/User/TabelUser.php");
    });
    //Pencarian
    $('#PencarianUser').keyup(function(){
        var keyword = $('#PencarianUser').val();
        $.ajax({
            type 	: 'POST',
            url 	: '_Page/User/TabelUser.php',
            data 	:  'keyword='+ keyword,
            success : function(data){
                $('#TabelUser').html(data);
            }
        });
    });
    $('#TambahUser').click(function(){
        var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
        $('#Halaman').html(Loading);
        $('#Halaman').load('_Page/User/TambahUser.php');
    });
</script>
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 grid-margin stretch-card">
        <div class="card card-statistics">
            <div class="card-body">
                <h3 class="text-primary"><i class="menu-icon mdi mdi-account-box"></i> Data Akses</h3>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col col-lg-6">
                        <div class="input-group">
                            <input type="text" class="form-control" id="PencarianUser" class="form-control" placeholder="Username.." value="">
                            <div class="input-group-append border-primary">
                                <span class="input-group-text bg-transparent">
                                    <i class="mdi mdi-menu mdi-search-web"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col col-lg-6 text-right">
                        <button class="btn btn-rounded btn-outline-primary" id="TambahUser">
                            <i class="menu-icon mdi mdi-account-plus"></i> Tambah User
                        </button>
                        <button class="btn btn-rounded btn-outline-warning" id="ReloadUser">
                            <i class="menu-icon mdi mdi-reload"></i> Reload
                        </button>
                    </div>
                </div>
            </div>
            <div  id="TabelUser">
                <!----- Tabel disini ----->
            </div>
        </div>
    </div>
</div>