<?php 
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=LaporanJualBeli.xls");
    //koneksi dan error
    include "../../_Config/Connection.php";
    //KategoriLaporan
    if(!empty($_GET['kategori'])){
        $KategoriLaporan=$_GET['kategori'];
    }else{
        $KategoriLaporan="Harian";
    }
    //OrderBy
    if(!empty($_GET['OrderBy'])){
        $OrderBy=$_GET['OrderBy'];
    }else{
        $OrderBy="id_transaksi";
    }
    //ShortBy
    if(!empty($_GET['ShortBy'])){
        $ShortBy=$_GET['ShortBy'];
    }else{
        $ShortBy="ASC";
    }
    //tanggal
    if(!empty($_GET['tanggal'])){
        $tanggal=$_GET['tanggal'];
    }else{
        $tanggal="";
    }
    //tahun
    if(!empty($_GET['tahun'])){
        $tahun=$_GET['tahun'];
    }else{
        $tahun="";
    }
    //bulan
    if(!empty($_GET['bulan'])){
        $bulan=$_GET['bulan'];
    }else{
        $bulan="";
    }
    //periode1
    if(!empty($_GET['periode1'])){
        $periode1=$_GET['periode1'];
    }else{
        $periode1="";
    }
    //periode2
    if(!empty($_GET['periode2'])){
        $periode2=$_GET['periode2'];
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
    //Buka Setting percetakan
    $QrySetting = mysqli_query($conn, "SELECT * FROM setting_cetak WHERE kategori_setting='percetakan_laporan'")or die(mysqli_error($conn));
    $DataSetting = mysqli_fetch_array($QrySetting);
    $kategori_setting = $DataSetting['kategori_setting'];
	$margin_atas = $DataSetting['margin_atas'];
	$margin_bawah = $DataSetting['margin_bawah'];
	$margin_kiri = $DataSetting['margin_kiri'];
	$margin_kanan = $DataSetting['margin_kanan'];
	$panjang_x = $DataSetting['panjang_x'];
	$lebar_y = $DataSetting['lebar_y'];
	$jenis_font = $DataSetting['jenis_font'];
	$ukuran_font = $DataSetting['ukuran_font'];
    $warna_font = $DataSetting['warna_font'];
    //Buka data Setting Aplikasi
    $Qry = mysqli_query($conn, "SELECT * FROM setting_aplikasi")or die(mysqli_error($conn));
    $DataSetting = mysqli_fetch_array($Qry);
    //Nama Perusahaan
    if(!empty($DataSetting['nama_perusahaan'])){
        $nama_perusahaan = $DataSetting['nama_perusahaan'];
    }else{
        $nama_perusahaan = "Business Today";
    }
    //Alamat
    if(!empty($DataSetting['alamat'])){
        $alamat = $DataSetting['alamat'];
    }else{
        $alamat ="";
    }
    //kontak
    if(!empty($DataSetting['kontak'])){
        $kontak = $DataSetting['kontak'];
    }else{
        $kontak ="";
    }
    //logo
    if(!empty($DataSetting['logo'])){
        $logo = $DataSetting['logo'];
    }else{
        $logo ="";
    }
    //logo
    if(!empty($DataSetting['aktif_promo'])){
        $aktif_promo = $DataSetting['aktif_promo'];
    }else{
        $aktif_promo ="Tidak";
    }
    //jumlah_point
    if(!empty($DataSetting['jumlah_point'])){
        $jumlah_point = $DataSetting['jumlah_point'];
    }else{
        $jumlah_point ="0";
    }
    //kelipatan_belanja
    if(!empty($DataSetting['kelipatan_belanja'])){
        $kelipatan_belanja = $DataSetting['kelipatan_belanja'];
    }else{
        $kelipatan_belanja ="0";
    }
?> 
<html>
    <head>
            <style type="text/css">
                table tr td {
                    border: 0.5px solid #666;
                    font-size:11px;
                    color:#333;
                    border-spacing: 0px;
                    padding: 4px;
                }
            </style>
    </head>
    <body>
        <table>
            <tr>
                <td align="center" colspan="7">
                    <h2><?php echo "$nama_perusahaan";?></h2>
                    <?php echo "$alamat $kontak";?>
                </td>
            </tr>
            <tr>
                <td><b>No</b></td>
                <td><b>Tanggal</b></td>
                <td><b>Kode</b></td>
                <td><b>Member/Supplier</b></td>
                <td><b>Jumlah</b></td>
                <td><b>Pembayaran</b></td>
                <td><b>Keterangan</b></td>
            </tr>
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
                        echo "$total_tagihan";
                    ?>
                </td>
                <td align="right">
                    <?php 
                        echo "$pembayaran";
                    ?>
                </td>
                <td><?php echo "$keterangan";?></td>
            </tr>
            <?php $no++;} ?>
            <tr>
                <td colspan="4" class="text-white" align="right">JUMLAH UTANG</td>
                <td class="text-white" align="right">
                    <?php 
                        echo "$JumlahUtangpembayaran";
                    ?>
                </td>
                <td class="text-white" align="right">
                    <?php 
                        echo "$JumlahUtangpembayaran";
                    ?>
                </td>
                <td></td>
            </tr>
            <tr>
                <td colspan="4" class="text-white" align="right">JUMLAH PIUTANG</td>
                <td class="text-white" align="right">
                    <?php 
                        echo "$JumlahPiutang";
                    ?>
                </td>
                <td class="text-white" align="right">
                    <?php 
                        echo "$JumlahPiutangPembayaran";
                    ?>
                </td>
                <td></td>
            </tr>
        </table>
    </body>
</html>