<?php
    include $_SERVER['DOCUMENT_ROOT'].'/tb_bdl/controller/koneksi.php';
    if(isset($_GET['id'])){
      $sql = 'Select kapal.id_kapal, nama, id_jenis_kapal, tanda_selar, mesin, panjang, berat_kotor, id_pemilik from kapal left join kepemilikan_kapal on kapal.id_kapal = kepemilikan_kapal.id_kapal where kapal.id_kapal = '.$_GET['id'];
      $eksekusi = pg_query($sql);
      while ($perulangan = pg_fetch_assoc($eksekusi)) {
 ?>
  <div class="form-group row">
      <label class="col-sm-2 col-form-label">Nama Kapal</label>
      <div class="col-sm-10">
          <input type="text" class="form-control" value="<?php echo $perulangan['nama']; ?>"  id="nama" name="nama" placeholder="Nama Kapal">
          <span class="messages popover-valid"></span>
      </div>
  </div>
  <div class="form-group row">
      <label class="col-sm-2 col-form-label">Jenis Kapal</label>
      <div class="col-sm-10">
          <select class="form-control js-example-basic-hide-search" name="id_jenis_kapal">
            <?php
              $sql = "SELECT id_jenis_kapal, nama from jenis_kapal";
              $eksekusi = pg_query($sql);
              while ($data = pg_fetch_assoc($eksekusi)) {
                if($data['id_jenis_kapal'] == $perulangan['id_jenis_kapal']){
                  echo '<option value="'.$data['id_jenis_kapal'].'" selected>'.$data['nama'].'</option>';
                }else{
                  echo '<option value="'.$data['id_jenis_kapal'].'">'.$data['nama'].'</option>';
                }
              }
            ?>
          </select>
          <span class="messages popover-valid"></span>
      </div>
  </div>
  <div class="form-group row">
      <label class="col-sm-2 col-form-label">Tanda Selar</label>
      <div class="col-sm-10">
          <input type="text" class="form-control" value="<?php echo $perulangan['tanda_selar']; ?>" id="tenda_selar" name="tenda_selar" placeholder="Tenda Selar">
          <span class="messages popover-valid"></span>
      </div>
  </div>
  <div class="form-group row">
      <label class="col-sm-2 col-form-label">Mesin</label>
      <div class="col-sm-10">
          <input type="text" class="form-control" value="<?php echo $perulangan['mesin']; ?>" id="mesin" name="mesin" placeholder="Mesin">
          <span class="messages popover-valid"></span>
      </div>
  </div>
  <div class="form-group row">
      <label class="col-sm-2 col-form-label">Panjang</label>
      <div class="col-sm-10">
          <input type="text" class="form-control autonumber" data-v-max="9999" data-v-min="0" value="<?php echo $perulangan['panjang']; ?>" id="panjang" name="panjang" placeholder="Panjang">
          <span class="messages popover-valid"></span>
      </div>
  </div>
  <div class="form-group row">
      <label class="col-sm-2 col-form-label">Berat Kotor</label>
      <div class="col-sm-10">
          <input type="text" class="form-control autonumber" data-v-max="9999" data-v-min="0" value="<?php echo $perulangan['berat_kotor']; ?>" id="berat_kotor" name="berat_kotor" placeholder="Berat Kotor">
          <span class="messages popover-valid"></span>
      </div>
  </div>
  <div class="form-group row" style="display:none">
      <label class="col-sm-2 col-form-label">ID</label>
      <div class="col-sm-10">
          <input type="text" class="form-control" value="<?php echo $perulangan['id_kapal']; ?>" id="id" name="id" placeholder="id">
          <span class="messages popover-valid"></span>
      </div>
  </div>
<?php
  }
}else{
?>
<div class="form-group row">
    <label class="col-sm-2 col-form-label">Nama Kapal</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Kapal" required>
        <span class="messages popover-valid"></span>
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-2 col-form-label">Jenis Kapal</label>
    <div class="col-sm-10">
        <select class="js-example-basic-single col-sm-12" name="id_jenis_kapal">
          <?php
            $sql = "SELECT id_jenis_kapal, nama from jenis_kapal";
            $eksekusi = pg_query($sql);
            while ($data = pg_fetch_assoc($eksekusi)) {
              echo '<option value="'.$data['id_jenis_kapal'].'">'.$data['nama'].'</option>';
            }
          ?>
        </select>
        <span class="messages popover-valid"></span>
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-2 col-form-label">Tanda Selar</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="tenda_selar" name="tenda_selar" placeholder="Tenda Selar">
        <span class="messages popover-valid"></span>
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-2 col-form-label">Mesin</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="mesin" name="mesin" placeholder="Mesin">
        <span class="messages popover-valid"></span>
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-2 col-form-label">Panjang</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="panjang" name="panjang" placeholder="Panjang">
        <span class="messages popover-valid"></span>
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-2 col-form-label">Berat Kotor</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="berat_kotor" name="berat_kotor" placeholder="Berat Kotor">
        <span class="messages popover-valid"></span>
    </div>
</div>
<?php
} ?>
