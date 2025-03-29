<?php
    //error display
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    //Menangkap data akses menjadi variabel

    //nama_perusahaan
    if(!empty($_POST['nama_perusahaan'])){
        $nama_perusahaan=$_POST['nama_perusahaan'];
    }else{
        $nama_perusahaan="My Page";
    }
    //Alamat
    if(!empty($_POST['alamat'])){
        $alamat=$_POST['alamat'];
    }else{
        $alamat="Alamat Perusahaan Disini";
    }
    //Kontak
    if(!empty($_POST['kontak'])){
        $kontak=$_POST['kontak'];
    }else{
        $kontak="08123456789";
    }
    //aktif_promo
    if(!empty($_POST['aktif_promo'])){
        $aktif_promo=$_POST['aktif_promo'];
    }else{
        $aktif_promo="";
    }
    //jumlah_point
    if(!empty($_POST['jumlah_point'])){
        $jumlah_point=$_POST['jumlah_point'];
    }else{
        $jumlah_point="0";
    }
    //kelipatan_belanja
    if(!empty($_POST['kelipatan_belanja'])){
        $kelipatan_belanja=$_POST['kelipatan_belanja'];
    }else{
        $kelipatan_belanja="0";
    }
    //host_printer
    if(!empty($_POST['host_printer'])){
        $host_printer=$_POST['host_printer'];
    }else{
        $host_printer="0";
    }
    //nama_printer
    if(!empty($_POST['nama_printer'])){
        $nama_printer=$_POST['nama_printer'];
    }else{
        $nama_printer="0";
    }
    //logo
    $tmp = $_FILES['logo']['tmp_name'];
    $type = $_FILES['logo']['type'];
    $size = $_FILES['logo']['size'];
    $filename = $_FILES['logo']['name'];
    $path = "../../images/".$filename;
    //Cek Ketersediaan data
    $TersediaSetting = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM setting_aplikasi"));
    //Apabila kontak bukan angka
    if (!preg_match("/^[0-9]*$/",$kontak)) { 
        echo '<div class="alert alert-warning" role="alert">';
        echo '  <strong>KETERANGAN :</strong> Format data kontak hanya boleh angka.';
        echo '</div>';
    }else{
        //Apabila nama_perusahaan Kosong
        if(empty($nama_perusahaan)){
            echo '<div class="alert alert-warning" role="alert">';
            echo '  <strong>KETERANGAN :</strong><br> Nama Perusahaan Tidak boleh kosong.';
            echo '</div>';
        }else{
            //Apabila alamat kosong
            if(empty($alamat)){
                echo '<div class="alert alert-warning" role="alert">';
                echo '  <strong>KETERANGAN :</strong><br> Alamat Perusahaan Tidak Boleh Kosong.';
                echo '</div>';
            }else{
                //apabila Setting belum ada maka input
                if(empty($TersediaSetting)){
                    //Apabila Logo Tidak Ada maka Langsung Input
                    if(empty($_FILES['logo']['name'])){
                        $entry="INSERT INTO setting_aplikasi (
                            nama_perusahaan,
                            alamat,
                            kontak,
                            logo,
                            aktif_promo,
                            jumlah_point,
                            kelipatan_belanja,
                            host_printer,
                            nama_printer
                        ) VALUES (
                            '$nama_perusahaan',
                            '$alamat',
                            '$kontak',
                            '',
                            '$aktif_promo',
                            '$jumlah_point',
                            '$kelipatan_belanja',
                            '$host_printer',
                            '$nama_printer'
                        )";
                        $hasil=mysqli_query($conn, $entry);
                        if($hasil){
                            echo '<div class="alert alert-success" role="alert">';
                            echo '  <strong>KETERANGAN INPUT DATA:</strong><div id="NotifikasiSettingAplikasiBerhasil">Berhasil</div>.';
                            echo '  Silahkan refresh halaman untuk mengetahui perubahan pengaturan <a href="index.php">berikut</a>.<br>';
                            echo '  Silahkan lakukan print test page berikut <a href="_Page/Setting/testpage.php" target="_blank">Print</a>.<br>';
                            echo '</div>';
                        }else{
                            echo '<div class="alert alert-warning" role="alert">';
                            echo '  <strong>KETERANGAN :</strong><br> Input data setting tanpa logo gagal diproses, Periksa koneksi database anda.<br>';
                            echo '</div>';
                        }
                    //Apabila Logo Ada maka lakukan validasi
                    }else{
                        //Apabila Logo terlalu besar
                        if($size>"1000000"){
                            echo '<div class="alert alert-warning" role="alert">';
                            echo '  <strong>KETERANGAN :</strong><br> Gunakan file logo dengan kapasitas kurang dari 1 mb.';
                            echo '</div>';
                        }else{
                            //Apabila format file tidak kompetebel
                            if($type=="image/jpeg"||$type=="image/jpg"||$type=="image/gif"||$type=="image/x-png"||$type=="image/png"){
                                //Apabila proses upload berhasil
                                if(move_uploaded_file($tmp, $path)){
                                    //apabila syarat terpenuhi lakukan input
                                    $entry="INSERT INTO setting_aplikasi (
                                        nama_perusahaan,
                                        alamat,
                                        kontak,
                                        logo,
                                        aktif_promo,
                                        jumlah_point,
                                        kelipatan_belanja,
                                        host_printer,
                                        nama_printer
                                    ) VALUES (
                                        '$nama_perusahaan',
                                        '$alamat',
                                        '$kontak',
                                        '$filename',
                                        '$aktif_promo',
                                        '$jumlah_point',
                                        '$kelipatan_belanja',
                                        '$host_printer',
                                        '$nama_printer'
                                    )";
                                    $hasil=mysqli_query($conn, $entry);
                                    if($hasil){
                                        echo '<div class="alert alert-success" role="alert">';
                                        echo '  <strong>KETERANGAN INPUT DATA:</strong><div id="NotifikasiSettingAplikasiBerhasil">Berhasil</div>.';
                                        echo '  Silahkan refresh halaman untuk mengetahui perubahan pengaturan <a href="index.php">berikut</a>.<br>';
                                        echo '  Silahkan lakukan print test page berikut <a href="_Page/Setting/testpage.php" target="_blank">Print</a>.<br>';
                                        echo '</div>';
                                    }else{
                                        echo '<div class="alert alert-warning" role="alert">';
                                        echo '  <strong>KETERANGAN :</strong><br> Input data setting dengan logo gagal, periksa koneksi anda.';
                                        echo '</div>';
                                    }
                                }else{
                                    echo '<div class="alert alert-warning" role="alert">';
                                    echo '  <strong>KETERANGAN :</strong><br> Maaf terjadi kesalahan pada saat mengunggah logo anda, coba sekali lagi.';
                                    echo '</div>';
                                }
                            }else{
                                echo '<div class="alert alert-warning" role="alert">';
                                echo '  <strong>KETERANGAN :</strong><br> Maaf file yang anda unggah tidak sesuai (gunakan format JPG, PNG atau GIF).';
                                echo '</div>';
                            }
                        }
                    }
                //Apabila Setting Sudah Ada Maka Edit 
                }else{
                    //Apabila Logo Tidak Ada maka Langsung Edit
                    if(empty($_FILES['logo']['name'])){
                        $hasil = mysqli_query($conn, "UPDATE setting_aplikasi SET 
                            nama_perusahaan='$nama_perusahaan',
                            alamat='$alamat',
                            kontak='$kontak',
                            aktif_promo='$aktif_promo',
                            jumlah_point='$jumlah_point',
                            kelipatan_belanja='$kelipatan_belanja',
                            host_printer='$host_printer',
                            nama_printer='$nama_printer'
                        ") or die(mysqli_error($conn)); 
                        if($hasil){
                            echo '<div class="alert alert-success" role="alert">';
                            echo '  <strong>KETERANGAN INPUT DATA:</strong><div id="NotifikasiSettingAplikasiBerhasil">Berhasil</div>.';
                            echo '  Silahkan refresh halaman untuk mengetahui perubahan pengaturan <a href="index.php">berikut</a>.<br>';
                            echo '  Silahkan lakukan print test page berikut <a href="_Page/Setting/testpage.php" target="_blank">Print</a>.<br>';
                            echo '</div>';
                        }else{
                            echo '<div class="alert alert-warning" role="alert">';
                            echo '  <strong>KETERANGAN :</strong><br> Input data setting tanpa logo gagal diproses, Periksa koneksi database anda.<br>';
                            echo '</div>';
                        }
                    //Apabila Logo Ada maka lakukan validasi
                    }else{
                        //Apabila Logo terlalu besar
                        if($size>"1000000"){
                            echo '<div class="alert alert-warning" role="alert">';
                            echo '  <strong>KETERANGAN :</strong><br> Gunakan file logo dengan kapasitas kurang dari 1 mb.';
                            echo '</div>';
                        }else{
                            //Apabila format file tidak kompetebel
                            if($type=="image/jpeg"||$type=="image/jpg"||$type=="image/gif"||$type=="image/x-png"||$type=="image/png"){
                                //Apabila proses upload berhasil
                                if(move_uploaded_file($tmp, $path)){
                                    $hasil = mysqli_query($conn, "UPDATE setting_aplikasi SET 
                                        nama_perusahaan='$nama_perusahaan',
                                        alamat='$alamat',
                                        kontak='$kontak',
                                        logo='$filename',
                                        aktif_promo='$aktif_promo',
                                        jumlah_point='$jumlah_point',
                                        kelipatan_belanja='$kelipatan_belanja',
                                        host_printer='$host_printer',
                                        nama_printer='$nama_printer'
                                    ") or die(mysqli_error($conn)); 
                                    if($hasil){
                                        echo '<div class="alert alert-success" role="alert">';
                                        echo '  <strong>KETERANGAN INPUT DATA:</strong><div id="NotifikasiSettingAplikasiBerhasil">Berhasil</div>';
                                        echo '  Silahkan refresh halaman untuk mengetahui perubahan pengaturan <a href="index.php">berikut</a>.<br>';
                                        echo '  Silahkan lakukan print test page berikut <a href="_Page/Setting/testpage.php" target="_blank">Print</a>.<br>';
                                        echo '</div>';
                                    }else{
                                        echo '<div class="alert alert-warning" role="alert">';
                                        echo '  <strong>KETERANGAN :</strong><br> Input data setting dengan logo gagal, periksa koneksi anda.';
                                        echo '</div>';
                                    }
                                }else{
                                    echo '<div class="alert alert-warning" role="alert">';
                                    echo '  <strong>KETERANGAN :</strong><br> Maaf terjadi kesalahan pada saat mengunggah logo anda, coba sekali lagi.';
                                    echo '</div>';
                                }
                            }else{
                                echo '<div class="alert alert-warning" role="alert">';
                                echo '  <strong>KETERANGAN :</strong><br> Maaf file yang anda unggah tidak sesuai (gunakan format JPG, PNG atau GIF).';
                                echo '</div>';
                            }
                        }
                    }
                }
            }
        }
    }
?>