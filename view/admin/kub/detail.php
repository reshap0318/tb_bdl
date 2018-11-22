<?php include $_SERVER['DOCUMENT_ROOT'].'/tb_bdl/blank.php'; ?>
<?php $no=0;
  include $_SERVER['DOCUMENT_ROOT'].'/tb_bdl/controller/koneksi.php';
  if(isset($_GET['id'])){
    $id = $_GET['id'];
    $sql = "select kub.id_kub, nama, alamat, deskripsi, kub.tgl_berdiri, count(usaha_perikanan.*) as jumlahusaha from kub left join usaha_perikanan on kub.id_kub = usaha_perikanan.id_kub where kub.id_kub = '$id' group by kub.id_kub, nama, alamat";
    $eksekusi = pg_query($sql);
    $data = pg_fetch_assoc($eksekusi);
  }
?>

<?php startblock('title') ?>Kelompok Usaha Bersama - detail <?php echo $data['nama']; ?> <?php endblock() ?>

<?php startblock('breadcrumb-link') ?>
  <li class="breadcrumb-item"><a href="#!">Kelompok Usaha Bersama</a>
  <li class="breadcrumb-item"><a href="#!">Detail <?php echo $data['nama']; ?></a>
<?php endblock() ?>

<?php startblock('breadcrumb-title') ?>
KUB - Detail <?php echo $data['nama']; ?>
<?php endblock() ?>

<?php startblock('content') ?>
  <div class="row">
    <div class="col-lg-12 col-xl-6 col-md-12">
        <div class="card">
          <div class="table-responsive">
              <table class="table m-0">
                  <tbody>
                      <tr>
                          <th scope="row">ID KUB</th>
                          <td><?php echo $data['id_kub']; ?></td>
                      </tr>
                      <tr>
                          <th scope="row">Nama KUB</th>
                          <td><?php echo $data['nama']; ?></td>
                      </tr>
                      <tr>
                          <th scope="row">Tanggal Berdiri</th>
                          <td><?php echo $data['tgl_berdiri']; ?></td>
                      </tr>
                      <tr>
                          <th scope="row">Alamat</th>
                          <td><?php echo $data['alamat']; ?></td>
                      </tr>
                      <tr>
                          <th scope="row">Deskripsi</th>
                          <td><?php echo $data['deskripsi']; ?></td>
                      </tr>
                  </tbody>
              </table>
          </div>
        </div>
    </div>
    <div class="col-lg-12 col-xl-6 col-md-12">
      <div class="" id="mapGeo">

      </div>
      <?php include $_SERVER['DOCUMENT_ROOT'].'/tb_bdl/view/admin/kub/map.php'; ?>
    </div>
  </div>
<?php endblock() ?>
