<?php
    //koneksi dan error
    ini_set("display_errors","off");
    include "../../_Config/Connection.php";
    //Atur Batas
    $batas="10";
    //Atur Page
    if(!empty($_POST['page'])){
        $page=$_POST['page'];
        $posisi = ( $page - 1 ) * $batas;
    }else{
        $page="1";
        $posisi = 0;
    }
    //Atur Keyword
    if(isset($_POST['keyword'])){
        $keyword=$_POST['keyword'];
    }else{
        $keyword="";
    }
    //hitung jumlah data
    if(empty($keyword)){
        $jml_data = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM user"));
    }else{
        $jml_data = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM user WHERE username like '%$keyword%'"));
    }
    //Jumlah halaman
    $JmlHalaman = ceil($jml_data/$batas); 
    $JmlHalaman_real = ceil($jml_data/$batas); 
    $prev=$page-1;
    $next=$page+1;
    if($next>$JmlHalaman){
        $next=$page;
    }else{
        $next=$page+1;
    }
    if($prev<"1"){
        $prev="1";
    }else{
        $prev=$page-1;
    }
?>
<script>
    $(document).ready(function(){
        $('#ReloadUser').click(function(){
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#TabelUser').html(Loading);
            $('#TabelUser').load('_Page/User/TabelUser.php');
        });
        //ketika Modal Delete muncul
        $('#ModalDeleteUser').on('show.bs.modal', function (e) {
            var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
            $('#FormDeleteUser').html(Loading);
            var IdUser = $(e.relatedTarget).data('id');
            $.ajax({
                url     : "_Page/User/FormDeleteUser.php",
                method  : "POST",
                data    : { IdUser: IdUser },
                success: function (data) {
                    $('#FormDeleteUser').html(data);
                    //Ketika disetujui delete
                    $('#ProsesDeleteUser').submit(function(){
                        var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
                        $('#NotifikasiDeleteUser').html(Loading);
                        var ProsesDeleteUser = $('#ProsesDeleteUser').serialize();
                        $.ajax({
                            type 	: 'POST',
                            url 	: '_Page/User/ProsesDeleteUser.php',
                            data 	:  ProsesDeleteUser,
                            success : function(data){
                                $('#NotifikasiDeleteUser').html(data);
                                //menangkap keterangan notifikasi
                                var Notifikasi=$('#NotifikasiDeleteUserBerhasil').html();
                                if(Notifikasi=="Berhasil"){
                                    $('#Halaman').load('_Page/User/User.php');
                                    $('#ModalDeleteUser').modal('hide');
                                    $('#ModalDeleteUserBerhasil').modal('show');
                                }
                            }
                        });
                    });
                }
            })
        });
        <?php 
            $a=1;
            $b=$jml_data;
            for ( $i =$a; $i<=$b; $i++ ){
        ?>
        $('#EditUser<?php echo "$i";?>').click(function() {
                var EditUser = $('#EditUser<?php echo $i;?>').val();
                var mode = EditUser.split(',');
                var IdUser = mode[0];
                var page = mode[1];
                var BatasData = mode[2];
                $.ajax({
                    url     : "_Page/User/EditUser.php",
                    method  : "POST",
                    data    : { page: page, IdUser: IdUser, BatasData: BatasData, },
                    success: function (data) {
                        $('#Halaman').html(data);

                    }
                })
            });
        <?php } ?>
        //ketika klik next
        $('#NextPage').click(function() {
            var valueNext = $('#NextPage').val();
            var mode = valueNext.split(',');
            var page = mode[0];
            var BatasData = mode[1];
            $.ajax({
                url     : "_Page/User/TabelUser.php",
                method  : "POST",
                data    : { page: page, BatasData: BatasData },
                success: function (data) {
                    $('#TabelUser').html(data);

                }
            })
        });
        //Ketika klik Previous
        $('#PrevPage').click(function() {
            var ValuePrev = $('#PrevPage').val();
            var mode = ValuePrev.split(',');
            var page = mode[0];
            var BatasData = mode[1];
            $.ajax({
                url     : "_Page/User/TabelUser.php",
                method  : "POST",
                data    : { page: page, BatasData: BatasData },
                success : function (data) {
                    $('#TabelUser').html(data);
                }
            })
        });
        <?php 
            $a=1;
            $b=$JmlHalaman;
            for ( $i =$a; $i<=$b; $i++ ){
        ?>
            //ketika klik page number
            $('#PageNumber<?php echo $i;?>').click(function() {
                var PageNumber = $('#PageNumber<?php echo $i;?>').val();
                var mode = PageNumber.split(',');
                var page = mode[0];
                var BatasData = mode[1];
                $.ajax({
                    url     : "_Page/User/TabelUser.php",
                    method  : "POST",
                    data    : { page: page, BatasData: BatasData },
                    success: function (data) {
                        $('#TabelUser').html(data);
                    }
                })
            });
        <?php } ?>
    });
</script>
<div class="card-body">
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Status</th>
                    <th>Level</th>
                    <th>Option</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $no = 1+$posisi;
                    //KONDISI PENGATURAN MASING FILTER
                    if(empty($keyword)){
                        $query = mysqli_query($conn, "SELECT*FROM user ORDER BY id_user DESC LIMIT $posisi, $batas");
                    }else{
                        $query = mysqli_query($conn, "SELECT*FROM user WHERE username like '%$keyword%' ORDER BY id_user DESC LIMIT $posisi, $batas");
                    }
                    while ($data = mysqli_fetch_array($query)) {
                        $id_user = $data['id_user'];
                        $username= $data['username'];
                        $password = $data['password'];
                        $status = $data['status'];
                        $level_akses= $data['level_akses'];
                ?>
                <tr>
                    <td><?php echo "$no";?></td>
                    <td><?php echo "$username";?></td>
                    <td><?php echo "$password";?></td>
                    <td><?php echo "$status";?></td>
                    <td>
                        <?php 
                            if($level_akses=="Admin"){
                                echo '<a class="text-primary">'.$level_akses.'</a>';
                            }
                            if($level_akses=="Kasir"){
                                echo '<a class="text-danger">'.$level_akses.'</a>';
                            }
                        ?>
                    </td>
                    <td align="center" width="10%">
                        <div class="btn-group">
                            <button class="btn btn-sm btn-info" id="EditUser<?php echo "$no";?>" <?php echo "value='".$id_user.",".$page.",".$batas."'"; ?>>
                                <i class="menu-icon mdi mdi-pencil" aria-hidden="true"></i> Edit
                            </button>
                            <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#ModalDeleteUser" data-id="<?php echo $id_user;?>">
                                <i class="menu-icon mdi mdi-delete" aria-hidden="true"></i> Hapus
                            </button>
                        </div>
                    </td>
                </tr>
                <?php $no++;} ?>
            </tbody>
        </table>
    </div>
</div>
<div class="card-body">
    <div class="row">
        <div class="col col-lg-12">
            <form action="javascript:void(0);" id="Paging">
                <div class="btn-group" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-outline-secondary" id="PrevPage" <?php echo "value='".$prev.",".$batas."'"; ?>>
                        <<
                    </button>
                    <?php 
                        //Navigasi nomor
                        $nmr = '';
                        if($JmlHalaman>5){
                            if($page>=3){
                                $a=$page-2;
                                $b=$page+2;
                                if($JmlHalaman<=$b){
                                    $a=$page-2;
                                    $b=$JmlHalaman;
                                }
                            }else{
                                $a=1;
                                $b=$page+2;
                                if($JmlHalaman<=$b){
                                    $a=1;
                                    $b=$JmlHalaman;
                                }
                            }
                        }else{
                            $a=1;
                            $b=$JmlHalaman;
                        }
                        for ( $i =$a; $i<=$b; $i++ ){
                    ?>
                    <button type="button" class="<?php if($i==$page){echo "btn btn-primary";}else{echo "btn btn-grey";} ?>" id="PageNumber<?php echo $i;?>" <?php echo "value='".$i.",".$batas."'"; ?>>
                        <?php echo $i;?>
                    </button>
                    <?php 
                        }
                    ?>
                    <button type="button" class="btn btn-outline-secondary" id="NextPage" <?php echo "value='".$next.",".$batas."'"; ?>>
                        >>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>