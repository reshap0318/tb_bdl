<?php include $_SERVER['DOCUMENT_ROOT'].'/tb_bdl/blank.php'; ?>

<?php startblock('title') ?> Kelompok Usaha Bersama <?php endblock() ?>

<?php startblock('breadcrumb-link') ?>
<li class="breadcrumb-item"><a href="#!">Kelompok Usaha Bersama</a>
<?php endblock() ?>

<?php startblock('breadcrumb-title') ?>
Kelompok Usaha Bersama
<?php endblock() ?>

<?php startblock('content') ?>
<div class="card">
  <div class="card-block">
      <div class="dt-responsive table-responsive">
          <table id="table-kub" class="table table-striped table-bordered nowrap" style="width:100%">
              <thead>
                  <tr>
                      <th style="width:20px" class="text-center">NO</th>
                      <th>Nama</th>
                      <th>Jumlah Usaha</th>
                      <th>Alamat</th>
                      <th style="width:100px">Action</th>
                  </tr>
              </thead>
              <tbody>
                <?php $no=0;
                  include $_SERVER['DOCUMENT_ROOT'].'/tb_bdl/controller/koneksi.php';
                  $sql = "select kub.id_kub, nama, alamat, count(usaha_perikanan.*) as jumlahusaha from kub left join usaha_perikanan on kub.id_kub = usaha_perikanan.id_kub group by kub.id_kub, nama, alamat";
                  $eksekusi = pg_query($sql);
                  while ($data = pg_fetch_assoc($eksekusi)) {
                ?>
                  <tr>
                      <td style="width:20px" class="text-center"><?php echo ++$no;?></td>
                      <td><?php echo $data['nama'];?></td>
                      <td><?php echo $data['jumlahusaha']?></td>
                      <td><?php echo $data['alamat']?></td>
                      <td style="width:100px">
                        <a href="/tb_bdl/view/admin/kub/detail.php?id=<?php echo $data['id_kub']; ?>" class="btn btn-primary btn-mini waves-effect waves-light">Show Detail</a>
                        <a href="/tb_bdl/view/admin/kub/edit.php?id=<?php echo $data['id_kub']; ?>" class="btn btn-primary btn-mini waves-effect waves-light">Edit</a>
                        <a href="#" class="btn btn-danger btn-mini waves-effect waves-light" onclick="hapus(<?php echo $data['id_kub']; ?>)">Delete</a>
                      </td>
                  </tr>
                <?php } ?>
              </tbody>
          </table>
<form class="" id="formdelete" style="display:none" action="/tb_bdl/controller/kubcontroller.php?aksi=delete" method="post">
  <input type="text" name="id" value="" id="delete_id">
</form>
      </div>
  </div>
</div>
<?php endblock() ?>

<?php startblock('table') ?>
  <!-- info lebih lanjut bisa di cek di : -->
  <!--editor/assets/pages/data-table/js/data-table-custom.js"-->
  <script type="text/javascript">
      $('#table-kub').DataTable(
        {
        "info":     false,
        dom: 'Bfrtip',
        buttons: [
        {
            text: 'Tambah KUB',
            className: 'btn-success',
            action: function(e, dt, node, config)
            {
              window.location.assign("http://localhost/tb_bdl/view/admin/kub/create.php");
            }
        },
        {
            extend: 'copy',
            className: 'btn-inverse',
            exportOptions: {
                columns: [0, 1, 2, 3]
            }
        },
        {
            extend: 'print',
            className: 'btn-inverse',
            exportOptions: {
                columns: [0, 1, 2, 3]
            }
        },
        {
            extend: 'excel',
            className: 'btn-inverse',
            exportOptions: {
                columns: [0, 1, 2, 3]
            }
        },
        {
            extend: 'pdf',
            className: 'btn-inverse',
            exportOptions: {
                columns: [0, 1, 2, 3]
            }
        }]
      });
  </script>

  <script type="text/javascript">
    function hapus(id) {
      if(confirm('yakin ingin menghapus data ini?') == true){
        document.getElementById('delete_id').value = id;
        document.getElementById('formdelete').submit();
      }
    }
  </script>
<?php endblock() ?>
