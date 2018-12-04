<?php include $_SERVER['DOCUMENT_ROOT'].'/tb_bdl/blank.php'; ?>

<?php startblock('title') ?> Murda Fungsional : 2 <?php endblock() ?>

<?php startblock('breadcrumb-link') ?>
<li class="breadcrumb-item"><a href="#!">Murda</a>
<li class="breadcrumb-item"><a href="#!">Fungsional : 2</a>
<?php endblock() ?>

<?php startblock('breadcrumb-title') ?>
Murda Fungsional : 2
<?php endblock() ?>

<?php startblock('content') ?>
<!-- menampilkan detail fungsional atau about fungsional -->
<div class="card">
    <div class="card-header">
        <h5 class="card-header-text">Description About Fungsional 2</h5>
    </div>
    <div class="card-block user-desc">
        <div class="view-desc">
            <p>fungsional : Menampilkan Pemilik Kapal yang meliputi, id_pemilik, nama, tgl_lahir, agama, pendidikan, kapal pemilik, jenis, jumlah abk yang berangkat, jumlah_alat_tangkap  Berdasarkan Tanggal Pelayaran <br>
               Sehingga Fungsional Ini Mempermudah atau Membantu orang - orang untuk bertanya kesumbernya(awak yang menangkap ikan tadi) seperti tentang kondisi lautan, kondisi lokasi ikan banyak, dllnya.<br>
               <font style="color:green">Aplikasi ini terdiri dari 8 table, yaitu pemilik, kepemilikan_kapal, kapal, jenis_kapal, alat_tangkap_kapal, alat_tangkap, pelayaran, keterangan_pelayaran_abk</font>
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
          <input id="dropper-default" class="form-control" id="pencarian" name="pencarian" type="text" placeholder="Select your date" />
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
          <table id="table-f2" class="table table-striped table-bordered nowrap" style="width:100%">
              <thead>
                  <tr>
                      <th></th>
                      <th>Nama Pemilik</th>
                      <th>Kapal</th>
                      <th>Jenis Kapal</th>
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
  <?php include $_SERVER['DOCUMENT_ROOT'].'/tb_bdl/view/murda/fung2/map.php'; ?>

  </div>
</div>
<?php endblock() ?>

<?php startblock('table') ?>
  <script type="text/javascript">
    function format(d) {
          // `d` is the original data object for the row
          return '<table class="table table-striped table-bordered nowrap">' +
            '<tr>' +
            '<td>Nama Pemilik  </td>' +
            '<td>' + d.nama + '</td>' +
            '<td>Kapal  </td>' +
            '<td>' + d.kapal + '</td>' +
            '</tr>' +
            '<tr>' +
            '<td>Tanggal Lahir  </td>' +
            '<td>' + d.tgl_lahir + '</td>' +
            '<td>Jenis Kapal  </td>' +
            '<td>' + d.jenis + '</td>' +
            '</tr>' +
            '<tr>' +
            '<td>Agama</td>' +
            '<td>' + d.agama + '</td>' +
            '<td>Jumlah ABK</td>' +
            '<td>' + d.jabk + ' Orang</td>' +
            '</tr>' +
            '<tr>' +
            '<td>Pendidikan  </td>' +
            '<td>' + d.pendidikan + '</td>' +
            '<td>Jumlah Alat Tangkap  </td>' +
            '<td>' + d.jalat + ' Buah</td>' +
            '</tr>' +
            '<tr>' +
            '<td>AKSI</td>' +
            '<td><a href="javascript:void(0)" onclick="satupemilik('+d.id_pemilik+')" class="btn btn-primary btn-mini waves-effect waves-light"><i class="fa fa-map-pin"></i></a></td>' +
            '<td></td>' +
            '<td></td>' +
            '</tr>' +
            '</table>';
    }

    var ct = $('#table-f2').DataTable({
        "ajax": 'http://localhost/tb_bdl/controller/murdacontroller/fung2controller.php?aksi=tablef2',
        "columns": [{
                "className": 'details-control',
                "orderable": false,
                "data": null,
                "defaultContent": ''
            },
            { "data": "nama"},
            { "data": "kapal" },
            { "data": "jenis" }
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
    $('#table-f2 tbody').on('click', 'td.details-control', function() {
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
      var select = document.getElementById("dropper-default");
      console.log(select.value);
      if(select.value==null){
        var link = 'http://localhost/tb_bdl/controller/murdacontroller/fung2controller.php?aksi=tablef2';
      }else{
        var link = 'http://localhost/tb_bdl/controller/murdacontroller/fung2controller.php?aksi=tablef2&pencarian='+select.value;
      }
      semuapemilik();
      console.log(link);
      ct.ajax.url(link).load();
    }


  </script>
<?php endblock() ?>
