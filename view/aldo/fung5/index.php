<?php include $_SERVER['DOCUMENT_ROOT'].'/tb_bdl/blank.php'; ?>

<?php startblock('title') ?> Aldo Fungsional : 5 <?php endblock() ?>

<?php startblock('breadcrumb-link') ?>
<li class="breadcrumb-item"><a href="#!">Aldo</a>
<li class="breadcrumb-item"><a href="#!">Fungsional : 5</a>
<?php endblock() ?>

<?php startblock('breadcrumb-title') ?>
Aldo Fungsional : 5
<?php endblock() ?>

<?php startblock('content') ?>
<!-- menampilkan detail fungsional atau about fungsional -->
<div class="card">
    <div class="card-header">
        <h5 class="card-header-text">Description About Fungsional 5</h5>
    </div>
    <div class="card-block user-desc">
        <div class="view-desc">
            <p>Fungsional : Menampilkan detail KUB yaitu nama kub, kebangsaan kub, kebangsaan kub, jumlah pelayaran kub, kapal kub, jenis_kapal kub, jumlah alat tangkap pada kapal kub berdasarkan alat tangkap yang ada<br>
               Sehingga Fungsional Ini Mempermudah atau Membantu orang - orang untuk bertanya kesumbernya(awak yang menangkap ikan tadi) seperti tentang kondisi lautan, kondisi lokasi ikan banyak, dllnya.<br>
               <font style="color:green">Aplikasi ini terdiri dari 8 table, yaitu table abk, jabatan, kebangsaan, kapal, keterangan_pelayaran_abk, jenis_kapal, alat_tangkap_kapal, alat_tangkap</font>
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
          <table id="table-f5" class="table table-striped table-bordered nowrap" style="width:100%">
              <thead>
                  <tr>
                      <th></th>
                      <th>Nama ABK</th>
                      <th>Jabatan</th>
                      <th>Kapal</th>
                  </tr>
              </thead>
          </table>
      </div>
  </div>
</div>

<div class="card">
  <div class="card-block">

  <div class="" id="map" style="width:100%; height:400px;">
  <?php include $_SERVER['DOCUMENT_ROOT'].'/tb_bdl/view/aldo/fung5/map.php'; ?>

  </div>
</div>
<?php endblock() ?>

<?php startblock('table') ?>
  <script type="text/javascript">
    function format(d) {
          // `d` is the original data object for the row
          return '<table class="table table-striped table-bordered nowrap">' +
            '<tr>' +
              '<td>Kode ABK </td>' +
              '<td>ABKRSP0' + d.id_abk + ' Buah</td>' +
              '<td>Kapal</td>' +
              '<td>' + d.kapal + '</td>' +
            '</tr>' +
            '<tr>' +
              '<td>Nama ABK</td>' +
              '<td>' + d.abk + '</td>' +
              '<td>Jenis Kapal</td>' +
              '<td>'+ d.jenis_kapal +'</td>' +
            '</tr>'+
            '<tr>' +
              '<td>Kebangsaan</td>' +
              '<td>' + d.kebangsaan + '</td>' +
              '<td>Jumlah Pelayaran</td>' +
              '<td>'+ d.jpelayaran +' Buah</td>' +
            '</tr>'+
            '<tr>'+
            '<tr>' +
              '<td>Jabatan</td>' +
              '<td>' + d.jabatan + '</td>' +
              '<td>Jumlah Alat Tangkap</td>' +
              '<td>'+ d.jalat +' Buah</td>' +
            '</tr>'+
            '<td>Aksi</td>' +
            '<td><a href="javascript:void(0)" onclick="satuabk('+d.id_abk+')" class="btn btn-primary btn-mini waves-effect waves-light"><i class="fa fa-map-pin"></i></a></td>' +
            '<td>  </td>' +
            '<td> </td>' +
            '</tr>' +
            '</table>';
    }

    var ct = $('#table-f5').DataTable({
        "ajax": 'http://localhost/tb_bdl/controller/aldocontroller/fung5controller.php?aksi=tablef5',
        "columns": [{
                "className": 'details-control',
                "orderable": false,
                "data": null,
                "defaultContent": ''
            },
            { "data": "abk"},
            { "data": "jabatan" },
            { "data": "kapal" },

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
    $('#table-f5 tbody').on('click', 'td.details-control', function() {
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
            var link = 'http://localhost/tb_bdl/controller/aldocontroller/fung5controller.php?aksi=tablef5';
          }else{
              for (var i=0; i < select.selectedOptions.length; i++) {
                  cari.push(select.selectedOptions[i].value);
              }
            var id = cari.join(",");
            var link = 'http://localhost/tb_bdl/controller/aldocontroller/fung5controller.php?aksi=tablef5&pencarian='+id;
          }
          console.log(link);
          ct.ajax.url(link).load();
        }


  </script>
<?php endblock() ?>
