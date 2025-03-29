<?php
    //koneksi dan error
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SessionLogin.php";
    //NewOrEdit
    if(!empty($_POST['NewOrEdit'])){
        $NewOrEdit=$_POST['NewOrEdit'];
    }else{
        $NewOrEdit="New";
    }
    //standar_harga
    if(!empty($_POST['standar_harga'])){
        $standar_harga=$_POST['standar_harga'];
    }else{
        $standar_harga="harga_1";
    }
    //jenis_transaksi
    if(!empty($_POST['trans'])){
        $trans=$_POST['trans'];
    }else{
        $trans="trans";
    }
    //kode_transaksi
    if(!empty($_POST['kode_transaksi'])){
        $kode_transaksi=$_POST['kode_transaksi'];
    }else{
        $kode_transaksi="";
    }
    //ppn
    if(!empty($_POST['ppn'])){
        $ppn=$_POST['ppn'];
    }else{
        $ppn="0";
    }
    //diskon
    if(!empty($_POST['diskon'])){
        $diskon=$_POST['diskon'];
    }else{
        $diskon="0";
    }
    //Apabila data baru maka input pada data transaksi
    if($NewOrEdit=="New"){
        //Update Setting
        $EditSetting = mysqli_query($conn, "UPDATE transaksi_setting SET 
            ppn='$ppn', 
            diskon='$diskon', 
            standar_harga='$standar_harga'
        WHERE trans='$trans'") or die(mysqli_error($conn));
        if($EditSetting){
            echo '<i class="text-primary" id="NotifikasiPengaturanKasirBerhasil">Berhasil</i>';
        }else{
            echo '<i class="text-danger" id="NotifikasiPengaturanKasirBerhasil">Edit Pengaturan Kasir Baru Gagal!</i>';
        }
    }else{
        //Apabila Edit Transaksi maka buka data transaksi berdasarkan kode transaksi
        $QryTransaksi = mysqli_query($conn, "SELECT * FROM transaksi WHERE kode_transaksi='$kode_transaksi'")or die(mysqli_error($conn));
        $DataTransaksi = mysqli_fetch_array($QryTransaksi);
        $subtotal = $DataTransaksi['subtotal'];
        if(!empty($DataTransaksi['pembayaran'])){
            $pembayaran = $DataTransaksi['pembayaran'];
        }else{
            $pembayaran = "0";
        }
        //Menghitung Nilai RP
        $RpPPN=($ppn*$subtotal)/100;
        $RpDiskon=($diskon*$subtotal)/100;
        //Menghitung Total Tagihan
        $total=($subtotal+$RpPPN)-$RpDiskon;
        //Menghitung Selisih
        $selisih=$total-$pembayaran;
        if($trans=="penjualan"){
            if($selisih=="0"){
                $keterangan="Lunas";
                $selisih="0";
            }else{
                if($selisih<0){
                    $keterangan="Utang";
                    $selisih=$selisih*-1;
                }
                if($selisih>0){
                    $keterangan="Piutang";
                }
            }
        }
        if($trans=="pembelian"){
            if($selisih=="0"){
                $keterangan="Lunas";
                $selisih="0";
            }else{
                if($selisih<0){
                    $keterangan="Piutang";
                    $selisih=$selisih*-1;
                }
                if($selisih>0){
                    $keterangan="Utang";
                }
            }
        }
        //Edit Data Transaksi
        $EditTransaksi = mysqli_query($conn, "UPDATE transaksi SET 
            ppn='$RpPPN', 
            diskon='$RpDiskon',
            total_tagihan='$total',
            selisih='$selisih',
            keterangan='$keterangan'
        WHERE kode_transaksi='$kode_transaksi'") or die(mysqli_error($conn));
        if($EditTransaksi){
            echo '<i class="text-primary" id="NotifikasiPengaturanKasirBerhasil">Berhasil</i>';
        }else{
            echo '<i class="text-danger" id="NotifikasiPengaturanKasirBerhasil">Edit Pengaturan Kasir Lama Gagal!</i>';
        }
    }
?>