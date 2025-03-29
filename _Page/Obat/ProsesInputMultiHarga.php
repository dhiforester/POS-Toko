<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    //Tangkap Variabel
    if(empty($_POST['id_obat'])){
        echo '<div class="text-danger">Maaf!! Id Harga Kosong</div>';
    }else{
        if(empty($_POST['satuan'])){
            echo '<div class="text-danger">Maaf!! Satuan Kosong</div>';
        }else{
            //Apabila id_multi tidak kosong maka edit
            if(!empty($_POST['id_multi'])){
                $id_obat=$_POST['id_obat'];
                $id_multi=$_POST['id_multi'];
                $satuan=$_POST['satuan'];
                $konversi=$_POST['konversi'];
                $harga1=$_POST['harga1'];
                $harga2=$_POST['harga2'];
                $harga3=$_POST['harga3'];
                $harga4=$_POST['harga4'];
                //Buka data barang
                $QryObat = mysqli_query($conn, "SELECT * FROM obat WHERE id_obat='$id_obat'")or die(mysqli_error($conn));
                $DataObat = mysqli_fetch_array($QryObat);
                $konversiBarang = $DataObat['konversi'];
                $StokBarang= $DataObat['stok'];
                //Hitung data stok melalui Stoki=(isi1/isi2)xstok1
                if(!empty($StokBarang)){
                    $stok=($konversiBarang/$konversi)*$StokBarang;
                    $stok=round($stok,2);
                }else{
                    $stok="0";
                }
                //Update Data ke multi harga
                $hasil = mysqli_query($conn, "UPDATE muti_harga SET 
                harga1='$harga1',
                harga2='$harga2',
                harga3='$harga3',
                harga4='$harga4',
                satuan='$satuan',
                konversi='$konversi',
                stok='$stok'
                WHERE id_multi='$id_multi'") or die(mysqli_error($conn)); 
                if($hasil){
                    echo '<div id="NotifikasiInputMultiHargaBerhasil">Berhasil</div>';
                }else{
                    echo '<div class="text-danger">Maaf!! Proses Edit Gagal</div>';
                }
            }else{
                $id_obat=$_POST['id_obat'];
                $satuan=$_POST['satuan'];
                $konversi=$_POST['konversi'];
                $harga1=$_POST['harga1'];
                $harga2=$_POST['harga2'];
                $harga3=$_POST['harga3'];
                $harga4=$_POST['harga4'];
                //Validasi Satuan yang sama
                $CekSatuan = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM muti_harga WHERE satuan='$satuan' AND id_barang='$id_obat'"));
                $CekSatuanBarang = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM obat WHERE satuan='$satuan' AND id_obat='$id_obat'"));
                //Apabila kode sudah ada
                if(!empty($CekSatuan)){
                    echo 'Maaf!! Nama Satuan Sudah Digunakan';
                }else{
                    if(!empty($CekSatuanBarang)){
                        echo 'Maaf!! Gunakan nama satuan lain';
                    }else{
                        //Buka data barang
                        $QryObat = mysqli_query($conn, "SELECT * FROM obat WHERE id_obat='$id_obat'")or die(mysqli_error($conn));
                        $DataObat = mysqli_fetch_array($QryObat);
                        $konversiBarang = $DataObat['konversi'];
                        $StokBarang= $DataObat['stok'];
                        //Hitung data stok melalui Stoki=(isi1/isi2)xstok1
                        if(!empty($StokBarang)){
                            $stok=($konversiBarang/$konversi)*$StokBarang;
                            $stok=round($stok,2);
                        }else{
                            $stok="0";
                        }
                        //Input Data ke multi harga
                        $entry="INSERT INTO muti_harga (
                            id_barang,
                            harga1,
                            harga2,
                            harga3,
                            harga4,
                            satuan,
                            konversi,
                            stok
                        ) VALUES (
                            '$id_obat',
                            '$harga1',
                            '$harga2',
                            '$harga3',
                            '$harga4',
                            '$satuan',
                            '$konversi',
                            '$stok'
                        )";
                        $hasil=mysqli_query($conn, $entry);
                        if($hasil){
                            echo '<div id="NotifikasiInputMultiHargaBerhasil">Berhasil</div>';
                        }else{
                            echo '<div class="text-danger">Maaf!! Proses Input gagal</div>';
                        }
                    }
                }
            }
        }
    }
?>