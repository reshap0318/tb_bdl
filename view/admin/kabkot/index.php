<?php include $_SERVER['DOCUMENT_ROOT'].'/tb_bdl/blank.php'; ?>

<?php startblock('title') ?> Kabupaten Kota <?php endblock() ?>

<?php startblock('breadcrumb-link') ?>
<li class="breadcrumb-item"><a href="#!">Kabupaten Kota</a>
<?php endblock() ?>

<?php startblock('breadcrumb-title') ?>
Kabupaten Kota
<?php endblock() ?>

<?php startblock('content') ?>

<div class="card">
  <div class="card-block">
      <div class="dt-responsive table-responsive">
        <?php $no=0 ?>
          <table id="table-kabkot" class="table table-striped table-bordered nowrap">
              <thead>
                  <tr>
                      <th style="width:10px">No</th>
                      <th>Kabupaten</th>
                      <th style="width:50px">Action</th>
                  </tr>
              </thead>
              <tbody>
                <?php
                  include $_SERVER['DOCUMENT_ROOT'].'/tb_bdl/controller/koneksi.php';
                  $sql = "Select id_kabkot as id, nama from kabkota";
                  $query = pg_query($sql);
                  $no = 0;
                  while($data =  pg_fetch_array($query)){
                ?>
                  <tr>
                      <td class="text-center"> <?php echo ++$no; ?></td>
                      <td><?php echo $data['nama']; ?></td>
                      <td class="text-center">
                        <a class="btn btn-primary btn-mini waves-effect waves-light" onclick="pin(<?php echo $data['id']; ?>)" ><i class="fa fa-map-pin"></i></a>
                        <a class="btn btn-warning btn-mini waves-effect waves-light"><i class="fa fa-edit"></i></a>
                        <a class="btn btn-danger btn-mini waves-effect waves-light" onclick="hapus(<?php echo $data['id']; ?>)"><i class="fa fa-trash"></i></a>
                      </td>
                  </tr>
                <?php } ?>
              </tbody>
          </table>
      </div>
  </div>
</div>


<form id="formdelete" style="display:none;" action="/tb_bdl/controller/kabkotcontroller.php?aksi=delete" method="post">
  <input type="hidden" name="id_kabkot" value="" id="id_delete">
</form>

<a href="/tb_bdl/view/admin/kabkot/create.php" class="btn btn-out-dashed btn-info btn-square btn-block">Tambah Kabupaten Kota</a>


<div class="card">
    <div class="card-block">
        <div id="mapGeo" style="height:600px"></div>
    </div>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'].'/tb_bdl/view/admin/kabkot/map.php'; ?>

<?php endblock() ?>

<?php startblock('table') ?>
  <!-- info lebih lanjut bisa di cek di : -->
  <!--editor/assets/pages/data-table/js/data-table-custom.js"-->
  <script type="text/javascript">
      $('#table-kabkot').DataTable(
        {
        "info":     false,
        dom: 'Bfrtip',
        buttons: [
        {
            extend: 'copy',
            className: 'btn-inverse',
            exportOptions: {
                columns: [0, 1]
            }
        },
        {
            extend: 'print',
            className: 'btn-inverse',
            exportOptions: {
                columns: [0, 1]
            }
        },
        {
            extend: 'excel',
            className: 'btn-inverse',
            exportOptions: {
                columns: [0, 1]
            }
        },
        {
            extend: 'pdf',
            className: 'btn-inverse',
            exportOptions: {
                columns: [0, 1]
            }
        }]
      });
  </script>

  <script type="text/javascript">
    function hapus(id) {
      if(confirm('yakin ingin menghapus data ini?') == true){
        console.log(id);
        document.getElementById('id_delete').value = id;
        document.getElementById('formdelete').submit();
      }
    }
  </script>
<?php endblock() ?>
