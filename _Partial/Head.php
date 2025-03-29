<?php
   //Buka data Setting Aplikasi
   $Qry = mysqli_query($conn, "SELECT * FROM setting_aplikasi")or die(mysqli_error($conn));
   $DataSetting = mysqli_fetch_array($Qry);
   //Nama Perusahaan
   if(!empty($DataSetting['nama_perusahaan'])){
       $nama_perusahaan = $DataSetting['nama_perusahaan'];
   }else{
       $nama_perusahaan = "Business Today";
   }
   //Alamat
   if(!empty($DataSetting['alamat'])){
       $alamat = $DataSetting['alamat'];
   }else{
       $alamat ="";
   }
   //kontak
   if(!empty($DataSetting['kontak'])){
       $kontak = $DataSetting['kontak'];
   }else{
       $kontak ="";
   }
   //logo
   if(!empty($DataSetting['logo'])){
       $logo = $DataSetting['logo'];
   }else{
       $logo ="";
   }
   //logo
   if(!empty($DataSetting['aktif_promo'])){
       $aktif_promo = $DataSetting['aktif_promo'];
   }else{
       $aktif_promo ="Tidak";
   }
   //jumlah_point
   if(!empty($DataSetting['jumlah_point'])){
       $jumlah_point = $DataSetting['jumlah_point'];
   }else{
       $jumlah_point ="0";
   }
   //kelipatan_belanja
   if(!empty($DataSetting['kelipatan_belanja'])){
       $kelipatan_belanja = $DataSetting['kelipatan_belanja'];
   }else{
       $kelipatan_belanja ="0";
   }
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo "$nama_perusahaan"; ?></title>
    <link rel="stylesheet" href="vendors/iconfonts/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.addons.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="images/favicon.png" />
    <script src="vendors/bootstrap431/js/jquery.min.js"></script>
    <!--- Ini adalah plugin untuk kontrol halaman atau engine--->
    <script src="_Page/Beranda/Beranda.js"></script>
    <script src="_Page/Logout/JsLogout.js"></script>
    <!---------------------JQUERY-AUTOCOMPLETE------------------------>
</head>
