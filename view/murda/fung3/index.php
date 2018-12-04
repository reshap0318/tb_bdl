<?php include $_SERVER['DOCUMENT_ROOT'].'/tb_bdl/blank.php'; ?>

<?php startblock('title') ?> Murda Fungsional : 3 <?php endblock() ?>

<?php startblock('breadcrumb-link') ?>
<li class="breadcrumb-item"><a href="#!">Murda</a>
<li class="breadcrumb-item"><a href="#!">Fungsional : 3</a>
<?php endblock() ?>

<?php startblock('breadcrumb-title') ?>
Murda Fungsional : 3
<?php endblock() ?>

<?php startblock('content') ?>
<!-- menampilkan detail fungsional atau about fungsional -->
<div class="card">
    <div class="card-header">
        <h5 class="card-header-text">Description About Fungsional 3</h5>
    </div>
    <div class="card-block user-desc">
        <div class="view-desc">
            <p>fungsional : menampilkan kub yang mencangkub, id_kub, nama, jumlah usaha perikanan, jumlah_transaksi, dan pelabuhanS berdasarkan pelabuhan <br>
               Sehingga Fungsional Ini Mempermudah atau Membantu orang - orang untuk bertanya kesumbernya(awak yang menangkap ikan tadi) seperti tentang kondisi lautan, kondisi lokasi ikan banyak, dllnya.<br>
               <font style="color:green">Aplikasi ini terdiri dari 7 table, yaitu kub, usaha_perikanan, transaksi, detail_transaksi, produksi, pelayaran, pelabuhan</font>
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
          <select name="pencarian" class="form-control js-example-basic-single" id="pencarian">
                <option value="">---Pilihan Pelabuhan---</option>
                <?php
                  include $_SERVER['DOCUMENT_ROOT'].'/tb_bdl/controller/koneksi.php';
                  $sql = "SELECT id_pelabuhan, nama from pelabuhan";
                  $eksekusi = pg_query($sql);
                  while ($data = pg_fetch_assoc($eksekusi)) {
                    echo '<option value="'.$data['id_pelabuhan'].'">'.$data['nama'].'</option>';
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
          <table id="table-f3" class="table table-striped table-bordered nowrap" style="width:100%">
              <thead>
                  <tr>
                      <th></th>
                      <th>KUB</th>
                      <th>Alamat</th>
                  </tr>
              </thead>
          </table>
      </div>
  </div>
</div>

<div class="card">
  <div class="card-block">
    <div class="" id="map" style="width:100%; height:400px;">
      <?php include $_SERVER['DOCUMENT_ROOT'].'/tb_bdl/view/murda/fung3/map.php'; ?>
  </div>
</div>
<?php endblock() ?>

<?php startblock('table') ?>
  <script type="text/javascript">
    function format(d) {
          // `d` is the original data object for the row
          return '<table class="table table-striped table-bordered nowrap">' +
            '<tr>' +
            '<td>KODE KUB  </td>' +
            '<td>KUBRSP0' + d.id_kub + '</td>' +
            '<td>Alamat</td>' +
            '<td>' + d.alamat + '</td>' +
            '</tr>' +
            '<tr>' +
            '<td>KUB</td>' +
            '<td>' + d.kub + '</td>' +
            '<td>Jumlah Transaksi  </td>' +
            '<td>' + d.jtransaksi + ' Buah</td>' +
            '</tr>' +
            '<tr>' +
            '<td>Tanggal Berdiri</td>' +
            '<td>' + d.tgl_berdiri + '</td>' +
            '<td>Jumlah Usaha</td>' +
            '<td>' + d.jusaha + ' Buah</td>' +
            '</tr>' +
            '<tr>' +
            '<td>deskripsi</td>' +
            '<td>' + d.deskripsi + '</td>' +
            '<td>AKSI</td>' +
            '<td><a href="javascript:void(0)" onclick="satukub('+d.id_kub+')" class="btn btn-primary btn-mini waves-effect waves-light"><i class="fa fa-map-pin"></i></a></td>' +
            '</tr>' +
            '</table>';
    }

    var ct = $('#table-f3').DataTable({
        "ajax": 'http://localhost/tb_bdl/controller/murdacontroller/fung3controller.php?aksi=tablef3',
        "columns": [{
                "className": 'details-control',
                "orderable": false,
                "data": null,
                "defaultContent": ''
            },
            { "data": "kub"},
            { "data": "alamat" }
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
      var select = document.getElementById("pencarian");
      console.log(select.value);
      if(select.value==''){
        var link = 'http://localhost/tb_bdl/controller/murdacontroller/fung3controller.php?aksi=tablef3';
      }else{
        var link = 'http://localhost/tb_bdl/controller/murdacontroller/fung3controller.php?aksi=tablef3&pencarian='+select.value;
      }
      semuakub();
      console.log(link);
      ct.ajax.url(link).load();
    }


  </script>
<?php endblock() ?>
