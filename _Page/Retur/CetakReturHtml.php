<?php
    //koneksi dan error
    ini_set("display_errors","off");
    include "../../_Config/Connection.php";
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
    if(empty($_GET['kode'])){
        echo '<div class="modal-body bg-white">';
        echo '  <div class="row">';
        echo '      <div class="col col-md-12">';
        echo '          <h4 class="text-danger">Tidak ada kode retur</h4>';
        echo '          <small class="text-danger">Pastikan Data yang diinput sudah benar</small>';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        $kode=$_GET['kode'];
        //Buka Retur
        $QryRetur = mysqli_query($conn, "SELECT * FROM retur WHERE kode='$kode'")or die(mysqli_error($conn));
        $DataRetur = mysqli_fetch_array($QryRetur);
        $id_retur=$DataRetur['id_retur'];
        $id_transaksi=$DataRetur['id_transaksi'];
        $tanggal=$DataRetur['tanggal'];
        $subtotal=$DataRetur['subtotal'];
        $ppn=$DataRetur['ppn'];
        $diskon=$DataRetur['diskon'];
        $tagihan=$DataRetur['tagihan'];
        $pembayaran=$DataRetur['pembayaran'];
        $selisih=$DataRetur['selisih'];
        $keterangan=$DataRetur['keterangan'];
        //Buka transaksi
        $QryTransaksi = mysqli_query($conn, "SELECT * FROM transaksi WHERE id_transaksi='$id_transaksi'")or die(mysqli_error($conn));
        $DataTransaksi = mysqli_fetch_array($QryTransaksi);
        $kode_transaksi=$DataTransaksi['kode_transaksi'];
        $trans=$DataTransaksi['jenis_transaksi'];
        if(!empty($DataTransaksi['petugas'])){
            $petugas = $DataTransaksi['petugas'];
        }else{
            $petugas ="";
        }
        
        if($trans=="penjualan"){
            //Buka data pemberian point
            $QryPemberianPoint = mysqli_query($conn, "SELECT * FROM pemberian_point WHERE kode_transaksi='$kode_transaksi'")or die(mysqli_error($conn));
            $DataPemberianPoint = mysqli_fetch_array($QryPemberianPoint);
            $IdMember=$DataPemberianPoint['id_member'];
            $point=$DataPemberianPoint['point'];
            //Buka nama member
            $QryMember = mysqli_query($conn, "SELECT * FROM member WHERE id_member='$IdMember'")or die(mysqli_error($conn));
            $DataMember = mysqli_fetch_array($QryMember);
            $NamaMember=$DataMember['nama'];
            if(empty($DataMember['id_member'])){
                $NamaMember="Tidak Ada";
            }else{
                $NamaMember=$DataMember['nama'];
            }
        }
        if($trans=="pembelian"){
            //Buka data transaksi supplier
            $QryTransaksiSupplier = mysqli_query($conn, "SELECT * FROM transaksi_supplier WHERE kode_transaksi='$kode_transaksi'")or die(mysqli_error($conn));
            $DataTransaksiSupplier = mysqli_fetch_array($QryTransaksiSupplier);
            $IdMember=$DataTransaksiSupplier['tanggal'];
            //Buka nama member
            $QryMember = mysqli_query($conn, "SELECT * FROM member WHERE id_member='$IdMember'")or die(mysqli_error($conn));
            $DataMember = mysqli_fetch_array($QryMember);
            $NamaMember=$DataMember['id_member'];
            if(empty($DataMember['nama'])){
                $NamaMember="Tidak Ada";
            }else{
                $NamaMember=$DataMember['nama'];
            }
        }
        //Buka Setting percetakan
        $QrySetting = mysqli_query($conn, "SELECT * FROM setting_cetak WHERE kategori_setting='percetakan_nota'")or die(mysqli_error($conn));
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
?>
<html>
    <head>
        <title>Cetak Nota <?php echo "$kode_transaksi"; ?></title>
        <style type="text/css">
            body{
                font-size: <?php echo "$ukuran_font";?>px;
                font-family: <?php echo "$jenis_font";?>;
                color: <?php echo "$warna_font";?>;
            }
            table tr td{
                border: none;
                padding: 0px;
                font-size: <?php echo "$ukuran_font";?>px;
                font-family: <?php echo "$jenis_font";?>;
                color: <?php echo "$warna_font";?>;
            }
            table.rincian tr td{
                border-bottom: 1px dotted #999;
                padding: 0px;
                font-size: <?php echo "$ukuran_font";?>px;
                font-family: <?php echo "$jenis_font";?>;
                color: <?php echo "$warna_font";?>;
            }
            td.title{
                padding: 0px;
                font-size: 20px;
                font-family: <?php echo "$jenis_font";?>;
                color: <?php echo "$warna_font";?>;
            }
        </style>
    </head>
    <body>
        <table>
            <tr>
                <td colspan="3" class="title">
                    <?php 
                        if(!empty($nama_perusahaan)){
                            echo "<b>$nama_perusahaan</b>";
                        }
                    ?>
                </td>
            </tr>
            <tr>
                <td colspan="3" class="">
                    <?php 
                        if(!empty($alamat)){
                            echo "$alamat";
                        }
                    ?>
                </td>
            </tr>
            <tr>
                <td><b>Kode Transaksi</b></td>
                <td><b>:</b></td>
                <td><?php echo "$kode";?></td>
            </tr>
            <tr>
                <td><b>Tanggal</b></td>
                <td><b>:</b></td>
                <td><?php echo "$tanggal";?></td>
            </tr>
            <?php
                if($trans=="penjualan"){
                    //Buka data pemberian point
                    $QryPemberianPoint = mysqli_query($conn, "SELECT * FROM pemberian_point WHERE kode_transaksi='$kode_transaksi'")or die(mysqli_error($conn));
                    $DataPemberianPoint = mysqli_fetch_array($QryPemberianPoint);
                    $IdMember=$DataPemberianPoint['id_member'];
                    $point=$DataPemberianPoint['point'];
                    //Buka nama member
                    $QryMember = mysqli_query($conn, "SELECT * FROM member WHERE id_member='$IdMember'")or die(mysqli_error($conn));
                    $DataMember = mysqli_fetch_array($QryMember);
                    $NamaMember=$DataMember['nama'];
                    if(!empty($DataMember['id_member'])){
                        $NamaMember=$DataMember['nama'];
                        echo '<tr>';
                        echo '  <td><b>Member</b></td>';
                        echo '  <td><b>:</b></td>';
                        echo '  <td>'.$NamaMember.'</td>';
                        echo '</tr>';
                        echo '<tr>';
                    }
                }
                if($trans=="pembelian"){
                   //Buka data transaksi supplier
                    $QryTransaksiSupplier = mysqli_query($conn, "SELECT * FROM transaksi_supplier WHERE kode_transaksi='$kode_transaksi'")or die(mysqli_error($conn));
                    $DataTransaksiSupplier = mysqli_fetch_array($QryTransaksiSupplier);
                    $IdMember=$DataTransaksiSupplier['tanggal'];
                    //Buka nama member
                    $QryMember = mysqli_query($conn, "SELECT * FROM member WHERE id_member='$IdMember'")or die(mysqli_error($conn));
                    $DataMember = mysqli_fetch_array($QryMember);
                    $NamaMember=$DataMember['id_member'];
                    if(!empty($DataMember['id_member'])){
                        $NamaMember=$DataMember['nama'];
                        echo '<tr>';
                        echo '  <td><b>Member</b></td>';
                        echo '  <td><b>:</b></td>';
                        echo '  <td>'.$NamaMember.'</td>';
                        echo '</tr>';
                    }
                }
            ?>
            <tr>
                <td><b>Petugas Kasir</b></td>
                <td><b>:</b></td>
                <td><?php echo "$petugas";?></td>
            </tr>
        </table>
        <table class="rincian" cellspacing="0">
            <tr>
                <td>Barang</td>
                <td>Qty</td>
                <td>Harga</td>
                <td>Jumlah</td>
            </tr>
            <?php
                $no = 1;
                //KONDISI PENGATURAN MASING FILTER
                $query = mysqli_query($conn, "SELECT*FROM retur_rincian WHERE id_retur='$id_retur' ORDER BY id_rincian_retur DESC");
                while ($data = mysqli_fetch_array($query)) {
                    $id_rincian_retur = $data['id_rincian_retur'];
                    $nama_barang = $data['nama_barang'];
                    $harga = $data['harga'];
                    $qty = $data['qty'];
                    $satuan = $data['satuan'];
                    $jumlah = $data['jumlah'];
            ?>
            <tr>
                <td><?php echo "$nama_barang";?></td>
                <td><?php echo "$qty";?></td>
                <td><?php echo "" . number_format($harga,0,',','.');?></>
                <td><?php echo "" . number_format($jumlah,0,',','.');?></td>
            </tr>
            <?php 
                $no++;} 
            ?>
            <tr>
                <td colspan="2" align="right">SUBTOTAL</td>
                <td colspan="2" align="right"><?php echo "" . number_format($subtotal,0,',','.');?></td>
            </tr>
            <?php if(!empty($RpPpn)){ ?>
                <tr>
                    <td colspan="2" align="right">PPN <?php echo "($ppn %)";?></td>
                    <td colspan="2" align="right"><?php echo "" . number_format($RpPpn,0,',','.');?></td>
                </tr>
            <?php }if(!empty($RpDiskon)){ ?>
                <tr>
                    <td colspan="2" align="right">DISKON <?php echo "($diskon %)";?></td>
                    <td colspan="2" align="right"><?php echo "" . number_format($RpDiskon,0,',','.');?></td>
                </tr>
            <?php } ?>
            <tr>
                <td colspan="2" align="right">TOTAL</td>
                <td colspan="2" align="right"><?php echo "" . number_format($total_tagihan,0,',','.');?></td>
            </tr>
            <tr>
                <td colspan="2" align="right">PEMBAYARAN</td>
                <td colspan="2" align="right"><?php echo "" . number_format($pembayaran,0,',','.');?></td>
            </tr>
            <?php if(!empty($selisih)){ ?>
                <tr>
                    <td colspan="2" align="right">SELISIH</td>
                    <td colspan="2" align="right"><?php echo "" . number_format($selisih,0,',','.');?></td>
                </tr>
            <?php } ?>
            <tr>
                <td colspan="2" align="right">KETERANGAN</td>
                <td colspan="2" align="right"><?php echo "$keterangan";?></td>
            </tr>
        </table>
        <br>
        TERIMA KASIH ATAS KUNJUNGAN ANDA
    </body>
</html>
            <?php } ?>