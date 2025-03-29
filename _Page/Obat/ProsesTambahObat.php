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
            $kode=$_POST['kode'];
            $nama=$_POST['nama'];
            //Validasi kode yang sama
            $CekKode = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM obat WHERE kode='$kode'"));
            //Apabila kode sudah ada
            if(!empty($CekKode)){
                echo '<div class="alert alert-warning" role="alert">';
                echo '  <strong>KETERANGAN :</strong><br> Kode Barang yang anda gunakan sudah terdaftar.';
                echo '</div>';
            }else{
                //Validasi nama yang sama
                $CekNama = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM obat WHERE nama='$nama'"));
                if(!empty($CekNama)){
                    echo '<div class="alert alert-warning" role="alert">';
                    echo '  <strong>KETERANGAN :</strong><br> Nama/Merek yang anda gunakan sudah terdaftar.';
                    echo '</div>';
                }else{
                    $kategori=$_POST['kategori'];
                    $satuan=$_POST['satuan'];
                    if(empty($_POST['isi'])){
                        $isi="0";
                    }else{
                        $isi=$_POST['isi'];
                    }
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
                                    echo '  <strong>KETERANGAN :</strong><br> Format Harga Toko Salah!!.';
                                    echo '</div>';
                                }else{
                                    if (!preg_match("/^[0-9.]*$/",$harga4)) { 
                                        echo '<div class="alert alert-warning" role="alert">';
                                        echo '  <strong>KETERANGAN :</strong><br> Format Harga Eceran Salah!!.';
                                        echo '</div>';
                                    }else{
                                        //apabila syarat terpenuhi lakukan input
                                        $entry="INSERT INTO obat (kode,nama,kategori,satuan,konversi,stok,harga_1,harga_2,harga_3,harga_4) 
                                        VALUES ('$kode','$nama','$kategori','$satuan','$isi','$stok','$harga1','$harga2','$harga3','$harga4')";
                                        $hasil=mysqli_query($conn, $entry);
                                        if($hasil){
                                            //Buka data obat dan panggil id nya
                                            $query_kode=mysqli_query($conn, "SELECT max(id_obat) as id_obat FROM obat")or die(mysqli_error($conn));
                                            while($hasil_kode=mysqli_fetch_array($query_kode)){
                                                $IdObatBuka=$hasil_kode['id_obat'];
                                            }
                                            echo '<div class="alert alert-success" role="alert">';
                                            echo '  <strong>KETERANGAN:</strong><div id="NotifikasiTambahObatBerhasil">Berhasil</div>.';
                                            echo '</div>';
                                        }else{
                                            echo '<div class="alert alert-warning" role="alert">';
                                            echo '  <strong>KETERANGAN :</strong><br> Input data Barang gagal, periksa koneksi anda.';
                                            echo '</div>';
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
?>
<b id="getKode"><?php echo $kode;?></b>