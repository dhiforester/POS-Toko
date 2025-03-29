<?php
    //error display
    ini_set("display_errors","off");
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    //Menangkap data akses menjadi variabel
    $IdUser=$_POST['IdUser'];
    $UsernameLama=$_POST['UsernameLama'];
    //Buka data user
    $username=$_POST['username'];
    $password1=$_POST['password1'];
    $password2=$_POST['password2'];
    $JmlhKarUsername = strlen($username);
    $JmlhKarPassword = strlen($password1);
    //Validasi jumlah nomor meter yang sama
    if($UsernameLama!==$username){
        $JumlahUsername = mysql_num_rows(mysql_query("SELECT*FROM user WHERE username='$username'"));
    }else{
        $JumlahUsername ="0";
    }
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
                    $hasil = mysql_query("UPDATE user SET 
                    username='$username',
                    password='$password1'
                    WHERE id_user='$IdUser'") or die(mysql_error()); 
                    if($hasil){
                        session_start();
                        session_destroy();
                        echo '<div class="alert alert-success" role="alert">';
                        echo '  <strong>KETERANGAN INPUT DATA:</strong><div id="NotifikasiProsesEditProfil">Berhasil</div>.';
                        echo '</div>';
                    }else{
                        echo '<div class="alert alert-warning" role="alert">';
                        echo '  <strong>KETERANGAN :</strong><br> Edit data profil gagal, periksa koneksi anda.';
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