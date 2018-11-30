<?php include $_SERVER['DOCUMENT_ROOT'].'/tb_bdl/blank.php'; ?>

<?php startblock('title') ?> Aldo Fungsional : 3 <?php endblock() ?>

<?php startblock('breadcrumb-link') ?>
<li class="breadcrumb-item"><a href="#!">Aldo</a>
<li class="breadcrumb-item"><a href="#!">Fungsional : 3</a>
<?php endblock() ?>

<?php startblock('breadcrumb-title') ?>
Aldo Fungsional : 3
<?php endblock() ?>

<?php startblock('content') ?>
<!-- menampilkan detail fungsional atau about fungsional -->
<div class="card">
    <div class="card-header">
        <h5 class="card-header-text">Description About Fungsional 3</h5>
    </div>
    <div class="card-block user-desc">
        <div class="view-desc">
            <p>Fungsional ini berfungsi menampilkan data KUB yang berisikan : nama, alamat, deskripsi KUB, tanggal berdiri kub, jumlahusaha yang berada dalam kub, jumlah transaksi, jumlah produksi, serta detail usaha, baik itu nama, lokasi, jenis, dllnya, dan juga detail transaksi, berupa, tanggal, dan jenis ikan yang di beli dan dari kapal mana pembeliannya.<br>
               Sehingga Fungsional Ini Mempermudah atau Membantu orang - orang untuk mencari Anak Buah Kapal yang berlayar pada waktu tertentu, jadi misalkan kita tertarik untuk bekerja sama dengan seseorang yang pernah kita bekerja di waktu yang sama, kita bisa mencari nya disi. atau jika ada Anak buah kapal yang hilang juga bisa mempermudah orang - orang untuk mencarinya<br>
               <font style="color:green">Aplikasi ini terdiri dari 10 table, yaitu table kub, usaha_perikanan, jenis_usaha, transaksi, detail_transaksi, produksi, jenis_tangkapan, kebangsaan, kapal, pelayaran, produksi, jenis_tangkapan, kabupaten_kota, kecamatan</font>
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
          <table id="table-f3" class="table table-striped table-bordered nowrap" style="width:100%">
              <thead>
                  <tr>
                      <th></th>
                      <th>Nama</th>
                      <th>Alamat</th>
                  </tr>
              </thead>
          </table>
      </div>
  </div>
</div>

<div class="card">
  <div class="card-block">
  <div class="sembunyi" id="map" style="width:100%; height:400px;">
  <?php include $_SERVER['DOCUMENT_ROOT'].'/tb_bdl/view/aldo/fung3/map.php'; ?>
  </div>
</div>
<div class="card">
    <div class="sembunyi"  id="table_usaha"></div>
    <div class="sembunyi"  id="table_transaksi"></div>
</div>
<?php endblock() ?>

<?php startblock('table') ?>
  <script type="text/javascript">
    function format(d) {
          // `d` is the original data object for the row
          return '<table class="table table-striped table-bordered nowrap">' +
              '<tr>' +
              '<td>ID KUB  </td>' +
              '<td>KUBRSP00' + d.id_kub + '</td>' +
              '<td>Alamat</td>' +
              '<td>' + d.alamat + '</td>' +
              '</tr>' +
              '<tr>' +
              '<td>Nama KUB </td>' +
              '<td>' + d.nama + '</td>' +
              '<td>Deskripsi</td>' +
              '<td>' + d.deskripsi + '</td>' +
              '</tr>' +
              '<tr>' +
              '<td>Tanggal Berdiri</td>' +
              '<td>'+ d.tgl_berdiri +' </td>' +
              '<td>Jumlah Usaha yang terikat</td>' +
              '<td>' + d.jumlahusaha + ' Buah</td>' +
              '</tr>' +
              '<tr>' +
              '<td>Jumlah Transaksi</td>' +
              '<td>'+ d.jumlahtransaksi +' Buah</td>' +
              '<td>Jumlah Produksi</td>' +
              '<td>' + d.jumlahproduksi + ' Buah</td>' +
              '</tr>' +
              '<tr>' +
              '<td>Aksi</td>' +
              '<td>'+
              '<a href="#map" onclick="lokasi('+d.id_kub+')" class="btn btn-primary btn-mini waves-effect waves-light" data-toggle="tooltip" data-placement="bottom" title="Lokasi KUB"><i class="fa fa-map-pin" ></i></a>'+
              '<a href="#usaha" onclick="cariusaha('+d.id_kub+')" class="btn btn-primary btn-mini waves-effect waves-light" data-toggle="tooltip" data-placement="top" title="Detail Usaha"><i class="fa fa-group"></i></a>'+
              '<a href="#transaksi" onclick="caritransaksi('+d.id_kub+')" class="btn btn-primary btn-mini waves-effect waves-light" data-toggle="tooltip" data-placement="top" title="Detail Transaksi"><i class="fa fa-money"></i></a>'+
              '</td>' +
              '<td>'+
              '</td>' +
              '<td></td>' +
              '</tr>' +
            '</table>';
    }

    var ct = $('#table-f3').DataTable({
        "ajax": 'http://localhost/tb_bdl/controller/aldocontroller/fung3controller.php?aksi=tablef3',
        "columns": [{
                "className": 'details-control',
                "orderable": false,
                "data": null,
                "defaultContent": ''
            },
            { "data": "nama"},
            { "data": "alamat"}
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
    $('#table-f3 tbody').on('click', 'td.details-control', function() {
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
        var link = 'http://localhost/tb_bdl/controller/aldocontroller/fung3controller.php?aksi=tablef3';
      }else{
        var link = 'http://localhost/tb_bdl/controller/aldocontroller/fung3controller.php?aksi=tablef3&pencarian='+select;
      }
      console.log(link);
      ct.ajax.url(link).load();
    }

    function tableusaha() {
      document.getElementById("table_transaksi").classList.add('sembunyi');
      document.getElementById('table_usaha').classList.remove("sembunyi");
      var table = '<div class="card-block"><div class="dt-responsive table-responsive">'+
      '<table class="table table-striped table-bordered nowrap" style="width:100%" id="usaha">' +
        '<thead>'+
          '<tr>' +
            '<th>id</th>' +
            '<th>Nama Usaha</th>' +
            '<th>Jenis Usaha</th>' +
            '<th>Aksi</th>' +
          '</tr>' +
        '</thead>'+
      '</table>'+
        '</div></div>';
      document.getElementById("table_usaha").innerHTML = table;
    }

    function cariusaha(id) {
      tableusaha();
      console.log('http://localhost/tb_bdl/controller/aldocontroller/fung3controller.php?aksi=tableusaha&pencarian='+id);
      var tbusaha = $('#usaha').DataTable({
          "ajax": 'http://localhost/tb_bdl/controller/aldocontroller/fung3controller.php?aksi=tableusaha&pencarian='+id,
          "columns": [
              { "data": "id_usaha"},
              { "data": "nama_usaha"},
              { "data": "jenis"},
              { defaultContent: '<a href="#map" onclick="lokasiusaha()" id="lokasi" class="btn btn-primary btn-mini waves-effect waves-light" data-toggle="tooltip" data-placement="bottom" title="Lokasi Usaha Perikanan"><i class="fa fa-map-pin" ></i></a>' }
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

    function tabletransaksi() {
      document.getElementById("table_usaha").classList.add('sembunyi');
      document.getElementById("map").classList.add('sembunyi');
      document.getElementById('table_transaksi').classList.remove("sembunyi");
      var table = '<div class="card-block"><div class="dt-responsive table-responsive">'+
      '<table class="table table-striped table-bordered nowrap" style="width:100%" id="transaksi">' +
        '<thead>'+
          '<tr>' +
            '<th>Ikan</th>' +
            '<th>Berat</th>' +
            '<th>Harga</th>' +
            '<th>Tanggal</th>' +
          '</tr>' +
        '</thead>'+
      '</table>'+
        '</div></div>';
      document.getElementById("table_transaksi").innerHTML = table;
    }

    function caritransaksi(id) {
      tabletransaksi();
      console.log('http://localhost/tb_bdl/controller/aldocontroller/fung3controller.php?aksi=tabletransaksi&pencarian='+id);
      var tbtransaksi = $('#transaksi').DataTable({
          "ajax": 'http://localhost/tb_bdl/controller/aldocontroller/fung3controller.php?aksi=tabletransaksi&pencarian='+id,
          "columns": [
              { "data": "ikan"},
              { "data": "berat"},
              { "data": "harga"},
              { "data": "Tanggal"},
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

    $(document).on('change','#kabkot',function(){
    	var id=document.getElementById("kabkot").options[document.getElementById("kabkot").selectedIndex].value;
    	$('#kecamatan').html("");
      $('#kecamatan').append('<option value="">---Pilihan Kecamatan---</option>');
    		$.ajax({
    	 		url: 'http://localhost/tb_bdl/controller/aldocontroller/fung3controller.php?aksi=kecamatan&pencarian='+id, data: "", dataType: 'json', success: function(rows)
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
