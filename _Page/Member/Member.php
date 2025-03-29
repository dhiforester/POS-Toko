<script>
    $(document).ready(function(){
        $('#PencarianMember').focus();
        $('#TabelMember').load("_Page/Member/TabelMember.php");
        //Event Focus TambahMember
        $('#TambahMember').focus(function(){
            $('#TambahMember').removeClass('btn-outline-primary');
            $('#TambahMember').addClass('btn-primary');
        });
        $('#TambahMember').focusout(function(){
            $('#TambahMember').removeClass('btn-primary');
            $('#TambahMember').addClass('btn-outline-primary');
        });
        //Event Focus ReloadMember
        $('#ReloadMember').focus(function(){
            $('#ReloadMember').removeClass('btn-outline-warning');
            $('#ReloadMember').addClass('btn-warning');
        });
        $('#ReloadMember').focusout(function(){
            $('#ReloadMember').removeClass('btn-warning');
            $('#ReloadMember').addClass('btn-outline-warning');
        });
    });
    //Pencarian
    $('#PencarianMember').keyup(function(){
        var keyword = $('#PencarianMember').val();
        $.ajax({
            type 	: 'POST',
            url 	: '_Page/Member/TabelMember.php',
            data 	:  'keyword='+ keyword,
            success : function(data){
                $('#TabelMember').html(data);
            }
        });
    });
    $('#TambahMember').click(function(){
        var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
        $('#Halaman').html(Loading);
        $('#Halaman').load('_Page/Member/TambahMember.php');
    });
</script>
<div class="row">
    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 grid-margin stretch-card">
        <div class="card card-statistics">
            <div class="card-body">
                <h3 class="text-primary"><i class="menu-icon mdi mdi-account-multiple"></i> Member & Supplier</h3>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 grid-margin stretch-card">
        <div class="card card-statistics">
            <div class="card-body">
                <div class="input-group">
                    <input type="text" class="form-control" id="PencarianMember" class="form-control" placeholder="Cari.." value="">
                    <div class="input-group-append border-primary">
                        <span class="input-group-text bg-transparent">
                            <i class="mdi mdi-menu mdi-search-web"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 grid-margin stretch-card">
        <div class="card card-statistics">
            <div class="card-body text-right">
                <button class="btn btn-rounded btn-outline-primary" id="TambahMember">
                    <i class="menu-icon mdi mdi-account-plus"></i> Tambah
                </button>
                <button class="btn btn-rounded btn-outline-warning" id="ReloadMember">
                    <i class="menu-icon mdi mdi-reload"></i> Reload
                </button>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 grid-margin">
        <div class="card">
            <div  id="TabelMember">
                <!----- Tabel disini ----->
            </div>
        </div>
    </div>
</div>