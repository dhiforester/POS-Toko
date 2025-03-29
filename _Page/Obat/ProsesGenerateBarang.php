<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    //Atur Batas
    if(!empty($_POST['batas'])){
        $batas=$_POST['batas'];
    }else{
        $batas="10";
    }
    //Atur Page
    if(!empty($_POST['page'])){
        $page=$_POST['page'];
        $posisi = ( $page - 1 ) * $batas;
    }else{
        $page="1";
        $posisi = 0;
    }
    //Atur Keyword
    if(isset($_POST['keyword'])){
        $keyword=$_POST['keyword'];
    }else{
        $keyword="";
    }
    //Atur Keyword
    if(isset($_POST['OrderBy'])){
        $OrderBy=$_POST['OrderBy'];
    }else{
        $OrderBy="nama";
    }
    //Atur Keyword
    if(isset($_POST['ShortBy'])){
        $ShortBy=$_POST['ShortBy'];
    }else{
        $ShortBy="ASC";
    }
    //hitung jumlah data
    if(empty($keyword)){
        $jml_data = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM obat"));
    }else{
        $jml_data = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM obat WHERE nama like '%$keyword%' OR kode like '%$keyword%'"));
    }
    //Jumlah halaman
    $JmlHalaman = ceil($jml_data/$batas); 
    $JmlHalaman_real = ceil($jml_data/$batas); 
    $prev=$page-1;
    $next=$page+1;
    if($next>$JmlHalaman){
        $next=$page;
    }else{
        $next=$page+1;
    }
    if($prev<"1"){
        $prev="1";
    }else{
        $prev=$page-1;
    }
    $no = 1+$posisi;
    //KONDISI PENGATURAN MASING FILTER
    if(empty($keyword)){
        $query = mysqli_query($conn, "SELECT*FROM obat ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
    }else{
        $query = mysqli_query($conn, "SELECT*FROM obat WHERE nama like '%$keyword%' OR kode like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
    }
    while ($data = mysqli_fetch_array($query)) {
        $id_obat = $data['id_obat'];
        $nama= $data['nama'];
        $kode = $data['kode'];
        $satuan = $data['satuan'];
        $stok= $data['stok'];
        $harga_1= $data['harga_1'];
        $harga_2= $data['harga_2'];
        $harga_3= $data['harga_3'];
        $harga_4= $data['harga_4'];
        //Membuka data barcode
        //Menghitung Jumlah Yang sama
        $jumlahYangSama = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM barcode WHERE kode='$kode'"));
        if($jumlahYangSama=="1"){
            $QryBarcode = mysqli_query($conn, "SELECT * FROM barcode WHERE kode='$kode'")or die(mysqli_error($conn));
            $DataBarkode = mysqli_fetch_array($QryBarcode);
            $barcode= $DataBarkode['barcode'];
        }else{
            if($jumlahYangSama>1){
                $QryBarcode = mysqli_query($conn, "SELECT * FROM barcode WHERE kode='$kode' AND harga='$harga_1'")or die(mysqli_error($conn));
                $DataBarkode = mysqli_fetch_array($QryBarcode);
                $barcode= $DataBarkode['barcode'];
            }else{
                $barcode="";
            }
        }
        if(empty($barcode)){
            $barcode="";
        }else{
            $barcode=$barcode;
        }
        if(!empty($barcode)){
            $hasil = mysqli_query($conn, "UPDATE obat SET kode='$barcode', stok='9999' WHERE id_obat='$id_obat'") or die(mysqli_error($conn)); 
        }
    }
    echo "<b id='NotifikasiGenerateBerhasil'>Berhasil</b><br>";
    echo "<b id='KelasBatas'>$batas</b> <br>";
    echo "<b id='KelasPage'>$page</b> <br>";
?>