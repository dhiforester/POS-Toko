<?php
    include "../../_Config/Connection.php";
    if (! empty($_FILES)) {
        // Validating SQL file type by extensions
        if (! in_array(strtolower(pathinfo($_FILES["backup_file"]["name"], PATHINFO_EXTENSION)), array(
            "sql"
        ))) {
            $response = array(
                "type" => "error",
                "message" => "Invalid File Type"
            );
        } else {
            if (is_uploaded_file($_FILES["backup_file"]["tmp_name"])) {
                move_uploaded_file($_FILES["backup_file"]["tmp_name"], $_FILES["backup_file"]["name"]);
                $response = restoreMysqlDB($_FILES["backup_file"]["name"], $conn);
                if (! empty($response)) {
                    $TipeRespon=$response["type"];
                    $PesanRespon=$response["message"];
                    if($TipeRespon=="success"){
                        echo '<div class="alert alert-success text-center" role="alert">';
                        echo '  Proses Restore Database <b id="NotifikasiRestoreBerhasil">Berhasil</b>';
                        echo '</div>';
                        echo '<div class="alert alert-success text-center" role="alert">';
                        echo '  Periksa kembali data-data anda, ulangi proses restore apabila terjadi kehilangan data.';
                        echo '</div>';
                    }else{
                        echo '<div class="alert alert-danger text-center" role="alert">';
                        echo '  <b>Type Respon :</b> '.$TipeRespon.'<br>';
                        echo '  <b>Pesan :</b> '.$PesanRespon.'<br>';
                        echo '</div>';
                    }
                }
            }
        }
    }

    function restoreMysqlDB($filePath, $conn)
    {
        $sql = '';
        $error = '';
        
        if (file_exists($filePath)) {
            $lines = file($filePath);
            
            foreach ($lines as $line) {
                
                // Ignoring comments from the SQL script
                if (substr($line, 0, 2) == '--' || $line == '') {
                    continue;
                }
                
                $sql .= $line;
                
                if (substr(trim($line), - 1, 1) == ';') {
                    $result = mysqli_query($conn, $sql);
                    if (! $result) {
                        $error .= mysqli_error($conn) . "\n";
                    }
                    $sql = '';
                }
            } // end foreach
            
            if ($error) {
                $response = array(
                    "type" => "error",
                    "message" => $error
                );
            } else {
                $response = array(
                    "type" => "success",
                    "message" => "Database Restore Completed Successfully."
                );
            }
        } // end if file exists
        return $response;
    }
?>