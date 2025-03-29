<?php
    //error display
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    //Menangkap data akses menjadi variabel
    $id_so=$_POST['id_so'];
    $query = mysqli_query($conn, "DELETE FROM stok_opename WHERE id_so='$id_so'") or die(mysqli_error($conn));    
    if($query){
        //Buka data So
        $QrySo = mysqli_query($conn, "SELECT * FROM stok_opename WHERE id_so='$id_so'")or die(mysqli_error($conn));
        $DataSo = mysqli_fetch_array($QrySo);
        $id_obat= $DataSo['id_barang'];
        $periode= $DataSo['tanggal'];
        $stok = $DataSo['stok_data'];
        $stok_nyata = $DataSo['stok_nyata'];
        $selisih= $DataSo['selisih'];
        $keterangan= $DataSo['keterangan'];
        //Buka data barang
        //Buka Data Obat
        $QryObat = mysqli_query($conn, "SELECT * FROM obat WHERE id_obat='$id_obat'")or die(mysqli_error($conn));
        $DataObat = mysqli_fetch_array($QryObat);
        $nama= $DataObat['nama'];
        $kode = $DataObat['kode'];
        $satuan = $DataObat['satuan'];
        $stokLama = $DataObat['stok'];
        //Hitung Stok baru setelah di delete
        $stokBaru=$stokLama-$selisih;
        //Lakukan update
        $UpdateBarang = mysqli_query($conn, "UPDATE obat SET stok='$stokBaru' WHERE id_obat='$id_obat'") or die(mysqli_error($conn));
        echo '<div id="">Berhasil</div>';
    }else{
        echo '<div id="">Gagal</div>';
    }
?>