<div class="row">
        <div class="form-group col-sm-6">
            <a href="_page/Transaksi/CetakPembelian.php?Awal=<?php echo $Awal; ?>&Akhir=<?php echo $Akhir; ?>" class="btn btn-rounded btn-outline-primary" target="_blank">
                Cetak
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 grid-margin">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Transaksi</th>
                            <th>Tagihan</th>
                            <th>Keterangan</th>
                            <th>Option</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $no = 1;
                            //KONDISI PENGATURAN MASING FILTER
                            $query = mysqli_query($conn, "SELECT*FROM transaksi WHERE jenis_transaksi='pembelian' AND tanggal>='$Awal' AND tanggal<='$Akhir' ORDER BY id_transaksi DESC");
                            while ($data = mysqli_fetch_array($query)) {
                                $id_transaksi = $data['id_transaksi'];
                                $kode_transaksi = $data['kode_transaksi'];
                                $tanggal = $data['tanggal'];
                                $jenis_transaksi= $data['jenis_transaksi'];
                                $total_tagihan= $data['total_tagihan'];
                                $pembayaran= $data['pembayaran'];
                                $selisih= $data['selisih'];
                                $keterangan= $data['keterangan'];
                                if($jenis_transaksi=="penjualan"){
                                    $jenis_transaksi="PNJ";
                                }else{
                                    $jenis_transaksi="PMB";
                                }
                        ?>
                        <tr>
                            <td><?php echo "$no";?></td>
                            <td><?php echo "$tanggal";?></td>
                            <td><?php echo "$jenis_transaksi";?></td>
                            <td align="right"><?php echo "Rp " . number_format($total_tagihan,0,',','.');?></td>
                            <td><?php echo "$keterangan";?></td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#ModalDetailTransaksi" data-id="<?php echo "Edit,$kode_transaksi,$JenisLaporan,$Awal,$Akhir";?>">
                                        Detail
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php $no++;} ?>
                        <?php
                            $QryJumlahTotal = mysqli_query($conn, "SELECT SUM(total_tagihan) as total_tagihan FROM transaksi WHERE jenis_transaksi='pembelian' AND tanggal>='$Awal' AND tanggal<='$Akhir'");
                            $DataJumlahTotal = mysqli_fetch_array($QryJumlahTotal);
                            $JumlahTotal=$DataJumlahTotal['total_tagihan'];
                        ?>
                        <tr>
                            <td colspan="3" align="right">JUMLAH TOTAL</td>
                            <td align="right"><?php echo "Rp " . number_format($JumlahTotal,0,',','.');?></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
