<?php
    //error display
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    //Menangkap data akses menjadi variabel
    //1
    if(!empty($_POST['IdUser'])){
        $IdUser=$_POST['IdUser'];
    }else{
        $IdUser="";
    }
    //2
    if(!empty($_POST['UsernameLama'])){
        $UsernameLama=$_POST['UsernameLama'];
    }else{
        $UsernameLama="";
    }
    //3
    if(!empty($_POST['page'])){
        $page=$_POST['page'];
    }else{
        $page="";
    }
    //4
    if(!empty($_POST['BatasData'])){
        $BatasData=$_POST['BatasData'];
    }else{
        $BatasData="";
    }
    //5
    if(!empty($_POST['username'])){
        $username=$_POST['username'];
    }else{
        $username="";
    }
    //6
    if(!empty($_POST['level'])){
        $level=$_POST['level'];
    }else{
        $level="";
    }
    //6
    if(!empty($_POST['password1'])){
        $password1=$_POST['password1'];
    }else{
        $password1="";
    }
    //6
    if(!empty($_POST['password2'])){
        $password2=$_POST['password2'];
    }else{
        $password2="";
    }
    //6
    if(!empty($_POST['status'])){
        $status=$_POST['status'];
    }else{
        $status="";
    }
    //Buka data user
    $JmlhKarUsername = strlen($username);
    $JmlhKarPassword = strlen($password1);
    //Validasi jumlah nomor meter yang sama
    if($UsernameLama!==$username){
        $JumlahUsername = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM user WHERE username='$username'"));
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
                    $hasil = mysqli_query($conn, "UPDATE user SET 
                    username='$username',
                    password='$password1',
                    level_akses='$level'
                    WHERE id_user='$IdUser'") or die(mysqli_error($conn)); 
                    if($hasil){
                        echo '<div class="alert alert-success" role="alert">';
                        echo '  <strong>KETERANGAN INPUT DATA:</strong><div id="NotifikasiProsesEditUser">Berhasil</div>.';
                        echo '  <div id="page">'.$page.'</div>.';
                        echo '  <div id="BatasData">'.$BatasData.'</div>.';
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