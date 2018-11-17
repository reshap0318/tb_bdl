<?php include $_SERVER['DOCUMENT_ROOT'].'/tb_bdl/blank.php'; ?>

<?php startblock('title') ?> Jabatan <?php endblock() ?>

<?php startblock('breadcrumb-link') ?>
  <li class="breadcrumb-item">Jabatan</li>
<?php endblock() ?>

<?php startblock('breadcrumb-title') ?>
Jabatan
<?php endblock() ?>

<?php startblock('content') ?>
<div class="card">
  <div class="card-block">
      <div class="dt-responsive table-responsive">
        <?php $no=0 ?>
          <table id="table-jabatan" class="table table-striped table-bordered nowrap">
              <thead>
                  <tr>
                      <th style="width:10px">No</th>
                      <th>Nama Jabatan</th>
                      <th class="text-center">Jumlah</th>
                      <th style="width:50px">Action</th>
                  </tr>
              </thead>
              <tbody>
                <?php
                  include $_SERVER['DOCUMENT_ROOT'].'/tb_bdl/controller/koneksi.php';
                  $sql = "Select jabatan.id_jabatan as id,jabatan.id_jabatan, jabatan.nama, count(abk.id_abk) as jumlah_anggota from jabatan left join abk on jabatan.id_jabatan = abk.id_jabatan group by jabatan.id_jabatan, jabatan.nama";
                  $query = pg_query($sql);
                  $no = 0;
                  while($data =  pg_fetch_array($query)){
                ?>
                  <tr>
                      <td class="text-center"> <?php echo ++$no; ?></td>
                      <td id="nama<?php echo $data['id']; ?>"><?php echo $data['nama']; ?></td>
                      <td class="text-center"><?php echo $data['jumlah_anggota']; ?></td>
                      <td class="text-center">
                        <a href="#" class="btn btn-primary btn-mini waves-effect waves-light">Show Anggota</a>
                        <a onclick="edit(<?php echo $data['id']; ?>)" class="btn btn-warning btn-mini waves-effect waves-light">Edit</a>
                        <form id="formdelete<?php echo $data['id']; ?>" style="display:none;" action="/tb_bdl/controller/jabatancontroller.php?aksi=delete" method="post">
                          <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
                        </form>
                        <a class="btn btn-danger btn-mini waves-effect waves-light" onclick="hapus(<?php echo $data['id']; ?>)">Delete</a>
                      </td>
                  </tr>
                <?php } ?>
              </tbody>
              <tfoot>
                  <tr>
                      <th>No</th>
                      <th>Nama Jabatan</th>
                      <th class="text-center">Jumlah</th>
                      <th>Action</th>
                  </tr>
              </tfoot>
          </table>
      </div>
      <?php include $_SERVER['DOCUMENT_ROOT'].'/tb_bdl/view/admin/jabatan/mcreate.php'; ?>
      <?php include $_SERVER['DOCUMENT_ROOT'].'/tb_bdl/view/admin/jabatan/mupdate.php'; ?>
  </div>
</div>
<?php endblock() ?>

<?php startblock('table') ?>
  <!-- info lebih lanjut bisa di cek di : -->
  <!--editor/assets/pages/data-table/js/data-table-custom.js"-->
  <script type="text/javascript">
      $('#table-jabatan').DataTable(
        {
        "info":     false,
        dom: 'Bfrtip',
        buttons: [
        {
            text: 'Tambah Jabatan',
            className: 'btn-success',
            action: function(e, dt, node, config)
            {
              $("#jabatan-model-create").modal();
            }
        },
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
    function edit(id) {
      var nama = document.getElementById('nama'+id).innerHTML;
      document.getElementById('edit_nama').value = nama;
      document.getElementById('edit_id').value = id;
      $("#jabatan-model-edit").modal();
    }
    function hapus(id) {
      if(confirm('yakin ingin menghapus data ini?') == true){
        document.getElementById('formdelete'+id).submit();
      }
    }
  </script>
<?php endblock() ?>
