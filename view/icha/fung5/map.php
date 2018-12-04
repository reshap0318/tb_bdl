<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBNnzxae2AewMUN0Tt_fC3gN38goeLVdVE"></script>
<script type="text/javascript">
var pos ='null';
var circles=[];
var info_windows = [];
var server = "http://localhost/tb_bdl/controller/ichacontroller/fung3controller.php?aksi=";
var markers = [];
var layer = [];
var directionsDisplay;
var rute = [];  //NAVIGASI
var angkot = [];
var centerBaru;
var jalurAngkot=[];
var centerLokasi; //untuk fungsi CallRoute()

window.onload = function() {
  basemap();
  // pelayaran();
  // semuakapal();
};


// fungsi basemap untuk menampilkan map polos
function basemap(){
    map = new google.maps.Map(document.getElementById('map'), {
    zoom: 13,
    center: new google.maps.LatLng(-1.000683, 100.370668),
    mapTypeId: google.maps.MapTypeId.ROADMAP,
  });
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


// digunakan untuk mencari data lokasi yang di inginkan, pemilik digunakan di dalam aksi, rubah pada bagian else if($aksi== 'pemilik') bagian pemilikntya dan pencarian
function pemilik(id) {
  $.ajax({ url: server+'pemilik&pencarian='+id, data: "", dataType: 'json', success: function (rows){
    console.log(rows);
    tampilkanmappemilik(rows);
  }});
}

function tampilkanmappemilik(rows) {
  hapusInfo();
  hapusmarker();
  if(rows==null){
    alert('Pemilik Tidak ditemukan');
  }
  for (var i in rows)
  {
    var row = rows[i];
    // console.log(row);
    var id = row.id;
    var nama = row.nama;
    var latitude = row.latitude ;
    var longitude = row.longitude ;
    centerBaru = new google.maps.LatLng(latitude, longitude);
    marker = new google.maps.Marker({
      position: centerBaru,
      icon:'http://localhost/tb_bdl/img/icon/placeholder.png',
      map: map,
      animation: google.maps.Animation.DROP,
    });
    // console.log(id);
    // console.log(latitude);
    // console.log(longitude);
    // nama tu dari nama yang di var nama
    kapal = 'Lokasi Rumah ABK "'+nama+'"'
    markers.push(marker);
    map.setCenter(centerBaru);
    infowindowslokasipelayaran(kapal, centerBaru);
    map.setZoom(14);
  }
}

function infowindowslokasipelayaran(tujuan, center) {
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

}

</script>
