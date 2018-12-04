<?php include $_SERVER['DOCUMENT_ROOT'].'/tb_bdl/blank.php'; ?>

<?php startblock('title') ?> Aldo Fungsional : 4 <?php endblock() ?>

<?php startblock('breadcrumb-link') ?>
<li class="breadcrumb-item"><a href="#!">Aldo</a>
<li class="breadcrumb-item"><a href="#!">Fungsional : 4</a>
<?php endblock() ?>

<?php startblock('breadcrumb-title') ?>
Aldo Fungsional : 4
<?php endblock() ?>

<?php startblock('content') ?>
<!-- menampilkan detail fungsional atau about fungsional -->
<div class="card">
    <div class="card-header">
        <h5 class="card-header-text">Description About Fungsional 4</h5>
    </div>
    <div class="card-block user-desc">
        <div class="view-desc">
            <p>Fungsional : Menampilkan detail pelayaran seperti lokasi pelabuhan, tanggal masuk, dan keluar, administrasi, tujuan, tanggal keluar, lokasi pelayaran, keterangan kapal, mencangkup pemilik dan jenis kapal, serta kub yang pergi dalam pelayaran tertentu mencangkup nama, kebangsaan, jabatan, sertifikat, lokasi rumah, tgl lahir, agama, pendidikan berdasarkan alat tangkap<br>
               <br>
               <font style="color:green">Aplikasi ini terdiri dari 12 table, yaitu table alat_tangkap, alat_tangap_kapal, kapal, jenis_kapal, kepemilikan_kapal, pemilik, pelayaran, pelabuhan, keterangan_pelayaran_abk, abk, kebangsaan, jabatan</font>
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
              $sql = "SELECT id_alat_tangkap, nama from alat_tangkap";
              $eksekusi = pg_query($sql);
              while ($data = pg_fetch_assoc($eksekusi)) {
                echo '<option value="'.$data['id_alat_tangkap'].'">'.$data['nama'].'</option>';
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
  <div class="card-block">
      <div class="dt-responsive table-responsive">
          <table id="table-f4" class="table table-striped table-bordered nowrap" style="width:100%">
              <thead>
                  <tr>
                      <th></th>
                      <th>Tanggal Keluar</th>
                      <th>Kapal</th>
                      <th>Tujuan</th>
                      <th>Pelabuhan</th>
                  </tr>
              </thead>
          </table>
      </div>
  </div>
</div>

<div class="card">
  <div class="card-block">
  <div class="sembunyi" id="map" style="width:100%; height:400px;">
  <?php include $_SERVER['DOCUMENT_ROOT'].'/tb_bdl/view/aldo/fung4/map.php'; ?>
  </div>
</div>
<div class="card">
    <div class="sembunyi"  id="table_abk"></div>
    <div class="sembunyi"  id="table_pemilik"></div>
</div>
<?php endblock() ?>

<?php startblock('table') ?>
  <script type="text/javascript">
    function format(d) {
          // `d` is the original data object for the row
          return '<table class="table table-striped table-bordered nowrap">' +
              '<tr>' +
                '<td>ID Pelayaran </td>' +
                '<td>PELRSP0' + d.id_pelayaran + '</td>' +
                '<td>ID Kapal</td>' +
                '<td>KPLRSP0' + d.id_kapal + '</td>' +
              '</tr>' +
              '<tr>' +
                '<td>Tanggal Keluar </td>' +
                '<td>' + d.tanggal_keluar + '</td>' +
                '<td>Kapal</td>' +
                '<td>' + d.kapal + '</td>' +
              '</tr>' +
              '<tr>' +
                '<td>Tanggal Masuk</td>' +
                '<td>' + tglnull(d.tanggal_masuk) + '</td>' +
                '<td>Jenis Kapal</td>' +
                '<td>' + d.jenis + '</td>' +
              '</tr>' +
              '<tr>' +
                '<td>Administrasi</td>' +
                '<td>'+ d.administrasi +'</td>' +
                '<td>Pelabuhan Berangkat</td>' +
                '<td>' + d.pelabuhan + '</td>' +
              '</tr>' +
              '<tr>' +
                '<td>Tujuan</td>' +
                '<td>'+ d.tujuan +'</td>' +
                '<td>Jumlah Pemilik Kapal</td>' +
                '<td>' + d.jumlah_pemilik + '</td>' +
              '</tr>' +
              '<tr>' +
                '<td>Jumlah ABK yang Berlayar</td>' +
                '<td>'+ d.jumlah_abk_pergi +'</td>' +
                '<td>Aksi</td>' +
                '<td>'+
                  '<a href="#map" onclick="daerahpelayaran('+d.id_pelayaran+')" class="btn btn-primary btn-mini waves-effect waves-light" data-toggle="tooltip" data-placement="bottom" title="Lokasi Pelayaran"><i class="fa fa-map-pin" ></i></a>'+
                  '<a href="#abk" onclick="cariabk('+d.id_kapal+')" class="btn btn-primary btn-mini waves-effect waves-light" data-toggle="tooltip" data-placement="top" title="detail ABK"><i class="fa fa-group"></i></a>'+
                  '<a href="#pemilik" onclick="caripemilik('+d.id_kapal+')" class="btn btn-primary btn-mini waves-effect waves-light" data-toggle="tooltip" data-placement="top" title="Detail Transaksi"><i class="fa fa-money"></i></a>'+
                '</td>' +
              '</tr>' +
            '</table>';
    }

    var ct = $('#table-f4').DataTable({
        "ajax": 'http://localhost/tb_bdl/controller/aldocontroller/fung4controller.php?aksi=tablef4',
        "columns": [{
                "className": 'details-control',
                "orderable": false,
                "data": null,
                "defaultContent": ''
            },
            { "data": "tanggal_keluar"},
            { "data": "kapal"},
            { "data": "tujuan"},
            { "data": "pelabuhan"}
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
    $('#table-f4 tbody').on('click', 'td.details-control', function() {
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

    function tglnull(tgl) {
      if(tgl==null){
        tgl = 'Belum Kembali Dari Pelayaran';
      }
      return tgl;
    }

    function pencarian() {
      var cari = [];
      var select = document.getElementById("pencarian");
      if(select.selectedOptions.length==0){
        var link = 'http://localhost/tb_bdl/controller/aldocontroller/fung4controller.php?aksi=tablef4';
      }else{
          for (var i=0; i < select.selectedOptions.length; i++) {
              cari.push(select.selectedOptions[i].value);
          }
        var id = cari.join(",");
        var link = 'http://localhost/tb_bdl/controller/aldocontroller/fung4controller.php?aksi=tablef4&pencarian='+id;
      }
      console.log(link);
      ct.ajax.url(link).load();
    }

    function tableabk() {
      document.getElementById('table_abk').classList.remove("sembunyi");
      var table = '<div class="card-block"><div class="dt-responsive table-responsive">'+
      '<table class="table table-striped table-bordered nowrap" id="abk" style="width:100%">' +
        '<thead>'+
          '<tr>' +
            '<th>id</th>' +
            '<th>Nama</th>' +
            '<th>Kebangsaan</th>' +
            '<th>Jabatan</th>' +
            '<th>Aksi</th>' +
          '</tr>' +
        '</thead>'+
      '</table>'+
        '</div></div>';
      document.getElementById("table_abk").innerHTML = table;
    }

    function cariabk(id) {
      document.getElementById('table_pemilik').classList.add("sembunyi");
      document.getElementById('map').classList.add("sembunyi");
      tableabk();
      console.log('http://localhost/tb_bdl/controller/aldocontroller/fung4controller.php?aksi=tableabk&pencarian='+id);
      var tbabk = $('#abk').DataTable({
          "ajax": 'http://localhost/tb_bdl/controller/aldocontroller/fung4controller.php?aksi=tableabk&pencarian='+id,
          "columns": [
              { "data": "id_abk"},
              { "data": "nama"},
              { "data": "kebangsaan" },
              { "data": "jabatan" },
              { defaultContent: '<a href="#map" onclick="lokasiabk()" id="lokasiabk" class="btn btn-primary btn-mini waves-effect waves-light" data-toggle="tooltip" data-placement="bottom" title="Rumah ABK yang di cari"><i class="fa fa-map-pin" ></i></a>' }
          ],
          "order": [
              [0, 'asc']
          ],
          "info":     false,
          "searchable": false,
          "searching": false,
          "lengthChange": false
      });
    }

    function tablepemilik() {
      document.getElementById('table_pemilik').classList.remove("sembunyi");
      var table = '<div class="card-block"><div class="dt-responsive table-responsive">'+
      '<table class="table table-striped table-bordered nowrap" id="pemilik" style="width:100%">' +
        '<thead>'+
          '<tr>' +
            '<th>id</th>' +
            '<th>Nama</th>' +
            '<th>Tanggal Lahir</th>' +
            '<th>Agama</th>' +
            '<th>Pendidikan</th>' +
            '<th>Aksi</th>' +
          '</tr>' +
        '</thead>'+
      '</table>'+
        '</div></div>';
      document.getElementById("table_pemilik").innerHTML = table;
    }

    function caripemilik(id) {
      document.getElementById('table_abk').classList.add("sembunyi");
      document.getElementById('map').classList.add("sembunyi");
      tablepemilik();
      console.log('http://localhost/tb_bdl/controller/aldocontroller/fung4controller.php?aksi=tablepemilik&pencarian='+id);
      var tbabk = $('#pemilik').DataTable({
          "ajax": 'http://localhost/tb_bdl/controller/aldocontroller/fung4controller.php?aksi=tablepemilik&pencarian='+id,
          "columns": [
              { "data": "id_pemilik"},
              { "data": "nama"},
              { "data": "tgl_lahir" },
              { "data": "agama" },
              { "data": "pendidikan" },
              { defaultContent: '<a href="#map" onclick="lokasipemilik()" id="lokasipemilik" class="btn btn-primary btn-mini waves-effect waves-light" data-toggle="tooltip" data-placement="bottom" title="Rumah ABK yang di cari"><i class="fa fa-map-pin" ></i></a>' }
          ],
          "order": [
              [0, 'asc']
          ],
          "info":     false,
          "searchable": false,
          "searching": false,
          "lengthChange": false
      });
    }
  </script>
<?php endblock() ?>
