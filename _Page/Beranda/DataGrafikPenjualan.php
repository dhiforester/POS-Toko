<?php
    include "../../_Config/Connection.php";
    //Tangkap Parameter Stok Minimal
    if(!empty($_POST['tahun'])){
        $tahun=$_POST['tahun'];
    }else{
        $tahun=date('Y');
    }
    //Tangkap Transaksi
    if(!empty($_POST['transaksi'])){
        $transaksi=$_POST['transaksi'];
    }else{
        $transaksi="Penjualan";
    }
?>
<script>
    $('#TampilkanData').submit(function(){
        var tahun=$('#tahun').val();
        var transaksi=$('#transaksi').val();
        $('#DataGrafikPenjualan').html('Loading..');
        $.ajax({
            url     : "_Page/Beranda/DataGrafikPenjualan.php",
            method  : "POST",
            data    : { tahun: tahun, transaksi: transaksi },
            success: function (data) {
                $('#DataGrafikPenjualan').html(data);
            }
        })
    });
</script>
<form action="javascript:void(0);" id="TampilkanData">
    <script>
         $('#ModalgrafikPenjualan').on('show.bs.modal', function (e) {
            $('#tahun').focus();
        });
    </script>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-6">
                <h3 class="text-primary">Grafik <?php echo $transaksi;?> Tahun <?php echo "$tahun"; ?></h3>
            </div>
            <div class="col-md-3">
                <div class="input-group">
                    <select name="transaksi"  id="transaksi" class="form-control">
                        <option value="Penjualan">Penjualan</option>
                        <option value="Pembelian">Pembelian</option>
                        <option value="Laba-Rugi">Laba-Rugi</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="input-group">
                    <input type="number" min="0" class="form-control" id="tahun" name="tahun" class="form-control" placeholder="Tahun">
                    <div class="input-group-append border-primary">
                        <button type="submit" class="btn btn-danger">
                            Tampilkan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<div class="modal-body">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <canvas id="myChart" height="150"></canvas>
                    <script>
                        var ctx = document.getElementById("myChart");
                        var myChart = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: ["Jan", "Feb", "Marc", "Apr", "May", "Jun", "Jul","Agus","Sept","Okt","Nov","Des"],
                                datasets: [{
                                    label: "Penjualan",
                                    data: [
                                        <?php
                                        //tahun sekarang
                                        $now_Y=date('Y');
                                        //lakukan perulangan sebanyak 12 kali
                                        for ( $b =1; $b<=12; $b++ ){
                                            $bulan= sprintf("%02d", $b);
                                            $y_m="$tahun-$bulan";
                                            if($transaksi=="Penjualan"){
                                                $get = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM transaksi WHERE jenis_transaksi='penjualan' AND tanggal like '%$y_m%'"));
                                            }
                                            if($transaksi=="Pembelian"){
                                                $get = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM transaksi WHERE jenis_transaksi='pembelian' AND tanggal like '%$y_m%'"));
                                            }
                                            if($transaksi=="Laba-Rugi"){
                                                //Menghitung Jumlah pemasukan
                                                $QryPemasukan = mysqli_query($conn, "SELECT SUM(total_tagihan) as total_tagihan FROM transaksi WHERE jenis_transaksi='penjualan' AND tanggal like '%$y_m%'");
                                                $DataPemasukan = mysqli_fetch_array($QryPemasukan);
                                                $Pemasukan=$DataPemasukan['total_tagihan'];
                                                //Menghitung Jumlah Pengeluaran
                                                $QryPengeluaran = mysqli_query($conn, "SELECT SUM(total_tagihan) as total_tagihan FROM transaksi WHERE jenis_transaksi='pembelian' AND tanggal like '%$y_m%'");
                                                $DataPembelian = mysqli_fetch_array($QryPengeluaran);
                                                $Pengeluaran=$DataPembelian['total_tagihan'];
                                                $get =$Pemasukan-$Pengeluaran;
                                            }
                                            
                                            echo '"' . $get . '",';
                                        }
                                        ?>
                                    ],
                                    borderColor: 'rgba(0, 188, 212, 0.75)',
                                    backgroundColor: 'rgba(0, 188, 212, 0.3)',
                                    pointBorderColor: 'rgba(0, 188, 212, 0)',
                                    pointBackgroundColor: 'rgba(0, 188, 212, 0.9)',
                                    pointBorderWidth: 1
                                }]
                            },
                            options: {
                                scales: {
                                    yAxes: [{
                                            ticks: {
                                                beginAtZero: true
                                            }
                                        }]
                                }
                            }
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>

