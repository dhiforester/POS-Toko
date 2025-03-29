<?PHP
    session_start();
    session_destroy();
    echo '<div class="alert alert-success" role="alert">';
    echo '  <strong>KETERANGAN INPUT DATA:</strong><div id="notifikasi">Berhasil</div>.';
    echo '</div>';
?>