<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    //Tangkap Variabel
    if(empty($_POST['id_obat'])){
        echo '<b class="text-danger">Ket:</b> Tidak ada data barang yang dikirim';
    }else{
        if(empty($_POST['id_rincian'])){
            echo '<b class="text-danger">Ket:</b> Tidak ada data rincian yang dikirim';
        }else{
            if(empty($_POST['StandarHarga'])){
                echo '<b class="text-danger">Ket:</b> Kategori Harga Tidak Boleh Kosong';
            }else{
                if(empty($_POST['qty'])){
                    echo '<b class="text-danger">Ket:</b> Jumlah barang tidak boleh kosong';
                }else{
                    $id_obat=$_POST['id_obat'];
                    $id_rincian=$_POST['id_rincian'];
                    $StandarHarga=$_POST['StandarHarga'];
                    $qty=$_POST['qty'];
                    //kode
                    if(empty($_POST['kode'])){
                        $kode="0";
                    }else{
                        $kode=$_POST['kode'];
                    }
                    //nama
                    if(empty($_POST['nama'])){
                        $nama="0";
                    }else{
                        $nama=$_POST['nama'];
                    }
                    //id_multi
                    if(empty($_POST['id_multi'])){
                        $id_multi="0";
                        $QryBarang = mysqli_query($conn, "SELECT * FROM obat WHERE id_obat='$id_obat'")or die(mysqli_error($conn));
                        $DataBarang = mysqli_fetch_array($QryBarang);
                        $satuan= $DataBarang['satuan'];
                    }else{
                        $id_multi=$_POST['id_multi'];
                        $QryBarang = mysqli_query($conn, "SELECT * FROM muti_harga WHERE id_multi='$id_multi'")or die(mysqli_error($conn));
                        $DataBarang = mysqli_fetch_array($QryBarang);
                        $satuan= $DataBarang['satuan'];
                    } 
                    //harga
                    if(empty($_POST['harga'])){
                        $harga="0";
                    }else{
                        $harga=$_POST['harga'];
                    } 
                    //NewOrEdit
                    if(empty($_POST['NewOrEdit'])){
                        $NewOrEdit="New";
                    }else{
                        $NewOrEdit=$_POST['NewOrEdit'];
                    }
                    //id_transaksi
                    if(empty($_POST['id_transaksi'])){
                        $id_transaksi="0";
                    }else{
                        $id_transaksi=$_POST['id_transaksi'];
                    } 
                    $jumlah=$qty*$harga;
                    //Apabila Data Baru
                    if($NewOrEdit=="New"){
                        //Tambah Rincian
                        $entry="INSERT INTO retur_rincian (
                            id_retur,
                            id_transaksi,
                            id_rincian_transaksi,
                            id_barang,
                            kode_barang,
                            nama_barang,
                            harga,
                            qty,
                            satuan,
                            jumlah,
                            standar_harga,
                            id_multi
                        ) VALUES (
                            '0',
                            '$id_transaksi',
                            '$id_rincian',
                            '$id_obat',
                            '$kode',
                            '$nama',
                            '$harga',
                            '$qty',
                            '$satuan',
                            '$jumlah',
                            '$StandarHarga',
                            '$id_multi'
                        )";
                        $hasil=mysqli_query($conn, $entry);
                        if($hasil){
                            echo "Proses Berhasil";
                        }else{
                            echo '<b class="text-danger">Ket:</b> Terjadi kesalahan pada saat input data rincian retur.';
                        }
                    }else{
                        echo '<b class="text-danger">Ket:</b> Data Lama '.$NewOrEdit.'';
                    } 

                } 
            }
        }
    }
?>