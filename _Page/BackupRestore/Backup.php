<?php
    //koneksi dan error
    include "../../_Config/Connection.php";
?>
<script>
    $('#ModalBackup').on('show.bs.modal', function (e) {
        var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
        $('#FormBackup').html(Loading);
        $('#FormBackup').load("_Page/BackupRestore/FormBackup.php");
    });
</script>
<div class="card-body">
    <div class="row">
        <div class="col-md-12 text-center">
            <button class="btn btn-lg btn-rounded btn-outline-primary" data-toggle="modal" data-target="#ModalBackup">
                <i class="menu-icon mdi mdi-download"></i> Backup File Database (SQL)
            </button>
        </div>
    </div>
    <br><br>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered scroll-container">
                <thead>
                    <tr>
                        <th><b>No</b></th>
                        <th><b>Nama Tabel</b></th>
                        <th><b>Data</b></th>
                        <th><b>Option</b></th>
                    </tr>
                </thead>
                <thead>
                    <tr>
                        <td align="center">1</td>
                        <td>Member dan Supplier</td>
                        <td>
                            <?php
                                $JumlahMember = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM member"));
                                echo "" . number_format($JumlahMember,0,',','.');
                                echo " Data";
                            ?>
                        </td>
                        <td align="center">
                            <a class="btn btn-primary" target="_blank" href="_Page/BackupRestore/ExcelMember.php">
                                <i class="menu-icon mdi mdi-file-excel"></i> Export
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">2</td>
                        <td>Barang</td>
                        <td>
                            <?php
                                $JumlahBarang = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM obat"));
                                echo "" . number_format($JumlahBarang,0,',','.');
                                echo " Data";
                            ?>
                        </td>
                        <td align="center">
                            <a class="btn btn-primary" target="_blank" href="_Page/BackupRestore/ExcelBarang.php">
                                <i class="menu-icon mdi mdi-file-excel"></i> Export
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">3</td>
                        <td>Kode Batch Barang</td>
                        <td>
                            <?php
                                $JumlahBatch = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM batch"));
                                echo "" . number_format($JumlahBatch,0,',','.');
                                echo " Data";
                            ?>
                        </td>
                        <td align="center">
                            <a class="btn btn-primary" target="_blank" href="_Page/BackupRestore/ExcelBatch.php">
                                <i class="menu-icon mdi mdi-file-excel"></i> Export
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">4</td>
                        <td>Transaksi</td>
                        <td>
                            <?php
                                $JumlahTransaksi = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM transaksi"));
                                echo "" . number_format($JumlahTransaksi,0,',','.');
                                echo " Data";
                            ?>
                        </td>
                        <td align="center">
                            <a class="btn btn-primary" target="_blank" href="_Page/BackupRestore/ExcelTransaksi.php">
                                <i class="menu-icon mdi mdi-file-excel"></i> Export
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">5</td>
                        <td>Rincian Transaksi</td>
                        <td>
                            <?php
                                $JumlahRincianTransaksi = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM rincian_transaksi"));
                                echo "" . number_format($JumlahRincianTransaksi,0,',','.');
                                echo " Data";
                            ?>
                        </td>
                        <td align="center">
                            <a class="btn btn-primary" target="_blank" href="_Page/BackupRestore/ExcelRincianTransaksi.php">
                                <i class="menu-icon mdi mdi-file-excel"></i> Export
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">6</td>
                        <td>Log Pemberian Point</td>
                        <td>
                            <?php
                                $JumlahPemberianPoint = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM pemberian_point"));
                                echo "" . number_format($JumlahPemberianPoint,0,',','.');
                                echo " Data";
                            ?>
                        </td>
                        <td align="center">
                            <a class="btn btn-primary" target="_blank" href="_Page/BackupRestore/ExcelRPemberianPoint.php">
                                <i class="menu-icon mdi mdi-file-excel"></i> Export
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">7</td>
                        <td>Data Hadiah</td>
                        <td>
                            <?php
                                $JumlahHadiah = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM hadiah"));
                                echo "" . number_format($JumlahHadiah,0,',','.');
                                echo " Data";
                            ?>
                        </td>
                        <td align="center">
                            <a class="btn btn-primary" target="_blank" href="_Page/BackupRestore/ExcelHadiah.php">
                                <i class="menu-icon mdi mdi-file-excel"></i> Export
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">8</td>
                        <td>Klaim Hadiah</td>
                        <td>
                            <?php
                                $JumlahKlaimHadiah = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM klaim"));
                                echo "" . number_format($JumlahKlaimHadiah,0,',','.');
                                echo " Data";
                            ?>
                        </td>
                        <td align="center">
                            <a class="btn btn-primary" target="_blank" href="_Page/BackupRestore/ExcelKlaimHadiah.php">
                                <i class="menu-icon mdi mdi-file-excel"></i> Export
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">9</td>
                        <td>Transaksi Supplier</td>
                        <td>
                            <?php
                                $JumlahTransaksiSupplier = mysqli_num_rows(mysqli_query($conn, "SELECT*FROM transaksi_supplier"));
                                echo "" . number_format($JumlahTransaksiSupplier,0,',','.');
                                echo " Data";
                            ?>
                        </td>
                        <td align="center">
                            <a class="btn btn-primary" target="_blank" href="_Page/BackupRestore/ExcelTransaksiSupplier.php">
                                <i class="menu-icon mdi mdi-file-excel"></i> Export
                            </a>
                        </td>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

