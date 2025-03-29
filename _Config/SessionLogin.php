<?php
    session_start();
    if (isset($_SESSION['IdUser']) || !empty($_SESSION['IdUser'])){
        $SessionIdUser=$_SESSION['IdUser'];
        //panggil dari database
        $QuerySessionAkses = mysqli_query($conn, "SELECT * FROM user WHERE id_user='$SessionIdUser'")or die(mysqli_error($conn));
        $DataSessionAkses = mysqli_fetch_array($QuerySessionAkses);
        //rincian profile user
        $SessionIdUser = $DataSessionAkses['id_user'];
        $SessionUsername = $DataSessionAkses['username'];
        $SessionPassword= $DataSessionAkses['password'];
        $SessionLevel= $DataSessionAkses['level_akses'];
        if($SessionLevel=="Pelanggan"){
            //Mendeteksi apakah ini pelanggan baru atau lama
            $QueryPelangganSession = mysqli_query($conn, "SELECT * FROM pelanggan WHERE id_user='$SessionIdUser'")or die(mysqli_error($conn));
            $DataPelangganSisseion = mysqli_fetch_array($QueryPelangganSession);
            //rincian profile user
            $SessionIdPelanggan = $DataPelangganSisseion['id_pelanggan'];
            $SessionNik = $DataPelangganSisseion['nik'];
            $SessionNama = $DataPelangganSisseion['nama'];
            $SessionAlamat = $DataPelangganSisseion['alamat'];
            $SessionTtl = $DataPelangganSisseion['ttl'];
            $SessionEmail = $DataPelangganSisseion['email'];
            $SessionNoHp = $DataPelangganSisseion['no_hp'];
            $SessionNoMeter = $DataPelangganSisseion['nomor_meter'];
            $SessionIdTarif = $DataPelangganSisseion['id_tarif'];
            $SessionStatus = $DataPelangganSisseion['status'];
            //Buka Tarif
            $QryGolonganTarif = mysqli_query($conn, "SELECT * FROM tarif WHERE id_tarif='$SessionIdTarif'")or die(mysqli_error($conn));
            $DataGolonganTarif = mysqli_fetch_array($QryGolonganTarif);
            $SessionGolongan = $DataGolonganTarif['golongan'];
            $SessionKategoriKonsumen = $DataGolonganTarif['kategori_konsumen'];
            $SessionTegangan = $DataGolonganTarif['tegangan'];
            $SessionBiayaPasang = $DataGolonganTarif['biaya_pemasangan'];
            $SessionBiayaJaminan = $DataGolonganTarif['biaya_jaminan'];
            $SessionMatrai= $DataGolonganTarif['matrai'];
            $SessionTarif= $DataGolonganTarif['tarif'];
            //Format rupiah
            $RpBiayaPemasangan="Rp " . number_format($SessionBiayaPasang,2,',','.');
            $RpBiayaJaminan="Rp " . number_format($SessionBiayaJaminan,2,',','.');
            $RpBiayaMatrai="Rp " . number_format($SessionMatrai,2,',','.');
            $BiayaTotal=$SessionBiayaPasang+$SessionBiayaJaminan+$SessionMatrai;
            $RpBiayaTotal="Rp " . number_format($BiayaTotal,2,',','.');
            //Buka Pembayaran pendaftaran
            $QryPembayaranPendaftaranPelanggan = mysqli_query($conn, "SELECT * FROM pembayaran WHERE id_pelanggan='$SessionIdPelanggan' AND tujuan_pembayaran='Pembayaran Biaya Pemasangan'")or die(mysqli_error($conn));
            $DataPembayaranPendaftaranPelanggan = mysqli_fetch_array($QryPembayaranPendaftaranPelanggan);
            $StatusPembayaranPendaftaran = $DataPembayaranPendaftaranPelanggan['status'];
            $TanggalPembayaranPendaftaran = $DataPembayaranPendaftaranPelanggan['tanggal'];
            $TujuanPembayaranPendaftaran = $DataPembayaranPendaftaranPelanggan['tujuan_pembayaran'];
            $Nominal_pembayaranPembayaranPendaftaran = $DataPembayaranPendaftaranPelanggan['nominal_pembayaran'];
            $No_buktiPembayaranPendaftaran = $DataPembayaranPendaftaranPelanggan['no_bukti'];
            $Bukti_pembayaranPembayaranPendaftaran = $DataPembayaranPendaftaranPelanggan['bukti_pembayaran'];
            $No_rekPembayaranPendaftaran = $DataPembayaranPendaftaranPelanggan['no_rek'];
        }
    }
?>