<?php include $_SERVER['DOCUMENT_ROOT'].'/tb_bdl/blank.php'; ?>

<?php startblock('title') ?> asraf Fungsional : 5 <?php endblock() ?>

<?php startblock('breadcrumb-link') ?>
<li class="breadcrumb-item"><a href="#!">asraf</a>
<li class="breadcrumb-item"><a href="#!">Fungsional : 5</a>
<?php endblock() ?>

<?php startblock('breadcrumb-title') ?>
asraf Fungsional : 5
<?php endblock() ?>

<?php startblock('content') ?>
<!-- menampilkan detail fungsional atau about fungsional -->
<div class="card">
    <div class="card-header">
        <h5 class="card-header-text">Description About Fungsional 5</h5>
    </div>
    <div class="card-block user-desc">
        <div class="view-desc">
            <p>Fungsional Ini Berfungsi untuk mengetahui detail pemilik kapal dengan menampilkan kecamatan pemilik kapal tertentu<br>
               Sehingga Fungsional Ini Mempermudah mengetahui berapakah pemilik kapal dikecamatan tertentu<br>
               <font style="color:green">Aplikasi ini terdiri dari 6 table, yaitu pemilik kapal, kepemilikan kapal, kapal , abk, kebangsaan dan kecamatan</font>
            </p>
        </div>
    </div>
</div>
<!-- menampilkan tombol pencarian, kalau ingin sama seperti ini, silakan rubah sqlnya, berdasarkan apanya di fungsional, dalam fungsinal ini berdasarkan jenis ika -->
<div class="card">
  <div class="card-block">
    <div class="row">
        <div class="col-sm-5 m-b-t-30">
          <select class="js-example-basic-single col-sm-12" id="kabkot">
                <option value="">---Pilihan Kabupaten Kota---</option>
                <?php
                  include $_SERVER['DOCUMENT_ROOT'].'/tb_bdl/controller/koneksi.php';
                  $sql = "SELECT id_kabkot, nama from kabkota";
                  $eksekusi = pg_query($sql);
                  while ($data = pg_fetch_assoc($eksekusi)) {
                    echo '<option value="'.$data['id_kabkot'].'">'.$data['nama'].'</option>';
                  }
                ?>
          </select>
        </div>
        <div class="col-sm-5 m-b-t-30">
          <select class="js-example-basic-single col-sm-12" id="kecamatan">
              <option value="">---Pilihan---</option>
          </select>
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
                      <th>ID Pemilik</th>
                      <th>NAMA Pemilik</th>
                      <th>Tanggal Lahir</th>
                      <th>Pendidikan</th>
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
  <?php include $_SERVER['DOCUMENT_ROOT'].'/tb_bdl/view/asraf/fung5/map.php'; ?>

  </div>
</div>
<?php endblock() ?>

<?php startblock('table') ?>
  <script type="text/javascript">
    function format(d) {
          // `d` is the original data object for the row
          return '<table class="table table-striped table-bordered nowrap">' +
            '<tr>' +
            '<td>ID Pemilik  </td>' +
            '<td>IDPM00' + d.id_pemilik + '</td>' +
            '<td>Nama Pemilik  </td>' +
            '<td>' + d.nama + '</td>' +
            '</tr>' +
            '<tr>' +
            '<td>Tanggal Lahir  </td>' +
            '<td>' + d.tgl_lahir + '</td>' +
            '<td>Agama  </td>' +
            '<td>' + d.agama + '</td>' +
            '</tr>' +
            '<tr>' +
            '<td>Pendidikan  </td>' +
            '<td>'+ d.pendidikan +'</td>' +
            '<td>Aksi</td>' +
            '<td><a href="javascript:void(0)" onclick="satupemilik('+d.id_pemilik+')" class="btn btn-primary btn-mini waves-effect waves-light"><i class="fa fa-map-pin"></i></a></td>' +
            '</tr>' +
            '</table>';
    }

    var ct = $('#table-f1').DataTable({
        "ajax": 'http://localhost/tb_bdl/controller/asrafcontroller/fung5controller.php?aksi=tablef1',
        "columns": [{
                "className": 'details-control',
                "orderable": false,
                "data": null,
                "defaultContent": ''
            },
            { "data": "id_pemilik"},
            { "data": "nama" },
            { "data": "tgl_lahir" },
            { "data": "pendidikan" }
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
      var select = document.getElementById("kecamatan").options[document.getElementById("kecamatan").selectedIndex].value;
      if(select==''){
        var link = 'http://localhost/tb_bdl/controller/asrafcontroller/fung5controller.php?aksi=tablef1';
      }else{
        jamakpemilik(select);
        var link = 'http://localhost/tb_bdl/controller/asrafcontroller/fung5controller.php?aksi=tablef1&pencarian='+select;
      }
      console.log(link);
      ct.ajax.url(link).load();
    }

    $(document).on('change','#kabkot',function(){
        	var id=document.getElementById("kabkot").options[document.getElementById("kabkot").selectedIndex].value;
        	$('#kecamatan').html("");
          $('#kecamatan').append('<option value="">---Pilihan Kecamatan---</option>');
        		$.ajax({
        	 		url: 'http://localhost/tb_bdl/controller/asrafcontroller/fung5controller.php?aksi=kecamatan&pencarian='+id, data: "", dataType: 'json', success: function(rows)
        	  			{
        	  				for (var i in rows)
        						{
        							var row = rows[i];
        							var id=row.id;
        							var nama=row.nama;
        							$('#kecamatan').append('<option value="'+id+'">'+nama+'</option>');
        		 				}
        				}
        			});
        });

  </script>
<?php endblock() ?>
