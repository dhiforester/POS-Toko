<?php
    //koneksi dan error
    include "../../_Config/Connection.php";
    //Tangkap data
    if(!empty($_POST['NewOrEdit'])){
        $NewOrEdit=$_POST['NewOrEdit'];
    }else{
        $NewOrEdit="New";
    }
    //Jenis transaksi
    if(!empty($_POST['trans'])){
        $trans=$_POST['trans'];
    }else{
        $trans="trans";
    }
    //Kode Transaksi
    if(!empty($_POST['kode_transaksi'])){
        $kode_transaksi=$_POST['kode_transaksi'];
    }else{
        $kode_transaksi="";
    }
    //Scan Barcode
    if(!empty($_POST['ScanBarcode'])){
        $ScanBarcode=$_POST['ScanBarcode'];
    }else{
        $ScanBarcode="";
    }
    //quantitas
    if(!empty($_POST['quantitas'])){
        $quantitas=$_POST['quantitas'];
    }else{
        $quantitas="";
    }
    //id_multi
    if(!empty($_POST['id_multi'])){
        $id_multi=$_POST['id_multi'];
    }else{
        $id_multi="";
    }
    //StandarHargaScan
    if(!empty($_POST['StandarHargaScan'])){
        $standar_harga=$_POST['StandarHargaScan'];
    }else{
        $standar_harga="";
    }
    //Buka data obat
    $QryObat = mysqli_query($conn, "SELECT * FROM obat WHERE kode='$ScanBarcode'")or die(mysqli_error($conn));
    $DataObat = mysqli_fetch_array($QryObat);
    //Apabila data obat tidak ada
    if(empty($DataObat['kode'])){
        echo '<b id="NotifikasiScanBerhasil" class="text-danger">Data Tidak Ditemukan</b>';
    }else{
        //Apabila Obat Ada maka panggil datanya
        $id_obat=$DataObat['id_obat'];
        $kode_obat=$DataObat['kode'];
        $nama=$DataObat['nama'];
        $stok=$DataObat['stok'];
        $harga_1=$DataObat['harga_1'];
        $harga_2=$DataObat['harga_2'];
        $harga_3=$DataObat['harga_3'];
        $harga_4=$DataObat['harga_4'];
        //Apakah ada data id_multi yang ditangkap?
        if(!empty($id_multi)){
            //Cek apakah id multi adalah yang utama atau bukan?
            if($id_multi=="Satuan Utama"){
                $id_multi="0";
            }else{
                $id_multi=$_POST['id_multi'];
            }
            //Tangkap juga variabel harga
            if(!empty($_POST['harga'])){
                $harga=$_POST['harga'];
            }else{
                $harga="";
            }
            //Buat Jumlah
            $jumlah=$harga*$quantitas;
            //Input ke rincian transaksi
            $entry="INSERT INTO rincian_transaksi (
                kode_transaksi,
                id_obat,
                id_multi,
                standar_harga,
                nama,
                qty,
                harga,
                jumlah
            ) VALUES (
                '$kode_transaksi',
                '$id_obat',
                '$id_multi',
                '$standar_harga',
                '$nama',
                '$quantitas',
                '$harga',
                '$jumlah'
            )";
            $hasil=mysqli_query($conn, $entry);
            if($hasil){
                echo '<b id="NotifikasiScanBerhasil" class="text-info">Lanjut Scan</b>';
            }else{
                echo '<b id="NotifikasiScanBerhasil" class="text-danger">Input Rincian Gagal</b>';
            }
        }else{
            //Cari apakah barang tersebut memiliki id multi
            $JmlhDataMulti = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM muti_harga WHERE id_barang='$id_obat'"));
            if(!empty($JmlhDataMulti)){
                //Apabila ada kirim perintah membuka form lanjutan
                echo '<b id="NotifikasiScanBerhasil" class="text-white">Multi Harga Ditemukan</b><br>';
                echo 'ID Barang: <b id="GetIdBarang" class="text-danger">'.$id_obat.'</b><br>';
                echo 'Standar Harga: <b id="GetStandarHarga" class="text-danger">'.$standar_harga.'</b>';
            }else{
            //Apabila tidak ada maka gunakan harga yang ada pada data utama sesuai standar harga
                if($standar_harga=="harga_1"){
                    $harga=$harga_1;
                }else{
                    if($standar_harga=="harga_2"){
                        $harga=$harga_2;
                    }else{
                        if($standar_harga=="harga_3"){
                            $harga=$harga_3;
                        }else{
                            if($standar_harga=="harga_4"){
                                $harga=$harga_4;
                            }else{
                                $harga=$harga_4;
                            }
                        }
                    }
                }
                //Buat Jumlah
                $jumlah=$harga*$quantitas;
                $id_multi="0";
                //Input ke rincian transaksi
                $entry="INSERT INTO rincian_transaksi (
                    kode_transaksi,
                    id_obat,
                    id_multi,
                    standar_harga,
                    nama,
                    qty,
                    harga,
                    jumlah
                ) VALUES (
                    '$kode_transaksi',
                    '$id_obat',
                    '$id_multi',
                    '$standar_harga',
                    '$nama',
                    '$quantitas',
                    '$harga',
                    '$jumlah'
                )";
                $hasil=mysqli_query($conn, $entry);
                if($hasil){
                    echo '<b id="NotifikasiScanBerhasil" class="text-info">Lanjut Scan</b>';
                }else{
                    echo '<b id="NotifikasiScanBerhasil" class="text-danger">Input Rincian Gagal</b>';
                }
            }
        }
    }
?>