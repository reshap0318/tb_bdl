<?php include $_SERVER['DOCUMENT_ROOT'].'/tb_bdl/blank.php'; ?>

<?php startblock('title') ?> asraf Fungsional : 1 <?php endblock() ?>

<?php startblock('breadcrumb-link') ?>
<li class="breadcrumb-item"><a href="#!">asraf</a>
<li class="breadcrumb-item"><a href="#!">Fungsional : 1</a>
<?php endblock() ?>

<?php startblock('breadcrumb-title') ?>
asraf Fungsional : 1
<?php endblock() ?>

<?php startblock('content') ?>
<!-- menampilkan detail fungsional atau about fungsional -->
<div class="card">
    <div class="card-header">
        <h5 class="card-header-text">Description About Fungsional 1</h5>
    </div>
    <div class="card-block user-desc">
        <div class="view-desc">
            <p>Fungsional Ini Berfungsi untuk mengetahui jenis kapal berdasarkan tanggal keluar dan pemilik kapal<br>
               Sehingga Fungsional Ini dapat membantu untuk mengetahui jenis-jenis apa saja yang ada pada pelayaran dan yang dimiliki oleh pemilik<br>
               <font style="color:green">Aplikasi ini terdiri dari 7 table, yaitu jenis_kapal, jabatan, kebangsaan, kapal, pelayaran, produksi, jenis_tangkapan</font>
            </p>
        </div>
    </div>
</div>
<!-- menampilkan tombol pencarian, kalau ingin sama seperti ini, silakan rubah sqlnya, berdasarkan apanya di fungsional, dalam fungsinal ini berdasarkan jenis ika -->
<div class="card">
  <div class="card-block">
    <div class="row">
        <div class="col-sm-5 m-b-t-30">
          <select class="js-example-basic-single col-sm-12" id="pencarian1">
                <option value="">-PILIH PEMILIK-</option>
                <?php
                  include $_SERVER['DOCUMENT_ROOT'].'/tb_bdl/controller/koneksi.php';
                  $sql = "SELECT id_pemilik, nama from pemilik";
                  $eksekusi = pg_query($sql);
                  while ($data = pg_fetch_assoc($eksekusi)) {
                    echo '<option value="'.$data['id_pemilik'].'">'.$data['nama'].'</option>';
                  }
                ?>
          </select>
        </div>
        <div class="col-sm-5 m-b-t-30">
          <input id="dropper-default" class="form-control" id="pencarian2" name="pencarian" type="text" placeholder="Select your date" />
        </div>
        <div class="col-sm-2 m-b-t-30">
          <button type="button" onclick="pencarian()" class="btn btn-success btn-square btn-block" name="button">Cari</button>
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
                      <th>Jenis Kapal</th>
                      <th>Nama Kapal</th>
                      <th>Pemilik</th>
                      <th>Kode</th>
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
  <?php include $_SERVER['DOCUMENT_ROOT'].'/tb_bdl/view/asraf/fung1/map.php'; ?>

  </div>
</div>
<?php endblock() ?>

<?php startblock('table') ?>
  <script type="text/javascript">
    function format(d) {
          // `d` is the original data object for the row
          return '<table class="table table-striped table-bordered nowrap">' +
            '<tr>' +
              '<td>ID Jenis Kapal  </td>' +
              '<td>JNSKPL00' + d.id_jenis_kapal + '</td>' +
              '<td>Tanggal Masuk  </td>' +
              '<td>' + d.tanggal_masuk + '</td>' +
            '</tr>' +
            '<tr>' +
              '<td>Jenis Kapal  </td>' +
              '<td>' + d.jenis + '</td>' +
              '<td>Nama Kapal  </td>' +
              '<td>' + d.nama + '</td>' +
            '</tr>' +
            '<tr>' +
              '<td>Pemilik Kapal </td>' +
              '<td>' + d.pemilik + '</td>' +
              '<td>kode  </td>' +
              '<td>' + d.kode + '</td>' +
            '</tr>' +
            '<tr>' +
              '<td>Tanggal Keluar  </td>' +
              '<td>' + d.tanggal_keluar + '</td>' +
              '<td>Aksi</td>' +
              '<td><a href="javascript:void(0)" onclick="satupemilik('+d.id_pemilik+')" class="btn btn-primary btn-mini waves-effect waves-light"><i class="fa fa-map-pin"></i></a></td>' +
            '</tr>' +

            '</table>';
    }

    var ct = $('#table-f1').DataTable({
      //rubah bagian link ajax dan data4 , link datang dari yg dibuka/ yg akan tampil
        "ajax": 'http://localhost/tb_bdl/controller/asrafcontroller/fung1controller.php?aksi=tablef1',
        "columns": [{
                "className": 'details-control',
                "orderable": false,
                "data": null,
                "defaultContent": ''
            },
            { "data": "jenis"},
            { "data": "nama" },
            { "data": "pemilik" },
            { "data": "kode" }
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
          var select1 = document.getElementById("pencarian1");
          var select2 = document.getElementById("dropper-default");

          if(select1.selectedOptions.length==0 && select2.value==null){
            var link = 'http://localhost/tb_bdl/controller/asrafcontroller/fung1controller.php?aksi=tablef1';
          }else{
              for (var i=0; i < select1.selectedOptions.length; i++) {
                  cari.push(select1.selectedOptions[i].value);
              }
            var id1 = cari.join(",");
            var id2 = select2.value;
            var link = 'http://localhost/tb_bdl/controller/asrafcontroller/fung1controller.php?aksi=tablef1&pencarian1='+id1+'&pencarian2='+id2;
          }
          console.log(link);
          ct.ajax.url(link).load();
        }


  </script>
<?php endblock() ?>
