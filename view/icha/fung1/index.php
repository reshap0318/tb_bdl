<?php include $_SERVER['DOCUMENT_ROOT'].'/tb_bdl/blank.php'; ?>

<?php startblock('title') ?> Icha Fungsional : 1 <?php endblock() ?>

<?php startblock('breadcrumb-link') ?>
<li class="breadcrumb-item"><a href="#!">Icha</a>
<li class="breadcrumb-item"><a href="#!">Fungsional : 1</a>
<?php endblock() ?>

<?php startblock('breadcrumb-title') ?>
Icha Fungsional : 1
<?php endblock() ?>

<?php startblock('content') ?>
<!-- menampilkan detail fungsional atau about fungsional -->
<div class="card">
    <div class="card-header">
        <h5 class="card-header-text">Description About Fungsional 1</h5>
    </div>
    <div class="card-block user-desc">
        <div class="view-desc">
            <p>Fungsional Ini Berfungsi untuk mengetahui Lokasi-lokasi kecamatan beserta kabupaten kota dari usaha perikanan yang nantinya akan meliputi KUB dari usaha perikanan tersebut, jenis dari usaha perikanan, transaksi beserta detail transaksi dan juga produksi berdasarkan jenis tangkapam.<br>
               Sehingga Fungsional Ini Mempermudah atau Membantu orang - orang untuk bertanya kesumbernya(awak yang menangkap ikan tadi) seperti tentang kondisi lautan, kondisi lokasi ikan banyak, dllnya.<br>
               <font style="color:green">Aplikasi ini terdiri dari  table, yaitu table abk, jabatan, kebangsaan, kapal, pelayaran, produksi, jenis_tangkapan</font>
            </p>
        </div>
    </div>
</div>
<!-- menampilkan tombol pencarian, kalau ingin sama seperti ini, silakan rubah sqlnya, berdasarkan apanya di fungsional, dalam fungsinal ini berdasarkan jenis ika -->
<div class="card">
  <div class="card-block">
    <div class="row">
        <div class="col-sm-12">
          <div class="input-group input-group-button">
            <select name="pencarian[]" class="form-control js-example-basic-hide-search" multiple="multiple" id="pencarian">
              <?php
                include $_SERVER['DOCUMENT_ROOT'].'/tb_bdl/controller/koneksi.php';
                $sql = "SELECT id_jenis_tangkapan, nama from jenis_tangkapan";
                $eksekusi = pg_query($sql);
                while ($data = pg_fetch_assoc($eksekusi)) {
                  echo '<option value="'.$data['id_jenis_tangkapan'].'">'.$data['nama'].'</option>';
                }
              ?>
            </select>
            <button class="input-group-addon btn btn-primary" onclick="pencarian()" id="basic-addon10" type="submit"  name="cari">cari</button>
          </div>
        </div>
    </div>
  </div>
</div>
<!-- hasil pencarian -->
<!-- table hasil -->
<div class="card">
  <div class="card-block sembunyi" id="tableutama">
      <div class="dt-responsive table-responsive">
          <table id="table-f1" class="table table-striped table-bordered nowrap" style="width:100%">
              <thead>
                  <tr>
                      <th></th>
                      <th>Nama Usaha</th>
                      <th>Jenis Usaha</th>
                      <th>Nama KUB</th>
                      <th>Jenis Tangkapan</th>
                      <th>Tanggal Transaksi</th>
                  </tr>
              </thead>
          </table>
      </div>
  </div>
</div>

<div class="card">
  <div class="card-block">
  <div class="" id="map" style="width:100%; height:400px;">
  <?php include $_SERVER['DOCUMENT_ROOT'].'/tb_bdl/view/icha/fung1/map.php'; ?>
  </div>
</div>
<?php endblock() ?>

<?php startblock('table') ?>
  <script type="text/javascript">
    function format(d) {
          // `d` is the original data object for the row
          return '<table class="table table-striped table-bordered nowrap">' +
            '<tr>' +
              '<td>ID Usaha Perikanan  </td>' +
              '<td>PRKNRSP0' + d.id_usaha + '</td>' +
              '<td>Nama Usaha  </td>' +
              '<td>' + d.nama_usaha + '</td>' +
            '</tr>' +
            '<tr>' +
              '<td>Jenis Usaha  </td>' +
              '<td>' + d.jenis_usaha + '</td>' +
              '<td>Nama KUB  </td>' +
              '<td>' + d.nama_kub + '</td>' +
            '</tr>'+
            '<tr>'+
              '<td>Jenis Tangkapan  </td>' +
              '<td>'+ d.jenis +'</td>' +
              '<td>Tanggal Transaksi  </td>' +
              '<td>'+ d.tanggal +'</td>' +
            '</tr>'+
            '<tr>'+
              '<td></td>' +
              '<td></td>' +
              '<td>Aksi</td>' +
              '<td><a href="javascript:void(0)" onclick="satuusaha('+d.id_usaha+')" class="btn btn-primary btn-mini waves-effect waves-light"><i class="fa fa-map-pin"></i></a></td>' +
            '</tr>' +
            '</table>';
    }

    var ct = $('#table-f1').DataTable({
        "ajax": 'http://localhost/tb_bdl/controller/ichacontroller/fung1controller.php?aksi=tablef1',
        "columns": [{
                "className": 'details-control',
                "orderable": false,
                "data": null,
                "defaultContent": ''
            },
            { "data": "nama_usaha"},
            { "data": "jenis_usaha" },
            { "data": "nama_kub" },
            { "data": "jenis_tangkapan" },
            { "data": "tanggal" },
        ],
        "order": [
            [1, 'asc']
        ],
        "info":     false,
        "searchable": false,
        "searching": false,
        "lengthChange": false
    });

    // Add event listener for opening and closing details
    $('#table-f1 tbody').on('click', 'td.details-control', function() {
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


        function pencarian() {
          var cari = [];
          var select = document.getElementById("pencarian");
          if(select.selectedOptions.length==0){
            var link = 'http://localhost/tb_bdl/controller/ichacontroller/fung1controller.php?aksi=tablef1';
          }else{
              for (var i=0; i < select.selectedOptions.length; i++) {
                  cari.push(select.selectedOptions[i].value);
              }
            document.getElementById("tableutama").classList.remove('sembunyi');
            var id = cari.join(",");
            var link = 'http://localhost/tb_bdl/controller/ichacontroller/fung1controller.php?aksi=tablef1&pencarian='+id;
          }
          console.log(link);
          ct.ajax.url(link).load();
        }


  </script>
<?php endblock() ?>
