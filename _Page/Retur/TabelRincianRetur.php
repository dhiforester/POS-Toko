<?php
    ini_set("display_errors","off");
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SessionLogin.php";
    if(!empty($_POST['id_transaksi'])){
        //Id Transaksi
        $id_transaksi=$_POST['id_transaksi'];
        //Buka Transaksi
        $QryTransaksi = mysqli_query($conn, "SELECT * FROM transaksi WHERE id_transaksi='$id_transaksi'")or die(mysqli_error($conn));
        $DataTransaksi = mysqli_fetch_array($QryTransaksi);
        $subtotalTransaksi = $DataTransaksi['subtotal'];
        $RpPpnTransaksi = $DataTransaksi['ppn'];
        $RpDiskonTransaksi = $DataTransaksi['diskon'];
        $ppn=($RpPpnTransaksi/$subtotalTransaksi)*100;
        $diskon=($RpDiskonTransaksi/$subtotalTransaksi)*100;
    }else{
        $id_transaksi="";
    }
    //Buka data retur
    $QryTransaksiRetur = mysqli_query($conn, "SELECT * FROM retur WHERE id_transaksi='$id_transaksi' AND id_retur='0'")or die(mysqli_error($conn));
    $DataTransaksiRetur = mysqli_fetch_array($QryTransaksiRetur);
    //subtotal
    if(empty($DataTransaksiRetur['subtotal'])){
        //Hitung subtotal
        $QrySubtotal = mysqli_query($conn, "SELECT SUM(jumlah) as jumlah from retur_rincian WHERE id_transaksi='$id_transaksi' AND id_retur='0'");
        $DataSubtotal = mysqli_fetch_array($QrySubtotal);
        $subtotal=$DataSubtotal['jumlah'];
    }else{
        $subtotal = $DataTransaksiRetur['subtotal'];
    }
    //RpPpnRetur
    if(empty($DataTransaksiRetur['ppn'])){
        if(!empty($subtotal)){
            $RpPpnRetur = ($subtotal*$ppn/100);
        }else{
            $RpPpnRetur ="0";
        }
    }else{
        $RpPpnRetur = $DataTransaksiRetur['ppn'];
    }
    //RpDiskonRetur
    if(empty($DataTransaksiRetur['diskon'])){
        if(!empty($subtotal)){
            $RpDiskonRetur = ($subtotal*$diskon/100);
        }else{
            $RpDiskonRetur ="0";
        }
        
    }else{
        $RpDiskonRetur = $DataTransaksiRetur['diskon'];
    }
    //total_tagihan
    if(empty($DataTransaksiRetur['tagihan'])){
        $total_tagihan = $subtotal+$RpPpnRetur-$RpDiskonRetur;
    }else{
        $total_tagihan = $DataTransaksiRetur['tagihan'];
    }
    //pembayaran
    if(empty($DataTransaksiRetur['pembayaran'])){
        $pembayaran ="0";
    }else{
        $pembayaran = $DataTransaksiRetur['pembayaran'];
    }
    //selisih
    if(empty($DataTransaksiRetur['selisih'])){
        $selisih =$total_tagihan-$pembayaran;
    }else{
        $selisih = $DataTransaksiRetur['selisih'];
    }
    $keterangan = $DataTransaksiRetur['keterangan'];
?>
<div class="table-responsive" style="height: 250px; overflow-y: scroll;">
    <table class="table table-sm table-bordered table-hover scroll-container">
        <thead class="thead-dark">
            <tr>
                <th>No</th>
                <th>Nama/Merek</th>
                <th>QTY</th>
                <th>Harga</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $no = 1;
                $query = mysqli_query($conn, "SELECT*FROM retur_rincian WHERE id_transaksi='$id_transaksi' AND id_retur='0' ORDER BY id_rincian_retur DESC");
                while ($data = mysqli_fetch_array($query)) {
                    $id_rincian_retur = $data['id_rincian_retur'];
                    $id_barang = $data['id_barang'];
                    $kode_barang = $data['kode_barang'];
                    $nama_barang = $data['nama_barang'];
                    $qty= $data['qty'];
                    $harga = $data['harga'];
                    $satuan = $data['satuan'];
                    $jumlah= $data['jumlah'];
                    $id_multi= $data['id_multi'];
                    $standar_harga= $data['standar_harga'];
            ?>
            <tr onmousemove="this.style.cursor='pointer'" data-toggle="modal" data-target="#" <?php echo "data-id='".$id_rincian_retur."'"; ?>>
                <td><?php echo "$no";?></td>
                <td><?php echo "$nama_barang";?></td>
                <td><?php echo "$qty $satuan";?></td>
                <td align="right"><?php echo "Rp " . number_format($harga,0,',','.');?></td>
                <td align="right"><?php echo "Rp " . number_format($jumlah,0,',','.');?></td>
            </tr>
            <?php 
                $no++;} 
            ?>
            <tr>
                <td colspan="4" align="right">SUBTOTAL</td>
                <td align="right"><?php echo "Rp " . number_format($subtotal,0,',','.');?></td>
            </tr>
            <?php if(!empty($RpPpnRetur)){ ?>
                <tr>
                    <td colspan="4" align="right">PPN <?php echo "($ppn %)";?></td>
                    <td align="right"><?php echo "Rp " . number_format($RpPpnRetur,0,',','.');?></td>
                </tr>
            <?php }if(!empty($RpDiskonRetur)){ ?>
                <tr>
                    <td colspan="4" align="right">DISKON <?php echo "($diskon %)";?></td>
                    <td align="right"><?php echo "Rp " . number_format($RpDiskonRetur,0,',','.');?></td>
                </tr>
            <?php } ?>
            <tr>
                <td colspan="4" align="right">TOTAL</td>
                <td align="right"><?php echo "Rp " . number_format($total_tagihan,0,',','.');?></td>
            </tr>
        </tbody>
    </table>
</div>