<?php include $_SERVER['DOCUMENT_ROOT'].'/tb_bdl/blank.php'; ?>

<?php startblock('title') ?> Kapal <?php endblock() ?>

<?php startblock('breadcrumb-link') ?>
<li class="breadcrumb-item"><a href="#!">Kapal</a>
<?php endblock() ?>

<?php startblock('breadcrumb-title') ?>
Kapal
<?php endblock() ?>

<?php startblock('content') ?>
<div class="card">
  <div class="card-block">
      <div class="dt-responsive table-responsive">
          <table id="table-kapal" class="table table-striped table-bordered nowrap" style="width:100%">
              <thead>
                  <tr>
                      <th></th>
                      <th style="width:20px">id</th>
                      <th>Nama Kapal</th>
                      <th>jenis Kapal</th>
                      <th>Pemilik Kapal</th>
                      <!-- <th>Jumlah Abk</th>
                      <th>Jumlah Alat Tangkap</th>
                      <th>Tenda Selar</th>
                      <th>Mesin</th>
                      <th>Panjang</th>
                      <th>Berat Kotor</th> -->
                      <th style="width:100px">Action</th>
                  </tr>
              </thead>
          </table>
      </div>
  </div>
</div>
<form class="" id="formdelete" style="display:none" action="/tb_bdl/controller/kapalcontroller.php?aksi=delete" method="post">
<input type="text" id="id_delete" name="id" value="">
</form>
<?php endblock() ?>

<?php startblock('table') ?>
  <!-- info lebih lanjut bisa di cek di : -->
  <!--editor/assets/pages/data-table/js/data-table-custom.js"-->
  <script type="text/javascript">
    function format(d) {
          // `d` is the original data object for the row
          return '<table class="table table-striped table-bordered nowrap">' +
            '<tr>' +
            '<td>ID KAPAL  </td>' +
            '<td>' + d.id_kapal + '</td>' +
            '<td>Jumlah Anak Buah Kapal  </td>' +
            '<td>' + d.jabk + ' Orang </td>' +
            '</tr>' +
            '<tr>' +
            '<td>Nama Kapal  </td>' +
            '<td>' + d.namakapal + '</td>' +
            '<td>Jumlah Alat Tangkap  </td>' +
            '<td>' + d.jalat + ' Buah </td>' +
            '</tr>' +
            '<tr>' +
            '<td>Jenis Kapal  </td>' +
            '<td>'+ d.jenis +'</td>' +
            '<td>Tanda Selar  </td>' +
            '<td>' + d.tanda_selar + '</td>' +
            '</tr>' +
            '<tr>' +
            '<td>Pemilik  </td>' +
            '<td>'+ d.pemilik +'</td>' +
            '<td>Panjang  </td>' +
            '<td>' + d.panjang + ' M </td>' +
            '</tr>' +
            '<tr>' +
            '<td>Mesin  </td>' +
            '<td>'+ d.mesin +'</td>' +
            '<td>Berat Kotor  </td>' +
            '<td>' + d.berat_kotor + ' Kg</td>' +
            '</tr>' +
            '</table>';
    }

    var ct = $('#table-kapal').DataTable({
        "ajax": "http://localhost/tb_bdl/controller/kapalcontroller.php?aksi=table",
        "columns": [{
                "className": 'details-control',
                "orderable": false,
                "data": null,
                "defaultContent": ''
            },
            { "data": "id_kapal"},
            { "data": "namakapal" },
            { "data": "jenis" },
            { "data": "pemilik" },
            { defaultContent: '<div class="dropdown-info dropdown open">' +
            '<button class="btn btn-primary btn-mini waves-effect waves-light " type="button" id="dropdown-4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><i class="icofont icofont-ui-settings"></i> Actions</button>' +
            '<div class="dropdown-menu" aria-labelledby="dropdown-4" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">' +
            '<a class="dropdown-item btn btn-primary btn-mini waves-effect waves-light" id="addabk" href="#">Tambah Anak Buah Kapal</a>' +
            '<a class="dropdown-item btn btn-primary btn-mini waves-effect waves-light" id="addatk" href="#">Tambah Alat Tangkap Kapal</a>' +
            '<a class="dropdown-item btn btn-primary btn-mini waves-effect waves-light" id="addpemilik" href="#">Tambah Pemilik</a>' +
            '<a class="dropdown-item btn btn-primary btn-mini waves-effect waves-light" id="edit" href="#">Edit</a>' +
            '<a class="dropdown-item btn btn-danger btn-mini waves-effect waves-light" id="hapus" href="#">Hapus</a>' +
            '</div>'+
            '  </div>' }
        ],
        "columnDefs": [
            {
                "targets": [ 1 ],
                "searchable": false,
                "orderable": false
            }
        ],
        "order": [
            [2, 'asc']
        ],
        "info":     false,
        dom: 'Bfrtip',
        buttons: [
        {
            text: 'Tambah Kapal',
            className: 'btn-success',
            action: function(e, dt, node, config)
            {
              window.location.assign("http://localhost/tb_bdl/view/admin/kapal/create.php");
            }
        },
        {
            extend: 'copy',
            className: 'btn-inverse',
            exportOptions: {
                columns: [2, 3, 4]
            }
        },
        {
            extend: 'print',
            className: 'btn-inverse',
            exportOptions: {
                columns: [2, 3, 4]
            }
        },
        {
            extend: 'excel',
            className: 'btn-inverse',
            exportOptions: {
                columns: [2, 3, 4]
            }
        },
        {
            extend: 'pdf',
            className: 'btn-inverse',
            exportOptions: {
                columns: [2, 3, 4]
            }
        }]
    });

    // Add event listener for opening and closing details
    $('#table-kapal tbody').on('click', 'td.details-control', function() {
        var tr = $(this).closest('tr');
        var row = ct.row(tr);

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child(format(row.data())).show();
            tr.addClass('shown');
        }
    });

    $('#table-kapal tbody').on( 'click', '#edit', function () {
          var datanya = $(this).closest("tr")[0];
          console.log( datanya.children[1].innerHTML );
          window.location.href = '/tb_bdl/view/admin/kapal/edit.php?id='+datanya.children[1].innerHTML;
      } );

    $('#table-kapal tbody').on( 'click', '#hapus', function () {
        if(confirm('Apakah Anda Ingin Menghapus Data Kapal Ini?') == true){
          var datanya = $(this).closest("tr")[0];
          console.log( datanya.children[1].innerHTML );
          document.getElementById("id_delete").value= datanya.children[1].innerHTML;
          document.getElementById("formdelete").submit();
          // console.log( document.getElementById("id_delete").value);
        }
      } );

  </script>
<?php endblock() ?>
