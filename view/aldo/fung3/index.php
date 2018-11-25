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
            <p>Fungsional Ini Berfungsi untuk mengetahui Lokasi Rumah Dari Anak Buah Kapal yang Berdasarkan Tanggal Pelayarannya.<br>
               Sehingga Fungsional Ini Mempermudah atau Membantu orang - orang untuk mencari Anak Buah Kapal yang berlayar pada waktu tertentu, jadi misalkan kita tertarik untuk bekerja sama dengan seseorang yang pernah kita bekerja di waktu yang sama, kita bisa mencari nya disi. atau jika ada Anak buah kapal yang hilang juga bisa mempermudah orang - orang untuk mencarinya<br>
               <font style="color:green">Aplikasi ini terdiri dari 6 table, yaitu table abk, jabatan, kebangsaan, kapal, pelayaran, produksi, jenis_tangkapan</font>
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
                      <th>Kapal</th>
                      <th>Jenis Kapal</th>
                      <th>Mesin</th>
                  </tr>
              </thead>
          </table>
      </div>
  </div>
</div>

<!-- <div class="card">
  <div class="card-block">
  <div class="sembunyi" id="map" style="width:100%; height:400px;">
  <?php include $_SERVER['DOCUMENT_ROOT'].'/tb_bdl/view/aldo/fung2/map.php'; ?>
  </div>
</div>
<div class="card">
    <div class="sembunyi"  id="table_abk">

    </div>
</div> -->
<?php endblock() ?>

<?php startblock('table') ?>
  <!-- <script type="text/javascript">
    function format(d) {
          // `d` is the original data object for the row
          return '<table class="table table-striped table-bordered nowrap">' +
            '<tr>' +
            '<td>Nama Kapal  </td>' +
            '<td>' + d.namakapal + '</td>' +
            '<td>Jumlah Anak Buah Kapal  </td>' +
            '<td>' + d.jabk + ' Orang </td>' +
            '</tr>' +
            '<tr>' +
            '<td>Jenis Kapal  </td>' +
            '<td>' + d.jenis + '</td>' +
            '<td>Jumlah Alat Tangkap  </td>' +
            '<td>' + d.jalat + ' Buah </td>' +
            '</tr>' +
            '<tr>' +
            '<td>Pemilik  </td>' +
            '<td>'+ d.pemilik +' Orang</td>' +
            '<td>Tanda Selar  </td>' +
            '<td>' + d.tanda_selar + '</td>' +
            '</tr>' +
            '<tr>' +
            '<td>Mesin  </td>' +
            '<td>'+ d.mesin +'</td>' +
            '<td>Panjang  </td>' +
            '<td>' + d.panjang + ' M </td>' +
            '</tr>' +
            '<tr>' +
            '<td>Berat Kotor  </td>' +
            '<td>'+ d.berat_kotor +'</td>' +
            '<td>Aksi  </td>' +
            '<td>'+
            '<a href="#map" onclick="daerahpelayaran('+d.id_pelayaran+')" class="btn btn-primary btn-mini waves-effect waves-light" data-toggle="tooltip" data-placement="bottom" title="Tampilkan Lokasi Pelayaran Kapal ini, pada waktu dicari"><i class="fa fa-map-pin" ></i></a>'+
            '<a href="#abk" onclick="cariabk('+d.id_kapal+')" class="btn btn-primary btn-mini waves-effect waves-light" data-toggle="tooltip" data-placement="top" title="Tampilkan Lokasi Rumah Anak Buah Kapal ini"><i class="fa fa-user-secret"></i></a>'+
            '</td>' +
            '</tr>' +
  -          '</table>';
    }

    var ct = $('#table-f2').DataTable({
        "ajax": 'http://localhost/tb_bdl/controller/aldocontroller/fung2controller.php?aksi=table',
        "columns": [{
                "className": 'details-control',
                "orderable": false,
                "data": null,
                "defaultContent": ''
            },
            { "data": "namakapal"},
            { "data": "jenis" },
            { "data": "mesin" },
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
        var link = 'http://localhost/tb_bdl/controller/aldocontroller/fung2controller.php?aksi=table';
      }else{
        var link = 'http://localhost/tb_bdl/controller/aldocontroller/fung2controller.php?aksi=table&pencarian='+select.value;
      }
      console.log(link);
      ct.ajax.url(link).load();
    }

    function tableabk() {
      document.getElementById('table_abk').classList.remove("sembunyi");
      var table = '<div class="card-block"><div class="dt-responsive table-responsive">'+
      '<table class="table table-striped table-bordered nowrap" id="abk">' +
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
      tableabk();
      console.log('http://localhost/tb_bdl/controller/aldocontroller/fung2controller.php?aksi=tableabk&pencarian='+id);
      var tbabk = $('#abk').DataTable({
          "ajax": 'http://localhost/tb_bdl/controller/aldocontroller/fung2controller.php?aksi=tableabk&pencarian='+id,
          "columns": [
              { "data": "id_abk"},
              { "data": "nama"},
              { "data": "kebangsaan" },
              { "data": "jabatan" },
              { defaultContent: '<a href="#map" onclick="lokasiabk()" id="lokasi" class="btn btn-primary btn-mini waves-effect waves-light" data-toggle="tooltip" data-placement="bottom" title="Rumah ABK yang di cari"><i class="fa fa-map-pin" ></i></a>' }
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
 -->


  </script>
<?php endblock() ?>
