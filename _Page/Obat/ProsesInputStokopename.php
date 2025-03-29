<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    //Apabila no_batch kosong
    if(empty($_POST['id_obat'])){
        echo 'None1';
    }else{
        //Apabila Nama Kosong
        if(empty($_POST['periode'])){
            echo 'None2';
        }else{
            if(empty($_POST['id_so'])){
                if(empty($_POST['stok_data'])){
                    echo 'None3';
                }else{
                    if(empty($_POST['satuan'])){
                        echo 'None4';
                    }else{
                        if(empty($_POST['stok_nyata'])){
                            echo 'None5';
                        }else{
                            if(empty($_POST['selisih'])){
                                echo 'None6';
                            }else{
                                if(empty($_POST['keterangan'])){
                                    echo 'None7';
                                }else{
                                    $id_obat=$_POST['id_obat'];
                                    $periode=$_POST['periode'];
                                    $stok_data=$_POST['stok_data'];
                                    $satuan=$_POST['satuan'];
                                    $stok_nyata=$_POST['stok_nyata'];
                                    $selisih=$_POST['selisih'];
                                    $keterangan=$_POST['keterangan'];
                                    $entry="INSERT INTO stok_opename (
                                        id_barang,
                                        tanggal,
                                        stok_data,
                                        stok_nyata,
                                        selisih,
                                        keterangan
                                    ) VALUES (
                                        '$id_obat',
                                        '$periode',
                                        '$stok_data',
                                        '$stok_nyata',
                                        '$selisih',
                                        '$keterangan'
                                    )";
                                    $hasil=mysqli_query($conn, $entry);
                                    if($hasil){
                                        echo '<i class="mdi mdi-plus"></i> Add (Enter)';
                                        $UpdateBarang = mysqli_query($conn, "UPDATE obat SET stok='$stok_nyata' WHERE id_obat='$id_obat'") or die(mysqli_error($conn));
                                    }else{
                                        echo 'None8';
                                    }
                                }
                            }
                        }
                    }
                }
            }else{
                $id_so=$_POST['id_so'];
                $id_obat=$_POST['id_obat'];
                $periode=$_POST['periode'];
                $stok_data=$_POST['stok_data'];
                $satuan=$_POST['satuan'];
                $stok_nyata=$_POST['stok_nyata'];
                $selisih=$_POST['selisih'];
                $keterangan=$_POST['keterangan'];
                $UpdateSo = mysqli_query($conn, "UPDATE stok_opename SET 
                    tanggal='$periode',
                    stok_data='$stok_data',
                    stok_nyata='$stok_nyata',
                    selisih='$selisih',
                    keterangan='$keterangan'
                WHERE id_so='$id_so'") or die(mysqli_error($conn));
                if($UpdateSo){
                    $UpdateBarang = mysqli_query($conn, "UPDATE obat SET stok='$stok_nyata' WHERE id_obat='$id_obat'") or die(mysqli_error($conn));
                    echo '<i class="mdi mdi-plus"></i> Update (Enter)';
                }else{
                    echo 'None8';
                }
            }
        }
    }
?>