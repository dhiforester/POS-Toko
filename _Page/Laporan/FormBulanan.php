<div class="form-group row">
    <div class="col col-md-6">
        <label>Tahun</label>
        <input type="number" require class="form-control border-dark" min="1999" max="2200" name="tahun" id="tahun" value="<?php echo date('Y');?>">
    </div>
    <div class="col col-md-6" id="FormTanggal">
        <label>Bulan</label>
        <select name="bulan" id="bulan" class="form-control border-dark">
            <option value="01">Januari</option>
            <option value="02">Februari</option>
            <option value="03">Maret</option>
            <option value="04">April</option>
            <option value="05">Mei</option>
            <option value="06">Juni</option>
            <option value="07">Juli</option>
            <option value="08">Agustus</option>
            <option value="09">September</option>
            <option value="010">Oktober</option>
            <option value="11">November</option>
            <option value="12">Desember</option>
        </select>
    </div>  
</div>
