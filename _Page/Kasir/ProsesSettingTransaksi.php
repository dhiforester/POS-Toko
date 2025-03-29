<?php
    //KONEKSI DAN ERROR
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SessionLogin.php";
    //TANGKAP DATA
    //NewOrEdit
    if(!empty($_POST['NewOrEdit'])){
        $NewOrEdit=$_POST['NewOrEdit'];
    }else{
        $NewOrEdit="New";
    }
    //jenis_transaksi
    if(!empty($_POST['jenis_transaksi'])){
        $jenis_transaksi=$_POST['jenis_transaksi'];
    }else{
        $jenis_transaksi="penjualan";
    }
    //kode_transaksi
    if(!empty($_POST['kode_transaksi'])){
        $kode_transaksi=$_POST['kode_transaksi'];
    }else{
        $kode_transaksi="";
    }
    //tanggal
    if(!empty($_POST['tanggal'])){
        $tanggal=$_POST['tanggal'];
    }else{
        $tanggal=date('Y-m-d H:i:s');
    }
    //subtotal
    if(!empty($_POST['subtotal'])){
        $subtotal=$_POST['subtotal'];
    }else{
        $subtotal="";
    }
    //ppn
    if(!empty($_POST['ppn'])){
        $ppn=$_POST['ppn'];
    }else{
        $ppn="0";
    }
    //RpPPN
    if(!empty($_POST['RpPPN'])){
        $RpPPN=$_POST['RpPPN'];
    }else{
        $RpPPN="0";
    }
    //diskon
    if(!empty($_POST['diskon'])){
        $diskon=$_POST['diskon'];
    }else{
        $diskon="0";
    }
    //RpDiskon
    if(!empty($_POST['RpDiskon'])){
        $RpDiskon=$_POST['RpDiskon'];
    }else{
        $RpDiskon="0";
    }
    //total
    if(!empty($_POST['total'])){
        $total=$_POST['total'];
    }else{
        $total="0";
    }
    //pembayaran
    if(!empty($_POST['pembayaran'])){
        $pembayaran=$_POST['pembayaran'];
    }else{
        $pembayaran="0";
    }
    //selisih
    $selisih=$total-$pembayaran;
    if($selisih<0){
        $selisih=$selisih*-1;
    }else{
        $selisih=$selisih;
    }
    //keterangan
    if($jenis_transaksi=="penjualan"){
        if($total==$pembayaran){
            $keterangan="Lunas";
        }else{
            if($total>$pembayaran){
                $keterangan="Piutang";
            }else{
                $keterangan="Utang";
            }
        }
    }else{
        if($total==$pembayaran){
            $keterangan="Lunas";
        }else{
            if($total>$pembayaran){
                $keterangan="Utang";
            }else{
                $keterangan="Piutang";
            }
        }
    }
    //Id Member
    if(!empty($_POST['id_member'])){
        $id_member=$_POST['id_member'];
    }else{
        $id_member="";
    }
    //PointMember
    if(!empty($_POST['TambahPointMember'])){
        $TambahPointMember=$_POST['TambahPointMember'];
    }else{
        $TambahPointMember="0";
    }
    //id_supplier
    if(!empty($_POST['id_supplier'])){
        $id_supplier=$_POST['id_supplier'];
    }else{
        $id_supplier="";
    }
    //BUKA DATA SETTING APLIKASI
    $Qry = mysqli_query($conn, "SELECT * FROM setting_aplikasi")or die(mysqli_error($conn));
    $DataSetting = mysqli_fetch_array($Qry);
    //aktif_promo
    if(!empty($DataSetting['aktif_promo'])){
        $aktif_promo = $DataSetting['aktif_promo'];
    }else{
        $aktif_promo ="Tidak";
    }
    //Apabila data baru maka input pada data transaksi
    if($NewOrEdit=="New"){
        //Input ke transaksi
        $entry="INSERT INTO transaksi (
            kode_transaksi,
            tanggal,
            jenis_transaksi,
            subtotal,
            ppn,
            biaya,
            diskon,
            total_tagihan,
            pembayaran,
            selisih,
            keterangan,
            petugas
        ) VALUES (
            '$kode_transaksi',
            '$tanggal',
            '$jenis_transaksi',
            '$subtotal',
            '$RpPPN',
            '0',
            '$RpDiskon',
            '$total',
            '$pembayaran',
            '$selisih',
            '$keterangan',
            '$SessionUsername'
        )";
        $hasil=mysqli_query($conn, $entry);
        //Apabila input transaksi berhasil
        if($hasil){
            if($jenis_transaksi=="penjualan"){
                //APABILA PROMO AKTIF
                if($aktif_promo=="Aktif"){
                    //Buka data member berdasarkan id member
                    if(!empty($id_member)){
                        $QryMember = mysqli_query($conn, "SELECT * FROM member WHERE id_member='$id_member'")or die(mysqli_error($conn));
                        $DataMember = mysqli_fetch_array($QryMember);
                        $nik = $DataMember['nik'];
                        $NamaMember = $DataMember['nama'];
                        $alamat = $DataMember['alamat'];
                        $kontak = $DataMember['kontak'];
                        $point = $DataMember['point'];
                        $PointBaru=$point+$TambahPointMember;
                        //Input Log Pemberian point
                        $LogPemberianPoint="INSERT INTO pemberian_point (
                            tanggal,
                            kode_transaksi,
                            id_member,
                            point
                        ) VALUES (
                            '$tanggal',
                            '$kode_transaksi',
                            '$id_member',
                            '$TambahPointMember'
                        )";
                        $HasilLogPemberianPoint=mysqli_query($conn, $LogPemberianPoint);
                        //Apabila Input log pemberian point berhasil maka edit point pada data member
                        if($HasilLogPemberianPoint){
                            $TambahkanPointKeMember = mysqli_query($conn, "UPDATE member SET 
                                point='$PointBaru'
                            WHERE id_member='$id_member'") or die(mysqli_error($conn));
                            if($TambahkanPointKeMember){
                                $ProsesPoinisasi="Berhasil";
                            }else{
                                $ProsesPoinisasi="Gagal";
                            }
                        }else{
                            $ProsesPoinisasi="Gagal";
                        }
                    }else{
                        $PointBaru="0";
                        $id_member="";
                        $ProsesPoinisasi="Berhasil";
                    }
                }else{
                    $PointBaru="0";
                    $id_member="";
                    $ProsesPoinisasi="Berhasil";
                }
                if($ProsesPoinisasi=="Berhasil"){
                    //Arraykan rincian transaksi
                    $QryRincianTrans = mysqli_query($conn, "SELECT*FROM rincian_transaksi WHERE kode_transaksi='$kode_transaksi'");
                    while ($DataRincianTrans = mysqli_fetch_array($QryRincianTrans)) {
                        $id_obat = $DataRincianTrans['id_obat'];
                        $qty= $DataRincianTrans['qty'];
                        $id_multi= $DataRincianTrans['id_multi'];
                        //Buka Data Obat
                        $QryObat = mysqli_query($conn, "SELECT * FROM obat WHERE id_obat='$id_obat'")or die(mysqli_error($conn));
                        $DataObat = mysqli_fetch_array($QryObat);
                        $stok = $DataObat['stok'];
                        $konversiBarang = $DataObat['konversi'];
                        //Jika rincian tidak mengandung multi harga
                        if(empty($id_multi)){
                            //Stok Baru
                            if($jenis_transaksi=="penjualan"){
                                $StokBaru=$stok-$qty;
                            }else{
                                $StokBaru=$stok+$qty;
                            }
                            //Update Stok Obat
                            $EditObat = mysqli_query($conn, "UPDATE obat SET stok='$StokBaru' WHERE id_obat='$id_obat'") or die(mysqli_error($conn));
                            //Buka Data Obat Lagi
                            $QryObat = mysqli_query($conn, "SELECT * FROM obat WHERE id_obat='$id_obat'")or die(mysqli_error($conn));
                            $DataObat = mysqli_fetch_array($QryObat);
                            $stok = $DataObat['stok'];
                            $konversiBarang = $DataObat['konversi'];
                            //Araykan data multi sesuai id barang
                            $QryMutiList = mysqli_query($conn, "SELECT*FROM muti_harga WHERE id_barang='$id_obat'");
                            while ($DataMutiList = mysqli_fetch_array($QryMutiList)) {
                                $id_multiList = $DataMutiList['id_multi'];
                                $KonversiList = $DataMutiList['konversi'];
                                $StokList = $DataMutiList['stok'];
                                $StokBaruList=($konversiBarang/$KonversiList)*$stok;
                                //lakukan Update pada setiap data muti harga
                                $UpdateMutiHarga = mysqli_query($conn, "UPDATE muti_harga SET stok='$StokBaruList' WHERE id_multi='$id_multiList'") or die(mysqli_error($conn));
                            }
                        }else{
                            //Sebaliknya Jika rincian mengandung multi harga
                            //Buka data multi untuk mengetahui konversi multi
                            $QryMulti = mysqli_query($conn, "SELECT * FROM muti_harga WHERE id_multi='$id_multi'")or die(mysqli_error($conn));
                            $DataMulti = mysqli_fetch_array($QryMulti);
                            $konversiMulti = $DataMulti['konversi'];
                            //konversikan qty rincian pada satuan utama
                            $qty=($konversiMulti/$konversiBarang)*$qty;
                            //Stok Baru
                            if($jenis_transaksi=="penjualan"){
                                $StokBaru=$stok-$qty;
                            }else{
                                $StokBaru=$stok+$qty;
                            }
                            //Updatekan ke data barang
                            $EditObat = mysqli_query($conn, "UPDATE obat SET stok='$StokBaru' WHERE id_obat='$id_obat'") or die(mysqli_error($conn));
                            //Buka Data Obat Lagi
                            $QryObat = mysqli_query($conn, "SELECT * FROM obat WHERE id_obat='$id_obat'")or die(mysqli_error($conn));
                            $DataObat = mysqli_fetch_array($QryObat);
                            $stok = $DataObat['stok'];
                            $konversiBarang = $DataObat['konversi'];
                            //Araykan data multi sesuai id barang
                            $QryMutiList = mysqli_query($conn, "SELECT*FROM muti_harga WHERE id_barang='$id_obat'");
                            while ($DataMutiList = mysqli_fetch_array($QryMutiList)) {
                                $id_multiList = $DataMutiList['id_multi'];
                                $KonversiList = $DataMutiList['konversi'];
                                $StokList = $DataMutiList['stok'];
                                $StokBaruList=($konversiBarang/$KonversiList)*$stok;
                                //lakukan Update pada setiap data muti harga
                                $UpdateMutiHarga = mysqli_query($conn, "UPDATE muti_harga SET stok='$StokBaruList' WHERE id_multi='$id_multiList'") or die(mysqli_error($conn));
                            }
                        }
                         
                    }
                    echo '<i id="NotifikasiSettingTransaksiBerhasil">Berhasil</i>';
                }else{
                    echo '<i id="NotifikasiSettingTransaksiBerhasil">Terjadi Kegagal Pada Saat Menamabahkan Point Pada Data Member '.$id_member.' dan '.$PointBaru.'</i>';
                }
            }else{
                //APABILA ada supplier
                if(!empty($id_supplier)){
                    $QryMember = mysqli_query($conn, "SELECT * FROM member WHERE id_member='$id_supplier'")or die(mysqli_error($conn));
                    $DataMember = mysqli_fetch_array($QryMember);
                    $nik = $DataMember['nik'];
                    $NamaMember = $DataMember['nama'];
                    $alamat = $DataMember['alamat'];
                    $kontak = $DataMember['kontak'];
                    //Input transaksi Supplier
                    $TransaksiSupplier="INSERT INTO transaksi_supplier (
                        kode_transaksi,
                        id_member,
                        tanggal,
                        nama
                    ) VALUES (
                        '$kode_transaksi',
                        '$id_supplier',
                        '$tanggal',
                        '$NamaMember'
                    )";
                    $HasilTransaksiSupplier=mysqli_query($conn, $TransaksiSupplier);
                    //Apabila Input Transaksi Supplier
                    if($HasilTransaksiSupplier){
                        $ProsesPoinisasi="Berhasil";
                    }else{
                        $ProsesPoinisasi="Gagal";
                    }
                }else{
                    $ProsesPoinisasi="Berhasil";
                }
                if($ProsesPoinisasi=="Berhasil"){
                    //Arraykan rincian transaksi
                    $QryRincianTrans = mysqli_query($conn, "SELECT*FROM rincian_transaksi WHERE kode_transaksi='$kode_transaksi'");
                    while ($DataRincianTrans = mysqli_fetch_array($QryRincianTrans)) {
                        $id_obat = $DataRincianTrans['id_obat'];
                        $qty= $DataRincianTrans['qty'];
                        $id_multi= $DataRincianTrans['id_multi'];
                        //Buka Data Obat
                        $QryObat = mysqli_query($conn, "SELECT * FROM obat WHERE id_obat='$id_obat'")or die(mysqli_error($conn));
                        $DataObat = mysqli_fetch_array($QryObat);
                        $stok = $DataObat['stok'];
                        $konversiBarang = $DataObat['konversi'];
                        //Jika rincian tidak mengandung multi harga
                        if(empty($id_multi)){
                            //Stok Baru
                            if($jenis_transaksi=="penjualan"){
                                $StokBaru=$stok-$qty;
                            }else{
                                $StokBaru=$stok+$qty;
                            }
                            //Update Stok Obat
                            $EditObat = mysqli_query($conn, "UPDATE obat SET stok='$StokBaru' WHERE id_obat='$id_obat'") or die(mysqli_error($conn));
                            //Buka Data Obat Lagi
                            $QryObat = mysqli_query($conn, "SELECT * FROM obat WHERE id_obat='$id_obat'")or die(mysqli_error($conn));
                            $DataObat = mysqli_fetch_array($QryObat);
                            $stok = $DataObat['stok'];
                            $konversiBarang = $DataObat['konversi'];
                            //Araykan data multi sesuai id barang
                            $QryMutiList = mysqli_query($conn, "SELECT*FROM muti_harga WHERE id_barang='$id_obat'");
                            while ($DataMutiList = mysqli_fetch_array($QryMutiList)) {
                                $id_multiList = $DataMutiList['id_multi'];
                                $KonversiList = $DataMutiList['konversi'];
                                $StokList = $DataMutiList['stok'];
                                $StokBaruList=($konversiBarang/$KonversiList)*$stok;
                                //lakukan Update pada setiap data muti harga
                                $UpdateMutiHarga = mysqli_query($conn, "UPDATE muti_harga SET stok='$StokBaruList' WHERE id_multi='$id_multiList'") or die(mysqli_error($conn));
                            }
                        }else{
                            //Sebaliknya Jika rincian mengandung multi harga
                            //Buka data multi untuk mengetahui konversi multi
                            $QryMulti = mysqli_query($conn, "SELECT * FROM muti_harga WHERE id_multi='$id_multi'")or die(mysqli_error($conn));
                            $DataMulti = mysqli_fetch_array($QryMulti);
                            $konversiMulti = $DataMulti['konversi'];
                            //konversikan qty rincian pada satuan utama
                            $qty=($konversiMulti/$konversiBarang)*$qty;
                            //Stok Baru
                            if($jenis_transaksi=="penjualan"){
                                $StokBaru=$stok-$qty;
                            }else{
                                $StokBaru=$stok+$qty;
                            }
                            //Updatekan ke data barang
                            $EditObat = mysqli_query($conn, "UPDATE obat SET stok='$StokBaru' WHERE id_obat='$id_obat'") or die(mysqli_error($conn));
                            //Buka Data Obat Lagi
                            $QryObat = mysqli_query($conn, "SELECT * FROM obat WHERE id_obat='$id_obat'")or die(mysqli_error($conn));
                            $DataObat = mysqli_fetch_array($QryObat);
                            $stok = $DataObat['stok'];
                            $konversiBarang = $DataObat['konversi'];
                            //Araykan data multi sesuai id barang
                            $QryMutiList = mysqli_query($conn, "SELECT*FROM muti_harga WHERE id_barang='$id_obat'");
                            while ($DataMutiList = mysqli_fetch_array($QryMutiList)) {
                                $id_multiList = $DataMutiList['id_multi'];
                                $KonversiList = $DataMutiList['konversi'];
                                $StokList = $DataMutiList['stok'];
                                $StokBaruList=($konversiBarang/$KonversiList)*$stok;
                                //lakukan Update pada setiap data muti harga
                                $UpdateMutiHarga = mysqli_query($conn, "UPDATE muti_harga SET stok='$StokBaruList' WHERE id_multi='$id_multiList'") or die(mysqli_error($conn));
                            }
                        }
                         
                    }
                    echo '<i id="NotifikasiSettingTransaksiBerhasil">Berhasil</i>';
                }else{
                    echo '<i id="NotifikasiSettingTransaksiBerhasil">Input Data Supplier Gagal, Periksa dan Lengkapi Form Transaksi Pembelian.</i>';
                }
            }
        }else{
            echo '<i id="NotifikasiSettingTransaksiBerhasil">Tambah Data Transaksi Gagal!</i>';
        }
    }else{
    //Apabila Edit Transaksi
        $EditTransaksi = mysqli_query($conn, "UPDATE transaksi SET 
            subtotal='$subtotal', 
            ppn='$RpPPN', 
            diskon='$RpDiskon',
            total_tagihan='$total',
            pembayaran='$pembayaran',
            selisih='$selisih',
            keterangan='$keterangan'
        WHERE kode_transaksi='$kode_transaksi'") or die(mysqli_error($conn));
        if($EditTransaksi){
            if($jenis_transaksi=="penjualan"){
                //Buka data log pemberian point
                $QryPemberianPoint = mysqli_query($conn, "SELECT * FROM pemberian_point WHERE kode_transaksi='$kode_transaksi'")or die(mysqli_error($conn));
                $DataPemberianPoint = mysqli_fetch_array($QryPemberianPoint);
                //Apabila ada log nya kembalikan Point tersebut
                if(!empty($DataPemberianPoint['id_pemberian_point'])){
                    $id_pemberian_point=$DataPemberianPoint['id_pemberian_point'];
                    $TanggalPemberianPoint=$DataPemberianPoint['tanggal'];
                    $IdMemberYangDiberikan=$DataPemberianPoint['id_member'];
                    $PointYangDiberikan=$DataPemberianPoint['point'];
                    //Buka data member Yang memperoleh point
                    $QryMemberIni = mysqli_query($conn, "SELECT * FROM member WHERE id_member='$IdMemberYangDiberikan'")or die(mysqli_error($conn));
                    $DataMemberIni = mysqli_fetch_array($QryMemberIni);
                    $PointMemberIni=$DataMemberIni['point'];
                    //kembalikan point
                    $PointBaru1=$PointMemberIni-$PointYangDiberikan;
                    //Kembalikan Point member Tersebut Dari Member
                    $KembalikanPointDariMember = mysqli_query($conn, "UPDATE member SET 
                        point='$PointBaru1'
                    WHERE id_member='$IdMemberYangDiberikan'") or die(mysqli_error($conn));
                    //Apabila Proses kembalikan Point member berhasil
                    if($KembalikanPointDariMember ){
                        //Cek apakah ada id member untuk transaski edit ini (yang baru) ada tidaknya
                        if(!empty($id_member)){
                            //Buka data member baru
                            $QryMemberIni = mysqli_query($conn, "SELECT * FROM member WHERE id_member='$id_member'")or die(mysqli_error($conn));
                            $DataMemberIni = mysqli_fetch_array($QryMemberIni);
                            $PointMemberIni=$DataMemberIni['point'];
                            //Edit Log Pemberian Point Yang lama
                            $PointBaru2=$PointMemberIni+$TambahPointMember;
                            $EditLogPemberianPoint = mysqli_query($conn, "UPDATE pemberian_point SET 
                                id_member='$id_member',
                                point='$TambahPointMember'
                            WHERE kode_transaksi='$kode_transaksi'") or die(mysqli_error($conn));
                            if($EditLogPemberianPoint){
                                //Berikan Point Baru Tersebut Pada Member Baru
                                $EditPointMemberBaru = mysqli_query($conn, "UPDATE member SET 
                                    point='$PointBaru2'
                                WHERE id_member='$id_member'") or die(mysqli_error($conn));
                                if($EditPointMemberBaru){
                                    echo '<i id="NotifikasiSettingTransaksiBerhasil">Berhasil</i>';
                                }else{
                                    echo '<i id="NotifikasiSettingTransaksiBerhasil">Edit Data Point pada Member Baru Gagal!</i>';
                                }
                            }else{
                                echo '<i id="NotifikasiSettingTransaksiBerhasil">Edit Data pada log pemberian point Gagal!</i>';
                            }
                        }else{
                            echo '<i id="NotifikasiSettingTransaksiBerhasil">Berhasil</i>';
                        }
                    }else{
                        echo '<i id="NotifikasiSettingTransaksiBerhasil">Kembalikan Point Dari Member Lama Gagal!</i>';
                    }
                //Apabila Tidak ada tidak perlu kembalikan
                }else{
                    //Cek Apakah Ada Data Member Di Edit transaksi baru
                    if(!empty($id_member)){
                        //Buka data member baru
                        $QryMemberIni = mysqli_query($conn, "SELECT * FROM member WHERE id_member='$IdMemberYangDiberikan'")or die(mysqli_error($conn));
                        $DataMemberIni = mysqli_fetch_array($QryMemberIni);
                        $PointMemberIni=$DataMemberIni['point'];
                        //Edit Log Pemberian Point Yang lama
                        $PointBaru2=$PointMemberIni+$TambahPointMember;
                        $EditLogPemberianPoint = mysqli_query($conn, "UPDATE pemberian_point SET 
                            id_member='$id_member',
                            point='$TambahPointMember'
                        WHERE kode_transaksi='$kode_transaksi'") or die(mysqli_error($conn));
                        if($EditLogPemberianPoint){
                            //Berikan Point Baru Tersebut Pada Member Baru
                            $EditPointMemberBaru = mysqli_query($conn, "UPDATE member SET 
                                point='$PointBaru2'
                            WHERE id_member='$id_member'") or die(mysqli_error($conn));
                            if($EditPointMemberBaru){
                                echo '<i id="NotifikasiSettingTransaksiBerhasil">Berhasil</i>';
                            }else{
                                echo '<i id="NotifikasiSettingTransaksiBerhasil">Edit Data Point pada Member Baru Gagal!</i>';
                            }
                        }else{
                            echo '<i id="NotifikasiSettingTransaksiBerhasil">Edit Data pada log pemberian point Gagal!</i>';
                        }
                    }else{
                        echo '<i id="NotifikasiSettingTransaksiBerhasil">Berhasil</i>';
                    }
                }
            }else{
                if(!empty($id_supplier)){
                    $QryMember = mysqli_query($conn, "SELECT * FROM member WHERE id_member='$id_supplier'")or die(mysqli_error($conn));
                    $DataMember = mysqli_fetch_array($QryMember);
                    $nik = $DataMember['nik'];
                    $NamaMember = $DataMember['nama'];
                    $alamat = $DataMember['alamat'];
                    $kontak = $DataMember['kontak'];

                    $EditTransaksiSupplier = mysqli_query($conn, "UPDATE transaksi_supplier SET 
                        id_member='$id_supplier',
                        nama='$NamaMember'
                    WHERE kode_transaksi='$kode_transaksi'") or die(mysqli_error($conn));
                    if($EditTransaksiSupplier){
                        echo '<i id="NotifikasiSettingTransaksiBerhasil">Berhasil</i>';
                    }
                }else{
                    echo '<i id="NotifikasiSettingTransaksiBerhasil">Supplier Tidak Boleh Kosong</i>';
                }
            }
           
        }else{
            echo '<i id="NotifikasiSettingTransaksiBerhasil">Edit Data Transaksi Gagal!</i>';
        }
    }
?>