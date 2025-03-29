<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    //Menangkap data akses menjadi variabel
    $username=$_POST['username'];
    $level=$_POST['level'];
    $password1=$_POST['password1'];
    $password2=$_POST['password2'];
    $status="Aktif";
    $JmlhKarUsername = strlen($username);
    $JmlhKarPassword = strlen($password1);
    //Validasi jumlah nomor meter yang sama
    $JumlahUsername = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM user WHERE username='$username'"));
    //Apabila username sudah ada
    if(!empty($JumlahUsername)){
        echo '<div class="alert alert-warning" role="alert">';
        echo '  <strong>KETERANGAN :</strong><br> Username yang anda gunakan sudah terdaftar.';
        echo '</div>';
    }else{
        //apabila username kurang dari 6 digit
        if($JmlhKarUsername<6){
            echo '<div class="alert alert-warning" role="alert">';
            echo '  <strong>KETERANGAN :</strong><br> Username minimal harus memiliki 6 karakter.';
            echo '</div>';
        }else{
            if($JmlhKarPassword<6){
                echo '<div class="alert alert-warning" role="alert">';
                echo '  <strong>KETERANGAN :</strong><br> Password minimal harus memiliki 6 karakter.';
                echo '</div>';
            }else{
                if($password1==$password2){
                    //apabila syarat terpenuhi lakukan input
                    $entry="INSERT INTO user (
                        username,
                        password,
                        status,
                        level_akses
                    ) VALUES (
                        '$username',
                        '$password1',
                        'Aktif',
                        '$level'
                    )";
                    $hasil=mysqli_query($conn, $entry);
                    if($hasil){
                        echo '<div class="alert alert-success" role="alert">';
                        echo '  <strong>KETERANGAN INPUT DATA:</strong><div id="NotifikasiProsesTambahUser">Berhasil</div>.';
                        echo '</div>';
                    }else{
                        echo '<div class="alert alert-warning" role="alert">';
                        echo '  <strong>KETERANGAN :</strong><br> Input data user gagal, periksa koneksi anda.';
                        echo '</div>';
                    }
                }else{
                    echo '<div class="alert alert-warning" role="alert">';
                    echo '  <strong>KETERANGAN :</strong><br> Password Tidak sama.';
                    echo '</div>';
                }
            }
        }
    }
?>