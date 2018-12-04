<?php include $_SERVER['DOCUMENT_ROOT'].'/tb_bdl/blank.php'; ?>

<?php startblock('title') ?> asraf Fungsional : 3 <?php endblock() ?>

<?php startblock('breadcrumb-link') ?>
<li class="breadcrumb-item"><a href="#!">asraf</a>
<li class="breadcrumb-item"><a href="#!">Fungsional : 3</a>
<?php endblock() ?>

<?php startblock('breadcrumb-title') ?>
asraf Fungsional : 3
<?php endblock() ?>

<?php startblock('content') ?>
<!-- menampilkan detail fungsional atau about fungsional -->
<div class="card">
    <div class="card-header">
        <h5 class="card-header-text">Description About Fungsional 3</h5>
    </div>
    <div class="card-block user-desc">
        <div class="view-desc">
            <p>Fungsional Ini Berfungsi untuk mengetahui kapal apa saja dan akan ditampilkan berdasarkan KUB tertentu beserta jenis tangkapannya<br>
               jadi pengguna dapat dengan mudah mengetahui detail kapal-kapal berdasarkan KUB nya<br>
               <font style="color:green">Aplikasi ini terdiri dari 7 table, yaitu table kapal, pelayaran, produksi,jenis_tangkapan, detail_transaksi, transaksi, dan KUB</font>
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
                $sql = "SELECT id_kub, nama from kub";
                $eksekusi = pg_query($sql);
                while ($data = pg_fetch_assoc($eksekusi)) {
                  echo '<option value="'.$data['id_kub'].'">'.$data['nama'].'</option>';
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
          <table id="table-f1" class="table table-striped table-bordered nowrap" style="width:100%">
              <thead>
                  <tr>
                      <th></th>
                      <th>Nama Kapal</th>
                      <th>Tujuan</th>
                      <th>ID KUB</th>
                      <th>NAMA KUB</th>
                  </tr>
              </thead>
          </table>
      </div>
  </div>
</div>

<div class="card">
  <div class="card-block">
    <!-- <a href="javascript:void(0)" class="btn btn-info" role="button" data-toggle="collapse" onclick="aktifkanGeolocation()" title="Current Position"><i class="icofont icofont-social-google-map"></i></a>
    <a href="javascript:void(0)" class="btn btn-info" role="button" data-toggle="collapse" onclick="manualLocation()" title=" Manual Position"><i class="icofont icofont-location-arrow"></i></a>
    <a class="btn btn-info" role="button" data-toggle="collapse" href="#terdekat" title="Nearby" aria-controls="terdekat"><i class="icofont icofont-road"></i></a>
    <label></label>
    <div class="collapse" id="terdekat">
      <div class="well">
        <label><b>Radius&nbsp</b></label><label style="color:black" id="km"><b>0</b></label>&nbsp<label><b>m</b></label><br>
        <input  type="range" onclick="cek();aktifkanRadius();resultt()" id="inputradiusmes" name="inputradiusmes" data-highlight="true" min="1" max="20" value="1" class="form-control">
      </div>
    </div>
  </div> -->

  <div class="" id="map" style="width:100%; height:400px;">
  <?php include $_SERVER['DOCUMENT_ROOT'].'/tb_bdl/view/asraf/fung3/map.php'; ?>

  </div>
</div>
<?php endblock() ?>

<?php startblock('table') ?>
  <script type="text/javascript">
    function format(d) {
          // `d` is the original data object for the row
          return '<table class="table table-striped table-bordered nowrap">' +
            '<tr>' +
            '<td>Nama Kapal</td>' +
            '<td>' + d.nama_kapal + '</td>' +
            '<td>Tujuan  </td>' +
            '<td>' + d.tujuan + '</td>' +
            '</tr>' +
            '<tr>' +
            '<td>ID KUB  </td>' +
            '<td>IKB00' + d.id_kub + '</td>' +
            '<td>Nama KUB  </td>' +
            '<td>' + d.nama + '</td>' +
            '</tr>' +
            '<tr>' +
            '<td>Tanggal Berdiri  </td>' +
            '<td>'+ d.tgl_berdiri +'</td>' +
            '<td>Alamat  </td>' +
            '<td>'+ d.alamat +'</td>' +
            '</tr>' +
            '<tr>' +
            '<td>Jenis Tangkapan  </td>' +
            '<td>'+ d.nama_jenis +'</td>' +
            '<td>Aksi</td>' +
            '<td><a href="javascript:void(0)" onclick="satukub('+d.id_kub+')" class="btn btn-primary btn-mini waves-effect waves-light"><i class="fa fa-map-pin"></i></a></td>' +
            '</tr>' +
            '</table>';
    }

    var ct = $('#table-f1').DataTable({
        "ajax": 'http://localhost/tb_bdl/controller/asrafcontroller/fung3controller.php?aksi=tablef1',
        "columns": [{
                "className": 'details-control',
                "orderable": false,
                "data": null,
                "defaultContent": ''
            },
            { "data": "nama_kapal"},
            { "data": "tujuan" },
            { "data": "id_kub" },
            { "data": "nama" }
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
            var link = 'http://localhost/tb_bdl/controller/asrafcontroller/fung3controller.php?aksi=tablef1';
          }else{
              for (var i=0; i < select.selectedOptions.length; i++) {
                  cari.push(select.selectedOptions[i].value);
              }
            var id = cari.join(",");
            var link = 'http://localhost/tb_bdl/controller/asrafcontroller/fung3controller.php?aksi=tablef1&pencarian='+id;
          }
          console.log(link);
          ct.ajax.url(link).load();
        }


  </script>
<?php endblock() ?>
