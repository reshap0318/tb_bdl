<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBNnzxae2AewMUN0Tt_fC3gN38goeLVdVE"></script>
<script type="text/javascript">
var pos ='null';
var info_windows = [];
var server = "http://localhost/tb_bdl/controller/aldocontroller/fung3controller.php?aksi=";
var markers = [];
var layer = [];
var directionsDisplay;
var centerBaru;
var jalurAngkot=[];
var centerLokasi; //untuk fungsi CallRoute()

window.onload = function() {
  basemap();
};

function lokasi(id) {
  //untuk menampilkan map pakai kodingan di bawah ini
    document.getElementById('map').classList.remove("sembunyi");
 //untuk menampilkan lokasi KUB
 layerkub(id);
 detaillokasikub(id);
 //untuk menghiilangkan table usaha dan transaksi
 document.getElementById("table_usaha").classList.add('sembunyi');
 document.getElementById("table_transaksi").classList.add('sembunyi');
}


function layerkub(id)
{
    kub = new google.maps.Data();
    kub.loadGeoJson(server+'layer&pencarian='+id);
    kub.setStyle(function(feature){
        return({
            fillColor: '#F0FFFF',
            strokeColor: '#000000',
            strokeWeight: 1,
            fillOpacity: 7
        });
    });
    layer.push(kub);
    hapuslayer();
    kub.setMap(map);
}

function basemap(){
    map = new google.maps.Map(document.getElementById('map'), {
    zoom: 13,
    center: new google.maps.LatLng(-1.000683, 100.370668),
    mapTypeId: google.maps.MapTypeId.ROADMAP,
  });
}

function hapuslayer() {
  for (var i = 0; i < layer.length; i++) {
    layer[i].setMap(null);
  }
}

function hapusInfo() {
  for (var i = 0; i < info_windows.length; i++) {
    info_windows[i].setMap(null);
  }
}

function hapusmarker() {
  for (var i = 0; i < markers.length; i++) {
    markers[i].setMap(null);
  }
}

function detaillokasikub(id) {
  $.ajax({ url: server+'detaillokasikub&pencarian='+id, data: "", dataType: 'json', success: function (rows){
    console.log(rows);
    tampilkanmapkub(rows);
  }});
}

function tampilkanmapkub(rows) {
  hapusInfo();
  hapusmarker();
  if(rows==null){
    alert('Pelayaran Tidak ditemukan');
  }
  for (var i in rows)
  {
    var row = rows[i];
    var nama = row.nama;
    var alamat = row.alamat;
    var latitude = row.latitude ;
    var longitude = row.longitude ;
    centerBaru = new google.maps.LatLng(latitude, longitude);
    marker = new google.maps.Marker({
      position: centerBaru,
      icon:'http://localhost/tb_bdl/img/icon/placeholder.png',
      map: map,
      animation: google.maps.Animation.DROP,
    });
    var katanya = '<div style="height:auto; width: 200px" class="text-center">Usaha ' +nama+ '<br>'+alamat+'</div>';
    // console.log(id);
    // console.log(latitude);
    // console.log(longitude);
    markers.push(marker);
    map.setCenter(centerBaru);
    infowindowslokasikub(katanya, centerBaru);
    map.setZoom(18);
  }
}

function infowindowslokasikub(tujuan, center) {
  google.maps.event.addListener(marker, "click", function(){
    infowindow = new google.maps.InfoWindow({
      position: center,
      content: tujuan,
      pixelOffset: new google.maps.Size(0, -33)
    });
    info_windows.push(infowindow);
    hapusInfo();
    infowindow.open(map);
  });
}

function lokasiusaha() {
  $('#usaha tbody').on( 'click', '#lokasi', function () {
        var datanya = $(this).closest("tr")[0];
        console.log( datanya.children[0].innerHTML );
        id = datanya.children[0].innerHTML;

      $.ajax({ url: server+'cariusaha&pencarian='+id, data: "", dataType: 'json', success: function (rows){
        console.log(rows);
        hapusInfo();
        hapusmarker();
        if(rows==null){
          alert('Pelayaran Tidak ditemukan');
        }
        for (var i in rows)
        {
          var row = rows[i];
          var nama = 'Lokasi Usaha '+row.nama;
          var latitude = row.latitude ;
          var longitude = row.longitude ;
          centerBaru = new google.maps.LatLng(latitude, longitude);
          marker = new google.maps.Marker({
            position: centerBaru,
            icon:'http://localhost/tb_bdl/img/icon/placeholder.png',
            map: map,
            animation: google.maps.Animation.DROP,
          });
          markers.push(marker);
          map.setCenter(centerBaru);
          infowindowslokasikub(nama, centerBaru);
          map.setZoom(18);
          document.getElementById('map').classList.remove("sembunyi");
        }
      }});

  } );
}

</script>
