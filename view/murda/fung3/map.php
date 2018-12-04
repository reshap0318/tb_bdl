<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBNnzxae2AewMUN0Tt_fC3gN38goeLVdVE"></script>
<script type="text/javascript">
var pos ='null';
var circles=[];
var info_windows = [];
var server = "http://localhost/tb_bdl/controller/murdacontroller/fung3controller.php?aksi=";
var markers = [];
var directionsDisplay;
var rute = [];  //NAVIGASI
var angkot = [];
var centerBaru;
var jalurAngkot=[];
var centerLokasi; //untuk fungsi CallRoute()

window.onload = function() {
  basemap();
  kub();
  semuakub();
};

function kub() //tampil digitasi kub
{
    kub = new google.maps.Data();
    kub.loadGeoJson(server+'layer');
    kub.setStyle(function(feature){
        return({
            fillColor: '#42cb6f',
            strokeColor: '#42cb6f',
            strokeWeight: 1,
            fillOpacity: 7
        });
    });
    kub.setMap(map);
}
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

function semuakub(){ //menampilkan semua kub
  $.ajax({ url: server+'kub', data: "", dataType: 'json', success: function (rows){
    tampilsemuakub(rows, 10);
  }});
}

function tampilsemuakub(rows, zoom){ //fungsi cari mesjid berdasarkan nama
  if(rows==null){
    alert('kub not found');
  }
  for (var i in rows)
  {
    var row = rows[i];
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
    markers.push(marker);
    map.setCenter(centerBaru);
    detail_info(nama, centerBaru);
    map.setZoom(zoom);
  }
}

function detail_info(nama, center){  //menampilkan informasi masjid
  google.maps.event.addListener(marker, "click", function(){
    infowindow = new google.maps.InfoWindow({
      position: center,
      content: "Lokasi Perkumpulan KUB "+nama,
      pixelOffset: new google.maps.Size(0, -33)
    });
    info_windows.push(infowindow);
    hapusInfo();
    infowindow.open(map);
  });
}

function satukub(id) {
  $.ajax({ url: server+'kub&pencarian='+id, data: "", dataType: 'json', success: function (rows){
    hapusInfo();
    hapusmarker();
    tampilsemuakub(rows, 18);
  }});
}



</script>
