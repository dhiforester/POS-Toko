<script>
    $(document).ready(function(){
        $('#ModalDeleteObat').on('show.bs.modal', function (e) {
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#FormDeleteObat').html(Loading);
            var IdUser = $(e.relatedTarget).data('id');
            $.ajax({
                url     : "_Page/Obat/FormDeleteObat.php",
                method  : "POST",
                data    : { IdUser: IdUser },
                success: function (data) {
                    $('#FormDeleteObat').html(data);
                    //Ketika disetujui delete
                    $('#ProsesDeleteObat').submit(function(){
                        var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
                        $('#NotifikasiDeleteObat').html(Loading);
                        var ProsesDeleteObat = $('#ProsesDeleteObat').serialize();
                        $.ajax({
                            type 	: 'POST',
                            url 	: '_Page/Obat/ProsesDeleteObat.php',
                            data 	:  ProsesDeleteObat,
                            success : function(data){
                                $('#NotifikasiDeleteObat').html(data);
                                //menangkap keterangan notifikasi
                                var Notifikasi=$('#NotifikasiDeleteObatBerhasil').html();
                                if(Notifikasi=="Berhasil"){
                                    $('#TabelObat').load('_Page/Obat/TabelObat.php');
                                    $('#ModalDeleteObat').modal('hide');
                                    $('#ModalDeleteObatBerhasil').modal('show');
                                }
                            }
                        });
                    });
                }
            })
        });
        //ketika Modal Delete muncul
        $('#ModalDetailObat').on('show.bs.modal', function (e) {
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#DetailObat').html(Loading);
            var id_obat = $(e.relatedTarget).data('id');
            $.ajax({
                url     : "_Page/Obat/DetailObat.php",
                method  : "POST",
                data    : { id_obat: id_obat },
                success: function (data) {
                    $('#DetailObat').html(data);
                }
            })
        });
    });
</script>
<div class="card-body">
    <div class="table-responsive">
        <table class="table table-bordered scroll-container">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama/Merek Barang</th>
                    <th>QTY</th>
                    <th>Harga</th>
                    <th>Subtotal</th>
                    <th>Option</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $no = 1;
                    $query = mysqli_query($conn, "SELECT*FROM rincian_transaksi WHERE kode_transaksi='$kode_transaksi' ORDER BY id_rincian ASC");
                    while ($data = mysqli_fetch_array($query)) {
                        $id_rincian = $data['id_rincian'];
                        $id_obat = $data['id_obat'];
                        $qty= $data['qty'];
                        $satuan = $data['satuan'];
                        $harga = $data['harga'];
                        $jumlah= $data['jumlah'];
                        //Buka data Obat
                        $QryObat = mysqli_query($conn, "SELECT * FROM obat WHERE id_obat='$id_obat'")or die(mysqli_error($conn));
	                    $DataObat = mysqli_fetch_array($QryObat);
	                    $nama = $DataObat['nama'];
                ?>
                <tr>
                    <td><?php echo "$no";?></td>
                    <td><?php echo "$nama";?></td>
                    <td><?php echo "$qty $satuan";?></td>
                    <td><?php echo "Rp " . number_format($harga,0,',','.');?></td>
                    <td><?php echo "Rp " . number_format($jumlah,0,',','.');?></td>
                    <td align="center" width="10%">
                        <div class="btn-group">
                            <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#ModalEditRincian" data-id="<?php echo "$id_rincian,$kode_transaksi";?>">
                                <i class="menu-icon mdi mdi-pencil" aria-hidden="true"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#ModalDeleteRincian" data-id="<?php echo "$id_rincian,$kode_transaksi";?>">
                                <i class="menu-icon mdi mdi-delete" aria-hidden="true"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php $no++;} ?>
            </tbody>
        </table>
    </div>
</div>