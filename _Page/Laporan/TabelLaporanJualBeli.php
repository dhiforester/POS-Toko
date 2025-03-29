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
    //Menghitung jumlah Penjualan
    if($KategoriLaporan=="Harian"){
        $QryJumlahTotalPenjualan = mysqli_query($conn, "SELECT SUM(total_tagihan) as total_tagihan FROM transaksi WHERE jenis_transaksi='penjualan' AND tanggal like '%$tanggal%'");
    }
    if($KategoriLaporan=="Bulanan"){
        $QryJumlahTotalPenjualan = mysqli_query($conn, "SELECT SUM(total_tagihan) as total_tagihan FROM transaksi WHERE jenis_transaksi='penjualan' AND tanggal like '%$bulanan%'");
    }
    if($KategoriLaporan=="Tahunan"){
        $QryJumlahTotalPenjualan = mysqli_query($conn, "SELECT SUM(total_tagihan) as total_tagihan FROM transaksi WHERE jenis_transaksi='penjualan' AND tanggal like '%$tahun%'");
    }
    if($KategoriLaporan=="Periode"){
        $QryJumlahTotalPenjualan = mysqli_query($conn, "SELECT SUM(total_tagihan) as total_tagihan FROM transaksi WHERE jenis_transaksi='penjualan' AND tanggal>='$periode1' AND tanggal<='$periode2'");
    }
    $DataJumlahTotalPenjualan = mysqli_fetch_array($QryJumlahTotalPenjualan);
    $JumlahPenjualan=$DataJumlahTotalPenjualan['total_tagihan'];
    
    //Menghitung jumlah pembelian
    if($KategoriLaporan=="Harian"){
        $QryJumlahTotalPembelian = mysqli_query($conn, "SELECT SUM(total_tagihan) as total_tagihan FROM transaksi WHERE jenis_transaksi='pembelian' AND tanggal like '%$tanggal%'");
    }
    if($KategoriLaporan=="Bulanan"){
        $QryJumlahTotalPembelian = mysqli_query($conn, "SELECT SUM(total_tagihan) as total_tagihan FROM transaksi WHERE jenis_transaksi='pembelian' AND tanggal like '%$bulanan%'");
    }
    if($KategoriLaporan=="Tahunan"){
        $QryJumlahTotalPembelian = mysqli_query($conn, "SELECT SUM(total_tagihan) as total_tagihan FROM transaksi WHERE jenis_transaksi='pembelian' AND tanggal like '%$tahun%'");
    }
    if($KategoriLaporan=="Periode"){
        $QryJumlahTotalPembelian = mysqli_query($conn, "SELECT SUM(total_tagihan) as total_tagihan FROM transaksi WHERE jenis_transaksi='pembelian' AND tanggal>='$periode1' AND tanggal<='$periode2'");
    }
    $DataJumlahTotalPembelian = mysqli_fetch_array($QryJumlahTotalPembelian);
    $JumlahPembelian=$DataJumlahTotalPembelian['total_tagihan'];
    //Menghitung jumlah Total
    $Selisih=$JumlahPenjualan-$JumlahPembelian;
?>
    <div class="row">
        <div class="form-group col-sm-12 text-center">
            <h3>LAPORAN JUAL BELI</h3>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-sm-12 text-center">
            <a href="<?php echo '_Page/Laporan/CetakJualBeliHtml.php?kategori='.$KategoriLaporan.'&OrderBy='.$OrderBy.'&ShortBy='.$ShortBy.'&tahun='.$tahun.'&bulan='.$bulan.'&periode1='.$periode1.'&periode2='.$periode2.'&tanggal='.$tanggal.'';?>" class="btn btn-rounded btn-outline-dark" target="_blank">
                <i class="mdi mdi-web"></i> Html
            </a>
            <a href="<?php echo '_Page/Laporan/CetakJualBeliExcel.php?kategori='.$KategoriLaporan.'&OrderBy='.$OrderBy.'&ShortBy='.$ShortBy.'&tahun='.$tahun.'&bulan='.$bulan.'&periode1='.$periode1.'&periode2='.$periode2.'&tanggal='.$tanggal.'';?>" class="btn btn-rounded btn-outline-dark" target="_blank">
                <i class="mdi mdi-file-excel"></i> Excel
            </a>
            <a href="<?php echo '_Page/Laporan/CetakJualBeliPdf.php?kategori='.$KategoriLaporan.'&OrderBy='.$OrderBy.'&ShortBy='.$ShortBy.'&tahun='.$tahun.'&bulan='.$bulan.'&periode1='.$periode1.'&periode2='.$periode2.'&tanggal='.$tanggal.'';?>" class="btn btn-rounded btn-outline-dark" target="_blank">
                <i class="mdi mdi-file-pdf"></i> PDF
            </a>
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
                            <th><b>Penjualan</b></th>
                            <th><b>Pembelian</b></th>
                            <th><b>Pembayaran</b></th>
                            <th><b>Keterangan</b></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $no = 1;
                            //KONDISI PENGATURAN MASING FILTER
                            if($KategoriLaporan=="Harian"){
                                $query = mysqli_query($conn, "SELECT*FROM transaksi WHERE tanggal like '%$tanggal%' ORDER BY $OrderBy $ShortBy");
                            }
                            if($KategoriLaporan=="Bulanan"){
                                $query = mysqli_query($conn, "SELECT*FROM transaksi WHERE tanggal like '%$bulanan%' ORDER BY $OrderBy $ShortBy");
                            }
                            if($KategoriLaporan=="Tahunan"){
                                $query = mysqli_query($conn, "SELECT*FROM transaksi WHERE tanggal like '%$tahun%' ORDER BY $OrderBy $ShortBy");
                            }
                            if($KategoriLaporan=="Periode"){
                                $query = mysqli_query($conn, "SELECT*FROM transaksi WHERE tanggal>='$periode1' AND tanggal<='$periode2' ORDER BY $OrderBy $ShortBy");
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
                        ?>
                        <tr class="<?php if($jenis_transaksi=="penjualan"){echo "bg-inverse-success";}else{echo "bg-inverse-danger";} ?>">
                            <td><?php echo "$no";?></td>
                            <td><?php echo "$tanggal";?></td>
                            <td><?php echo "$kode_transaksi";?></td>
                            <td align="right">
                                <?php 
                                    if($jenis_transaksi=="penjualan"){
                                        echo "Rp " . number_format($total_tagihan,0,',','.');
                                    }else{
                                        echo "-";
                                    }
                                ?>
                            </td>
                            <td align="right">
                                <?php 
                                    if($jenis_transaksi=="pembelian"){
                                        echo "Rp " . number_format($total_tagihan,0,',','.');
                                    }else{
                                        echo "-";
                                    }
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
                        <tr class="text-white">
                            <td colspan="3" align="right"><b>JUMLAH PEMBELIAN - PENJUALAN</b></td>
                            <td align="right"> <?php echo "Rp " . number_format($JumlahPenjualan,0,',','.'); ?> </td>
                            <td align="right"><?php echo "Rp " . number_format($JumlahPembelian,0,',','.'); ?></td>
                            <td align="right">
                                <?php 
                                    if($Selisih=="0"){
                                        echo "Rp " . number_format($Selisih,0,',','.');
                                    }else{
                                        if($Selisih>"0"){
                                            echo "<b class='text-success'>";
                                            echo "Rp " . number_format($Selisih,0,',','.');
                                            echo "</b>";
                                        }else{
                                            echo "<b class='text-danger'>";
                                            echo "Rp " . number_format($Selisih,0,',','.');
                                            echo "</b>";
                                        }
                                    }
                                     
                                ?>
                            </td>
                            <td align="center">
                                <?php 
                                    if($Selisih=="0"){
                                        echo "None";
                                    }else{
                                        if($Selisih>"0"){
                                            echo "<b class='text-success'>Profit/Laba</b>";
                                        }else{
                                            echo "<b class='text-danger'>Rugi</b>";
                                        }
                                    }
                                ?>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
