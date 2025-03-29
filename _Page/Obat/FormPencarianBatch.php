<script>
    $(document).ready(function(){
        $('#ProsesPencarianBatch').submit(function(){
            $('#TabelHasilPencarianBatch').html('Loading...');
            var ProsesPencarianBatch=$('#ProsesPencarianBatch').serialize();
            $.ajax({
                type 	: 'POST',
                url 	: '_Page/Obat/TabelHasilPencarianBatch.php',
                data 	:  ProsesPencarianBatch,
                success : function(data){
                    $('#TabelHasilPencarianBatch').html(data);
                }
            });
        });
    });
</script>
<div class="modal-body">
    <form action="javascript:void(0);" id="ProsesPencarianBatch">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group">
                            <input type="text" class="form-control" id="Keyword" name="Keyword" class="form-control" placeholder="Seri Batch Barang">
                            <div class="input-group-append border-primary">
                                <button type="submit" class="btn btn-danger">
                                    <i class="mdi mdi-search-web"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" id="TabelHasilPencarianBatch">

            </div>
        </div>
    </form>
</div>
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-12 text-center">
            <button class="btn btn-rounded btn-outline-danger" data-dismiss="modal">
                <i class="mdi mdi-close"></i> Tutup
            </button>
        </div>
    </div>
</div>