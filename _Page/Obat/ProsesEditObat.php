<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    //Apabila kode kosong
    if(empty($_POST['kode'])){
        echo '<div class="alert alert-warning" role="alert">';
        echo '  <strong>KETERANGAN :</strong><br> Kode Obat Tidak Boleh Kosong!!.';
        echo '</div>';
    }else{
        //Apabila Nama Kosong
        if(empty($_POST['nama'])){
            echo '<div class="alert alert-warning" role="alert">';
            echo '  <strong>KETERANGAN :</strong><br> Nama/Merek Obat Tidak Boleh Kosong!!.';
            echo '</div>';
        }else{
            $id_obat=$_POST['id_obat'];
            $kode=$_POST['kode'];
            $nama=$_POST['nama'];
            $kategori=$_POST['kategori'];
            $satuan=$_POST['satuan'];
            if(empty($_POST['stok'])){
                $stok="0";
            }else{
                $stok=$_POST['stok'];
            }
            if(empty($_POST['harga1'])){
                $harga1="0";
            }else{
                $harga1=$_POST['harga1'];
            }
            if(empty($_POST['harga2'])){
                $harga2="0";
            }else{
                $harga2=$_POST['harga2'];
            }
            if(empty($_POST['harga3'])){
                $harga3="0";
            }else{
                $harga3=$_POST['harga3'];
            }
            if(empty($_POST['harga4'])){
                $harga4="0";
            }else{
                $harga4=$_POST['harga4'];
            }
            if(empty($_POST['isi'])){
                $isi="0";
            }else{
                $isi=$_POST['isi'];
            }
            //Cek format angka
            if (!preg_match("/^[0-9.]*$/",$stok)) { 
                echo '<div class="alert alert-warning" role="alert">';
                echo '  <strong>KETERANGAN :</strong><br> Stok Diisi dengan format yang salah!!.';
                echo '</div>';
            }else{
                if (!preg_match("/^[0-9.]*$/",$harga1)) { 
                    echo '<div class="alert alert-warning" role="alert">';
                    echo '  <strong>KETERANGAN :</strong><br> Format Harga Beli Salah!!';
                    echo '</div>';
                }else{
                    if (!preg_match("/^[0-9.]*$/",$harga2)) { 
                        echo '<div class="alert alert-warning" role="alert">';
                        echo '  <strong>KETERANGAN :</strong><br> Format Harga Grosir Salah!!.';
                        echo '</div>';
                    }else{
                        if (!preg_match("/^[0-9.]*$/",$harga3)) { 
                            echo '<div class="alert alert-warning" role="alert">';
                            echo '  <strong>KETERANGAN :</strong><br> Format Harga Medis Salah!!.';
                            echo '</div>';
                        }else{
                            if (!preg_match("/^[0-9.]*$/",$harga4)) { 
                                echo '<div class="alert alert-warning" role="alert">';
                                echo '  <strong>KETERANGAN :</strong><br> Format Harga Eceran Salah!!.';
                                echo '</div>';
                            }else{
                                //apabila syarat terpenuhi lakukan input
                                $hasil = mysqli_query($conn, "UPDATE obat SET 
                                kode='$kode',
                                nama='$nama',
                                kategori='$kategori',
                                satuan='$satuan',
                                konversi='$isi',
                                stok='$stok',
                                harga_1='$harga1',
                                harga_2='$harga2',
                                harga_3='$harga3',
                                harga_4='$harga4'
                                WHERE id_obat='$id_obat'") or die(mysqli_error($conn)); 
                                if($hasil){
                                    //Araykan Data Multi Harga
                                    $query = mysqli_query($conn, "SELECT*FROM muti_harga WHERE id_barang='$id_obat'");
                                    while ($data = mysqli_fetch_array($query)) {
                                        $id_multi = $data['id_multi'];
                                        $konversi = $data['konversi'];
                                        $satuanMulti = $data['satuan'];
                                        $stokMulti= $data['stok'];
                                        $harga_1Multi= $data['harga1'];
                                        $harga_2Multi= $data['harga2'];
                                        $harga_3Multi= $data['harga3'];
                                        $harga_4Multi= $data['harga4'];
                                        //Lakukan perhitungan stok dan harga
                                        $stokMultiBaru=($isi/$konversi)*$stok;
                                        $harga_1MultiBaru=($konversi/$isi)*$harga1;
                                        $harga_2MultiBaru=($konversi/$isi)*$harga2;
                                        $harga_3MultiBaru=($konversi/$isi)*$harga3;
                                        $harga_4MultiBaru=($konversi/$isi)*$harga4;
                                        //Lakukan Update MultiHarga
                                        $UpdateMultiHarga = mysqli_query($conn, "UPDATE muti_harga SET 
                                            stok='$stokMultiBaru',
                                            harga1='$harga_1MultiBaru',
                                            harga2='$harga_2MultiBaru',
                                            harga3='$harga_3MultiBaru',
                                            harga4='$harga_4MultiBaru'
                                        WHERE id_multi='$id_multi'") or die(mysqli_error($conn)); 
                                    }
                                    echo '<div class="alert alert-success" role="alert">';
                                    echo '  <strong>KETERANGAN:</strong><div id="NotifikasiTambahObatBerhasil">Berhasil</div>.';
                                    echo '</div>';
                                }else{
                                    echo '<div class="alert alert-warning" role="alert">';
                                    echo '  <strong>KETERANGAN :</strong><br> Input data obat gagal, periksa koneksi anda.';
                                    echo '</div>';
                                }
                            }
                        }
                    }
                }
            }
        }
    }
?>