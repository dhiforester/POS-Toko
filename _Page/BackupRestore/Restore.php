<script>
    $(document).ready(function(){
        $('#ProsesRestore').submit(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            var ProsesRestore=new FormData($(this)[0]);
            $('#NotifikasiRestore').html(Loading);
            $.ajax({
                type 	    : 'POST',
                url 	    : '_Page/BackupRestore/ProsesRestore.php',
                data 	    :  ProsesRestore,
                processData : false,
                contentType : false,
                success : function(data){
                    $('#IsiBackupRestore').html(data);
                }
            });
        });
    });
</script>
<div class="row">
    <div class="col-lg-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <form action="javascript:void(0);" id="ProsesRestore" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">File SQL</label>
                                <div class="col-sm-8">
                                    <input type="file" class="form-control" name="backup_file">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md col-12" id="NotifikasiRestore">
                            <div class="alert alert-warning text-center" role="alert">
                                <b>Perhatian!!!</b><br>
                                Sebelum melakukan restore database sebaiknya anda telah melakukan 
                                <i>Backup</i> database pada directory yang aman.
                                Pastikan juga bahwa file yang anda gunakan untuk restore database sudah sesuai.
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md col-12 text-center">
                            <button type="submit" class="btn btn-lg btn-primary">
                                <i class="menu-icon mdi mdi-check"></i> Restore
                            </button>
                            <button type="reset" class="btn btn-lg btn-danger">
                                <i class="menu-icon mdi mdi-reload"></i> Reset
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>