<?php
    //koneksi dan error
    include "../../_Config/Connection.php";
    //KategoriLaporan
    if(!empty($_POST['kategori'])){
        $KategoriLaporan=$_POST['kategori'];
    }else{
        $KategoriLaporan="Harian";
    }
    //OrderBy
    if(!empty($_POST['OrderBy'])){
        $OrderBy=$_POST['OrderBy'];
    }else{
        $OrderBy="id_transaksi";
    }
    //ShortBy
    if(!empty($_POST['ShortBy'])){
        $ShortBy=$_POST['ShortBy'];
    }else{
        $ShortBy="ASC";
    }
    //tanggal
    if(!empty($_POST['tanggal'])){
        $tanggal=$_POST['tanggal'];
    }else{
        $tanggal="";
    }
    //tahun
    if(!empty($_POST['tahun'])){
        $tahun=$_POST['tahun'];
    }else{
        $tahun="";
    }
    //bulan
    if(!empty($_POST['bulan'])){
        $bulan=$_POST['bulan'];
    }else{
        $bulan="";
    }
    //periode1
    if(!empty($_POST['periode1'])){
        $periode1=$_POST['periode1'];
    }else{
        $periode1="";
    }
    //periode2
    if(!empty($_POST['periode2'])){
        $periode2=$_POST['periode2'];
    }else{
        $periode2="";
    }
    $bulanan="$tahun-$bulan";
    //Menghitung jumlah tagihan utang
    if($KategoriLaporan=="Harian"){
        $QryJumlahTotalUtang = mysqli_query($conn, "SELECT SUM(total_tagihan) as total_tagihan FROM transaksi WHERE keterangan='Utang' AND tanggal like '%$tanggal%'");
    }
    if($KategoriLaporan=="Bulanan"){
        $QryJumlahTotalUtang = mysqli_query($conn, "SELECT SUM(total_tagihan) as total_tagihan FROM transaksi WHERE keterangan='Utang' AND tanggal like '%$bulanan%'");
    }
    if($KategoriLaporan=="Tahunan"){
        $QryJumlahTotalUtang = mysqli_query($conn, "SELECT SUM(total_tagihan) as total_tagihan FROM transaksi WHERE keterangan='Utang' AND tanggal like '%$tahun%'");
    }
    if($KategoriLaporan=="Periode"){
        $QryJumlahTotalUtang = mysqli_query($conn, "SELECT SUM(total_tagihan) as total_tagihan FROM transaksi WHERE keterangan='Utang' AND tanggal>='$periode1' AND tanggal<='$periode2'");
    }
    $DataJumlahTotalUtang = mysqli_fetch_array($QryJumlahTotalUtang);
    $JumlahUtang=$DataJumlahTotalUtang['total_tagihan'];
    //Menghitung jumlah tagihan Piutang
    if($KategoriLaporan=="Harian"){
        $QryJumlahTotalPiutang = mysqli_query($conn, "SELECT SUM(total_tagihan) as total_tagihan FROM transaksi WHERE keterangan='Piutang' AND tanggal like '%$tanggal%'");
    }
    if($KategoriLaporan=="Bulanan"){
        $QryJumlahTotalPiutang = mysqli_query($conn, "SELECT SUM(total_tagihan) as total_tagihan FROM transaksi WHERE keterangan='Piutang' AND tanggal like '%$bulanan%'");
    }
    if($KategoriLaporan=="Tahunan"){
        $QryJumlahTotalPiutang = mysqli_query($conn, "SELECT SUM(total_tagihan) as total_tagihan FROM transaksi WHERE keterangan='Piutang' AND tanggal like '%$tahun%'");
    }
    if($KategoriLaporan=="Periode"){
        $QryJumlahTotalPiutang = mysqli_query($conn, "SELECT SUM(total_tagihan) as total_tagihan FROM transaksi WHERE keterangan='Piutang' AND tanggal>='$periode1' AND tanggal<='$periode2'");
    }
    $DataJumlahTotalPiutang = mysqli_fetch_array($QryJumlahTotalPiutang);
    $JumlahPiutang=$DataJumlahTotalPiutang['total_tagihan'];
    

    //Menghitung jumlah pembayaran utang
    if($KategoriLaporan=="Harian"){
        $QryJumlahTotalUtangPembayaran = mysqli_query($conn, "SELECT SUM(selisih) as selisih FROM transaksi WHERE keterangan='Utang' AND tanggal like '%$tanggal%'");
    }
    if($KategoriLaporan=="Bulanan"){
        $QryJumlahTotalUtangPembayaran = mysqli_query($conn, "SELECT SUM(selisih) as selisih FROM transaksi WHERE keterangan='Utang' AND tanggal like '%$bulanan%'");
    }
    if($KategoriLaporan=="Tahunan"){
        $QryJumlahTotalUtangPembayaran = mysqli_query($conn, "SELECT SUM(selisih) as selisih FROM transaksi WHERE keterangan='Utang' AND tanggal like '%$tahun%'");
    }
    if($KategoriLaporan=="Periode"){
        $QryJumlahTotalUtangPembayaran = mysqli_query($conn, "SELECT SUM(selisih) as selisih FROM transaksi WHERE keterangan='Utang' AND tanggal>='$periode1' AND tanggal<='$periode2'");
    }
    $DataJumlahTotalUtangPembayaran = mysqli_fetch_array($QryJumlahTotalUtangPembayaran);
    $JumlahUtangpembayaran=$DataJumlahTotalUtangPembayaran['selisih'];
    //Menghitung jumlah pembayaran Piutang
    if($KategoriLaporan=="Harian"){
        $QryJumlahTotalPiutangPembayaran = mysqli_query($conn, "SELECT SUM(selisih) as selisih FROM transaksi WHERE keterangan='Piutang' AND tanggal like '%$tanggal%'");
    }
    if($KategoriLaporan=="Bulanan"){
        $QryJumlahTotalPiutangPembayaran = mysqli_query($conn, "SELECT SUM(selisih) as selisih FROM transaksi WHERE keterangan='Piutang' AND tanggal like '%$bulanan%'");
    }
    if($KategoriLaporan=="Tahunan"){
        $QryJumlahTotalPiutangPembayaran = mysqli_query($conn, "SELECT SUM(selisih) as selisih FROM transaksi WHERE keterangan='Piutang' AND tanggal like '%$tahun%'");
    }
    if($KategoriLaporan=="Periode"){
        $QryJumlahTotalPiutangPembayaran = mysqli_query($conn, "SELECT SUM(pembayaran) as pembayaran FROM transaksi WHERE keterangan='Piutang' AND tanggal>='$periode1' AND tanggal<='$periode2'");
    }
    $DataJumlahTotalPiutangPembayaran = mysqli_fetch_array($QryJumlahTotalPiutangPembayaran);
    $JumlahPiutangPembayaran=$DataJumlahTotalPiutangPembayaran['selisih'];
?>
    <div class="row">
        <div class="form-group col-sm-12 text-center">
            <h3>LAPORAN UTANG PIUTANG</h3>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-sm-12 text-center">
            <a href="<?php echo '_Page/Laporan/CetakUtangPiutangHtml.php?kategori='.$KategoriLaporan.'&OrderBy='.$OrderBy.'&ShortBy='.$ShortBy.'&tahun='.$tahun.'&bulan='.$bulan.'&periode1='.$periode1.'&periode2='.$periode2.'&tanggal='.$tanggal.'';?>" class="btn btn-rounded btn-outline-dark" target="_blank">
                <i class="mdi mdi-web"></i> Html
            </a>
            <a href="<?php echo '_Page/Laporan/CetakUtangPiutangExcel.php?kategori='.$KategoriLaporan.'&OrderBy='.$OrderBy.'&ShortBy='.$ShortBy.'&tahun='.$tahun.'&bulan='.$bulan.'&periode1='.$periode1.'&periode2='.$periode2.'&tanggal='.$tanggal.'';?>" class="btn btn-rounded btn-outline-dark" target="_blank">
                <i class="mdi mdi-file-excel"></i> Excel
            </a>
            <!--
            <a href="<?php echo '_Page/Laporan/CetakUtangPiutangPdf.php?kategori='.$KategoriLaporan.'&OrderBy='.$OrderBy.'&ShortBy='.$ShortBy.'&tahun='.$tahun.'&bulan='.$bulan.'&periode1='.$periode1.'&periode2='.$periode2.'&tanggal='.$tanggal.'';?>" class="btn btn-rounded btn-outline-dark" target="_blank">
                <i class="mdi mdi-file-pdf"></i> PDF
            </a>
            -->
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 grid-margin">
            <div class="table-responsive" style="height: 400px; overflow-y: scroll;">
                <table class="table table-hover table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th><b>No</b></th>
                            <th><b>Tanggal</b></th>
                            <th><b>Kode</b></th>
                            <th><b>Member/Supplier</b></th>
                            <th><b>Jumlah</b></th>
                            <th><b>Pembayaran</b></th>
                            <th><b>Keterangan</b></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $no = 1;
                            //KONDISI PENGATURAN MASING FILTER
                            if($KategoriLaporan=="Harian"){
                                $query = mysqli_query($conn, "SELECT*FROM transaksi WHERE keterangan!='Lunas' AND tanggal like '%$tanggal%' ORDER BY $OrderBy $ShortBy");
                            }
                            if($KategoriLaporan=="Bulanan"){
                                $query = mysqli_query($conn, "SELECT*FROM transaksi WHERE keterangan!='Lunas' AND tanggal like '%$bulanan%' ORDER BY $OrderBy $ShortBy");
                            }
                            if($KategoriLaporan=="Tahunan"){
                                $query = mysqli_query($conn, "SELECT*FROM transaksi WHERE keterangan!='Lunas' AND tanggal like '%$tahun%' ORDER BY $OrderBy $ShortBy");
                            }
                            if($KategoriLaporan=="Periode"){
                                $query = mysqli_query($conn, "SELECT*FROM transaksi WHERE keterangan!='Lunas' AND tanggal>='$periode1' AND tanggal<='$periode2' ORDER BY $OrderBy $ShortBy");
                            }
                           
                            while ($data = mysqli_fetch_array($query)) {
                                $id_transaksi = $data['id_transaksi'];
                                $kode_transaksi = $data['kode_transaksi'];
                                $tanggal = $data['tanggal'];
                                $jenis_transaksi= $data['jenis_transaksi'];
                                $selisih= $data['selisih'];
                                $keterangan= $data['keterangan'];
                                if(!empty($data['pembayaran'])){
                                    $pembayaran= $data['pembayaran'];
                                }else{
                                    $pembayaran="0";
                                }
                                if(!empty($data['total_tagihan'])){
                                    $total_tagihan= $data['total_tagihan'];
                                }else{
                                    $total_tagihan="0";
                                }
                                if($jenis_transaksi=="penjualan"){
                                    //Buka Data Log point
                                    $Qrypemberian_point = mysqli_query($conn, "SELECT * FROM pemberian_point WHERE kode_transaksi='$kode_transaksi'")or die(mysqli_error($conn));
                                    $DataPemberianPoint = mysqli_fetch_array($Qrypemberian_point);
                                    $id_member=$DataPemberianPoint['id_member'];
                                    //Buka Data member
                                    $QryMember = mysqli_query($conn, "SELECT * FROM member WHERE id_member='$id_member'")or die(mysqli_error($conn));
                                    $DataMember = mysqli_fetch_array($QryMember);
                                    $nama=$DataMember['nama'];
                                }else{
                                    //Buka Data Transaksi Supplier
                                    $QryTransSupp = mysqli_query($conn, "SELECT * FROM transaksi_supplier WHERE kode_transaksi='$kode_transaksi'")or die(mysqli_error($conn));
                                    $DataTransSupp = mysqli_fetch_array($QryTransSupp);
                                    $id_member=$DataTransSupp['id_member'];
                                    //Buka Data member
                                    $QryMember = mysqli_query($conn, "SELECT * FROM member WHERE id_member='$id_member'")or die(mysqli_error($conn));
                                    $DataMember = mysqli_fetch_array($QryMember);
                                    $nama=$DataMember['nama'];
                                }
                                if(empty($DataMember['nama'])){
                                    $nama="None";
                                }
                                
                        ?>
                        <tr class="<?php if($keterangan=="Piutang"){echo "bg-inverse-success";}else{echo "bg-inverse-danger";} ?>">
                            <td><?php echo "$no";?></td>
                            <td><?php echo "$tanggal";?></td>
                            <td><?php echo "$kode_transaksi";?></td>
                            <td><?php echo "$nama";?></td>
                            <td align="right">
                                <?php 
                                   echo "Rp " . number_format($total_tagihan,0,',','.');
                                ?>
                            </td>
                            <td align="right">
                                <?php 
                                    echo "Rp " . number_format($pembayaran,0,',','.');
                                ?>
                            </td>
                            <td><?php echo "$keterangan";?></td>
                        </tr>
                        <?php $no++;} ?>
                    </tbody>
                    <tfoot class="bg-dark">
                        <tr>
                            <th colspan="4" class="text-white">JUMLAH UTANG</th>
                            <th class="text-white">
                                <?php 
                                    echo "Rp " . number_format($JumlahUtang,0,',','.');
                                ?>
                            </th>
                            <th class="text-white">
                                <?php 
                                    echo "Rp " . number_format($JumlahUtangpembayaran,0,',','.');
                                ?>
                            </th>
                            <th></th>
                        </tr>
                        <tr>
                            <th colspan="4" class="text-white">JUMLAH PIUTANG</th>
                            <th class="text-white">
                                <?php 
                                    echo "Rp " . number_format($JumlahPiutang,0,',','.');
                                ?>
                            </th>
                            <th class="text-white">
                                <?php 
                                    echo "Rp " . number_format($JumlahPiutangPembayaran,0,',','.');
                                ?>
                            </th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
